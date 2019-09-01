<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
<<<<<<< HEAD
        $endDate = $request->end_date.' 23:50:50';
=======
        $endDate = $request->end_date;
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
        $status = $request->status;

        $trn = DB::table('penjualan_trn')->select('id_area','tanggal','tanggal_target','tgl_target_updated');
        $mst = DB::table('penjualan_mst')
            ->where('finish','=',$status)
<<<<<<< HEAD
            ->whereBetween('created_at',[$startDate,$endDate])->get();
=======
            ->whereBetween('tanggal_spk',[$startDate,$endDate])->get();
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
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
<<<<<<< HEAD
                    '11' => $this->checkOverdue($h[10]->tanggal, $h[10]->tanggal_target, $h[10]->tgl_target_updated),
                    '12' => $this->checkOverdue($h[11]->tanggal, $h[11]->tanggal_target, $h[11]->tgl_target_updated),
                    '13' => $this->checkOverdue($h[12]->tanggal, $h[12]->tanggal_target, $h[12]->tgl_target_updated),
                    '14' => $this->checkOverdue($h[13]->tanggal, $h[13]->tanggal_target, $h[13]->tgl_target_updated),
=======
                    '10' => $this->checkOverdue($h[9]->tanggal, $h[9]->tanggal_target, $h[9]->tgl_target_updated),
                    '11' => $this->checkOverdue($h[10]->tanggal, $h[10]->tanggal_target, $h[10]->tgl_target_updated),
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
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
<<<<<<< HEAD
                    '12' => $this->checkOverdue($hslTrn[11]->tanggal, $hslTrn[11]->tanggal_target),
                    '13' => $this->checkOverdue($hslTrn[12]->tanggal, $hslTrn[12]->tanggal_target),
                    '14' => $this->checkOverdue($hslTrn[13]->tanggal, $hslTrn[13]->tanggal_target),
=======
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
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
<<<<<<< HEAD
            ->whereIn('id_area',[1,2,3,4,5,6,7,8,9,11,12,13,14])
            ->orderBy('ord','asc')
=======
            ->whereBetween('id_area',[1,11])
            ->orderBy('id_area')
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
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
<<<<<<< HEAD

        if ($customTglAwal < $customTglAkhir) {
            $customDateDiff = $customTglAkhir->diff($customTglAwal);
        } else {
            $customDateDiff = $customTglAwal->diff($customTglAkhir);
        }
=======
        $customDateDiff = $customTglAwal->diff($customTglAkhir);
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac

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
<<<<<<< HEAD
            $rvpg = '<td>Retail vs Penagihan</td><td></td><td></td><td></td><td></td><th class="bg-gradient-warning text-center text-white" colspan="5">' . $rvpg->format("%a") . '</th><td></td><td></td><td></td><td></td>';
=======
            $rvpg = '<td>Retail vs Penagihan</td><td></td><td></td><td></td><td></td><th class="bg-gradient-warning text-center text-white" colspan="5">' . $rvpg->format("%a") . '</th><td></td><td></td>';
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac

            $start = date_create($tgl[3]);
            $end = date_create($tgl[9]);
            $rvpl = date_diff($start, $end);
<<<<<<< HEAD
            $rvpl = '<td>Retail vs Pelunasan</td><td></td><td></td><td></td><td></td><th class="bg-gradient-warning text-center text-white" colspan="6">' . $rvpl->format("%a") . '</th><td></td><td></td><td></td>';
