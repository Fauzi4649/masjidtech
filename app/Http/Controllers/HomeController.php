<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Donation;
use App\Models\PrayerTime;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
{
    // Prayer times for today, sorted by adhan time
    $prayerTimes = PrayerTime::where('effective_date', today())
        ->orderBy('adhan_time')
        ->get();

    $now = Carbon::now();
    $currentPrayer = null;
    $nextPrayer = null;
    $nextPrayerTime = null;

    // Determine current and next prayer
    foreach ($prayerTimes as $index => $prayer) {
        $adhan = Carbon::parse($prayer->adhan_time);
        if ($adhan->lessThanOrEqualTo($now)) {
            // This prayer has already started (or starts exactly now)
            $currentPrayer = $prayer;
        } else {
            // First prayer that is in the future becomes the next prayer
            $nextPrayer = $prayer;
            $nextPrayerTime = $adhan;
            break;
        }
    }

    // If no next prayer today (all prayers passed), take first prayer of tomorrow
    if (!$nextPrayer && $prayerTimes->isNotEmpty()) {
        $nextPrayer = $prayerTimes->first();
        $nextPrayerTime = Carbon::parse($nextPrayer->adhan_time)->addDay();
    }

    // Fallback if no prayer times exist at all
    if (!$currentPrayer && $prayerTimes->isNotEmpty()) {
        $currentPrayer = $prayerTimes->first();
    }

    $currentPrayerName = $currentPrayer ? $currentPrayer->name : 'Zohor';
    $nextPrayerName = $nextPrayer ? $nextPrayer->name : 'Asr';
    $nextPrayerTimeFormatted = $nextPrayerTime ? $nextPrayerTime->format('H:i') : '16:28';

    // Upcoming events (limit to 3 for preview)
    $events = Event::with('registrations')
        ->where('event_date', '>=', today())
        ->orderBy('event_date')
        ->take(3)
        ->get();

    // Latest announcements (limit 4)
    $announcements = Announcement::latest()->take(4)->get();

    // Stats for hero & community sections
    $totalMembers = User::where('role', 'member')->count();
    $totalEvents = Event::where('event_date', '>=', Carbon::now()->startOfYear())
        ->where('event_date', '<=', Carbon::now()->endOfYear())
        ->count();

    // Hijri date (placeholder)
    $hijriDate = today()->format('l, j F Y') . ' AH (approx.)';

    return view('home', compact(
        'prayerTimes',
        'currentPrayerName',
        'nextPrayerName',
        'nextPrayerTimeFormatted',
        'events',
        'announcements',
        'totalMembers',
        'totalEvents',
        'hijriDate'
    ));
}
}