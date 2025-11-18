<?php
class t_bahan extends Model
{
    protected $table = 't_bahan';
    
    protected $fillable = [
        'id_bahan', 'nama_bahan', 'stok_bahan', 
        'harga_satuan', 'total_harga_bahan',
    ];

    protected $casts = [
        'stok_bahan' => 'integer',
        'harga_satuan' => 'decimal:2',
        'total_harga_bahan' => 'decimal:2',
    ];

    public function resepMenu()  
    {
        return $this->hasMany(ResepMenu::class, 'id_bahan');
    }

    public function menus()  
    {
        return $this->belongsToMany(Menu::class, 't_resep_menu', 'id_bahan', 'id_menu')
                    ->withPivot('jumlah_bahan')
                    ->withTimestamps();
    }
}