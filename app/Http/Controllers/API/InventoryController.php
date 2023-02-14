<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Inventory;
use App\Http\Controllers\Controller;
use App\Http\Resources\InventoryCollection;


class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $inv = Inventory::where('unit_id',$user->unit_id)
                        ->orderBy('updated_at','desc');
        if ($request->q != '') {
            $q = $request->q;
            $inv = $inv->where('inv_code', 'LIKE', '%' . $q . '%')
                        ->orWhere('inv_name', 'LIKE', '%' . $q . '%')
                        ->orWhere('inv_serialnumber', 'LIKE', '%' . $q . '%');
        }
        if ($request->s != '') {
            $s = $request->s;
            $inv = $inv->where('inv_status', $s);
        }
        return new InventoryCollection($inv->paginate(30));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'inv_code' => 'required',
            'inv_name' => 'required',

        ]);

        $user = $request->user();

        Inventory::create(['inv_code' => $request->inv_code,
                        'inv_name' => $request->inv_name,
                        'inv_serialnumber' => $request->inv_serialnumber,
                        'inv_condition' => $request->inv_condition,
                        'inv_location' => $request->inv_location,
                        'inv_photo' => $request->inv_photo,
                        'inv_status' => $request->inv_status,
                        'user_id' => $user->id,
                        'unit_id' => $user->unit_id,
                        ]);

        return response()->json(['status' => 'success'], 200);
    }

    public function edit(Request $request, $id)
    {
        $inv = Inventory::whereId($id)->first();
        return response()->json(['status' => 'success', 'data' => $inv], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'inv_code' => 'required',
            'inv_name' => 'required',

        ]);

        $user = $request->user();
        $inv = Inventory::whereId($id)->first();
        $inv->update([  'inv_code' => $request->inv_code,
                        'inv_name' => $request->inv_name,
                        'inv_location' => $request->inv_location,
                        'inv_condition' => $request->inv_condition,
                        'inv_serialnumber' => $request->inv_serialnumber,
                        'inv_status' => $request->inv_status,
                    ]);
        return response()->json(['status' => 'success'],200);
    }

    public function destroy($id)
    {
        $inv = Inventory::find($id);
        $inv->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
