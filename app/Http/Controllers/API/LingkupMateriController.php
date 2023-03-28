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
        $semester = Periode::whereId($user->periode)->value('p_semester');
        $lms = LingkupMateri::where('lm_grade', $request->j)
                            ->where('lm_semester', $semester)
                            ->with('mapel');
        if($request->m) {
            $mapel = Mapel::where('mapel_kode', $request->m)->value('id');
            $lms = $lms->where('mapel_id', $mapel);
        }
        $lms = $lms->get();
        return response()->json(['data' => $lms], 200);
    }
}
