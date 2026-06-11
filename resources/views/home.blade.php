@extends('layouts.app')

@section('title', 'MasjidTech — Smart Mosque Management')

@section('content')
<!-- HERO SECTION -->
<section class="hero" id="home">
    <div class="hero-bg"></div>
    <div class="hero-pattern"></div>
    <div class="container hero-content">
        <div class="hero-eyebrow">
            <i class="fas fa-star-and-crescent" style="color:var(--gold)"></i>
            Smart Mosque Management Platform
            <i class="fas fa-star-and-crescent" style="color:var(--gold)"></i>
        </div>
        <h1>Your Masjid,<br><span>Digitally Empowered</span></h1>
        <p>Streamline prayer times, events, announcements and community engagement — all in one beautiful platform designed for modern Islamic centers.</p>
        <div class="hero-actions">
            @guest
                <button class="btn btn-gold" onclick="openModal('registerModal')"><i class="fas fa-user-plus"></i> Join Our Community</button>
            @else
                <a href="{{ route('events.index') }}" class="btn btn-gold"><i class="fas fa-calendar-alt"></i> Browse Events</a>
            @endguest
            <a href="{{ route('events.index') }}" class="btn" style="background:rgba(255,255,255,.15);color:#fff;border-color:rgba(255,255,255,.3)">
                <i class="fas fa-calendar-alt"></i> View Events
            </a>
        </div>
        <div class="hero-stats">
            <div><div class="hero-stat-num">{{ $totalMembers ?? '2,400+' }}</div><div class="hero-stat-label">Registered Members</div></div>
            <div><div class="hero-stat-num">{{ $totalEvents ?? '48' }}</div><div class="hero-stat-label">Events This Year</div></div>
            <div><div class="hero-stat-num">5</div><div class="hero-stat-label">Daily Prayers Served</div></div>
            <div><div class="hero-stat-num">15+</div><div class="hero-stat-label">Programs & Classes</div></div>
        </div>
    </div>
    <div class="hero-card">
        <div class="next-prayer-label">NEXT PRAYER</div>
        <div class="next-prayer-name" id="nextPrayerName">{{ $nextPrayerName ?? 'Asr' }}</div>
        <div class="next-prayer-time" id="nextPrayerTime">{{ $nextPrayerTimeFormatted ?? '16:28' }}</div>
        <div class="next-prayer-sub">In <span id="prayerCountdown">1hr 12min</span></div>
    </div>
</section>

<!-- ABOUT SECTION -->
<section class="about-section" id="about">
    <div class="container">
        <div class="about-grid">
            <div class="about-img-wrap reveal">
                <i class="fas fa-mosque mosque-icon"></i>
                <div class="about-badge-float">Est. 1998 · 26 Years of Service</div>
            </div>
            <div class="reveal reveal-delay-1">
                <div class="section-label"><i class="fas fa-info-circle"></i> About Us</div>
                <h2 class="section-title">Serving the Community with Faith & Excellence</h2>
                <p class="section-sub">Masjid Al-Noor has been a cornerstone of the Muslim community, providing spiritual guidance, education and a welcoming space for worship and community gatherings.</p>
                <p style="color:var(--gray-500);font-size:.88rem;margin-top:12px">Our digital platform — MasjidTech — was built to modernize mosque operations, making it easier for members to stay connected, register for events, and access prayer information from anywhere.</p>
                <div class="values-grid" style="margin-top:28px">
                    <div class="value-card"><div class="value-icon"><i class="fas fa-hands-praying"></i></div><div class="value-title">Spiritual Growth</div><div class="value-desc">Daily programs, Quran classes and halaqas for all ages.</div></div>
                    <div class="value-card"><div class="value-icon"><i class="fas fa-users"></i></div><div class="value-title">Community Unity</div><div class="value-desc">Building bonds through shared events and outreach programs.</div></div>
                    <div class="value-card"><div class="value-icon"><i class="fas fa-graduation-cap"></i></div><div class="value-title">Education</div><div class="value-desc">Weekend Islamic school, adult education and youth programs.</div></div>
                    <div class="value-card"><div class="value-icon"><i class="fas fa-heart"></i></div><div class="value-title">Charitable Work</div><div class="value-desc">Zakat distribution, food drives and interfaith dialogue.</div></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PRAYER TIMES SECTION -->
