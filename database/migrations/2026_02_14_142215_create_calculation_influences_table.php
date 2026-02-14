<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('calculation_influences', function (Blueprint $table) {
            $table->id();

            $table->foreignId('calculation_id')
                ->constrained('calculations')
                ->cascadeOnDelete();

            // اسم المدخل (مثلاً: pavement_age_code, pci_code, ...)
            $table->string('input_key', 60);

            // 0..100
            $table->decimal('influence_percent', 6, 2)->default(0);

            // signed: cost_alt - cost_base
            $table->bigInteger('delta_cost')->default(0);

            // increase/decrease (اتجاه التغيير)
            $table->enum('direction', ['increase', 'decrease'])->nullable();

            // ترتيب هذا العامل ضمن الـ 8
            $table->unsignedTinyInteger('rank')->nullable();

            $table->timestamps();

            $table->unique(['calculation_id', 'input_key']); // لأنهم ثابتين لكل calculation
            $table->index(['calculation_id', 'rank']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calculation_influences');
    }
};
