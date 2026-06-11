<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\MediaUpload;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('registrations')->latest()->paginate(9);
        return view('events.index', compact('events'));
    }
    public function create()
    {
        $this->authorizeAdmin();
        return view('events.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'location' => 'required',
            'max_participants' => 'required|integer|min:1',
            'category' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $event = Event::create([
            ...$validated,
            'admin_id' => auth()->id()
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('events', 'public');
            MediaUpload::create([
                'file_name' => $request->file('image')->getClientOriginalName(),
                'file_type' => 'image',
                'file_path' => $path,
                'admin_id' => auth()->id(),
                'event_id' => $event->id
            ]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Event created successfully.');
    }

    /**
     * Show form to edit an event (admin only)
     */
    public function edit(Event $event)
    {
        $this->authorizeAdmin();
        return view('events.edit', compact('event'));
    }

    /**
     * Update an existing event (admin only)
     */
    public function update(Request $request, Event $event)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'location' => 'required',
            'max_participants' => 'required|integer|min:1',
            'category' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $event->update($validated);

        if ($request->hasFile('image')) {
            // Delete old media if exists
            $oldMedia = MediaUpload::where('event_id', $event->id)->first();
            if ($oldMedia) {
                Storage::disk('public')->delete($oldMedia->file_path);
                $oldMedia->delete();
            }

            $path = $request->file('image')->store('events', 'public');
            MediaUpload::create([
                'file_name' => $request->file('image')->getClientOriginalName(),
                'file_type' => 'image',
                'file_path' => $path,
                'admin_id' => auth()->id(),
                'event_id' => $event->id
            ]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Event updated successfully.');
    }

    /**
     * Delete an event (admin only)
     */
    public function destroy(Event $event)
    {
        $this->authorizeAdmin();

        // Delete associated media
        foreach ($event->media as $media) {
            Storage::disk('public')->delete($media->file_path);
            $media->delete();
        }

        $event->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Event deleted successfully.');
    }

    /**
     * Register authenticated user for an event
     */
    public function register(Request $request, Event $event)
    {
        $request->validate([
            'attendees_count' => 'required|integer|min:1|max:' . $event->remaining_spots
        ]);

        // Check if already registered
        $existing = EventRegistration::where('user_id', auth()->id())
            ->where('event_id', $event->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'You are already registered for this event.');
        }

        EventRegistration::create([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
            'attendees_count' => $request->attendees_count,
            'status' => 'confirmed'
        ]);

        return back()->with('success', '✅ Registration successful! You have been registered for ' . $event->title);
    }

    private function authorizeAdmin()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
    }
}