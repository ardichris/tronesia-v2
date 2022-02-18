<?php

namespace App\Imports;

use Ramsey\Uuid\Uuid;
use App\Siswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToCollection;

class SiswasImport implements ToCollection, WithStartRow
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
            Siswa::create([ 'uuid' => Uuid::Uuid4(),
                        's_code' => $row[0],
                        's_nama' => $row[1],
                        's_nis' => $row[2],
                        's_nisn' => $row[3],
                        's_tempat_lahir' => $row[4],
                        's_tanggal_lahir' => $row[5],
                        's_kelamin' => $row[6],                        
                        'unit_id' => $this->siswa['unit'],
                        's_keterangan' => 'AKTIF']);
        }
    }
    public function startRow(): int
    {
        return 2;
    }
    public function  __construct($siswa)
    {
        $this->siswa= $siswa;
    }
}