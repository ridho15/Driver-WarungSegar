<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukSub extends Model
{
    use HasFactory;
    protected $table = 'produk_sub';
    protected $primaryKey = 'id_produk_sub';

    public function produkMaster()
    {
        return $this->belongsTo('\App\Models\ProdukMaster', 'id_produk', 'id_produk');
    }

    public function produkB2C()
    {
        return $this->hasOne('\App\Models\ProdukB2C', 'id_produk_sub', 'id_produk');
    }

    public function warehouseStok()
    {
        return $this->hasOne('\App\Models\WarehouseStok', 'id_produk_sub', 'id_produk_sub');
    }

    public function satuanProduk()
    {
        return $this->belongsTo('\App\Models\SatuanProduk', 'id_satuan', 'id_satuan');
    }
}
