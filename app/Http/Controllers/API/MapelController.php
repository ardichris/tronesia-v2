<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\MapelCollection;
use App\Mapel;

class MapelController extends Controller
{
    public function index(Request $request) {
        $mapels = Mapel::orderBy('mapel_kode', 'ASC');
        if (request()->q != '') {
            $mapels = $mapels->where('mapel_nama', 'LIKE', '%' . request()->q . '%')
                             ->orWhere('mapel_kode', 'LIKE', '%' . request()->q . '%');
        }
        return new MapelCollection($mapels->paginate(10));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'mapel_kode' => 'required',
            'mapel_nama' => 'required|string'
        ]);

        Mapel::create($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    public function edit($id)
    {
        $mapel = Mapel::whereMapel_kode($id)->first();
        return response()->json(['status' => 'success', 'data' => $mapel], 200);
    }

    public function view($id)
    {
        $mapel = Mapel::whereMapel_kode($id)->first();
        return response()->json(['status' => 'success', 'data' => $mapel], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'mapel_kode' => 'required',
            'mapel_nama' => 'required|string',
        ]);

        $mapel = Mapel::whereMapel_kode($id)->first();
        $mapel->update($request->except('Mapel_kode'));
        return response()->json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        $mapel = Mapel::find($id);
        $mapel->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
