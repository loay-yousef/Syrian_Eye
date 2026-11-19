<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['weapon_reports', 'war_crime_reports', 'tunnel_reports', 'drug_reports'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName): void {
                $table->string('status')->default('new')->index();
                $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamp('reviewed_at')->nullable();
            });
        }
    }

    public function down(): void
    {
        foreach (['weapon_reports', 'war_crime_reports', 'tunnel_reports', 'drug_reports'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName): void {
                $table->dropForeign(['reviewed_by']);
                $table->dropIndex($tableName.'_status_index');
                $table->dropColumn(['status', 'reviewed_by', 'reviewed_at']);
            });
        }
    }
};
