<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\UserCollection;
use DB;
use File;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $users = User::with('unit')->where('unit_id',$user->unit_id)->orderBy('created_at', 'DESC');//->teacher();
        if (request()->q != '') {
            $users = $users->where('name', 'LIKE', '%' . request()->q . '%');
        }
        $users = $users->paginate(10);
        return new UserCollection($users);
    }
    public function store(Request $request)
    {
        //VALIDASI
        $this->validate($request, [
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|string',
            'unit_id' => 'required'
            //'photo' => 'image'
        ]);
        /*DB::beginTransaction();
        try {
            $name = NULL;
            //APABILA ADA FILE YANG DIKIRIMKAN
            if ($request->hasFile('photo')) {
                //MAKA FILE TERSEBUT AKAN DISIMPAN KE STORAGE/APP/PUBLIC/COURIERS
                $file = $request->file('photo');
                $name = $request->email . '-' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/teachers', $name);
            }
            $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $request->password,
                    'photo' => $name,
                    'role' => $request->role,
                    'unit_id' => $request->unit_id['id']
            ]);
            //$user->assignRole('teacher');
            DB::commit();
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'data' => $e->getMessage()], 200);
        }*/
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            //'photo' => $name,
            'role' => $request->role,
            //'unit_id' => $request->unit_id['id']
        ]);
        return response()->json(['status' => 'success'], 200);
    }
    public function edit($id)
    {
        $user = User::find($id); //MENGAMBIL DATA BERDASARKAN ID
        return response()->json(['status' => 'success', 'data' => $user], 200);
    }

    public function view($id)
    {
        $user = User::find($id); //MENGAMBIL DATA BERDASARKAN ID
        return response()->json(['status' => 'success', 'data' => $user], 200);
    }

    public function update(Request $request, $id)
    {
        //VALIDASI DATA
        $this->validate($request, [
            'name' => 'required|string|max:150',
            'email' => 'required|email',
            'password' => 'nullable|min:6|string',
            'photo' => 'nullable|image'
        ]);

        try {
            $user = User::find($id); //MENGAMBIL DATA YANG AKAN DI UBAH
            //JIKA FORM PASSWORD TIDAK DI KOSONGKAN, MAKA PASSWORD AKAN DIPERBAHARUI
            $password = $request->password != '' ? $request->password:$user->password;
            $filename = $user->photo; //NAMA FILE FOTO SEBELUMNYA
            $email = $request->email;

            //JIKA ADA FILE BARU YANG DIKIRIMKAN
            if ($request->hasFile('photo')) {
                //MAKA FOTO YANG LAMA AKAN DIGANTI
                $file = $request->file('photo');
                //DAN FILE FOTO YANG LAMA AKAN DIHAPUS
                File::delete(storage_path('app/public/teachers/' . $filename));
                $filename = $request->email . '-' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/teachers', $filename);
            }

            //PERBAHARUI DATA YANG ADA DI DATABASE
            $user->update([
                'name' => $request->name,
                'full_name' => $request->full_name,
                'email' => $email,
                'password' => $password,
                'photo' => $filename,

            ]);
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'data' => $e->getMessage()], 200);
        }
    }

    public function destroy($id)
    {
        $user = User::find($id); //MENGAMBIL DATA YANG AKAN DIHAPUS
        File::delete(storage_path('app/public/teachers/' . $user->photo)); //MENGHAPUS FILE FOTO
        $user->delete(); //MENGHAPUS DATANYA
        return response()->json(['status' => 'success']);
    }

    public function userLists()
    {
        $user = User::where('role', '!=', 3)->get();
        return new UserCollection($user);
    }

    public function getUserLogin()
    {
        $user = request()->user(); //MENGAMBIL USER YANG SEDANG LOGIN
        $permissions = [];
        foreach (Permission::all() as $permission) {
            //JIKA USER YANG SEDANG LOGIN PUNYA PERMISSION TERKAIT
            if (request()->user()->can($permission->name)) {
                $permissions[] = $permission->name; //MAKA PERMISSION TERSEBUT DITAMBAHKAN
            }
        }
        $user['permission'] = $permissions; //PERMISSION YANG DIMILIKI DIMASUKKAN KE DALAM DATA USER.
        return response()->json(['status' => 'success', 'data' => $user]);
    }
}
