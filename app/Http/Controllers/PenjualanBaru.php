<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\AjuFakturValidasi;
=======
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
use App\msArea;
use App\msLeasing;
use App\msWilayahKecamatan;
use App\msWilayahKota;
use App\penjualanMst;
use App\penjualanTrn;
<<<<<<< HEAD
=======
use http\Exception;
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
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
<<<<<<< HEAD
            ->select('no_spk','nama_customer','nama_stnk','no_rangka','leasing','kota','kecamatan','alamat','created_at','username','finish')
=======
            ->select('no_spk','nama_customer','no_rangka','leasing','kota','kecamatan','alamat','tanggal_spk','username','finish')
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
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
<<<<<<< HEAD
        $fakturChecklist = array(
            ['id' => 0, 'nama' => 'KTP Asli'],
            ['id' => 1, 'nama' => 'MEMO'],
            ['id' => 2, 'nama' => 'NPWP, TDP, SIUP, Domisili'],
            ['id' => 3, 'nama' => 'KOP Perusahaan'],
        );
=======
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
        $tglSekarang = date('Y-m-d');
        $kota = DB::table('ms_wilayah_kotas')->where('id','=',$request->id_kota)->first();

        $area = DB::table('ms_areas')->get();
        $mst = DB::table('penjualan_mst');
        $trn = DB::table('penjualan_trn');

        $noSPK = $request->no_spk;
        $aju = $request->aju;
        $namaCust = $request->nama_customer;
        $noRangka = $request->no_rangka;
        $idLeasing = $request->id_leasing;
        $idKota = $kota->nama;
        $idKecamatan = $request->id_kecamatan;
        $alamat = $request->alamat;
<<<<<<< HEAD
        $username = Session::get('username');

=======
        $tglSPK = date('Y-m-d',strtotime($request->tanggal_spk));
        $username = Session::get('username');

        $tglIncrement = $tglSPK;

>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
        if ($mst->where('no_spk','=',$noSPK)->doesntExist()) {
            $mstBaru = new penjualanMst;

            $mstBaru->no_spk = $noSPK;
            $mstBaru->nama_customer = $namaCust;
            $mstBaru->no_rangka = $noRangka;
            $mstBaru->leasing = $idLeasing;
            $mstBaru->kota = $idKota;
            $mstBaru->kecamatan = $idKecamatan;
            $mstBaru->alamat = $alamat;
<<<<<<< HEAD
            $mstBaru->username = $username;

            if ($mstBaru->save()) {
                try {
                    foreach ($fakturChecklist as $f) {
                        $ajuF = new AjuFakturValidasi();
                        $ajuF->id_checklist = $f['id'];
                        $ajuF->no_spk = $noSPK;
                        $ajuF->nama = $f['nama'];
                        $ajuF->save();
                    }

                    foreach ($area as $a) {
                        penjualanTrn::create([
                            'no_spk' => $noSPK,
                            'id_area' => $a->id,
                            'username' => $username,
                        ]);
                    }
                } catch (\Exception $ex) {
                    dd('Exception Block',$ex);
                }
                $result = [
                    'status' => 'success',
                ];
=======
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
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
            }
        } else {
            $result = [
                'status' => 'failed',
                'reason' => 'No SPK sudah terdaftar',
            ];
        }
        return json_encode($result);
    }

<<<<<<< HEAD
=======
    function checkNull($date) {
//        $check = $short = substr($date, 0, strpos( $date, ' '));
        if ($date == '' || $date == null || $date == ' ') {
            $result = null;
        } else {
            $result = date('Y-m-d', strtotime($date));
        }
        return $result;
    }

