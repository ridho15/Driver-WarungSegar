<?php

namespace App\Http\Controllers;

use App\Models\ConfigHariPengiriman;
use App\Models\ConfigWaktuPengiriman;
use App\Models\Driver;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    //
    function index(Request $request)
    {
        $data = [
            'title' => 'Halaman Riwayat',
            'active' => 'Riwayat',
        ];
        return view('riwayat.index', $data);
    }

    function fetchDataPengiriman(Request $request)
    {
        $tanggal = $request->tanggal;
        $configHariPengiriman = ConfigHariPengiriman::orderBy('id_config_hari_pengiriman', 'DESC')->first();
        $driver = Driver::findOrFail($request->session()->get('id_driver'));
        $configWaktuPengiriman = ConfigWaktuPengiriman::whereHas('configWaktuPengirimanLog', function ($query) use ($driver, $tanggal) {
            $query->whereHas('transaksiApps', function ($query) use ($driver, $tanggal) {
                $query->where('id_driver', $driver->id_driver)->where('id_kota', 1)->where('tipe_keranjang', 1)->where('status', 4)->where(function($query)use($tanggal){
                    $query->whereDate('tw4', '>=', date('Y-m-d', strtotime($tanggal)))
                    ->whereDate('tw4', '<=', date('Y-m-d', strtotime($tanggal)));
                });
            });
        })->get();
        $data = [
            'configHariPengiriman' => $configHariPengiriman,
            'configWaktuPengiriman' => $configWaktuPengiriman,
            'driver' => $driver,
            'tanggal' => $tanggal,
            'function' => new FunctionController(),
            'crypt' => new CryptController()
        ];

        return view('riwayat.fetch.data-pengiriman', $data);
    }
}
