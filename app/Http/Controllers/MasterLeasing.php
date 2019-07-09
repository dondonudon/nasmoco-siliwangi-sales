<?php

namespace App\Http\Controllers;

use App\msLeasing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterLeasing extends Controller
{
    public function index() {
        return view('dashboard-master-leasing');
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
