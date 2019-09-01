<?php

namespace App\Http\Controllers\OpenFunction;

use App\pembayaranAR;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PembayaranARBaru extends Controller
{
    public static function add($noSPK,$nominal) {
        try {
            $ar = new pembayaranAR();
            $ar->no_spk = $noSPK;
            $ar->nominal = $nominal;
            $ar->save();
        } catch (\Exception $ex) {
            return dd($ex);
        }
        return 'success';

    }
}
