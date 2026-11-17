<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() :void
    {
        Schema::create('weapon_reports', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_code')->unique(); // WPN-XXXX-XXXX
            $table->string('governorate');
            $table->text('exact_location');
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->string('weapon_type')->nullable();
            $table->string('activity')->nullable();
            $table->text('description')->nullable();
            $table->date('event_date')->nullable();
            $table->time('event_time')->nullable();
            $table->boolean('is_ongoing')->default(true);
            $table->text('evidence_description')->nullable();
    
            // تخزين مسار الملف (ليس اسم المستخدم!)
            $table->string('evidence_file')->nullable(); // سيتم حفظه كـ hash أو اسم عشوائي
    
            $table->timestamps();
            $table->softDeletes(); // اختياري: لحذف مؤقت إذا لزم الأمر
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weapon_reports');
    }
};
