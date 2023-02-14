<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\AbsensiCollection;
use App\Absensi;
use App\Siswa;
use App\User;
use App\Kelas;
use App\KelasAnggota;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        /*if (request()->q != '') {
            $q = $request->q;
            $absensis = Absensi::with(['siswa','user','approve'])->whereHas('siswa', function($query) use($q){
                $query->where('siswa_nama','like','%'.$q.'%');
            });
        } else {*/
            $user = $request->user();

            $absensis = Absensi::with(['creator','approve','editor'])
                                ->with(['siswa' => function ($query) {
                                            $query->select('id', 's_nama', 'uuid');
                                        }])
                                ->where('unit_id', $user->unit_id)
                                ->where('periode_id', $user->periode)
                                ->orderBy('created_at', 'DESC');

            if (request()->q != '') {
                $q = request()->q;
                $absensis = $absensis->where(function ($query) use ($q) {
                                        $query->whereHas('siswa', function($query) use($q){
                                                    $query->where('s_nama','like','%'.$q.'%');
                                                });
                                });
            }

            if (request()->kelas != '') {
                $k = request()->kelas;
                $filterkelas = Kelas::where('kelas_nama',$k)->where('periode_id',$user->periode)->value('id');
                $anggotakelas = KelasAnggota::where('kelas_id',$filterkelas)->where('periode_id',$user->periode)->pluck('siswa_id');
                $absensis = $absensis->whereIn('siswa_id',$anggotakelas);
            }

            $absensis=$absensis->paginate(40);
            foreach ($absensis as $row){
                $kelas = KelasAnggota::where('siswa_id',$row->siswa->id)->where('periode_id',$user->periode)->first();
                $row['kelas'] = $kelas?Kelas::where('id',$kelas['kelas_id'])->value('kelas_nama'):'-';
                $row['absen'] = $kelas?$kelas['absen']:'-';
                // $absen = AbsensiPtm::where('siswa_id',$row->siswa_id)->where('aptm_tanggal', Carbon::today())->first();
                // $row['status'] = $absen?$absen->aptm_status:'Daring';
                // $row['absensi'] = $absen?$absen:'-';
                // if($absen){
                //     $row['distance'] = $absen->aptm_lat?$this->distance($absen->aptm_lat, $absen->aptm_lng, -7.282205, 112.684897, "K"):null;
                // } else {
                //     $row['distance'] = null;
                // }

            }
        //}

        /*$user = $request->user();
        if($user->role != 0){
            $absensis = $absensis->where('user_id',$user->id);
        }*/
        return new AbsensiCollection($absensis);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'siswa_id' => 'required',
            'absensi_tanggal' => 'required|date',
            'absensi_jenis' => 'required|string|max:150'
        ]);
        $user = $request->user();

        $begin = $request->absensi_tanggal;
        $end   = $request->absensi_enddate?$request->absensi_enddate:$request->absensi_tanggal;
        $period = CarbonPeriod::create($begin, $end)->filter('isWeekday');
        foreach($period as $date){
            $getAB = Absensi::orderBy('id', 'DESC');
            $rowCount = $getAB->count();
            $lastId = $getAB->first();

            if($rowCount==0) {
                $kode = "AB".date('y').date('m').date('d')."001";
            } else {
                if(substr($lastId->absensi_kode,2,6) == date('y').date('m').date('d')) {
                $counter = (int)substr($lastId->absensi_kode,-3) + 1 ;
                    if($counter < 10) {
                        $kode = "AB".date('y').date('m').date('d')."00".$counter;
                    } elseif ($counter < 100) {
                        $kode = "AB".date('y').date('m').date('d')."0".$counter;
                    } else {
                        $kode = "AB".date('y').date('m').date('d').$counter;
                    }
                } else {
                    $kode = "AB".date('y').date('m').date('d')."001";
                }
            }
            Absensi::create([
                'absensi_kode' => $kode,
                'siswa_id' => $request->siswa_id['id'],
                'absensi_tanggal' => $date,
                'absensi_jenis' => $request->absensi_jenis,
                'absensi_keterangan' => $request->absensi_keterangan,
                'created_by' => $user->id,
                'unit_id' => $user->unit_id,
                'periode_id' => $user->periode,
                'ab_status' => "Issued"
            ]);
        }


        return response()->json(['status' => 'success'], 200);
    }

    public function view($id)
    {
        $absensi = Absensi::whereAbsensi_kode($id)->first();
        return response()->json(['status' => 'success', 'data' => $absensi], 200);
    }

    public function edit($id)
    {
        $absensi = Absensi::with('siswa')->whereAbsensi_kode($id)->first();
        return response()->json(['status' => 'success', 'data' => $absensi], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'siswa_id' => 'required',
            'absensi_tanggal' => 'required|date',
            'absensi_jenis' => 'required|string|max:150'
        ]);

        $user = $request->user();
        $absensi = Absensi::whereAbsensi_kode($request->absensi_kode);
        $absensi->update(['siswa_id' => $request->siswa_id['id'],
                        'absensi_tanggal' => $request->absensi_tanggal,
                        'absensi_jenis' => $request->absensi_jenis,
                        'absensi_keterangan' => $request->absensi_keterangan,
                        'updated_by' => $user->id]);
        return response()->json(['status' => 'success']);
    }

    public function destroy($id)
    {
        $absensi = Absensi::find($id);
        $absensi->delete();
        return response()->json(['status' => 'success'], 200);
    }

    public function denies_test(Request $request){
        $q = '';
        if($request->has('q')){
            $q = $request->q;
        }
        $absensis = Absensi::with('siswa')->whereHas('siswa', function($query) use($q){
            $query->where('siswa_nama','like','%'.$q.'%');
        })->get();
        return response()->json($absensis);
    }

    public function changeStatus(Request $request, $kode) {
        $user = $request->user();
        $ab = Absensi::whereAbsensi_kode($kode)->first();
        if($request->status=="Approved"){
            $ab->update(['ab_status' => $request->status,
                         'approve_by' => $user->id,
                         'approve_at' => date('d-m-y H:i'),]);
        }
        if($request->status=="Issued"){
            $ab->update(['ab_status' => $request->status,
                         'approve_by' => null,
                         'approve_at' => null]);
        }
        return response()->json(['status' => 'success'], 200);
    }
}
