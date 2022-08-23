<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pakets', function (Blueprint $table) {
            $table->id();
            $table->string('jenis');
            $table->string('nomor_akun');
            $table->string('status');
            $table->date('waktu_pelaksanaan');
            $table->unsignedBigInteger('id_rab');
            $table->foreign('id_rab')->references('id')->on('rabs');
            $table->integer('total_harga');
            $table->integer('ppn');
            $table->integer('total_rab');
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
        Schema::dropIfExists('pakets');
    }
}
