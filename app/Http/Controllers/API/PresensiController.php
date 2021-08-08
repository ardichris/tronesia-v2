<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PresensiCollection;
use App\DetailJurnal;
use App\Siswa;
use App\User;
use App\Kelas;
use App\JamMengajar;
use DB;

class PresensiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $presensis = DetailJurnal::with(['siswa','jurnal','siswa.kelas'])
                                    ->whereHas('jurnal', function($query) use($user){
                                        $query->where('unit_id',$user->unit_id);
                                    })
                                    ->whereHas('jurnal', function($query) use($user){
                                        $query->where('periode_id',$user->periode);
                                    })
                                    ->whereHas('jurnal', function($query){
                                                    $query->where('jm_status','<=', 1);
                                                })
                                    ->orderBy('created_at', 'DESC');
        if (request()->q != '') {
            $q = $request->q;
            $presensis = $presensis->where('alasan', 'LIKE', '%' . request()->q . '%')
                                    ->orwhereHas('siswa.kelas', function($query) use($q){
                                        $query->where('kelas_nama','like','%'.$q.'%');
                                    })
                                    ->orwhereHas('siswa', function($query) use($q){
                                        $query->where('s_nama','like','%'.$q.'%');
                                    });
        }
        $gurubk = JamMengajar::where('mapel_id',22)->where('guru_id',$user->id)->pluck('kelas_id');
        if($user->role==2){
            $presensis = $presensis->whereHas('siswa.kelas', function($query) use($user){
                                            $query->where('kelas_wali',$user->id);
                                            })
                                        ->orwhereHas('siswa.kelas', function($query) use($user){
                                            $query->where('k_mentor', $user->id);
                                            })
                                        ->orwhereHas('siswa', function($query) use($gurubk){
                                            $query->whereIn('kelas_id', $gurubk);
                                            });
        }
        return new PresensiCollection($presensis->paginate(10));
    }
}
