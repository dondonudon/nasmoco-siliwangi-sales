<?php

namespace App\Http\Controllers;

use App\msArea;
use App\msLeasing;
use App\msWilayahKecamatan;
use App\msWilayahKota;
use App\penjualanMst;
use App\penjualanTrn;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

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

    public function add(Request $request) {
        $tglSekarang = date('Y-m-d');

        $area = DB::table('ms_areas')->get();
        $mst = DB::table('penjualan_mst');
        $trn = DB::table('penjualan_trn');

        $noSPK = $request->no_spk;
        $aju = $request->aju;
        $namaCust = $request->nama_customer;
        $noRangka = $request->no_rangka;
        $idLeasing = $request->id_leasing;
        $idKota = $request->id_kota;
        $idKecamatan = $request->id_kecamatan;
        $alamat = $request->alamat;
        $tglSPK = date('Y-m-d',strtotime($request->tanggal_spk));
        $username = Session::get('username');

        $tglIncrement = $tglSPK;

        if ($mst->where('no_spk','=',$noSPK)->doesntExist()) {
            $mstBaru = new penjualanMst;
            $mstBaru->no_spk = $noSPK;
            $mstBaru->nama_customer = $namaCust;
            $mstBaru->no_rangka = $noRangka;
            $mstBaru->id_leasing = $idLeasing;
            $mstBaru->id_kota = $idKota;
            $mstBaru->id_kecamatan = $idKecamatan;
            $mstBaru->alamat = $alamat;
            $mstBaru->tanggal_spk = $tglSPK;
            $mstBaru->username = $username;

            if ($mstBaru->save()) {
                $counter = 0;
                $dataTrn = array();
                foreach ($area as $a) {
                    if ($a->id !== '1') {
                        $startDate = $tglIncrement;
                        $default = $a->tgl_target_default;
                        $your_date = strtotime($default." day", strtotime($startDate));
                        $tglIncrement = date("Y-m-d", $your_date);
                    }
                    if ($a->id == $aju) {
                        $listTrn = array(
                            'no_spk' => $noSPK,
                            'id_area' => $a->id,
                            'tanggal_target' => $tglIncrement,
                            'catatan' => 'initial',
                            'tanggal' => $tglSPK,
                            'username' => $username,
                            'status' => '1',
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        );
                    } else {
                        $listTrn = array(
                            'no_spk' => $noSPK,
                            'id_area' => $a->id,
                            'tanggal_target' => $tglIncrement,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        );
                    }
                    array_push($dataTrn,$listTrn);
                    if ($trn->insert($listTrn)) {
                        $counter++;
                    }
                }
                if ($counter == $area->count()) {
                    $result = [
                        'status' => 'success',
                    ];
                } else {
                    $result = [
                        'status' => 'failed',
                        'reason' => 'Gagal insert trn',
                    ];
                }
            }
        } else {
            $result = [
                'status' => 'failed',
                'reason' => 'No SPK sudah terdaftar',
            ];
        }
        return json_encode($result);
    }

    public function upload(Request $request, $tipe) {
        $dbLeasing = DB::table('ms_leasings')->select('id','nama')->get();
        $dbKecamatan = DB::table('ms_wilayah_kecamatans')->select('id','nama')->get();
        $dbKotaKab = DB::table('ms_wilayah_kotas')->select('id','nama')->get();

        $noSPK = 0;
        $namaCust = 0;
        $noRangka = 0;
        $leasing = 0;
        $kotaKab = 0;
        $kecamatan =0;
        $alamat = 0;
        $tglSPK = 0;

        $file = $request->file('filepond');
        $extension = $file->extension();

        switch ($extension) {
            case 'xls':
                $reader = new Xls();
                break;

            case 'xlsx':
                $reader = new Xlsx();
        }
        $spreadsheet = $reader->load($file);
        $worksheet = $spreadsheet->getActiveSheet();
        $array = $worksheet->toArray();

        foreach ($array[0] as $key => $value) {
            switch ($value) {
                case 'nomor spk':
                    $noSPK = $key;
                    break;

                case 'nama customer':
                    $namaCust = $key;
                    break;

                case 'nomor rangka':
                    $noRangka = $key;
                    break;

                case 'leasing':
                    $leasing = $key;
                    break;

                case 'kota/kabupaten':
                    $kotaKab = $key;
                    break;

                case 'kecamatan':
                    $kecamatan = $key;
                    break;

                case 'alamat':
                    $alamat = $key;
                    break;

                case 'tanggal spk':
                    $tglSPK = $key;
                    break;
            }
        }

        $result = array();
        for ($i=1 ; $i < count($array) ; $i++) {
            $leas = 0;
            $kec = 0;
            $kot = 0;
            foreach ($dbLeasing as $l) {
                if ($l->nama == $array[$i][$leasing]) {
                    $leas = $l->id;
                }
            }
            foreach ($dbKotaKab as $ko) {
                if ($ko->nama == $array[$i][$kotaKab]) {
                    $kot = $ko->id;
                }
            }
            foreach ($dbKecamatan as $kc) {
                if ($kc->nama == $array[$i][$kecamatan]) {
                    $kec = $kc->id;
                }
            }
            $result[] = [
                'nomor_spk' => $array[$i][$noSPK],
                'nama_customer' => $array[$i][$namaCust],
                'nomor_rangka' => $array[$i][$noRangka],
                'leasing' => $leas,
                'kota_kabupaten' => $kot,
                'kecamatan' => $kec,
                'alamat' => $array[$i][$alamat],
                'tanggal_spk' => $array[$i][$tglSPK],
            ];
//            $mstBaru = new penjualanMst;
//            $mstBaru->no_spk = $array[$i][$noSPK];
//            $mstBaru->nama_customer = $array[$i][$namaCust];
//            $mstBaru->no_rangka = $array[$i][$noRangka];
//            $mstBaru->id_leasing = $array[$i][$leasing];
//            $mstBaru->id_kota = $array[$i][$kotaKab];
//            $mstBaru->id_kecamatan = $array[$i][$kecamatan];
//            $mstBaru->alamat = $array[$i][$alamat];
//            $mstBaru->tanggal_spk = $array[$i][$tglSPK];
//            $mstBaru->username = Session::get('username');
        }

        return json_encode($result);
    }
}
