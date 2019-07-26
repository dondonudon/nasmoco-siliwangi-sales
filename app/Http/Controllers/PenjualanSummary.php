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

    public function fullscreen($start,$end,$status) {
        if (Session::has('username')) {
            return view('dashboard-penjualan-fullscreen')
                ->with([
                    'start' => $start,
                    'end' => $end,
                    'status' => $status,
                ]);
        } else {
            return abort('403');
        }
    }

    public function checkOverdue($tgl,$trgt, $trgtUpdated) {
        $endDate = date('Y-m-d',strtotime($trgt));
        $today = date('Y-m-d');

        if ($tgl !== null) {
            $result = date('d-m-Y',strtotime($tgl));
        } else {
            if ($today > $endDate && $trgtUpdated == '0') {
                $result = 'overdue - '.date('d-m-Y',strtotime($endDate));
            } elseif ($today <= $endDate && $trgtUpdated == '1') {
                $result = 'updated - '.date('d-m-Y',strtotime($endDate));
            } else {
                $result = null;
            }
        }
        return $result;
    }

    public function getPenjualan(Request $request) {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $status = $request->status;

        $trn = DB::table('penjualan_trn')->select('id_area','tanggal','tanggal_target','tgl_target_updated');
        $mst = DB::table('penjualan_mst')
            ->where('finish','=',$status)
            ->whereBetween('tanggal_spk',[$startDate,$endDate])->get();
        if ($mst->count() == 0) {
            $result['data'] = '';
            return json_encode($result);
        }
        $store = array();
        if ($mst->count() > 0) {
            foreach ($mst as $msts) {
                $query = clone $trn;
                try {
                    $hslTrn[] = $query->where('no_spk','=',$msts->no_spk)->get();
                } catch (\Exception $ex) {
                    return dd('Exception block', $ex);
                }
            }
	    $i = 0;
            foreach ($hslTrn as $h) {
                $store[] = array(
                    'no_spk' => $mst[$i]->no_spk,
                    '1' => $this->checkOverdue($h[0]->tanggal, $h[0]->tanggal_target, $h[0]->tgl_target_updated),
                    '2' => $this->checkOverdue($h[1]->tanggal, $h[1]->tanggal_target, $h[1]->tgl_target_updated),
                    '3' => $this->checkOverdue($h[2]->tanggal, $h[2]->tanggal_target, $h[2]->tgl_target_updated),
                    '4' => $this->checkOverdue($h[3]->tanggal, $h[3]->tanggal_target, $h[3]->tgl_target_updated),
                    '5' => $this->checkOverdue($h[4]->tanggal, $h[4]->tanggal_target, $h[4]->tgl_target_updated),
                    '6' => $this->checkOverdue($h[5]->tanggal, $h[5]->tanggal_target, $h[5]->tgl_target_updated),
                    '7' => $this->checkOverdue($h[6]->tanggal, $h[6]->tanggal_target, $h[6]->tgl_target_updated),
                    '8' => $this->checkOverdue($h[7]->tanggal, $h[7]->tanggal_target, $h[7]->tgl_target_updated),
                    '9' => $this->checkOverdue($h[8]->tanggal, $h[8]->tanggal_target, $h[8]->tgl_target_updated),
                    '10' => $this->checkOverdue($h[9]->tanggal, $h[9]->tanggal_target, $h[9]->tgl_target_updated),
                    '11' => $this->checkOverdue($h[10]->tanggal, $h[10]->tanggal_target, $h[10]->tgl_target_updated),
                );
		$i++;
            }
        } else {
                $hslTrn = $trn->where('no_spk','=',$mst[0]->no_spk)->get();
                $store[] = array(
                    'no_spk' => $mst[0]->no_spk,
                    '1' => $this->checkOverdue($hslTrn[0]->tanggal, $hslTrn[0]->tanggal_target),
                    '2' => $this->checkOverdue($hslTrn[1]->tanggal, $hslTrn[1]->tanggal_target),
                    '3' => $this->checkOverdue($hslTrn[2]->tanggal, $hslTrn[2]->tanggal_target),
                    '4' => $this->checkOverdue($hslTrn[3]->tanggal, $hslTrn[3]->tanggal_target),
                    '5' => $this->checkOverdue($hslTrn[4]->tanggal, $hslTrn[4]->tanggal_target),
                    '6' => $this->checkOverdue($hslTrn[5]->tanggal, $hslTrn[5]->tanggal_target),
                    '7' => $this->checkOverdue($hslTrn[6]->tanggal, $hslTrn[6]->tanggal_target),
                    '8' => $this->checkOverdue($hslTrn[7]->tanggal, $hslTrn[7]->tanggal_target),
                    '9' => $this->checkOverdue($hslTrn[8]->tanggal, $hslTrn[8]->tanggal_target),
                    '10' => $this->checkOverdue($hslTrn[9]->tanggal, $hslTrn[9]->tanggal_target),
                    '11' => $this->checkOverdue($hslTrn[10]->tanggal, $hslTrn[10]->tanggal_target),
                );
        }
        $result['data'] = $store;
        return json_encode($result);
    }

    public function getDetailSPK(Request $request) {
        $noSpk = $request->no_spk;

        $spk['detail'] = DB::table('penjualan_trn')
            ->select('no_spk','ms_areas.nama as nama_area','catatan','nominal','tanggal','tanggal_target','username')
            ->join('ms_areas','penjualan_trn.id_area','=','ms_areas.id')
            ->where('no_spk','=',$noSpk)
            ->orderBy('id_area')
            ->get();
        $spk['ar'] = DB::table('pembayaran_ar')
            ->where('no_spk','=',$noSpk)->get();
        return json_encode($spk);
    }

    public function getDifference(Request $request) {
        $noSpk = $request->no_spk;
        if ($request->area_awal < $request->area_akhir) {
            $areaAwal = $request->area_awal;
            $areaAkhir = $request->area_akhir;
        } else {
            $areaAkhir = $request->area_awal;
            $areaAwal = $request->area_akhir;
        }

        $areaRange = range($request->area_awal,$request->area_akhir);

        $spa = array();
        $sdf = array();
        $rvpg = '';
        $rvpl = '';
        $custom = '';
        $colspan = 0;
        $customHtmlAwal = '';
        $customHtmlAkhir = '';

        $trgtTglArea = [];

        $trn = DB::table('penjualan_trn')
            ->select('no_spk','ms_areas.nama as nama_area','ms_areas.id as id_area','tanggal','tanggal_target')
            ->join('ms_areas','penjualan_trn.id_area','=','ms_areas.id')
            ->where('no_spk','=',$noSpk)
            ->whereBetween('id_area',[1,11])
            ->orderBy('id_area')
            ->get();

        if ($trn[$areaAwal]->tanggal == null) {
            $customTglAwal = new \DateTime($trn[$areaAwal-1]->tanggal_target);
        } else {
            $customTglAwal = new \DateTime($trn[$areaAwal-1]->tanggal);
        }

        if ($trn[$areaAkhir]->tanggal == null) {
            $customTglAkhir = new \DateTime($trn[$areaAkhir-1]->tanggal_target);
        } else {
            $customTglAkhir = new \DateTime($trn[$areaAkhir-1]->tanggal);
        }
        $customDateDiff = $customTglAwal->diff($customTglAkhir);

        $tgl = array();
        foreach ($trn as $t) {
            if ($t->tanggal == null) {
                $tgl[] = $t->tanggal_target;
            } else {
                $tgl[] = $t->tanggal;
            }
        }

        /*
         * SELISIH DARI FAKTUR = SDF
         * SELISIH PER AREA = SPA
         * RETAIL VS PENAGIHAN = RVPG
         * RETAIL VS PELUNASAN = RVPL
         * CUSTOM
        */
        $lastDate = '';
        $firstDate = date_create($tgl[0]);
        for ($i = 0; $i < count($tgl); $i++) {
            $idArea = $trn[$i]->id_area;
            if ($lastDate == '') {
                $spa[] = $tgl[$i];
                $sdf[] = '';

                $lastDate = $tgl[$i];
            } else {
                $start = date_create($tgl[$i]);
                $spaEnd = date_create($tgl[$i - 1]);
                $sdfEnd = date_create($tgl[$i]);

                $spaDiff = date_diff($start, $spaEnd);
                $sdfDiff = date_diff($firstDate, $sdfEnd);

                $spa[] = $spaDiff->format("%a");
                $sdf[] = $sdfDiff->format("%a");
            }

            $start = date_create($tgl[3]);
            $end = date_create($tgl[8]);
            $rvpg = date_diff($start, $end);
            $rvpg = '<td>Retail vs Penagihan</td><td></td><td></td><td></td><td></td><th class="bg-gradient-warning text-center text-white" colspan="5">' . $rvpg->format("%a") . '</th><td></td><td></td>';

            $start = date_create($tgl[3]);
            $end = date_create($tgl[9]);
            $rvpl = date_diff($start, $end);
            $rvpl = '<td>Retail vs Pelunasan</td><td></td><td></td><td></td><td></td><th class="bg-gradient-warning text-center text-white" colspan="6">' . $rvpl->format("%a") . '</th><td></td>';

            if ($idArea >= $areaAwal && $idArea <= $areaAkhir) {
                $colspan += 1;
            } elseif ($idArea < $areaAwal) {
                $customHtmlAwal .= '<td></td>';
            } elseif ($idArea > $areaAkhir) {
                $customHtmlAkhir .= '<td></td>';
            }
        }

        $result = [
            'selisih_per_area' => $spa,
            'selisih_dari_faktur' => $sdf,
            'retail_vs_penagihan' => $rvpg,
            'retail_vs_pelunasan' => $rvpl,
            'custom' => '<td>Custom</td>'
                .$customHtmlAwal
                .'<th class="bg-gradient-info text-center text-white" colspan="' .$colspan .'">'
                .$customDateDiff->format('%a').'</th>'
                .$customHtmlAkhir,
        ];
        return json_encode($result);
    }
}
