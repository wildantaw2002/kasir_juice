<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-6 rounded-xl shadow-2xl">
            <div>
                <h2 class="font-bold text-3xl text-white leading-tight drop-shadow-lg">
                    🍹 {{ __('Daftar Menu') }}
                </h2>
                <p class="text-blue-100 text-sm mt-1">Kelola menu minuman juice Anda</p>
            </div>
            <a href="{{ route('menu.create') }}" class="inline-flex items-center px-6 py-3 bg-white border-2 border-indigo-200 rounded-xl font-bold text-sm text-indigo-600 uppercase tracking-widest hover:bg-indigo-50 hover:scale-110 active:scale-95 focus:outline-none focus:ring-4 focus:ring-indigo-300 transition-all duration-300 transform shadow-lg hover:shadow-2xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Menu
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Alert Success -->
            @if(session('success'))
            <div class="mb-6 p-5 bg-gradient-to-r from-pink-100 via-rose-100 to-pink-100 border-l-4 border-indigo-500 text-pink-800 rounded-lg shadow-lg animate-slide-down" role="alert">
                <div class="flex items-center">
                    <div class="bg-indigo-500 rounded-full p-2 mr-3">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <p class="font-semibold text-lg">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <!-- Search & Filter -->
            <div class="bg-gradient-to-br from-white via-pink-50 to-rose-50 overflow-hidden shadow-xl sm:rounded-2xl mb-6 animate-fade-in border-2 border-indigo-200">
                <div class="p-6">
                    <form method="GET" action="{{ route('menu.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div class="relative group">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari menu..." class="w-full pl-12 pr-4 py-3 border-2 border-indigo-300 rounded-xl focus:ring-4 focus:ring-indigo-300 focus:border-indigo-500 transition duration-300 bg-white shadow-sm group-hover:shadow-md">
                            <svg class="absolute left-4 top-3.5 w-5 h-5 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>

                        <!-- Filter Kategori -->
                        <select name="kategori" class="w-full px-4 py-3 border-2 border-indigo-300 rounded-xl focus:ring-4 focus:ring-indigo-300 focus:border-indigo-500 transition duration-300 bg-white shadow-sm hover:shadow-md">
                            <option value="">🍹 Semua Kategori</option>
                            @foreach($kategoris as $kat)
                            <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                            @endforeach
                        </select>

                        <!-- Button -->
                        <div class="flex gap-3">
                            <button type="submit" class="flex-1 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white px-4 py-3 rounded-xl transition duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl font-bold">
                                🔍 Filter
                            </button>
                            <a href="{{ route('menu.index') }}" class="flex-1 bg-gradient-to-r from-gray-400 to-gray-500 hover:from-gray-500 hover:to-gray-600 text-white px-4 py-3 rounded-xl text-center transition duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl font-bold">
                                ↻ Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-gradient-to-br from-white via-pink-50 to-white overflow-hidden shadow-2xl sm:rounded-2xl animate-fade-in border-2 border-indigo-200">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-pink-200">
                            <thead class="bg-gradient-to-r from-pink-500 via-rose-500 to-pink-500">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-white uppercase tracking-wider">📸 Foto</th>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-white uppercase tracking-wider">🆔 ID Menu</th>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-white uppercase tracking-wider">🍹 Nama</th>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-white uppercase tracking-wider">📁 Kategori</th>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-white uppercase tracking-wider">💰 Harga</th>
                                    <th class="px-6 py-4 text-right text-sm font-bold text-white uppercase tracking-wider">⚡ Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-pink-100">
                                @forelse($menus as $menu)
                                <tr class="hover:bg-indigo-50 transition duration-300 transform hover:scale-[1.02]">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($menu->foto)
                                        <img src="{{ asset('storage/' . $menu->foto) }}" alt="{{ $menu->nama_menu }}" class="h-20 w-20 rounded-2xl object-cover shadow-lg hover:shadow-2xl transition duration-300 cursor-pointer transform hover:scale-110 border-4 border-indigo-300" onclick="showImageModal('{{ asset('storage/' . $menu->foto) }}')">
                                        @else
                                        <div class="h-20 w-20 rounded-2xl bg-gradient-to-br from-pink-400 via-rose-400 to-pink-500 flex items-center justify-center shadow-lg animate-pulse">
                                            <span class="text-white text-2xl font-bold drop-shadow-lg">{{ substr($menu->nama_menu, 0, 1) }}</span>
                                        </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-700">
                                        {{ $menu->id_menu }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-semibold">
                                        {{ $menu->nama_menu }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-4 py-2 inline-flex text-xs leading-5 font-bold rounded-full bg-gradient-to-r from-pink-200 to-rose-200 text-pink-800 shadow-md">
                                            {{ $menu->kategori }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-indigo-600 font-bold text-lg">
                                        Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('menu.edit', $menu->id) }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-2 rounded-lg hover:from-blue-600 hover:to-blue-700 transition duration-300 transform hover:scale-110 shadow-md">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-gradient-to-r from-red-500 to-red-600 text-white p-2 rounded-lg hover:from-red-600 hover:to-red-700 transition duration-300 transform hover:scale-110 shadow-md">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                        <p class="text-lg">Tidak ada menu yang ditemukan</p>
                                        <a href="{{ route('menu.create') }}" class="inline-block mt-4 text-indigo-600 hover:text-indigo-800">Tambah menu pertama</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $menus->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4" onclick="hideImageModal()">
        <div class="relative max-w-4xl max-h-full">
            <img id="modalImage" src="" alt="" class="max-w-full max-h-screen rounded-lg shadow-2xl">
            <button onclick="hideImageModal()" class="absolute top-4 right-4 text-white bg-black bg-opacity-50 rounded-full p-2 hover:bg-opacity-75 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <style>
        @keyframes slide-down {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes fade-in {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        .animate-slide-down {
            animation: slide-down 0.3s ease-out;
        }
        .animate-fade-in {
            animation: fade-in 0.5s ease-out;
        }
    </style>

    <script>
        function showImageModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function hideImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        // Auto hide success alert
        setTimeout(() => {
            const alert = document.querySelector('[role="alert"]');
            if (alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }
        }, 5000);
    </script>
</x-app-layout>
