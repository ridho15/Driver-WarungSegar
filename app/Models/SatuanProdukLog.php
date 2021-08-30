<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatuanProdukLog extends Model
{
    use HasFactory;
    protected $table = 'satuan_produk_log';
    protected $primaryKey = 'id_satuan_log';

    public function satuanProduk()
    {
        return $this->belongsTo('\App\Models\SatuanProduk', 'id_satuan', 'id_satuan');
    }

    public function satuanProdukMasterLog()
    {
        return $this->belongsTo('\App\Models\SatuanProdukMasterLog', 'id_satuan_produk_master_log', 'id_satuan_produk_master_log');
    }
}
