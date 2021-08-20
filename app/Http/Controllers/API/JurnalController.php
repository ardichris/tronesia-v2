<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\JurnalCollection;
use App\Jurnal;
use App\User;
use App\DetailJurnal;
use App\Pelanggaran;
use App\Unit;
use Carbon\Carbon;
use DB;
use PDF;

class JurnalController extends Controller
{
    public function rekapJurnalPDF(Request $request)
    {
        $user = $request->user;
        $mulai = date($request->start);
        $akhir = date($request->finish);
        $listjurnal = Jurnal::with(['mapel','kelas','kompetensi'])
                    ->whereBetween('jm_tanggal', [$mulai, $akhir])
                    ->where('jm_status','=',1)
                    ->orderBy('jm_tanggal', 'ASC')
                    ->orderBy('jm_jampel', 'ASC')
                    ->where('user_id',$user);
                    //->get();
                    
                    //$listjurnal = $listjurnal->where('user_id',$user->id);
        $jurnals['tanggal'] = Carbon::now()->format('d F Y');
        $jurnals['list'] = $listjurnal->get();
        $jurnals['guru'] = User::where('id',$user)->pluck('name');
        $jurnals['start'] = Carbon::parse($mulai)->format('d F Y');
        $jurnals['end'] = Carbon::parse($akhir)->format('d F Y');
        $pdf = PDF::loadView('print', compact('jurnals'))->setPaper('a4', 'landscape');
        return $pdf->stream();
        /*
        
        */

        
        //GET DATA BERDASARKAN ID
        //$invoice = Invoice::with(['customer', 'detail', 'detail.product'])->find($id);
        //LOAD PDF YANG MERUJUK KE VIEW PRINT.BLADE.PHP DENGAN MENGIRIMKAN DATA DARI INVOICE
        //KEMUDIAN MENGGUNAKAN PENGATURAN LANDSCAPE A4
        
    }
    
    
    
    public function rekap(Request $request) {
        //return response()->json(['data' => $request->start], 200);
        $user = $request->user();
        $mulai = date($request->start);
        $akhir = date($request->finish);
        $jurnals = Jurnal::with(['mapel','kelas','kompetensi'])
                    ->whereBetween('jm_tanggal', [$mulai, $akhir])
                    ->where('jm_status','=',1)
                    ->orderBy('jm_tanggal', 'ASC')
                    ->orderBy('jm_jampel', 'ASC');
        //if($user->role==2){
            $jurnals = $jurnals->where('user_id',$user->id);
        //}
        return new JurnalCollection($jurnals->get());
    }
    
