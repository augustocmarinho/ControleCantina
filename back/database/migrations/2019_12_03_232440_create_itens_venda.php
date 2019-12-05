<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItensVenda extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itens_venda', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('venda_id', false, true)->nullable(false);
            $table->foreign('venda_id')->references('id')->on('vendas')->onUpdate('CASCADE')->onDelete('CASCADE');
            
            $table->bigInteger('produto_id', false, true)->nullable(true);
            $table->foreign('produto_id')->references('id')->on('produtos')->onUpdate('CASCADE')->onDelete('CASCADE');
            
            $table->integer('quantidade')->nullable(false);

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
        Schema::dropIfExists('itens_venda');
    }
}
