<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\JamMengajarCollection;
use App\JamMengajar;
use App\JadwalPelajaran;
use App\User;

class JamMengajarController extends Controller
{

    public function jadwal(Request $request){
        return response()->json(['status' => 'success', 'data' => 'tes'], 200);

    }

    public function index(Request $request) {
        $user = $request->user();
        $q = request()->q;
        $jammengajars = JamMengajar::with('kelas','mapel','guru')->where('periode_id',$user->periode)
                        ->where('unit_id',$user->unit_id)
                        ->orderBy('created_at', 'DESC');
        if ($user->role != 0 || request()->jm == 'nilai'){
            $jammengajars= $jammengajars->where('guru_id',$user->id);
        }
        if(request()->kurikulum == 'kurmer'){
            $jammengajars = $jammengajars->where(function ($query) use ($q) {
                                                $query->whereHas('kelas', function($query) {
                                                            $query->where('kelas_jenjang',7);
                                                        });
                                            });
        } elseif(request()->kurikulum == 'kurtilas'){
            $jammengajars = $jammengajars->where(function ($query) use ($q) {
                $query->whereHas('kelas', function($query) {
                            $query->whereIn('kelas_jenjang',[8,9]);
                        });
            });
        }
        if (request()->q != '') {
            $jammengajars = $jammengajars->where(function ($query) use ($q) {
                                            $query->whereHas('kelas', function($query) use($q){
                                                        $query->where('kelas_nama','like','%'.$q.'%');
                                                    })
                                                    ->orwhereHas('guru', function($query) use($q){
                                                        $query->where('name','like','%'.$q.'%');
                                                    });
                                        });


        }
        return new JamMengajarCollection($jammengajars->paginate(40));
    }

    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'kelas' => 'required',
        //     'pengajar' => 'required',
        // ]);
        $user = $request->user();
        if($request->mengajar == []) {
            foreach ($request->pengajar as $row) {
                $konflik = JamMengajar::where('guru_id', $row['guru']['id'])
                                        ->where('kelas_id', $request->kelas['id'])
                                        ->where('mapel_id', $request->mapel['id'])
                                        ->where('periode_id', $user->periode)
                                        ->count();
                if($konflik == 0){
                    JamMengajar::create(['kelas_id' => $request->kelas['id'],
                                        'mapel_id' => $row['mapel']['id'],
                                        'guru_id' => $row['guru']['id'],
                                        'periode_id' => $user->periode,
                                        'unit_id' => $user->unit_id,
                                        'user_id' => $user->id,
                                        ]);
                }
            }
        } else {
            foreach ($request->mengajar as $row) {
                $konflik = JamMengajar::where('guru_id', $request->guru['id'])
                                        ->where('kelas_id', $row['kelas']['id'])
                                        ->where('mapel_id', $row['mapel']['id'])
                                        ->where('periode_id', $user->periode)
                                        ->count();
                if($konflik == 0){
                    JamMengajar::create(['guru_id' => $request->guru['id'],
                                        'mapel_id' => $row['mapel']['id'],
                                        'kelas_id' => $row['kelas']['id'],
                                        'periode_id' => $user->periode,
                                        'unit_id' => $user->unit_id,
                                        'user_id' => $user->id,
                                        ]);
                }
            }
        }
        return response()->json(['status' => 'success'], 200);
    }

    public function edit($id)
    {
        $jammengajar = JamMengajar::whereId($id)->with('kelas','mapel','guru')->first();
        return response()->json(['status' => 'success', 'data' => $jammengajar], 200);
    }

    public function view($id)
    {
        $jammengajar = JamMengajar::whereId($id)->first();
        return response()->json(['status' => 'success', 'data' => $jammengajar], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'kelas' => 'required',
            'guru' => 'required',
            'mapel' => 'required'
        ]);

        $jammengajar = JamMengajar::whereId($id)->first();
        $jammengajar->update([
            'kelas_id' => $request->kelas['id'],
            'mapel_id' => $request->mapel['id'],
            'guru_id' =>  $request->guru['id'],
        ]);
        return response()->json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        $jammengajar = JamMengajar::find($id);
        $jammengajar->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
