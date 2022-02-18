<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Absensi;
use App\Pelanggaran;
use App\Jurnal;
use App\Kelas;
use App\Pengumumans;
use App\LaporSarpras;
use App\DetailJurnal;
use Carbon\Carbon;
use App\Http\Resources\FrontCollection;


class FrontController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function statistik(Request $request)
    {
        $user = $request->user();
        $absensitotal = DetailJurnal::with('jurnal')
                                    ->whereHas('jurnal', function($query) use($user) {
                                        $query->where('periode_id', $user->periode)->where('unit_id', $user->unit_id);
                                    })->count();
        $absensitoday = DetailJurnal::with('jurnal')
                                    ->whereHas('jurnal', function($query) use($user) {
                                        $query->where('jm_tanggal', Carbon::today())->where('unit_id', $user->unit_id);
                                    })->count();
        $pelanggarantotal = Pelanggaran::where('unit_id',$user->unit_id)->where('periode_id',$user->periode)->count();
        $pelanggarantoday = Pelanggaran::where('pelanggaran_tanggal', Carbon::today())->where('unit_id',$user->unit_id)
                                         ->count();//->with('siswa')->get();
        $jurnaltotal = Jurnal::where('unit_id',$user->unit_id)->where('periode_id',$user->periode)->count();
        $jurnaltoday = Jurnal::where([['jm_tanggal', Carbon::today()],['jm_status','!=',2]])
                                ->where('unit_id',$user->unit_id)
                                // ->with(['kelas' => function ($query) {
                                //     $query->orderBy('kelas_nama','ASC');
                                // }])
                                //->orderBy('jm_jampel','ASC')
                                ->count();
        $kerusakan = LaporSarpras::where([['ls_kategori','Kerusakan'],['ls_status','!=',2]])->where('unit_id',$user->unit_id);
        $jumlahKerusakan = $kerusakan->count();
        //$kerusakanDetail = $kerusakan->get();
        $pengumuman = Pengumumans::with('user')->orderBy('created_at','DESC')->get();

        $statistik['absensitotal'] = $absensitotal;
        $statistik['absensitoday'] = $absensitoday;
        $statistik['pelanggarantotal'] = $pelanggarantotal;
        $statistik['pelanggarantoday'] = $pelanggarantoday;
        $statistik['jurnaltotal'] = $jurnaltotal;
        $statistik['jurnaltoday'] = $jurnaltoday;
        $statistik['jumlahKerusakan'] = $jumlahKerusakan;
        //$statistik['kerusakanDetail'] =$kerusakanDetail;
        $statistik['pengumuman'] = $pengumuman;

        //return response()->json(['status' => 'success', 'data' => $statistik], 200);
        return new FrontCollection($statistik);
    }
}
