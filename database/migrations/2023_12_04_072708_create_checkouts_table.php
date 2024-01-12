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
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number');
            $table->integer('user_id');
            $table->string('region');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('barangay');
            $table->string('street_bldg_name');
            $table->string('postal_code');
            $table->string('city');
            $table->string('email');
            $table->string('phone_number');
            $table->string('courier');
            $table->string('payment_method');
            $table->string('receipt_img');
            $table->decimal('grand_total', 10, 2);
            $table->string('status')->default('pending')->comment('pending, confirmed, shipped, out for delivery, delivered');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkouts');
    }
};