<section class="prayer-section" id="prayer">
    <div class="container">
        <div class="section-header reveal">
            <div class="section-label"><i class="fas fa-sun"></i> Daily Schedule</div>
            <h2 class="section-title">Prayer Times</h2>
            <p class="section-sub">Today's prayer schedule for Masjid Al-Noor. Times are updated automatically based on our location.</p>
        </div>
        <div class="hijri-bar reveal">
            <div><div class="hijri-date">{{ $hijriDate ?? 'Wednesday, 15 Dhul Hijjah 1446 AH' }}</div><div class="hijri-location"><i class="fas fa-map-marker-alt" style="margin-right:5px;color:var(--green-400)"></i> Kuala Lumpur, Malaysia</div></div>
            <div style="color:rgba(255,255,255,.5);font-size:.82rem">{{ now()->format('l, j F Y') }}</div>
        </div>
        <div class="prayer-grid reveal">
            @foreach($prayerTimes ?? [] as $prayer)
            <div class="prayer-card {{ $prayer->name == $currentPrayerName ? 'active' : '' }}">
                <div class="prayer-icon"><i class="fas {{ $prayer->icon ?? 'fa-clock' }}"></i></div>
                <div class="prayer-name">{{ $prayer->name }}</div>
                <div class="prayer-time">{{ \Carbon\Carbon::parse($prayer->adhan_time)->format('H:i') }}</div>
                <div class="prayer-iqama">Iqama: {{ $prayer->iqama_time ? \Carbon\Carbon::parse($prayer->iqama_time)->format('H:i') : '-' }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- EVENTS PREVIEW -->
<section class="events-section" id="events">
    <div class="container">
        <div class="events-header reveal">
            <div><div class="section-label"><i class="fas fa-calendar-alt"></i> Upcoming Events</div><h2 class="section-title">Community Events</h2><p class="section-sub">Join us for these upcoming programs, workshops and gatherings.</p></div>
            <a href="{{ route('events.index') }}" class="btn btn-outline" style="flex-shrink:0">View All Events <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="events-grid">
            @forelse($events ?? [] as $event)
            <div class="event-card reveal">
                <div class="event-img" style="background:linear-gradient(135deg, #166534, #0d3320)">
                    <div class="event-img-pattern"></div>
                    <i class="fas fa-calendar-alt event-img-icon"></i>
                    <div class="event-date-chip">{{ $event->event_date->format('d') }}<br>{{ $event->event_date->format('M') }}</div>
                </div>
                <div class="event-body">
                    <div class="event-category"><span class="badge badge-green">{{ $event->category ?? 'General' }}</span></div>
                    <h3 class="event-title">{{ $event->title }}</h3>
                    <div class="event-meta">
                        <div class="event-meta-row"><i class="fas fa-calendar"></i> {{ $event->event_date->format('l, j F Y') }}</div>
                        <div class="event-meta-row"><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}</div>
                        <div class="event-meta-row"><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</div>
                    </div>
                    <div class="event-footer">
                        <div class="event-spots"><strong>{{ $event->remaining_spots }}</strong> spots left of {{ $event->max_participants }}</div>
                        @auth
                            @if($event->remaining_spots > 0 && !auth()->user()->registrations->contains('event_id', $event->id))
                                <button class="btn btn-primary" onclick="openEventReg({{ $event->id }}, '{{ addslashes($event->title) }}', '{{ $event->event_date->format('l, j F Y') }}', '{{ addslashes($event->location) }}')"><i class="fas fa-ticket-alt"></i> Register</button>
                            @elseif(auth()->user()->registrations->contains('event_id', $event->id))
                                <span class="badge badge-green">Registered</span>
                            @else
                                <span class="badge badge-gray">Full</span>
                            @endif
                        @else
                            <button class="btn btn-outline" onclick="openModal('loginModal')">Login to Register</button>
                        @endauth
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center">No upcoming events at the moment. Please check back later.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- ANNOUNCEMENTS PREVIEW -->
<section class="announcements-section" id="announcements">
    <div class="container">
        <div class="section-header reveal"><div class="section-label"><i class="fas fa-bullhorn"></i> News & Updates</div><h2 class="section-title">Announcements</h2><p class="section-sub">Stay informed with the latest news, reminders and updates from Masjid Al-Noor.</p></div>
        <div class="announce-grid">
            <div class="announce-feed reveal">
                @forelse($announcements ?? [] as $announcement)
                <div class="announce-card">
                    <div class="announce-top"><div><span class="badge badge-green" style="margin-bottom:6px;display:inline-block">News</span><div class="announce-title">{{ $announcement->title }}</div></div><div class="announce-date"><i class="fas fa-calendar"></i> {{ $announcement->created_at->format('j M Y') }}</div></div>
                    <div class="announce-text">{{ Str::limit($announcement->content, 180) }}</div>
                </div>
                @empty
                <p>No announcements yet.</p>
                @endforelse
            </div>
            <div class="reveal reveal-delay-2">
                <div class="sidebar-card"><h3><i class="fas fa-bolt" style="margin-right:8px"></i>Quick Access</h3>
                    <div class="quick-link" onclick="openModal('loginModal')"><div class="quick-link-icon"><i class="fas fa-sign-in-alt"></i></div><div><div class="quick-link-text">Member Portal</div><div class="quick-link-sub">Login to access full features</div></div></div>
                    <div class="quick-link"><div class="quick-link-icon"><i class="fas fa-donate"></i></div><div><div class="quick-link-text">Online Donation</div><div class="quick-link-sub">Support the masjid</div></div></div>
                    <div class="quick-link"><div class="quick-link-icon"><i class="fas fa-file-pdf"></i></div><div><div class="quick-link-text">Friday Khutbah</div><div class="quick-link-sub">Download this week's notes</div></div></div>
                    <div class="quick-link"><div class="quick-link-icon"><i class="fas fa-book-open"></i></div><div><div class="quick-link-text">Islamic Resources</div><div class="quick-link-sub">Articles, audios & more</div></div></div>
                    <div class="quick-link"><div class="quick-link-icon"><i class="fas fa-envelope"></i></div><div><div class="quick-link-text">Subscribe Newsletter</div><div class="quick-link-sub">Get weekly updates</div></div></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- COMMUNITY SECTION -->
