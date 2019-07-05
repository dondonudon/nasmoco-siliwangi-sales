<?php

namespace App\Http\Controllers;

use App\msArea;
use Illuminate\Http\Request;

class MsAreaController extends Controller
{
    public function index() {
        return msArea::all();
    }

    public function add(Request $request) {
        $nama = $request->nama;

        if (msArea::where('nama',$nama)->get()->count() == 0) {
            $area = new msArea;
            $area->nama = $nama;
            if ($area->save()) {
                $result = array([
                    'status' => 'success',
                ]);
            } else {
                $result = array([
                    'status' => 'failed',
                    'reason' => 'Penyimpanan data gagal',
                ]);
            }
        } else {
            $result = array([
                'status' => 'failed',
                'reason' => 'Nama Area sudah digunakan, silahkan memasukkan nama area lain',
            ]);
        }
        return $result;
    }
}
