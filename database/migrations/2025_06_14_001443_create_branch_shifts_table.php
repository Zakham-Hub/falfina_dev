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
        Schema::create('branch_shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daily_schedule_id')->constrained('branch_daily_schedules')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->time('delivery_start_time');
            $table->time('delivery_end_time');
            $table->time('pickup_start_time');
            $table->time('pickup_end_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_shifts');
    }
};
