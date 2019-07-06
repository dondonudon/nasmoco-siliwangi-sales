<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenjualanBaru extends Controller
{
    public function index() {
        return view('dashboard-penjualan-baru');
    }
}
