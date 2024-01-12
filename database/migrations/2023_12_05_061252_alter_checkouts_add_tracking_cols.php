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
        Schema::table('checkouts', function (Blueprint $table) {
            $table->string('tracking_number')->nullable()->after('grand_total');
            $table->string('tracking_url')->nullable()->after('tracking_number');
            $table->string('estimated_delivery_date')->nullable()->after('tracking_url');
            $table->string('delivery_status')->default('pending')->after('estimated_delivery_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checkouts', function (Blueprint $table) {
            $table->dropColumn('tracking_number');
            $table->dropColumn('tracking_url');
            $table->dropColumn('estimated_delivery_date');
            $table->dropColumn('delivery_status');
        });
    }
};
