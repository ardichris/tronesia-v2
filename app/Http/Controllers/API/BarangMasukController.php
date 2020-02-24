<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\BarangMasukCollection;
use App\Barang;
use App\BarangMasuk;
use App\ListBarangMasuk;


class BarangMasukController extends Controller
{    
    public function index(Request $request) {
        $pbs = BarangMasuk::orderBy('created_at', 'DESC')
                                ->with(['user']);
        return new BarangMasukCollection($pbs->paginate(30)); 
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'listbarang' => 'required',
            'bm_tanggal' => 'required'
        ]);
        $user = $request->user();
        $getBM = BarangMasuk::orderBy('id', 'DESC');
        $rowCount = $getBM->count();
        $lastId = $getBM->first();
        if($rowCount==0) {
            $kode = "BM".date('y').date('m').date('d')."001";    
        } else {
            if(substr($lastId->bm_kode,2,6) == date('y').date('m').date('d')) {
            $counter = (int)substr($lastId->bm_kode,-3) + 1 ;
                if($counter < 10) {
                    $kode = "BM".date('y').date('m').date('d')."00".$counter;
                } elseif ($counter < 100) {
                    $kode = "BM".date('y').date('m').date('d')."0".$counter;
                } else {
                    $kode = "BM".date('y').date('m').date('d').$counter;
                }
            } else {
                $kode = "BM".date('y').date('m').date('d')."001";
            } 
        }

        $newBM = BarangMasuk::create([
                    'bm_kode' => $kode,
                    'bm_tanggal' => $request->bm_tanggal,
                    'user_id' => $user->id
                ]);
        //return response()->json(['status' => 'success']);        
        foreach ($request->listbarang as $row) {
                ListBarangMasuk::create([
                    'barangmasuk_id' => $newBM->id,
                    'barang_id' => $row['barang']['id'],
                    'jumlah' => $row['jumlah']
                ]);
        }
        return response()->json(['status' => 'success']); 
    }

    public function edit($kode)
    {
        $pbs = BarangMasuk::whereBm_kode($kode)->with(['barang','user'])->first();
        return response()->json(['status' => 'success', 'data' => $pbs], 200);
    }

    public function update(Request $request,$kode)
    {
        $this->validate($request, [
            'barang' => 'required',
            'bm_tanggal' => 'required'
        ]);
        
        $pbs = BarangMasuk::whereBm_kode($request->bl_kode);
        $user = $request->user();
        $pbs->update([
                'bl_tanggal' => $request->bl_tanggal,
                'barang_id' => $request->barang['id'],
                'user_id' => $user->id
                ]);
        return response()->json(['status' => 'success']);
    }

    public function destroy($kode)
    {
        $pbs = BarangMasuk::whereBm_kode($kode);
        $pbs->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
