<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Eliminar el CHECK constraint del enum antiguo en PostgreSQL
        //    y limpiar los registros existentes para evitar conflictos
        DB::statement('DELETE FROM resultado_final');

        // 2. Eliminar columnas del esquema antiguo que ya no se usan
        Schema::table('resultado_final', function (Blueprint $table) {
            // Eliminar columnas viejas si existen
            $columns = DB::select("SELECT column_name FROM information_schema.columns WHERE table_name = 'resultado_final'");
            $columnNames = array_column($columns, 'column_name');

            if (in_array('estado_final', $columnNames)) {
                // En PostgreSQL hay que eliminar el CHECK del enum antes de borrar la columna
                DB::statement('ALTER TABLE resultado_final DROP COLUMN IF EXISTS estado_final');
            }
            if (in_array('promedio_final', $columnNames)) {
                $table->dropColumn('promedio_final');
            }
            if (in_array('calificacion_final', $columnNames)) {
                $table->dropColumn('calificacion_final');
            }
            if (in_array('posicion_ranking', $columnNames)) {
                $table->dropColumn('posicion_ranking');
            }
            if (in_array('fecha_calculo', $columnNames)) {
                $table->dropColumn('fecha_calculo');
            }
            if (in_array('observaciones', $columnNames)) {
                $table->dropColumn('observaciones');
            }
        });

        // 3. Agregar las columnas que usa el controlador (si aún no existen)
        Schema::table('resultado_final', function (Blueprint $table) {
            $columns = DB::select("SELECT column_name FROM information_schema.columns WHERE table_name = 'resultado_final'");
            $columnNames = array_column($columns, 'column_name');

            if (!in_array('promedio_mat', $columnNames)) {
                $table->decimal('promedio_mat', 5, 2)->default(0);
            }
            if (!in_array('promedio_fis', $columnNames)) {
                $table->decimal('promedio_fis', 5, 2)->default(0);
            }
            if (!in_array('promedio_com', $columnNames)) {
                $table->decimal('promedio_com', 5, 2)->default(0);
            }
            if (!in_array('promedio_ing', $columnNames)) {
                $table->decimal('promedio_ing', 5, 2)->default(0);
            }
            if (!in_array('promedio_total', $columnNames)) {
                $table->decimal('promedio_total', 5, 2)->default(0);
            }
            if (!in_array('aprobado_general', $columnNames)) {
                $table->boolean('aprobado_general')->default(false);
            }
            if (!in_array('ranking', $columnNames)) {
                $table->integer('ranking')->nullable();
            }
            if (!in_array('calculado_en', $columnNames)) {
                $table->timestamp('calculado_en')->nullable();
            }

            // estado_admision como varchar sin CHECK constraint (flexible)
            if (!in_array('estado_admision', $columnNames)) {
                $table->string('estado_admision', 30)->default('PROCESO');
            }
        });
    }

    public function down(): void
    {
        // Revertir no es necesario en este contexto, pero definimos el método
        Schema::table('resultado_final', function (Blueprint $table) {
            $table->dropColumn([
                'promedio_mat', 'promedio_fis', 'promedio_com', 'promedio_ing',
                'promedio_total', 'aprobado_general', 'ranking', 'calculado_en',
                'estado_admision',
            ]);
        });
    }
};
