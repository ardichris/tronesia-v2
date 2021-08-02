<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\NilaiSiswa;
use App\Http\Resources\NilaiSiswaCollection;

class NilaiSiswaController extends Controller
{
    public function index(Request $request) {
        $user = $request->user();
        $nilai = NilaiSiswa::where('siswa_id',1551);            
        return new NilaiSiswaCollection($nilai->paginate(10));
    }
}
