<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\LingkupMateri;
use App\Mapel;
use App\Periode;

class LingkupMateriController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $semester = substr(Periode::whereId($user->periode)->value('p_semester'),0,1);
        $mapel = Mapel::where('mapel_kode', $request->m)->value('id');
        $lms = LingkupMateri::where('mapel_id', $mapel)
                            ->where('lm_grade', $request->j)
                            ->where('lm_semester', $semester)
                            ->get();
        return response()->json(['data' => $lms], 200);
    }
}
