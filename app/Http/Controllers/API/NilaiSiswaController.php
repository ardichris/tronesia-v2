<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\NilaiSiswa;
use App\Siswa;
use App\Kelas;
use App\Kompetensi;
use App\Mapel;
use App\Http\Resources\NilaiSiswaCollection;

class NilaiSiswaController extends Controller
{
    public function index(Request $request) {
        $user = $request->user();
        $nilaisiswa = Siswa::where('kelas_id', request()->kelas)
                            ->select('s_nama','id')
                            ->orderBy('s_nama','ASC')
                            ->get();
        
        foreach($nilaisiswa as $key=>$row){
            $nilai = NilaiSiswa::where('siswa_id',$row->id)
                                ->where('mapel_id', request()->mapel)
                                ->where('ns_jenis_nilai', request()->jenis)
                                ->where('kompetensi_id', request()->kd)
                                ->where('periode_id', $user->periode)
                                ->value('ns_nilai');
            $nilaisiswa[$key]['nilai'] = $nilai;
            //$row = array("nilai" => $nilai->ns_nilai);
        }
        //return response()->json(['status' => 'success', 'data' => 'data'], 200);

        return response()->json(['status' => 'success', 'data' => $nilaisiswa], 200);
    }
    
    // public function index(Request $request) {
    //     $user = $request->user();
    //     $pengetahuan = array('PHS','TGS');
    //     $ketrampilan = array('PRK','PRD','PRY','PRT');
    //     $jenis = request()->jenis;
    //     $mapel = Mapel::where('id', request()->mapel)->first();
    //     $kelas = Kelas::where('id', request()->kelas)->first();
    //     $nilaisiswa['mapel'] = $mapel;
    //     $nilaisiswa['mapelkode'] = $mapel->mapel_kode;
    //     $nilaisiswa['kelas'] = $kelas;
    //     $nilaisiswa['kelasnama'] = $kelas->kelas_nama;
    //     $nilaisiswa['jenis'] = $jenis;
    //     $nilaisiswa['siswa'] = Siswa::where('kelas_id', request()->kelas)
    //                                 ->select('s_nama','id')
    //                                 ->orderBy('s_nama','ASC')
    //                                 ->get();
    //     if(in_array($jenis,$pengetahuan)){
    //         $sort = '3.';
    //     } elseif(in_array($jenis,$ketrampilan)){
    //         $sort = '4.';
    //     } else {
    //         $sort = null;
    //     };
    //     $kompetensi = Kompetensi::where('kompetensi_mapel', $mapel->mapel_kode)
    //                             ->where('kompetensi_jenjang', $kelas->kelas_jenjang);
    //     if(!is_null($sort)){
    //         $kompetensi = $kompetensi->where('kd_kode', 'like', $sort.'%');
    //         $komp = $kompetensi->get();
    //         $nilaisiswa['kompetensi'] = $kompetensi->select('id','kd_kode')->get(); 
    //     } else {
    //         $nilaisiswa['kompetensi'] = ['PTS','PAS'];
    //     }    
    //     foreach ($nilaisiswa['siswa'] as $row) {
    //         $count = 0;
    //         $nilai = NilaiSiswa::where('siswa_id',$row->id)
    //                             ->select('ns_nilai')
    //                             ->where('unit_id',$user->unit_id)
    //                             ->where('periode_id',$user->periode);
    //             if (is_null($sort)){
    //                 $ptspas = array('PTS','PAS');
    //                 $row['nilai'] = $kompetensi->take(2)->get();                    
    //                 foreach ($ptspas as $rowptspas) {                    
    //                     $nilaiptspas = $nilai->where('ns_jenis_nilai',$rowptspas)
    //                                         ->where('mapel_id',request()->mapel)->first();                   
    //                     if(is_null($nilaiptspas)) {
    //                         $nilaiptspas = "";
    //                     };
    //                     $row['nilai'][$count] = ['ns_nilai' => $nilaiptspas];
    //                     $count = $count+1;
    //                 }                    
    //             } else {
    //                 $row['nilai'] = $kompetensi->pluck('kd_kode');
    //                 foreach ($komp as $rowkomp) { 
    //                     $nilai = NilaiSiswa::where('siswa_id',$row->id)
    //                                     ->select('ns_nilai')
    //                                     ->where('unit_id',$user->unit_id)
    //                                     ->where('periode_id',$user->periode)   
    //                                     ->where('ns_jenis_nilai',$jenis)
    //                                     ->where('kompetensi_id', $rowkomp['id']);           
    //                     $row['nilai'][$count] = $nilai->first();
    //                     if(is_null($row['nilai'][$count])) {
    //                         $row['nilai'][$count] = array('ns_nilai' => "");
    //                     };
    //                     $count = $count+1;
    //                 };
    //             }
    //         }; 
    //     return response()->json(['status' => 'success', 'data' => $nilaisiswa], 200);
    // }
    
