<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukMaster extends Model
{
    use HasFactory;
    protected $table = 'produk_master';
    protected $primaryKey = 'id_produk';

    public function produkMasterGambar()
    {
        return $this->hasMany('\App\Models\ProdukMasterGambar', 'id_produk', 'id_produk');
    }
}
