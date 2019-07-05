<?php

namespace App\Http\Controllers;

use App\msArea;
use Illuminate\Http\Request;

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
}