    public function index(Request $request) {
        $user = $request->user();
        $jurnals = Jurnal::with(['mapel','kelas','kompetensi','user','detail','detail.siswa','pelanggaran','pelanggaran.siswa','unit'])
                    ->orderBy('updated_at', 'DESC')
                    ->where('unit_id',$user->unit_id)
                    ->where('periode_id',$user->periode);
<<<<<<< HEAD
        if($user->role==2){
            $jurnals = $jurnals->where('user_id',$user->id);
        }
=======
>>>>>>> 97b73ced2c6e008bda7d1dfeb1dd057d3b8eb831
        if (request()->q != '') {
            $q = request()->q;
            $jurnals = $jurnals->where(function ($query) use ($q) {
                                    $query->where('jm_kode', 'LIKE', '%' . $q . '%')
                                        ->orWhere('jm_materi', 'LIKE', '%' . $q . '%')
                                        ->orwhereHas('kelas', function($query) use($q){
                                                $query->where('kelas_nama','like','%'.$q.'%');
                                            })
                                        ->orwhereHas('user', function($query) use($q){
                                                $query->where('name','like','%'.$q.'%');
                                            });
                                });
        }
        if (request()->s != '') {
            $s = $request->s;
            $jurnals = $jurnals->where('jm_status',$s);
        }
        return new JurnalCollection($jurnals->paginate(20));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'jm_tanggal' => 'required',
            'jm_materi' => 'required|string',
            'jm_keterangan' => 'required|string',
            'kelas_id' => 'required',
            'jm_jampel' => 'required',
            //'mapel_id' => 'required'
        ]);
        
        //DB::enableQueryLog();
        foreach ($request->jm_jampel as $rowJP) {
            $getJM = Jurnal::orderBy('id', 'DESC');
            $rowCount = $getJM->count();
            $lastId = $getJM->first();
            $konflik = 0;
            if($request->mapel_id!=null){
                if($request->mapel_id['id']!=23 && $request->mapel_id['id']!=24){
                    $cekkonflik = Jurnal::where([['jm_jampel', $rowJP],
                                                ['kelas_id', $request->kelas_id['id']],
                                                ['jm_tanggal', $request->jm_tanggal],
                                                ['jm_status','!=',2]]);
                    $konflik = $cekkonflik->count();                         
                    $konflikwith = $cekkonflik->with('user')->first();
                }
            }
            if($konflik!=0){
                $catatan="Konflik dengan ".$konflikwith->user->name;
            } else {
                $catatan="";
            }

            if($rowCount==0) {
                $kode = "JM".date('y').date('m').date('d')."001";    
            } else {
                if(substr($lastId->jm_kode,2,6) == date('y').date('m').date('d')) {
                $counter = (int)substr($lastId->jm_kode,-3) + 1 ;
                    if($counter < 10) {
                        $kode = "JM".date('y').date('m').date('d')."00".$counter;
                    } elseif ($counter < 100) {
                        $kode = "JM".date('y').date('m').date('d')."0".$counter;
                    } else {
                        $kode = "JM".date('y').date('m').date('d').$counter;
                    }
                } else {
                    $kode = "JM".date('y').date('m').date('d')."001";
                } 
            }
            $user = $request->user();

            $new_jurnal=Jurnal::create([
                            'jm_kode' => $kode,
                            'mapel_id' => $request->mapel_id ? $request->mapel_id['id']:null,
                            'jm_tanggal' => $request->jm_tanggal,
                            'jm_jampel' => $rowJP,
                            'kelas_id' => $request->kelas_id['id'],
                            'kompetensi_id' => $request->kompetensi_id ? $request->kompetensi_id['id']:null,
                            'jm_materi' => $request->jm_materi,
                            'user_id' => $user->id,
                            'unit_id' => $user->unit_id,
                            'periode_id' => $user->periode,
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

            foreach ($request->pelanggaran as $row) {
                $getPL = Pelanggaran::orderBy('id', 'DESC');
                $rowCount = $getPL->count();
                $lastId = $getPL->first();

                if($rowCount==0) {
                    $kode = "PL".date('y').date('m').date('d')."001";    
                } else {
                    if(substr($lastId->pelanggaran_kode,2,6) == date('y').date('m').date('d')) {
                    $counter = (int)substr($lastId->pelanggaran_kode,-3) + 1 ;
                        if($counter < 10) {
                            $kode = "PL".date('y').date('m').date('d')."00".$counter;
                        } elseif ($counter < 100) {
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
                    'jurnal_id' => $new_jurnal->id,
                    'siswa_id' => $row['siswa']['id'],
                    'pelanggaran_tanggal' => $request->jm_tanggal,
                    'pelanggaran_jenis' => $row['pelanggaran_jenis'],
                    'pelanggaran_keterangan' => $row['pelanggaran_keterangan'],
                    'user_id' => $user->id,
                    'unit_id' => $user->unit_id,
                    'periode_id' => $user->periode
                ]);
            }
            
        }
            //return response()->json(DB::getQueryLog());
            return response()->json('sukses');
  
        
    }

    public function edit($id)
    {
        $jurnal = Jurnal::whereJm_kode($id)->with(['mapel','kelas','kompetensi','user','detail','detail.siswa','pelanggaran','pelanggaran.siswa'])->first();
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
            $jurnal->update(['jm_status' => $request->status,
                             'jm_catatan' => $request->jurnal['jm_catatan']]);
        
        return response()->json(['status' => 'success'], 200);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'jm_tanggal' => 'required',
            'jm_materi' => 'required|string',
            'kelas_id' => 'required',
            //'mapel_id' => 'required'
        ]);
        
        $jurnal = Jurnal::whereJm_kode($id)->first();
        $konflik = 0;
        if($request->mapel_id['id']!=23 && $request->mapel_id['id']!=24){
            $cekkonflik = Jurnal::where([['jm_kode','!=',$request->jm_kode],
                                            ['jm_jampel', $request->jm_jampel],
                                            ['kelas_id', $request->kelas_id['id']],
                                            ['jm_tanggal', $request->jm_tanggal],
                                            ['jm_status','!=',2]]);
            $konflik = $cekkonflik->count();                             
            $konflikwith = $cekkonflik->with('user')->first();
        }
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
            'unit_id' => $user->unit_id,
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

        Pelanggaran::whereJurnal_id($jurnal->id)->delete();
        foreach ($request->pelanggaran as $row) {
            if (!is_null($row['siswa'])) {
                $getPL = Pelanggaran::orderBy('id', 'DESC');
                $rowCount = $getPL->count();
                $lastId = $getPL->first();

                if($rowCount==0) {
                    $kode = "PL".date('y').date('m').date('d')."001";    
                } else {
                    if(substr($lastId->pelanggaran_kode,2,6) == date('y').date('m').date('d')) {
                    $counter = (int)substr($lastId->pelanggaran_kode,-3) + 1 ;
                        if($counter < 10) {
                            $kode = "PL".date('y').date('m').date('d')."00".$counter;
                        } elseif ($counter < 100) {
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
                    'jurnal_id' => $new_jurnal->id,
                    'siswa_id' => $row['namasiswa']['id'],
                    'pelanggaran_tanggal' => $request->jm_tanggal,
                    'pelanggaran_jenis' => $row['pelanggaran_jenis'],
                    'pelanggaran_keterangan' => $row['pelanggaran_keterangan'],
                    'user_id' => $user->id,
                    'unit_id' => $user->unit_id,
                    'periode_id' => $user->periode
                ]);
            }
        } 
        return response()->json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        DetailJurnal::whereJurnal_id($id)->delete();
        Pelanggaran::whereJurnal_id($id)->delete();
        $jurnal = Jurnal::find($id);
        $jurnal->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
