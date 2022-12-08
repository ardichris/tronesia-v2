<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PembayaranPsb;
use App\Http\Resources\PenerimaanSiswaCollection;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PembayaransImport;


class PenerimaanSiswaController extends Controller
{
    public function indexPembayaran(Request $request){
        $user = $request->user();
        $pembayaran = PembayaranPsb::where('unit_id', $user->unit_id)->paginate(50);
        return new PenerimaanSiswaCollection($pembayaran);
    }

    public function importPembayaran(Request $request) {
        $request->validate([
            'import_file' => 'required|file|mimes:xls,xlsx'
        ]);

        $user = $request->user();
        $path = $request->file('import_file');
        $pembayaran['periode'] = $user->periode;
        $pembayaran['unit'] = $user->unit_id;
        $data = Excel::import(new PembayaransImport($pembayaran), $path);
        return response()->json(['message' => 'uploaded successfully'], 200);
    }
}
