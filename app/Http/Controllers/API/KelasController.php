<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\KelasCollection;
use App\Kelas;
use App\User;
use App\Siswa;
use App\KelasAnggota;

class KelasController extends Controller
{
    public function getAnggota($id)
    {
        $anggota = Siswa::whereKelas_id($id)->orderBy('s_nama', 'ASC');
        return new KelasCollection($anggota->paginate(40));
    }
    
    public function tambahAnggota(Request $request)
    {
        return response()->json(['status' => 'success1'], 200);
        if (request()->key == 'tambahAnggotaKelas') {
            $siswa = Siswa::whereId(request()->siswa)->first();
            $siswa->update(['kelas_id'=> 11]);
        }
        return response()->json(['status' => 'success1'], 200);
    }
    
    public function index(Request $request) {
        $user = $request->user();
        $kelas = Kelas::with(['user'])->orderBy('kelas_nama', 'ASC')->where('unit_id', $user->unit_id);
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
        $user = $request->user();
        Kelas::create([
            'kelas_nama' => $request->kelas_nama,
            'kelas_jenjang' => $request->kelas_jenjang,
            'kelas_wali' => $request->kelas_wali['id'],
            'unit_id' => $user->unit_id,
        ]);
        return response()->json(['status' => 'success'], 200);
    }

    public function edit($id)
    {
        $kelas = Kelas::with(['user','siswa'])->whereId($id)->first();
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
