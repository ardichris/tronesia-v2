<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\RaporPetra;
use App\Kelas;
use App\KelasAnggota;
use App\DeskripsiRaporpetra;
use App\Siswa;
use App\User;
use App\Periode;
use Ramsey\Uuid\Uuid;

class RaporPetraController extends Controller
{
    public function update(Request $request, $id){
        $user = $request->user();
                if($id == 'add'){
                    $add = RaporPetra::create([
                            'id'  => Uuid::Uuid4(),
                            'siswa_id' => $request->siswa_id,
                            'periode_id' => $user->periode,
                            'unit_id' =>  $user->unit_id,
                            'user_id' =>  $user->id,
                            'rp_pone_score' => $request->rp_pone_score,
                            'rp_ptwo_score' => $request->rp_ptwo_score,
                            'rp_pthree_score' => $request->rp_pthree_score,
                            'rp_physical_score' => $request->rp_pone_score.$request->rp_ptwo_score.$request->rp_pthree_score,
                            'rp_eone_score' => $request->rp_eone_score,
                            'rp_etwo_score' => $request->rp_etwo_score,
                            'rp_ethree_score' => $request->rp_ethree_score,
                            'rp_efour_score' => $request->rp_efour_score,
                            'rp_emotional_score' => $request->rp_eone_score.$request->rp_etwo_score.$request->rp_ethree_score.$request->rp_efour_score,
                            'rp_tone_desc' => $request->rp_tone_desc,
                            'rp_ttwo_desc' => $request->rp_ttwo_desc,
                            'rp_talent_score' => $request->rp_talent_score,
                            'rp_rone_score' => $request->rp_rone_score,
                            'rp_rtwo_score' => $request->rp_rtwo_score,
                            'rp_rthree_score' => $request->rp_rthree_score,
                            'rp_rfour_score' => $request->rp_rfour_score,
                            'rp_religious_score' => $request->rp_rone_score.$request->rp_rtwo_score.$request->rp_rthree_score.$request->rp_rfour_score,
                            'rp_academic_score' => $request->rp_academic_score,
                             ]);
                    $id = $add->id;
                } else {
                    $cekdata = RaporPetra::where('id',$id)->where('periode_id', $user->periode)->first();
                    $cekdata->update([  'rp_pone_score' => $request->rp_pone_score,
                                        'rp_ptwo_score' => $request->rp_ptwo_score,
                                        'rp_pthree_score' => $request->rp_pthree_score,
                                        'rp_eone_score' => $request->rp_eone_score,
                                        'rp_etwo_score' => $request->rp_etwo_score,
                                        'rp_ethree_score' => $request->rp_ethree_score,
                                        'rp_efour_score' => $request->rp_efour_score,
                                        'rp_tone_desc' => $request->rp_tone_desc,
                                        'rp_ttwo_desc' => $request->rp_ttwo_desc,
                                        'rp_talent_score' => $request->rp_talent_score,
                                        'rp_rone_score' => $request->rp_rone_score,
                                        'rp_rtwo_score' => $request->rp_rtwo_score,
                                        'rp_rthree_score' => $request->rp_rthree_score,
                                        'rp_rfour_score' => $request->rp_rfour_score,
                                        'rp_academic_score' => $request->rp_academic_score,
                                        'rp_physical_score' => $request->rp_pone_score.$request->rp_ptwo_score.$request->rp_pthree_score,
                                        'rp_emotional_score' => $request->rp_eone_score.$request->rp_etwo_score.$request->rp_ethree_score.$request->rp_efour_score,
                                        'rp_religious_score' => $request->rp_rone_score.$request->rp_rtwo_score.$request->rp_rthree_score.$request->rp_rfour_score,
                                    ]);
                }

                $score = RaporPetra::where('id',$id)->first();
                $physical='';$emotional='';$talent='';$religious='';$academic='';
                if(!is_null($request->rp_pone_score)&&!is_null($request->rp_ptwo_score)&&!is_null($request->rp_pthree_score)){
                    $physical = DeskripsiRaporpetra::where('kode',$request->rp_pone_score.$request->rp_ptwo_score.$request->rp_pthree_score)->value('deskripsi');
                }
                if(!is_null($request->rp_eone_score)&&!is_null($request->rp_etwo_score)&&!is_null($request->rp_ethree_score)&&!is_null($request->rp_efour_score)){
                    $emotional = DeskripsiRaporpetra::where('kode',$request->rp_eone_score.$request->rp_etwo_score.$request->rp_ethree_score.$request->rp_efour_score)->value('deskripsi');
                }
                if(!is_null($request->rp_rone_score)&&!is_null($request->rp_rtwo_score)&&!is_null($request->rp_rthree_score)&&!is_null($request->rp_rfour_score)){
                    $religious = DeskripsiRaporpetra::where('kode',$request->rp_rone_score.$request->rp_rtwo_score.$request->rp_rthree_score.$request->rp_rfour_score)->value('deskripsi');
                }
                if(!is_null($request->rp_talent_score)){
                    $talent = DeskripsiRaporpetra::where('kode',$request->rp_talent_score)->value('deskripsi');
                    if(!is_null($request->rp_ttwo_desc)){
                        $talent = $talent." ".$request->rp_tone_desc." dan ".$request->rp_ttwo_desc;
                    }else{
                        $talent = $talent." ".$request->rp_tone_desc;
                    }
                }
                if(!is_null($request->rp_academic_score)){
                    $academic = DeskripsiRaporpetra::where('kode', $request->rp_academic_score)->value('deskripsi');
                }
                $score->update(['rp_physical_desc' => $physical?$physical:null,
                                'rp_emotional_desc' => $emotional?$emotional:null,
                                'rp_talent_desc' => $talent?$talent:null,
                                'rp_religious_desc' => $religious?$religious:null,
                                'rp_academic_desc' => $academic?$academic:null]);

        return response()->json(['status' => 'success'], 200);

    }

    public function edit($id){
        $rapor = RaporPetra::whereId($id)->first();
        return response()->json(['status' => 'success', 'data' => $rapor], 200);
    }
}
