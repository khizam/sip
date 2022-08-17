<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKodeLabToLabTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lab', function (Blueprint $table) {
            $table->string('kode_lab')
                ->unique()
                ->after('id_lab');
            $table->enum('status', ['Accept', 'Reject'])->default('Reject');
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
            $table->dropColumn('kode_lab');
            $table->dropColumn('status');
        });
    }
}
