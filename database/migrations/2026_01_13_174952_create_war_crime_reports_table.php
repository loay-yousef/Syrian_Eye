<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('war_crime_reports', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_code')->unique();
            
            // المشتبه به
            $table->string('suspect_name')->nullable();
            $table->string('suspect_rank')->nullable();
            $table->text('suspect_description')->nullable();
            $table->string('affiliation')->nullable();
            
            // الجريمة
            $table->json('crime_types'); // مصفوفة
            $table->text('crime_details')->nullable();
            $table->text('victims')->nullable();
            
            // الموقع
            $table->string('governorate');
            $table->text('exact_location');
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            
            // الوقت
            $table->date('crime_date')->nullable();
            $table->time('crime_time')->nullable();
            
            // المرفق
            $table->string('evidence_file')->nullable();
            $table->text('evidence_description')->nullable();
            
            // أنواع الأدلة (boolean)
            $table->boolean('has_photos')->default(false);
            $table->boolean('has_videos')->default(false);
            $table->boolean('has_audio')->default(false);
            $table->boolean('has_medical_reports')->default(false);
            $table->boolean('has_autopsy_reports')->default(false);
            $table->boolean('has_direct_witnesses')->default(false);
            $table->boolean('has_indirect_witnesses')->default(false);
            
            // الحماية
            $table->boolean('needs_protection')->default(false);
            
            // الأهمية والمنظمات
            $table->enum('importance', ['critical', 'important', 'supportive'])->default('important');
            $table->json('target_organizations'); // مصفوفة
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('war_crime_reports');
    }
};