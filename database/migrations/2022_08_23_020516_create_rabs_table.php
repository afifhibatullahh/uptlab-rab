<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rabs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('jenis_rab');
            $table->string('nomor_akun');

            $table->integer('laboratorium');

            $table->enum('status', ['pending', 'accepted', 'rejected', 'update']);
            $table->date('waktu_pelaksanaan');

            $table->double('total_harga');
            $table->double('expenses');
            $table->double('total_harga2');
            $table->double('pajak');
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
        Schema::dropIfExists('rabs');
    }
}
