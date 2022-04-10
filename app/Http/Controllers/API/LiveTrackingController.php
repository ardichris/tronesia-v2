<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Siswa;
use App\AbsensiPtm;
use Carbon\Carbon;


class LiveTrackingController extends Controller
{
    public function requestLiveTracking(Request $request){
        $this->validate($request, [
            'studentcode' => 'required',
            'dob' => 'required',
        ]);
        $siswa = Siswa::where('s_code',$request->studentcode)->first(); 
        if($siswa['s_tanggal_lahir'] == $request->dob){
            $absensi = AbsensiPtm::where('siswa_id', $siswa['id'])->where('aptm_tanggal', Carbon::today())->value('uuid');
            return response()->json(['status' => 'success', 'uuid' => $absensi]); 
        } else {
            return response()->json(['status' => 'fail']); 
        }

    }

    public function updateLiveTracking(Request $request){
        $aptm = AbsensiPtm::where('uuid', $request->code)
                          ->update([
                              'aptm_lat' => $request->lat,
                              'aptm_lng' => $request->lng
                          ]);
        return response()->json(['status' => 'good']);
    }
}