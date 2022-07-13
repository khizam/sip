<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabProduksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_produksis', function (Blueprint $table) {
            $table->increments('id_labproduksi');
            $table->unsignedInteger('id_status_gudang_produksi');
            $table->foreign('id_status_gudang_produksi')
                  ->references('id_status_gudang_produksi')
                  ->on('status_gudang_produksi')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');
            $table->integer('stok');   
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
        Schema::dropIfExists('lab_produksis');
    }
}
