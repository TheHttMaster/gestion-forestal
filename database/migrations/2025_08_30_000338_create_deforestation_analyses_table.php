<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeforestationAnalysesTable extends Migration
{
    public function up()
    {
        Schema::create('deforestation_analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('polygon_id')->constrained()->onDelete('cascade');
            $table->integer('year'); // Año del análisis
            $table->decimal('forest_area_ha', 10, 2); // Área boscosa en hectáreas
            $table->decimal('deforested_area_ha', 10, 2); // Área deforestada en hectáreas
            $table->decimal('percentage_loss', 5, 2); // Porcentaje de pérdida
            $table->json('metadata')->nullable(); // Datos adicionales en JSON
            $table->timestamps();
            
            // Índice compuesto para búsquedas eficientes
            $table->index(['polygon_id', 'year']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('deforestation_analyses');
    }
}