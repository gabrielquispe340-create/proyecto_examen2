<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Table: anuncio (Avisos del Docente para el Grupo)
        Schema::create('anuncio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_id')->constrained('grupo')->onDelete('cascade');
            $table->foreignId('materia_id')->nullable()->constrained('materia')->onDelete('cascade');
            $table->foreignId('docente_id')->constrained('docente')->onDelete('cascade');
            $table->string('titulo');
            $table->text('contenido');
            $table->timestamps();
        });

        // 2. Table: tarea (Tareas/Prácticos creados por el Docente)
        Schema::create('tarea', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_id')->constrained('grupo')->onDelete('cascade');
            $table->foreignId('materia_id')->constrained('materia')->onDelete('cascade');
            $table->foreignId('docente_id')->constrained('docente')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descripcion');
            $table->dateTime('fecha_limite');
            $table->string('archivo_guia')->nullable();
            $table->timestamps();
        });

        // 3. Table: tarea_entrega (Entregas de los alumnos y calificaciones/comentarios)
        Schema::create('tarea_entrega', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tarea_id')->constrained('tarea')->onDelete('cascade');
            $table->foreignId('postulante_id')->constrained('postulante')->onDelete('cascade');
            $table->string('archivo_respuesta')->nullable();
            $table->text('comentario_postulante')->nullable();
            $table->decimal('calificacion', 5, 2)->nullable();
            $table->text('comentario_docente')->nullable();
            $table->dateTime('fecha_entrega')->useCurrent();
            $table->timestamps();

            $table->unique(['tarea_id', 'postulante_id']);
        });

        // 4. Table: mensaje (Chat de consultas directas entre docente y postulante)
        Schema::create('mensaje', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_id')->constrained('grupo')->onDelete('cascade');
            $table->foreignId('emisor_id')->constrained('usuario')->onDelete('cascade');
            $table->foreignId('receptor_id')->constrained('usuario')->onDelete('cascade');
            $table->text('contenido');
            $table->boolean('leido')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensaje');
        Schema::dropIfExists('tarea_entrega');
        Schema::dropIfExists('tarea');
        Schema::dropIfExists('anuncio');
    }
};
