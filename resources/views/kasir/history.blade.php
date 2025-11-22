<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-6 rounded-xl shadow-2xl">
            <div>
                <h2 class="font-bold text-3xl text-white leading-tight drop-shadow-lg">
                    📋 {{ __('Riwayat Transaksi') }}
                </h2>
                <p class="text-blue-100 text-sm mt-1">Lihat semua transaksi Anda</p>
            </div>
            <a href="{{ route('kasir.index') }}" class="inline-flex items-center px-6 py-3 bg-white border-2 border-indigo-200 rounded-xl font-bold text-sm text-indigo-600 uppercase tracking-widest hover:bg-indigo-50 hover:scale-110 transition-all duration-300 transform shadow-lg">
                🛒 Kasir
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-2 border-indigo-200">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-indigo-200">
                            <thead class="bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-600">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-white uppercase tracking-wider">Kode Transaksi</th>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-white uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-white uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-white uppercase tracking-wider">Metode Bayar</th>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-white uppercase tracking-wider">Item</th>
                                    <th class="px-6 py-4 text-center text-sm font-bold text-white uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-indigo-100">
                                @forelse($transaksis as $transaksi)
                                <tr class="hover:bg-indigo-50 transition duration-300">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-700">
                                        {{ $transaksi->kode_transaksi }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        {{ $transaksi->time->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-indigo-600 font-bold">
                                        Rp {{ number_format($transaksi->total, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($transaksi->metode_bayar == 'Cash') bg-green-100 text-green-800
                                            @elseif($transaksi->metode_bayar == 'Debit') bg-blue-100 text-blue-800
                                            @else bg-purple-100 text-purple-800 @endif">
                                            {{ $transaksi->metode_bayar }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $transaksi->details->count() }} item
                                        <div class="text-xs text-gray-500 mt-1">
                                            @foreach($transaksi->details->take(2) as $detail)
                                            <div>• {{ $detail->menu->nama_menu }} ({{ $detail->jumlah }}x)</div>
                                            @endforeach
                                            @if($transaksi->details->count() > 2)
                                            <div class="text-pink-600">+{{ $transaksi->details->count() - 2 }} lainnya</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <a href="{{ route('kasir.print', $transaksi->id) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:from-indigo-700 hover:to-purple-700 hover:scale-110 active:scale-95 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-300 shadow-lg">
                                            🖨️ Print PDF
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        <p class="text-lg">Belum ada transaksi</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $transaksis->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
