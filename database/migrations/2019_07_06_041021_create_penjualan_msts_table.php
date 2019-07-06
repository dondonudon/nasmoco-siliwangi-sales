<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenjualanMstsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan_mst', function (Blueprint $table) {
            $table->string('no_spk',30)->unique();
            $table->string('nama_customer',100);
            $table->string('no_rangka',30);
            $table->integer('id_leasing');
            $table->integer('id_kota');
            $table->integer('id_kecamatan');
            $table->string('alamat',100);
            $table->string('username',10);
            $table->tinyInteger('finish')->default(0);
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
        Schema::dropIfExists('penjualan_msts');
    }
}
