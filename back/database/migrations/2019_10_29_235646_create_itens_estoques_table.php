<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItensEstoquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itens_estoque', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('produto_id', false, true)->nullable(true);
            $table->foreign('produto_id')->references('id')->on('produtos')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->integer('saldo');
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
        Schema::dropIfExists('itens_estoques');
    }
}
