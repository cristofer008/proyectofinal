<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('nombre', 25);
            $table->string('seg_nombre', 25)->nullable();
            $table->string('apellido_p', 25);
            $table->string('apellido_m', 25);
            $table->string('telefono', 15)->nullable();
            $table->string('rol_funcion', 40);
            $table->foreignId('id_user')->unique();
            $table->binary('foto');

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
