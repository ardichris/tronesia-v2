<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UnitCollection;
use App\Unit;

class UnitController extends Controller
{
    public function index(Request $request) {
        $units = Unit::orderBy('unit_kode', 'ASC');
        if (request()->q != '') {
            $units = $units->where('unit_nama', 'LIKE', '%' . request()->q . '%')
                             ->orWhere('unit_kode', 'LIKE', '%' . request()->q . '%');
        }
        return new UnitCollection($units->paginate(10));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'unit_kode' => 'required',
            'unit_nama' => 'required|string'
        ]);

        Unit::create($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    public function edit($id)
    {
        $unit = Unit::whereId($id)->first();
        return response()->json(['status' => 'success', 'data' => $unit], 200);
    }

    public function view($id)
    {
        $unit = Unit::whereId($id)->first();
        return response()->json(['status' => 'success', 'data' => $unit], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'unit_kode' => 'required',
            'unit_nama' => 'required|string',
        ]);

        $unit = Unit::whereId($id)->first();
        $unit->update([
            'unit_kode' => $request->unit_kode,
            'unit_nama' => $request->unit_nama
        ]);
        return response()->json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        $unit = Unit::find($id);
        $unit->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
