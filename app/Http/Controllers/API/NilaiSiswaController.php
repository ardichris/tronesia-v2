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
        $pengetahuan = array('PHS','TGS');
        $ketrampilan = array('PRK','PRD','PRY','PRT');
        $jenis = request()->jenis;
        $mapel = Mapel::where('id', request()->mapel)->first();
        $kelas = Kelas::where('id', request()->kelas)->first();
        $nilaisiswa['siswa'] = Siswa::where('s_kelas', request()->kelas)->select('s_nama','id')->get();
        if(in_array($jenis,$pengetahuan)){
            $sort = '3.';
        } elseif(in_array($jenis,$ketrampilan)){
            $sort = '4.';
        } else {
            $sort = null;
        };
        $kompetensi = Kompetensi::where('kompetensi_mapel', $mapel->mapel_kode)
                                ->where('kompetensi_jenjang', $kelas->kelas_jenjang);
        if(!is_null($sort)){
            $kompetensi = $kompetensi->where('kd_kode', 'like', $sort.'%');
            $komp = $kompetensi->get();
            $nilaisiswa['kompetensi'] = $kompetensi->select('kd_kode')->get(); 
        } else {
            $nilaisiswa['kompetensi'] = ['PTS','PAS'];
        }    
        foreach ($nilaisiswa['siswa'] as $row) {
            $count = 0;
            $nilai = NilaiSiswa::where('siswa_id',$row->id)
                                    ->select('ns_nilai')
                                    ->where('unit_id',$user->unit_id)
                                    ->where('periode_id',$user->periode);
            if (is_null($sort)){
                //$row['nilai'] = array('PTS' => "-", 'PAS' => "-");
                //$row['nilai'][PTS] = 'tes';//$nilai->where('ns_jenis_nilai','PTS')->get();
                //$row['nilai']['PAS'] = $nilai->whereIn('ns_jenis_nilai','PAS')->get();
                //if(is_null($row['nilai'])) {
                //            $row['nilai'] = array('0' => "-", '1' => "-");
                //};
                $ptspas = array('PTS','PAS');
                $row['nilai'] = $kompetensi->take(2)->get();
                foreach ($ptspas as $rowptspas) {
                    $row['nilai'][$count] = $nilai->where('ns_jenis_nilai',$rowptspas)->first();
                    if(is_null($row['nilai'][$count])) {
                        $row['nilai'][$count] = ['ns_nilai' => "-"];
                    };
                    $count = $count+1;
                }
            } else {
                $row['nilai'] = $kompetensi->pluck('kd_kode');
                foreach ($komp as $rowkomp) { 
                    $nilai = NilaiSiswa::where('siswa_id',$row->id)
                                    ->select('ns_nilai')
                                    ->where('unit_id',$user->unit_id)
                                    ->where('periode_id',$user->periode)   
                                    ->where('ns_jenis_nilai',$jenis)
                                    ->where('kompetensi_id', $rowkomp['id']);           
                    $row['nilai'][$count] = $nilai->first();
                    if(is_null($row['nilai'][$count])) {
                        $row['nilai'][$count] = array('ns_nilai' => "-");
                    };
                    $count = $count+1;
                };
            }
        }; 
        return response()->json(['status' => 'success', 'data' => $nilaisiswa], 200);
    }
}
