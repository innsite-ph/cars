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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('vin', 100);
            $table->string('license_plate', 100);
            $table->string('brand',100);
            $table->string('model', 100);
            $table->string('gearbox_type',100);
            $table->string('colour', 100);
            $table->string('fuel_type', 100);
            $table->string('engine_capacity', 100);
            $table->string('power', 100);
            $table->string('engine_code', 100);
            $table->date('car_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
