<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
//database/migrations/2026_09_13_add_wallet_id_to_users_table.php — run: php artisan make:migration add_wallet_id_to_users_table --table=users
public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('wallet_id')->nullable()->unique()->after('role');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('wallet_id');
    });
}

};