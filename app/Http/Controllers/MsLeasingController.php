<?php

namespace App\Http\Controllers;

use App\msLeasing;
use Illuminate\Http\Request;

class MsLeasingController extends Controller
{
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
