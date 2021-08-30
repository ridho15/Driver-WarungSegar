<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigHariPengiriman extends Model
{
    use HasFactory;
    protected $table = 'config_hari_pengiriman';
    protected $primaryKey = 'id_config_hari_pengiriman';
}
