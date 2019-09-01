<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Http\Controllers\OpenFunction\AjuFakturChecklist;
use App\Http\Controllers\OpenFunction\UpdateAllArea;
use App\Http\Controllers\OpenFunction\UpdateArea;
=======
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
use App\penjualanMst;
use App\penjualanTrn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
<<<<<<< HEAD
use PhpOffice\PhpSpreadsheet\Reader\Csv;
=======
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class OldDataUploader extends Controller
{
<<<<<<< HEAD
    private function checkNull($date) {
        if ($date == '' || $date == null || $date == ' ') {
            $result = null;
        } else {
            $result = date('Y-m-d', strtotime($date));
        }
        return $result;
    }

    public function upload(Request $request) {
        $extension = $request->extension;
        $area = DB::table('ms_areas')->get();

        $username = Session::get('username');
        $date = date('Y-m-d H:i:s');
=======
    public function upload(Request $request) {
        $area = DB::table('ms_areas')->get();

>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
        $noSPK = 0;
        $namaCust = 0;
        $noRangka = 0;
        $kotaKab = 0;
<<<<<<< HEAD
        $kecamatan = 0;
        $alamat = 0;
        $tglSPK = 0;

        $file = $request->file('filepond');
//        $extension = $file->extension();

//        $reader = null;
=======
        $kecamatan =0;
        $alamat = 0;
        $tglSPK = 0;
        $username = Session::get('username');
        $date = date('Y-m-d H:i:s');

        $file = $request->file('filepond');
        $extension = $file->extension();

>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
        switch ($extension) {
            case 'xls':
                $reader = new Xls();
                break;

            case 'xlsx':
                $reader = new Xlsx();
<<<<<<< HEAD
                break;

            case 'csv':
                $reader = new Csv();
                break;
=======
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
        }
        $spreadsheet = $reader->load($file);
        $worksheet = $spreadsheet->getActiveSheet();
        $array = $worksheet->toArray();

<<<<<<< HEAD
        foreach ($array[0] as $key => $value) {
=======
        foreach ($array[1] as $key => $value) {
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
            switch ($value) {
                case 'No SPK':
                    $noSPK = $key;
                    break;

                case 'Nama Pemesan':
                    $namaCust = $key;
                    break;

                case 'No. Rangka':
                    $noRangka = $key;
                    break;

                case 'KOTA':
                    $kotaKab = $key;
                    break;

                case 'KECAMATAN / KODE POS':
                    $kecamatan = $key;
                    break;

                case 'Alamat STNK':
                    $alamat = $key;
                    break;

                case 'Tgl SPK':
                    $tglSPK = $key;
                    break;

                case 'Tgl Kirim AFI':
                    $tglAjuFaktur = $key;
                    break;

                case 'Tgl AFI Dealer':
                    $tglAjuDR = $key;
                    break;

                case 'Tgl AFI HO':
                    $tglFakturDatang = $key;
                    break;

                case 'PDS IN':
                    $tglPDSIn = $key;
                    break;

                case 'GESEK':
                    $tglGesek = $key;
                    break;

                case 'RETAIL':
                    $tglRetail = $key;
                    break;

                case 'PDS OUT':
                    $tglPDSOut = $key;
                    break;

                case 'Tgl Jadi STNK':
                    $tglSTNKJadi = $key;
                    break;

                case 'PENAGIHAN':
                    $tglPenagihan = $key;
                    break;

                case 'PELUNASAN':
                    $tglPelunasan = $key;
                    break;

                case 'Tgl Jadi BPKB':
                    $tglBPKB = $key;
                    break;
            }
        }

        $result = array();
<<<<<<< HEAD
        for ($i=1 ; $i < count($array) ; $i++) {
            $trnData = [
                ['id' => '1','nama_area' => 'aju_faktur', 'tgl' => $this->checkNull($array[$i][$tglAjuFaktur])],
                ['id' => '2','nama_area' => 'aju_dr', 'tgl' => $this->checkNull($array[$i][$tglAjuDR])],
                ['id' => '3','nama_area' => 'pds_in', 'tgl' => $this->checkNull($array[$i][$tglPDSIn])],
                ['id' => '4','nama_area' => 'gesek', 'tgl' => $this->checkNull($array[$i][$tglGesek])],
                ['id' => '5','nama_area' => 'retail', 'tgl' => $this->checkNull($array[$i][$tglRetail])],
                ['id' => '6','nama_area' => 'faktur_datang', 'tgl' => $this->checkNull($array[$i][$tglFakturDatang])],
                ['id' => '7','nama_area' => 'pds_out', 'tgl' => $this->checkNull($array[$i][$tglPDSOut])],
                ['id' => '8','nama_area' => 'stnk_jadi', 'tgl' => $this->checkNull($array[$i][$tglSTNKJadi])],
                ['id' => '9','nama_area' => 'penagihan', 'tgl' => $this->checkNull($array[$i][$tglPenagihan])],
                ['id' => '10','nama_area' => 'ar', 'tgl' => null],
                ['id' => '11','nama_area' => 'pelunasan', 'tgl' => $this->checkNull($array[$i][$tglPelunasan])],
                ['id' => '12','nama_area' => 'bpkb_jadi', 'tgl' => $this->checkNull($array[$i][$tglBPKB])],
            ];

            $iNoSPK = $array[$i][$noSPK];
            try {
                $mst = new penjualanMst();
                $mst->no_spk = $iNoSPK;
                $mst->nama_customer = $array[$i][$namaCust];
                $mst->no_rangka = $array[$i][$noRangka];
                $mst->kota = $array[$i][$kotaKab];
                $mst->kecamatan = $array[$i][$kecamatan];
                $mst->alamat = $array[$i][$alamat];
                $mst->username = $username;
                $mst->created_at = $this->checkNull($array[$i][$tglSPK]);
                if ($trnData[11]['tgl'] == null) {
                    $mst->finish = 0;
                } else {
                    $mst->finish = 1;
                }
                $mst->save();

                foreach ($area as $a) {
                    penjualanTrn::create([
                        'no_spk' => $iNoSPK,
                        'id_area' => $a->id,
                        'username' => $username,
                    ]);
                }
                AjuFakturChecklist::add($iNoSPK);
//                $updateAllArea = UpdateAllArea::update($iNoSPK,$trnData[0]['tgl']);

                if ($trnData[0]['tgl'] !== null) {
                    UpdateAllArea::update($iNoSPK,$trnData[0]['tgl']);
                    foreach ($trnData as $v) {
                        if ($v !== null) {
                            UpdateArea::update($username,$iNoSPK,$v['id'],'',0,$v['tgl'],1);
                        }
                    }
                }
=======
        for ($i=2 ; $i < count($array) ; $i++) {
            $trnData = [
                'AJU FAKTUR' => $this->checkNull($array[$i][$tglAjuFaktur]),
                'AJU DR' => $this->checkNull($array[$i][$tglAjuDR]),
                'PDS IN' => $this->checkNull($array[$i][$tglPDSIn]),
                'GESEK' => $this->checkNull($array[$i][$tglGesek]),
                'RETAIL' => $this->checkNull($array[$i][$tglRetail]),
                'FAKTUR DATANG' => $this->checkNull($array[$i][$tglFakturDatang]),
                'PDS OUT' => $this->checkNull($array[$i][$tglPDSOut]),
                'STNK JADI' => $this->checkNull($array[$i][$tglSTNKJadi]),
                'PENAGIHAN' => $this->checkNull($array[$i][$tglPenagihan]),
                'PELUNASAN' => $this->checkNull($array[$i][$tglPelunasan]),
                'BPKB' => $this->checkNull($array[$i][$tglBPKB]),
                'AR' => null,
            ];

            $reformatTglSPK = date('Y-m-d H:i:s', strtotime($array[$i][$tglSPK]));
            $iNoSPK = $array[$i][$noSPK];
            $mst = new penjualanMst();

            $mst->no_spk = $iNoSPK;
            $mst->nama_customer = $array[$i][$namaCust];
            $mst->no_rangka = $array[$i][$noRangka];
            $mst->kota = $array[$i][$kotaKab];
            $mst->kecamatan = $array[$i][$kecamatan];
            $mst->alamat = $array[$i][$alamat];
            $mst->tanggal_spk = $reformatTglSPK;
            $mst->username = $username;
            if ($trnData['BPKB'] == null) {
                $mst->finish = 0;
            } else {
                $mst->finish = 1;
            }

            try {
                $mst->save();
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
            } catch (\Exception $ex) {
                return dd('Exception block', $ex);
            }

<<<<<<< HEAD
//            $counter = 0;
//            foreach ($area as $a) {
//                $counter += $a->tgl_target_default;
//                $thisDate = $reformatTglSPK;
//
//                $your_date = strtotime($counter." day", strtotime($thisDate));
//                $tglIncrement = date("Y-m-d", $your_date);
//
//                $trn = new penjualanTrn();
//
//                $trn->no_spk = $iNoSPK;
//                $trn->id_area = $a->id;
//                $trn->catatan = '';
//                if ($trnData[$a->nama] !== null) {
//                    $trn->tanggal = $trnData[$a->nama];
//                    $trn->status = '1';
//                } else {
//                    $trn->status = '0';
//                }
//                $trn->tanggal_target = $tglIncrement;
//                $trn->username = $username;
//
//                try {
//                    $trn->save();
//                    $lastDate = $trnData[$a->nama];
//                } catch (\Exception $ex) {
//                    return dd('Exception block', $ex);
//                }
//            }
        }

        return 'success';
=======
            $counter = 0;
            foreach ($area as $a) {
                $counter += $a->tgl_target_default;
                $thisDate = $reformatTglSPK;

                $your_date = strtotime($counter." day", strtotime($thisDate));
                $tglIncrement = date("Y-m-d", $your_date);

                $trn = new penjualanTrn();

                $trn->no_spk = $iNoSPK;
                $trn->id_area = $a->id;
                $trn->catatan = '';
                if ($trnData[$a->nama] !== null) {
                    $trn->tanggal = $trnData[$a->nama];
                    $trn->status = '1';
                } else {
                    $trn->status = '0';
                }
                $trn->tanggal_target = $tglIncrement;
                $trn->username = $username;

                try {
                    $trn->save();
                    $lastDate = $trnData[$a->nama];
                } catch (\Exception $ex) {
                    return dd('Exception block', $ex);
                }
            }
        }

        return json_encode($result);
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
    }
}
