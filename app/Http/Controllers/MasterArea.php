<?php

namespace App\Http\Controllers;

use App\msArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MasterArea extends Controller
{
    public function index() {
        $viewName = 'master_area';
        $username = Session::get('username');
        $permission = DB::table('ms_permission')
            ->join('sys_menu','ms_permission.id_menu','=','sys_menu.id')
            ->where([
                ['ms_permission.username','=',$username],
                ['ms_permission.permission','=','1'],
                ['sys_menu.view_name','=',$viewName],
            ]);
        if ($permission->exists()) {
            return view('dashboard-master-area');
        } else {
            return abort('403');
        }
    }

    public static function getListArea() {
        $area = DB::table('ms_areas')
            ->select('id','nama','ord')
            ->get();
        return $area;
    }

    public function list() {
        return array(
            'data' => msArea::all()
        );
    }

    public function add(Request $request) {
        $area = new msArea;
        $area->nama = $request->area;
        $area->tgl_target_default = $request->target;
        $area->color = $request->color;
        $area->ord = $request->ord;
        if ($area->save()) {
            $result = [
                'status' => 'success',
            ];
        } else {
            $result = [
                'status' => 'failed',
                'reason' => 'Gagal menyimpan data',
            ];
        }
        return json_encode($result);
    }

    public function edit(Request $request) {
        $data = [
            'nama' => $request->area,
            'perbandingan' => $request->perbandingan,
            'tgl_target_default' => $request->target,
            'ord' => $request->ord,
        ];
        try {
            DB::table('ms_areas')->where('id', $request->id)->update($data);
        } catch (\Exception $ex) {
            dd('Exception Block',$ex);
        }

        $result = [
            'status' => 'success',
        ];
        return json_encode($result);
    }
}