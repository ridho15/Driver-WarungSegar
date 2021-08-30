<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferalUser extends Model
{
    use HasFactory;
    protected $table = 'referal_user';
    protected $primaryKey = 'id_referal_user';

    protected $fillable = [
        'id_referal_user',
        'id_user',
        'kode_referal',
        'status'
    ];

    public function user(){
        return $this->belongsTo('\App\Models\User', 'id_user', 'id_user');
    }
}
