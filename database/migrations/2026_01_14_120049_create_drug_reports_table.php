<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('drug_reports', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_code')->unique();
            
            // الموقع
            $table->string('governorate');
            $table->text('exact_location');
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            
            // المرفق
            $table->string('evidence_file')->nullable();
            $table->text('evidence_description')->nullable();
            
            // نوع المخدرات
            $table->enum('drug_type', ['captagon', 'heroin', 'cannabis', 'chemical', 'pills', 'unknown'])->nullable();
            $table->enum('activity_type', ['production', 'storage', 'distribution', 'smuggling', 'transport'])->nullable();
            $table->enum('scale', ['individual', 'group', 'network', 'factory'])->nullable();
            $table->text('description')->nullable();
            
            // علامات مميزة
            $table->boolean('has_plated_cars')->default(false);
            $table->boolean('has_armed_guard')->default(false);
            $table->boolean('has_chemical_smells')->default(false);
            $table->boolean('has_night_activity')->default(false);
            
            // معلومات إضافية
            $table->enum('frequency', ['daily', 'weekly', 'monthly', 'random', 'continuous'])->nullable();
            
            // مستوى الخطورة
            $table->enum('threat_level', ['low', 'medium', 'high']);
            $table->enum('impact', ['local', 'district', 'city', 'regional'])->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('drug_reports');
    }
};