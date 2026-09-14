<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
//database/migrations/2026_09_13_create_category_report_table.php
public function up(): void
{
    Schema::create('category_report', function (Blueprint $table) {
        $table->foreignId('report_id')->constrained()->cascadeOnDelete();
        $table->foreignId('category_id')->constrained()->cascadeOnDelete();
        $table->primary(['report_id', 'category_id']);
    });
}

public function down(): void
{
    Schema::dropIfExists('category_report');
}
};