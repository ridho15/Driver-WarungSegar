<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukB2CHarga extends Model
{
    use HasFactory;
    protected $table = 'produk_b2c_harga';
    protected $primaryKey = 'id_produk_b2c_harga';

    public function produkB2C()
    {
        return $this->belongsTo('\App\Models\ProdukB2C', 'id_produk_b2c', 'id_produk_b2c');
    }

    public function transaksiAppsDetail()
    {
        return $this->hasMany('\App\Models\TransaksiAppsDetail', 'id_produk', 'id_produk_b2c_harga');
    }

    public function satuanProduk()
    {
        return $this->belongsTo('\App\Models\SatuanProduk', 'id_satuan', 'id_satuan');
    }
}
