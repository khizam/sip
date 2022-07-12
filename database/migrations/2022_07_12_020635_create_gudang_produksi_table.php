<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGudangProduksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gudang_produksi', function (Blueprint $table) {
            $table->increments('id_gudangproduksi');
            $table->unsignedInteger('id_labproduksi');
            $table->foreign('id_labproduksi')
                    ->references('id_labproduksi')
                    ->on('lab_produksi')
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
        Schema::dropIfExists('gudang_produksi');
    }
}
