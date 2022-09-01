<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKodeLabToLabProduksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lab_produksi', function (Blueprint $table) {
            $table->string('kode_labproduksi')->nullable()
            ->unique()
            ->after('id_labproduksi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lab_produksi', function (Blueprint $table) {
            //
        });
    }
}
