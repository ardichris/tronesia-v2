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
        $pengumuman = Pengumumans::with('user')->orderBy('created_at','DESC');
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
            'p_kategori' => $request->p_kategori,
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
        $pengumuman = Pengumumans::whereId($id)->first();
        return response()->json(['status' => 'success', 'data' => $pengumuman], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'p_title' => 'required',
            'p_isi' => 'required',
            'p_kategori' => 'required'
        ]);
        $user = $request->user();

       $pengumuman = Pengumumans::whereId($request->id)->first();
       $pengumuman->update([
                            'p_title' => $request->p_title,
                            'p_isi' => $request->p_isi,
                            'p_kategori' => $request->p_kategori,
                            'user_id' => $user->id
                         ]);
        return response()->json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        $pengumuman = Pengumumans::find($id);
        $pengumuman->delete();
        return response()->json(['status' => 'success'], 200);
    }

}
