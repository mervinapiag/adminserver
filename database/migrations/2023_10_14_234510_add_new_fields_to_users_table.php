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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 15)->unique()->nullable()->after('id');
            $table->string('lastname', 15)->after('username');
            $table->string('firstname', 15)->after('lastname');
            $table->string('phonenumber')->nullable()->after('firstname');
            $table->string('address')->nullable()->after('phonenumber');
            $table->string('contact')->nullable()->after('email');
            $table->date('birthday')->nullable()->after('contact');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
