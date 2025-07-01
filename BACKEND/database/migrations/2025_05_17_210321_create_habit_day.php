<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('habit_day', function (Blueprint $table) {
            $table->foreignId('habit_id')->constrained('habits')->onDelete('cascade');
            $table->foreignId('day_id')->constrained('day_of_weeks')->onDelete('cascade');
            $table->primary(['habit_id', 'day_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habit_day');
    }
};
