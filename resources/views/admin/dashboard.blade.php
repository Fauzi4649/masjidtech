@extends('layouts.app')

@section('title', 'Admin Dashboard - MasjidTech')

@section('content')
<section class="admin-section" style="padding-top: 120px;">
    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 15px 20px; border-radius: 8px; margin-bottom: 24px; max-width: 1200px; margin-left: auto; margin-right: auto; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-check-circle" style="font-size: 20px;"></i>
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.style.display='none'" style="margin-left: auto; background: none; border: none; cursor: pointer;">&times;</button>
        </div>
    @endif
    <div class="container">
        <div class="section-header reveal" style="text-align:center; max-width:560px; margin:0 auto 48px">
            <div class="section-label"><i class="fas fa-tachometer-alt"></i> Admin Control Center</div>
            <h2 class="section-title">Welcome back, {{ auth()->user()->name }}</h2>
            <p class="section-sub">Manage mosque operations, events, announcements, and track community engagement.</p>
        </div>

        <!-- KPIs -->
        <div class="admin-kpis" style="display: grid; grid-template-columns: repeat(4,1fr); gap: 20px; margin-bottom: 40px;">
            <div class="kpi-card">
                <div class="kpi-label">Total Members</div>
                <div class="kpi-value">{{ $totalMembers }}</div>
                <div class="kpi-delta"><i class="fas fa-users"></i> Registered users</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-label">Total Events</div>
                <div class="kpi-value">{{ $totalEvents }}</div>
                <div class="kpi-delta"><i class="fas fa-calendar-alt"></i> All time</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-label">Registrations</div>
                <div class="kpi-value">{{ $totalRegistrations }}</div>
                <div class="kpi-delta"><i class="fas fa-check-circle"></i> Confirmed</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-label">Donations (RM)</div>
                <div class="kpi-value">RM {{ number_format($totalDonations, 2) }}</div>
                <div class="kpi-delta"><i class="fas fa-hand-holding-usd"></i> Completed</div>
            </div>
        </div>

        <div class="admin-charts" style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 40px;">
            <!-- Attendance Chart -->
            <div class="chart-card">
                <div class="chart-title">Weekly Attendance</div>
                <canvas id="attendanceChart" height="200"></canvas>
            </div>

            <!-- Recent Registrations Table -->
            <div class="chart-card">
                <div class="chart-title">Recent Event Registrations</div>
                <table class="recent-table" style="width:100%;">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Event</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentRegistrations as $reg)
                        <tr>
                            <td>{{ $reg->user->name }}</td>
                            <td>{{ $reg->event->title }}</td>
                            <td><span class="badge badge-green">{{ ucfirst($reg->status) }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="3">No recent registrations.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="chart-card" style="margin-bottom: 24px;">
            <div class="chart-title">Upcoming Events</div>
            <table class="recent-table" style="width:100%;">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Spots Left</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($upcomingEvents as $event)
                    <tr>
                        <td>{{ $event->title }}</td>
                        <td>{{ $event->event_date->format('d M Y') }}</td>
                        <td>{{ $event->location }}</td>
                        <td>{{ $event->remaining_spots }}/{{ $event->max_participants }}</td>
                        <td>
                            <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-outline">Edit</a>
                        </td>
                    </tr>
                    @empty
                        <tr><td colspan="5">No upcoming events.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div style="margin-top: 16px; display: flex; gap: 12px;">
                <a href="{{ route('admin.events.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Create New Event</a>
                <a href="{{ url('/admin/announcements') }}" class="btn btn-outline"><i class="fas fa-bullhorn"></i> Manage Announcements</a>
            </div>
        </div>

        <!-- Recent Donations -->
        <div class="chart-card">
            <div class="chart-title">Recent Donations</div>
            <table class="recent-table" style="width:100%;">
                <thead>
                    <tr>
                        <th>Donor</th>
                        <th>Amount (RM)</th>
                        <th>Date</th>
                        <th>Method</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentDonations as $donation)
                    <tr>
                        <td>{{ $donation->user->name }}</td>
                        <td>{{ number_format($donation->amount, 2) }}</td>
                        <td>{{ $donation->donation_date->format('d M Y') }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $donation->payment_method)) }}</td>
                    </tr>
                    @empty
                        <tr><td colspan="4">No donations recorded.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Attendance',
                data: @json($chartData),
                backgroundColor: '#166534',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: { beginAtZero: true, grid: { color: '#e2e8f0' } }
            }
        }
    });
</script>
@endpush