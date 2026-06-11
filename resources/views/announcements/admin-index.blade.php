@extends('layouts.app')

@section('title', 'Manage Announcements')

@section('content')
<div class="container" style="padding-top: 120px; padding-bottom: 80px;">
    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 12px 20px; border-radius: 8px; margin-bottom: 24px;">
            {{ session('success') }}
        </div>
    @endif
    <div class="section-header">
        <div class="section-label"><i class="fas fa-bullhorn"></i> Announcements Management</div>
        <h2 class="section-title">All Announcements</h2>
        <p class="section-sub">Create, edit, or remove mosque announcements.</p>
    </div>

    <div style="margin-bottom: 24px;">
        <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Post New Announcement</a>
    </div>

    <div class="card" style="background: white; border-radius: var(--radius); overflow: hidden;">
        <table class="recent-table" style="width:100%;">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($announcements as $announcement)
                <tr>
                    <td>{{ $announcement->title }}</td>
                    <td>{{ Str::limit($announcement->content, 60) }}</td>
                    <td>{{ $announcement->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.announcements.edit', $announcement) }}" class="btn btn-sm btn-outline">Edit</a>
                        <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this announcement?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline" style="border-color:#dc2626;color:#dc2626;">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top: 20px;">
        {{ $announcements->links() }}
    </div>
</div>
@endsection