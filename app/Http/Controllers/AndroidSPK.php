<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\OpenFunction\UpdateAllArea;
use App\Http\Controllers\OpenFunction\UpdateValidasi;
use App\Http\Controllers\OpenFunction\PembayaranARBaru;
use App\Http\Controllers\OpenFunction\UpdateArea;

class AndroidSPK extends Controller
{
    public function search(Request $request) {
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
