<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParameterLabTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameter_lab', function (Blueprint $table) {
            $table->increments('id_parameterlab');
            $table->unsignedInteger('id_lab');
            $table->foreign('id_lab')
                ->references('id_lab')
                ->on('lab')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedInteger('id_parameter');
            $table->foreign('id_parameter')
                ->references('id_parameter')
                ->on('parameter')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parameter_lab');
    }
}
