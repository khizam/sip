<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSatuanToProduksiBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produksi_barang', function (Blueprint $table) {
            $table->unsignedInteger('id_satuan');
            $table->foreign('id_satuan')
                    ->references('id_satuan')
                    ->on('satuan')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produksi_barang', function (Blueprint $table) {
            //
        });
    }
}
