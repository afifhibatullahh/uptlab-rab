<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRabdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rabdetails', function (Blueprint $table) {
            $table->unsignedBigInteger('rab_id_ref');
            $table->foreign('rab_id_ref')->references('id')->on('rabs');
            $table->unsignedBigInteger('id_item');
            $table->foreign('id_item')->references('id')->on('items');
            $table->double('jumlah_harga');
            $table->string('pajak');
            $table->integer('qty');
            $table->string('satuan');
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
        Schema::dropIfExists('rabdetails');
    }
}
