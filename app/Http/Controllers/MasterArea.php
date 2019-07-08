<?php

namespace App\Http\Controllers;

use App\msArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterArea extends Controller
{
    public function index() {
        return view('dashboard-master-area');
    }

    public function list() {
        return array(
            'data' => msArea::all()
        );
    }

    public function add(Request $request) {
        $area = new msArea;
        $area->nama = $request->area;
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
        $data = ['nama' => $request->area];
        $area = DB::table('ms_areas')->where('id', $request->id);

        if ($area->update($data)) {
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
}
