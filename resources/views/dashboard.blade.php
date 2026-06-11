@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
<div class="container" style="padding-top: 120px; padding-bottom: 80px;">
    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif
    <div class="section-header">
        <div class="section-label"><i class="fas fa-user"></i> Member Area</div>
        <h2 class="section-title">Welcome back, {{ Auth::user()->name }}</h2>
        <p class="section-sub">Manage your event registrations and profile.</p>
    </div>

    <div class="row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
        <!-- Profile Card -->
        <div class="card" style="background: white; border-radius: var(--radius); padding: 24px; box-shadow: var(--shadow-md);">
            <h3 style="color: var(--green-900); margin-bottom: 16px;"><i class="fas fa-id-card"></i> Your Profile</h3>
            <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
            <p><strong>Phone:</strong> {{ Auth::user()->phone ?? 'Not provided' }}</p>
            <p><strong>Member since:</strong> {{ Auth::user()->created_at->format('d M Y') }}</p>
            <a href="{{ route('profile.edit') }}" class="btn btn-outline" style="margin-top: 16px;">Edit Profile</a>
        </div>

        <!-- Upcoming Events Card -->
        <div class="card" style="background: white; border-radius: var(--radius); padding: 24px; box-shadow: var(--shadow-md);">
            <h3 style="color: var(--green-900); margin-bottom: 16px;"><i class="fas fa-calendar-check"></i> Upcoming Events</h3>
            @if($upcomingRegistrations->count())
                <ul style="list-style: none; padding: 0;">
                    @foreach($upcomingRegistrations as $reg)
                    <li style="padding: 12px 0; border-bottom: 1px solid var(--gray-200);">
                        <strong>{{ $reg->event->title }}</strong><br>
                        <small>{{ $reg->event->event_date->format('l, j F Y') }} at {{ \Carbon\Carbon::parse($reg->event->event_time)->format('g:i A') }}</small><br>
                        <span class="badge badge-green">Registered ({{ $reg->attendees_count }} person)</span>
                    </li>
                    @endforeach
                </ul>
            @else
                <p>You haven't registered for any upcoming events.</p>
                <a href="{{ route('events.index') }}" class="btn btn-primary">Browse Events</a>
            @endif
        </div>
    </div>

    <!-- Donation Section -->
        <div class="card" style="background: white; border-radius: var(--radius); padding: 24px; margin-top: 30px; box-shadow: var(--shadow-md);">
            <h3 style="color: var(--green-900); margin-bottom: 16px;"><i class="fas fa-hand-holding-heart"></i> Make a Donation</h3>
            <form method="POST" action="{{ route('donate.store') }}">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Amount (RM)</label>
                        <input type="number" name="amount" class="form-input" step="0.01" min="1" required placeholder="e.g., 50.00">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method" class="form-input" required>
                            <option value="online_transfer">Online Transfer</option>
                            <option value="cash">Cash (at mosque)</option>
                            <option value="card">Credit/Debit Card</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-donate"></i> Donate Now</button>
            </form>
            @if(session('success'))
                <div style="background: #dcfce7; color: #166534; padding: 10px; border-radius: 8px; margin-top: 16px;">
                    {{ session('success') }}
                </div>
            @endif
        </div>

    <!-- Past Events (optional) -->
    @if($pastRegistrations->count())
    <div class="card" style="background: white; border-radius: var(--radius); padding: 24px; margin-top: 30px; box-shadow: var(--shadow-md);">
        <h3 style="color: var(--gray-600); margin-bottom: 16px;"><i class="fas fa-history"></i> Past Events</h3>
        <ul style="list-style: none; padding: 0;">
            @foreach($pastRegistrations as $reg)
            <li style="padding: 10px 0; border-bottom: 1px solid var(--gray-200);">
                {{ $reg->event->title }} – {{ $reg->event->event_date->format('d M Y') }}
                <span class="badge badge-gray">Completed</span>
            </li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
@endsection