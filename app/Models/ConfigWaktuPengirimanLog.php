<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigWaktuPengirimanLog extends Model
{
    use HasFactory;
    protected $table = 'config_waktu_pengiriman_log';
    protected $primaryKey = 'id_config_waktu_pengiriman_log';

    public function configWaktuPengiriman()
    {
        return $this->belongsTo('\App\Models\ConfigWaktuPengiriman', 'id_config_waktu_pengiriman', 'id_config_waktu_pengiriman');
    }

    public function transaksiApps()
    {
        return $this->hasMany('\App\Models\TransaksiApps', 'id_config_waktu_pengiriman_log', 'id_config_waktu_pengiriman_log');
    }
}
