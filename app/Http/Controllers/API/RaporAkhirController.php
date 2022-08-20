<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\RaporAkhirsImport;
use App\Imports\RaporSisipansImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\RaporAkhirCollection;
use App\RaporAkhir;
use App\RaporSisipan;
use App\RaporPetra;
use App\Kelas;
use App\KelasAnggota;
use App\Siswa;
use App\User;
use App\Unit;
use App\Periode;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Jenssegers\Date\Date;
use SimpleSoftwareIO\QrCode\Generator;
use App\Exports\RaporsExport;
use App\Exports\RaporsPetraExport;

function capitalize_after_delimiters($string)
    {
        preg_match_all("/\.\s*\w/", $string, $matches);

        foreach($matches[0] as $match){
            $string = str_replace($match, strtoupper($match), $string);
        }
        return $string;
    }

class RaporAkhirController extends Controller
{


    public function exportRapor(Request $request) {
        $user = $request->user();
        $siswa = KelasAnggota::with('kelas')
                                 ->where('periode_id', $user->periode)
                                 ->whereHas('kelas', function($query) use($user){
                                        $query->where('unit_id',$user->unit_id);
                                    });

        if(request()->grup=='Jenjang'){
            $siswa = $siswa->whereHas('kelas', function($query) use($request){
                                        $query->where('kelas_jenjang',$request->detail);
                                    });
        }

        if(request()->grup=='Kelas'){
            $siswa = $siswa->whereHas('kelas', function($query) use($request){
                                        $query->where('kelas_nama',$request->detail);
                                    });
        }

        // if(request()->grup=='Jenjang'){
        //     $siswa = KelasAnggota::with('kelas')
        //                          ->where('periode_id', $user->periode)
        //                          ->whereHas('kelas', function($query) use($user,$request){
        //                                 $query->where('unit_id',$user->unit_id)
        //                                       ->where('kelas_jenjang',$request->detail);
        //                             })
        //                          ->pluck('siswa_id');
        // }

        $siswa = $siswa->pluck('siswa_id');

        if(request()->rapor=='Akhir'){
            $rapor = RaporAkhir::whereIn('siswa_id',$siswa)->with('siswa')->where('periode_id',$user->periode)->get();
        }

        if(request()->rapor=='Petra'){
            $rapor = RaporPetra::whereIn('siswa_id',$siswa)->with('siswa')->where('periode_id',$user->periode)->get();
        }

        foreach($rapor as $row) {
            $kelas = KelasAnggota::with('kelas')->where('siswa_id',$row->siswa_id)->where('periode_id',$user->periode)->first();
            $row['kelas'] = $kelas?Kelas::where('id',$kelas['kelas_id'])->value('kelas_nama'):'-';
            $row['absen'] = $kelas?$kelas['absen']:'-';
            $row['walikelas'] = $kelas?User::whereId($kelas['kelas']['kelas_wali'])->value('full_name'):'-';
        }

        // Date::setLocale('id');
        // $siswa = Siswa::where('s_keterangan','AKTIF')->where('unit_id',$user->unit_id)->orderBy('s_nama')->get();
        // foreach($siswa as $row) {
        //     $kelas = KelasAnggota::where('siswa_id',$row->id)->where('periode_id',$user->periode)->first();
        //     //return response()->json(['data' => $kelas['kelas_id']]);
        //     $row['kelas'] = $kelas?Kelas::where('id',$kelas['kelas_id'])->value('kelas_nama'):'-';
        //     $row['absen'] = $kelas?$kelas['absen']:'-';
        //     $row['s_tanggal_lahir'] = Date::parse($row['s_tanggal_lahir'])->format('j F Y');
        // }
        // //$siswa = collect($siswa)->sortBy('s_nama')->sortBy('kelas')->toArray();
        $rapor = $rapor->toArray();
        //$nama = array_column($rapor->siswa, 's_nama');
        $kelas = array_column($rapor, 'kelas');
        $absen = array_column($rapor, 'absen');
        array_multisort($kelas, SORT_ASC, $absen, SORT_ASC, $rapor);
        if(request()->rapor=='Akhir'){
            return Excel::download(new RaporsExport($rapor), 'raporakhir-'.request()->grup.request()->detail.'-'.date('y').date('m').date('d').'.xlsx');
        } elseif(request()->rapor=='Petra'){
            return Excel::download(new RaporsPetraExport($rapor), 'raporpetra-'.request()->grup.request()->detail.'-'.date('y').date('m').date('d').'.xlsx');
        }
        //return response()->json(['status' => 'sukses'],200);
    }

