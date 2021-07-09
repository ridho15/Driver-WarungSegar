<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    use HasFactory;
    protected $table = 'kota';
    protected $primaryKey = 'id_kota';

    public function kecamatan()
    {
        return $this->hasMany('\App\Models\Kecamatan', 'id_kota', 'id_kota');
    }
}
