<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('media')) {
            Schema::create('media', function (Blueprint $table) {
                $table->id();
                $table->morphs('mediable');
                $table->string('collection_name')->nullable();
                $table->string('file_name');
                $table->string('disk');
                $table->timestamps();
            });
        }
    }
};
