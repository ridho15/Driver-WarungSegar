<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;
    protected $table = 'kecamatan';
    protected $primaryKey = 'id_kecamatan';

    public function kota()
    {
        return $this->belongsTo('\App\Models\Kota', 'id_kota', 'id_kota');
    }
}