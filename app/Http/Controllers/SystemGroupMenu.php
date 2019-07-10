<?php

namespace App\Http\Controllers;

use App\sysMenuGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SystemGroupMenu extends Controller
{
    public function index() {
        return view('dashboard-system-group-menu');
    }

    public function list() {
        return array(
            'data' => sysMenuGroup::all()
        );
    }

    public function add(Request $request) {
        $data = [
            'nama' => $request->nama,
            'id_target' => $request->id_target,
            'icon' => $request->icon,
            'order' => $request->order,
        ];

        $group = DB::table('sys_menu_group');
        if ($group->insert($data)) {
            $result = [
                'status' => 'success'
            ];
        } else {
            $result = [
                'status' => 'failed'
            ];
        }
        return json_encode($result);
    }

    public function edit(Request $request) {
        $id = $request->id;
        $data = [
            'nama' => $request->nama,
            'id_target' => $request->id_target,
            'icon' => $request->icon,
            'order' => $request->order,
        ];

        $group = DB::table('sys_menu_group')->where('id','=',$id);
        if ($group->update($data)) {
            $result = [
                'status' => 'success'
            ];
        } else {
            $result = [
                'status' => 'failed'
            ];
        }
        return json_encode($result);
    }
}
