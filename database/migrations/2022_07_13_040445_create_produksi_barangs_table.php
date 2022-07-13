<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksiBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produksi_barangs', function (Blueprint $table) {
            $table->increments('id_produksibarang');
            $table->unsignedInteger('id_produk');
            $table->foreign('id_produk')
                  ->references('id_produk')
                  ->on('produk')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');
            $table->unsignedInteger('id_status');
            $table->foreign('id_statusproduksi')
                  ->references('id_statusproduksi')
                  ->on('status_produksis')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');
            $table->unsignedInteger('id_bahan');
            $table->foreign('id_bahan')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');
            $table->integer('jumlah');
            $table->unsignedBigInteger('id');
            $table->foreign('id')
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
