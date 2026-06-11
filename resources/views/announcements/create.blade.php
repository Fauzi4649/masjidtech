@extends('layouts.app')

@section('title', 'Create Announcement')

@section('content')
<div class="container" style="padding-top: 120px; padding-bottom: 80px;">
    <div class="section-header">
        <div class="section-label"><i class="fas fa-plus-circle"></i> Announcements</div>
        <h2 class="section-title">Post New Announcement</h2>
    </div>
    <div class="card" style="max-width: 700px; margin: 0 auto; background: white; border-radius: var(--radius); padding: 32px;">
        <form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Content *</label>
                <textarea name="content" class="form-input" rows="6" required></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Image (optional)</label>
                <input type="file" name="image" class="form-input" accept="image/*">
            </div>
            <div style="display: flex; gap: 16px;">
                <button type="submit" class="btn btn-primary">Publish</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection