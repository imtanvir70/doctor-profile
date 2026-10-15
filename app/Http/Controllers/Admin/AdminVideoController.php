<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;

class AdminVideoController extends Controller
{
    public function index()
    {
        $videos = Video::orderBy('display_order')->get();
        return view('admin.videos.index', compact('videos'));
    }

    protected function extractYouTubeId(string $input): string
    {
        $input = trim($input);

        // Match all standard YouTube URL patterns:
        // - https://www.youtube.com/watch?v=ScMzIvxBSi4
        // - https://m.youtube.com/watch?v=ScMzIvxBSi4&t=10s
        // - https://youtu.be/ScMzIvxBSi4?si=xyz
        // - https://www.youtube.com/shorts/ScMzIvxBSi4
        // - https://www.youtube.com/embed/ScMzIvxBSi4
        // - youtube.com/watch?v=ScMzIvxBSi4
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=|shorts/)|youtu\.be/)([^"&?/\s]{11})%i', $input, $match)) {
            return $match[1];
        }

        // If it's already an 11-char ID (alphanumeric, dashes, underscores)
        $cleaned = preg_replace('/[^a-zA-Z0-9_-]/', '', $input);
        if (strlen($cleaned) >= 11) {
            return substr($cleaned, 0, 11);
        }

        return $cleaned ?: $input;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_bn' => 'required|string|max:255',
            'youtube_id' => 'required|string|max:500',
            'category' => 'required|string',
            'duration' => 'nullable|string',
            'description_en' => 'required|string',
            'description_bn' => 'required|string',
            'display_order' => 'integer',
        ]);

        $validated['youtube_id'] = $this->extractYouTubeId($validated['youtube_id']);
        $validated['is_active'] = $request->has('is_active');
        $validated['thumbnail'] = 'https://img.youtube.com/vi/' . $validated['youtube_id'] . '/hqdefault.jpg';

        Video::create($validated);
        return back()->with('success', 'Video guide added successfully!');
    }

    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_bn' => 'required|string|max:255',
            'youtube_id' => 'required|string|max:500',
            'category' => 'required|string',
            'duration' => 'nullable|string',
            'description_en' => 'required|string',
            'description_bn' => 'required|string',
            'display_order' => 'integer',
        ]);

        $validated['youtube_id'] = $this->extractYouTubeId($validated['youtube_id']);
        $validated['is_active'] = $request->has('is_active');
        $validated['thumbnail'] = 'https://img.youtube.com/vi/' . $validated['youtube_id'] . '/hqdefault.jpg';

        $video->update($validated);
        return back()->with('success', 'Video updated successfully!');
    }

    public function destroy($id)
    {
        Video::findOrFail($id)->delete();
        return back()->with('success', 'Video removed.');
    }
}

