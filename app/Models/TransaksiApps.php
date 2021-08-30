<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiApps extends Model
{
    use HasFactory;
    protected $table = 'transaksi_apps';
    protected $primaryKey = 'id_transaksi_apps';

    protected $fillable = [
        'id_user',
        'id_warehouse_akun',
        'id_driver',
        'id_kota',
        'id_warehouse',
        'id_config_waktu_pengiriman_log',
        'id_alamat',
        'status',
        'tw1',
        'tw2',
        'tw3',
        'tw4',
        'tw10',
        'tanggal_pengiriman',
        'id_metode_pembayaran_waktu',
        'potongan',
        'ongkir',
        'ongkir_asli',
        'total',
        'profit',
        'catatan',
        'keterangan',
        'ulas',
        'tipe_keranjang',
        'deadline',
        'status_pembayaran',
    ];

    public function user()
    {
        return $this->belongsTo('\App\Models\User', 'id_user', 'id_user');
    }

    public function transaksiAppsDetail()
    {
        return $this->hasMany('\App\Models\TransaksiAppsDetail', 'id_transaksi_apps', 'id_transaksi_apps');
    }

    public function transaksiJenisPembayaranWaktu()
    {
        return $this->belongsTo('\App\Models\TransaksiJenisPembayaranWaktu', 'id_metode_pembayaran_waktu', 'id_jenis_pembayaran_waktu');
    }

    public function warehouseAkun()
    {
        return $this->belongsTo('\App\Models\WarehouseAkun', 'id_warehouse_akun', 'id_warehouse_akun');
    }

    public function alamat()
    {
        return $this->belongsTo('\App\Models\Alamat', 'id_alamat', 'id_alamat');
    }

    public function configWaktuPengirimanLog()
    {
        return $this->belongsTo('\App\Models\ConfigWaktuPengirimanLog', 'id_config_waktu_pengiriman_log', 'id_config_waktu_pengiriman_log');
    }

    public function driver()
    {
        return $this->belongsTo('\App\Models\Driver', 'id_driver', 'id_driver');
    }

    public function warehouse()
    {
        return $this->belongsTo('\App\Models\Warehouse', 'id_warehouse', 'id_warehouse');
    }

    public function kota()
    {
        return $this->belongsTo('\App\Models\Kota', 'id_kota', 'id_kota');
    }

    public function transaksiAppsUlasan()
    {
        return $this->hasMany('\App\Models\TransaksiAppsUlasan', 'id_transaksi_apps', 'id_transaksi_apps');
    }
}
