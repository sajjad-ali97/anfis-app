<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calculations', function (Blueprint $table) {

            $table->id();

            $table->foreignId('project_id')
                ->constrained('projects')
                ->cascadeOnDelete();

            // ========= 13 INPUTS =========

            $table->decimal('pavement_area_m2', 12, 2)->nullable();          // Var1
            $table->unsignedTinyInteger('pavement_age_code')->nullable();    // Var2 (انتبه: code vs years)
            $table->unsignedTinyInteger('pci_code')->nullable();             // Var3
            $table->decimal('asphalt_thickness_cm', 6, 2)->nullable();        // Var4
            $table->unsignedTinyInteger('pavement_type_code')->nullable();   // Var5
            $table->unsignedTinyInteger('maintenance_type_code')->nullable(); // Var6
            $table->unsignedTinyInteger('aadt_code')->nullable();            // Var7 (Traffic Volume)
            $table->unsignedTinyInteger('aadt_heavy_code')->nullable();      // Var8
            $table->unsignedTinyInteger('road_class_code')->nullable();      // Var9
            $table->unsignedSmallInteger('hts_days_over_45')->nullable();    // Var10
            $table->unsignedTinyInteger('soil_strength_code')->nullable();   // Var11
            $table->unsignedTinyInteger('median_islands')->nullable();       // Var12
            $table->unsignedTinyInteger('drainage_system')->nullable();      // Var13

            // ========= OUTPUTS =========
            $table->unsignedBigInteger('estimated_cost')->nullable();        // IQD

            $table->timestamps();

            $table->index(['project_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calculations');
    }
};
