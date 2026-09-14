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
                $table->string('nickname')->nullable();
                $table->string('phone')->nullable();
                $table->enum('role', ['user', 'admin'])->default('user');
                $table->boolean('anonymous_by_default')->default(true);
                $table->boolean('two_factor_enabled')->default(false);
                $table->string('notification_channel')->default('Email');
                $table->boolean('notify_on_status_change')->default(true);
                $table->timestamp('suspended_at')->nullable();
            });
        }

        public function down(): void
        {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['nickname', 'phone', 'role', 'anonymous_by_default', 'two_factor_enabled', 'notification_channel', 'notify_on_status_change', 'suspended_at']);
            });
        }


};
