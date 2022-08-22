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
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->unsignedInteger('id_status')->nullable();
            $table->foreign('id_status')
                  ->references('id_status')
                  ->on('status_produksi')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->integer('jumlah');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
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
