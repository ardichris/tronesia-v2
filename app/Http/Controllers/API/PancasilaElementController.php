<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PancasilaElement;

class PancasilaElementController extends Controller
{
    public function index (Request $request) {
        $pe = PancasilaElement::get();
        return $pe;
    }
}
