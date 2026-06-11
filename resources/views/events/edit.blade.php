@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')
<div class="container" style="padding-top: 120px; padding-bottom: 80px;">
    <div class="section-header">
        <div class="section-label"><i class="fas fa-edit"></i> Event Management</div>
        <h2 class="section-title">Edit Event: {{ $event->title }}</h2>
        <p class="section-sub">Update event details.</p>
    </div>

    <div class="card" style="max-width: 800px; margin: 0 auto; background: white; border-radius: var(--radius); padding: 32px; box-shadow: var(--shadow-md);">
        <!-- UPDATE FORM -->
        <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- all input fields stay the same -->
            <div class="form-group">
                <label class="form-label">Event Title *</label>
                <input type="text" name="title" class="form-input" required value="{{ old('title', $event->title) }}">
            </div>

            <div class="form-group">
                <label class="form-label">Description *</label>
                <textarea name="description" class="form-input" rows="5" required>{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Event Date *</label>
                    <input type="date" name="event_date" class="form-input" required value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Event Time *</label>
                    <input type="time" name="event_time" class="form-input" required value="{{ old('event_time', \Carbon\Carbon::parse($event->event_time)->format('H:i')) }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Location *</label>
                <input type="text" name="location" class="form-input" required value="{{ old('location', $event->location) }}">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Max Participants *</label>
                    <input type="number" name="max_participants" class="form-input" min="1" required value="{{ old('max_participants', $event->max_participants) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <input type="text" name="category" class="form-input" value="{{ old('category', $event->category) }}">
                </div>
            </div>

            @if($event->media->first())
            <div class="form-group">
                <label>Current Image:</label><br>
                <img src="{{ asset('storage/' . $event->media->first()->file_path) }}" style="max-width: 200px; border-radius: 8px;">
            </div>
            @endif

            <div class="form-group">
                <label class="form-label">Replace Image (optional)</label>
                <input type="file" name="image" class="form-input" accept="image/*">
            </div>

            <!-- Buttons inside the update form (Update & Cancel) -->
            <div style="display: flex; gap: 16px; margin-top: 24px;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Event</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>

        <!-- DELETE FORM (outside the update form) -->
        <div style="display: flex; justify-content: flex-start; margin-top: 16px;">
            <form action="{{ route('admin.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Delete this event?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline" style="border-color: #dc2626; color: #dc2626;"><i class="fas fa-trash"></i> Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection