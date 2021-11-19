<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('nombre', 25);
            $table->string('asunto', );
            $table->foreignId('id_fuente');
            $table->foreignId('id_estado');
            $table->foreignId('id_area')->nullable();
            $table->foreignId('id_prioridad');
            $table->string('tipo_problema', 25);
            $table->dateTime('fechahora_creacion');
            $table->string('desc_problema', 300);
            $table->string('resol_problema', 200)->nullable();
            $table->string('respuesta_problema', 200)->nullable();
            $table->smallInt('plazo_reapertura')->nullable();
            $table->foreignId('id_tecnico')->nullable();
            $table->foreignId('id_solicitante');
            $table->foreignId('id_coordinador');
            $table->foreignId('id_solicitud')->nullable();

            $table->foreign('id_fuente')->references('id')->on('fuentes');
            $table->foreign('id_estado')->references('id')->on('estados');
            $table->foreign('id_area')->references('id')->on('areas');
            $table->foreign('id_prioridad')->references('id')->on('prioridades');
            $table->foreign('id_tecnico')->references('id')->on('tecnicos')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_solicitante')->references('id')->on('solicitantes')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('id_coordinador')->references('id')->on('coordinadores')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('id_solicitud')->references('id')->on('solicitudes')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
