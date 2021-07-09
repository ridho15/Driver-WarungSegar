<?php

namespace App\Http\Controllers;

use App\Models\ConfigHariPengiriman;
use App\Models\ConfigWaktuPengiriman;
use App\Models\Driver;
use App\Models\TransaksiApps;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    //
    function index(Request $request)
    {
        if ($request->session()->get('level') == 1) {
            return redirect()->back()->with('fail', 'Maaf Kamu Bukan Kepala Driver');
        }
        $driver = Driver::get();
        $data = [
            'title' => 'Halaman Driver',
            'active' => 'Driver',
            'driver' => $driver,
            'configHariPengiriman' => ConfigHariPengiriman::orderBy('id_config_hari_pengiriman', 'DESC')->first(),
            'crypt' => new CryptController(),
            'function' => new FunctionController,
        ];
        return view('driver.index', $data);
    }

    function simpanDriver(Request $request)
    {
        $idTransaksiApps = $request->id_transaksi_apps;
        $idDriver = $request->id_driver;
        $transaksiApps = TransaksiApps::findOrFail($idTransaksiApps);
        $transaksiApps->update([
            'id_driver' => $idDriver
        ]);

        return redirect()->back()->with('success', 'Berhasil Memilih Driver');
    }


    function detail(Request $request)
    {
        $crypt = new CryptController();
        $driver = Driver::findOrFail($crypt->crypt($request->id, 'd'));
        $configHariPengiriman = ConfigHariPengiriman::orderBy('id_config_hari_pengiriman', 'DESC')->first();
        $configWaktuPengiriman = ConfigWaktuPengiriman::whereHas('configWaktuPengirimanLog', function ($query) use ($configHariPengiriman, $driver) {
            $query->whereHas('transaksiApps', function ($query) use ($configHariPengiriman, $driver) {
                $query->where(function ($query) {
                    $query->where('status', 2)
                        ->orWhere('status', 3)
                        ->orWhere('status', 4);
                })->where('id_driver', $driver->id_driver)->where('id_kota', $driver->id_kota)->where('tipe_keranjang', 1)->where(function ($query) use ($configHariPengiriman) {
                    $query->whereDate('tw2', '>=', date('Y-m-d H:i:s', strtotime(date('Y-m-d') . '-' . $configHariPengiriman->hari . 'days')))
                        ->whereDate('tw2', '<=', date('Y-m-d H:i:s'));
                });
            });
        })->get();
        $siapAntar = 0;
        $pengiriman = 0;
        $selesai = 0;
        foreach ($configWaktuPengiriman as $item) {
            foreach ($item->configWaktuPengirimanLog as $configWaktuPengirimanLog) {
                foreach ($configWaktuPengirimanLog->transaksiApps as $transaksiApps) {
                    if(($transaksiApps->status == 2 || $transaksiApps->status == 3 || $transaksiApps->status == 4) && $transaksiApps->id_driver == $driver->id_driver && $transaksiApps->tw2 >= date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '-' . $configHariPengiriman->hari . 'days')) && $transaksiApps->tw2 <= date('Y-m-d H:i:s') && $transaksiApps->id_kota == 1 && $transaksiApps->tipe_keranjang == 1){
                        if($transaksiApps->status == 2){
                            $siapAntar++;
                        }elseif($transaksiApps->status == 3){
                            $pengiriman++;
                        }elseif($transaksiApps->status == 4){
                            $selesai++;
                        }
                    }
                }
            }
        }
        $data = [
            'title' => 'Halaman Detail Driver',
            'active' => 'Detail Driver',
            'driver' => $driver,
            'crypt' => $crypt,
            'backPage' => '/driver',
            'configHariPengiriman' => $configHariPengiriman,
            'function' => new FunctionController(),
            'configWaktuPengiriman' => $configWaktuPengiriman,
            'siapAntar' => $siapAntar,
            'pengiriman' => $pengiriman,
            'selesai' => $selesai,
        ];

        return view('driver.detail', $data);
    }
}
