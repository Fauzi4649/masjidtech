<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get upcoming registrations (events where event_date >= today)
        $upcomingRegistrations = $user->registrations()
            ->with('event')
            ->whereHas('event', function ($query) {
                $query->where('event_date', '>=', now()->toDateString());
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Get past registrations (events already passed)
        $pastRegistrations = $user->registrations()
            ->with('event')
            ->whereHas('event', function ($query) {
                $query->where('event_date', '<', now()->toDateString());
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard', compact('upcomingRegistrations', 'pastRegistrations'));
    }
}