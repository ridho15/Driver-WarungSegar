<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukB2C extends Model
{
    use HasFactory;
    protected $table = 'produk_b2c';
    protected $primaryKey = 'id_produk_b2c';

    public function produkB2CHarga()
    {
        return $this->hasMany('\App\Models\ProdukB2CHarga', 'id_produk_b2c', 'id_produk_b2c');
    }

    public function produkSub()
    {
        return $this->belongsTo('\App\Models\ProdukSub', 'id_produk_sub', 'id_produk_sub');
    }
}
