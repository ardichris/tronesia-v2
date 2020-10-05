<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\MasterPelanggaranCollection;
use App\MasterPelanggaran;

class MasterPelanggaranController extends Controller
{
    public function index(Request $request) {
        $MP = MasterPelanggaran::orderBy('mp_pelanggaran', 'ASC');
        if (request()->q != '') {
            $MP = $MP->where('mp_pelanggaran', 'LIKE', '%' . request()->q . '%')
                             ->orWhere('mp_kategori', 'LIKE', '%' . request()->q . '%');
        }
        return new MasterPelanggaranCollection($MP->paginate(10));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'mp_pelanggaran' => 'required',
            'mp_kategori' => 'required|string',
            'mp_poin' => 'required|integer'
        ]);

        MasterPelanggaran::create($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    public function edit($id)
    {
        $MP = MasterPelanggaran::whereId($id)->first();
        return response()->json(['status' => 'success', 'data' => $MP], 200);
    }

    public function view($id)
    {
        $mapel = Mapel::whereMapel_kode($id)->first();
        return response()->json(['status' => 'success', 'data' => $mapel], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'mp_pelanggaran' => 'required',
            'mp_kategori' => 'required|string',
            'mp_poin' => 'required|integer'
        ]);

        $MP = MasterPelanggaran::whereId($request->id)->first();                                                                                                                                                                                                                                                                                                                                                                                                  
        $MP->update($request->except('id'));
        return response()->json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        $MP = MasterPelanggaran::find($id);
        $MP->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
