@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container" style="padding-top: 120px; padding-bottom: 80px;">

    <div class="section-header">
        <div class="section-label"><i class="fas fa-user-edit"></i> Profile Settings</div>
        <h2 class="section-title">Edit Your Profile</h2>
        <p class="section-sub">Update your personal information.</p>
    </div>

    <div class="card" style="max-width: 600px; margin: 0 auto; background: white; border-radius: var(--radius); padding: 32px; box-shadow: var(--shadow-md);">
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="form-group">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-input" value="{{ old('name', auth()->user()->name) }}" required>
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" value="{{ old('email', auth()->user()->email) }}" required>
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-input" value="{{ old('phone', auth()->user()->phone) }}">
                @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">New Password (leave blank to keep current)</label>
                <input type="password" name="password" class="form-input" autocomplete="new-password">
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-input" autocomplete="new-password">
            </div>

            <div style="display: flex; gap: 16px;">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('dashboard') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection