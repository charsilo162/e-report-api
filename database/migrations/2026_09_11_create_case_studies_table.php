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
    Schema::create('case_studies', function (Blueprint $table) {
        $table->id();
        $table->string('slug')->unique();
        $table->string('tag')->nullable();
        $table->string('title');
        $table->text('excerpt');
        $table->string('image');
        $table->string('detail_title');
        $table->text('case_details');
        $table->json('evidence');           // [{title, description}, ...]
        $table->text('monetary_amount');
        $table->text('outcome');
        $table->json('stats');              // {amountRecovered, reportDate, resolutionDate, legalFrameworkUsed}
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('case_studies');
}

};
