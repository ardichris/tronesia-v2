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
use PDF;


class RaporAkhirController extends Controller
{
    public function raporSisipanView(Request $request)
    {
        $user = $request->user();
        $raporSisipan = RaporSisipan::whereId($request->uuid)->with('siswa')->first();
        $raporSisipan['kelas'] = KelasAnggota::whereSiswa_id($raporSisipan['siswa']['id'])->with('kelas')->first();
        $raporSisipan['user'] = User::whereId($user->id)->first();
        return response()->json(['message' => 'success', 'data' => $raporSisipan], 200);
        
    }
    
    public function raporSisipanPDF(Request $request)
    {
        $user = $request->user;
        $idSisipan = $request->rapor;
        $raporSisipan = RaporSisipan::whereId($idSisipan)->with('siswa')->first();
        $raporSisipan['user'] = User::whereId($user)->first();
        $raporSisipan['kelas'] = KelasAnggota::whereSiswa_id($raporSisipan['siswa']['id'])->with('kelas')->first();
        $studentCode = Siswa::whereId($raporSisipan->siswa_id)->value('s_code');
        $pdf = PDF::loadView('sisipan', compact('raporSisipan'))->setPaper([0, 0, 612.283, 935.433], 'portrait');
        return $pdf->stream($studentCode.".pdf");
        
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

        $kelas = Kelas::whereKelas_wali($user->id)->value('id');
        $kelasAnggota = KelasAnggota::whereKelas_id($kelas)
                                    ->wherePeriode_id($user->periode)
                                    ->with(['siswa' => function ($query) {
                                        $query->select('id','s_nama','uuid');
                                      }])
                                    ->paginate(40);
                                    
        foreach ($kelasAnggota as $row){
            $raporSisipan = RaporSisipan::where('siswa_id',$row->siswa->id)->where('periode_id',$user->periode)->select('id')->first();
            $raporAkhir = RaporAkhir::where('siswa_id',$row->siswa->id)->where('periode_id',$user->periode)->select('id')->first();
            $row['RaporSisipan'] = $raporSisipan?$raporSisipan:'-';
            $row['RaporAkhir'] = $raporAkhir?$raporAkhir:'-';
        }                            
        // $raporakhirs = RaporAkhir::where('periode_id',$user->periode)
        //                             ->where('unit_id',$user->unit_id)
        //                             ->orderBy('ra_walikelas', 'ASC')
        //                             ->select('id','ra_tanggal','ra_walikelas','siswa_id')
        //                             ->with(['siswa' => function ($query) {
        //                                 $query->select('id','s_nama');
        //                             }]);
                                    
        // $raporakhirs=$raporakhirs->paginate(40);
        // foreach ($raporakhirs as $row){
        //     $kelas = KelasAnggota::where('siswa_id',$row->siswa->id)->where('periode_id',$user->periode)->first();
        //     $row['kelas'] = $kelas?Kelas::where('id',$kelas['kelas_id'])->value('kelas_nama'):'-';
        //     $row['absen'] = $kelas?$kelas['absen']:'-';
        // }
        
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
