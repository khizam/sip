<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBahanLayakDanTidakLayakToLabTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lab', function (Blueprint $table) {
            $table->smallInteger('bahan_layak')
                ->nullable()
                ->after('grid');
            $table->smallInteger('bahan_tidak_layak')
                ->nullable()
                ->after('bahan_layak');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lab');
    }
}
