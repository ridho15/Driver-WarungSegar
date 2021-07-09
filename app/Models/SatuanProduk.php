<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatuanProduk extends Model
{
    use HasFactory;
    protected $table = 'satuan_produk';
    protected $primaryKey = 'id_satuan';

    public function satuanProdukMaster()
    {
        return $this->belongsTo('\App\Models\SatuanProdukMaster', 'id_satuan_produk_master', 'id_satuan_produk_master');
    }

    public function satuanProdukLog()
    {
        return $this->hasMany('\App\Models\SatuanProdukLog', 'id_satuan', 'id_satuan');
    }
}
