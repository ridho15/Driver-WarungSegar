<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiAppsUlasan extends Model
{
    use HasFactory;
    protected $table = 'transaksi_apps_ulasan';
    protected $primaryKey = 'id_transaksi_apps_ulasan';

    public function transaksiApps()
    {
        return $this->belongsTo('\App\Models\TransaksiApps', 'id_transaksi_apps', 'id_transaksi_apps');
    }
}
