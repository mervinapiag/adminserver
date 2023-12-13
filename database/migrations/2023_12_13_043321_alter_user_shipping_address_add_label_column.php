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
        Schema::table('user_shipping_addresses', function (Blueprint $table) {
            $table->string('label');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('socks')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_shipping_addresses', function (Blueprint $table) {
            $table->dropColumn('label');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('socks')->nullable()->change();
        });
    }
};