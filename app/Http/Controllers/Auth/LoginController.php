<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\User;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request)
    {
        //VALIDASI EMAIL DAN PASSWORD YANG DIKIRIMKAN
        /*$this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);*/

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
            'periode' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages(), 'status' => 422], 200);
        }
        //ADA 3 VALUE YANG DIKIRIMKAN, YAKNI: EMAIL, PASSWORD DAN REMEMBER_ME
        //AMBIL SEMUA REQUEST TERSEBUT KECUALI REMEMBER ME KARENA YANG DIBUTUHKAN 
        //UNTUK OTENTIKASI ADALAH EMAIL DAN PASSWORD
        $auth = $request->except(['remember_me','periode']);
        
        //MELAKUKAN PROSES OTENTIKASI
        if (auth()->attempt($auth, $request->remember_me)) {
            //APABILA BERHASIL, GENERATE API_TOKEN MENGGUNAKAN STRING RANDOM
            auth()->user()->update(['api_token' => Str::random(40),'periode' => $request->periode]);
            //$periode = User::whereEmail($request->email)->first();
            //$periode = $periode->update('periode',$request->periode);
            //KEMUDIAN KIRIM RESPONSENYA KE CLIENT UNTUK DIPROSES LEBIH LANJUT
            return response()->json(['status' => 'success', 'data' => auth()->user()->api_token], 200);
        }
        //APABILA GAGAL, KIRIM RESPONSE LAGI KE BAHWA PERMINTAAN GAGAL
        return response()->json(['status' => 'failed']);
    }
}
