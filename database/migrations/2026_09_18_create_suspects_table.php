<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
//database/migrations/2026_09_18_create_suspects_table.php
public function up(): void
{
    Schema::create('suspects', function (Blueprint $table) {
        $table->id();
        $table->foreignId('report_id')->constrained()->cascadeOnDelete();
        $table->string('full_name');
        $table->string('position')->nullable();
        $table->string('phone')->nullable();
        $table->string('email')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('suspects');
}

};