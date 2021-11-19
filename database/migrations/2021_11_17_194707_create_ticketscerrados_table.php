<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketscerradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets_cerrados', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('nombre', 25);
            $table->string('asunto', 40)->nullable();
            $table->string('motivo')->nullable();
            $table->foreignId('id_fuente');
            $table->foreignId('id_prioridad');
            $table->string('tipo_problema', 30);
            $table->dateTime('fechahora_solicitud')->nullable();
            $table->dateTime('fechahora_creacion');
            $table->dateTime('fechahora_cierre');
            $table->string('desc_problema', 300);
            $table->string('resol_problema', 200);
            $table->foreignId('id_tecnico')->nullable();
            $table->foreignId('id_solicitante')->nullable();
            $table->foreignId('id_coordinador')->nullable();

            $table->foreign('id_fuente')->references('id')->on('fuentes');
            $table->foreign('id_prioridad')->references('id')->on('prioridades');
            $table->foreign('id_tecnico')->reference('id')->on('tecnicos');
            $table->foreign('id_solicitante')->reference('id')->on('solicitantes');
            $table->foreign('id_coordinador')->references('id')->on('coordinadores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticketscerrados');
    }
}
