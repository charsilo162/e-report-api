<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
//database/migrations/xxxx_xx_xx_create_reports_table.php — run: php artisan make:migration create_reports_table
public function up(): void
{
    Schema::create('reports', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
        $table->string('org_name');
        $table->string('location');
        $table->date('incident_date');
        $table->json('wrongdoing');                 // ["Corruption", "Fraud", ...]
        $table->text('description');
        $table->string('report_to')->nullable();
        $table->boolean('is_anonymous')->default(true);
        $table->enum('status', [
            'Submitted', 'Under Review', 'Approved', 'In Progress', 'Resolved', 'Rejected',
        ])->default('Submitted');
        $table->string('passcode')->unique()->nullable()->index();
        $table->string('wallet_id')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('reports');
}


};
