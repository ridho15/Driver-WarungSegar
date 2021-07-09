<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $table = 'driver';
    protected $primaryKey = 'id_driver';

    protected $fillable = [
        'username',
        'nama_driver',
        'email',
        'password',
        'id_kota',
        'level',
        'foto_driver'
    ];

    public $timestamps = false;

    public function driverLoginLogs()
    {
        return $this->hasMany('\App\Models\DriverLoginLogs', 'id_driver', 'id_driver');
    }

    public function transaksiApps()
    {
        return $this->hasMany('\App\Models\TransaksiApps', 'id_driver', 'id_driver');
    }
}
