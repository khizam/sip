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
            $table->string('kode_labproduksi')
                    ->unique();
            $table->unsignedInteger('id_produksi');
            $table->foreign('id_produksi')
                    ->references('id_produksi')
                    ->on('produksi')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');
            $table->integer('stok_produkjadi');
            $table->integer('stok produkgagal');
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
