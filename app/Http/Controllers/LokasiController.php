<?php

namespace App\Http\Controllers;

use App\Models\ConfigHariPengiriman;
use App\Models\ConfigWaktuPengiriman;
use App\Models\Driver;
use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\TransaksiApps;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    //
    function semuaLokasi(Request $request)
    {
        $configHariPengiriman = ConfigHariPengiriman::orderBy('id_config_hari_pengiriman', 'DESC')->first();
        $driver = Driver::findOrFail($request->session()->get('id_driver'));
        if ($driver->level == 1) {
            $configWaktuPengiriman = ConfigWaktuPengiriman::whereHas('configWaktuPengirimanLog', function ($query) use ($configHariPengiriman, $driver) {
                $query->whereHas('transaksiApps', function ($query) use ($configHariPengiriman, $driver) {
                    $query->where(function ($query) use ($configHariPengiriman) {
                        $query->whereDate('tw2', '>=', date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '-' . $configHariPengiriman->hari . 'days')))
                            ->whereDate('tw2', '<=', date('Y-m-d H:i:s'));
                    })->where('id_kota', $driver->id_kota)->where('tipe_keranjang', 1)->where(function ($query) {
                        $query->where('status', 2)
                            ->orWhere('status', 3)
                            ->orWhere('status', 4);
                    })->where('id_driver', $driver->id_driver);
                });
            })->get();
        } elseif ($driver->level == 2) {
            $configWaktuPengiriman = ConfigWaktuPengiriman::whereHas('configWaktuPengirimanLog', function ($query) use ($configHariPengiriman, $driver) {
                $query->whereHas('transaksiApps', function ($query) use ($configHariPengiriman, $driver) {
                    $query->where(function ($query) use ($configHariPengiriman) {
                        $query->whereDate('tw2', '>=', date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '-' . $configHariPengiriman->hari . 'days')))
                            ->whereDate('tw2', '<=', date('Y-m-d H:i:s'));
                    })->where('id_kota', $driver->id_kota)->where('tipe_keranjang', 1)->where(function ($query) {
                        $query->where('status', 2)
                            ->orWhere('status', 3)
                            ->orWhere('status', 4);
                    });
                });
            })->get();
        }
        $data = [
            'title' => 'Halaman Lokasi',
            'active' => 'Semua Lokasi',
            'configWaktuPengiriman' => $configWaktuPengiriman,
            'configHariPengiriman' => $configHariPengiriman,
            'backPage' => '/home'
        ];
        return view('lokasi.semua-lokasi', $data);
    }

    function lokasiPesanan(Request $request)
    {
        $crypt = new CryptController();
        $transaksiApps = TransaksiApps::findOrFail($crypt->crypt($request->id, 'd'));
        $data = [
            'title' => 'Lokasi Pesanan',
            'active' => 'Lokasi Pesanan',
            'transaksiApps' => $transaksiApps,
            'backPage' => '/pesanan/detail?id=' . $request->id
        ];

        return view('lokasi.lokasi', $data);
    }

    function PerKecamatan(Request $request)
    {
        $kota = Kota::get();
        $data = [
            'title' => 'Halaman Pesanan Per Kecamatan',
            'active' => 'Kecamatan',
            'kota' => $kota
        ];
        return view('lokasi.per-kecamatan', $data);
    }

    function fetchData(Request $request, $pages)
    {
        if ($pages == 'get-kecamatan') {
            $id_kota = $request->id_kota;
            $kecamatan = Kecamatan::where('id_kota', $id_kota)->get();
            $data = [
                'kecamatan' => $kecamatan
            ];

            return $data;
        }
    }
}
