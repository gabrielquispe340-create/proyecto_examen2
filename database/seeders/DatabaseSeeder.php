<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear 2 Docentes (Asumiendo que rol_id 3 es DOCENTE)
        for ($i = 1; $i <= 2; $i++) {
            $userId = DB::table('usuario')->insertGetId([
                'nombre' => "Docente $i",
                'apellido' => "Prueba $i",
                'email' => "docente$i@ficct.edu.bo",
                'password' => "123456",
                'rol_id' => 3, 
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('docente')->insert([
                'usuario_id' => $userId,
                'ci' => "88800$i",
                'nombre' => "Docente $i",
                'apellido' => "Prueba $i",
                'email' => "docente$i@ficct.edu.bo",
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // 2. Crear 10 Estudiantes (Asumiendo que rol_id 2 es POSTULANTE)
        for ($i = 1; $i <= 100; $i++) {
            $userId = DB::table('usuario')->insertGetId([
                'nombre' => "Estudiante $i",
                'apellido' => "Test $i",
                'email' => "estudiante$i@gmail.com",
                'password' => "99900$i",
                'rol_id' => 2,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('postulante')->insert([
                'usuario_id' => $userId,
                'convocatoria_id' => 1, // Asegúrate de tener una convocatoria con id 1
                'codigo_estudiante' => "POST-2026-00$i",
                'ci' => "99900$i",
                'nombre' => "Estudiante $i",
                'apellido' => "Test $i",
                'email' => "estudiante$i@gmail.com",
                'turno_asignado' => 'MAÑANA',
                'estado' => 'CON_PAGO',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}