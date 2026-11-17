<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_weapon_report_can_be_submitted(): void
    {
        $response = $this->postJson('/api/reports/weapons', [
            'governorate' => 'دمشق',
            'exactLocation' => 'موقع اختباري',
            'ongoing' => 'yes',
        ]);

        $response->assertSuccessful()
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('weapon_reports', [
            'governorate' => 'دمشق',
            'exact_location' => 'موقع اختباري',
            'is_ongoing' => true,
        ]);
    }

    public function test_tunnel_report_can_be_submitted(): void
    {
        $response = $this->postJson('/api/reports/tunnels', [
            'governorate' => 'حلب',
            'exact_location' => 'موقع اختباري',
            'location_type' => 'tunnel',
            'purpose' => 'storage',
            'duration' => 'recent',
        ]);

        $response->assertSuccessful()
            ->assertJsonPath('success', true);
    }

    public function test_drug_report_can_be_submitted(): void
    {
        $response = $this->postJson('/api/reports/drugs', [
            'governorate' => 'حمص',
            'exact_location' => 'موقع اختباري',
            'threat_level' => 'medium',
        ]);

        $response->assertSuccessful()
            ->assertJsonPath('success', true);
    }

    public function test_war_crime_report_can_be_submitted_with_json_fields(): void
    {
        $response = $this->postJson('/api/reports/war-crimes', [
            'governorate' => 'درعا',
            'exact_location' => 'موقع اختباري',
            'crime_types' => json_encode(['القتل العمد'], JSON_UNESCAPED_UNICODE),
            'importance' => 'important',
            'target_organizations' => json_encode([], JSON_THROW_ON_ERROR),
        ]);

        $response->assertSuccessful()
            ->assertJsonPath('success', true);
    }

    public function test_war_crime_report_rejects_invalid_json_fields(): void
    {
        $response = $this->postJson('/api/reports/war-crimes', [
            'governorate' => 'درعا',
            'exact_location' => 'موقع اختباري',
            'crime_types' => 'not-json',
            'importance' => 'important',
            'target_organizations' => 'not-json',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['crime_types', 'target_organizations']);
    }
}
