<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {

            $table->id();

            // ===== Basic Project Info =====
            $table->string('title', 150)->nullable();        // اسم المشروع
            $table->string('governorate', 80)->nullable();   // المحافظة
            $table->string('road_name', 150)->nullable();    // اسم الطريق

            // ===== Maintenance Date Only =====
            $table->date('maintenance_date')->nullable();    // تاريخ الصيانة

            $table->timestamps();

            // Indexes
            $table->index('governorate');
            $table->index('maintenance_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
