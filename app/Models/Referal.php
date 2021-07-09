<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referal extends Model
{
    use HasFactory;
    protected $table = 'referal';
    protected $primaryKey = 'id_referal';

    protected $fillable = [
        'id_referal',
        'id_referal_user',
        'id_user',
        'id_done',
        'tipe',
        'komisi_segarpay',
    ];

    public function referalUser(){
        return $this->belongsTo('\App\Models\ReferalUser', 'id_referal_user', 'id_referal_user');
    }
}
