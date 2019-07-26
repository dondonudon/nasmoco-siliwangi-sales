<?php

namespace App\Http\Controllers;

use App\msPermission;
use App\msUser;
use App\msUserArea;
use App\sysMenu;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MasterUser extends Controller
{
    public function serializePermission($data,$username) {
        $menu = sysMenu::all();
        $permission = [];
        foreach ($menu as $m) {
            if (in_array($m->id,$data)) {
                $isAllowed = '1';
            } else {
                $isAllowed = '0';
            }
            $permission[] = [
                'username' => $username,
                'id_menu' => $m->id,
                'permission' => $isAllowed,
            ];
        }
        return $permission;
    }

    function serializeArea($data,$username) {
        $area = [];
        foreach ($data as $d) {
            $area[] = [
                'username' => $username,
                'id_area' => $d,
            ];
        }
        return $area;
    }

    public function index() {
        $viewName = 'master_user';
        $username = Session::get('username');
        $permission = DB::table('ms_permission')
            ->join('sys_menu','ms_permission.id_menu','=','sys_menu.id')
            ->where([
                ['ms_permission.username','=',$username],
                ['ms_permission.permission','=','1'],
                ['sys_menu.view_name','=',$viewName],
            ]);
        if ($permission->exists()) {
            return view('dashboard-master-user');
        } else {
            return abort('403');
        }
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
        $permission = $this->serializePermission($request->menu_permission,$username);
        $area = $this->serializeArea($request->area_permission,$username);

        $savePermission = [];
        $data = [
            'username' => $username,
            'password' => $password,
            'nama_lengkap' => $namaLengkap,
        ];

        $checkUser = DB::table('ms_users')->where('username',$username);
        if ($checkUser->doesntExist()) {
            $user = DB::table('ms_users');
            if ($user->insert($data)) {
                if (DB::table('ms_permission')->insert($permission)) {
                    if (DB::table('ms_user_areas')->insert($area)) {
                        $result = [
                            'status' => 'success'
                        ];
                    } else {
                        $result = [
                            'status' => 'failed',
                            'reason' => 'Gagal menyimpan area'
                        ];
                    }
                } else {
                    $result = [
                        'status' => 'failed',
                        'reason' => 'Gagal menyimpan permission'
                    ];
                }
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
        $permission = $this->serializePermission($request->menu_permission,$username);
        $area = $this->serializeArea($request->area_permission,$username);

        $data = [
            'password' => $password,
            'nama_lengkap' => $namaLengkap,
        ];

        $checkUser = DB::table('ms_users')->where('username',$username);
        if ($checkUser->exists()) {
            $user = DB::table('ms_users')->where('username',$username);
            if ($user->update($data)) {
                $del = DB::table('ms_permission')->where('username','=',$username);
                if ($del->delete()) {
                    if (msPermission::insert($permission)) {
                        $del = DB::table('ms_user_areas')->where('username','=',$username);
                        if ($del->delete()) {
                            if (msUserArea::insert($area)) {
                                $result = [
                                    'status' => 'success'
                                ];
                            } else {
                                $result = [
                                    'status' => 'failed',
                                    'reason' => 'Gagal menyimpan area'
                                ];
                            }
                        } else {
                            $result = [
                                'status' => 'failed',
                                'reason' => 'Gagal menghapus area'
                            ];
                        }
                    } else {
                        $result = [
                            'status' => 'failed',
                            'reason' => 'Gagal menyimpan permission'
                        ];
                    }
                } else {
                    $result = [
                        'status' => 'failed',
                        'reason' => 'Gagal menghapus permission lama'
                    ];
                }
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

    public function permission(Request $request) {
        $username = $request->username;
        $permission = DB::table('ms_permission')
            ->select('id_menu')
            ->where([
                ['username','=',$username],
                ['permission','=','1'],
            ])
            ->get();
        $area = DB::table('ms_user_areas')
            ->select('id_area')
            ->where([
                ['username','=',$username],
            ])
            ->get();

        $result = array(
            'permission' => $permission,
            'area' => $area,
        );
        return json_encode($result);
    }
}
