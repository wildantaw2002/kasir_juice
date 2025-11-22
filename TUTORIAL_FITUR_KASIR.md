# 🍹 Tutorial Membuat Fitur Kasir (POS) di Dashboard

Tutorial lengkap untuk menambahkan fitur Point of Sale (POS) untuk kasir di halaman dashboard.

---

## 📋 Table of Contents
1. [Persiapan](#persiapan)
2. [Membuat Controller Transaksi](#membuat-controller-transaksi)
3. [Membuat View Dashboard Kasir](#membuat-view-dashboard-kasir)
4. [Menambahkan Route](#menambahkan-route)
5. [Update Navigation](#update-navigation)
6. [Testing](#testing)

---

## 1. Persiapan

### Database Schema yang Diperlukan
Pastikan tabel berikut sudah ada:
- ✅ `t_menu` (menu minuman)
- ✅ `t_transaksi` (header transaksi)
- ✅ `t_detail_transaksi` (detail item transaksi)

---

## 2. Membuat Controller Transaksi

### Step 1: Buat Controller
```bash
php artisan make:controller TransaksiController
```

### Step 2: Edit Controller `app/Http/Controllers/TransaksiController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\t_menu;
use App\Models\m_transaksi;
use App\Models\t_detail_transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    /**
     * Tampilkan halaman kasir (POS)
     */
    public function index(Request $request)
    {
        $query = t_menu::query();

        // Search menu
        if ($request->has('search')) {
            $query->where('nama_menu', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        $menus = $query->get();
        $kategoris = t_menu::distinct()->pluck('kategori');

        return view('kasir.index', compact('menus', 'kategoris'));
    }

    /**
     * Simpan transaksi
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id_menu' => 'required|exists:t_menu,id',
            'items.*.ukuran' => 'required|in:Small,Medium,Large',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.subtotal' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'metode_bayar' => 'required|in:Cash,Debit,QRIS',
        ]);

        DB::beginTransaction();
        try {
            // Generate kode transaksi
            $kode = 'TRX-' . date('YmdHis') . '-' . Str::random(4);

            // Simpan transaksi
            $transaksi = m_transaksi::create([
                'kode_transaksi' => $kode,
                'id_user' => auth()->id(),
                'total' => $validated['total'],
                'metode_bayar' => $validated['metode_bayar'],
                'time' => now(),
            ]);

            // Simpan detail transaksi
            foreach ($validated['items'] as $item) {
                t_detail_transaksi::create([
                    'id_transaksi' => $transaksi->id,
                    'id_menu' => $item['id_menu'],
                    'ukuran' => $item['ukuran'],
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan!',
                'kode_transaksi' => $kode,
                'total' => $validated['total'],
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan transaksi: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Tampilkan riwayat transaksi
     */
    public function history()
    {
        $transaksis = m_transaksi::with(['user', 'details.menu'])
            ->where('id_user', auth()->id())
            ->latest()
            ->paginate(10);

        return view('kasir.history', compact('transaksis'));
    }

    /**
     * Detail transaksi
     */
    public function show($id)
    {
        $transaksi = m_transaksi::with(['user', 'details.menu'])
            ->findOrFail($id);

        // Pastikan hanya bisa lihat transaksi sendiri (kecuali admin)
        if (auth()->user()->role != 'admin' && $transaksi->id_user != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('kasir.detail', compact('transaksi'));
    }
}
```

---

## 3. Membuat View Dashboard Kasir

### Step 1: Buat Folder Views
```bash
mkdir -p resources/views/kasir
```

### Step 2: Buat File `resources/views/kasir/index.blade.php`

```blade
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-gradient-to-r from-pink-500 via-rose-500 to-pink-600 p-6 rounded-xl shadow-2xl">
            <div>
                <h2 class="font-bold text-3xl text-white leading-tight drop-shadow-lg">
                    🛒 {{ __('Kasir - Point of Sale') }}
                </h2>
                <p class="text-pink-100 text-sm mt-1">Pilih menu dan buat transaksi</p>
            </div>
            <a href="{{ route('kasir.history') }}" class="inline-flex items-center px-6 py-3 bg-white border-2 border-pink-200 rounded-xl font-bold text-sm text-pink-600 uppercase tracking-widest hover:bg-pink-50 hover:scale-110 transition-all duration-300 transform shadow-lg">
                📋 Riwayat Transaksi
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-pink-50 via-white to-rose-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Menu List (Kiri) -->
                <div class="lg:col-span-2">
                    <!-- Search & Filter -->
                    <div class="bg-white p-4 rounded-xl shadow-lg mb-4 border-2 border-pink-200">
                        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari menu..." class="w-full pl-10 pr-4 py-2 border-2 border-pink-300 rounded-lg focus:ring-4 focus:ring-pink-300">
                                <svg class="absolute left-3 top-3 w-5 h-5 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <select name="kategori" class="w-full px-4 py-2 border-2 border-pink-300 rounded-lg focus:ring-4 focus:ring-pink-300" onchange="this.form.submit()">
                                <option value="">🍹 Semua Kategori</option>
                                @foreach($kategoris as $kat)
                                <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                    <!-- Menu Cards -->
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @forelse($menus as $menu)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-pink-200 hover:shadow-2xl transition duration-300 transform hover:scale-105 cursor-pointer" onclick="addToCart({{ json_encode($menu) }})">
                            @if($menu->foto)
                            <img src="{{ asset('storage/' . $menu->foto) }}" alt="{{ $menu->nama_menu }}" class="w-full h-32 object-cover">
                            @else
                            <div class="w-full h-32 bg-gradient-to-br from-pink-400 to-rose-500 flex items-center justify-center">
                                <span class="text-white text-4xl font-bold">{{ substr($menu->nama_menu, 0, 1) }}</span>
                            </div>
                            @endif
                            <div class="p-3">
                                <h3 class="font-bold text-gray-800 text-sm mb-1">{{ $menu->nama_menu }}</h3>
                                <p class="text-pink-600 font-bold text-lg">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                <span class="inline-block px-2 py-1 text-xs bg-pink-100 text-pink-700 rounded-full mt-1">{{ $menu->kategori }}</span>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-3 text-center py-8 text-gray-500">
                            Tidak ada menu tersedia
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Cart (Kanan) -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-2xl border-4 border-pink-300 sticky top-4">
                        <div class="bg-gradient-to-r from-pink-500 to-rose-500 p-4 rounded-t-lg">
                            <h3 class="text-white font-bold text-xl">🛒 Keranjang</h3>
                        </div>
                        
                        <div class="p-4">
                            <!-- Cart Items -->
                            <div id="cart-items" class="space-y-3 mb-4 max-h-96 overflow-y-auto">
                                <p class="text-gray-400 text-center py-8">Keranjang kosong</p>
                            </div>

                            <!-- Total -->
                            <div class="border-t-2 border-pink-200 pt-4 space-y-2">
                                <div class="flex justify-between text-lg font-bold text-gray-800">
                                    <span>Total:</span>
                                    <span id="total-price" class="text-pink-600">Rp 0</span>
                                </div>

                                <!-- Metode Bayar -->
                                <select id="metode-bayar" class="w-full px-4 py-2 border-2 border-pink-300 rounded-lg focus:ring-4 focus:ring-pink-300">
                                    <option value="Cash">💵 Cash</option>
                                    <option value="Debit">💳 Debit</option>
                                    <option value="QRIS">📱 QRIS</option>
                                </select>

                                <!-- Buttons -->
                                <button onclick="clearCart()" class="w-full py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition font-bold">
                                    🗑️ Hapus Semua
                                </button>
                                <button onclick="checkout()" class="w-full py-3 bg-gradient-to-r from-pink-500 to-rose-500 text-white rounded-lg hover:from-pink-600 hover:to-rose-600 transition font-bold text-lg shadow-lg animate-pulse">
                                    ✨ CHECKOUT ✨
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Success -->
    <div id="success-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 shadow-2xl transform scale-95 transition-all">
            <div class="text-center">
                <div class="bg-green-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Transaksi Berhasil! 🎉</h3>
                <p class="text-gray-600 mb-1">Kode Transaksi:</p>
                <p id="modal-kode" class="text-pink-600 font-bold text-xl mb-1"></p>
                <p class="text-gray-600 mb-1">Total:</p>
                <p id="modal-total" class="text-pink-600 font-bold text-2xl mb-6"></p>
                <button onclick="closeModal()" class="w-full py-3 bg-gradient-to-r from-pink-500 to-rose-500 text-white rounded-lg hover:from-pink-600 hover:to-rose-600 font-bold">
                    OK
                </button>
            </div>
        </div>
    </div>

    <script>
        let cart = [];

        function addToCart(menu) {
            // Cek apakah menu sudah ada di cart
            const existingIndex = cart.findIndex(item => item.id === menu.id && item.ukuran === 'Medium');
            
            if (existingIndex > -1) {
                cart[existingIndex].jumlah++;
                cart[existingIndex].subtotal = cart[existingIndex].jumlah * menu.harga;
            } else {
                cart.push({
                    id: menu.id,
                    id_menu: menu.id,
                    nama: menu.nama_menu,
                    harga: menu.harga,
                    ukuran: 'Medium',
                    jumlah: 1,
                    subtotal: menu.harga
                });
            }
            
            renderCart();
        }

        function removeFromCart(index) {
            cart.splice(index, 1);
            renderCart();
        }

        function updateQuantity(index, change) {
            cart[index].jumlah += change;
            if (cart[index].jumlah <= 0) {
                removeFromCart(index);
            } else {
                cart[index].subtotal = cart[index].jumlah * cart[index].harga;
                renderCart();
            }
        }

        function updateSize(index, size) {
            const sizeMultiplier = {
                'Small': 0.8,
                'Medium': 1,
                'Large': 1.2
            };
            
            cart[index].ukuran = size;
            cart[index].subtotal = cart[index].jumlah * cart[index].harga * sizeMultiplier[size];
            renderCart();
        }

        function renderCart() {
            const cartItems = document.getElementById('cart-items');
            
            if (cart.length === 0) {
                cartItems.innerHTML = '<p class="text-gray-400 text-center py-8">Keranjang kosong</p>';
                document.getElementById('total-price').textContent = 'Rp 0';
                return;
            }

            let html = '';
            let total = 0;

            cart.forEach((item, index) => {
                total += item.subtotal;
                html += `
                    <div class="bg-pink-50 p-3 rounded-lg border border-pink-200">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-bold text-sm text-gray-800">${item.nama}</h4>
                            <button onclick="removeFromCart(${index})" class="text-red-500 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <select onchange="updateSize(${index}, this.value)" class="w-full px-2 py-1 text-xs border border-pink-300 rounded mb-2">
                            <option value="Small" ${item.ukuran === 'Small' ? 'selected' : ''}>Small (-20%)</option>
                            <option value="Medium" ${item.ukuran === 'Medium' ? 'selected' : ''}>Medium</option>
                            <option value="Large" ${item.ukuran === 'Large' ? 'selected' : ''}>Large (+20%)</option>
                        </select>
                        
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <button onclick="updateQuantity(${index}, -1)" class="bg-pink-500 text-white w-6 h-6 rounded hover:bg-pink-600">-</button>
                                <span class="font-bold">${item.jumlah}</span>
                                <button onclick="updateQuantity(${index}, 1)" class="bg-pink-500 text-white w-6 h-6 rounded hover:bg-pink-600">+</button>
                            </div>
                            <span class="text-pink-600 font-bold">Rp ${item.subtotal.toLocaleString('id-ID')}</span>
                        </div>
                    </div>
                `;
            });

            cartItems.innerHTML = html;
            document.getElementById('total-price').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        function clearCart() {
            if (confirm('Hapus semua item dari keranjang?')) {
                cart = [];
                renderCart();
            }
        }

        async function checkout() {
            if (cart.length === 0) {
                alert('Keranjang kosong!');
                return;
            }

            const metodeBayar = document.getElementById('metode-bayar').value;
            const total = cart.reduce((sum, item) => sum + item.subtotal, 0);

            try {
                const response = await fetch('{{ route("kasir.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        items: cart,
                        total: total,
                        metode_bayar: metodeBayar
                    })
                });

                const data = await response.json();

                if (data.success) {
                    document.getElementById('modal-kode').textContent = data.kode_transaksi;
                    document.getElementById('modal-total').textContent = 'Rp ' + data.total.toLocaleString('id-ID');
                    document.getElementById('success-modal').classList.remove('hidden');
                    
                    cart = [];
                    renderCart();
                } else {
                    alert('Error: ' + data.message);
                }
            } catch (error) {
                alert('Terjadi kesalahan: ' + error.message);
            }
        }

        function closeModal() {
            document.getElementById('success-modal').classList.add('hidden');
        }
    </script>
</x-app-layout>
```

---

## 4. Menambahkan Route

Edit file `routes/web.php`:

```php
use App\Http\Controllers\TransaksiController;

// Route untuk kasir (POS)
Route::middleware(['auth', 'role:admin,kasir'])->group(function () {
    Route::get('/kasir', [TransaksiController::class, 'index'])->name('kasir.index');
    Route::post('/kasir/transaksi', [TransaksiController::class, 'store'])->name('kasir.store');
    Route::get('/kasir/history', [TransaksiController::class, 'history'])->name('kasir.history');
    Route::get('/kasir/transaksi/{id}', [TransaksiController::class, 'show'])->name('kasir.show');
});
```

---

## 5. Update Navigation

Edit `resources/views/layouts/navigation.blade.php`:

Tambahkan link kasir di navigation:

```php
@if(auth()->check() && in_array(auth()->user()->role, ['admin', 'kasir']))
<x-nav-link :href="route('kasir.index')" :active="request()->routeIs('kasir.*')">
    🛒 {{ __('Kasir') }}
</x-nav-link>
@endif
```

---

## 6. Update Dashboard untuk Redirect

Edit `routes/web.php`, ubah route dashboard:

```php
Route::get('/dashboard', function () {
    // Jika kasir, redirect ke halaman kasir
    if (auth()->check() && auth()->user()->role === 'kasir') {
        return redirect()->route('kasir.index');
    }
    
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
```

---

## 7. Testing

### Test 1: Login sebagai Kasir
```
Email: kasir@kasir.com
Password: password
```

### Test 2: Akses Halaman Kasir
- Klik menu "🛒 Kasir" di navigation
- Atau akses: `http://localhost:8000/kasir`

### Test 3: Buat Transaksi
1. Pilih menu dengan klik card menu
2. Pilih ukuran (Small/Medium/Large)
3. Atur jumlah dengan tombol +/-
4. Pilih metode bayar
5. Klik "CHECKOUT"
6. Lihat modal sukses dengan kode transaksi

### Test 4: Lihat Riwayat
- Klik "📋 Riwayat Transaksi"
- Lihat daftar transaksi yang sudah dibuat

---

## 🎨 Fitur-Fitur yang Tersedia

### ✅ Fitur Utama:
1. **Pilih Menu** - Tampilan card menu dengan foto
2. **Shopping Cart** - Keranjang belanja di sidebar
3. **Pilih Ukuran** - Small (-20%), Medium, Large (+20%)
4. **Atur Jumlah** - Increment/decrement qty
5. **Metode Bayar** - Cash, Debit, QRIS
6. **Checkout** - Simpan transaksi ke database
7. **Modal Success** - Notifikasi transaksi berhasil
8. **Search & Filter** - Cari menu dan filter kategori
9. **Riwayat Transaksi** - Lihat transaksi yang sudah dibuat

### 🎨 Design Features:
- Tema pink konsisten
- Animasi smooth
- Responsive layout
- Real-time cart update
- Auto-calculate total

---

## 📝 Notes

### Database Requirements:
Pastikan kolom berikut ada di tabel:
- `t_menu`: id, id_menu, nama_menu, kategori, harga, foto
- `t_transaksi`: id, kode_transaksi, id_user, total, metode_bayar, time
- `t_detail_transaksi`: id, id_transaksi, id_menu, ukuran, jumlah, subtotal

### Permissions:
- Kasir bisa: tambah transaksi, lihat riwayat sendiri
- Admin bisa: lihat semua transaksi, buat transaksi

---

## 🚀 Next Steps (Optional)

1. **Print Receipt** - Tambah fitur print struk
2. **Report Penjualan** - Laporan per hari/bulan
3. **Stok Management** - Kurangi stok otomatis
4. **Payment Calculator** - Kalkulator kembalian
5. **Customer Display** - Tampilan untuk customer
6. **Export Excel** - Export laporan ke Excel

---

Selamat mencoba! 🎉
