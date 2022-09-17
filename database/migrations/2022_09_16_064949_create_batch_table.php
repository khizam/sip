<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batch', function (Blueprint $table) {
            $table->increments('id_batch');
            $table->integer('jumlah_batch');
            $table->unsignedInteger('id_produksi');
            $table->foreign('id_produksi')
                ->references('id_produksi')
                ->on('produksi_barang')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('nama_batch');
            $table->unsignedInteger('id_status');
            $table->foreign('id_status')
                ->references('id_status')
                ->on('status_batch')
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
        Schema::dropIfExists('batch');
    }
}
