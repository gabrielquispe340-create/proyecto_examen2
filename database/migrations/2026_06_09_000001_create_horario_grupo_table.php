<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Crea la tabla horario_grupo que almacena los horarios semanales
     * de cada grupo académico por materia, día, hora y aula.
     * Usa hasTable() como guard para no fallar si la tabla ya existe.
     */
    public function up(): void
    {
        if (Schema::hasTable('horario_grupo')) {
            return; // Tabla ya existe (creada manualmente)
        }

        Schema::create('horario_grupo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_id')->constrained('grupo')->onDelete('cascade');
            $table->foreignId('materia_id')->constrained('materia')->onDelete('cascade');
            // Docente asignado a este horario (puede ser null si aún no se asigna)
            $table->foreignId('docente_id')->nullable()->constrained('docente')->onDelete('set null');
            // Día de la semana: LUNES, MARTES, MIÉRCOLES, JUEVES, VIERNES, SÁBADO
            $table->string('dia_semana', 20);
            $table->time('hora_inicio');
            $table->time('hora_fin');
            // Aula o ambiente donde se dicta la clase
            $table->string('aula', 60)->nullable();
            $table->timestamps();

            // Índices para acelerar las búsquedas de conflictos
            $table->index(['grupo_id', 'dia_semana']);
            $table->index(['docente_id', 'dia_semana']);
            $table->index(['aula', 'dia_semana']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horario_grupo');
    }
};
