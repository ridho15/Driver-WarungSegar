<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatuanProdukMasterLog extends Model
{
    use HasFactory;
    protected $table = 'satuan_produk_master_log';
    protected $primaryKey = 'id_satuan_produk_master_log';

    public function satuanProdukMaster()
    {
        return $this->belongsTo('\App\Models\SatuanProdukMaster', 'id_satuan_produk_master', 'id_satuan_produk_master');
    }
}
