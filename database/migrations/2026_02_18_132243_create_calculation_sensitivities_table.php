<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('calculation_sensitivities', function (Blueprint $table) {

            $table->id();

            $table->foreignId('calculation_id')
                ->constrained('calculations')
                ->cascadeOnDelete()
                ->unique(); // 1:1 relation

            // ==============================
            // Core Data
            // ==============================

            $table->json('bar_data'); // للرسم (Plotly)
            $table->json('debug_payload'); // التفاصيل العلمية

            // ==============================
            // Meta Info (من config وقت التنفيذ)
            // ==============================

            $table->integer('top_n');
            $table->decimal('perturb_percent', 5, 2);

            $table->timestamps();

            $table->index('calculation_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calculation_sensitivities');
    }
};
