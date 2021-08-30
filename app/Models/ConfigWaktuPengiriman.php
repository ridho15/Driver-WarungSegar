<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigWaktuPengiriman extends Model
{
    use HasFactory;
    protected $table = 'config_waktu_pengiriman';
    protected $primaryKey = 'id_config_waktu_pengiriman';

    public function kota()
    {
        return $this->belongsTo('\App\Models\Kota', 'id_kota', 'id_kota');
    }

    public function configWaktuPengirimanLog()
    {
        return $this->hasMany('\App\Models\ConfigWaktuPengirimanLog', 'id_config_waktu_pengiriman', 'id_config_waktu_pengiriman');
    }
}
