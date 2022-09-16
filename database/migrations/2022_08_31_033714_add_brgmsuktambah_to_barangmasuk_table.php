<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBrgmsuktambahToBarangmasukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barangmasuk', function (Blueprint $table) {
            $table->unsignedInteger('id_kemasan')->nullable();
            $table->foreign('id_kemasan')
                ->references('id_kemasan')
                ->on('kemasan')
                ->onUpdate('cascade')
                ->onDelete('cascade')
                ->after('id_supplier');
            $table->string('nomor_po');
            $table->string('pengirim');
            $table->string('penerima');
            $table->float('berat_kotor');
            $table->float('tara');
            $table->float('netto');
            $table->float('reject')->nullable();
            $table->string('kendaraan');
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
