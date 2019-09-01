<?php

use Illuminate\Database\Seeder;

class MasterArea extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => '1', 'nama' => 'AJU FAKTUR', 'perbandingan' => '0', 'tgl_target_default' => '0', 'use_nominal' => '0', 'ord' => '1',],
            ['id' => '2', 'nama' => 'AJU DR', 'perbandingan' => '1', 'tgl_target_default' => '1', 'use_nominal' => '0', 'ord' => '2',],
            ['id' => '3', 'nama' => 'PDS IN', 'perbandingan' => '2', 'tgl_target_default' => '3', 'use_nominal' => '0', 'ord' => '3',],
            ['id' => '4', 'nama' => 'GESEK', 'perbandingan' => '3', 'tgl_target_default' => '1', 'use_nominal' => '0', 'ord' => '4',],
            ['id' => '5', 'nama' => 'RETAIL', 'perbandingan' => '2', 'tgl_target_default' => '4', 'use_nominal' => '1', 'ord' => '5',],
            ['id' => '6', 'nama' => 'FAKTUR DATANG', 'perbandingan' => '1', 'tgl_target_default' => '5', 'use_nominal' => '0', 'ord' => '6',],
            ['id' => '7', 'nama' => 'PDS OUT', 'perbandingan' => '5', 'tgl_target_default' => '2', 'use_nominal' => '0', 'ord' => '7',],
            ['id' => '8', 'nama' => 'STNK JADI', 'perbandingan' => '6', 'tgl_target_default' => '7', 'use_nominal' => '0', 'ord' => '8',],
            ['id' => '9', 'nama' => 'PENAGIHAN', 'perbandingan' => '5', 'tgl_target_default' => '7', 'use_nominal' => '1', 'ord' => '9',],
            ['id' => '10', 'nama' => 'AR', 'perbandingan' => '5', 'tgl_target_default' => '7', 'use_nominal' => '1', 'ord' => '10',],
            ['id' => '11', 'nama' => 'PELUNASAN', 'perbandingan' => '9', 'tgl_target_default' => '7', 'use_nominal' => '1', 'ord' => '11',],
            ['id' => '12', 'nama' => 'BPKB JADI', 'perbandingan' => '8', 'tgl_target_default' => '90', 'use_nominal' => '0', 'ord' => '12',],
            ['id' => '13', 'nama' => 'BPKB DITERIMA', 'perbandingan' => '12', 'tgl_target_default' => '2', 'use_nominal' => '0', 'ord' => '13',],
            ['id' => '14', 'nama' => 'BPKB DISERAHKAN', 'perbandingan' => '13', 'tgl_target_default' => '2', 'use_nominal' => '0', 'ord' => '14',],
        ];
        foreach ($data as $d) {
            $area = new \App\msArea();

            $area->id = $d['id'];
            $area->nama = $d['nama'];
            $area->perbandingan = $d['perbandingan'];
            $area->tgl_target_default = $d['tgl_target_default'];
            $area->use_nominal = $d['use_nominal'];
            $area->ord = $d['ord'];

            $area->save();
        }
    }
}
