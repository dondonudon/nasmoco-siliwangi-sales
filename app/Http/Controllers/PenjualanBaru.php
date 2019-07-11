<?php

namespace App\Http\Controllers;

use App\msWilayahKota;
use App\penjualanMst;
use App\penjualanTrn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PenjualanBaru extends Controller
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
            return view('dashboard-penjualan-baru');
        } else {
            return abort('403');
        }
    }

    public function list() {
        $result['data'] = penjualanMst::all();
        $result['data'] = DB::table('penjualan_mst')
            ->select('no_spk','nama_customer','no_rangka','ms_leasings.nama as id_leasing','ms_wilayah_kotas.nama as id_kota','ms_wilayah_kecamatans.nama as id_kecamatan','alamat','tanggal_spk','username','finish')
            ->join('ms_leasings','penjualan_mst.id_leasing','=','ms_leasings.id')
            ->join('ms_wilayah_kotas','penjualan_mst.id_kota','=','ms_wilayah_kotas.id')
            ->join('ms_wilayah_kecamatans','penjualan_mst.id_kecamatan','=','ms_wilayah_kecamatans.id')
            ->get();
        return json_encode($result);
    }

    public function leasing() {
        $result = DB::table('ms_leasings')
            ->select('id','nama')
            ->get();
        return json_encode($result);
    }

    public function kota() {
        $result = DB::table('ms_wilayah_kotas')
            ->select('id','id_provinsi','nama')
            ->where('id_provinsi','=','33')
            ->get();
        return json_encode($result);
    }

    public function kecamatan(Request $request) {
        $kota = $request->kota;
        $result = DB::table('ms_wilayah_kecamatans')
            ->select('id','id_kota','nama')
            ->where('id_kota','=',$kota)
            ->get();
        return json_encode($result);
    }

//    public function addTrn($idMst) {
//        $trn = DB::table('penjualan_trn');
//        $area = DB::table('ms_areas')->select('id')->get();
//        foreach ($area as $v) {
//            $data = [
//                'id_penjualan_mst' => $idMst,
//                'id_area' => $v->id,
//                'username' => Session::get('username'),
//            ];
//            $trn->insert($data);
//        }
//    }

    public function add(Request $request) {
        $noSPK = $request->no_spk;
        $data = [
            'no_spk' => $request->no_spk,
            'nama_customer' => $request->nama_customer,
            'no_rangka' => $request->no_rangka,
            'id_leasing' => $request->id_leasing,
            'id_kota' => $request->id_kota,
            'id_kecamatan' => $request->id_kecamatan,
            'alamat' => $request->alamat,
            'tanggal_spk' => date("Y-m-d", strtotime($request->tanggal_spk)),
            'username' => $request->username,
        ];
        $penjualan = DB::table('penjualan_mst');
        if ($penjualan->where('no_spk','=',$noSPK)->doesntExist()) {
            if ($penjualan->insert($data)) {
                $trn = DB::table('penjualan_trn');
                $area = DB::table('ms_areas')->select('id')->get();
                foreach ($area as $v) {
                    $data = [
                        'id_penjualan_mst' => $noSPK,
                        'id_area' => $v->id,
                        'username' => Session::get('username'),
                    ];
                    $trn->insert($data);
                }
                $result = [
                    'status' => 'success',
                ];
            } else {
                $result = [
                    'status' => 'failed',
                    'reason' => 'gagal menyimpan data',
                ];
            }
        } else {
            $result = [
                'status' => 'failed',
                'reason' => 'No SPK sudah terdaftar',
            ];
        }
        return json_encode($result);
    }
}
