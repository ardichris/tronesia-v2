<?php

namespace App\Exports;

use App\Siswa;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class SiswasExport implements FromView, WithColumnFormatting, ShouldAutoSize
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

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
