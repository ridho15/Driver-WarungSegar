<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiAppsDetail extends Model
{
    use HasFactory;
    protected $table = 'transaksi_apps_detail';
    protected $primaryKey = 'id_transaksi_apps_detail';

    protected $fillable = [
        'id_transaksi_apps ',
        'id_produk',
        'satuan',
        'id_satuan_log',
        'jumlah',
        'harga_beli',
        'harga_jual',
        'harga_beli_temp',
        'harga_jual_temp',
        'subtotal',
        'status_beli'
    ];

    public function transaksiApps()
    {
        return $this->belongsTo('\App\Models\TransaksiApps', 'id_transaksi_apps', 'id_transaksi_apps');
    }

    public function produkB2CHarga()
    {
        return $this->belongsTo('\App\Models\ProdukB2CHarga', 'id_produk', 'id_produk_b2c_harga');
    }

    public function satuanProdukLog()
    {
        return $this->belongsTo('\App\Models\SatuanProdukLog', 'id_satuan_log', 'id_satuan_log');
    }
}
