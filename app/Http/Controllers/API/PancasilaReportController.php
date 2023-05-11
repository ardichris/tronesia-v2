<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use App\PancasilaReport;
use App\PancasilaScore;
use App\KelasAnggota;
use App\PancasilaProject;
use App\PancasilaProjectElement;
use App\PancasilaElement;
use App\PancasilaComment;

class PancasilaReportController extends Controller
{
    public function index(Request $request){
        $user = $request->user();
        if(strlen($request->id)<30){
            $kelas = KelasAnggota::where('siswa_id', $request->id)
                                 ->where('periode_id', $user->periode)
                                 ->value('kelas_id');
            $pp = PancasilaProject::where('kelas_id', $kelas)
                                  ->where('periode_id', $user->periode)
                                //   ->with(['element' => function ($query) {
                                //     $query->with('element');
                                //     }])
                                  ->get();
            foreach($pp as $rowpp) {
                $ppe = PancasilaProjectElement::where('pp_id', $rowpp['id'])
                                              ->pluck('pe_id');
                $pe = PancasilaElement::whereIn('id', $ppe)->get();
                foreach($pe as $rowpe) {
                    $rowpe['score'] ='';
                }
                $rowpp['element'] = $pe;

            }
            return $pp;
        } else {
            $pr = PancasilaReport::where('id',$request->id)
                                 ->with(['siswa' => function ($query) {
                                        $query->select('id','s_nama', 's_nis');
                                    }])
                                 ->first();
            $pr['kelas'] = KelasAnggota::where('siswa_id', $pr['siswa_id'])
                                 ->where('periode_id', $user->periode)
                                 ->first();
            $pp = PancasilaProject::where('kelas_id', $pr['kelas']['id'])
                                  ->where('periode_id', $user->periode)
                                  ->get();

            foreach($pp as $rowpp) {
                $ppe = PancasilaProjectElement::where('pp_id', $rowpp['id'])
                                                ->pluck('pe_id');
                $pe = PancasilaElement::whereIn('id', $ppe)->get();
                foreach($pe as $rowpe) {
                    $rowpe['score'] = PancasilaScore::where('pp_id',$rowpp['id'])
                                                    ->where('pe_id', $rowpe['id'])
                                                    ->where('siswa_id',$pr['siswa_id'])
                                                    ->value('ps_score');
                }
                $rowpp['element'] = $pe;
            }
        }


    }

    public function update(Request $request, $id){
        $user = $request->user();
        if(strlen($id)<30) {
            $pr = PancasilaReport::create([
                                    'id' => Uuid::Uuid4(),
                                    'siswa_id' => $id,
                                    'periode_id' => $user->periode,
                                    'unit_id' =>  $user->unit_id,
                                    'creator_id' =>  $user->id,
                                    'updater_id' =>  $user->id,
                                ]);
        } else {
            $pr = PancasilaReport::where('id',$id)->first();
            $pr->update([
                            'updater_id' =>  $user->id,
                        ]);
            $id = $pr['siswa_id'];
            //return response()->json(['status' => 'success'],200);
        }

        foreach($request->pr_project as $rowpp){
            foreach($rowpp['element'] as $rowpe){
                if($rowpe['score']){
                    $cek = PancasilaScore::where('siswa_id',$id)
                                        ->where('periode_id',$user->periode)
                                        ->where('pp_id',$rowpp['id'])
                                        ->where('pe_id',$rowpe['id']);
                    if($cek->count()==0){
                        $pe = PancasilaScore::create([
                                                'pp_id' => $rowpp['id'],
                                                'pe_id' => $rowpe['id'],
                                                'ps_score' => $rowpe['score'],
                                                'siswa_id' => $id,
                                                'periode_id' => $user->periode,
                                                'creator_id' =>  $user->id,
                                                'updater_id' =>  $user->id,
                                            ]);
                    } else {
                        $pe = $cek->update([
                                        'ps_score' => $rowpe['score'],
                                        'updater_id' =>  $user->id,
                                    ]);
                    }

                }
            }
        }

        return response()->json(['status' => 'success'],200);
    }

