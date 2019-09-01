<?php

namespace App\Http\Controllers\OpenFunction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UpdateValidasi extends Controller
{
    public static function update($checklist) {
        try {
            foreach ($checklist as $c) {
                DB::table('aju_faktur_validasi')
                    ->where([
                        ['no_spk','=',$c['no_spk']],
                        ['id_checklist','=',$c['id']],
                    ])
                    ->update(['status' => $c['status']]);
            }
        } catch (\Exception $ex) {
            return dd($ex);
        }
        return 'success';
    }
}
