<?php

namespace Database\Seeders;

use App\Models\DrugReport;
use App\Models\TunnelReport;
use App\Models\WarCrimeReport;
use App\Models\WeaponReport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    private array $governorates = [
        'دمشق',
        'ريف دمشق',
        'حلب',
        'حمص',
        'حماة',
        'اللاذقية',
        'درعا',
        'إدلب',
        'الرقة',
        'دير الزور',
    ];

    public function run(): void
    {
        $this->seedWeapons();
        $this->seedWarCrimes();
        $this->seedTunnels();
        $this->seedDrugs();
    }

    private function seedWeapons(): void
    {
        foreach (range(1, 12) as $index) {
            WeaponReport::create([
                'tracking_code' => $this->trackingCode('WPN'),
                'governorate' => $this->governorate($index),
                'exact_location' => 'موقع تجريبي رقم '.$index,
                'lat' => $this->latitude(),
                'lng' => $this->longitude(),
                'weapon_type' => fake()->randomElement(['light', 'heavy', 'explosives', 'unknown']),
                'activity' => fake()->randomElement(['storage', 'selling', 'smuggling', 'manufacturing']),
                'description' => 'بلاغ تجريبي لأغراض اختبار لوحة الإحصائيات.',
                'event_date' => now()->subDays($index * 3)->toDateString(),
                'event_time' => fake()->time('H:i'),
                'is_ongoing' => $index % 3 !== 0,
                'evidence_description' => null,
                'evidence_file' => null,
            ]);
        }
    }

    private function seedWarCrimes(): void
    {
        $crimeTypes = ['القتل العمد', 'تدمير الممتلكات', 'التعذيب', 'التهجير القسري'];

        foreach (range(1, 10) as $index) {
            WarCrimeReport::create([
                'tracking_code' => $this->trackingCode('WAR'),
                'suspect_name' => 'اسم تجريبي '.$index,
                'suspect_rank' => 'صفة تجريبية',
                'suspect_description' => 'وصف تجريبي غير حقيقي.',
                'affiliation' => 'unknown',
                'crime_types' => fake()->randomElements($crimeTypes, fake()->numberBetween(1, 2)),
                'crime_details' => 'تفاصيل تجريبية لأغراض اختبار النظام.',
                'victims' => 'بيانات ضحايا تجريبية.',
                'governorate' => $this->governorate($index + 2),
                'exact_location' => 'موقع تجريبي رقم '.$index,
                'lat' => $this->latitude(),
                'lng' => $this->longitude(),
                'crime_date' => now()->subDays($index * 4)->toDateString(),
                'crime_time' => fake()->time('H:i'),
                'evidence_file' => null,
                'evidence_description' => null,
                'has_photos' => $index % 2 === 0,
                'has_videos' => $index % 3 === 0,
                'has_audio' => false,
                'has_medical_reports' => $index % 4 === 0,
                'has_autopsy_reports' => false,
                'has_direct_witnesses' => $index % 2 !== 0,
                'has_indirect_witnesses' => false,
                'needs_protection' => $index % 3 === 0,
                'importance' => fake()->randomElement(['critical', 'important', 'supportive']),
                'target_organizations' => fake()->randomElements(['un', 'icrc', 'local'], fake()->numberBetween(0, 2)),
            ]);
        }
    }

    private function seedTunnels(): void
    {
        foreach (range(1, 8) as $index) {
            TunnelReport::create([
                'tracking_code' => $this->trackingCode('TNL'),
                'governorate' => $this->governorate($index + 4),
                'exact_location' => 'موقع نفق تجريبي رقم '.$index,
                'lat' => $this->latitude(),
                'lng' => $this->longitude(),
                'location_type' => fake()->randomElement(['tunnel', 'bunker', 'headquarters', 'warehouse']),
                'evidence_file' => null,
                'evidence_description' => null,
                'length' => fake()->randomFloat(2, 10, 800),
                'width' => fake()->randomFloat(2, 1, 20),
                'depth' => fake()->randomFloat(2, 1, 50),
                'entrances' => fake()->numberBetween(1, 5),
                'construction_type' => fake()->randomElement(['natural', 'simple', 'reinforced', 'advanced', 'unknown']),
                'purpose' => fake()->randomElement(['storage', 'living', 'command', 'production', 'unknown']),
                'has_continuous_movement' => $index % 2 === 0,
                'has_equipment_transport' => $index % 3 === 0,
                'has_armed_guard' => $index % 2 !== 0,
                'has_vehicle_traffic' => false,
                'has_machinery_sounds' => $index % 4 === 0,
                'capacity' => (string) fake()->numberBetween(5, 100),
                'has_cameras' => $index % 3 === 0,
                'has_towers' => false,
                'has_patrols' => $index % 2 === 0,
                'has_mines' => false,
                'has_barbed_wire' => false,
                'has_concrete_barriers' => $index % 4 === 0,
                'has_alarm_systems' => false,
                'has_generators' => $index % 2 === 0,
                'has_ventilation' => $index % 3 === 0,
                'security_level' => fake()->randomElement(['none', 'light', 'medium', 'heavy', 'fortified']),
                'discovery_date' => now()->subDays($index * 5)->toDateString(),
                'activity_time' => '22:00-04:00',
                'duration' => fake()->randomElement(['recent', 'medium', 'long', 'unknown']),
            ]);
        }
    }

    private function seedDrugs(): void
    {
        foreach (range(1, 10) as $index) {
            DrugReport::create([
                'tracking_code' => $this->trackingCode('DRG'),
                'governorate' => $this->governorate($index + 1),
                'exact_location' => 'موقع نشاط تجريبي رقم '.$index,
                'lat' => $this->latitude(),
                'lng' => $this->longitude(),
                'evidence_file' => null,
                'evidence_description' => null,
                'drug_type' => fake()->randomElement(['captagon', 'heroin', 'cannabis', 'chemical', 'pills', 'unknown']),
                'activity_type' => fake()->randomElement(['production', 'storage', 'distribution', 'smuggling', 'transport']),
                'scale' => fake()->randomElement(['individual', 'group', 'network', 'factory']),
                'description' => 'بلاغ مخدرات تجريبي لأغراض اختبار التحليل.',
                'has_plated_cars' => $index % 2 === 0,
                'has_armed_guard' => $index % 3 === 0,
                'has_chemical_smells' => $index % 4 === 0,
                'has_night_activity' => $index % 2 !== 0,
                'frequency' => fake()->randomElement(['daily', 'weekly', 'monthly', 'random', 'continuous']),
                'threat_level' => fake()->randomElement(['low', 'medium', 'high']),
                'impact' => fake()->randomElement(['local', 'district', 'city', 'regional']),
            ]);
        }
    }

    private function trackingCode(string $prefix): string
    {
        return $prefix.'-'.strtoupper(Str::random(8));
    }

    private function governorate(int $index): string
    {
        return $this->governorates[$index % count($this->governorates)];
    }

    private function latitude(): float
    {
        return fake()->randomFloat(7, 32.5, 37.3);
    }

    private function longitude(): float
    {
        return fake()->randomFloat(7, 35.5, 42.4);
    }
}
