<?php

namespace App\Http\Controllers;

use App\Models\ConfigHariPengiriman;
use App\Models\ConfigWaktuPengiriman;
use App\Models\Driver;
use App\Models\TransaksiApps;
use Berkayk\OneSignal\OneSignalFacade;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class HomeController extends Controller
{
    function index(Request $request)
    {
        $configHariPengiriman = ConfigHariPengiriman::orderBy('id_config_hari_pengiriman', 'DESC')->first();
        $driver = Driver::findOrFail($request->session()->get('id_driver'));
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
        $driverPengiriman =  ConfigWaktuPengiriman::whereHas('configWaktuPengirimanLog', function ($query) use ($configHariPengiriman, $driver) {
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
            'driverPengiriman' => $driverPengiriman,
        ];
        setcookie('urutand', $driver->id_driver, 0);
        return view('home/index', $data);
    }
}
