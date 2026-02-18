<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('calculation_explanations', function (Blueprint $table) {

            $table->id();

            $table->foreignId('calculation_id')
                ->constrained('calculations')
                ->cascadeOnDelete()
                ->unique(); // 1:1

            $table->longText('summary_ar');
            $table->longText('summary_en');

            $table->json('reasons_ar');
            $table->json('reasons_en');

            $table->json('debug_payload'); // التحليل العلمي الكامل

            $table->timestamps();

            $table->index('calculation_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calculation_explanations');
    }
};
