<?php

namespace App\Http\Controllers;

use App\msUser;
use App\sysMenu;
use App\sysMenuGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public static function getAllSidebar() {
        $listSidebar = array();
        $group = sysMenuGroup::all();
        foreach ($group as $g) {
            $listMenu = array();
            $viewName = array();
            $menu = DB::table('sys_menu')
                ->select('id','nama','url','view_name')
                ->where('id_group','=',$g->id)
                ->get();
            foreach ($menu as $m) {
                $listMenu[] = array(
                    'id' => $m->id,
                    'nama' => $m->nama,
                    'url' => $m->url,
                );
                $viewName[] = $m->view_name;
            }
            $listSidebar[] = array(
                'group' => array(
                    'nama' => $g->nama,
                    'id_target' => $g->id_target,
                    'icon' => $g->icon,
                    'url' => $viewName,
                ),
                'menu' => $listMenu,
            );
        }
        return $listSidebar;
    }

    public static function getSidebar() {
        $username = Session::get('username');
        $group = DB::table('sys_menu_group')
            ->select('sys_menu_group.id','sys_menu_group.nama','sys_menu_group.id_target','sys_menu_group.icon')
            ->join('sys_menu','sys_menu_group.id','=','sys_menu.id_group')
            ->join('ms_permission','sys_menu.id','=','ms_permission.id_menu')
            ->where([
                ['ms_permission.username','=',$username],
                ['ms_permission.permission','=','1']
            ])
            ->orderBy('sys_menu_group.order','asc')
            ->distinct()
            ->get();
        $listSidebar = array();
//        $group = sysMenuGroup::all();
        foreach ($group as $g) {
            $listMenu = array();
            $viewName = array();
            $menu = DB::table('sys_menu')
                ->select('sys_menu.id','sys_menu.nama','sys_menu.url','sys_menu.view_name')
                ->join('ms_permission','sys_menu.id','=','ms_permission.id_menu')
                ->where([
                    ['id_group','=',$g->id],
                    ['ms_permission.username','=',$username],
                    ['ms_permission.permission','=','1'],
                ])
                ->orderBy('sys_menu.order')
                ->get();
            foreach ($menu as $m) {
                $listMenu[] = array(
                    'id' => $m->id,
                    'nama' => $m->nama,
                    'url' => $m->url,
                );
                $viewName[] = $m->view_name;
            }
            $listSidebar[] = array(
                'group' => array(
                    'nama' => $g->nama,
                    'id_target' => $g->id_target,
                    'icon' => $g->icon,
                    'url' => $viewName,
                ),
                'menu' => $listMenu,
            );
        }
        return $listSidebar;
    }

    public function login() {
        if (Session::has('username')) {
            return redirect('dashboard');
        } else {
            return view('dashboard-login');
        }
    }

    public function loginCheck(Request $request) {
        $username = $request->username;
        $password = $request->password;

        $user = DB::table('ms_users')->where('username','=',$username);
        if ($user->exists()) {
            $dataUser = $user->first();
            $passUser = Crypt::decryptString($dataUser->password);
            if ($password == $passUser) {
                Session::put('username',$username);
                Session::put('nama_lengkap',$dataUser->nama_lengkap);

                $result = [
                    'status' => 'success'
                ];
            } else {
                $result = [
                    'status' => 'failed',
                    'reason' => 'Password Salah',
                ];
            }
        } else {
            $result = [
                'status' => 'failed',
                'reason' => 'User tidak terdaftar',
            ];
        }
        return json_encode($result);
    }

    public function index() {
        if (!Session::has('username')) {
            return redirect('dashboard/login');
        } else {
            return view('dashboard-overview');
        }
    }

    public function sessionFlush() {
        Session::flush();
        if(Session::has('username')) {
            $result = [
                'status' => 'failed'
            ];
        } else {
            $result = [
                'status' => 'success'
            ];
        }
        return json_encode($result);
    }

    public function register() {
        return view('dashboard-register');
    }

    public function registerSubmit(Request $request) {
        $username = $request->username;
        $email = $request->email;
        $password = Crypt::encryptString($request->password);
        $menuPermission = $request->menu_permission;
        $areaPermission = $request->area_permission;

        $user = new msUser;
        $user->username = $username;
    }
}
