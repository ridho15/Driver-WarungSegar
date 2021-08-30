<?php

namespace App\Http\Controllers;

use App\Models\ConfigHariPengiriman;
use App\Models\ConfigWaktuPengiriman;
use App\Models\Driver;
use App\Models\Kota;
use App\Models\TransaksiApps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redis;

class PesananController extends Controller
{
    function detailPesanan(Request $request)
    {
        $crypt = new CryptController();
        $transaksiApps = TransaksiApps::findOrFail($crypt->crypt($request->id, 'd'));
        $driver = Driver::where('status', 1)->where('id_kota', 1)->get();
        $data = [
            'title' => 'Detail Pesanan',
            'active' => 'Detail Pesanan',
            'backPage' => '/home',
            'transaksiApps' => $transaksiApps,
            'function' => new FunctionController(),
            'crypt' => $crypt,
            'driver' => $driver,
            'level' => $request->session()->get('level')
        ];
        return view('pesanan.detail-pesanan', $data);
    }

    function kirimPesanan(Request $request)
    {
        $crypt = new CryptController();
        $transaksiApps = TransaksiApps::findOrFail($crypt->crypt($request->id, 'd'));
        if (!$transaksiApps->driver) {
            return redirect()->back()->with('fail', 'Kamu belum memilih Driver');
        }
        if ($transaksiApps->driver) {
            $transaksiApps->update([
                'status' => 3,
                'tw3' => date('Y-m-d H:i:s'),
            ]);
            $sendNotification = new SendNotificationController();
            $heading = 'Info pesanan';
            $message = 'Pesanan Kamu Sedang Diantar Oleh ' . $transaksiApps->driver->nama_driver;
            $data = [
                'id_user' => $crypt->crypt($transaksiApps->id_user)
            ];
            $sendNotification->sendNotificationToPembeli('Info Pesanan', 'Pesanan ' . $transaksiApps->user->nama_depan . ' ' . $transaksiApps->user->nama_belakang . ' Sedang Diantar Oleh ' . $transaksiApps->driver->nama_driver);
            $response = $sendNotification->sendNotificationToAppRN($heading, $message, $data);
            if ($response['status'] == 1) {
                return redirect()->back()->with('success', 'Berhasil membuat pesanan menjadi kiriman');
            }
        } else {
            return redirect()->back()->with('fail', 'Anda belum memilih driver');
        }
    }

    function batalKirim(Request $request)
    {
        $crypt = new CryptController();
        $transaksiApps = TransaksiApps::findOrFail($crypt->crypt($request->id, 'd'));

        $transaksiApps->update([
            'status' => 2
        ]);

        return redirect()->back()->with('fail', 'Pesanan Batal Dikirim');
    }