    public function edit(Request $request, $id){
        $user = $request->user();
        $pr = PancasilaReport::where('id',$id)
                                ->with(['siswa' => function ($query) {
                                    $query->select('id','s_nama', 's_nis');
                                }])
                                ->first();
        $pr['kelas'] = KelasAnggota::where('siswa_id', $pr['siswa_id'])
                                ->where('periode_id', $user->periode)
                                ->with(['kelas' => function ($query) {
                                    $query->where('k_jenis','REGULER');
                                }])
                                ->first();
        $pp = PancasilaProject::where('kelas_id', $pr['kelas']['kelas_id'])
                                ->where('periode_id', $user->periode)
                                ->get();


        foreach($pp as $rowpp) {
            $ppe = PancasilaProjectElement::where('pp_id', $rowpp['id'])
                                            ->pluck('pe_id');
            $pe = PancasilaElement::whereIn('id', $ppe)->get();
            $pc = PancasilaComment::where('siswa_id', $pr['siswa_id'])
                                  ->where('pp_id', $rowpp['id'])
                                  ->value('pc_comment');
            $rowpp['comment'] = $pc;
            foreach($pe as $rowpe) {
                $rowpe['score'] = PancasilaScore::where('pp_id',$rowpp['id'])
                                                ->where('pe_id', $rowpe['id'])
                                                ->where('siswa_id',$pr['siswa_id'])
                                                ->value('ps_score');
            }
            $rowpp['element'] = $pe;
        }
        $pr['pr_project'] = $pp;

        return response()->json(['status'=>'success','data'=>$pr],200);
    }

    public function viewRapor(Request $request, $id){
        $user = $request->user();
        $pr = PancasilaReport::where('id',$id)
                                ->with(['siswa' => function ($query) {
                                    $query->select('id','s_nama', 's_nis');
                                }])
                                ->first();
        $pr['kelas'] = KelasAnggota::where('siswa_id', $pr['siswa_id'])
                                ->where('periode_id', $user->periode)
                                ->with(['kelas' => function ($query) {
                                    $query->where('k_jenis','REGULER');
                                }])
                                ->first();
        $pp = PancasilaProject::where('kelas_id', $pr['kelas']['kelas_id'])
                                ->where('periode_id', $user->periode)
                                ->with(['comment' => function ($query) use ($pr){
                                    $query->where('siswa_id',$pr['siswa_id'])->value('pc_comment');
                                }])
                                ->get();

        foreach($pp as $rowpp) {
            $ppe = PancasilaProjectElement::where('pp_id', $rowpp['id'])
                                            ->pluck('pe_id');
            $pe = PancasilaElement::whereIn('id', $ppe)->get();
            foreach($pe as $rowpe) {
                $rowpe['score'] = PancasilaScore::where('pp_id',$rowpp['id'])
                                                ->where('pe_id', $rowpe['id'])
                                                ->where('siswa_id',$pr['siswa_id'])
                                                ->value('ps_score');
            }
            $element = [];
            $dimension = ['Bergotong Royong',
                          'Beriman, Bertakwa Kepada Tuhan Yang Maha Esa dan Berakhlak Mulia',
                          'Berkebhinekaan Global',
                          'Bernalar Kritis',
                          'Kreatif',
                          'Mandiri'];
            foreach($dimension as $index=>$rowelement){
                $pe_cek = PancasilaElement::whereIn('id', $ppe)
                                          ->with(['score' => function ($query) use ($rowpp,$pr) {
                                                $query->where('pp_id',$rowpp['id'])
                                                      ->where('siswa_id',$pr['siswa']['id']);
                                             }])
                                          ->where('pe_dimension',$rowelement);
                $pe_count = $pe_cek->count();
                if($pe_count>0){
                    array_push($element,$pe_cek->get());
                } else {
                    array_push($element,null);
                }

            }
            $rowpp['element'] = $element;
            //$rowpp['element']->dimensi1 = '1';//$pe->where('pe_dimension','Bergotong Royong');
        }
        $pr['pr_project'] = $pp;

        return response()->json(['status'=>'success','data'=>$pr],200);
    }
}
