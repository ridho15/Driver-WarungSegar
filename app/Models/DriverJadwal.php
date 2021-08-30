<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverJadwal extends Model
{
    use HasFactory;
    protected $table = 'driver_jadwal';
    protected $primaryKey = 'id_driver_jadwal';

    protected $fillable = [
        'id_driver',
        'hari'
    ];

    public function driver()
    {
        return $this->belongsTo('\App\Models\Driver', 'id_driver', 'id_driver');
    }
}
