<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('asunto', 40);
            $table->dateTime('fecha_hora');
            $table->string('desc_problema', 300);
            $table->boolean('en_curso')->default('false');
            $table->foreignId('id_tecnico')->nullable();
            $table->foreignId('id_coordinador')->nullable();
            $table->foreignId('id_solicitante');

            $table->foreign('id_tecnico')->references('id')->on('tecnicos')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_coordinador')->references('id')->on('coordinadores')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_solicitante')->references('id')->on('solicitantes')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitudes');
    }
}
