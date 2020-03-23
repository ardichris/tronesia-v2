<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\JurnalCollection;
use App\Jurnal;
use App\DetailJurnal;
use DB;

class JurnalController extends Controller
{
    public function rekap(Request $request) {
        //return response()->json($request);
        $jurnals = Jurnal::with(['mapel','kelas'])->where([['kelas_id', request()->kls],['jm_tanggal', request()->tgl],['jm_status','!=',2]])->orderBy('jm_jampel', 'ASC');
        return new JurnalCollection($jurnals->get());
    }
    
    public function index(Request $request) {
        $user = $request->user();
        $jurnals = Jurnal::with(['mapel','kelas','kompetensi','user'])->orderBy('created_at', 'DESC');
        if (request()->q != '') {
            $q = $request->q;
            $jurnals = $jurnals->where('jm_kode', 'LIKE', '%' . request()->q . '%')
                             ->orWhere('jm_materi', 'LIKE', '%' . request()->q . '%')
                             ->orwhereHas('kelas', function($query) use($q){
                                $query->where('kelas_nama','like','%'.$q.'%');
                               })
                             ->orwhereHas('user', function($query) use($q){
                                $query->where('name','like','%'.$q.'%');
                               });
        }
        if (request()->s != '') {
            $s = $request->s;
            $jurnals = $jurnals->where('jm_status',$s);
        }
        if($user->role==2){
            $jurnals = $jurnals->where('user_id',$user->id);
        }
        return new JurnalCollection($jurnals->paginate(20));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'jm_tanggal' => 'required',
            'jm_materi' => 'required|string',
            'kelas_id' => 'required',
            'mapel_id' => 'required'
        ]);
        
        DB::enableQueryLog();
        foreach ($request->jm_jampel as $rowJP) {
            $getJM = Jurnal::orderBy('id', 'DESC');
            $rowCount = $getJM->count();
            $lastId = $getJM->first();
            $cekkonflik = Jurnal::where([['jm_jampel', $rowJP],
                                         ['kelas_id', $request->kelas_id['id']],
                                         ['jm_tanggal', $request->jm_tanggal],
                                         ['jm_status','!=',2]]);
            $konflik = $cekkonflik->count();                             
            $konflikwith = $cekkonflik->with('user')->first();
            
            if($konflik!=0){
                $catatan="Konflik dengan ".$konflikwith->user->name;
            } else {
                $catatan="";
            }

            if($rowCount==0) {
                $kode = "JM".date('y').date('m').date('d')."0001";    
            } else {
                if(substr($lastId->jm_kode,2,6) == date('y').date('m').date('d')) {
                $counter = (int)substr($lastId->jm_kode,-4) + 1 ;
                    if($counter < 10) {
                        $kode = "JM".date('y').date('m').date('d')."000".$counter;
                    } elseif ($counter < 100) {
                        $kode = "JM".date('y').date('m').date('d')."00".$counter;
                    } elseif ($counter < 1000) {
                        $kode = "JM".date('y').date('m').date('d')."0".$counter;
                    } else {
                        $kode = "JM".date('y').date('m').date('d').$counter;
                    }
                } else {
                    $kode = "JM".date('y').date('m').date('d')."0001";
                } 
            }
            $user = $request->user();

            $new_jurnal=Jurnal::create([
                            'jm_kode' => $kode,
                            'mapel_id' => $request->mapel_id['id'],
                            'jm_tanggal' => $request->jm_tanggal,
                            'jm_jampel' => $rowJP,
                            'kelas_id' => $request->kelas_id['id'],
                            'kompetensi_id' => $request->kompetensi_id['id'],
                            'jm_materi' => $request->jm_materi,
                            'user_id' => $user->id,
                            'jm_status' => $konflik != 0 ? 2:0,
                            'jm_keterangan' => $request->jm_keterangan,
                            'jm_catatan' => $catatan
                        ]);

            foreach ($request->detail as $row) {
                //if (!is_null($row['siswa'])) {
                    DetailJurnal::create([
                        'jurnal_id' => $new_jurnal->id,
                        'siswa_id' => $row['siswa']['id'],
                        'alasan' => $row['alasan']
                    ]);
                //}
            }
            
        }
            //return response()->json(DB::getQueryLog());
            return response()->json('sukses');
  
        
    }

    public function edit($id)
    {
        $jurnal = Jurnal::whereJm_kode($id)->with(['mapel','kelas','kompetensi','user','detail','detail.siswa'])->first();
        return response()->json(['status' => 'success', 'data' => $jurnal], 200);
    }

    public function view($id)
    {
        $jurnal = Jurnal::whereJurnal_kode($id)->first();
        return response()->json(['status' => 'success', 'data' => $jurnal], 200);
    }

    public function changeJMstatus(Request $request,$kode) {
        $jurnal = Jurnal::whereJm_kode($kode)->first();
            //return response()->json($request->status);
            $jurnal->update(['jm_status' => $request->status]);
        
        return response()->json(['status' => 'success'], 200);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'jm_tanggal' => 'required',
            'jm_materi' => 'required|string',
            'kelas_id' => 'required',
            'mapel_id' => 'required'
        ]);
        
        $jurnal = Jurnal::whereJm_kode($id)->first();
        $cekkonflik = Jurnal::where([['jm_kode','!=',$request->jm_kode],
                                        ['jm_jampel', $request->jm_jampel],
                                        ['kelas_id', $request->kelas_id['id']],
                                        ['jm_tanggal', $request->jm_tanggal],
                                        ['jm_status','!=',2]]);
        $konflik = $cekkonflik->count();                             
        $konflikwith = $cekkonflik->with('user')->first();

        if($konflik!=0){
            $catatan="Konflik dengan ".$konflikwith->user->name;
        } else {
            $catatan="";
        }
        
        $jurnal->update([
            'mapel_id' => $request->mapel_id['id'],
            'jm_tanggal' => $request->jm_tanggal,
            'jm_jampel' => $request->jm_jampel,
            'kelas_id' => $request->kelas_id['id'],
            'kompetensi_id' => $request->kompetensi_id['id'],
            'jm_materi' => $request->jm_materi,
            'user_id' => $request->user_id['id'],
            'jm_status' => $konflik != 0 ? 2:0,
            'jm_keterangan' => $request->jm_keterangan,
            'jm_catatan' => $catatan
        ]);

            DetailJurnal::whereJurnal_id($jurnal->id)->delete();
            foreach ($request->detail as $row) {
                if (!is_null($row['siswa'])) {
                    DetailJurnal::create([
                        'jurnal_id' => $jurnal->id,
                        'siswa_id' => $row['siswa']['id'],
                        'alasan' => $row['alasan']
                    ]);
                }            
            }
            
        return response()->json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        DetailJurnal::whereJurnal_id($id)->delete();
        $jurnal = Jurnal::find($id);
        $jurnal->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
