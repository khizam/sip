<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermintaanBahanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permintaan_bahan', function (Blueprint $table) {
            $table->increments('id_request');
            $table->unsignedInteger('detail_bahan_produksi');
            $table->foreign('detail_bahan_produksi')
                    ->references('id_detail')
                    ->on('detail_produksi')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');
            $table->integer('jumlah_bahan');
            $table->text('keterangan');
            $table->unsignedBigInteger('user_produksi');
            $table->foreign('user_produksi')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');
            $table->unsignedBigInteger('user_gudang');
            $table->foreign('user_gudang')
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
        Schema::dropIfExists('permintaan_bahan');
    }
}
