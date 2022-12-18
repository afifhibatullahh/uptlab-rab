<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketRabDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paket_rab_details', function (Blueprint $table) {
            $table->unsignedBigInteger('id_paket');
            $table->foreign('id_paket')->references('id')->on('pakets');
            $table->unsignedBigInteger('id_rab');
            $table->foreign('id_rab')->references('id')->on('rabs');
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
        Schema::dropIfExists('paket_rab_details');
    }
}
