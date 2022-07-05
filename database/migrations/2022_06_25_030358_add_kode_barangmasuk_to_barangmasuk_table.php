<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKodeBarangmasukToBarangmasukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barangmasuk', function (Blueprint $table) {
            $table->string('kode_barangmasuk')
            ->unique()
            ->after('id_barangmasuk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('barangmasuk', function (Blueprint $table) {
            //
        });
    }
}
