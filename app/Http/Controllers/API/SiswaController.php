<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\SiswaCollection;
use App\Siswa;

class SiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::orderBy('siswa_nama', 'ASC');
        if (request()->kelas != '') {
            $siswas = $siswas->where('siswa_kelas', '=' , request()->kelas);
                                //->where('siswa_nama', 'LIKE', '%' . request()->q . '%');
        }
        if (request()->q != '') {
            $siswas = $siswas->where('siswa_nama', 'LIKE', '%' . request()->q . '%');
        }
        $siswas = $siswas->paginate(40);
        return new SiswaCollection($siswas);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'siswa_kelamin' => 'required',
            'siswa_nama' => 'required|string',
            'siswa_kelas' => 'required|string',
            'siswa_tempatlahir' => 'required|string',
            'siswa_tanggallahir' => 'required|date'
        ]);

        Siswa::create($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    public function edit($id)
    {
        $siswa = Siswa::whereSiswa_nis($id)->first();
        return response()->json(['status' => 'success', 'data' => $siswa], 200);
    }

    public function view($id)
    {
        $siswa = Siswa::whereSiswa_nis($id)->first();
        return response()->json(['status' => 'success', 'data' => $siswa], 200);
    }

    public function update(Request $request, $id)
    {
        if(is_null($request['siswa_nama'])){
            $siswa = Siswa::whereId($id)->first();
            $siswa->update(['siswa_kelas'=> '-']);
        } else {
            $this->validate($request, [
                'siswa_kelamin' => 'required',
                'siswa_nama' => 'required|string',
                'siswa_kelas' => 'required|string',
                'siswa_tempatlahir' => 'required|string',
                'siswa_tanggallahir' => 'required|date'
            ]);
    
            $siswa = Siswa::whereSiswa_nis($id)->first();
            $siswa->update($request->except('Siswa_nis'));
        }
        return response()->json(['status' => 'success'], 200);
        
    }

    public function destroy($id)
    {
        $siswa = Siswa::find($id);
        $siswa->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
