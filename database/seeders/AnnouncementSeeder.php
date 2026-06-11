<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        if ($admin) {
            Announcement::create([
                'title' => 'Jumaat Prayer Timings for May 2026',
                'content' => 'Jumaat prayers this month will be held at 1:15 PM (first congregation) and 2:15 PM (second congregation). Please arrive early as space is limited.',
                'admin_id' => $admin->id,
            ]);

            Announcement::create([
                'title' => 'Ramadan Food Bank Collections Open',
                'content' => 'We are now collecting non-perishable food items, toiletries and clothing for distribution. Drop-off point: Ground Floor Office, 9 AM – 9 PM daily.',
                'admin_id' => $admin->id,
            ]);

            Announcement::create([
                'title' => 'New Islamic Finance Course — Registration Open',
                'content' => 'Ustaz Dr. Khairul Azmi will be conducting a 6-week course on Islamic Finance and Halal Investing every Tuesday at 8:00 PM. Limited seats available.',
                'admin_id' => $admin->id,
            ]);
        }
    }
}