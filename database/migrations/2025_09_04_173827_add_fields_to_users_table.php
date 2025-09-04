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
            //
            $table->string('avatar')->nullable()->after('email');
            $table->enum('permission', ['admin', 'user'])->default('user')->after('avatar');
            $table->enum('status', ['online', 'offline'])->default('offline')->after('permission');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('avatar');
            $table->dropColumn('permission');
            $table->dropColumn('status');
        });
    }
};
