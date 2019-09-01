<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_users', function (Blueprint $table) {
            $table->string('username',10)->unique();
            $table->string('password',255);
            $table->string('nama_lengkap',100);
            $table->integer('tipe_akun');
            $table->tinyInteger('isDel');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ms_users');
    }
}
