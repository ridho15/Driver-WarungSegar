<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverLoginLogs extends Model
{
    use HasFactory;
    protected $table = 'driver_login_logs';
    protected $primaryKey = 'id_driver_login_Logs';

    protected $fillable = [
        'id_driver',
        'device',
        'token',
        'status'
    ];

    public function driver()
    {
        return $this->belongsTo('\App\Models\Driver', 'id_driver', 'id_driver');
    }
}
