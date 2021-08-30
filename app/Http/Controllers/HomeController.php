<?php

namespace App\Http\Controllers;

use App\Models\ConfigHariPengiriman;
use App\Models\ConfigWaktuPengiriman;
use App\Models\Driver;
use App\Models\TransaksiApps;
use Illuminate\Http\Request;
use Carbon\CarbonPeriod;
use Carbon\Carbon;

class HomeController extends Controller
{
    function index(Request $request)
    {
        $configHariPengiriman = ConfigHariPengiriman::orderBy('id_config_hari_pengiriman', 'DESC')->first();
        $driver = Driver::findOrFail($request->session()->get('id_driver'));
        $configWaktuPengiriman = ConfigWaktuPengiriman::where('id_kota', 1)->where('tipe', 1)->get();
        $carbon = new Carbon();
        $transaksiApps = TransaksiApps::where(function($query){
            $query->where('status', 2)
            ->orWhere('status', 3);
        })->where('id_kota', 1)->where('tipe_keranjang', 1)->orderBy('tanggal_pengiriman', 'ASC')->get();
        $data = [
            'title' => 'Halaman Home',
            'active' => 'Home',
            'level' => $request->session()->get('level'),
            'driver' => Driver::get(),
            'configHariPengiriman' => $configHariPengiriman,
            'driver' => $driver,
            'configWaktuPengiriman' => $configWaktuPengiriman,
            'function' => new FunctionController(),
            'crypt' => new CryptController(),
        ];
        setcookie('urutand', $driver->id_driver, 0);
        return view('home/index', $data);
    }
}