    public function store(Request $request){

        $this->validate($request, [
                 'siswa' => 'required'
             ]);
        $user = $request->user();
        foreach( $request->siswa as $rowsiswa){
            $count=0;
            if ($request->jenis != 'PTSPAS') {
                foreach( $rowsiswa['nilai'] as $rownilai){                
                    $nilai = NilaiSiswa::where('siswa_id',$rowsiswa['id'])
                                        ->where('mapel_id',$request->mapel['id'])
                                        ->where('kompetensi_id',$request->kompetensi[$count]['id'])
                                        ->where('ns_jenis_nilai',$request->jenis)
                                        ->where('periode_id',$user->periode)
                                        ;
                    $cek = $nilai->count();
                    if($cek == 0 && $rownilai['ns_nilai'] != ''){
                    //return response()->json(['status' =>  $request->kompetensi[$count]['id']], 200);
                        NilaiSiswa::create(['siswa_id' => $rowsiswa['id'],
                                            'ns_nilai' => $rownilai['ns_nilai'],
                                            'mapel_id' => $request->mapel['id'],
                                            'kompetensi_id' => $request->kompetensi[$count]['id'],
                                            'ns_jenis_nilai' => $request->jenis,
                                            'periode_id' => $user->periode,
                                            'user_id' => $user->id,
                                            'unit_id' => $user->unit_id,]);

                    } else {
                        $nilai->update(['ns_nilai' => $rownilai['ns_nilai']]);
                                                                    
                    }
                    $count = $count + 1;
                }
            } else {
                foreach ($rowsiswa['nilai'] as $rownilai){
                    $nilai = NilaiSiswa::where('siswa_id',$rowsiswa['id'])
                                        ->where('mapel_id',$request->mapel['id'])
                                        ->where('ns_jenis_nilai',$request->kompetensi[$count])
                                        ->where('periode_id',$user->periode)
                                        ;
                    $cek = $nilai->count();
                    // $cekPTS = $nilai->where('ns_jenis_nilai','PTS')->count();
                    // $cekPAS = $nilai->where('ns_jenis_nilai','PAS')->count();
                    if ($cek == 0 && $rowsiswa['nilai'][0]['ns_nilai'] != '') {
                        NilaiSiswa::create(['siswa_id' => $rowsiswa['id'],
                                            'ns_nilai' => $rownilai['ns_nilai'],
                                            'mapel_id' => $request->mapel['id'],
                                            'ns_jenis_nilai' => $request->kompetensi[$count],
                                            'periode_id' => $user->periode,
                                            'user_id' => $user->id,
                                            'unit_id' => $user->unit_id,]);
                    } else {
                        $nilai->update(['ns_nilai' => $rownilai['ns_nilai']]);
                    }
                    $count = $count + 1;
                }
            }   
               
        }
        return response()->json(['status' => 'success'], 200);
    }

    
}
