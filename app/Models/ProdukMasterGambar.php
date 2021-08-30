<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukMasterGambar extends Model
{
    use HasFactory;
    protected $table = 'produk_master_gambar';
    protected $primaryKey = 'id_produk_master_gambar';

    public function produkMaster()
    {
        return $this->belongsTo('\App\Models\ProdukMaster', 'id_produk', 'id_produk');
    }
}
