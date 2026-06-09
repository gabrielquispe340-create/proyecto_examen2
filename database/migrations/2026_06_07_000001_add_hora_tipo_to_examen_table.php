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
        Schema::table('examen', function (Blueprint $table) {
            $table->string('hora')->nullable()->default('09:00')->after('fecha');
            $table->string('tipo')->nullable()->default('PRESENCIAL')->after('hora');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('examen', function (Blueprint $table) {
            $table->dropColumn(['hora', 'tipo']);
        });
    }
};
