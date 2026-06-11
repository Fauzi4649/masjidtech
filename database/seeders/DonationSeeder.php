<?php

namespace Database\Seeders;

use App\Models\Donation;
use App\Models\User;
use Illuminate\Database\Seeder;

class DonationSeeder extends Seeder
{
    public function run(): void
    {
        $member = User::where('role', 'member')->first();

        if ($member) {
            Donation::create([
                'user_id' => $member->id,
                'amount' => 50.00,
                'donation_date' => today(),
                'payment_method' => 'online_transfer',
                'status' => 'completed',
            ]);
        }
    }
}