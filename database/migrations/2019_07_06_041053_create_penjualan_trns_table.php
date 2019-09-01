<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenjualanTrnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan_trn', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_spk');
            $table->integer('id_area');
            $table->string('catatan')->default('');
            $table->date('tanggal');
            $table->string('username',10);
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('penjualan_trns');
    }
}
