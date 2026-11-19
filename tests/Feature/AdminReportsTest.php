<?php

namespace Tests\Feature;

use App\Models\AdminAuditLog;
use App\Models\User;
use App\Models\WeaponReport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminReportsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_report_management(): void
    {
        $this->get('/admin/reports')->assertRedirect('/admin/login');
    }

    public function test_admin_can_update_report_status_and_audit_is_recorded(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $report = WeaponReport::create([
            'tracking_code' => 'WPN-TEST-0001',
            'governorate' => 'دمشق',
            'exact_location' => 'موقع اختباري',
            'is_ongoing' => true,
        ]);

        $this->actingAs($admin)
            ->patch('/admin/reports/weapons/'.$report->id.'/status', ['status' => 'confirmed'])
            ->assertRedirect('/admin/reports/weapons/'.$report->id);

        $this->assertDatabaseHas('weapon_reports', [
            'id' => $report->id,
            'status' => 'confirmed',
            'reviewed_by' => $admin->id,
        ]);
        $this->assertDatabaseHas('admin_audit_logs', [
            'user_id' => $admin->id,
            'action' => 'status_updated',
            'report_type' => 'weapons',
            'report_id' => $report->id,
        ]);
    }
}
