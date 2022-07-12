<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestProduksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_produksi', function (Blueprint $table) {
            $table->increments('id_reqproduksi');
            $table->unsignedInteger('id');
            $table->foreign('id')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');
            $table->unsignedInteger('id_produk');
            $table->foreign('id_produk')
                    ->references('id_produk')
                    ->on('produk')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->integer('jumrequest_produksi');
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
        Schema::dropIfExists('request_produksi');
    }
}

