<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //database/migrations/2026_09_14_create_activity_logs_table.php
public function up(): void
{
    Schema::create('activity_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('actor_id')->nullable()->constrained('users')->nullOnDelete();
        $table->string('title');
        $table->string('detail');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('activity_logs');
}

};