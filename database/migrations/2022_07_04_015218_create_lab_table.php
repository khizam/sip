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
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->enum('satuan', ['kg', 'liter'])->nullable();
            $table->text('parameter')->nullable();
            $table->text('hasil')->nullable();
            $table->text('kesimpulan')->nullable();
            $table->text('grid')->nullable();
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
