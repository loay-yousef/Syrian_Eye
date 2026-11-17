<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tunnel_reports', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_code')->unique();
            
            // الموقع
            $table->string('governorate');
            $table->text('exact_location');
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->enum('location_type', ['tunnel', 'bunker', 'headquarters', 'warehouse']);
            
            // المرفق
            $table->string('evidence_file')->nullable();
            $table->text('evidence_description')->nullable();
            
            // القياسات
            $table->decimal('length', 8, 2)->nullable(); // بالمتر
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('depth', 8, 2)->nullable();
            $table->integer('entrances')->nullable();
            $table->enum('construction_type', ['natural', 'simple', 'reinforced', 'advanced', 'unknown'])->nullable();
            
            // الاستخدام
            $table->enum('purpose', ['storage', 'living', 'command', 'production', 'unknown']);
            $table->boolean('has_continuous_movement')->default(false);
            $table->boolean('has_equipment_transport')->default(false);
            $table->boolean('has_armed_guard')->default(false);
            $table->boolean('has_vehicle_traffic')->default(false);
            $table->boolean('has_machinery_sounds')->default(false);
            $table->string('capacity')->nullable();
            
            // الحماية
            $table->boolean('has_cameras')->default(false);
            $table->boolean('has_towers')->default(false);
            $table->boolean('has_patrols')->default(false);
            $table->boolean('has_mines')->default(false);
            $table->boolean('has_barbed_wire')->default(false);
            $table->boolean('has_concrete_barriers')->default(false);
            $table->boolean('has_alarm_systems')->default(false);
            $table->boolean('has_generators')->default(false);
            $table->boolean('has_ventilation')->default(false);
            $table->enum('security_level', ['none', 'light', 'medium', 'heavy', 'fortified'])->nullable();
            
            // معلومات زمنية
            $table->date('discovery_date')->nullable();
            $table->string('activity_time')->nullable();
            $table->enum('duration', ['recent', 'medium', 'long', 'unknown']);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tunnel_reports');
    }
};