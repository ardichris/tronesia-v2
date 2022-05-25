<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Barang;
use App\PemakaianBarang;
use App\Http\Resources\PemakaianBarangCollection;

class PemakaianBarangController extends Controller
{

    public function index(Request $request) {
            $user = $request->user();
            $pbs = PemakaianBarang::orderBy('created_at', 'DESC')
                                    ->where('unit_id',$user->unit_id)
                                    ->with(['barang','user']);
            if($user->role!=0 && $user->role!=4){
                $pbs = $pbs->where('user_id',$user->id);
            }
            if (request()->q != '') {
                $q = request()->q;
                $pbs = $pbs->where(function ($query) use ($q) {
                                $query->whereHas('barang', function($query) use($q){
                                            $query->where('barang_nama','like','%'.$q.'%');
                                        });
                            });
                        }
            return new PemakaianBarangCollection($pbs->paginate(30));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'barang' => 'required',
            'pb_tanggal' => 'required',
            'pb_jumlah' => 'required',

        ]);
        $user = $request->user();
        $getPB = PemakaianBarang::orderBy('id', 'DESC');
        $rowCount = $getPB->count();
        $lastId = $getPB->first();

        if($rowCount==0) {
            $kode = "PB".date('y').date('m').date('d')."001";
        } else {
            if(substr($lastId->pb_kode,2,6) == date('y').date('m').date('d')) {
            $counter = (int)substr($lastId->pb_kode,-3) + 1 ;
                if($counter < 10) {
                    $kode = "PB".date('y').date('m').date('d')."00".$counter;
                } elseif ($counter < 100) {
                    $kode = "PB".date('y').date('m').date('d')."0".$counter;
                } else {
                    $kode = "PB".date('y').date('m').date('d').$counter;
                }
            } else {
                $kode = "PB".date('y').date('m').date('d')."001";
            }
        }

        PemakaianBarang::create([
            'pb_kode' => $kode,
            'pb_tanggal' => $request->pb_tanggal,
            'barang_id' => $request->barang['id'],
            'pb_jumlah' => $request->pb_jumlah,
            'pb_keterangan' => $request->pb_keterangan,
            'pb_status' => 0,
            'user_id' => $user->id,
            'unit_id' => $user->unit_id
        ]);
        //Barang::find($request->barang['id'])->decrement('barang_stok',$request->pb_jumlah);
        return response()->json(['status' => 'success']);
    }

    public function edit($kode)
    {
        $pbs = PemakaianBarang::wherePb_kode($kode)->with(['barang','user'])->first();
        return response()->json(['status' => 'success', 'data' => $pbs], 200);
    }

    public function update(Request $request,$kode)
    {
        $this->validate($request, [
            'barang' => 'required',
            'pb_tanggal' => 'required',
            'pb_jumlah' => 'required',
        ]);

        $pbs = PemakaianBarang::wherePb_kode($request->pb_kode);
        $oldPB = $pbs->first();
        Barang::find($oldPB->barang_id)->increment('barang_stok',$oldPB->pb_jumlah);
        $user = $request->user();
        $pbs->update([
                'pb_tanggal' => $request->pb_tanggal,
                'barang_id' => $request->barang['id'],
                'pb_jumlah' => $request->pb_jumlah,
                'pb_keterangan' => $request->pb_keterangan,
                'user_id' => $user->id
                ]);
        //Barang::find($oldPB->barang_id)->increment('barang_stok',$oldPB->pb_jumlah);
        Barang::find($oldPB->barang_id)->decrement('barang_stok',$request->pb_jumlah);
        return response()->json(['status' => 'success']);
    }

    public function destroy($kode)
    {
        $pbs = PemakaianBarang::wherePb_kode($kode);
        $barang = $pbs->first();
        if($barang->pb_status == 1) {
            Barang::find($barang->barang_id)->increment('barang_stok',$barang->pb_jumlah);
        }
        $pbs->delete();
        return response()->json(['status' => 'success'], 200);
    }

    public function listPemakaian(Request $request,$kode){
        $listbarang = PemakaianBarang::whereBarang_id($kode)->get();
        return response()->json(['status' => 'success', 'data' => $listbarang], 200);
    }

    public function changeStatus(Request $request,$kode) {
        $pb = PemakaianBarang::wherePb_kode($kode)->first();
            $pb->update(['pb_status' => $request->status]);
            if($request->status == 1){
                Barang::find($pb->barang_id)->decrement('barang_stok',$pb->pb_jumlah);
            }
        return response()->json(['status' => 'success'], 200);
    }
}
