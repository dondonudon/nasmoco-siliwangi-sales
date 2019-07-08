<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AndroidSearchSpk extends Controller
{
    public function search(Request $request) {
        $spk = DB::table('penjualan_mst')
            ->select('no_spk','nama_customer','no_rangka','ms_leasings.nama AS leasing','ms_wilayah_kotas.nama AS kota','ms_wilayah_kecamatans.nama AS kecamatan','alamat','tanggal_spk','username','finish')
            ->join('ms_leasings','penjualan_mst.id_leasing','=','ms_leasings.id')
            ->join('ms_wilayah_kotas','penjualan_mst.id_kota','=','ms_wilayah_kotas.id')
            ->join('ms_wilayah_kecamatans','penjualan_mst.id_kecamatan','=','ms_wilayah_kecamatans.id')
            ->orderBy('finish');
        if ($request->search !== '') {
            $search = '%'.$request->search.'%';
            $spk->where('no_spk','like', $search)
                ->orWhere('nama_customer','like', $search);
        }
        return $spk->get();
    }
}
