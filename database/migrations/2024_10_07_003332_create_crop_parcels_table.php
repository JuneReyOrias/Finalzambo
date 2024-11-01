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
        Schema::create('crop_parcels', function (Blueprint $table) {
            $table->id();
            $table->json('coordinates'); // Store coordinates as JSON
            $table->decimal('area', 15, 8); // Store the area of the polygon
            $table->decimal('altitude', 8, 8); // Store the altitude of the polygon's first point
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crop_parcels');
    }
};
