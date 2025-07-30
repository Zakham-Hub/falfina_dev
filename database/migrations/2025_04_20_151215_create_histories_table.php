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
        if(!Schema::hasTable('histories')) {
            Schema::create('histories', function (Blueprint $table) {
                $table->id();
                $table->morphs('historyable');
                $table->string('changed_column');
                $table->text('change_value_from')->nullable();
                $table->text('change_value_to')->nullable();
                $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
                $table->foreignId('manager_id')->nullable()->constrained('managers')->nullOnDelete();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamps();
            });

        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
