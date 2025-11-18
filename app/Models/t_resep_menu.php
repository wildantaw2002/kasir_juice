<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class t_resep_menu extends Model
{
    protected $table = 't_resep_menu';

    protected $fillable = [
        'id_menu',
        'id_bahan',
        'jumlah_bahan',
    ];

    protected $casts = [
        'jumlah_bahan' => 'decimal:2',
    ];

   
    public function menu()
    {
        return $this->belongsTo(t_menu::class, 'id_menu');
    }

    public function bahan()
    {
        return $this->belongsTo(t_bahan::class, 'id_bahan');
    }
}
