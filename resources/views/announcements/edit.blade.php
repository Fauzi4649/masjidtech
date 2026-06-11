@extends('layouts.app')

@section('title', 'Edit Announcement')

@section('content')
<div class="container" style="padding-top: 120px; padding-bottom: 80px;">
    <div class="section-header">
        <div class="section-label"><i class="fas fa-edit"></i> Announcements</div>
        <h2 class="section-title">Edit Announcement</h2>
    </div>
    <div class="card" style="max-width: 700px; margin: 0 auto; background: white; border-radius: var(--radius); padding: 32px;">
        <!-- UPDATE FORM -->
        <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-input" required value="{{ old('title', $announcement->title) }}">
            </div>

            <div class="form-group">
                <label class="form-label">Content *</label>
                <textarea name="content" class="form-input" rows="6" required>{{ old('content', $announcement->content) }}</textarea>
            </div>

            @if($announcement->media->first())
            <div class="form-group">
                <label>Current Image:</label><br>
                <img src="{{ asset('storage/' . $announcement->media->first()->file_path) }}" style="max-width: 200px;">
            </div>
            @endif

            <div class="form-group">
                <label class="form-label">Replace Image (optional)</label>
                <input type="file" name="image" class="form-input" accept="image/*">
            </div>

            <div style="display: flex; gap: 16px;">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>

        <!-- DELETE FORM (separate, outside the main form) -->
        <div style="margin-top: 16px;">
            <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" onsubmit="return confirm('Delete this announcement?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline" style="border-color:#dc2626;color:#dc2626;">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection