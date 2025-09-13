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
        Schema::table('mensagens', function (Blueprint $table) {
            //
            $table->string('image_path')->nullable();
            $table->enum('message_type', ['text', 'image'])->default('text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mensagens', function (Blueprint $table) {
            //
            $table->dropColumn(['image_path', 'message_type']);
        });
    }
};
