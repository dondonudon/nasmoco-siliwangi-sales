<?php

namespace App\Http\Controllers;

use App\msUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MsUserController extends Controller
{
    public function index() {
        return DB::table('ms_users')
            ->select('username','nama_lengkap','created_at','updated_at')
            ->where('isDel','=','0')
            ->get();
    }

    public function add(Request $request) {
        $username = $request->username;
        $password = Crypt::encryptString($request->password);
        $namaLengkap = $request->nama_lengkap;

        if (msUser::where('username',$username)->get()->count() > 0) {
            $result = array([
                'status' => 'failed',
                'reason' => 'username not available',
            ]);
        } else {
            $user = new msUser;
            $user->username = $username;
            $user->password = $password;
            $user->nama_lengkap = $namaLengkap;

            if ($user->save()) {
                $result = array([
                    'status' => 'success'
                ]);
            } else {
                $result = array([
                    'status' => 'failed',
                    'reason' => 'save failed',
                ]);
            }
        }
        return $result;
    }

    public function Edit(Request $request) {
        $username = $request->username;
        $password = Crypt::encryptString($request->password);
        $namaLengkap = $request->nama_lengkap;
        $data = [
            'password' => $password,
            'nama_lengkap' => $namaLengkap,
        ];

        $user = msUser::where('username',$username);
        if ($user->get()->count() == 1) {
            if ($user->update($data)) {
                $result = array([
                    'status' => 'success',
                ]);
            } else {
                $result = array([
                    'status' => 'failed',
                    'reason' => 'save failed',
                ]);
            }
        } else {
            $result = array([
                'status' => 'failed',
                'reason' => 'username not available',
            ]);
        }
        return $result;
    }

    public function LoginAndroid(Request $request) {
        $username = $request->username;
        $password = $request->password;

        $user = msUser::where('username',$username)->get();
        if ($user->count() > 0) {
            $passUser = Crypt::decryptString($user[0]['password']);
            if ($password == $passUser) {
                $result = array([
                    'status' => 'success',
                    'username' => $user[0]['username'],
                    'nama' => $user[0]['nama_lengkap'],
                ]);
            } else {
                $result = array([
                    'status' => 'failed',
                    'reason' => 'wrong password',
                ]);
            }
        } else {
            $result = array([
                'status' => 'failed',
                'reason' => 'username not registered',
            ]);
        }
        return $result;
    }
}
