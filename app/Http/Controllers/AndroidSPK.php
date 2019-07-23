<?php

namespace App\Http\Controllers;

use App\pembayaranAR;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AndroidSPK extends Controller
{
    public function search(Request $request) {
        $spk = DB::table('penjualan_mst')
            ->select('no_spk','nama_customer','no_rangka','ms_leasings.nama AS leasing','ms_wilayah_kotas.nama AS kota','ms_wilayah_kecamatans.nama AS kecamatan','alamat','tanggal_spk','username','finish')
            ->join('ms_leasings','penjualan_mst.id_leasing','=','ms_leasings.id')
            ->join('ms_wilayah_kotas','penjualan_mst.id_kota','=','ms_wilayah_kotas.id')
            ->join('ms_wilayah_kecamatans','penjualan_mst.id_kecamatan','=','ms_wilayah_kecamatans.id')
            ->orderBy('finish');
        if ($request->search !== '') {
            $search = '%'.$request->search.'%';
            $spk->where('no_spk','like', $search)
                ->orWhere('nama_customer','like', $search);
        }
        return $spk->get()->toJson();
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
                    case '10':
                        $result['pembayaran_ar'] = DB::table('pembayaran_ar')
                            ->select('nominal')
                            ->where('no_spk','=',$noSpk)
                            ->sum('nominal');
                        $trn = DB::table('penjualan_trn')
                            ->where([
                                ['no_spk','=',$noSpk],
                            ])->whereIn('id_area',['9','10'])->get();
                        $result['trn'] = $trn;
                        break;
                    case '12':
                        $result['pembayaran_ar'] = DB::table('pembayaran_ar')
                            ->select('nominal')
                            ->where('no_spk','=',$noSpk)
                            ->sum('nominal');
                        $trn = DB::table('penjualan_trn')
                            ->where([
                                ['no_spk','=',$noSpk],
                            ])->whereIn('id_area',['9','12'])->get();
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
