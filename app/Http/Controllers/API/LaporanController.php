<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Absensi;
use App\Kelas;
use App\KelasAnggota;
use App\Siswa;
use App\Pelanggaran;
use App\NilaiSiswa;
use App\Mapel;
use App\MasterPelanggaran;
use App\PembayaranPsb;
use App\Http\Resources\AbsensiCollection;


class LaporanController extends Controller
{
    public function pembayaran(Request $request){
        $user = $request->user();
        $pembayaran = PembayaranPsb::where('unit_id', $user->unit_id)->get();
        $jumlahdalam = 0;
        $jumlahluar = 0;
        $jumlahluartunai = 0;
        $jumlahdalamtunai = 0;
        $jumlahdalamangsuran1 = 0;
        $jumlahdalamangsuran2 = 0;
        $jumlahdalamangsuran3 = 0;
        $jumlahdalamangsuran4 = 0;
        $jumlahdalamlunasangsuran1 = 0;
        $jumlahdalamlunasangsuran2 = 0;
        $jumlahdalamlunasangsuran3 = 0;
        $jumlahdalamlunasangsuran4 = 0;
        $jumlahluarangsuran1 = 0;
        $jumlahluarangsuran2 = 0;
        $jumlahluarangsuran3 = 0;
        $jumlahluarangsuran4 = 0;
        $jumlahluarlunasangsuran1 = 0;
        $jumlahluarlunasangsuran2 = 0;
        $jumlahluarlunasangsuran3 = 0;
        $jumlahluarlunasangsuran4 = 0;
        $siswa=[];
        foreach($pembayaran as $row){

            if(substr($row->pp_student_code,0,4)=='2023'){
                if($row->pp_angsuran==1) {
                    if(intval(str_replace(',', '', $row->pp_bruto))-intval(str_replace(',', '', $row->pp_subsidi))-intval(str_replace(',', '', $row->pp_tunai))==intval(str_replace(',', '', $row->pp_biaya))){
                        $jumlahluartunai++;
                    } else {
                        $jumlahluarangsuran1++;
                        if($row->pp_sisa==0)$jumlahluarlunasangsuran1++;
                    }
                }
                if($row->pp_angsuran==2) {
                    $jumlahluarangsuran2++;
                    if($row->pp_sisa==0)$jumlahluarlunasangsuran2++;
                }
                if($row->pp_angsuran==3) {
                    $jumlahluarangsuran3++;
                    if($row->pp_sisa==0)$jumlahluarlunasangsuran3++;
                }
                if($row->pp_angsuran==4) {
                    $jumlahluarangsuran4++;
                    if($row->pp_sisa==0)$jumlahluarlunasangsuran4++;
                }
            } elseif(substr($row->pp_student_code,0,4)!='2023') {
                if($row->pp_angsuran==1) {
                    if(intval(str_replace(',', '', $row->pp_bruto))-intval(str_replace(',', '', $row->pp_subsidi))-intval(str_replace(',', '', $row->pp_tunai))==intval(str_replace(',', '', $row->pp_biaya))){
                        $jumlahdalamtunai++;
                    } else {
                        $jumlahdalamangsuran1++;
                        if($row->pp_sisa==0)$jumlahdalamlunasangsuran1++;
                    }
                }
                if($row->pp_angsuran==2) {
                    $jumlahdalamangsuran2++;
                    if($row->pp_sisa==0)$jumlahdalamlunasangsuran2++;
                }
                if($row->pp_angsuran==3) {
                    $jumlahdalamangsuran3++;
                    if($row->pp_sisa==0)$jumlahdalamlunasangsuran3++;
                }
                if($row->pp_angsuran==4) {
                    $jumlahdalamangsuran4++;
                    if($row->pp_sisa==0)$jumlahdalamlunasangsuran4++;
                }
            }

            if(!collect($siswa)->contains('Noform',$row->pp_no_formulir)){
                array_push($siswa, (object)[
                    'Noform' => $row->pp_no_formulir,
                    'Nama' => $row->pp_student_name,
                    'Kode' => $row->pp_student_code,
                    'Angsuran1' => null,
                    'Angsuran2' => null,
                    'Angsuran3' => null,
                    'Angsuran4' => null,
                    'Sisa' => 0
                ]);
            }
                foreach($siswa as $rowsiswa){
                    if($rowsiswa->Noform == $row->pp_no_formulir){
                        $rowsiswa->Sisa = $rowsiswa->Sisa+intval(str_replace(',', '', $row->pp_sisa));
                        if($row->pp_angsuran==1)$rowsiswa->Angsuran1 = $row->pp_sisa;
                        if($row->pp_angsuran==2)$rowsiswa->Angsuran2 = $row->pp_sisa;
                        if($row->pp_angsuran==3)$rowsiswa->Angsuran3 = $row->pp_sisa;
                        if($row->pp_angsuran==4)$rowsiswa->Angsuran4 = $row->pp_sisa;
                    }
                }

        }
        $luarlunas = 0;
        $dalamlunas = 0;
        foreach($siswa as $rowsiswa){
            if(substr($rowsiswa->Kode,0,4)=='2023'){
                $jumlahluar++;
                if($rowsiswa->Sisa=='0'){
                    $luarlunas++;
                }
            } else {
                $jumlahdalam++;
                if($rowsiswa->Sisa=='0'){
                    $dalamlunas++;
                }
            }
        }
        $rekap = ['dalam' => ['jumlah' => $jumlahdalam,
                              'tunaiangsuran' => $jumlahdalamtunai.'/'.($jumlahdalam-$jumlahdalamtunai),
                              'lunasUP' => $dalamlunas,
                              'Angsuran1' => $jumlahdalamangsuran1.'/'.$jumlahdalamlunasangsuran1,
                              'Angsuran2' => $jumlahdalamangsuran2.'/'.$jumlahdalamlunasangsuran2,
                              'Angsuran3' => $jumlahdalamangsuran3.'/'.$jumlahdalamlunasangsuran3,
                              'Angsuran4' => $jumlahdalamangsuran4.'/'.$jumlahdalamlunasangsuran4],
                  'luar' => ['jumlah' => $jumlahluar,
                             'tunaiangsuran' => $jumlahluartunai.'/'.($jumlahluar-$jumlahluartunai),
                             'lunasUP' => $luarlunas,
                             'Angsuran1' => $jumlahluarangsuran1.'/'.$jumlahluarlunasangsuran1,
                             'Angsuran2' => $jumlahluarangsuran2.'/'.$jumlahluarlunasangsuran2,
                             'Angsuran3' => $jumlahluarangsuran3.'/'.$jumlahluarlunasangsuran3,
                             'Angsuran4' => $jumlahluarangsuran4.'/'.$jumlahluarlunasangsuran4],

                  ];
        return response()->json(['data' => $siswa, 'rekap' => $rekap, 'status' => 'sukses'],200);
    }

