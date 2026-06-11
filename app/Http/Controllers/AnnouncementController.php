<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\MediaUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10);
        return view('announcements.index', compact('announcements'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('announcements.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:2048'
        ]);

        $announcement = Announcement::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'admin_id' => auth()->id()
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('announcements', 'public');
            MediaUpload::create([
                'file_name' => $request->file('image')->getClientOriginalName(),
                'file_type' => 'image',
                'file_path' => $path,
                'admin_id' => auth()->id(),
                'announcement_id' => $announcement->id
            ]);
        }

        return redirect()->to('/admin/announcements')->with('success', 'Announcement posted successfully.');
    }

    public function edit(Announcement $announcement)
    {
        $this->authorizeAdmin();
        return view('announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:2048'
        ]);

        $announcement->update($validated);

        if ($request->hasFile('image')) {
            $oldMedia = MediaUpload::where('announcement_id', $announcement->id)->first();
            if ($oldMedia) {
                Storage::disk('public')->delete($oldMedia->file_path);
                $oldMedia->delete();
            }

            $path = $request->file('image')->store('announcements', 'public');
            MediaUpload::create([
                'file_name' => $request->file('image')->getClientOriginalName(),
                'file_type' => 'image',
                'file_path' => $path,
                'admin_id' => auth()->id(),
                'announcement_id' => $announcement->id
            ]);
        }

        return redirect()->to('/admin/announcements')->with('success', 'Announcement updated successfully.');
    }

    public function destroy(Announcement $announcement)
    {
        $this->authorizeAdmin();

        foreach ($announcement->media as $media) {
            Storage::disk('public')->delete($media->file_path);
            $media->delete();
        }

        $announcement->delete();

        return redirect()->to('/admin/announcements')->with('success', 'Announcement deleted successfully.');
    }

    private function authorizeAdmin()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function adminIndex()
    {
        $announcements = Announcement::latest()->paginate(10);
        return view('announcements.admin-index', compact('announcements'));
    }
}