<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PelanggaranCollection;
use App\Pelanggaran;
use App\MasterPelanggaran;
use App\JamMengajar;
<<<<<<< HEAD
use App\User;
=======
>>>>>>> 97b73ced2c6e008bda7d1dfeb1dd057d3b8eb831
use DB;

class PelanggaranController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $pelanggarans = Pelanggaran::with(['siswa','user','jurnal','siswa.kelas','masterpelanggaran'])
                                    ->where('unit_id',$user->unit_id)
                                    ->where('periode_id',$user->periode)
                                    ->orderBy('created_at', 'DESC');
<<<<<<< HEAD
                                    
=======
>>>>>>> 97b73ced2c6e008bda7d1dfeb1dd057d3b8eb831
        if (request()->q != '') { 
            $q = request()->q;
            $pelanggarans = $pelanggarans->where(function ($query) use ($q) {
                                            $query  ->whereHas('siswa', function($query) use($q){
                                                        $query->where('s_nama','like','%'.$q.'%');
                                                        })
                                                    ->orWhere('pelanggaran_jenis','like','%'.$q.'%')
                                                    ->orWhere('pelanggaran_keterangan','like','%'.$q.'%');
                                                });                   
        }
        $gurubk = JamMengajar::where('mapel_id',22)->where('guru_id',$user->id)->pluck('kelas_id');
        if($user->role==2){
<<<<<<< HEAD
            $pelanggarans = $pelanggarans->where(function ($query) use ($gurubk, $user) {
                                            $query  ->whereHas('siswa.kelas', function($query) use($user){
                                                        $query->where('kelas_wali',$user->id);
                                                        })
                                                    ->orwhereHas('siswa.kelas', function($query) use($user){
                                                        $query->where('k_mentor', $user->id);
                                                        })
                                                    ->orwhereHas('siswa', function($query) use($gurubk){
                                                        $query->whereIn('kelas_id', $gurubk);
                                                        });
                                        });
=======
            $pelanggarans = $pelanggarans->whereHas('siswa.kelas', function($query) use($user){
                                            $query->where('kelas_wali',$user->id);
                                            })
                                        ->orwhereHas('siswa.kelas', function($query) use($user){
                                            $query->where('k_mentor', $user->id);
                                            })
                                        ->orwhereHas('siswa', function($query) use($gurubk){
                                            $query->whereIn('kelas_id', $gurubk);
                                            })
                                        ;
>>>>>>> 97b73ced2c6e008bda7d1dfeb1dd057d3b8eb831
        }
        
        return new PelanggaranCollection($pelanggarans->paginate(10));
    }
    
    public function store(Request $request)
    {
        //BUAT VALIDASI DATA
        $this->validate($request, [
            'siswa_id' => 'required',
            'pelanggaran_tanggal' => 'required|date',
            'mp_id' => 'required',
        ]);
        $getPL = Pelanggaran::orderBy('id', 'DESC');
        $rowCount = $getPL->count();
        $lastId = $getPL->first();

        if($rowCount==0) {
            $kode = "PL".date('y').date('m').date('d')."001";    
        } else {
            if(substr($lastId->pelanggaran_kode,2,6) == date('y').date('m').date('d')) {
            $counter = (int)substr($lastId->pelanggaran_kode,-3) + 1 ;
                if($counter < 10) {
                    $kode = "PL".date('y').date('m').date('d')."00".$counter;
                } elseif ($counter < 100) {
                    $kode = "PL".date('y').date('m').date('d')."0".$counter;
                } else {
                    $kode = "PL".date('y').date('m').date('d').$counter;
                }
            } else {
                $kode = "PL".date('y').date('m').date('d')."001";
            } 
        }
        $user = $request->user();
        Pelanggaran::create([
            'pelanggaran_kode' => $kode,
            'siswa_id' => $request->siswa_id['id'],
            'mp_id' => $request->mp_id['id'],
            'pelanggaran_tanggal' => $request->pelanggaran_tanggal,
            'pelanggaran_keterangan' => $request->pelanggaran_keterangan,
            'user_id' => $user->id,
            'unit_id' => $user->unit_id,
            'periode_id' => $user->periode
        ]);
        return response()->json(['status' => 'success']);
    }

    public function view($id)
    {
        $pelanggaran = Pelanggaran::wherePelanggaran_kode($id)->first();
        return response()->json(['status' => 'success', 'data' => $pelanggaran], 200);
    }

    public function edit($kode)
    {
        $pelanggaran = Pelanggaran::with(['siswa','user'])->wherePelanggaran_kode($kode)->first();
        return response()->json(['status' => 'success', 'data' => $pelanggaran], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'siswa_id' => 'required',
            'pelanggaran_tanggal' => 'required|date',
            'pelanggaran_jenis' => 'required|string|max:150'
        ]);
        $user = $request->user();
        $pelanggaran = Pelanggaran::wherePelanggaran_kode($request->pelanggaran_kode);
        $pelanggaran->update(['siswa_id' => $request->siswa_id['id'],
                              'mp_id' => $request->mp_id['id'],
                              'pelanggaran_tanggal' => $request->pelanggaran_tanggal,
                              'pelanggaran_keterangan' => $request->pelanggaran_keterangan,
                              'user_id' => $user->id,
                              'unit_id' => $user->unit_id,
                            ]);
        return response()->json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        $pelanggaran = Pelanggaran::find($id);
        $pelanggaran->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
