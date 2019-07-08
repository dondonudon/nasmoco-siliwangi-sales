<?php

namespace App\Http\Controllers;

use App\msUser;
use App\sysMenuGroup;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function loginCheck() {
        if (Session::has('username')) {
            return redirect('dashboard');
        } else {
            return view('dashboard-login');
        }
    }

    public function login(Request $request) {
        $username = $request->username;
        $password = $request->password;

        $user = msUser::where('username',$username)->get();
        if ($user->count() > 0) {
            $passUser = Crypt::decryptString($user[0]['password']);
            if ($password == $passUser) {
                Session::put('username',$username);
                Session::put('nama_lengkap',$user[0]['nama_lengkap']);

                $result = array([
                    'status' => 'success'
                ]);
            } else {
                $result = array([
                    'status' => 'failed',
                    'reason' => 'Cek kembali username dan password anda!',
                ]);
            }
        } else {
            $result = array([
                'status' => 'failed',
                'reason' => 'Cek kembali username dan password anda!',
            ]);
        }
        return json_encode($result);
    }

//    public function sidebar() {
//        $data = [];
//        $group = DB::table('sys_menu_groups')->orderBy('order')->get();
//        foreach ($group AS $g) {
//            $menu = DB::table('sys_menus')->orderBy('order')->get();
//            foreach ($menu AS $m)
//            $data[] = [
//                'nama' => $g['nama'],
//                'icon' => $g['icon'],
//                'menu' => [],
//            ];
//        }
//    }

    public function index() {
        if (!Session::has('username')) {
            return redirect('dashboard/login');
        } else {
            return view('dashboard-overview');
        }
    }
}
