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
        Schema::create('manager_devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manager_id')->constrained('managers')->onDelete('cascade');
            $table->string('fcm_token')->unique();
            $table->string('device_name')->nullable();
            $table->timestamps();
            $table->index(['manager_id', 'fcm_token']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manager_devices');
    }
}; 
