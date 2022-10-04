<?php

namespace App\Http\Controllers\API;

use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\MasterPelanggaranCollection;
use App\MasterPelanggaran;
use App\Pelanggaran;

class MasterPelanggaranController extends Controller
{
    public function index(Request $request) {
        $user = $request->user();
        $MP = MasterPelanggaran::orderBy('mp_pelanggaran', 'ASC');
        if (request()->category != '') {
            $MP = $MP->where('mp_kategori',request()->category);
        }
        if (request()->q != '') {
            $MP = $MP->where('mp_pelanggaran', 'LIKE', '%' . request()->q . '%')
                             ->orWhere('mp_kategori', 'LIKE', '%' . request()->q . '%');
        }
        $MP = $MP->paginate(20);
        if (request()->siswa != '') {
            foreach($MP as $row){
                try {
                    $total = Pelanggaran::where('mp_id', $row['id'])
                                    ->where('siswa_id', $request->siswa)
                                    ->where('periode_id', $user->periode)
                                    ->count();
                    $row['total'] = $total;
                }
                catch(QueryException $e){
                    $total = 0;
                }

            }

        }
        return new MasterPelanggaranCollection($MP);
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
