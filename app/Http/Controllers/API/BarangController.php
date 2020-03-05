<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Barang;
use App\Http\Resources\BarangCollection;

class BarangController extends Controller
{
    public function index(Request $request) {
        $barangs = Barang::orderBy('barang_nama', 'ASC');
        if (request()->q != '') {
            $barangs = $barangs->where('barang_nama', 'LIKE', '%' . request()->q . '%')
                             ->orWhere('barang_kode', 'LIKE', '%' . request()->q . '%');
        }
        return new BarangCollection($barangs->paginate(10));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'barang_nama' => 'required',
            'barang_stok' => 'required',
            'barang_satuan' => 'required',
            
        ]);
        $getB = Barang::orderBy('id', 'DESC');
        $rowCount = $getB->count();
        $lastId = $getB->first();

        if($rowCount==0) {
            $kode = "B"."0001";    
        } else {
            $counter = (int)substr($lastId->barang_kode,-4) + 1 ;
            if($counter < 10) {
                $kode = "B"."000".$counter;
            } elseif ($counter < 100) {
                $kode = "B"."00".$counter;
            } elseif ($counter < 1000) {
                $kode = "B"."0".$counter;
            } else {
                $kode = "B".$counter;
            }
        } 
        Barang::create(['barang_kode' => $kode,
                        'barang_nama' => $request->barang_nama,
                        'barang_stok' => (int)$request->barang_stok,
                        'barang_satuan' => $request->barang_satuan,
                        'b_varian' => $request->b_varian,
                        'b_kategori' => $request->b_kategori,
                        'barang_lokasi' => $request->barang_lokasi
                        ]);
        return response()->json(['status' => 'success'], 200);
    }

    public function edit($id)
    {
        $barang = Barang::whereBarang_kode($id)->first();
        return response()->json(['status' => 'success', 'data' => $barang], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'barang_nama' => 'required',
            'barang_satuan' => 'required',
            //'barang_lokasi' => 'required',
        ]);
        
        $barang = Barang::whereBarang_kode($id)->first();
        $barang->update(['barang_nama' => $request->barang_nama,
                         'barang_satuan' => $request->barang_satuan,
                         'barang_lokasi' => $request->barang_lokasi,
                         'b_varian' => $request->b_varian,
                         'b_kategori' => $request->b_kategori
                        ]);
        return response()->json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        $barang = Barang::find($id);
        $barang->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
