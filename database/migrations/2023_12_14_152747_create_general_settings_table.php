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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo');
            $table->string('favicon');
            $table->string('header_title');
            $table->text('footer_text');
            $table->string('contact_info');
            $table->string('social_media');
            $table->string('shipping_rate');
            $table->string('about_us_image');
            $table->string('history_image');
            $table->text('about_us_text');
            $table->text('history_text');
            $table->text('privacy_policy');
            $table->text('terms_and_condition');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
