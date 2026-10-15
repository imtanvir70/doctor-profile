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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_bn' => 'required|string|max:255',
            'youtube_id' => 'required|string|max:50',
            'category' => 'required|string',
            'duration' => 'nullable|string',
            'description_en' => 'required|string',
            'description_bn' => 'required|string',
            'display_order' => 'integer',
        ]);

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
            'youtube_id' => 'required|string|max:50',
            'category' => 'required|string',
            'duration' => 'nullable|string',
            'description_en' => 'required|string',
            'description_bn' => 'required|string',
            'display_order' => 'integer',
        ]);

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

