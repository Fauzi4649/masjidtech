@extends('layouts.app')

@section('title', 'Create New Event')

@section('content')
<div class="container" style="padding-top: 120px; padding-bottom: 80px;">
    <div class="section-header">
        <div class="section-label"><i class="fas fa-calendar-plus"></i> Event Management</div>
        <h2 class="section-title">Create New Event</h2>
        <p class="section-sub">Fill in the details to add a new mosque event.</p>
    </div>

    <div class="card" style="max-width: 800px; margin: 0 auto; background: white; border-radius: var(--radius); padding: 32px; box-shadow: var(--shadow-md);">
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label">Event Title *</label>
                <input type="text" name="title" class="form-input" required value="{{ old('title') }}">
                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Description *</label>
                <textarea name="description" class="form-input" rows="5" required>{{ old('description') }}</textarea>
                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Event Date *</label>
                    <input type="date" name="event_date" class="form-input" required value="{{ old('event_date') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Event Time *</label>
                    <input type="time" name="event_time" class="form-input" required value="{{ old('event_time') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Location *</label>
                <input type="text" name="location" class="form-input" required value="{{ old('location') }}">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Max Participants *</label>
                    <input type="number" name="max_participants" class="form-input" min="1" required value="{{ old('max_participants', 50) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <input type="text" name="category" class="form-input" value="{{ old('category') }}" placeholder="e.g., Education, Youth, Sisters">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Poster Image (optional)</label>
                <input type="file" name="image" class="form-input" accept="image/*">
                @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                <small class="text-muted">Max 2MB, JPG/PNG.</small>
            </div>

            <div style="display: flex; gap: 16px; margin-top: 24px;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create Event</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection