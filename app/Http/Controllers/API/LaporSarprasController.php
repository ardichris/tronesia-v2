<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\LaporSarprasCollection;
use App\LaporSarpras;
use Carbon\Carbon;

class LaporSarprasController extends Controller
{
    public function index(Request $request)
    {
        //return response()->json(['data' => $request], 200);
        $user = $request->user();
        $laporsarpras = LaporSarpras::with(['creator','updater'])->where('unit_id',$user->unit_id)->orderBy('created_at', 'DESC');
        if (request()->k != '') {
            $laporsarpras = $laporsarpras->where('ls_kategori', '=', request()->k);
        }
        if (request()->q != '') {
            $laporsarpras = $laporsarpras->where('ls_sarpras', 'LIKE', '%'.request()->q.'%')
                                         ->orWhere('ls_keterangan', 'LIKE', '%'.request()->q.'%');
        }
        if($user->role!=0 && $user->role!=4){
            $laporsarpras = $laporsarpras->where('creator_id',$user->id);
        }
        return new LaporSarprasCollection($laporsarpras->paginate(10));
    }

    public function store(Request $request)
    {
        
        $this->validate($request, [
            'ls_kategori' => 'required',
            'ls_sarpras' => 'required|string|max:150',
            'ls_keterangan' => 'required|string|max:150'
        ]);
        $user = $request->user();
        $getLS = LaporSarpras::orderBy('id', 'DESC');
        $rowCount = $getLS->count();
        $lastId = $getLS->first();

        if($rowCount==0) {
            $kode = "LS".date('y').date('m').date('d')."001";    
        } else {
            if(substr($lastId->ls_kode,2,6) == date('y').date('m').date('d')) {
            $counter = (int)substr($lastId->ls_kode,-3) + 1 ;
                if($counter < 10) {
                    $kode = "LS".date('y').date('m').date('d')."00".$counter;
                } elseif ($counter < 100) {
                    $kode = "LS".date('y').date('m').date('d')."0".$counter;
                } else {
                    $kode = "LS".date('y').date('m').date('d').$counter;
                }
            } else {
                $kode = "LS".date('y').date('m').date('d')."001";
            } 
        }
        LaporSarpras::create([
            'ls_kode' => $kode,
            'ls_kategori' => $request->ls_kategori,
            'ls_sarpras' => $request->ls_sarpras,
            'ls_keterangan' => $request->ls_keterangan,
            'ls_tanggal' => Carbon::now(),
            'ls_status' => 0,
            'creator_id' => $user->id,
            'unit_id' => $user->unit_id
            
        ]);
        return response()->json(['status' => 'success']);
    }

    public function view($id)
    {
        $lapor = LaporSarpras::whereAbsensi_kode($id)->first();
        return response()->json(['status' => 'success', 'data' => $lapor], 200);
    }

    public function edit($kode)
    {
        $lapor = LaporSarpras::with('updater')->whereLs_kode($kode)->first();
        return response()->json(['status' => 'success', 'data' => $lapor], 200);
    }

    public function update(Request $request, $kode)
    {
        $this->validate($request, [
            'ls_kategori' => 'required',
            'ls_sarpras' => 'required|string|max:150',
            'ls_keterangan' => 'required|string|max:150'
        ]);
        
        $user = $request->user();
        $lapor = LaporSarpras::whereLs_kode($request->ls_kode);
        $lapor->update(['ls_kategori' => $request->ls_kategori,
                        'ls_sarpras' => $request->ls_sarpras,
                        'ls_keterangan' => $request->ls_keterangan,
                        'ls_penanganan' => $request->ls_penanganan,
                        'updater_id' => $user->id]);
        return response()->json(['status' => 'success']);
    }

    public function destroy($id)
    {
        $lapor = LaporSarpras::find($id);
        $lapor->delete();
        return response()->json(['status' => 'success'], 200);
    }

    public function changeStatus(Request $request,$kode) {
        $user = $request->user();
        $ls = LaporSarpras::whereLs_kode($kode)->first();
            $ls->update(['ls_status' => $request->status,
                         'ls_penanganan' => $request->ls['ls_penanganan'],
                         'updater_id' => $user->id]);    
        return response()->json(['status' => 'success'], 200);
    }
}
