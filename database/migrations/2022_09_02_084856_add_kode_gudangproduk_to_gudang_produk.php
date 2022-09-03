<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKodeGudangprodukToGudangProduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gudang_produk', function (Blueprint $table) {
            $table->string('kode_gudangproduk')->nullable()
            ->unique()
            ->after('id_gudangproduk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gudang_produk', function (Blueprint $table) {
            //
        });
    }
}
