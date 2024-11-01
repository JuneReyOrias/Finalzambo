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
        Schema::create('contact_us', function (Blueprint $table) {
            $table->id();
            $table->string('intro_title',200)->nullable();
            $table->string('location_address',100)->nullable();
            $table->json('coordinates')->nullable();
            $table->string('email',100)->unique();
            $table->double('contact_no',100)->nullable();
            $table->string('logo_partners')->nullable();
            $table->json('logo_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_us');
    }
};
