<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\RaporAkhirsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\RaporAkhirCollection;

class RaporAkhirController extends Controller
{
    public function import(Request $request)
    {
         
        // $request->validate([
        //     'import_file' => 'required|file|mimes:xls,xlsx'
        // ]);

        $path = $request->file('import_file');
        $data = Excel::import(new RaporAkhirsImport, $path);

        return response()->json(['message' => 'uploaded successfully'], 200);
    }

    public function index(Request $request) {
        $raporakhirs = RaporAkhir::orderBy('id', 'ASC');
        
        return new RaporAkhirCollection($raporakhirs->paginate(10));
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
