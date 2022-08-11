<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradeLabProduksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade_lab_produksi', function (Blueprint $table) {
            $table->increments('id_gradelab');
            $table->unsignedInteger('id_produksi');
            $table->foreign('id_produksi')
                    ->references('id_produksi')
                    ->on('produksi_barang')
                    ->onUpdate('restrict')
                    ->onDelete('cascade');
            $table->unsignedInteger('id_grade');
            $table->foreign('id_grade')
                    ->references('id_grade')
                    ->on('grade')
                    ->onUpdate('restrict')
                    ->onDelete('cascade');
            $table->integer('jumlah_produk');
            $table->integer('stok');
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
        Schema::dropIfExists('grade_lab_produksi');
    }
}
