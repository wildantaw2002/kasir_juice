<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class t_menu extends Model
{
    protected $table = 't_menu';
    protected $fillable = [
        'nama_menu',
        'kategori',
        'harga',
        'foto',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    public function detailTransaksi()
    {
        return $this->hasMany(t_detail_transaksi::class, 'id_menu');
    }

    public function bahans()
    {
        return $this->belongsToMany(t_bahan::class, 't_resep_menu', 'id_menu', 'id_bahan')
                    ->withPivot('jumlah_bahan')
                    ->withTimestamps();
    }
}
