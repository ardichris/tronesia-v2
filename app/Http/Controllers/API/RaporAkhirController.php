<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\RaporAkhirsImport;
use App\Imports\RaporSisipansImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\RaporAkhirCollection;
use App\RaporAkhir;
use App\RaporSisipan;
use App\Kelas;
use App\KelasAnggota;
use App\Siswa;
use App\User;
use App\Periode;
use PDF;

function capitalize_after_delimiters($string)
    {
        preg_match_all("/\.\s*\w/", $string, $matches);

        foreach($matches[0] as $match){
            $string = str_replace($match, strtoupper($match), $string);
        }
        return $string;
    }

class RaporAkhirController extends Controller
{
    
    
    public function raporSisipanStore(Request $request, $id) {
        $this->validate($request, [
            'rs_catatan_ayat' => 'required|string',
            'rs_catatan_isi' => 'required|string'
        ]);

        $user = $request->user();
        $raporsisipan = RaporSisipan::whereId($id)
                                    ->update(['rs_catatan_ayat' => $request->rs_catatan_ayat,
                                                'rs_catatan_isi' => $request->rs_catatan_isi]);
        return response()->json(['status' => 'success'], 200);
    }
    
    public function raporSisipanView(Request $request)
    {
        $user = $request->user();
        $raporSisipan = RaporSisipan::whereId($request->uuid)
                                    ->with(['siswa' => function ($query) {
                                        $query->select('id','s_nama', 's_nis');
                                    }])->first();
                                    $raporSisipan['kelas'] = KelasAnggota::whereSiswa_id($raporSisipan['siswa']['id'])
                                    ->where('periode_id',$raporSisipan['periode_id'])
                                    ->with('kelas')
                                    ->first();
        $ttd = User::whereId($raporSisipan['kelas']['kelas']['kelas_wali'])->first();
        $raporSisipan['email'] = $ttd->email;
        $raporSisipan['ttd'] = $ttd->ttd;
        $raporSisipan['walikelas'] = $ttd->full_name;
        $raporSisipan['periode'] = Periode::whereId($raporSisipan['periode_id']);
        return response()->json(['message' => 'success', 'data' => $raporSisipan], 200);
        
    }
    
    public function raporSisipanPDF(Request $request)
    {
        $user = $request->user();
        $idSisipan = $request->rapor;
        $unit = $request->unit;
        $raporSisipan = RaporSisipan::whereId($idSisipan)
                                    ->with(['siswa' => function ($query) {
                                        $query->select('id','s_nama','s_nis','s_code');
                                    }])->first();
        $raporSisipan['kelas'] = KelasAnggota::whereSiswa_id($raporSisipan['siswa']['id'])
                                                ->where('periode_id',$raporSisipan['periode_id'])
                                                ->with('kelas')
                                                ->first();
        $ttd = User::whereId($raporSisipan['kelas']['kelas']['kelas_wali'])->first();
        $raporSisipan['rs_spiritual_deskripsi'] = ucfirst(capitalize_after_delimiters($raporSisipan['rs_spiritual_deskripsi'])).'.';
        $raporSisipan['rs_sosial_deskripsi'] = ucfirst(capitalize_after_delimiters($raporSisipan['rs_sosial_deskripsi'])).'.';
        $raporSisipan['email'] = $ttd->email;
        $raporSisipan['ttd'] = $ttd->ttd;
        $raporSisipan['walikelas'] = $ttd->full_name;
        $raporSisipan['periode'] = Periode::whereId($raporSisipan['periode_id']);
        //$studentCode = Siswa::whereId($raporSisipan->siswa_id)->value('s_code');
        $studentCode = $raporSisipan['siswa']['s_code'];
        if($unit == 1) {
            $pdf = PDF::loadView('sisipan', compact('raporSisipan'))->setPaper([0, 0, 612.283, 935.433], 'portrait');
            return $pdf->stream($studentCode.".pdf");
        }elseif($unit == 3) {
            $pdf = PDF::loadView('sisipanp2', compact('raporSisipan'))->setPaper([0, 0, 612.283, 935.433], 'portrait');
            return $pdf->stream($studentCode.".pdf");
        }
        
        
    }
    
