<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('calculations', function (Blueprint $table) {

            $table->id();

            // ========= Relation =========
            $table->foreignId('project_id')
                ->constrained('projects')
                ->cascadeOnDelete();

            // ========= 13 INPUTS =========

            // 1) Pavement Area (m2)
            $table->decimal('pavement_area_m2', 12, 2)->nullable();

            // 2) Pavement Age (1=New, 2=Medium, 3=Old)
            $table->unsignedTinyInteger('pavement_age_code')->nullable();

            // 3) Median Islands (1=Exist, 0=None)
            $table->unsignedTinyInteger('median_islands')->nullable();

            // 4) Asphalt Thickness (cm)
            $table->decimal('asphalt_thickness_cm', 6, 2)->nullable();

            // 5) HTS days > 45°C (Integer only)
            $table->unsignedSmallInteger('hts_days_over_45')->nullable();

            // 6) Road Classification (1=Main, 2=Secondary)
            $table->unsignedTinyInteger('road_class_code')->nullable();

            // 7) Road Condition PCI (1=Fair, 2=Poor, 3=Very Poor)
            $table->unsignedTinyInteger('pci_code')->nullable();

            // 8) AADT Heavy Vehicles (1=Low, 2=Medium, 3=High)
            $table->unsignedTinyInteger('aadt_heavy_code')->nullable();

            // 9) Drainage System (1=Exist, 0=None)
            $table->unsignedTinyInteger('drainage_system')->nullable();

            // 10) Maintenance Type (1=Preventive, 2=Routine, 3=Emergency)
            $table->unsignedTinyInteger('maintenance_type_code')->nullable();

            // 11) Soil Strength (1=Weak, 2=Medium, 3=Strong)
            $table->unsignedTinyInteger('soil_strength_code')->nullable();

            // 12) Pavement Type (1=Asphalt, 2=Mix)
            $table->unsignedTinyInteger('pavement_type_code')->nullable();

            // 13) Traffic Volume AADT (1=Low, 2=Medium, 3=High)
            $table->unsignedTinyInteger('aadt_code')->nullable();


            // ========= OUTPUTS =========

            // Estimated Cost (IQD)
            $table->unsignedBigInteger('estimated_cost')->nullable();

            // Gauge value = cost / area
            $table->decimal('gauge_value', 12, 2)->nullable();

            // Gauge Level
            $table->enum('gauge_level', [
                'very_low',
                'low',
                'medium',
                'high',
                'very_high'
            ])->nullable();

            // Explanation text
            $table->text('explanation')->nullable();

            $table->timestamps();

            // ========= Indexing =========
            $table->index(['project_id', 'created_at']);
            $table->index(['gauge_level']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calculations');
    }
};
