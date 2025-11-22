<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-6 rounded-xl shadow-2xl">
            <div>
                <h2 class="font-bold text-3xl text-white leading-tight drop-shadow-lg">
                    🛒 {{ __('Kasir - Point of Sale') }}
                </h2>
                <p class="text-blue-100 text-sm mt-1">Pilih menu dan buat transaksi</p>
            </div>
            <a href="{{ route('kasir.history') }}" class="inline-flex items-center px-6 py-3 bg-white border-2 border-indigo-200 rounded-xl font-bold text-sm text-indigo-600 uppercase tracking-widest hover:bg-indigo-50 hover:scale-110 transition-all duration-300 transform shadow-lg">
                📋 Riwayat
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Menu List (Kiri) -->
                <div class="lg:col-span-2">
                    <!-- Search & Filter -->
                    <div class="bg-white p-4 rounded-xl shadow-lg mb-4 border-2 border-indigo-200">
                        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari menu..." class="w-full pl-10 pr-4 py-2 border-2 border-indigo-300 rounded-lg focus:ring-4 focus:ring-indigo-300">
                                <svg class="absolute left-3 top-3 w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <select name="kategori" class="w-full px-4 py-2 border-2 border-indigo-300 rounded-lg focus:ring-4 focus:ring-indigo-300" onchange="this.form.submit()">
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
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-indigo-200 hover:shadow-2xl transition duration-300 transform hover:scale-105 cursor-pointer" onclick='addToCart(@json($menu))'>
                            @if($menu->foto)
                            <img src="{{ asset('storage/' . $menu->foto) }}" alt="{{ $menu->nama_menu }}" class="w-full h-32 object-cover">
                            @else
                            <div class="w-full h-32 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                                <span class="text-white text-4xl font-bold">{{ substr($menu->nama_menu, 0, 1) }}</span>
                            </div>
                            @endif
                            <div class="p-3">
                                <h3 class="font-bold text-gray-800 text-sm mb-1">{{ $menu->nama_menu }}</h3>
                                <p class="text-indigo-600 font-bold text-lg">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                <span class="inline-block px-2 py-1 text-xs bg-indigo-100 text-indigo-700 rounded-full mt-1">{{ $menu->kategori }}</span>
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
                    <div class="bg-white rounded-xl shadow-2xl border-4 border-indigo-300 sticky top-4">
                        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-4 rounded-t-lg">
                            <h3 class="text-white font-bold text-xl">🛒 Keranjang</h3>
                        </div>
                        
                        <div class="p-4">
                            <!-- Cart Items -->
                            <div id="cart-items" class="space-y-3 mb-4 max-h-96 overflow-y-auto">
                                <p class="text-gray-400 text-center py-8">Keranjang kosong</p>
                            </div>

                            <!-- Total -->
                            <div class="border-t-2 border-indigo-200 pt-4 space-y-2">
                                <div class="flex justify-between text-lg font-bold text-gray-800">
                                    <span>Total:</span>
                                    <span id="total-price" class="text-indigo-600">Rp 0</span>
                                </div>

                                <!-- Metode Bayar -->
                                <select id="metode-bayar" class="w-full px-4 py-2 border-2 border-indigo-300 rounded-lg focus:ring-4 focus:ring-indigo-300">
                                    <option value="Cash">💵 Cash</option>
                                    <option value="Debit">💳 Debit</option>
                                    <option value="QRIS">📱 QRIS</option>
                                </select>

                                <!-- Buttons -->
                                <button onclick="clearCart()" class="w-full py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition font-bold">
                                    🗑️ Hapus Semua
                                </button>
                                <button onclick="checkout()" class="w-full py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition font-bold text-lg shadow-lg animate-pulse">
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
                <input type="hidden" id="modal-transaksi-id">
                <p class="text-gray-600 mb-1">Total:</p>
                <p id="modal-total" class="text-pink-600 font-bold text-2xl mb-6"></p>
                <div class="flex gap-2">
                    <button onclick="printStruk()" class="flex-1 py-3 bg-gradient-to-r from-cyan-600 to-blue-600 text-white rounded-lg hover:from-cyan-700 hover:to-blue-700 font-bold">
                        🖨️ Print PDF
                    </button>
                    <button onclick="closeModal()" class="flex-1 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 font-bold">
                        OK
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let cart = [];

        function addToCart(menu) {
            // Cek apakah menu sudah ada di cart
            const existingIndex = cart.findIndex(item => item.id === menu.id && item.ukuran === 'Medium');
            
            const hargaBase = parseFloat(menu.harga);
            
            if (existingIndex > -1) {
                cart[existingIndex].jumlah++;
                cart[existingIndex].subtotal = parseFloat(cart[existingIndex].jumlah * hargaBase);
            } else {
                cart.push({
                    id: menu.id,
                    id_menu: menu.id,
                    nama: menu.nama_menu,
                    harga: hargaBase,
                    ukuran: 'Medium',
                    jumlah: 1,
                    subtotal: hargaBase
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
                const sizeMultiplier = {
                    'Small': 0.8,
                    'Medium': 1,
                    'Large': 1.2
                };
                const hargaBase = parseFloat(cart[index].harga);
                const multiplier = sizeMultiplier[cart[index].ukuran] || 1;
                cart[index].subtotal = parseFloat(cart[index].jumlah * hargaBase * multiplier);
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
            const hargaBase = parseFloat(cart[index].harga);
            const multiplier = sizeMultiplier[size] || 1;
            cart[index].subtotal = parseFloat(cart[index].jumlah * hargaBase * multiplier);
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
                total += parseFloat(item.subtotal);
                html += `
                    <div class="bg-indigo-50 p-3 rounded-lg border border-indigo-200">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-bold text-sm text-gray-800">${item.nama}</h4>
                            <button onclick="removeFromCart(${index})" class="text-red-500 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <select onchange="updateSize(${index}, this.value)" class="w-full px-2 py-1 text-xs border border-indigo-300 rounded mb-2">
                            <option value="Small" ${item.ukuran === 'Small' ? 'selected' : ''}>Small (-20%)</option>
                            <option value="Medium" ${item.ukuran === 'Medium' ? 'selected' : ''}>Medium</option>
                            <option value="Large" ${item.ukuran === 'Large' ? 'selected' : ''}>Large (+20%)</option>
                        </select>
                        
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <button onclick="updateQuantity(${index}, -1)" class="bg-indigo-600 text-white w-6 h-6 rounded hover:bg-indigo-700">-</button>
                                <span class="font-bold">${item.jumlah}</span>
                                <button onclick="updateQuantity(${index}, 1)" class="bg-indigo-600 text-white w-6 h-6 rounded hover:bg-indigo-700">+</button>
                            </div>
                            <span class="text-indigo-600 font-bold">Rp ${item.subtotal.toLocaleString('id-ID')}</span>
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
                    document.getElementById('modal-transaksi-id').value = data.transaksi_id;
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

        function printStruk() {
            const transaksiId = document.getElementById('modal-transaksi-id').value;
            window.open('/kasir/transaksi/' + transaksiId + '/print', '_blank');
        }

        function closeModal() {
            document.getElementById('success-modal').classList.add('hidden');
        }
    </script>
</x-app-layout>
