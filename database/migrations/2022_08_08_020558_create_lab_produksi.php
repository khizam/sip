<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class CreateLabProduksi extends Migration
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
            $table->unsignedInteger('id_produksi');
            $table->foreign('id_produksi')
                    ->references('id_produksi')
                    ->on('produksi_barang')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');
            $table->integer('jumlah_produksi');
            $table->integer('lost')
                    ->nullable();
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
        Schema::dropIfExists('lab_produksi');
    }
}
