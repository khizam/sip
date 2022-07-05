<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab', function (Blueprint $table) {
            $table->increments('id_lab');
            $table->unsignedInteger('id_barangmasuk');
            $table->foreign('id_barangmasuk')
                  ->references('id_barangmasuk')
                  ->on('barangmasuk')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');
            $table->enum('satuan', ['kg', 'liter'])->nullable();
            $table->string('parameter')->nullable();
            $table->string('hasil')->nullable();
            $table->text('kesimpulan')->nullable();
            $table->string('grid')->nullable();
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
        Schema::dropIfExists('lab');
    }
}
