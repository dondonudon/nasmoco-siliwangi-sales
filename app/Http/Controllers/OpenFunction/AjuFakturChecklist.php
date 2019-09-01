<?php

namespace App\Http\Controllers\OpenFunction;

use App\AjuFakturValidasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AjuFakturChecklist extends Controller
{
    public static function add($noSPK) {
        try {
            $fakturChecklist = array(
                ['id' => 0, 'nama' => 'KTP Asli'],
                ['id' => 1, 'nama' => 'MEMO'],
                ['id' => 2, 'nama' => 'NPWP, TDP, SIUP, Domisili'],
                ['id' => 3, 'nama' => 'KOP Perusahaan'],
            );

            foreach ($fakturChecklist as $f) {
                $ajuF = new AjuFakturValidasi();
                $ajuF->id_checklist = $f['id'];
                $ajuF->no_spk = $noSPK;
                $ajuF->nama = $f['nama'];
                $ajuF->save();
            }
        } catch (\Exception $ex) {
            dd($ex);
        }
        return 'success';
    }
}
