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
        Schema::table('live_chats', function (Blueprint $table) {
            $table->string('guest_username')->nullable()->after('staff_id');
        });

        Schema::table('live_chat_messages', function (Blueprint $table) {
            $table->string('guest_username')->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('live_chats', function (Blueprint $table) {
            $table->dropColumn('guest_username');
        });

        Schema::table('live_chat_messages', function (Blueprint $table) {
            $table->dropColumn('guest_username');
        });
    }
};
