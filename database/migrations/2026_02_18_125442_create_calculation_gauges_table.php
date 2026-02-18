<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calculation_gauges', function (Blueprint $table) {

            $table->id();

            $table->foreignId('calculation_id')
                ->constrained('calculations')
                ->cascadeOnDelete()
                ->unique(); // 1:1

            // Core gauge value (a = cost/area)
            $table->decimal('a', 12, 2);

            // Classification
            $table->string('label_key', 40);
            $table->string('label', 80)->nullable(); // optional

            // Applied range
            $table->integer('range_min');
            $table->integer('range_max');
            $table->string('range_color', 20);

            // Global scale
            $table->integer('min');
            $table->integer('max');

            // Snapshot for Plotly & PDF stability
            $table->json('ranges_json');

            $table->timestamps();

            $table->index('label_key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calculation_gauges');
    }
};
