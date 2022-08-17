<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangmasukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangmasuk', function (Blueprint $table) {
            $table->increments('id_barangmasuk');
            $table->unsignedInteger('id_bahan');
            $table->foreign('id_bahan')
                ->references('id_bahan')
                ->on('bahan')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->unsignedInteger('id_kategori');
            $table->foreign('id_kategori')
                ->references('id_kategori')
                ->on('kategori')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->unsignedInteger('id_supplier');
            $table->foreign('id_supplier')
                ->references('id_supplier')
                ->on('supplier')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->integer('jumlah_bahan');
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
        Schema::dropIfExists('barangmasuk');
    }
}
