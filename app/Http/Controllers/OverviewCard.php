<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OverviewCard extends Controller
{
    public static function infoDashboard() {
        $dateStart = date('Y-m-1');
        $dateEnd = date('Y-m-t');

        $mst = DB::table('penjualan_mst')->whereBetween('tanggal_spk',[$dateStart,$dateEnd])->count();
        $area = DB::table('ms_areas')
            ->select('id','nama','color')
            ->orderBy('ord','asc')
            ->get();
        $trn = DB::table('penjualan_trn')
            ->select('id_area')
            ->where('status','=','0')
            ->get();

        $result['spk'] = $mst;
        foreach ($area as $a) {
            $counter = 0;
            foreach ($trn as $t) {
                if ($t->id_area == $a->id) {
                    $counter++;
                }
            }
            $result['info'][$a->nama] = [
//                'x' => count($x),
                'x' => $counter,
                'color' => $a->color,
            ];
        }

        return $result;
    }
}
