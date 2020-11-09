<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PengumumanCollection;
use App\Pengumumans;
use Carbon\Carbon;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $pengumuman = Pengumumans::with('user');
        return new PengumumanCollection($pengumuman->paginate(10));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'p_title' => 'required',
            'p_isi' => 'required',
            'p_kategori' => 'required'
        ]);
        $user = $request->user();

        Pengumumans::create([
            'p_title' => $request->p_title,
            'p_isi' => $request->p_isi,
            'p_tanggal' => Carbon::now(),
            'P_kategori' => $request->p_kategori,
            'user_id' => $user->id
        ]);
        return response()->json(['status' => 'success']);
    }

    public function view($id)
    {
        $kitirsiswas = KitirSiswa::whereKitirSiswa_kode($id)->first();
        return response()->json(['status' => 'success', 'data' => $kitirsiswa], 200);
    }

    public function edit($id)
    {
        $kitirsiswas = KitirSiswa::with('siswa')->whereKs_kode($id)->first();
        return response()->json(['status' => 'success', 'data' => $kitirsiswas], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'siswa_id' => 'required',
            'ks_tanggal' => 'required|date',
            'ks_keterangan' => 'required',
            'ks_jenis' => 'required|string|max:150'
        ]);
        
        $user = $request->user();
        $kitirsiswa = KitirSiswa::whereKs_kode($request->ks_kode);
        $kitirsiswa->update([
                        'ks_tanggal' => $request->ks_tanggal,
                        'ks_jenis' => $request->ks_jenis,
                        'ks_keterangan' => $request->ks_keterangan,
                        'ks_status' => 0,
                        'creator_id' => $user->id,
                        'last_at' => date('d-m-y H:i'),
                        'approve_by' => null,
                        'approve_at' => null
                    ]);
        return response()->json(['status' => 'success']);
    }

    public function destroy($id)
    {
        $kitirsiswa = KitirSiswa::find($id);
        $kitirsiswa->delete();
        return response()->json(['status' => 'success'], 200);
    }

    public function changeStatus(Request $request,$kode) {
        $user = $request->user();
        $ks = KitirSiswa::whereKs_kode($kode)->first();
            $ks->update(['ks_status' => $request->status,
                         'approve_by' => $user->id,
                         'approve_at' => date('d-m-y H:i'),]);    
        return response()->json(['status' => 'success'], 200);
    }
}
