<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-6 rounded-xl shadow-2xl">
            <h2 class="font-bold text-3xl text-white leading-tight drop-shadow-lg">
                🏠 {{ __('Dashboard Admin') }}
            </h2>
            <p class="text-blue-100 text-sm mt-1">Selamat datang, {{ auth()->user()->name }}!</p>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Menu -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-2 border-indigo-200 transform hover:scale-105 transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Menu</p>
                                <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $totalMenu }}</p>
                            </div>
                            <div class="bg-indigo-100 rounded-full p-4">
                                <span class="text-4xl">🍹</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Transaksi -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-2 border-cyan-200 transform hover:scale-105 transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Transaksi</p>
                                <p class="text-3xl font-bold text-cyan-600 mt-2">{{ $totalTransaksi }}</p>
                            </div>
                            <div class="bg-cyan-100 rounded-full p-4">
                                <span class="text-4xl">📊</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Pendapatan -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-2 border-green-200 transform hover:scale-105 transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Pendapatan</p>
                                <p class="text-2xl font-bold text-green-600 mt-2">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-green-100 rounded-full p-4">
                                <span class="text-4xl">💰</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Kasir -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-2 border-purple-200 transform hover:scale-105 transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Kasir</p>
                                <p class="text-3xl font-bold text-purple-600 mt-2">{{ $totalKasir }}</p>
                            </div>
                            <div class="bg-purple-100 rounded-full p-4">
                                <span class="text-4xl">👥</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik Hari Ini -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-600 to-indigo-600 overflow-hidden shadow-xl sm:rounded-2xl p-6 text-white">
                    <h3 class="text-lg font-bold mb-4 flex items-center">
                        <span class="text-2xl mr-2">📅</span> Transaksi Hari Ini
                    </h3>
                    <p class="text-4xl font-bold">{{ $transaksiHariIni }}</p>
                    <p class="text-blue-100 mt-2">{{ now()->format('d F Y') }}</p>
                </div>

                <div class="bg-gradient-to-br from-emerald-600 to-teal-600 overflow-hidden shadow-xl sm:rounded-2xl p-6 text-white">
                    <h3 class="text-lg font-bold mb-4 flex items-center">
                        <span class="text-2xl mr-2">💵</span> Pendapatan Hari Ini
                    </h3>
                    <p class="text-3xl font-bold">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</p>
                    <p class="text-green-100 mt-2">{{ now()->format('d F Y') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Menu Terlaris -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-2 border-indigo-200">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-4">
                        <h3 class="text-white font-bold text-xl flex items-center">
                            <span class="text-2xl mr-2">🏆</span> Menu Terlaris
                        </h3>
                    </div>
                    <div class="p-6">
                        @forelse($menuTerlaris as $index => $item)
                        <div class="flex items-center justify-between mb-4 pb-4 {{ !$loop->last ? 'border-b border-indigo-100' : '' }}">
                            <div class="flex items-center space-x-3">
                                <div class="bg-indigo-100 rounded-full w-10 h-10 flex items-center justify-center">
                                    <span class="font-bold text-indigo-600">{{ $index + 1 }}</span>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800">{{ $item->menu->nama_menu }}</p>
                                    <p class="text-sm text-gray-500">{{ $item->menu->kategori }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-indigo-600">{{ $item->total_terjual }}x</p>
                                <p class="text-xs text-gray-500">terjual</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-400 text-center py-8">Belum ada data</p>
                        @endforelse
                    </div>
                </div>

                <!-- Transaksi Terakhir -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-2 border-cyan-200">
                    <div class="bg-gradient-to-r from-cyan-600 to-blue-600 p-4">
                        <h3 class="text-white font-bold text-xl flex items-center">
                            <span class="text-2xl mr-2">⏱️</span> Transaksi Terakhir
                        </h3>
                    </div>
                    <div class="p-6">
                        @forelse($transaksiTerakhir as $transaksi)
                        <div class="mb-4 pb-4 {{ !$loop->last ? 'border-b border-cyan-100' : '' }}">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <p class="font-bold text-cyan-600">{{ $transaksi->kode_transaksi }}</p>
                                    <p class="text-sm text-gray-600">{{ $transaksi->user->name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-gray-800">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500">{{ $transaksi->time->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-1">
                                @foreach($transaksi->details->take(3) as $detail)
                                <span class="inline-block px-2 py-1 text-xs bg-blue-50 text-blue-600 rounded">
                                    {{ $detail->menu->nama_menu }} ({{ $detail->jumlah }}x)
                                </span>
                                @endforeach
                                @if($transaksi->details->count() > 3)
                                <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded">
                                    +{{ $transaksi->details->count() - 3 }} lainnya
                                </span>
                                @endif
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-400 text-center py-8">Belum ada transaksi</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('kasir.index') }}" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-6 px-6 rounded-xl shadow-lg transform hover:scale-105 transition duration-300 text-center">
                    <span class="text-4xl block mb-2">🛒</span>
                    <span class="text-lg">Buka Kasir</span>
                </a>
                
                <a href="{{ route('menu.index') }}" class="bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white font-bold py-6 px-6 rounded-xl shadow-lg transform hover:scale-105 transition duration-300 text-center">
                    <span class="text-4xl block mb-2">🍹</span>
                    <span class="text-lg">Kelola Menu</span>
                </a>
                
                <a href="{{ route('kasir.history') }}" class="bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-bold py-6 px-6 rounded-xl shadow-lg transform hover:scale-105 transition duration-300 text-center">
                    <span class="text-4xl block mb-2">📋</span>
                    <span class="text-lg">Riwayat Transaksi</span>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
