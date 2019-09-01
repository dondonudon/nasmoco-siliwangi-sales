<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\OpenFunction\UpdateAllArea;
use App\Http\Controllers\OpenFunction\UpdateValidasi;
use App\Http\Controllers\OpenFunction\PembayaranARBaru;
use App\Http\Controllers\OpenFunction\UpdateArea;
=======
use App\pembayaranAR;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac

class AndroidSPK extends Controller
{
    public function search(Request $request) {
<<<<<<< HEAD
        $spk = DB::table('penjualan_mst');
        if ($request->search !== '' && strlen($request->search) >= 3) {
            $search = '%'.$request->search.'%';
            $spk->where('no_spk','like', $search)
                ->orWhere('nama_customer','like', $search)
                ->orWhere('no_rangka','like',$search);
            return $spk->get()->toJson();
        } else {
            return json_encode('');
        }
=======
        $spk = DB::table('penjualan_mst')
            ->select('no_spk','nama_customer','no_rangka','leasing','kota','kecamatan','alamat','tanggal_spk','username','finish');
        if ($request->search !== '') {
            $search = '%'.$request->search.'%';
            $spk->where('no_spk','like', $search)
                ->orWhere('nama_customer','like', $search);
        }
        return $spk->get()->toJson();
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
    }

    public function getTrn(Request $request) {
        $noSpk = $request->no_spk;
        $idArea = $request->id_area;
        $username = $request->username;

        $user = DB::table('ms_users')->where('username','=',$username);
        if ($user->exists()) {
            $userArea = DB::table('ms_user_areas')
                ->where([
                    ['username','=',$username],
                    ['id_area','=',$idArea],
                ]);
            if ($userArea->exists()) {
                switch ($idArea) {
<<<<<<< HEAD
                    case '1':
                        $trn = DB::table('penjualan_trn')
                            ->where([
                                ['no_spk','=',$noSpk],
                                ['id_area','=',$idArea],
                            ]);
                        $checklist = DB::table('aju_faktur_validasi')
                            ->where('no_spk','=',$noSpk);
                        $result['trn'] = $trn->get();
                        $result['checklist'] = $checklist->get();
                        break;

                    case '11':
=======
                    case '10':
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
                        $result['pembayaran_ar'] = DB::table('pembayaran_ar')
                            ->select('nominal')
                            ->where('no_spk','=',$noSpk)
                            ->sum('nominal');
                        $trn = DB::table('penjualan_trn')
                            ->where([
                                ['no_spk','=',$noSpk],
<<<<<<< HEAD
                            ])->whereIn('id_area',['9','12'])->get();
                        $result['trn'] = $trn;
                        break;
                    case '10':
=======
                            ])->whereIn('id_area',['5','10','12'])->get();
                        $result['trn'] = $trn;
                        break;
                    case '12':
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
                        $result['pembayaran_ar'] = DB::table('pembayaran_ar')
                            ->select('nominal')
                            ->where('no_spk','=',$noSpk)
                            ->sum('nominal');
                        $trn = DB::table('penjualan_trn')
                            ->where([
                                ['no_spk','=',$noSpk],
<<<<<<< HEAD
                            ])->whereIn('id_area',['9','10'])->get();
=======
                            ])->whereIn('id_area',['9','12'])->get();
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
                        $result['trn'] = $trn;
                        break;
                    default:
                        $trn = DB::table('penjualan_trn')
                            ->where([
                                ['no_spk','=',$noSpk],
                                ['id_area','=',$idArea],
                            ]);
                        $result = $trn->get();
                        break;
                }
            } else {
                $result = [
                    'status' => 'failed',
                    'reason' => 'User tidak memiliki akses ke area tersebut',
                ];
            }
        } else {
            $result = [
                'status' => 'failed',
                'reason' => 'Username tidak terdaftar',
            ];
        }
        return json_encode($result);
    }

    public function comment(Request $request) {
        $noSpk = $request->no_spk;
        $idArea = $request->id_area;
        $catatan = $request->catatan;
        $tanggal = $request->tanggal;
        $username = $request->username;
        $status = $request->status;
<<<<<<< HEAD
        if (isset($request->nominal)) {
            $nominal = $request->nominal;
        } else {
            $nominal = 0;
        }
        if (isset($request->faktur_0)) {
            $fakturChecklist = array(
                ['id' => 0,'no_spk' => $noSpk ,'status' => $request->faktur_0],
                ['id' => 1,'no_spk' => $noSpk ,'status' => $request->faktur_1],
                ['id' => 2,'no_spk' => $noSpk ,'status' => $request->faktur_2],
                ['id' => 3,'no_spk' => $noSpk ,'status' => $request->faktur_3],
            );
        }

        $user = DB::table('ms_users')->where('username','=',$username);
        $areaPermission = DB::table('ms_user_areas')->where([['username','=',$username], ['id_area','=',$idArea]]);

        if ($user->exists() && $areaPermission->exists()) {
            $spk = DB::table('penjualan_trn')->where([
                ['no_spk','=',$noSpk],
                ['id_area','=',$idArea],
            ]);
            $storedDT = $spk->first();

            try {
                switch ($idArea) {
                    case 1:
                        if ($storedDT->tanggal_target == null) {
                            $updateAllArea = UpdateAllArea::update($noSpk,$tanggal);
                        }
                        if (isset($fakturChecklist)) {
                            $updateFValidasi = UpdateValidasi::update($fakturChecklist);
                        }
                        break;

                    case 10:
                        $newPembayaranAR = PembayaranARBaru::add($noSpk,$nominal);
                        break;
                }
                $updateArea = UpdateArea::update($username,$noSpk,$idArea,$catatan,$nominal,$tanggal,$status);
                $result[] = ['status' => 'success'];
            } catch (\Exception $ex) {
                dd($ex);
            }
            $result[] = ['status' => 'success'];
        } else {
            $result[] = ['status' => 'failed - username or id_area not recognized'];
=======

        $user = DB::table('ms_users')->where('username','=',$username);
        if ($user->exists()) {
            $areaPermission = DB::table('ms_user_areas')
                ->where([
                    ['username','=',$username],
                    ['id_area','=',$idArea],
                ]);
            if ($areaPermission->exists()) {
                $spk = DB::table('penjualan_trn')->where([
                    ['no_spk','=',$noSpk],
                    ['id_area','=',$idArea],
                ]);
                $oldCat = $spk->first();
                $newCat = $oldCat->catatan.$tanggal.' - '.$username.'
'.$catatan.'

';
                if (in_array($idArea,['5','9'])) {
                    $data = [
                        'catatan' => $newCat,
                        'tanggal' => $tanggal,
                        'username' => $username,
                        'nominal' => $request->nominal,
                        'status' => $status,
                    ];
                } elseif ($idArea == '12') {
                    $ar = new pembayaranAR();
                    $ar->no_spk = $noSpk;
                    $ar->nominal = $request->nominal;
                    $ar->save();
                    $data = [
                        'catatan' => $newCat,
                        'tanggal' => $tanggal,
                        'username' => $username,
                        'nominal' => 0,
                        'status' => $status,
                    ];
                } else {
                    $data = [
                        'catatan' => $newCat,
                        'tanggal' => $tanggal,
                        'username' => $username,
                        'status' => $status,
                    ];
                }
                if ($spk->update($data)) {
                    $result = array(
                        [
                            'status' => 'success',
                        ]
                    );
                } else {
                    $result = array(
                        [
                            'status' => 'failed',
                            'reason' => 'gagal update data',
                        ]
                    );
                }
            } else {
                $result = array(
                    [
                        'status' => 'failed',
                        'data' => 'Username not alowed to edit area',
                    ]
                );
            }
        } else {
            $result = array(
                [
                    'status' => 'failed',
                    'data' => 'username not available',
                ]
            );
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
        }
        return json_encode($result);
    }

    public function updateTarget(Request $request) {
        $noSpk = $request->no_spk;
        $idArea = $request->id_area;
        $catatan = $request->catatan;
        $tanggal = date('Y-m-d');
        $tanggalTarget = $request->tanggal;
        $username = $request->username;
//        $status = $request->status;

        $user = DB::table('ms_users')->where('username','=',$username);
        if ($user->exists()) {
            $areaPermission = DB::table('ms_user_areas')
                ->where([
                    ['username','=',$username],
                    ['id_area','=',$idArea],
                ]);
            if ($areaPermission->exists()) {
                $spk = DB::table('penjualan_trn')->where([
                    ['no_spk','=',$noSpk],
                    ['id_area','=',$idArea],
                ]);
                $oldCat = $spk->first();
                $newCat = $oldCat->catatan.$tanggal.' - '.$username.'
'.$catatan.'

';
                $data = [
                    'catatan' => $newCat,
                    'tanggal_target' => $tanggalTarget,
                    'username' => $username,
//                    'status' => $status,
                    'tgl_target_updated' => '1',
                ];
                if ($spk->update($data)) {
                    $result = array(
                        [
                            'status' => 'success',
                        ]
                    );
                } else {
                    $result = array(
                        [
                            'status' => 'failed',
                            'reason' => 'gagal update data',
                        ]
                    );
                }
            } else {
                $result = array(
                    [
                        'status' => 'failed',
                        'data' => 'Username not alowed to edit area',
                    ]
                );
            }
        } else {
            $result = array(
                [
                    'status' => 'failed',
                    'data' => 'username not available',
                ]
            );
        }
        return json_encode($result);
    }
}
