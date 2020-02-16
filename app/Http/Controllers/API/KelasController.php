<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\KelasCollection;
use App\Kelas;
use App\User;
use App\Siswa;

class KelasController extends Controller
{
    public function index(Request $request) {
        $kelas = Kelas::with(['user'])->orderBy('kelas_nama', 'ASC');
        if (request()->q != '') {
            $kelas = $kelas->where('kelas_nama', 'LIKE', '%' . request()->q . '%');
        }
        return new KelasCollection($kelas->paginate(10));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'kelas_nama' => 'required|string|unique:kelas,kelas_nama',
            'kelas_jenjang' => 'required'
        ]);

        Kelas::create([
            'kelas_nama' => $request->kelas_nama,
            'kelas_jenjang' => $request->kelas_jenjang,
            'kelas_wali' => $request->kelas_wali['id']
        ]);
        return response()->json(['status' => 'success'], 200);
    }

    public function edit($id)
    {
        $kelas = Kelas::with(['user','siswa'])->whereKelas_nama($id)->first();
        return response()->json(['status' => 'success', 'data' => $kelas], 200);
    }

    public function view($id)
    {
        $kelas = Kelas::whereKelas_nama($id)->first();
        return response()->json(['status' => 'success', 'data' => $kelas], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'kelas_jenjang' => 'required|string',
        ]);

        $kelas = Kelas::whereKelas_nama($id)->first();
        $kelas->update([
                'kelas_jenjang' => $request->kelas_jenjang,
                'kelas_wali' => $request->kelas_wali['id']
        ]);
        return response()->json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        $kelas = Kelas::find($id);
        $kelas->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
