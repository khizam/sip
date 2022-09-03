<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdGudangproduksiToProduksiBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produksi_barang', function (Blueprint $table) {
            $table->unsignedInteger('id_jenisproduksi')->nullable();
            $table->foreign('id_jenisproduksi')
                ->references('id_jenisproduksi')
                ->on('jenis_produksi')
                ->onUpdate('cascade')
                ->onDelete('cascade')
                ->after('id_status');
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