    public function absensi(Request $request){

        $this->validate($request, [
            'start' => 'required|date',
            'end' => 'required|date',
        ]);

        $user = $request->user();
        $absen = Absensi::with(['siswa' => function ($query) {
                                $query->select('id', 's_nama', 'uuid');
                            }])
                        ->whereBetween('absensi_tanggal',[$request->start,$request->end])
                        //->where('ab_status', 'Approved')
                        ->where('unit_id', $user->unit_id);

        if($request->siswa!=''){
            $q = $request->siswa;
            $absen = $absen->where(function ($query) use ($q) {
                            $query->whereHas('siswa', function($query) use($q){
                                        $query->where('uuid','like','%'.$q.'%');
                                    });
                        });
        }
        if($request->kelas!=''){
            $q = $request->kelas;
            $anggota = KelasAnggota::with('kelas')
                                    ->where(function ($query) use ($q) {
                                        $query->whereHas('kelas', function($query) use($q){
                                                    $query->where('kelas_nama',$q);
                                                });
                                        })
                                    ->where('periode_id',$user->periode)
                                    ->pluck('siswa_id');
            $absen = $absen->whereIn('siswa_id',$anggota);
        }

        $absen = $absen->get();
        $total = array('kelas7_Total'=> 0,
                        'kelas7_Sakit' => 0,
                        'kelas7_Ijin' => 0,
                        'kelas7_Alpha' => 0,
                        'kelas7_Covid' => 0,
                        'kelas8_Total'=> 0,
                        'kelas8_Sakit' => 0,
                        'kelas8_Ijin' => 0,
                        'kelas8_Alpha' => 0,
                        'kelas8_Covid' => 0,
                        'kelas9_Total'=> 0,
                        'kelas9_Sakit' => 0,
                        'kelas9_Ijin' => 0,
                        'kelas9_Alpha' => 0,
                        'kelas9_Covid' => 0,
                        'kelas7_Issued' => 0,
                        'kelas8_Issued' => 0,
                        'kelas9_Issued' => 0,

                    );
        $rekap = [];
        foreach ($absen as $row){
            $kelas = KelasAnggota::where('siswa_id',$row->siswa->id)->where('periode_id',$user->periode)->first();
            $kelasdetail = Kelas::where('id',$kelas['kelas_id'])->first();
            //if($kelasdetail['kelas_jenjang']==7){
            if($row->ab_status=='Approved'){
                $total['kelas'.$kelasdetail['kelas_jenjang'].'_Total']++;
                $total['kelas'.$kelasdetail['kelas_jenjang'].'_'.$row->absensi_jenis]++;
                $row['kelas'] = $kelas?$kelasdetail['kelas_nama']:'-';
                $row['absen'] = $kelas?$kelas['absen']:'-';
                if($row->ab_status=='Approved'&&!collect($rekap)->contains('id',$row->siswa->id)){
                    array_push($rekap, (object)[
                        'id' => $row->siswa->id,
                        'Nama' => $row->siswa->s_nama,
                        'Kelas' => $row->kelas,
                        'Absen' => $kelas['absen'],
                        'Sakit' => 0,
                        'Ijin' => 0,
                        'Alpha' => 0,
                        'Covid' => 0
                    ]);
                }

                foreach($rekap as $rowrekap){
                    if($rowrekap->id==$row->siswa_id){
                        $rowrekap->{$row->absensi_jenis}++;
                    }

                }
            } else {
                $total['kelas'.$kelasdetail['kelas_jenjang'].'_Issued']++;
            }
                // if($row->absensi_jenis=="Sakit")
                //     $total['kelas'.$kelasdetail['kelas_jenjang'].'_sakit']++;
                // if($row->absensi_jenis=="Ijin")
                //     $total['kelas7_ijin']++;
                // if($row->absensi_jenis=="Alpha")
                //     $total['kelas7_alpha']++;
                // if($row->absensi_jenis=="Covid")
                //     $total['kelas7_covid']++;
            // }
            // elseif($kelasdetail['kelas_jenjang']==8){
            //     $total['kelas8_total']++;
            //     if($row->absensi_jenis=="Sakit")
            //         $total['kelas8_sakit']++;
            //     if($row->absensi_jenis=="Ijin")
            //         $total['kelas8_ijin']++;
            //     if($row->absensi_jenis=="Alpha")
            //         $total['kelas8_alpha']++;
            //     if($row->absensi_jenis=="Covid")
            //         $total['kelas8_covid']++;
            // }
            // elseif($kelasdetail['kelas_jenjang']==9){
            //     $total['kelas9_total']++;
            //     if($row->absensi_jenis=="Sakit")
            //         $total['kelas9_sakit']++;
            //     if($row->absensi_jenis=="Ijin")
            //         $total['kelas9_ijin']++;
            //     if($row->absensi_jenis=="Alpha")
            //         $total['kelas9_alpha']++;
            //     if($row->absensi_jenis=="Covid")
            //         $total['kelas9_covid']++;
            // }

        }
        return response()->json(['status' => 'success', 'data' => $absen, 'total' => $total, 'rekap' => $rekap], 200);

    }

