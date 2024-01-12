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
        Schema::create('coupon_codes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('user_id');
            $table->string('code');
            $table->integer('type')->comment('1 - Percentage, 2 - Amount');
            $table->decimal('value', 9, 2);
            $table->integer('times_of_use');
            $table->integer('used');
            $table->integer('once_per_customer')->default(0);
            $table->string('apply_category');
            $table->string('apply_product');
            $table->integer('is_no_time_limit');
            $table->string('date_start');
            $table->string('date_end');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_codes');
    }
};
