<?php

namespace App\Http\Controllers;

use App\msLeasing;
use Illuminate\Http\Request;

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
        return $result;
    }
}
