<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolygonsTable extends Migration
{
    public function up()
    {
        Schema::create('polygons', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre del área de estudio
            $table->text('description')->nullable(); // Descripción opcional
            $table->json('geometry'); // Almacena el polígono en formato PostGIS
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('polygons');
    }
}