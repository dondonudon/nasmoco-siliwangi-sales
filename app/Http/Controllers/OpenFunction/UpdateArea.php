<?php

namespace App\Http\Controllers\OpenFunction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UpdateArea extends Controller
{
    public static function update($username,$noSPK,$idArea,$catatan,$nominal,$tanggal,$status) {
        try {
            $spk = DB::table('penjualan_trn')->where([
                ['no_spk','=',$noSPK],
                ['id_area','=',$idArea],
            ]);
            $oldCat = $spk->first();
            if ($oldCat->catatan == null) {
                $newCat = $tanggal.' - '.$username.'
'.$catatan.'

';
            } else {
                $newCat = $oldCat->catatan.$tanggal.' - '.$username.'
'.$catatan.'

';
            }

            $data = [
                'catatan' => $newCat,
                'tanggal' => $tanggal,
                'username' => $username,
                'nominal' => $nominal,
                'status' => $status,
            ];
            $spk->update($data);
        } catch (\Exception $ex) {
            return dd($ex);
        }
        return 'success';
    }
}
