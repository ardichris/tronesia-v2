<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\AbsensiCollection;
use App\Absensi;
use App\Siswa;
use App\User;

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
            $absensis = Absensi::with('siswa')->orderBy('created_at', 'DESC');
        //}
        
        /*$user = $request->user();
        if($user->role != 0){
            $absensis = $absensis->where('user_id',$user->id);
        }*/
        return new AbsensiCollection($absensis->paginate(10));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'siswa_id' => 'required',
            'absensi_tanggal' => 'required|date',
            'absensi_jenis' => 'required|string|max:150'
        ]);
        $user = $request->user();
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
            'absensi_tanggal' => $request->absensi_tanggal,
            'absensi_jenis' => $request->absensi_jenis,
            'absensi_keterangan' => $request->absensi_keterangan,
            'user_id' => $user->id
        ]);
        return response()->json(['status' => 'success']);
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
                        'user_id' => $user->id]);
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
        //wkwkwkwkw piye yaw... ora nemu2 ket biyen kae
        //ya wis kodingku iki disave sik. aq tak golek inspirasi karo mangan lunch.
        //oke siap
    }
}