    public function raporSisipanStore(Request $request, $id) {
        $this->validate($request, [
            'rs_catatan_ayat' => 'required|string',
            'rs_catatan_isi' => 'required|string'
        ]);

        $user = $request->user();
        $raporsisipan = RaporSisipan::whereId($id)
                                    ->update(['rs_catatan_ayat' => $request->rs_catatan_ayat,
                                                'rs_catatan_isi' => $request->rs_catatan_isi]);
        return response()->json(['status' => 'success'], 200);
    }

    public function raporSisipanView(Request $request)
    {
        $user = $request->user();
        $raporSisipan = RaporSisipan::whereId($request->uuid)
                                    ->with(['siswa' => function ($query) {
                                        $query->select('id','s_nama', 's_nis');
                                    }])->first();
                                    $raporSisipan['kelas'] = KelasAnggota::whereSiswa_id($raporSisipan['siswa']['id'])
                                    ->where('periode_id',$raporSisipan['periode_id'])
                                    ->with('kelas')
                                    ->first();
        $ttd = User::whereId($raporSisipan['kelas']['kelas']['kelas_wali'])->first();
        $raporSisipan['email'] = $ttd->email;
        $raporSisipan['ttd'] = $ttd->ttd;
        $raporSisipan['walikelas'] = $ttd->full_name;
        $raporSisipan['periode'] = Periode::whereId($raporSisipan['periode_id']);
        return response()->json(['message' => 'success', 'data' => $raporSisipan], 200);

    }

    public function raporSisipanPDF(Request $request)
    {
        $user = $request->user();
        $idSisipan = $request->rapor;
        $unit = $request->unit;
        $raporSisipan = RaporSisipan::whereId($idSisipan)
                                    ->with(['siswa' => function ($query) {
                                        $query->select('id','s_nama','s_nis','s_code');
                                    }])->first();
        $raporSisipan['kelas'] = KelasAnggota::whereSiswa_id($raporSisipan['siswa']['id'])
                                                ->where('periode_id',$raporSisipan['periode_id'])
                                                ->with('kelas')
                                                ->first();
        $ttd = User::whereId($raporSisipan['kelas']['kelas']['kelas_wali'])->first();
        $raporSisipan['rs_spiritual_deskripsi'] = ucfirst(capitalize_after_delimiters($raporSisipan['rs_spiritual_deskripsi'])).'.';
        $raporSisipan['rs_sosial_deskripsi'] = ucfirst(capitalize_after_delimiters($raporSisipan['rs_sosial_deskripsi'])).'.';
        $raporSisipan['email'] = $ttd->email;
        $raporSisipan['ttd'] = $ttd->ttd;
        $raporSisipan['walikelas'] = $ttd->full_name;
        $raporSisipan['periode'] = Periode::whereId($raporSisipan['periode_id']);
        //$qrcode = new Generator;
        //$raporSisipan['qrcode'] = $qrcode->size(200)->generate('test');//QrCode::size(100)->generate('test');
        //return response()->json(['message' => 'success', 'data' => $raporSisipan], 200);
        //$studentCode = Siswa::whereId($raporSisipan->siswa_id)->value('s_code');
        $studentCode = $raporSisipan['siswa']['s_code'];
        if($unit == 1) {
            $pdf = PDF::loadView('sisipan', compact('raporSisipan'))->setPaper([0, 0, 612.283, 935.433], 'portrait');
            return $pdf->stream($studentCode.".pdf");
        }elseif($unit == 3) {
            $pdf = PDF::loadView('sisipanp2', compact('raporSisipan'))->setPaper([0, 0, 612.283, 935.433], 'portrait');
            return $pdf->stream($studentCode.".pdf");
        }


    }

    public function import(Request $request)
    {

        $request->validate([
            'import_file' => 'required|file|mimes:xls,xlsx'
        ]);

        $user = $request->user();
        $path = $request->file('import_file');
        $jenis = $request->rapor;
        $rapor['periode'] = $user->periode;
        $rapor['user'] = $user->id;
        $rapor['unit'] = $user->unit_id;
        if ($jenis=='akhir') {
            $data = Excel::import(new RaporAkhirsImport($rapor), $path);
        }
        if ($jenis=='sisipan') {
            $data = Excel::import(new RaporSisipansImport($rapor), $path);
        }
        return response()->json(['message' => 'uploaded successfully'], 200);
    }

