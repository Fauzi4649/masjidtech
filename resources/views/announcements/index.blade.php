@extends('layouts.app')

@section('title', 'Announcements')

@section('content')
<section class="announcements-section" style="padding-top: 120px;">
    <div class="container">
        <div class="section-header reveal">
            <div class="section-label"><i class="fas fa-bullhorn"></i> News & Updates</div>
            <h2 class="section-title">All Announcements</h2>
            <p class="section-sub">Stay updated with the latest mosque news.</p>
        </div>

        <div class="announce-grid" style="grid-template-columns: 1fr;">
            <div class="announce-feed">
                @forelse($announcements as $announcement)
                <div class="announce-card">
                    <div class="announce-top">
                        <div>
                            <span class="badge badge-green">Update</span>
                            <div class="announce-title">{{ $announcement->title }}</div>
                        </div>
                        <div class="announce-date"><i class="fas fa-calendar"></i> {{ $announcement->created_at->format('j M Y') }}</div>
                    </div>
                    <div class="announce-text">{{ $announcement->content }}</div>
                </div>
                @empty
                <p>No announcements yet.</p>
                @endforelse
            </div>
            <div class="d-flex justify-content-center" style="margin-top: 32px;">
                {{ $announcements->links() }}
            </div>
        </div>
    </div>
</section>
@endsection