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
            $table->unsignedInteger('id_labproduksi');
            $table->foreign('id_labproduksi')
                    ->references('id_labproduksi')
                    ->on('lab_produksi')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');
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
