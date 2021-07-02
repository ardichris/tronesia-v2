<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UnitCollection;
use App\Unit;

class UnitController extends Controller
{
    public function index(Request $request) {
        $units = Unit::orderBy('unit_code', 'ASC');
        if (request()->q != '') {
            $units = $units->where('unit_name', 'LIKE', '%' . request()->q . '%')
                             ->orWhere('unit_code', 'LIKE', '%' . request()->q . '%');
        }
        return new UnitCollection($units->paginate(10));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'unit_code' => 'required',
            'unit_name' => 'required|string'
        ]);

        Unit::create($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    public function edit($id)
    {
        $unit = Unit::whereUnit_code($id)->first();
        return response()->json(['status' => 'success', 'data' => $unit], 200);
    }

    public function view($id)
    {
        $unit = Unit::whereUnit_code($id)->first();
        return response()->json(['status' => 'success', 'data' => $unit], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'unit_code' => 'required',
            'unit_name' => 'required|string',
        ]);

        $unit = Unit::whereUnit_code($id)->first();
        $unit->update($request->except('Unit_code'));
        return response()->json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        $unit = Unit::find($id);
        $unit->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
