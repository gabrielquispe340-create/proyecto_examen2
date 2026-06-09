<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$cols = DB::select("SELECT column_name FROM information_schema.columns WHERE table_name = 'horario_grupo' ORDER BY ordinal_position");
foreach ($cols as $c) {
    echo $c->column_name . PHP_EOL;
}
