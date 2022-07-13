<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RelationshipsToLabTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lab', function (Blueprint $table) {
            $table->unsignedInteger('id_status_gudang')->nullable()->default(1);
            $table->foreign('id_status_gudang')
                  ->references('id_status')
                  ->on('status_gudang')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lab', function (Blueprint $table) {
            //
        });
    }
}
