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
            Schema::create('platform_topups', function (Blueprint $table) {
                $table->id();
                $table->decimal('amount', 15, 2);
                $table->string('method')->default('paystack');
                $table->string('reference')->nullable();
                $table->enum('status', ['Completed', 'Pending', 'Failed'])->default('Completed');
                $table->timestamps();
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('platform_topups');
        }

};
