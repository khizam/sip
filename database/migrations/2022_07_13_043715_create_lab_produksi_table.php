<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabProduksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_produksi', function (Blueprint $table) {
            $table->increments('id_labproduksi');
            $table->unsignedInteger('id_status');
            $table->foreign('id_status')
                  ->references('id_status')
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