    public function import(Request $request)
    {
         
        $request->validate([
            'import_file' => 'required|file|mimes:xls,xlsx'
        ]);

        $user = $request->user();
        $path = $request->file('import_file');
        $jenis = $request->rapor;
        $rapor['periode'] = $user->periode;
        $rapor['user'] = $user->id;
        $rapor['unit'] = $user->unit_id;
        if ($jenis=='akhir') {
            $data = Excel::import(new RaporAkhirsImport($rapor), $path);
        }
        if ($jenis=='sisipan') {
            $data = Excel::import(new RaporSisipansImport($rapor), $path);
        }
        return response()->json(['message' => 'uploaded successfully'], 200);
    }

    public function index(Request $request) {
        $user = $request->user();
        $unit = $user->unit_id;        
        $kelasAnggota = KelasAnggota::wherePeriode_id($user->periode)
                                    ->with('kelas')
                                    ->whereHas('kelas', function($query) use($unit){
                                        $query->where('unit_id', $unit);
                                    });
        if($user->role!=0){
            $kelas = Kelas::whereKelas_wali($user->id)->value('id');
            $kelasAnggota = $kelasAnggota->whereKelas_id($kelas);
        } 
        $kelasAnggota = $kelasAnggota->with(['siswa' => function ($query) {
                                        $query->select('id','s_nama','uuid');
                                      }]);
                                   
        if (request()->q != '') {
            $q = request()->q;
            $kelasAnggota = $kelasAnggota->where(function ($query) use ($q) {
                                            $query->whereHas('siswa', function($query) use($q){
                                                        $query->where('s_nama','like','%'.$q.'%');
                                                    });
                                            });
        }                            
        $kelasAnggota = $kelasAnggota->paginate(40);
        foreach ($kelasAnggota as $row){
            $raporSisipan = RaporSisipan::where('siswa_id',$row->siswa->id)->where('periode_id',$user->periode)->select('id')->first();
            $raporAkhir = RaporAkhir::where('siswa_id',$row->siswa->id)->where('periode_id',$user->periode)->select('id')->first();
            $row['RaporSisipan'] = $raporSisipan?$raporSisipan:'-';
            $row['RaporAkhir'] = $raporAkhir?$raporAkhir:'-';
        }                            

        return new RaporAkhirCollection($kelasAnggota);
    }

    // public function store(Request $request)
    // {
    //     $this->validate($request, [
    //         'raporakhir_kode' => 'required',
    //         'raporakhir_nama' => 'required|string'
    //     ]);

    //     RaporAkhir::create($request->all());
    //     return response()->json(['status' => 'success'], 200);
    // }

    // public function edit($id)
    // {
    //     $raporakhir = RaporAkhir::whereRaporAkhir_kode($id)->first();
    //     return response()->json(['status' => 'success', 'data' => $raporakhir], 200);
    // }

    // public function view($id)
    // {
    //     $raporakhir = RaporAkhir::whereRaporAkhir_kode($id)->first();
    //     return response()->json(['status' => 'success', 'data' => $raporakhir], 200);
    // }

    // public function update(Request $request, $id)
    // {
    //     $this->validate($request, [
    //         'raporakhir_kode' => 'required',
    //         'raporakhir_nama' => 'required|string',
    //     ]);

    //     $raporakhir = RaporAkhir::whereRaporAkhir_kode($id)->first();
    //     $raporakhir->update($request->except('RaporAkhir_kode'));
    //     return response()->json(['status' => 'success'], 200);
    // }

    // public function destroy($id)
    // {
    //     $raporakhir = RaporAkhir::find($id);
    //     $raporakhir->delete();
    //     return response()->json(['status' => 'success'], 200);
    // }
}
