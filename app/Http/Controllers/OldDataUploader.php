<?php

namespace App\Http\Controllers;

use App\penjualanMst;
use App\penjualanTrn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class OldDataUploader extends Controller
{
    public function upload(Request $request) {
        $area = DB::table('ms_areas')->get();

        $noSPK = 0;
        $namaCust = 0;
        $noRangka = 0;
        $kotaKab = 0;
        $kecamatan =0;
        $alamat = 0;
        $tglSPK = 0;
        $username = Session::get('username');
        $date = date('Y-m-d H:i:s');

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

        foreach ($array[1] as $key => $value) {
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
            } catch (\Exception $ex) {
                return dd('Exception block', $ex);
            }

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
    }
}
