<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->string('codigo', 50)->unique();
            $table->text('descripcion')->nullable();
            $table->decimal('latitud', 12, 8)->nullable(); // Mayor precisión para PostgreSQL
            $table->decimal('longitud', 12, 8)->nullable(); // Mayor precisión para PostgreSQL
            $table->foreignId('area_padre_id')->nullable()->constrained('areas')->onDelete('cascade');
            $table->enum('tipo', ['pais', 'estado', 'ciudad', 'municipio', 'zona', 'barrio'])->default('zona');
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Índices adicionales para PostgreSQL
        Schema::table('areas', function (Blueprint $table) {
            $table->index('area_padre_id');
            $table->index('tipo');
            $table->index('activo');
            $table->index(['latitud', 'longitud']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('areas');
    }
};