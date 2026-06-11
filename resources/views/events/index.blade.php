@extends('layouts.app')

@section('title', 'Upcoming Events')

@section('content')
<section class="events-section" style="padding-top: 120px;">
    <div class="container">
        @if(session('success'))
            <div style="background: #dcfce7; color: #166534; padding: 12px 20px; border-radius: 8px; margin-bottom: 24px;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: #fee2e2; color: #991b1b; padding: 12px 20px; border-radius: 8px; margin-bottom: 24px;">
                {{ session('error') }}
            </div>
        @endif
        <div class="events-header">
            <div>
                <div class="section-label"><i class="fas fa-calendar-alt"></i> Our Programs</div>
                <h2 class="section-title">All Events</h2>
                <p class="section-sub">Browse and register for upcoming mosque events, classes, and community gatherings.</p>
            </div>
        </div>

        <div class="events-grid">
            @forelse($events as $event)
            <div class="event-card">
                <div class="event-img" style="background:linear-gradient(135deg, #166534, #0d3320)">
                    <div class="event-img-pattern"></div>
                    <i class="fas fa-calendar-alt event-img-icon"></i>
                    <div class="event-date-chip">
                        {{ $event->event_date->format('d') }}<br>{{ $event->event_date->format('M') }}
                    </div>
                </div>
                <div class="event-body">
                    <div class="event-category">
                        <span class="badge badge-green">{{ $event->category ?? 'General' }}</span>
                    </div>
                    <h3 class="event-title">{{ $event->title }}</h3>
                    <div class="event-meta">
                        <div class="event-meta-row"><i class="fas fa-calendar"></i> {{ $event->event_date->format('l, j F Y') }}</div>
                        <div class="event-meta-row"><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}</div>
                        <div class="event-meta-row"><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</div>
                    </div>
                    <div class="event-footer">
                        <div class="event-spots">
                            <strong>{{ $event->remaining_spots }}</strong> spots left of {{ $event->max_participants }}
                        </div>
                        @auth
                            @if($event->remaining_spots > 0 && !auth()->user()->registrations->contains('event_id', $event->id))
                                <form method="POST" action="{{ route('events.register', $event) }}" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="attendees_count" value="1">
                                    <button type="submit" class="btn btn-primary" style="padding:8px 18px; font-size:0.8rem">
                                        <i class="fas fa-ticket-alt"></i> Register
                                    </button>
                                </form>
                            @elseif(auth()->user()->registrations->contains('event_id', $event->id))
                                <span class="badge badge-green">Registered</span>
                            @else
                                <span class="badge badge-gray">Full</span>
                            @endif
                        @else
                            <button class="btn btn-outline" onclick="openModal('loginModal')">
                                Login to Register
                            </button>
                        @endauth
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center" style="grid-column: 1/-1; padding: 60px;">
                <i class="fas fa-calendar-times" style="font-size: 48px; color: var(--gray-400);"></i>
                <p style="margin-top: 16px;">No upcoming events at the moment. Please check back later.</p>
            </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center" style="margin-top: 40px;">
            {{ $events->links() }}
        </div>
    </div>
</section>
@endsection