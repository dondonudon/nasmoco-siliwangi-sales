<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_areas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama',25);
<<<<<<< HEAD
            $table->integer('perbandingan');
            $table->integer('tgl_target_default');
            $table->integer('use_nominal');
            $table->integer('ord');
=======
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
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
        Schema::dropIfExists('ms_areas');
    }
}
