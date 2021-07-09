<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class FunctionController extends Controller
{
    //
    public function formatTanggal($waktu)
    {
        $namaBulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];
        $tanggal = date('d', strtotime($waktu));
        $bulan = $namaBulan[date('m', strtotime($waktu))];
        $tahun = date('Y', strtotime($waktu));

        return $tanggal . '-' . $bulan . '-' . $tahun;
    }
}
