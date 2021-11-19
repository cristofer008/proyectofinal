<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoordinadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coordinadores', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('nombre', 25);
            $table->string('seg_nombre', 25)->nullable();
            $table->string('apellido_p', 25);
            $table->string('apellido_m', 25);
            $table->string('cargo', 30);
            $table->string('area', 40);
            $table->string('telefono', 15)->unique();
            $table->binary('foto')->nullable();
            $table->foreignId('id_user')->unique();

            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coordinadores');
    }
}
