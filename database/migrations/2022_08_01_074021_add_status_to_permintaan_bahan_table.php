<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToPermintaanBahanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permintaan_bahan', function (Blueprint $table) {
            $table->enum('status', ['proses', 'terima', 'tolak'])->nullable()->default('proses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permintaan_bahan', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
