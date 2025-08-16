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
        Schema::table('settings', function (Blueprint $table) {
            if(!Schema::hasColumn('settings', 'delivery_range')) {
                $table->bigInteger('delivery_range')->nullable()->after('status');
            }
            if(!Schema::hasColumn('settings', 'delivery_fee_per_km')) {
                $table->decimal('delivery_fee_per_km', 8, 2)->nullable()->after('delivery_range');
            }
            if(!Schema::hasColumn('settings', 'delivery_fees')) {
                $table->decimal('delivery_fees', 8, 2)->nullable()->after('delivery_fee_per_km');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if(!Schema::hasColumn('settings', 'delivery_range')) {
                $table->dropColumn('delivery_range');
            }
            if(Schema::hasColumn('settings', 'delivery_fee_per_km')) {
                $table->dropColumn('delivery_fee_per_km');
            }
            if(Schema::hasColumn('settings', 'delivery_fees')) {
                $table->dropColumn('delivery_fees');
            }
        });
    }
};
