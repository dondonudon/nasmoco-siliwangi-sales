<?php

namespace App\Http\Controllers;

use App\msArea;
use App\penjualanMst;
use App\penjualanTrn;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class PenjualanUploadBpkb extends Controller
{
    public function index() {
        $viewName = 'penjualan_update_data';
        $username = Session::get('username');
        $permission = DB::table('ms_permission')
            ->join('sys_menu','ms_permission.id_menu','=','sys_menu.id')
            ->where([
                ['ms_permission.username','=',$username],
                ['ms_permission.permission','=','1'],
                ['sys_menu.view_name','=',$viewName],
            ]);
        if ($permission->exists()) {
            return view('dashboard-penjualan-update-data');
        } else {
            return abort('403');
        }
    }

    public function upload(Request $request) {
        $username = Session::get('username');
        $file = $request->file('filepond');
        $extension = $file->extension();

        switch ($extension) {
            case 'xls':
                $reader = new Xls();
                break;

            case 'xlsx':
                $reader = new Xlsx();
        }

        try {
            $spreadsheet = $reader->load($file);
            $worksheet = $spreadsheet->getActiveSheet();
        } catch (\Exception $ex) {
            dd('Exception Block',$ex);
        }
        $array = $worksheet->toArray();

        foreach ($array[0] as $key => $value) {
            switch ($value) {
                case 'No SPK':
                    $noSPK = $key;
                    break;

                case 'Tanggal BPKB Diterima':
                    $tglDiterima = $key;
                    break;

                case 'status':
                    $status = $key;
            }
        }

        for ($i = 1; $i < count($array); $i++) {
            $tanggalUpdate = Carbon::parse($array[$i][$tglDiterima])->format('Y-m-d');
            if ($array[$i][$status] == 'selesai') {
                $iStatus = 1;
            } else {
                $iStatus = 0;
            }

            try {
                DB::table('penjualan_trn')
                    ->where([
                        ['no_spk','=',$array[$i][$noSPK]],
                        ['id_area','=','13'],
                    ])
                    ->update([
                        'tanggal' => $tanggalUpdate,
                        'username' => $username,
                        'status' => $iStatus,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
            } catch (\Exception $ex) {
                dd('Exception Block', $ex);
            }
        }
    }

    public function preview() {

    }

    public function simpan() {

    }

    public function sample() {
        return response()->download('sample/template-update-area.xlsx','template-update-area.xlsx');
    }
}
