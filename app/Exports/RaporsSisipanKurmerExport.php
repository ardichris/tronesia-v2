<?php

namespace App\Exports;

use App\RaporSisipan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RaporsSisipanKurmerExport implements FromView, ShouldAutoSize
{
    protected $rapor;

    public function __construct($rapor)
    {
        $this->rapor = $rapor;
    }

    public function view(): View
    {
        //LOAD VIEW transaction.blade.php DAN PASSING DATA YANG DIMINTA DIATAS
        return view('exports.raporssisipankurmer', [
            'rapor' => $this->rapor
        ]);
    }
}
