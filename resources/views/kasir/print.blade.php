<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk - {{ $transaksi->kode_transaksi }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 11px;
            line-height: 1.4;
            padding: 10px;
            width: 80mm;
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px dashed #333;
            padding-bottom: 10px;
        }
        
        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 3px;
            color: #ec4899;
        }
        
        .header p {
            font-size: 10px;
            margin: 2px 0;
        }
        
        .info {
            margin-bottom: 10px;
            font-size: 10px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
        }
        
        .items {
            margin: 15px 0;
        }
        
        .item {
            margin-bottom: 8px;
            padding-bottom: 5px;
        }
        
        .item-name {
            font-weight: bold;
            font-size: 11px;
            margin-bottom: 2px;
        }
        
        .item-detail {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            margin: 2px 0;
        }
        
        .separator {
            border-top: 1px dashed #999;
            margin: 10px 0;
        }
        
        .total-section {
            margin-top: 10px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
            font-size: 11px;
        }
        
        .grand-total {
            font-weight: bold;
            font-size: 14px;
            padding-top: 8px;
            border-top: 2px solid #333;
            margin-top: 8px;
        }
        
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px dashed #333;
            font-size: 10px;
        }
        
        .footer p {
            margin: 3px 0;
        }
        
        .thank-you {
            font-weight: bold;
            font-size: 12px;
            margin-top: 8px;
            color: #ec4899;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>🍹 KASIR JUICE 🍹</h1>
        <p>Jl. Contoh No. 123, Kota</p>
        <p>Telp: 0812-3456-7890</p>
    </div>
    
    <!-- Info Transaksi -->
    <div class="info">
        <div class="info-row">
            <span>No. Transaksi</span>
            <span><strong>{{ $transaksi->kode_transaksi }}</strong></span>
        </div>
        <div class="info-row">
            <span>Tanggal</span>
            <span>{{ $transaksi->time->format('d/m/Y H:i') }}</span>
        </div>
        <div class="info-row">
            <span>Kasir</span>
            <span>{{ $transaksi->user->name }}</span>
        </div>
        <div class="info-row">
            <span>Pembayaran</span>
            <span><strong>{{ $transaksi->metode_bayar }}</strong></span>
        </div>
    </div>
    
    <div class="separator"></div>
    
    <!-- Items -->
    <div class="items">
        @foreach($transaksi->details as $detail)
        <div class="item">
            <div class="item-name">{{ $detail->menu->nama_menu }}</div>
            <div class="item-detail">
                <span>{{ $detail->ukuran }} x {{ $detail->jumlah }}</span>
                <span>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="item-detail" style="font-size: 9px; color: #666;">
                <span>@ Rp {{ number_format($detail->subtotal / $detail->jumlah, 0, ',', '.') }}</span>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="separator"></div>
    
    <!-- Total -->
    <div class="total-section">
        <div class="total-row">
            <span>Subtotal</span>
            <span>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
        </div>
        <div class="total-row">
            <span>Pajak (0%)</span>
            <span>Rp 0</span>
        </div>
        <div class="total-row grand-total">
            <span>TOTAL</span>
            <span>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
        </div>
    </div>
    
    <!-- Footer -->
    <div class="footer">
        <p>{{ $transaksi->details->count() }} item(s) | {{ $transaksi->details->sum('jumlah') }} qty</p>
        <p class="thank-you">✨ Terima Kasih ✨</p>
        <p>Selamat Menikmati!</p>
        <p style="margin-top: 8px; font-size: 9px;">
            Dicetak: {{ now()->format('d/m/Y H:i:s') }}
        </p>
    </div>
</body>
</html>
