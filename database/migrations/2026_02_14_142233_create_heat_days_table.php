<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('heat_days', function (Blueprint $table) {
            $table->id();

            $table->string('governorate', 80);
            $table->unsignedSmallInteger('year');
            $table->unsignedSmallInteger('days_over_45')->nullable();

            $table->timestamps();

            $table->unique(['governorate', 'year']);
            $table->index(['governorate']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('heat_days');
    }
};
