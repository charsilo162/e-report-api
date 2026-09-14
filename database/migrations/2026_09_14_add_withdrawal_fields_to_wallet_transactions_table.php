<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
//database/migrations/2026_09_14_add_withdrawal_fields_to_wallet_transactions_table.php — run: php artisan make:migration add_withdrawal_fields_to_wallet_transactions_table --table=wallet_transactions
public function up(): void
{
    Schema::table('wallet_transactions', function (Blueprint $table) {
        $table->string('account_number')->nullable()->after('amount');
        $table->string('bank')->nullable()->after('account_number');
    });
}

public function down(): void
{
    Schema::table('wallet_transactions', function (Blueprint $table) {
        $table->dropColumn(['account_number', 'bank']);
    });
}

};