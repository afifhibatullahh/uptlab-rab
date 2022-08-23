<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRabTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rab_item', function (Blueprint $table) {
            $table->unsignedBigInteger('id_rab');
            $table->foreign('id_rab')->references('id')->on('rabs');
            
            $table->unsignedBigInteger('id_item'); 
            $table->foreign('id_item')->references('id')->on('items');

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
        Schema::dropIfExists('rab_transactions');
    }
}
