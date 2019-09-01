<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OverviewCard extends Controller
{
    public static function infoDashboard() {
        $startdate = date('Y-m-d',strtotime('first day of this month',time()));
        $enddate = date('Y-m-d',strtotime('last day of this month',time()));

//        $mst = DB::table('penjualan_mst')->whereBetween('created_at',[$dateStart,$dateEnd])->count();
        $SPKBulanIni = DB::table('penjualan_mst')
            ->select(DB::raw('COUNT(no_spk) as total'))
            ->whereBetween('created_at',[$startdate,$enddate])
            ->first();
        $SPKBlmValidasi = DB::table('penjualan_trn')
            ->select('ms_areas.nama','id_area',DB::raw('COUNT(no_spk) as total'))
            ->join('ms_areas','penjualan_trn.id_area','=','ms_areas.id')
            ->where('tanggal','=',null)
            ->whereBetween('tanggal_target',[$startdate,$enddate])
            ->groupBy('id_area')
            ->get()->toArray();

        $result['spk_bulan_ini'] = $SPKBulanIni;
        $result['spk_belum_validasi'] = $SPKBlmValidasi;

        return $result;
    }

    public function listSPK(Request $request) {
        $startdate = date('Y-m-d',strtotime('first day of this month',time()));
        $enddate = date('Y-m-d',strtotime('last day of this month',time()));
        $idArea = $request->id;

        try {
            $spk = DB::table('penjualan_trn')
                ->select('penjualan_trn.no_spk','penjualan_mst.nama_customer')
                ->join('penjualan_mst','penjualan_trn.no_spk','=','penjualan_mst.no_spk')
                ->where('id_area','=',$idArea)
                ->where('tanggal','=',null)
                ->whereBetween('tanggal_target',[$startdate,$enddate])
                ->get();
        } catch (\Exception $ex) {
            dd('Exception Block',$ex);
        }
        return json_encode($spk);
    }
}
