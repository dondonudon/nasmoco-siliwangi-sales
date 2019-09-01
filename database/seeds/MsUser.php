<?php

use Illuminate\Database\Seeder;

class MsUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\msUser();

        $user->username = 'dev';
        $user->password = \Illuminate\Support\Facades\Crypt::encryptString('dev');
        $user->nama_lengkap = 'DEVELOPER';

        $user->save();
    }
}
