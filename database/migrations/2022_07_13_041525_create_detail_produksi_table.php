<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailProduksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_produksi', function (Blueprint $table) {
            $table->increments('id_detail');
            $table->unsignedInteger('id_bahan');
            $table->foreign('id_bahan')
                  ->references('id_bahan')
                  ->on('bahan')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');
            $table->unsignedInteger('id_produksi');
            $table->foreign('id_produksi')
                  ->references('id_produksi')
                  ->on('produksi_barang')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');
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
        Schema::dropIfExists('detail_produksis');
    }
}
