<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-6 rounded-xl shadow-2xl">
            <div>
                <h2 class="font-bold text-3xl text-white leading-tight drop-shadow-lg">
                    📄 {{ __('Detail Transaksi') }}
                </h2>
                <p class="text-blue-100 text-sm mt-1">{{ $transaksi->kode_transaksi }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('kasir.print', $transaksi->id) }}" class="inline-flex items-center px-6 py-3 bg-white border-2 border-indigo-200 rounded-xl font-bold text-sm text-indigo-600 uppercase tracking-widest hover:bg-indigo-50 hover:scale-110 transition-all duration-300 transform shadow-lg">
                    🖨️ Print PDF
                </a>
                <a href="{{ route('kasir.history') }}" class="inline-flex items-center px-6 py-3 bg-white border-2 border-indigo-200 rounded-xl font-bold text-sm text-indigo-600 uppercase tracking-widest hover:bg-indigo-50 hover:scale-110 transition-all duration-300 transform shadow-lg">
                    📋 Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Info Transaksi -->
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl mb-6 border-2 border-indigo-200">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-4">
                    <h3 class="text-white font-bold text-xl">📊 Informasi Transaksi</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Kode Transaksi</p>
                            <p class="text-lg font-bold text-indigo-600">{{ $transaksi->kode_transaksi }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal & Waktu</p>
                            <p class="text-lg font-bold text-gray-800">{{ $transaksi->time->format('d/m/Y H:i:s') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Kasir</p>
                            <p class="text-lg font-bold text-gray-800">{{ $transaksi->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Metode Pembayaran</p>
                            <p class="text-lg font-bold">
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                    @if($transaksi->metode_bayar == 'Cash') bg-green-100 text-green-800
                                    @elseif($transaksi->metode_bayar == 'Debit') bg-blue-100 text-blue-800
                                    @else bg-purple-100 text-purple-800 @endif">
                                    {{ $transaksi->metode_bayar }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Item -->
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl mb-6 border-2 border-indigo-200">
                <div class="bg-gradient-to-r from-cyan-600 to-blue-600 p-4">
                    <h3 class="text-white font-bold text-xl">🛒 Item Transaksi</h3>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-indigo-200">
                            <thead class="bg-indigo-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Menu</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Ukuran</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Harga</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Jumlah</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-indigo-700 uppercase tracking-wider">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-indigo-100">
                                @foreach($transaksi->details as $detail)
                                <tr class="hover:bg-indigo-50 transition duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($detail->menu->foto)
                                            <img src="{{ asset('storage/' . $detail->menu->foto) }}" alt="{{ $detail->menu->nama_menu }}" class="h-10 w-10 rounded-lg object-cover mr-3">
                                            @else
                                            <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center mr-3">
                                                <span class="text-white font-bold">{{ substr($detail->menu->nama_menu, 0, 1) }}</span>
                                            </div>
                                            @endif
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $detail->menu->nama_menu }}</p>
                                                <p class="text-xs text-gray-500">{{ $detail->menu->kategori }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                            {{ $detail->ukuran }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        Rp {{ number_format($detail->subtotal / $detail->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                        {{ $detail->jumlah }}x
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-indigo-600">
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-indigo-50">
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-right text-sm font-bold text-gray-900">
                                        Total Item: {{ $transaksi->details->sum('jumlah') }} | Total:
                                    </td>
                                    <td class="px-6 py-4 text-right text-xl font-bold text-indigo-600">
                                        Rp {{ number_format($transaksi->total, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Summary -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 overflow-hidden shadow-2xl sm:rounded-2xl p-6 text-white">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                    <div>
                        <p class="text-indigo-100 text-sm">Total Item</p>
                        <p class="text-3xl font-bold">{{ $transaksi->details->count() }}</p>
                    </div>
                    <div>
                        <p class="text-indigo-100 text-sm">Total Qty</p>
                        <p class="text-3xl font-bold">{{ $transaksi->details->sum('jumlah') }}</p>
                    </div>
                    <div>
                        <p class="text-indigo-100 text-sm">Metode Bayar</p>
                        <p class="text-xl font-bold">{{ $transaksi->metode_bayar }}</p>
                    </div>
                    <div>
                        <p class="text-indigo-100 text-sm">Total Bayar</p>
                        <p class="text-3xl font-bold">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
