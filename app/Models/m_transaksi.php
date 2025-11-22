<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class m_transaksi extends Model
{
    protected $table = 't_transaksi';

    protected $fillable = [
        'kode_transaksi',
        'id_user',
        'total',
        'metode_bayar',
        'time',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function details()
    {
        return $this->hasMany(t_detail_transaksi::class, 'id_transaksi');
    }
}
