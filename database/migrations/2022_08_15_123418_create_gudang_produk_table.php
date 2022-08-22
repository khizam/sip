<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGudangProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gudang_produk', function (Blueprint $table) {
            $table->increments('id_gudangproduk');
            $table->unsignedInteger('id_gradelab')->nullable();
            $table->foreign('id_gradelab')
                    ->references('id_gradelab')
                    ->on('grade_lab_produksi')
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
        Schema::dropIfExists('gudang_produk');
    }
}
