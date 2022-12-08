<?php

namespace App\Imports;

use App\PembayaranPsb;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToCollection;

class PembayaransImport implements ToCollection, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $tanggal = $row[11]?strtotime($row[11]):null;
            $cekdata = null;
            $cekdata = PembayaranPsb::where('pp_no_formulir',$row[1])
                                    ->where('pp_angsuran', $row[9])
                                    ->first();
            if(is_null($cekdata)){
                PembayaranPsb::create([
                    'pp_no_formulir' => $row[1],
                    'pp_student_code' => $row[2],
                    'pp_student_name' => $row[3],
                    'pp_bruto' => $row[4],
                    'pp_subsidi' => $row[5],
                    'pp_tunai' => $row[6],
                    'pp_keterangan' => $row[7],
                    'pp_coa' => $row[8],
                    'pp_angsuran' => $row[9],
                    'pp_biaya' => $row[10],
                    'pp_tanggal' => $tanggal?date('Y-m-d h:i:s', $tanggal):null,
                    'pp_pembayaran' => $row[12],
                    'pp_terbayar' => $row[13],
                    'pp_sisa' => $row[14],
                    'unit_id' => $this->pembayaran['unit'],
                    'periode_id' => $this->pembayaran['periode']
                ]);
            } else {
                $cekdata->update([
                    'pp_student_code' => $row[2],
                    'pp_student_name' => $row[3],
                    'pp_bruto' => $row[4],
                    'pp_subsidi' => $row[5],
                    'pp_tunai' => $row[6],
                    'pp_keterangan' => $row[7],
                    'pp_coa' => $row[8],
                    'pp_biaya' => $row[10],
                    'pp_tanggal' => $tanggal?date('Y-m-d h:i:s', $tanggal):null,
                    'pp_pembayaran' => $row[12],
                    'pp_terbayar' => $row[13],
                    'pp_sisa' => $row[14],
                ]);
            }

        }
    }
    public function startRow(): int
    {
        return 2;
    }
    public function  __construct($pembayaran)
    {
        $this->pembayaran= $pembayaran;
    }
}