=======
            $rvpl = '<td>Retail vs Pelunasan</td><td></td><td></td><td></td><td></td><th class="bg-gradient-warning text-center text-white" colspan="6">' . $rvpl->format("%a") . '</th><td></td>';
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac

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

    function summaryPenjualan($start,$end,$status) {
        $trn = DB::table('penjualan_trn')->select('id_area','tanggal','tanggal_target','tgl_target_updated');
        $mst = DB::table('penjualan_mst')
            ->where('finish','=',$status)
            ->whereBetween('tanggal_spk',[$start,$end])->get();
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
        return $result;
    }

    function setCell($value,$option) {
        $result = '';

        if (strstr($value, ' - ')) {
            $data = explode(' - ', $value);
            switch ($option) {
                case 'remove-status':
                    $result = $data[1];
                    break;

                case 'set-color':
                    if ($data[0] == 'overdue') {
                        $result = 'ff0000';
                    } else {
                        $result = 'ffc300';
                    }
                    break;
            }
        } else {
            switch ($option) {
                case 'set-color':
                    $result = 'ffffff';
                    break;

                default:
                    $result = $value;
                    break;
            }
        }

        return $result;
    }

    public function export($data,$start,$end,$status) {
        $spreadsheet = new Spreadsheet();

        ob_start();
        $sheet = $spreadsheet->getActiveSheet();
        switch ($data) {
            case 'penjualan-summary':
                $sheet->setCellValue('A1', 'Nomor SPK');
                $sheet->setCellValue('B1', 'AJU FAKTUR');
                $sheet->setCellValue('C1', 'AJU DR');
                $sheet->setCellValue('D1', 'PDS IN');
                $sheet->setCellValue('E1', 'GESEK');
                $sheet->setCellValue('F1', 'RETAIL');
                $sheet->setCellValue('G1', 'FAKTUR DATANG');
                $sheet->setCellValue('H1', 'PDS OUT');
                $sheet->setCellValue('I1', 'STNK');
                $sheet->setCellValue('J1', 'PENAGIHAN');
                $sheet->setCellValue('K1', 'PELUNASAN');
                $sheet->setCellValue('L1', 'BPKB');

                $spreadsheet->getActiveSheet()->getStyle('A1:L1')->getFill()
                    ->setFillType(Fill::FILL_SOLID)->getStartColor()
                    ->setARGB('828282');

                $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);

                $iRow = 2;
                $getData = $this->summaryPenjualan($start,$end,$status);
                if ($getData['data'] !== '') {
                    foreach ($getData['data'] as $d) {
                        $sheet->setCellValue('A'.$iRow, $d['no_spk']);

                        $sheet->setCellValue('B'.$iRow, $this->setCell($d['1'],'remove-status'));
                        $sheet->setCellValue('C'.$iRow, $this->setCell($d['2'],'remove-status'));
                        $sheet->setCellValue('D'.$iRow, $this->setCell($d['3'],'remove-status'));
                        $sheet->setCellValue('E'.$iRow, $this->setCell($d['4'],'remove-status'));
                        $sheet->setCellValue('F'.$iRow, $this->setCell($d['5'],'remove-status'));
                        $sheet->setCellValue('G'.$iRow, $this->setCell($d['6'],'remove-status'));
                        $sheet->setCellValue('H'.$iRow, $this->setCell($d['7'],'remove-status'));
                        $sheet->setCellValue('I'.$iRow, $this->setCell($d['8'],'remove-status'));
                        $sheet->setCellValue('J'.$iRow, $this->setCell($d['9'],'remove-status'));
                        $sheet->setCellValue('K'.$iRow, $this->setCell($d['10'],'remove-status'));
                        $sheet->setCellValue('L'.$iRow, $this->setCell($d['11'],'remove-status'));

                        $spreadsheet->getActiveSheet()->getStyle('B'.$iRow)->getFill()
                            ->setFillType(Fill::FILL_SOLID)->getStartColor()
                            ->setARGB($this->setCell($d['1'],'set-color'));
                        $spreadsheet->getActiveSheet()->getStyle('C'.$iRow)->getFill()
                            ->setFillType(Fill::FILL_SOLID)->getStartColor()
                            ->setARGB($this->setCell($d['2'],'set-color'));
                        $spreadsheet->getActiveSheet()->getStyle('D'.$iRow)->getFill()
                            ->setFillType(Fill::FILL_SOLID)->getStartColor()
                            ->setARGB($this->setCell($d['3'],'set-color'));
                        $spreadsheet->getActiveSheet()->getStyle('E'.$iRow)->getFill()
                            ->setFillType(Fill::FILL_SOLID)->getStartColor()
                            ->setARGB($this->setCell($d['4'],'set-color'));
                        $spreadsheet->getActiveSheet()->getStyle('F'.$iRow)->getFill()
                            ->setFillType(Fill::FILL_SOLID)->getStartColor()
                            ->setARGB($this->setCell($d['5'],'set-color'));
                        $spreadsheet->getActiveSheet()->getStyle('G'.$iRow)->getFill()
                            ->setFillType(Fill::FILL_SOLID)->getStartColor()
                            ->setARGB($this->setCell($d['6'],'set-color'));
                        $spreadsheet->getActiveSheet()->getStyle('H'.$iRow)->getFill()
                            ->setFillType(Fill::FILL_SOLID)->getStartColor()
                            ->setARGB($this->setCell($d['7'],'set-color'));
                        $spreadsheet->getActiveSheet()->getStyle('I'.$iRow)->getFill()
                            ->setFillType(Fill::FILL_SOLID)->getStartColor()
                            ->setARGB($this->setCell($d['8'],'set-color'));
                        $spreadsheet->getActiveSheet()->getStyle('J'.$iRow)->getFill()
                            ->setFillType(Fill::FILL_SOLID)->getStartColor()
                            ->setARGB($this->setCell($d['9'],'set-color'));
                        $spreadsheet->getActiveSheet()->getStyle('K'.$iRow)->getFill()
                            ->setFillType(Fill::FILL_SOLID)->getStartColor()
                            ->setARGB($this->setCell($d['10'],'set-color'));
                        $spreadsheet->getActiveSheet()->getStyle('L'.$iRow)->getFill()
                            ->setFillType(Fill::FILL_SOLID)->getStartColor()
                            ->setARGB($this->setCell($d['11'],'set-color'));
                        $iRow++;
                    }
                }
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '828282'],
                        ],
                    ],
                ];
                $sheet->getStyle('A1:L'.($iRow-1))->applyFromArray($styleArray);
                break;
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        $content = ob_get_contents();
        ob_end_clean();
<<<<<<< HEAD
        Storage::disk('Public')->put('export-summary.xlsx',$content);

        return Storage::download('Public/export-summary.xlsx');
=======
        Storage::disk('public')->put('export-summary.xlsx',$content);

        return Storage::download('public/export-summary.xlsx');
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac


//        response()->headers->set('Content-Type','application/vnd.ms-excel');
//        response()->headers->set('Content-Disposition','attachment;filename="ExportSummary.xlsx"');
//        response()->headers->set('Cache-Control','max-age=0');

<<<<<<< HEAD
//        Storage::putFile('Public', new File($writer->save('summary.xlsx')), 'export-summary.xlsx');
=======
//        Storage::putFile('public', new File($writer->save('summary.xlsx')), 'export-summary.xlsx');
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
//        $save = $writer->save('php://output');
//
//        $headers = [
//            'Content-Description' => 'File Transfer',
//            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
//            'Content-Disposition' => 'attachment;filename="export-summary.xlsx"',
//            'Content-Transfer-Encoding' => 'binary',
//            'Expires' => '0',
//            'Cache-Control' => 'must-revalidate',
<<<<<<< HEAD
//            'Pragma' => 'Public',
=======
//            'Pragma' => 'public',
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
//            'Content-Length' => filesize($save),
//        ];
//
//        return \response()->download($save, 'export-summary.xlsx', $headers);
//        return $writer->save('export-summary.xlsx');
    }
}
