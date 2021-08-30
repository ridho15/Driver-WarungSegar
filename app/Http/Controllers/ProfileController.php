<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ProfileController extends Controller
{
    //
    function __construct()
    {
        $storage = new StorageClient([
            'projectId' => 'warungsegar-a4ef8'
        ]);
        $storage->registerStreamWrapper();
        $bucket = $storage->bucket('assets-warungsegar');
        $this->bucket = $bucket;
    }
    function index(Request $request)
    {
        $data = [
            'title' => 'Halaman Profile',
            'active' => 'Profile',
            'driver' => Driver::findOrFail($request->session()->get('id_driver')),
        ];
        return view('profile.index', $data);
    }

    function logout(Request $request)
    {
        $request->session()->forget('id_driver');
        $request->session()->forget('token');
        $request->session()->forget('nama_driver');
        $request->session()->forget('level');

        Cookie::queue(Cookie::forget('urutand'));
        setcookie('urutand', '', 0);
        return redirect('/')->with('success', 'Logout Driver Berhasil');
    }

    function rubahNama(Request $request)
    {
        $driver = Driver::findOrFail($request->session()->get('id_driver'));
        $data = [
            'title' => 'Halaman Profile',
            'active' => 'Rubah Nama',
            'backPage' => '/profile',
            'driver' => $driver
        ];
        return view('profile.rubah-nama', $data);
    }

    function rubahNamaPost(Request $request)
    {
        $request->validate([
            'nama_driver' => 'required'
        ]);
        $driver = Driver::findOrFail($request->session()->get('id_driver'));
        $driver->update([
            'nama_driver' => $request->nama_driver
        ]);

        return [
            'status' => 1,
            'message' => 'Rubah Nama Berhasil'
        ];
    }

    function rubahPasswordPost(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required'
        ]);

        $driver = Driver::findOrFail($request->session()->get('id_driver'));
        if (!password_verify(md5($request->password_lama), $driver->password)) {
            return redirect()->back()->with('fail', 'Password Lama Kamu Salah');
        }
        $driver->update([
            'password' => password_hash(md5($request->password_baru), PASSWORD_DEFAULT)
        ]);
        $request->session()->forget('id_driver');
        $request->session()->forget('token');
        return redirect('/login')->with('success', 'Berhasil Merubah Password, Silahkan Login Kembali');
    }

    function uploadImage(Request $request)
    {
        $request->validate([
            'fotoDriver' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:10240',
        ]);
        if ($request->hasFile('fotoDriver')) {
            $fotoDriver = $request->file('fotoDriver');
            $namaFoto = $fotoDriver->getClientOriginalName();
            $namaFoto = 'images/driver/' . time() . rand(1, 100) . $namaFoto;
            $namaFoto = strtolower($namaFoto);
            $namaFoto = str_replace(' ', '-', $namaFoto);
            $fOpen = fopen($fotoDriver->getPathname(), "r");
            $this->bucket->upload($fOpen, [
                'name' => $namaFoto
            ]);
            $finalImage = 'https://storage.googleapis.com/assets-warungsegar/' . $namaFoto;
            $finalImages[] = $finalImage;
        } else {
            return 'Foto Driver tidak ditemukan';
        }

        $driver = Driver::findOrFail($request->session()->get('id_driver'));
        $driver->update([
            'foto_driver' => $finalImage
        ]);

        return redirect()->back()->with('success', 'Berhasil Mengupload Foto Driver');
    }

    function informasi(Request $request)
    {
        $data = [
            'title' => 'Halaman Informasi',
            'active' => 'Informasi Aplikasi',
            'backPage' => '/profile',
        ];
        return view('profile.informasi', $data);
    }
}
