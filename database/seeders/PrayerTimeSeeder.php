<?php

namespace Database\Seeders;

use App\Models\PrayerTime;
use Illuminate\Database\Seeder;

class PrayerTimeSeeder extends Seeder
{
    public function run(): void
    {
        $prayers = [
            ['name' => 'Subuh', 'adhan_time' => '05:47:00', 'iqama_time' => '06:00:00'],
            ['name' => 'Syuruk', 'adhan_time' => '07:04:00', 'iqama_time' => null],
            ['name' => 'Zohor', 'adhan_time' => '13:17:00', 'iqama_time' => '13:30:00'],
            ['name' => 'Asr',   'adhan_time' => '16:28:00', 'iqama_time' => '16:40:00'],
            ['name' => 'Maghrib','adhan_time' => '19:28:00', 'iqama_time' => '19:33:00'],
            ['name' => 'Isyak', 'adhan_time' => '20:40:00', 'iqama_time' => '20:50:00'],
        ];

        foreach ($prayers as $prayer) {
            PrayerTime::updateOrCreate(
                ['name' => $prayer['name'], 'effective_date' => today()],
                [
                    'adhan_time' => $prayer['adhan_time'],
                    'iqama_time' => $prayer['iqama_time'],
                    'effective_date' => today(),
                ]
            );
        }
    }
}