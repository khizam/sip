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
            $table->id('id_request');
            $table->unsignedInteger('id_detail_produksi');
            $table->foreign('id_detail_produksi')->nullable()
                ->references('id_detail')
                ->on('detail_produksi')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->float('jumlah_bahan')->nullable();
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('id_user_produksi')->nullable();
            $table->foreign('id_user_produksi')
                ->references('id')
                ->on('users')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->unsignedBigInteger('id_user_gudang')->nullable();
            $table->foreign('id_user_gudang')
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
