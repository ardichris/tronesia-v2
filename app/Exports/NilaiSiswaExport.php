<?php

namespace App\Exports;

use App\NilaiSiswa;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class NilaiSiswaExport implements FromView, ShouldAutoSize
{
    protected $download;

    public function __construct($download)
    {
        $this->download = $download;
    }

    public function view(): View
    {
        //LOAD VIEW transaction.blade.php DAN PASSING DATA YANG DIMINTA DIATAS
        return view('exports.nilaisiswa', [
            'data' => $this->download
        ]);
    }
}
