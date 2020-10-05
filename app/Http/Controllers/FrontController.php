<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Absensi;
use App\Pelanggaran;
use App\Jurnal;
use App\Kelas;
use App\Pengumumans;
use App\LaporSarpras;
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
        $jurnaltoday = Jurnal::where([['jm_tanggal', Carbon::today()],['jm_status','!=',2]])
                                ->with('kelas')
                                ->join('kelas','jurnals.kelas_id','=','kelas.id')
                                ->orderBy('kelas.kelas_nama','ASC')
                                ->orderBy('jm_jampel','ASC')
                                ->paginate(9);
        $jumlahKerusakan = LaporSarpras::where([['ls_kategori','Kerusakan'],['ls_status','!=',2]])->count();
        $kerusakanDetail = LaporSarpras::where([['ls_kategori','Kerusakan'],['ls_status','!=',2]])->get();
        $pengumuman = Pengumumans::with('user')->get();

        $statistik['absensitotal'] = $absensitotal;
        $statistik['absensitoday'] = $absensitoday;
        $statistik['pelanggarantotal'] = $pelanggarantotal;
        $statistik['pelanggarantoday'] = $pelanggarantoday;
        $statistik['jurnaltotal'] = $jurnaltotal;
        $statistik['jurnaltoday'] = $jurnaltoday;
        $statistik['jumlahKerusakan'] = $jumlahKerusakan;
        $statistik['kerusakanDetail'] =$kerusakanDetail;
        $statistik['pengumuman'] = $pengumuman;

        return response()->json(['status' => 'success', 'data' => $statistik], 200);
    }
}
