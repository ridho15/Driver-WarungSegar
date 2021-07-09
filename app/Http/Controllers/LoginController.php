<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\DriverLoginLogs;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    //
    function index(Request $request)
    {
        Cookie::queue(Cookie::forget('urutand'));
        setcookie('urutand', '', time() - 10);
        return view('login.index');
    }

    function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $driver = Driver::where('email', $request->email)->first();
        if (!$driver) {
            return redirect()->back()->with('fail', 'Email tidak ditemukan');
        }
        if (!password_verify(md5($request->password), $driver->password)) {
            return redirect()->back()->with('fail', 'Password kamu salah');
        }

        $crypt = new CryptController();
        $token = $crypt->crypt(date('Y-m-d H:i:s'));

        DriverLoginLogs::insert([
            'id_driver' => $driver->id_driver,
            'device' => $request->server('HTTP_USER_AGENT'),
            'token' => $token,
            'status' => 1
        ]);
        $request->session()->put([
            'id_driver' => $driver->id_driver,
            'token' => $token,
            'nama_driver' => $driver->nama_driver,
            'level' => $driver->level
        ]);
        setcookie('urutand', $crypt->crypt($driver->id_driver), 0);
        return redirect('/')->with('success', 'Login Driver Berhasil');
    }
}