    function siapDikirim(Request $request)
    {
        $configHariPengiriman = ConfigHariPengiriman::orderBy('id_config_hari_pengiriman', 'DESC')->first();
        $user = Driver::findOrFail($request->session()->get('id_driver'));
        if ($user->level == 1) {
            $configWaktuPengiriman = ConfigWaktuPengiriman::whereHas('configWaktuPengirimanLog', function ($query) use ($configHariPengiriman, $user) {
                $query->whereHas('transaksiApps', function ($query) use ($configHariPengiriman, $user) {
                    $query->where('status', 2)->where('id_kota', $user->id_kota)->where('tipe_keranjang', 1)
                        ->where(function ($query) use ($configHariPengiriman) {
                            $query->whereDate('tw2', '>=', date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '-' . $configHariPengiriman->hari . 'days')))
                                ->whereDate('tw2', '<=', date('Y-m-d H:i:s'));
                        })->where('id_driver', $user->id_driver);
                });
            })->get();
        } elseif ($user->level == 2) {
            $configWaktuPengiriman = ConfigWaktuPengiriman::whereHas('configWaktuPengirimanLog', function ($query) use ($configHariPengiriman, $user) {
                $query->whereHas('transaksiApps', function ($query) use ($configHariPengiriman, $user) {
                    $query->where('status', 2)->where('id_kota', $user->id_kota)->where('tipe_keranjang', 1)
                        ->where(function ($query) use ($configHariPengiriman) {
                            $query->whereDate('tw2', '>=', date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '-' . $configHariPengiriman->hari . 'days')))
                                ->whereDate('tw2', '<=', date('Y-m-d H:i:s'));
                        });
                });
            })->get();
        }
        $data = [
            'title' => 'Halaman Pesanan',
            'active' => 'Pesanan Siap Dikirim',
            'configHariPengiriman' => $configHariPengiriman,
            'configWaktuPengiriman' => $configWaktuPengiriman,
            'backPage' => '/home',
            'function' => new FunctionController(),
            'crypt' => new CryptController(),
            'user' => $user,
            'driver' => Driver::where('id_kota', $user->id_kota)->get()
        ];
        return view('pesanan.siap-dikirim', $data);
    }

    function sedangDikirim(Request $request)
    {
        $configHariPengiriman = ConfigHariPengiriman::orderBy('id_config_hari_pengiriman', 'DESC')->first();
        $driver = Driver::findOrFail($request->session()->get('id_driver'));
        if ($driver->level == 1) {
            $configWaktuPengiriman = ConfigWaktuPengiriman::whereHas('configWaktuPengirimanLog', function ($query) use ($configHariPengiriman, $driver) {
                $query->whereHas('transaksiApps', function ($query) use ($configHariPengiriman, $driver) {
                    $query->where('status', 3)->where('id_kota', $driver->id_kota)->where('tipe_keranjang', 1)
                        ->where(function ($query) use ($configHariPengiriman) {
                            $query->whereDate('tw3', '>=', date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '-' . $configHariPengiriman->hari . 'days')))
                                ->whereDate('tw3', '<=', date('Y-m-d H:i:s'));
                        })->where('id_driver', $driver->id_driver);
                });
            })->get();
        } elseif ($driver->level == 2) {
            $configWaktuPengiriman = ConfigWaktuPengiriman::whereHas('configWaktuPengirimanLog', function ($query) use ($configHariPengiriman, $driver) {
                $query->whereHas('transaksiApps', function ($query) use ($configHariPengiriman, $driver) {
                    $query->where('status', 3)->where('id_kota', $driver->id_kota)->where('tipe_keranjang', 1)
                        ->where(function ($query) use ($configHariPengiriman) {
                            $query->whereDate('tw3', '>=', date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '-' . $configHariPengiriman->hari . 'days')))
                                ->whereDate('tw3', '<=', date('Y-m-d H:i:s'));
                        });
                });
            })->get();
        }

        $data = [
            'title' => 'Halaman Pesanan',
            'active' => 'Pesanan Dikirim',
            'configHariPengiriman' => $configHariPengiriman,
            'configWaktuPengiriman' => $configWaktuPengiriman,
            'backPage' => '/home',
            'function' => new FunctionController(),
            'crypt' => new CryptController(),
            'driver' => $driver
        ];
        return view('pesanan.sedang-dikirim', $data);
    }

    function pesananSelesai(Request $request)
    {
        if ($request->id) {
            $crypt = new CryptController();
            $transaksiApps = TransaksiApps::findOrFail($crypt->crypt($request->id, 'd'));
            $transaksiApps->update([
                'status' => 4,
                'tw4' => date('Y-m-d H:i:s')
            ]);
            return redirect()->back()->with('success', 'Pesanan Telah Sampai');
        }
        $configHariPengiriman = ConfigHariPengiriman::orderBy('id_config_hari_pengiriman', 'DESC')->first();
        $driver = Driver::findOrFail($request->session()->get('id_driver'));
        if ($driver->level == 1) {
            $configWaktuPengiriman = ConfigWaktuPengiriman::whereHas('configWaktuPengirimanLog', function ($query) use ($configHariPengiriman, $driver) {
                $query->whereHas('transaksiApps', function ($query) use ($configHariPengiriman, $driver) {
                    $query->where('status', 4)->where('id_kota', $driver->id_kota)->where('tipe_keranjang', 1)
                        ->where(function ($query) use ($configHariPengiriman) {
                            $query->whereDate('tw4', '>=', date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '-' . $configHariPengiriman->hari . 'days')))
                                ->whereDate('tw4', '<=', date('Y-m-d H:i:s'));
                        })->where('id_driver', $driver->id_driver);
                });
            })->get();
        } elseif ($driver->level == 2) {
            $configWaktuPengiriman = ConfigWaktuPengiriman::whereHas('configWaktuPengirimanLog', function ($query) use ($configHariPengiriman, $driver) {
                $query->whereHas('transaksiApps', function ($query) use ($configHariPengiriman, $driver) {
                    $query->where('status', 4)->where('id_kota', $driver->id_kota)->where('tipe_keranjang', 1)
                        ->where(function ($query) use ($configHariPengiriman) {
                            $query->whereDate('tw4', '>=', date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '-' . $configHariPengiriman->hari . 'days')))
                                ->whereDate('tw4', '<=', date('Y-m-d H:i:s'));
                        });
                });
            })->get();
        }

        $data = [
            'title' => 'Halaman Pesanan',
            'active' => 'Pesanan Selesai',
            'configHariPengiriman' => $configHariPengiriman,
            'configWaktuPengiriman' => $configWaktuPengiriman,
            'backPage' => '/home',
            'function' => new FunctionController(),
            'crypt' => new CryptController(),
            'driver' => $driver
        ];
        return view('pesanan.selesai', $data);
    }

    function fetchData(Request $request, $pages)
    {
        if ($pages == 'data-pesanan') {
            $id_kota = $request->id_kota;
            $id_kecamatan = $request->id_kecamatan;
            $configHariPengiriman = ConfigHariPengiriman::orderBy('id_config_hari_pengiriman', 'DESC')->first();
            $configWaktuPengiriman = ConfigWaktuPengiriman::whereHas('configWaktuPengirimanLog', function ($query) use ($configHariPengiriman, $id_kota, $id_kecamatan) {
                $query->whereHas('transaksiApps', function ($query) use ($configHariPengiriman, $id_kota, $id_kecamatan) {
                    $query->where('id_kota', $id_kota)->where('tipe_keranjang', 1)->where(function ($query) {
                        $query->where('status', 2)
                            ->orWhere('status', 3)
                            ->orWhere('status', 4);
                    })->where(function ($query) use ($configHariPengiriman) {
                        $query->whereDate('tw2', '>=', date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '-' . $configHariPengiriman->hari . 'days')))
                            ->whereDate('tw2', '<=', date('Y-m-d H:i:s'));
                    })->whereHas('alamat', function ($query) use ($id_kecamatan) {
                    });
                });
            });
        }
    }
}
