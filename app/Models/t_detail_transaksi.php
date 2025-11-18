<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class t_detail_transaksi extends Model
{
    protected $table = 't_detail_transaksi';

    protected $fillable = [
        'id_detail',
        'id_transaksi',
        'id_menu',
        'ukuran',
        'jumlah',
        'subtotal',
    ];

    protected $casts = [
        'ukuran' => 'integer',
        'jumlah' => 'integer',
        'subtotal' => 'decimal:2',
    ];

    public function transaksi()
    {
        return $this->belongsTo(m_transaksi::class, 'id_transaksi');
    }

    
    public function menu()
    {
        return $this->belongsTo(t_menu::class, 'id_menu');
    }
}
