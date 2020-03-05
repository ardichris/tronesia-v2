<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\SeragamCollection;
use App\Barang;
use App\Siswa;
use App\Seragam;
use App\PemesananSeragam;

class SeragamController extends Controller
{
    public function index(Request $request) {
        $pbs = Seragam::orderBy('created_at', 'DESC')
                                ->with(['user','siswa']);
        return new SeragamCollection($pbs->paginate(30)); 
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'pemesanan' => 'required',
            'siswa_id' => 'required'
        ]);
        $user = $request->user();
        $getS = Seragam::orderBy('id', 'DESC');
        $rowCount = $getS->count();
        $lastId = $getS->first();
        if($rowCount==0) {
            $kode = "S".date('y').date('m').date('d')."001";    
        } else {
            if(substr($lastId->s_kode,1,6) == date('y').date('m').date('d')) {
            $counter = (int)substr($lastId->s_kode,-3) + 1 ;
                if($counter < 10) {
                    $kode = "S".date('y').date('m').date('d')."00".$counter;
                } elseif ($counter < 100) {
                    $kode = "S".date('y').date('m').date('d')."0".$counter;
                } else {
                    $kode = "S".date('y').date('m').date('d').$counter;
                }
            } else {
                $kode = "S".date('y').date('m').date('d')."001";
            } 
        }

        $newS = Seragam::create([
                    's_kode' => $kode,
                    //'s_tanggal' => $request->s_tanggal,
                    'user_id' => $user->id,
                    'siswa_id' => $request->siswa_id['id']
                ]);
        //return response()->json(['status' => 'success']);        
        foreach ($request->pemesanan as $row) {
                PemesananSeragam::create([
                    'seragam_id' => $newS->id,
                    'barang_id' => $row['barang']['id'],
                    'jumlah' => $row['jumlah'],
                    'status' => $row['status'] == null ? "Pesan":$row['status']
                ]);
                /*if($row['status']=="Diterima"){
                    Barang::find($row['barang']['id'])->decrement('barang_stok',$row['jumlah']);
                }*/
        }
        return response()->json(['status' => 'success']); 
    }

    public function edit($kode)
    {
        $pbs = Seragam::whereS_kode($kode)->with(['user','siswa','pemesanan','pemesanan.barang'])->first();
        return response()->json(['status' => 'success', 'data' => $pbs], 200);
    }

    public function update(Request $request,$kode)
    {
        $this->validate($request, [
            'pemesanan' => 'required',
            //'s_tanggal' => 'required'
            'siswa_id' => 'required',
            'pemesanan' => 'required'
        ]);
        
        $seragams = Seragam::whereS_kode($kode)->first();
        $user = $request->user();
        $tanggal = date('d-m-y');//date('d')."-".date('m')."-".date('y');
        $seragams->update([
                        //'s_tanggal' => $request->s_tanggal,
                        'user_id' => $user->id,
                        'siswa_id' => $request->siswa_id['id']
                        ]);
        $barang = PemesananSeragam::whereSeragam_id($seragams->id);                 
        $pemesanan = $barang->get();
        /*foreach ($pemesanan as $row) {
            Barang::find($row->barang_id)->decrement('barang_stok',$row->jumlah);
        }*/
        $barang->delete();
        foreach ($request->pemesanan as $row) {
            if (!is_null($row['jumlah'])&&!is_null($row['barang'])) {
                PemesananSeragam::create([
                                    'seragam_id' => $seragams->id,
                                    'barang_id' => $row['barang']['id'],
                                    'jumlah' => $row['jumlah'],
                                    'status' => $row['status'] == null ? "Pesan":$row['status'],
                                    'diterima' => $row['status'] == "Diterima" ? $tanggal:null
                                ]);
                //Barang::find($row['barang']['id'])->increment('barang_stok',$row['jumlah']);
            }            
        }
        return response()->json(['status' => 'success']);
    }

    public function destroy($kode)
    {
        $pbs = Seragam::find($kode);
        $barang = PemesananSeragam::whereSeragam_id($kode);                 
        $pemesanan = $barang->get();
        foreach ($pemesanan as $row) {
            Barang::find($row->barang_id)->decrement('barang_stok',$row->jumlah);
        }
        $barang->delete();
        $pbs->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
