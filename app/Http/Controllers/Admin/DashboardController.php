<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Donation;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMembers = User::where('role', 'member')->count();
        $totalEvents = Event::count();
        $totalRegistrations = EventRegistration::count();
        $totalDonations = Donation::where('status', 'completed')->sum('amount');

        $recentRegistrations = EventRegistration::with(['user', 'event'])
            ->latest()
            ->take(5)
            ->get();

        $weeklyData = EventRegistration::select(
                DB::raw('DAYNAME(created_at) as day'),
                DB::raw('COUNT(*) as count')
            )
            ->whereBetween('created_at', [now()->subDays(7), now()])
            ->groupBy('day')
            ->orderBy(DB::raw('FIELD(day, "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday")'))
            ->get();

        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $chartLabels = [];
        $chartData = [];

        foreach ($daysOfWeek as $day) {
            $found = $weeklyData->firstWhere('day', $day);
            $chartLabels[] = substr($day, 0, 3); // Mon, Tue, etc.
            $chartData[] = $found ? $found->count : 0;
        }

        $recentDonations = Donation::with('user')
            ->latest()
            ->take(5)
            ->get();

        $upcomingEvents = Event::where('event_date', '>=', today())
            ->orderBy('event_date')
            ->take(5)
            ->get();

            
        return view('admin.dashboard', compact(
            'totalMembers',
            'totalEvents',
            'totalRegistrations',
            'totalDonations',
            'recentRegistrations',
            'chartLabels',
            'chartData',
            'recentDonations',
            'upcomingEvents'
        ));
    }
}