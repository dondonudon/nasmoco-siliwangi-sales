<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PenjualanSummary extends Controller
{
    public function index() {
        $viewName = 'penjualan_baru';
        $username = Session::get('username');
        $permission = DB::table('ms_permission')
            ->join('sys_menu','ms_permission.id_menu','=','sys_menu.id')
            ->where([
                ['ms_permission.username','=',$username],
                ['ms_permission.permission','=','1'],
                ['sys_menu.view_name','=',$viewName],
            ]);
        if ($permission->exists()) {
            return view('dashboard-penjualan-summary');
        } else {
            return abort('403');
        }
    }

    public function getPenjualan(Request $request) {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $status = $request->status;
        $cols = array(
            array(
                "id" => 'noSpk',
                "type" => 'string',
            ),
            array(
                "id" => 'area',
                "type" => 'string',
            ),
            array(
                "id" => 'color',
                "type" => 'string',
                "role" => 'style',
            ),
            array(
                "id" => 'Start',
                "type" => 'date',
            ),
            array(
                "id" => 'End',
                "type" => 'date',
            ),
        );
        $penjualan = DB::table('penjualan_mst')
            ->select('penjualan_mst.no_spk as no_spk','ms_areas.nama as area','ms_areas.color as color','penjualan_mst.tanggal_spk as start','penjualan_trn.tanggal as end')
            ->join('penjualan_trn','penjualan_mst.no_spk','=','penjualan_trn.no_spk')
            ->join('ms_areas','penjualan_trn.id_area','=','ms_areas.id')
            ->orderBy('no_spk')
            ->where('penjualan_mst.finish',$status)
            ->whereBetween('penjualan_mst.tanggal_spk',[$startDate,$endDate]);
//        if ($penjualan->exists()) {
//
//        }
        $rPenjualan = array();
        foreach ($penjualan->get() as $p) {
            $rPenjualan[]['c'] = array(
                array(
                    'v' => $p->no_spk,

                ),
                array(
                    'v' => $p->area,

                ),
                array(
                    'v' => $p->color,

                ),
                array(
                    'v' => 'Date('.date('Y, m, d',strtotime($p->start)).')',

                ),
                array(
                    'v' => 'Date('.date('Y, m, d',strtotime("+1 day", strtotime($p->end))).')',

                ),

            );
        }
        $result = array(
            'cols' => $cols,
            'rows' => $rPenjualan,
        );
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}
