<?php

namespace App\Http\Controllers;

use App\penjualanMst;
use Illuminate\Http\Request;

class PenjualanBaru extends Controller
{
    public function index() {
        return view('dashboard-penjualan-baru');
    }

    public function list() {
        $result['data'] = penjualanMst::all();
        return json_encode($result);
    }
}
