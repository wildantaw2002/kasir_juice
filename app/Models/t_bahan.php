<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class t_bahan extends Model
{
    protected $table = 't_bahan';
    protected $filllable = [
        'id_bahan',
        'nama_bahan',
        'stok_bahan',
        'satuan_bahan',
        'harga_satuan'
    ];

    protected $casts = [
        'stok_bahan' => 'integer',
        'harga_satuan' => 'decimal:2',
    ];

    public function resepMenu()
    {
        return $this->hasMany(ResepMenu::class, 'id_bahan');
    }

    public function menu()
    {
        return $this->belongsToMany(Menu::class, 't_resep_menu', 'id_bahan', 'id_menu')
                    ->withPivot('jumlah_bahan')
                    ->withTimestamps();
    }

    
}
