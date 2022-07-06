<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToLabTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lab', function (Blueprint $table) {
            $table->enum('status', ['selesai', 'tidak selesai'])->nullable()->default('tidak selesai');
            $table->mediumText('keterangan')->nullable();
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
            $table->dropColumn('status');
            $table->dropColumn('keterangan');
        });
    }
}
