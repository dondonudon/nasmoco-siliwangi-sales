<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->string('no_spk',100)->unique();
            $table->integer('tipe_pembelian');
            $table->string('nama_cust',100);
            $table->string('no_rangka',100);
            $table->integer('leasing');
            $table->integer('kota');
            $table->integer('kecamatan');
            $table->string('alamat',150);
            $table->date('tgl_spk');
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
        Schema::dropIfExists('penjualans');
    }
}
