<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
//database/migrations/2026_09_13_create_evidence_files_table.php
public function up(): void
{
    Schema::create('evidence_files', function (Blueprint $table) {
        $table->id();
        $table->foreignId('report_id')->constrained()->cascadeOnDelete();
        $table->string('original_name');
        $table->string('path');
        $table->unsignedBigInteger('size'); // bytes
        $table->string('mime')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('evidence_files');
}

};