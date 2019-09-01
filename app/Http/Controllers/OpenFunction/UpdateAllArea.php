<?php

namespace App\Http\Controllers\OpenFunction;

use App\msArea;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UpdateAllArea extends Controller
{
    public static function update($noSPK,$tglFaktur) {
        $area = msArea::all();
        $data = [];

        try {
            foreach ($area as $a) {
                if ($a->id == '1') {
                    $tglHasil = $tglFaktur;
                    $data[$a->id] = [
                        'tgl' => $tglFaktur,
                    ];
                } else {
                    $tglPembanding = $data[$a->perbandingan]['tgl'];
                    $defaultDiff = $a->tgl_target_default;

                    $tgl = strtotime($defaultDiff." day", strtotime($tglPembanding));
                    $tglHasil = date('Y-m-d', $tgl);

                    $data[$a->id] = [
                        'tgl' => $tglHasil,
                    ];
                }
                DB::table('penjualan_trn')->where([
                    ['no_spk','=',$noSPK],
                    ['id_area','=',$a->id]
                ])->update([
                    'tanggal_target' => $tglHasil
                ]);
            }
        } catch (\Exception $ex) {
            return dd($ex);
        }
        return 'success';
    }
}
