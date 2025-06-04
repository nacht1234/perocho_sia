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
        Schema::create('available_parking_spaces', function (Blueprint $table) {
            $table->id();
            $table->string('bldg_floor_no');
            $table->string('lot_no');
            $table->enum('status', ['available', 'booked'])->default('available');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('available_parking_spaces');
    }
};
