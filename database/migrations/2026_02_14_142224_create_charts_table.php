<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('charts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('calculation_id')
                ->constrained('calculations')
                ->cascadeOnDelete();

            // bar | gauge
            $table->enum('type', ['bar', 'gauge']);

            // مثال: charts/15/bar.png
            $table->string('image_path', 255);

            // optional metadata
            $table->json('meta')->nullable();

            $table->timestamps();

            $table->unique(['calculation_id', 'type']); // عادة لكل calculation بار واحد وكَيج واحد
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('charts');
    }
};
