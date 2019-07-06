<?php

namespace App\Http\Controllers;

use App\msUser;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class MasterUser extends Controller
{
    public function index() {
        return view('dashboard-master-user');
    }

    public function list() {
        return array(
            'data' => DB::table('ms_users')
                ->select('username','nama_lengkap')
                ->where('isDel',0)
                ->get()
        );
    }

    public function new(Request $request) {
        $username = $request->username;
        $password = Crypt::encryptString($request->password);
        $namaLengkap = $request->nama_lengkap;
        $data = [
            'username' => $username,
            'password' => $password,
            'nama_lengkap' => $namaLengkap,
        ];

        $checkUser = DB::table('ms_users')->where('username',$username);
        if ($checkUser->doesntExist()) {
            $user = DB::table('ms_users');
            if ($user->insert($data)) {
                $result = [
                    'status' => 'success'
                ];
            } else {
                $result = [
                    'status' => 'failed',
                    'reason' => 'Gagal tersimpan, silahkan coba lagi'
                ];
            }
        } else {
            $result = [
                'status' => 'failed',
                'reason' => 'username sudah terdaftar'
            ];
        }
        return json_encode($result);
    }

    public function edit(Request $request) {
        $username = $request->username;
        $password = Crypt::encryptString($request->password);
        $namaLengkap = $request->nama_lengkap;
        $data = [
            'password' => $password,
            'nama_lengkap' => $namaLengkap,
        ];

        $checkUser = DB::table('ms_users')->where('username',$username);
        if ($checkUser->exists()) {
            $user = DB::table('ms_users')->where('username',$username);
            if ($user->update($data)) {
                $result = [
                    'status' => 'success'
                ];
            } else {
                $result = [
                    'status' => 'failed',
                    'reason' => 'Gagal tersimpan, silahkan coba lagi'
                ];
            }
        } else {
            $result = [
                'status' => 'failed',
                'reason' => 'username tidak terdaftar'
            ];
        }
        return json_encode($result);
    }

    public function disable(Request $request) {
        $username = $request->username;
        $data = [
            'isDel' => '1',
        ];

        $checkUser = DB::table('ms_users')->where('username',$username);
        if ($checkUser->exists()) {
            $user = DB::table('ms_users')->where('username',$username);
            if ($user->update($data)) {
                $result = [
                    'status' => 'success'
                ];
            } else {
                $result = [
                    'status' => 'failed',
                    'reason' => 'Gagal tersimpan, silahkan coba lagi'
                ];
            }
        } else {
            $result = [
                'status' => 'failed',
                'reason' => 'username tidak terdaftar'
            ];
        }
        return json_encode($result);
    }
}
