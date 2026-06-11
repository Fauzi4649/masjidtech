<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure an admin exists (will be created in UsersTableSeeder)
        $admin = User::where('role', 'admin')->first();

        if ($admin) {
            Event::create([
                'title' => 'Quran Intensive Weekend',
                'description' => 'A two-day intensive Quran recitation and tajweed workshop for intermediate learners.',
                'event_date' => now()->addDays(10),
                'event_time' => '08:00:00',
                'location' => 'Main Prayer Hall',
                'max_participants' => 40,
                'category' => 'Education',
                'admin_id' => $admin->id,
            ]);

            Event::create([
                'title' => 'Monthly Sisters\' Halaqah',
                'description' => 'Monthly spiritual gathering for Muslim women featuring guest speaker Ustazah Hafsah.',
                'event_date' => now()->addDays(5),
                'event_time' => '14:00:00',
                'location' => 'Sisters\' Hall (Level 2)',
                'max_participants' => 30,
                'category' => 'Sisters',
                'admin_id' => $admin->id,
            ]);

            Event::create([
                'title' => 'Youth Leadership Camp 2026',
                'description' => 'Annual overnight leadership camp for Muslim youth aged 15–25. Build skills and brotherhood.',
                'event_date' => now()->addDays(20),
                'event_time' => '09:00:00',
                'location' => 'Ulu Langat Retreat Centre',
                'max_participants' => 50,
                'category' => 'Youth',
                'admin_id' => $admin->id,
            ]);
        }
    }
}