    public function pelanggaran(Request $request){

        $this->validate($request, [
            'start' => 'required|date',
            'end' => 'required|date',
        ]);

        $user = $request->user();

        $pelanggaran = Pelanggaran::with(['siswa' => function ($query) {
                                        $query->select('id', 's_nama', 'uuid');
                                    }])
                                ->with('masterpelanggaran')
                                ->whereBetween('pelanggaran_tanggal',[$request->start,$request->end])
                                ->where('unit_id', $user->unit_id);

        $rekap = [];
        $total = [];
        if($request->siswa!=''){
            $q = $request->siswa;
            $pelanggaran = $pelanggaran->where(function ($query) use ($q) {
                                            $query->whereHas('siswa', function($query) use($q){
                                                        $query->where('uuid','like','%'.$q.'%');
                                                    });
                                        });
        }
        if($request->kelas!=''){
            $q = $request->kelas;
            $anggota = KelasAnggota::with('kelas')
                                    ->where(function ($query) use ($q) {
                                        $query->whereHas('kelas', function($query) use($q){
                                                    $query->where('kelas_nama',$q);
                                                });
                                        })
                                    ->where('periode_id',$user->periode)
                                    ->pluck('siswa_id');
            $pelanggaran = $pelanggaran->whereIn('siswa_id',$anggota);
        }
        $pelanggaran = $pelanggaran->get();//->sortBy('siswa.s_nama');
        $masterpelanggaran = MasterPelanggaran::orderBy('mp_kategori')->get();

        foreach($pelanggaran as $row) {
            $kelas = KelasAnggota::where('siswa_id',$row->siswa->id)->where('periode_id',$user->periode)->first();
            $kelasdetail = Kelas::where('id',$kelas['kelas_id'])->first();
            $row['kelas'] = $kelas?$kelasdetail['kelas_nama']:'-';
            $row['absen'] = $kelas?$kelas['absen']:'-';
            if(!collect($total)->contains('ID',$row->siswa->id)){
                array_push($total, (object)[
                    'ID' => $row->siswa->id,
                    'Nama' => $row->siswa->s_nama,
                    'Kelas' => $row->kelas,
                    'Absen' => $row['absen'],
                    'Pelanggaran' => 0,
                ]);
            }
            foreach($total as $rowtotal){
                if($rowtotal->ID==$row->siswa_id){
                    $rowtotal->Pelanggaran++;
                }

            }
        }

        foreach($masterpelanggaran as $rowmp){
            $count = 0;
            foreach($pelanggaran as $rowp){
                if($rowp['mp_id']==$rowmp['id']){
                    $count++;
                }
            }
            if($count>0){
                array_push($rekap, (object)[
                    'mp_pelanggaran' => $rowmp->mp_pelanggaran,
                    'mp_kategori' => $rowmp->mp_kategori,
                    'jumlah' => $count,
                ]);
            }

            //$rowmp['jumlah'] = $count;
        }
        //$masterpelanggaran = $masterpelanggaran->toArray();
        $jumlah = array_column($rekap, 'jumlah');
        array_multisort($jumlah, SORT_DESC, $rekap);
        $jumlah = array_column($total, 'Pelanggaran');
        $kelas = array_column($total, 'Kelas');
        array_multisort($jumlah, SORT_DESC, $kelas, SORT_ASC, $total);
        $pelanggaran = $pelanggaran->toArray();
        return response()->json(['status' => 'SUKSES', 'data' => $pelanggaran, 'rekap' => $rekap, 'total' => $total],200);
    }

