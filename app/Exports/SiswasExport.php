<?php

namespace App\Exports;

use App\Siswa;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SiswasExport implements FromView, ShouldAutoSize
{
    protected $siswa;
    
    public function __construct($siswa)
    {
        $this->siswa = $siswa;
    }

    public function view(): View
    {
        //LOAD VIEW transaction.blade.php DAN PASSING DATA YANG DIMINTA DIATAS
        return view('exports.siswas', [
            'siswa' => $this->siswa
        ]);
    }
}
