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

        // 1. Check standard URL query parameter ?v=VIDEO_ID (e.g. watch?v=nFgsBxw-zWQ&list=...)
        $parsed = parse_url($input);
        if (isset($parsed['query'])) {
            parse_str($parsed['query'], $query);
            if (!empty($query['v']) && is_string($query['v'])) {
                $v = preg_replace('/[^a-zA-Z0-9_-]/', '', $query['v']);
                if (strlen($v) >= 11) {
                    return substr($v, 0, 11);
                }
            }
        }

        // 2. Check youtu.be/VIDEO_ID (e.g. https://youtu.be/nFgsBxw-zWQ)
        if (isset($parsed['host']) && str_contains($parsed['host'], 'youtu.be')) {
            $path = trim($parsed['path'] ?? '', '/');
            $segments = explode('/', $path);
            if (!empty($segments[0])) {
                $v = preg_replace('/[^a-zA-Z0-9_-]/', '', $segments[0]);
                if (strlen($v) >= 11) {
                    return substr($v, 0, 11);
                }
            }
        }

        // 3. Check /shorts/VIDEO_ID or /embed/VIDEO_ID
        if (isset($parsed['path']) && preg_match('#/(?:shorts|embed|v)/([a-zA-Z0-9_-]{11})#i', $parsed['path'], $match)) {
            return $match[1];
        }

        // 4. Regex fallback
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=|shorts/)|youtu\.be/)([^"&?/\s]{11})%i', $input, $match)) {
            return $match[1];
        }

        // 5. If user still just typed the 11-char ID
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

