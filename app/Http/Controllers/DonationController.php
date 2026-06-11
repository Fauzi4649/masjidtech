<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string|in:online_transfer,cash,card'
        ]);

        Donation::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'donation_date' => now(),
            'payment_method' => $request->payment_method,
            'status' => 'completed'
        ]);

        return redirect()->route('dashboard')->with('success', 'Thank you for your donation! RM ' . number_format($request->amount, 2));
    }
}