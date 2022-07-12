<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produksi', function (Blueprint $table) {
            $table->increments('id_produksi');
            $table->string('kode_produksi')
                    ->unique();
            $table->unsignedInteger('id_reqproduksi');
            $table->foreign('id_reqproduksi')
                    ->references('id_reqproduksi')
                    ->on('request_produksi')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');
            $table->integer('request_bahan')->nullable();
            $table->integer('jumlah_produksi')->nullable();
            $table->enum('status', ['Done', 'Process', 'Not Process'])->nullable();
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
        Schema::dropIfExists('produksi');
    }
}
