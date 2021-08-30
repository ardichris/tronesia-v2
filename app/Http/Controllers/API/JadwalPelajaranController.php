<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\JadwalPelajaran;

class JadwalPelajaranController extends Controller
{
    public function index(Request $request){
        $kelas = request()->kelas;
        $rosterJP =   array("monday" => null,
                            "tuesday" => null,
                            "wednesday" => null,
                            "thursday" => null,
                            "friday" => null,
                      );
        foreach($rosterJP as $key=>$value){
            //;
            for ($i = 0; $i < 10; ++$i){
                //$rosterJP[$key] = array($i => null);
                $rosterJP[$key][$i] =  JadwalPelajaran::with('guru')
                                                        ->where('kelas_id',$kelas)
                                                        ->where('jp_hari',$key)
                                                        ->where('jp_jampel',$i)
                                                        ->get();
            }
        }
        return response()->json(['status' => 'success', 'data' => $rosterJP],200);
    }
}
