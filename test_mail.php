<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

config(['mail.mailers.smtp.username' => 'gabrielquispe340@gmail.com']);

try {
    Illuminate\Support\Facades\Mail::raw('Test', function($msg){
        $msg->to('gabrielquispe340@gmail.com')->subject('Test');
    });
    echo "OK\n";
} catch(\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
