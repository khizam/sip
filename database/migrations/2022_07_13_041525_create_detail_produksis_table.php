<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailProduksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_produksis', function (Blueprint $table) {
            $table->increments('id_detail');
            $table->unsignedInteger('id_lab');
            $table->foreign('id_lab')
                  ->references('id_lab')
                  ->on('lab')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');
            $table->unsignedInteger('id_produksibarang');
            $table->foreign('id_produksibarang')
                  ->references('id_produksibarang')
                  ->on('produksi_barangs')
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