>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
    public function upload(Request $request) {
        $username = Session::get('username');
        $area = msArea::all();
        $file = $request->file('filepond');
<<<<<<< HEAD
        $extension = $file->getClientOriginalExtension();
=======
        $extension = $file->extension();
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac

        switch ($extension) {
            case 'xls':
                $reader = new Xls();
                break;

            case 'xlsx':
                $reader = new Xlsx();
        }

        try {
            $spreadsheet = $reader->load($file);
            $worksheet = $spreadsheet->getActiveSheet();
        } catch (\Exception $ex) {
            dd('Exception Block',$ex);
        }
        $array = $worksheet->toArray();

        foreach ($array[0] as $key => $value) {
            switch ($value) {
                case 'No SPK':
                    $noSPK = $key;
                    break;

                case 'Nama Customer':
                    $namaCust = $key;
                    break;

<<<<<<< HEAD
                case 'Nama STNK':
                    $namaSTNK = $key;
                    break;

=======
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
                case 'No Rangka':
                    $noRangka = $key;
                    break;

                case 'Leasing':
<<<<<<< HEAD
                    $leasing = $key;
                    break;

                case 'Kota / Kabupaten':
                    $kotaKab = $key;
                    break;

                case 'Kecamatan':
=======
                    $kotaKab = $key;
                    break;

                case 'Kota / Kabupaten':
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
                    $kecamatan = $key;
                    break;

                case 'Alamat':
                    $alamat = $key;
                    break;
<<<<<<< HEAD
            }
        }

        $fakturChecklist = array(
            ['id' => 0, 'nama' => 'KTP Asli'],
            ['id' => 1, 'nama' => 'MEMO'],
            ['id' => 2, 'nama' => 'NPWP, TDP, SIUP, Domisili'],
            ['id' => 3, 'nama' => 'KOP Perusahaan'],
        );

        $duplicateNoSPK = [];
        $SPK = DB::table('penjualan_mst');

        try {
            for ($i = 1; $i < count($array); $i++) {
                $dtNoSPK = $array[$i][$noSPK];
                $checkSPK = clone $SPK->where('no_spk', '=', $dtNoSPK);
                if ($checkSPK->exists()) {
                    $duplicateNoSPK[] = $dtNoSPK;
                } else {
                    $mst = new penjualanMst();
                    $mst->no_spk = $dtNoSPK;
                    $mst->nama_customer = $array[$i][$namaCust];
                    $mst->nama_stnk = (is_null($array[$i][$namaSTNK]))?'':$array[$i][$namaSTNK];
                    $mst->no_rangka = $array[$i][$noRangka];
                    $mst->leasing = $array[$i][$leasing];
                    $mst->kota = $array[$i][$kotaKab];
                    $mst->kecamatan = $array[$i][$kecamatan];
                    $mst->alamat = $array[$i][$alamat];
                    $mst->username = $username;
                    $mst->save();

                    foreach ($area as $a) {
                        penjualanTrn::create([
                            'no_spk' => $dtNoSPK,
                            'id_area' => $a->id,
                            'username' => $username,
                        ]);
                    }

                    foreach ($fakturChecklist as $f) {
                        $ajuF = new AjuFakturValidasi();
                        $ajuF->id_checklist = $f['id'];
                        $ajuF->no_spk = $dtNoSPK;
                        $ajuF->nama = $f['nama'];
                        $ajuF->save();
                    }
                }
            }
        } catch (\Exception $ex) {
            dd('Exception Block',$ex);
        }

        $result = [
            'status' => 'success',
            'duplicate' => $duplicateNoSPK,
        ];
        return json_encode($result);
    }

    public function sample() {
        return response()
            ->download('sample/template-penjualan-baru.xlsx','template-penjualan-baru.xlsx');
=======

                case 'Tanggal SPK':
                    $tglSPK = $key;
                    break;
            }
        }

        for ($i = 1; $i < count($array); $i++) {
            $dtNoSPK = $array[$i][$noSPK];
            $dtTglSPK = $array[$i][$tglSPK];
            $mst = new penjualanMst();

            $mst->no_spk = $array[$i][$noSPK];
            $mst->nama_customer = $array[$i][$namaCust];
            $mst->no_rangka = $array[$i][$noRangka];
            $mst->kota = $array[$i][$kotaKab];
            $mst->kecamatan = $array[$i][$kecamatan];
            $mst->alamat = $array[$i][$alamat];
            $mst->tanggal_spk = $array[$i][$tglSPK];
            $mst->username = $username;

            try {
                $mst->save();
            } catch (\Exception $ex) {
                dd('Exception Block',$ex);
            }

            $counter = 0;
            foreach ($area as $a) {
                $counter += $a->tgl_target_default;
                $thisDate = $dtTglSPK;

                $your_date = strtotime($counter." day", strtotime($thisDate));
                $tglIncrement = date("Y-m-d", $your_date);

                $trn = new penjualanTrn();

                $trn->no_spk = $dtNoSPK;
                $trn->id_area = $a->id;
                $trn->catatan = '';
                $trn->status = '0';
                $trn->tanggal_target = $tglIncrement;
                $trn->username = $username;

                try {
                    $trn->save();
                } catch (\Exception $ex) {
                    return dd('Exception block', $ex);
                }
            }
        }
    }

    public function sample() {
        return Storage::download('public/spk-baru.xlsx');
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
    }

    public function hapus(Request $request) {
        $noSPK = $request->no_spk;

        try {
            DB::table('penjualan_mst')->where('no_spk','=',$noSPK)->delete();
            DB::table('penjualan_trn')->where('no_spk','=',$noSPK)->delete();
        } catch (\Exception $ex) {
            dd('Exception Block', $ex);
        }

        $result = [
            'status' => 'success'
        ];

        return json_encode($result);
    }
}
