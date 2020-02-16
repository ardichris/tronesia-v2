<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PelanggaranCollection;
use App\Pelanggaran;
use App\Siswa;

class PelanggaranController extends Controller
{
    public function index(Request $request)
    {
        if (request()->q != '') { //JIKA DATA PENCARIAN ADA
            $filter = $request->q;
            $siswas = Siswa::where('siswa_nama','like','%'.$filter.'%')->select('id')->get();
            $pelanggarans = Pelanggaran::where('siswa_id',$siswas)
            /*$pelanggarans = Pelanggaran::whereHas('siswa',function ($q) use ($filter) {
                            $q->where('siswa_nama','like','%'.$filter.'%');
                            })*/
            //$pelanggarans = Pelanggaran::with(['siswa'=>function($q) use ($filter) {
                //$q->where('siswa_nama','like','%'.$filter.'%');
                            ->orderBy('created_at', 'DESC');
            //$pelanggarans = $pelanggarans->where('siswa_id', 'LIKE', '%' . request()->q . '%'); //MAKA BUAT FUNGSI FILTERING DATA BERDASARKAN NAME
        }
        else{
            //GET PELANGGARAN DENGAN MENGURUTKAN DATANYA BERDASARKAN CREATED_AT
            $pelanggarans = Pelanggaran::with(['siswa'])->orderBy('created_at', 'DESC');
        }
        return new PelanggaranCollection($pelanggarans->paginate(10));
    }
    
    public function store(Request $request)
    {
        //BUAT VALIDASI DATA
        $this->validate($request, [
            //'pelanggaran_kode' => 'required|string|unique:pelanggarans,pelanggaran_kode',
            'siswa_id' => 'required',
            'pelanggaran_tanggal' => 'required|date',
            'pelanggaran_jenis' => 'required|string|max:150',
        ]);
        $getPL = Pelanggaran::orderBy('id', 'DESC');
        $rowCount = $getPL->count();
        $lastId = $getPL->first();

        if($rowCount==0) {
            $kode = "PL".date('y').date('m').date('d')."001";    
        } else {
            if(substr($lastId->pelanggaran_kode,2,6) == date('y').date('m').date('d')) {
            $counter = (int)substr($lastId->pelanggaran_kode,-3) + 1 ;
                if($counter < 100) {
                    $kode = "PL".date('y').date('m').date('d')."00".$counter;
                } elseif ($counter < 10) {
                    $kode = "PL".date('y').date('m').date('d')."0".$counter;
                } else {
                    $kode = "PL".date('y').date('m').date('d').$counter;
                }
            } else {
                $kode = "PL".date('y').date('m').date('d')."001";
            } 
        }
        Pelanggaran::create([
            'pelanggaran_kode' => $kode,
            'siswa_id' => $request->siswa_id['id'],
            'pelanggaran_tanggal' => $request->pelanggaran_tanggal,
            'pelanggaran_jenis' => $request->pelanggaran_jenis,
            'pelanggaran_keterangan' => $request->pelanggaran_keterangan
        ]);
        return response()->json(['status' => 'success']);
    }

    public function view($id)
    {
        $pelanggaran = Pelanggaran::wherePelanggaran_kode($id)->first();
        return response()->json(['status' => 'success', 'data' => $pelanggaran], 200);
    }

    public function edit($id)
    {
        $pelanggaran = Pelanggaran::with(['siswa'])->wherePelanggaran_kode($id)->first();
        return response()->json(['status' => 'success', 'data' => $pelanggaran], 200);
    }

    public function update(Request $request, $id)
    {
        /*$this->validate($request, [
            'siswa_id' => 'required',
            'pelanggaran_tanggal' => 'required|date',
            'pelanggaran_jenis' => 'required|string|max:150',
            'pelanggaran_keterangan' => 'required|string'
        ]);*/
        $pelanggaran = Pelanggaran::wherePelanggaran_kode($request->pelanggaran_kode);
        //$pelanggaran->update([$request->except('Pelanggaran_kode')]);

        $pelanggaran->update(['siswa_id' => $request->siswa_id['id'],
        'pelanggaran_tanggal' => $request->pelanggaran_tanggal,
        'pelanggaran_jenis' => $request->pelanggaran_jenis,
        'pelanggaran_keterangan' => $request->pelanggaran_keterangan]);
        return response()->json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        $pelanggaran = Pelanggaran::find($id);
        $pelanggaran->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
