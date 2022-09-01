<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdProdukToGradeLabProduksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grade_lab_produksi', function (Blueprint $table) {
            $table->unsignedInteger('id_produk');
            $table->foreign('id_produk')->nullable()->after('id_produksi')
                ->references('id_produk')
                ->on('produk')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grade_lab_produksi', function (Blueprint $table) {
            //
        });
    }
}
