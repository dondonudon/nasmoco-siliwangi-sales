<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAjuFakturValidasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aju_faktur_validasi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_checklist');
            $table->string('no_spk', 50);
            $table->string('nama', 75);
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
        Schema::dropIfExists('aju_faktur_validasis');
    }
}
