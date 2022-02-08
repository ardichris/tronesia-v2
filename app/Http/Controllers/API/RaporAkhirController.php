<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\RaporAkhirsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\RaporAkhirCollection;
use App\RaporAkhir;
use App\Kelas;
use App\KelasAnggota;
use App\Siswa;

class RaporAkhirController extends Controller
{
    public function import(Request $request)
    {
         
        // $request->validate([
        //     'import_file' => 'required|file|mimes:xls,xlsx'
        // ]);
        $user = $request->user();
        $path = $request->file('import_file');
        $rapor['periode'] = $user->periode;
        $rapor['user'] = $user->id;
        $rapor['unit'] = $user->unit_id;
        $data = Excel::import(new RaporAkhirsImport($rapor), $path);

        return response()->json(['message' => 'uploaded successfully'], 200);
    }

    public function index(Request $request) {
        $user = $request->user();
                                    
        $raporakhirs = RaporAkhir::where('periode_id',$user->periode)
                                    ->where('unit_id',$user->unit_id)
                                    ->orderBy('ra_walikelas', 'ASC')
                                    ->select('id','ra_tanggal','ra_walikelas','siswa_id')
                                    ->with(['siswa' => function ($query) {
                                        $query->select('id','s_nama');
                                    }]);
                                    
        $raporakhirs=$raporakhirs->paginate(40);
        foreach ($raporakhirs as $row){
            $kelas = KelasAnggota::where('siswa_id',$row->siswa->id)->where('periode_id',$user->periode)->first();
            $row['kelas'] = $kelas?Kelas::where('id',$kelas['kelas_id'])->value('kelas_nama'):'-';
            $row['absen'] = $kelas?$kelas['absen']:'-';
        }
        
        return new RaporAkhirCollection($raporakhirs);
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
