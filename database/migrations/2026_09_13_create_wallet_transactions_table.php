<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
//database/migrations/2026_09_13_create_wallet_transactions_table.php
public function up(): void
{
    Schema::create('wallet_transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('report_id')->nullable()->constrained()->nullOnDelete();
        $table->enum('type', ['Credit', 'Withdrawal']);
        $table->decimal('amount', 15, 2);
        $table->enum('status', ['Completed', 'Failed', 'Pending'])->default('Completed');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('wallet_transactions');
}

};