    public function nilai(Request $request){

        $user = $request->user();
        if($user->role!=0){
            $this->validate($request, [
                'kelas' => 'required'
            ]);
        }

        $dataNilai = NilaiSiswa::where('unit_id', $user->unit_id)
                                ->where('periode_id', $user->periode);
        $dataMapel = Mapel::get();
        $dataKelas = Kelas::where('unit_id',$user->unit_id)
                            ->where('k_jenis','REGULER')
                            ->where('periode_id', $user->periode)
                            ->get();

        if($request->kelas!=''){
            $kelas = $dataKelas->where('kelas_nama',$request->kelas)->pluck('id');
            $anggotaKelas = KelasAnggota::whereIn('kelas_id',$kelas)->get();
        } else{
            $kelas = $dataKelas->pluck('id');
            $anggotaKelas = KelasAnggota::whereIn('kelas_id',$dataKelas->pluck('id'))->get();
        }
        $dataNilai = $dataNilai->whereIn('siswa_id',$anggotaKelas->pluck('siswa_id'))->get();

        $mapelKurmer = ['PAK','PKN','BIN','BIG','MAT','BIO','FIS','EKO','GEO','SEJ','SNM','SNR','MEK','TIK','ORG','JWA','MAN','DC'];
        //$mapelKurtilas = ['PAK','PKN','BIN','BIG','MAT','BIO','FIS','EKO','GEO','SEJ','SNM','SNR','PKY','ORG','JWA','MAN'];
        $jenisNilai = ['KI3','KI4','PTS','PAS','SUM','SAS'];

        foreach($kelas as $rowkelas){
            $siswa = $anggotaKelas->where('kelas_id',$rowkelas)->pluck('siswa_id');
            foreach($mapelKurmer as $rowmapel){
                $idMapel = $dataMapel->where('mapel_kode',$rowmapel)->first();
                foreach($jenisNilai as $rowjenis){
                    $jumlahnilai = NilaiSiswa::where('periode_id',$user->periode)
                                                ->where('mapel_id',$idMapel->id)
                                                ->whereIn('siswa_id',$siswa)
                                                ->where('ns_jenis_nilai',$rowjenis)
                                                ->count();
                    $kelasnama = $dataKelas->where('id',$rowkelas)->first();
                    $rekap[$kelasnama->kelas_nama][$rowmapel][$rowjenis] = $jumlahnilai;
                }
            }
        }
        return response()->json($rekap,200);
    }
}
