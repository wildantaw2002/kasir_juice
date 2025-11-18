<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class t_menu extends Model
{
    protected $table = 't_menu';
    protected $fillable = [
        'id_menu',
        'nama_menu',
        'kategori',
        'harga',
        'foto',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    public function t_detail_transaksi()
    {
        return $this->hasMany(t_detail_transaksi::class, 'id_menu');
    }
}