<section class="community-section" id="community">
    <div class="community-pattern"></div>
    <div class="container community-content">
        <div class="community-grid">
            <div class="community-text reveal"><div class="section-label"><i class="fas fa-users"></i> Our Community</div><h2 class="section-title">Everything You Need to Stay Connected</h2><p class="section-sub">MasjidTech brings together all the tools your mosque community needs in one seamless digital experience.</p>
                <div class="feature-list">
                    <div class="feature-item"><div class="feature-icon"><i class="fas fa-clock"></i></div><div><div class="feature-title">Real-time Prayer Notifications</div><div class="feature-desc">Receive adhan alerts and iqama reminders on your device.</div></div></div>
                    <div class="feature-item"><div class="feature-icon"><i class="fas fa-calendar-check"></i></div><div><div class="feature-title">Event Registration & Ticketing</div><div class="feature-desc">Register for programs and track attendance seamlessly.</div></div></div>
                    <div class="feature-item"><div class="feature-icon"><i class="fas fa-shield-alt"></i></div><div><div class="feature-title">Secure Admin Dashboard</div><div class="feature-desc">Manage all mosque operations from a single control panel.</div></div></div>
                    <div class="feature-item"><div class="feature-icon"><i class="fas fa-photo-video"></i></div><div><div class="feature-title">Media & Document Library</div><div class="feature-desc">Upload event posters, khutbahs and Islamic content.</div></div></div>
                </div>
            </div>
            <div class="community-right reveal reveal-delay-2">
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-users"></i></div><div class="stat-num">{{ $totalMembers ?? '2,400+' }}</div><div class="stat-label">Active Members</div></div>
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-calendar-alt"></i></div><div class="stat-num">{{ $totalEvents ?? '48' }}</div><div class="stat-label">Events This Year</div></div>
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-hands-helping"></i></div><div class="stat-num">12</div><div class="stat-label">Active Volunteers</div></div>
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-star-and-crescent"></i></div><div class="stat-num">26</div><div class="stat-label">Years Serving</div></div>
            </div>
        </div>
    </div>
