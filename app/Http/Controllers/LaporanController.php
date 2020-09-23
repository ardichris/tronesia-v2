<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Jurnal;

use PDF;

class LaporanController extends Controller
{
    public function index()
    {
    	$pegawai = Jurnal::all();
    	return view('pegawai',['pegawai'=>$pegawai]);
    }

    public function cetak_pdf()
    {
    	$jurnal = Jurnal::all();

    	$pdf = PDF::loadview('print',['jurnals'=>$jurnal]);
    	return $pdf->download('laporan-jurnal-pdf');
    }
}