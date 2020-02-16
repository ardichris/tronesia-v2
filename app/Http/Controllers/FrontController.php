<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Absensi;
use App\Pelanggaran;
use App\Jurnal;
use Carbon\Carbon;
use App\Http\Resources\FrontCollection;

class FrontController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function statistik()
    {
        $absensitotal = Absensi::count();
        $absensitoday = Absensi::where('absensi_tanggal', Carbon::today())
                                 ->with('siswa')->get();
        $pelanggarantotal = Pelanggaran::count();
        $pelanggarantoday = Pelanggaran::where('pelanggaran_tanggal', Carbon::today())
                                         ->with('siswa')->get();
        $jurnaltotal = Jurnal::count();
        $jurnaltoday = Jurnal::where('jm_tanggal', Carbon::today())
                                ->with('kelas')->get();

        $statistik['absensitotal'] = $absensitotal;
        $statistik['absensitoday'] = $absensitoday;
        $statistik['pelanggarantotal'] = $pelanggarantotal;
        $statistik['pelanggarantoday'] = $pelanggarantoday;
        $statistik['jurnaltotal'] = $jurnaltotal;
        $statistik['jurnaltoday'] = $jurnaltoday;

        return response()->json(['status' => 'success', 'data' => $statistik], 200);
    }
}
