<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Añadir columna docente_id a horario_grupo si no existe
$hasCol = DB::select("SELECT column_name FROM information_schema.columns WHERE table_name = 'horario_grupo' AND column_name = 'docente_id'");

if (empty($hasCol)) {
    // PostgreSQL usa BIGINT, no BIGINT UNSIGNED
    DB::statement('ALTER TABLE horario_grupo ADD COLUMN docente_id BIGINT NULL');

    // Intentar añadir FK si la tabla docente existe
    try {
        DB::statement('ALTER TABLE horario_grupo ADD CONSTRAINT horario_grupo_docente_id_foreign FOREIGN KEY (docente_id) REFERENCES docente(id) ON DELETE SET NULL');
        echo "Columna docente_id y Foreign key añadidas correctamente.\n";
    } catch (Exception $e) {
        echo "Columna docente_id añadida. FK no añadida: " . $e->getMessage() . "\n";
    }
} else {
    echo "La columna docente_id ya existe.\n";
}

// Verificar columnas finales
$cols = DB::select("SELECT column_name FROM information_schema.columns WHERE table_name = 'horario_grupo' ORDER BY ordinal_position");
echo "Columnas actuales en horario_grupo: ";
foreach ($cols as $c) {
    echo $c->column_name . ", ";
}
echo PHP_EOL;
