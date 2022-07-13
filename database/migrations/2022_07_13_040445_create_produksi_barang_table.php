<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksiBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produksi_barang', function (Blueprint $table) {
            $table->increments('id_produksi');
            $table->unsignedInteger('id_produk');
            $table->foreign('id_produk')
                  ->references('id_produk')
                  ->on('produk')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');
            $table->unsignedInteger('id_status');
            $table->foreign('id_status')
                  ->references('id_status')
                  ->on('status_produksi')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');
            $table->integer('jumlah');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')
                  ->references('id')
                  ->on('users')
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
        Schema::dropIfExists('produksi_barangs');
    }
}