    public function index(Request $request) {
        $user = $request->user();
        $unit = $user->unit_id;
        $kelasAnggota = KelasAnggota::wherePeriode_id($user->periode)
                                    ->with('kelas')
                                    ->whereHas('kelas', function($query) use($unit){
                                        $query->where('unit_id', $unit);
                                    });
        if($user->role!=0){
            $kelas = Kelas::whereKelas_wali($user->id)->value('id');
            $kelasAnggota = $kelasAnggota->whereKelas_id($kelas);
        }
        $kelasAnggota = $kelasAnggota->with(['siswa' => function ($query) {
                                        $query->select('id','s_nama','uuid');
                                      }]);

        if (request()->q != '') {
            $q = request()->q;
            $kelasAnggota = $kelasAnggota->where(function ($query) use ($q) {
                                            $query->whereHas('siswa', function($query) use($q){
                                                        $query->where('s_nama','like','%'.$q.'%');
                                                    });
                                            });
        }
        $kelasAnggota = $kelasAnggota->paginate(40);
        foreach ($kelasAnggota as $row){
            $raporSisipan = RaporSisipan::where('siswa_id',$row->siswa->id)->where('periode_id',$user->periode)->select('id')->first();
            $raporAkhir = RaporAkhir::where('siswa_id',$row->siswa->id)->where('periode_id',$user->periode)->select('id')->first();
            $raporPetra = RaporPetra::where('siswa_id',$row->siswa->id)->where('periode_id',$user->periode)->select('id')->first();
            $row['RaporSisipan'] = $raporSisipan?$raporSisipan:'-';
            $row['RaporAkhir'] = $raporAkhir?$raporAkhir:'-';
            $row['RaporPetra'] = $raporPetra?$raporPetra:'-';
        }

        return new RaporAkhirCollection($kelasAnggota);
    }

    // public function store(Request $request)
    // {
    //     $this->validate($request, [
    //         'raporakhir_kode' => 'required',
    //         'raporakhir_nama' => 'required|string'
    //     ]);

    //     RaporAkhir::create($request->all());
    //     return response()->json(['status' => 'success'], 200);
    // }

    // public function edit($id)
    // {
    //     $raporakhir = RaporAkhir::whereRaporAkhir_kode($id)->first();
    //     return response()->json(['status' => 'success', 'data' => $raporakhir], 200);
    // }

    public function show(Request $request)
    {
        $user = $request->user();
        $raporAkhir = RaporAkhir::whereId($request->uuid)
                                    ->with(['siswa' => function ($query) {
                                        $query->select('id','s_nama', 's_nis');
                                    }])->first();
                                    $raporAkhir['kelas'] = KelasAnggota::whereSiswa_id($raporAkhir['siswa']['id'])
                                    ->where('periode_id',$raporAkhir['periode_id'])
                                    ->with('kelas')
                                    ->first();
        $ttd = User::whereId($raporAkhir['kelas']['kelas']['kelas_wali'])->first();
        $kasek = Unit::whereId($user->unit_id)->first();
        $raporAkhir['email'] = $ttd->email;
        $raporAkhir['ttd'] = $ttd->ttd;
        $raporAkhir['walikelas'] = $ttd->full_name;
        $raporAkhir['kasek'] = $kasek->unit_head;
        $raporAkhir['periode'] = Periode::whereId($raporAkhir['periode_id']);
        return response()->json(['message' => 'success', 'data' => $raporAkhir], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'ra_catatan_ayat' => 'required|string',
            'ra_catatan_isi' => 'required|string'
        ]);

        $user = $request->user();
        $raporakhir = RaporAkhir::whereId($id)
                                    ->update(['ra_catatan_ayat' => $request->ra_catatan_ayat,
                                                'ra_catatan_isi' => $request->ra_catatan_isi]);
        return response()->json(['status' => 'success'], 200);
    }

    // public function destroy($id)
    // {
    //     $raporakhir = RaporAkhir::find($id);
    //     $raporakhir->delete();
    //     return response()->json(['status' => 'success'], 200);
    // }
}
