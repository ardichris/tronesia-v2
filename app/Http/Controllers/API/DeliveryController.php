<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Delivery;
use App\Kelas;
use App\KelasAnggota;
use App\Http\Resources\DeliveryCollection;


class DeliveryController extends Controller
{
    public function index(Request $request){
        $user = $request->user();
        $dlv = Delivery::where('unit_id',$user->unit_id)
                        ->with(['siswa' => function ($query) {
                            $query->select('id', 's_nama', 'uuid');
                        }])
                        ->orderBy('updated_at','desc')
                        ->paginate(10);
        foreach ($dlv as $row){
            $kelas = KelasAnggota::where('siswa_id',$row->siswa->id)->where('periode_id',$user->periode)->first();
            $row['kelas'] = $kelas?Kelas::where('id',$kelas['kelas_id'])->value('kelas_nama'):'-';
            $row['absen'] = $kelas?$kelas['absen']:'-';
        }
        return new DeliveryCollection($dlv);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'dlv_date' => 'required',
            'dlv_item' => 'required',
            'siswa' => 'required',

        ]);

        $user = $request->user();
        $counter = Delivery::where('siswa_id', $request->siswa['id'])
                            ->where('periode_id', $user->periode)
                            ->count();

        Delivery::create(['dlv_date' => $request->dlv_date,
                            'dlv_item' => $request->dlv_item,
                            'siswa_id' => $request->siswa['id'],
                            'dlv_counter' => $counter+1,
                            'dlv_sender' => $request->dlv_sender,
                            'user_id' => $user->id,
                            'periode_id' => $user->periode,
                            'unit_id' => $user->unit_id,
                            'dlv_status' => 'Received'
                        ]);

        return response()->json(['status' => 'success'], 200);

    }

    public function update(Request $request)
    {}

    public function edit(Request $request)
    {}

    public function destroy($id){
        $dlv = Delivery::find($id);
        $dlv->delete();
        return response()->json(['status' => 'success'], 200);
    }

    public function ChangeStatus(Request $request, $id){
        $dlv = Delivery::whereId($id)->first();
        $dlv->update(['dlv_status' => 'Delivered']);

        return response()->json(['status' => 'success'], 200);
    }
}
