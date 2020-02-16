<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\KompetensiCollection;
use App\Kompetensi;

class KompetensiController extends Controller
{
    public function index(Request $request) {
        $kompetensis = Kompetensi::orderBy('created_at', 'DESC');
        if (request()->q != '') {
            $kompetensis = $kompetensis->where('kompetensi_deskripsi', 'LIKE', '%' . request()->q . '%');
        }
        if (request()->m != '') {
            $kompetensis = Kompetensi::where('kompetensi_mapel', 'LIKE', '%' . request()->m . '%')
                                        ->where('kompetensi_jenjang', 'LIKE', '%' . request()->j . '%')
                                        ->orderBy('kd_kode', 'ASC');
        }
        return new KompetensiCollection($kompetensis->paginate(50));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'kompetensi_mapel' => 'required',
            'kompetensi_jenjang' => 'required',
            'kd_kode' => 'required',
            'kompetensi_deskripsi' => 'required',

        ]);
        Kompetensi::create([
            'kompetensi_mapel' => $request->kompetensi_mapel['mapel_kode'],
            'kompetensi_jenjang' => $request->kompetensi_jenjang,
            'kd_kode' => $request->kd_kode,
            'kompetensi_deskripsi' => $request->kompetensi_deskripsi
        ]);
            return response()->json(['status' => 'success'], 200);
    }

    public function edit($id)
    {
        $kompetensi = Kompetensi::whereId($id)->first();
        return response()->json(['status' => 'success', 'data' => $kompetensi], 200);
    }

    public function view($id)
    {
        $kompetensi = Kompetensi::whereKompetensi_kode($id)->first();
        return response()->json(['status' => 'success', 'data' => $kompetensi], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'kompetensi_mapel' => 'required',
            'kompetensi_jenjang' => 'required',
            'kd_kode' => 'required',
            'kompetensi_deskripsi' => 'required',
        ]);

        $kompetensi = Kompetensi::whereId($id)->first();
        $kompetensi->update($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        $kompetensi = Kompetensi::find($id);
        $kompetensi->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
