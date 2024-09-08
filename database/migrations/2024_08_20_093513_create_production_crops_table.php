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
        Schema::create('production_crops', function (Blueprint $table) {
            $table->id();
            $table->integer('last_production_datas_id')->nullable();
            $table->double('unit_price_per_kg');
            $table->double('gross_income');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_crops');
    }
};
