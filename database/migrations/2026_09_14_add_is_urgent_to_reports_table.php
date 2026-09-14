<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //database/migrations/2026_09_14_add_is_urgent_to_reports_table.php
public function up(): void
{
    Schema::table('reports', function (Blueprint $table) {
        $table->boolean('is_urgent')->default(false)->after('status');
    });
}

public function down(): void
{
    Schema::table('reports', function (Blueprint $table) {
        $table->dropColumn('is_urgent');
    });
}

};