</section>

<!-- ADMIN PREVIEW SECTION (optional, shown only to guests) -->
<section class="admin-section" id="admin">
    <div class="container">
        <div class="section-header reveal" style="text-align:center;max-width:560px;margin:0 auto 48px"><div class="section-label"><i class="fas fa-tachometer-alt"></i> Admin Panel</div><h2 class="section-title">Powerful Admin Dashboard</h2><p class="section-sub">A comprehensive control center for mosque administrators to manage all operations efficiently.</p></div>
        <div class="admin-preview reveal">
            <div class="admin-topbar"><div class="admin-topbar-title"><i class="fas fa-mosque"></i> MasjidTech Admin · Masjid Al-Noor</div><div class="admin-topbar-actions"><div class="admin-dot" style="background:#ef4444"></div><div class="admin-dot" style="background:#f59e0b"></div><div class="admin-dot" style="background:#22c55e"></div></div></div>
            <div class="admin-inner"><div class="admin-sidebar"><div class="admin-nav-item active"><i class="fas fa-chart-bar"></i> Overview</div><div class="admin-nav-item"><i class="fas fa-calendar-alt"></i> Events</div><div class="admin-nav-item"><i class="fas fa-users"></i> Members</div><div class="admin-nav-item"><i class="fas fa-clock"></i> Prayer Times</div><div class="admin-nav-item"><i class="fas fa-bullhorn"></i> Announcements</div><div class="admin-nav-item"><i class="fas fa-image"></i> Media Upload</div><div class="admin-nav-item"><i class="fas fa-donate"></i> Donations</div><div class="admin-nav-item"><i class="fas fa-cog"></i> Settings</div></div>
                <div class="admin-main">
                    <div style="font-size:.8rem;color:var(--gray-400);margin-bottom:14px">Welcome back, <strong style="color:var(--green-700)">Admin Ustaz Hafiz</strong> · {{ now()->format('l, j F Y') }}</div>
                    <div class="admin-kpis"><div class="kpi-card"><div class="kpi-label">Total Members</div><div class="kpi-value">2,418</div><div class="kpi-delta"><i class="fas fa-arrow-up"></i> +34 this month</div></div><div class="kpi-card"><div class="kpi-label">Events This Month</div><div class="kpi-value">7</div><div class="kpi-delta"><i class="fas fa-arrow-up"></i> +2 vs last month</div></div><div class="kpi-card"><div class="kpi-label">Registrations</div><div class="kpi-value">412</div><div class="kpi-delta"><i class="fas fa-arrow-up"></i> +18% growth</div></div><div class="kpi-card"><div class="kpi-label">Donations (RM)</div><div class="kpi-value">8,240</div><div class="kpi-delta"><i class="fas fa-arrow-up"></i> +5% vs last month</div></div></div>
                    <div class="admin-charts"><div class="chart-card"><div class="chart-title">Weekly Attendance</div><div class="bar-chart"><div class="bar" style="height:40%"></div><div class="bar" style="height:65%"></div><div class="bar" style="height:55%"></div><div class="bar" style="height:80%"></div><div class="bar" style="height:100%;background:var(--green-700)"></div><div class="bar" style="height:72%"></div><div class="bar" style="height:68%"></div></div><div style="display:flex;justify-content:space-between;font-size:.68rem;color:var(--gray-400);margin-top:6px"><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span style="color:var(--green-700);font-weight:700">Fri</span><span>Sat</span><span>Sun</span></div></div><div class="chart-card"><div class="chart-title">Recent Registrations</div><table class="recent-table"><thead><tr><th>Name</th><th>Event</th><th>Status</th></tr></thead><tbody><tr><td>Ahmad Zaki</td><td>Quran Intensive</td><td><span class="badge badge-green">Confirmed</span></td></tr><tr><td>Nurul Aina</td><td>Sisters' Halaqah</td><td><span class="badge badge-green">Confirmed</span></td></tr><tr><td>Muhammad Ikram</td><td>Youth Camp 2026</td><td><span class="badge badge-gold">Pending</span></td></tr><tr><td>Fatimah Zahra</td><td>Quran Intensive</td><td><span class="badge badge-green">Confirmed</span></td></tr></tbody></table></div></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection