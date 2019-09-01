<?php

namespace App\Http\Controllers;

use App\msLeasing;
use App\sysMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class MasterLeasing extends Controller
{
    public function index() {
        $viewName = 'master_leasing';
        $username = Session::get('username');
        $permission = DB::table('ms_permission')
            ->join('sys_menu','ms_permission.id_menu','=','sys_menu.id')
            ->where([
                ['ms_permission.username','=',$username],
                ['ms_permission.permission','=','1'],
                ['sys_menu.view_name','=',$viewName],
            ]);
        if ($permission->exists()) {
            return view('dashboard-master-leasing');
        } else {
            return abort('403');
        }
    }

    public function list() {
        return array(
            'data' => msLeasing::all(),
        );
    }

    public function add(Request $request) {
        $nama = $request->nama;

        $leasing = new msLeasing;
        $leasing->nama = $nama;

        if ($leasing->save()) {
            $result = ['status' => 'success'];
        } else {
            $result = ['status' => 'failed'];
        }
        return json_encode($result);
    }

    public function edit(Request $request) {
        $nama = $request->nama;
        $id = $request->id;

        $leasing = DB::table('ms_leasings')->where('id','=',$id);
        if ( $leasing->update(['nama' => $nama]) ) {
            $result = ['status' => 'success'];
        } else {
            $result = ['status' => 'failed'];
        }
        return json_encode($result);
    }

    public function delete(Request $request) {
        $id = $request->id;

        $leasing = DB::table('ms_leasings')->where('id','=',$id);
        if ( $leasing->update(['isDel' => '1']) ) {
            $result = ['status' => 'success'];
        } else {
            $result = ['status' => 'failed'];
        }
        return json_encode($result);
    }
}
