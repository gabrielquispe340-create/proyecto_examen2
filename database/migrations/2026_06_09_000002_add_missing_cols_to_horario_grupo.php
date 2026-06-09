<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Añade columnas faltantes a horario_grupo:
     * - docente_id (FK nullable a docente)
     * - aula (string nullable)
     * - created_at / updated_at (timestamps)
     * Solo añade las columnas si no existen (idempotente).
     */
    public function up(): void
    {
        Schema::table('horario_grupo', function (Blueprint $table) {
            if (!Schema::hasColumn('horario_grupo', 'docente_id')) {
                $table->foreignId('docente_id')
                      ->nullable()
                      ->after('materia_id')
                      ->constrained('docente')
                      ->onDelete('set null');
            }
            if (!Schema::hasColumn('horario_grupo', 'aula')) {
                $table->string('aula', 60)->nullable()->after('hora_fin');
            }
            if (!Schema::hasColumn('horario_grupo', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('horario_grupo', function (Blueprint $table) {
            if (Schema::hasColumn('horario_grupo', 'docente_id')) {
                $table->dropForeign(['docente_id']);
                $table->dropColumn('docente_id');
            }
            if (Schema::hasColumn('horario_grupo', 'aula')) {
                $table->dropColumn('aula');
            }
        });
    }
};
