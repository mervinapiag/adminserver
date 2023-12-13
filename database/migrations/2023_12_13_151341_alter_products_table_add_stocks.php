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
        Schema::table('products', function (Blueprint $table) {
            $table->string('stocks')->after('image');
        });

        Schema::table('user_shipping_addresses', function (Blueprint $table) {
            $table->string('building_address')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('stocks');
        });

        Schema::table('user_shipping_addresses', function (Blueprint $table) {
            $table->string('building_address')->nullable(false)->change();
        });
    }
};
