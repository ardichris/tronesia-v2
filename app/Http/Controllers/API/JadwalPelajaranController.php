<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\JadwalPelajaran;
use App\JamMengajar;

class JadwalPelajaranController extends Controller
{
    public function index(Request $request){
        $kelas = request()->kelas;
        $rosterJP =   array("Monday" => null,
                            "Tuesday" => null,
                            "Wednesday" => null,
                            "Thursday" => null,
                            "Friday" => null,
                      );
        foreach($rosterJP as $key=>$value){
            //;
            for ($i = 0; $i < 10; ++$i){
                //$rosterJP[$key] = array($i => null);
                $rosterJP[$key][$i] =  JadwalPelajaran::with('guru','mapel')
                                                        ->where('kelas_id',$kelas)
                                                        ->where('jp_hari',$key)
                                                        ->where('jp_jampel',$i)
                                                        ->get();
            }
        }
        return response()->json(['status' => 'success', 'data' => $rosterJP],200);
    }

    public function store(Request $request)
    {       
        $this->validate($request, [
            'mapel' => 'required'
        ]);
        $user = $request->user();

        $cek = JamMengajar::where('kelas_id',$request->kelas['id'])
                            ->where('mapel_id',$request->mapel['id'])
                            ->where('periode_id', $user->periode)
                            ->select('guru_id')->first();
        
        if(!is_null($cek)){
            JadwalPelajaran::create(['guru_id' => $cek->guru_id,
                                'mapel_id' => $request->mapel['id'],
                                'kelas_id' => $request->kelas['id'],
                                'jp_hari' => $request->hari,
                                'jp_jampel' => $request->jampel,
                                'periode_id' => $user->periode,
                                'unit_id' => $user->unit_id,
                                'user_id' => $user->id,
            ]);
        }

        return response()->json(['status' => 'sukses','data' => $cek],200);
    }
}
