<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatuanProdukMaster extends Model
{
    use HasFactory;
    protected $table = 'satuan_produk_master';
    protected $primaryKey = 'id_satuan_produk_master';

    public function satuanProduk()
    {
        return $this->hasMany('\App\Models\SatuanProduk', 'id_satuan_produk_master', 'id_satuan_produk_master');
    }
}
