<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Str;

class AdminArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->get();
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.form', ['article' => new Article()]);
    }

    public function store(Request $request)
    {
        $title = trim($request->input('title') ?: ($request->input('title_bn') ?: $request->input('title_en', '')));
        $content = trim($request->input('content') ?: ($request->input('content_bn') ?: $request->input('content_en', '')));

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'title_bn' => 'nullable|string|max:255',
            'category' => 'required|string',
            'badge_en' => 'nullable|string',
            'badge_bn' => 'nullable|string',
            'excerpt' => 'nullable|string',
            'excerpt_en' => 'nullable|string',
            'excerpt_bn' => 'nullable|string',
            'content' => 'nullable|string',
            'content_en' => 'nullable|string',
            'content_bn' => 'nullable|string',
            'read_time' => 'nullable|string',
            'featured_image_file' => 'nullable|image|max:4096',
        ]);

        if (empty($title)) {
            return back()->withInput()->withErrors(['title' => 'Blog post title is required.']);
        }

        $titleBn = $request->input('title_bn') ?: $title;
        $titleEn = $request->input('title_en') ?: $title;
        $contentBn = $request->input('content_bn') ?: $content;
        $contentEn = $request->input('content_en') ?: $content;

        $plainText = strip_tags($content);
        $autoExcerpt = Str::limit($plainText, 180);
        $excerpt = trim($request->input('excerpt') ?: ($request->input('excerpt_bn') ?: ($request->input('excerpt_en') ?: $autoExcerpt)));
        $excerptBn = $request->input('excerpt_bn') ?: $excerpt;
        $excerptEn = $request->input('excerpt_en') ?: $excerpt;

        // Publish action check: Only publish when user explicitly clicks Publish button
        $isPublished = false;
        if ($request->input('submit_action') === 'publish') {
            $isPublished = true;
        } elseif ($request->input('submit_action') === 'draft') {
            $isPublished = false;
        } elseif ($request->has('is_published')) {
            $isPublished = (bool) $request->input('is_published');
        }

        $slugBase = Str::slug($titleEn) ?: (Str::slug($titleBn) ?: 'blog-' . time());
        $slug = $slugBase . '-' . rand(100, 999);

        $data = [
            'title_bn' => $titleBn,
            'title_en' => $titleEn,
            'slug' => $slug,
            'category' => $validated['category'],
            'badge_en' => $validated['badge_en'] ?? 'Health Column',
            'badge_bn' => $validated['badge_bn'] ?? 'স্বাস্থ্য কলাম',
            'excerpt_bn' => $excerptBn,
            'excerpt_en' => $excerptEn,
            'content_bn' => $contentBn,
            'content_en' => $contentEn,
            'read_time' => $validated['read_time'] ?? '5 min read',
            'is_featured' => $request->has('is_featured'),
            'is_published' => $isPublished,
            'published_at' => $isPublished ? now() : null,
        ];

        if ($request->hasFile('featured_image_file')) {
            $path = $request->file('featured_image_file')->store('articles', 'public');
            $data['featured_image'] = asset('storage/' . $path);
        }

        $article = Article::create($data);
        $msg = $isPublished ? 'Blog post published successfully!' : 'Blog post draft saved successfully!';
        return redirect()->route('admin.articles.index')->with('success', $msg);
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('admin.articles.form', compact('article'));
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        
        $title = trim($request->input('title') ?: ($request->input('title_bn') ?: $request->input('title_en', '')));
        $content = trim($request->input('content') ?: ($request->input('content_bn') ?: $request->input('content_en', '')));

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'title_bn' => 'nullable|string|max:255',
            'category' => 'required|string',
            'badge_en' => 'nullable|string',
            'badge_bn' => 'nullable|string',
            'excerpt' => 'nullable|string',
            'excerpt_en' => 'nullable|string',
            'excerpt_bn' => 'nullable|string',
            'content' => 'nullable|string',
            'content_en' => 'nullable|string',
            'content_bn' => 'nullable|string',
            'read_time' => 'nullable|string',
            'featured_image_file' => 'nullable|image|max:4096',
        ]);

        if (empty($title)) {
            $title = $article->title_en ?: $article->title_bn;
        }

        $titleBn = $request->input('title_bn') ?: $title;
        $titleEn = $request->input('title_en') ?: $title;
        $contentBn = $request->input('content_bn') ?: $content;
        $contentEn = $request->input('content_en') ?: $content;

        $plainText = strip_tags($content);
        $autoExcerpt = Str::limit($plainText, 180);
        $excerpt = trim($request->input('excerpt') ?: ($request->input('excerpt_bn') ?: ($request->input('excerpt_en') ?: $autoExcerpt)));
        $excerptBn = $request->input('excerpt_bn') ?: ($excerpt ?: $article->excerpt_bn);
        $excerptEn = $request->input('excerpt_en') ?: ($excerpt ?: $article->excerpt_en);

        // Publish action check: Only publish when user explicitly clicks Publish button
        $isPublished = $article->is_published;
        if ($request->has('submit_action')) {
            $isPublished = ($request->input('submit_action') === 'publish');
        } elseif ($request->has('is_published')) {
            $isPublished = (bool) $request->input('is_published');
        }

        $data = [
            'title_bn' => $titleBn,
            'title_en' => $titleEn,
            'category' => $validated['category'],
            'badge_en' => $validated['badge_en'] ?? $article->badge_en,
            'badge_bn' => $validated['badge_bn'] ?? $article->badge_bn,
            'excerpt_bn' => $excerptBn,
            'excerpt_en' => $excerptEn,
            'content_bn' => $contentBn,
            'content_en' => $contentEn,
            'read_time' => $validated['read_time'] ?? $article->read_time,
            'is_featured' => $request->has('is_featured'),
            'is_published' => $isPublished,
        ];

        if ($isPublished && !$article->published_at) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('featured_image_file')) {
            $path = $request->file('featured_image_file')->store('articles', 'public');
            $data['featured_image'] = asset('storage/' . $path);
        }

        $article->update($data);
        $msg = $isPublished ? 'Blog post published successfully!' : 'Blog post draft updated successfully!';
        return redirect()->route('admin.articles.index')->with('success', $msg);
    }

    public function autosave(Request $request)
    {
        $id = $request->input('id');
        $title = trim($request->input('title') ?: ($request->input('title_bn') ?: $request->input('title_en', '')));
        $content = trim($request->input('content') ?: ($request->input('content_bn') ?: $request->input('content_en', '')));

        // If both title and content are blank, skip autosave
        $cleanContent = trim(strip_tags($content));
        if (empty($title) && empty($cleanContent)) {
            return response()->json([
                'success' => false,
                'skipped' => true,
                'message' => 'Post is currently empty. Autosave skipped.',
            ]);
        }

        $titleBn = $request->input('title_bn') ?: $title;
        $titleEn = $request->input('title_en') ?: $title;
        $contentBn = $request->input('content_bn') ?: $content;
        $contentEn = $request->input('content_en') ?: $content;

        $autoExcerpt = Str::limit($cleanContent, 180);
        $excerpt = trim($request->input('excerpt') ?: ($request->input('excerpt_bn') ?: ($request->input('excerpt_en') ?: $autoExcerpt)));
        $excerptBn = $request->input('excerpt_bn') ?: $excerpt;
        $excerptEn = $request->input('excerpt_en') ?: $excerpt;

        $category = $request->input('category', 'Preventive Health');
        $readTime = $request->input('read_time', '5 min read');

        if ($id && $article = Article::find($id)) {
            $article->update([
                'title_bn' => $titleBn ?: $article->title_bn,
                'title_en' => $titleEn ?: $article->title_en,
                'content_bn' => $contentBn,
                'content_en' => $contentEn,
                'excerpt_bn' => $excerptBn,
                'excerpt_en' => $excerptEn,
                'category' => $category,
                'read_time' => $readTime,
                // Crucial requirement: autosave will NOT publish.
                // If it was already published previously, keep it published. If it was draft, keep it draft.
                'is_published' => (bool) $article->is_published,
            ]);
        } else {
            $slugBase = Str::slug($titleEn) ?: (Str::slug($titleBn) ?: 'blog-' . time());
            $slug = $slugBase . '-' . rand(100, 999);

            $article = Article::create([
                'title_bn' => $titleBn ?: 'Untitled Draft',
                'title_en' => $titleEn ?: 'Untitled Draft',
                'slug' => $slug,
                'category' => $category,
                'badge_en' => 'Health Column',
                'badge_bn' => 'স্বাস্থ্য কলাম',
                'excerpt_bn' => $excerptBn,
                'excerpt_en' => $excerptEn,
                'content_bn' => $contentBn,
                'content_en' => $contentEn,
                'read_time' => $readTime,
                'is_featured' => false,
                'is_published' => false, // Always draft on autosave!
            ]);
        }

        return response()->json([
            'success' => true,
            'id' => $article->id,
            'saved_at' => now()->format('h:i:s A'),
            'message' => 'Draft auto-saved successfully at ' . now()->format('h:i:s A'),
        ]);
    }

    public function destroy($id)
    {
        Article::findOrFail($id)->delete();
        return back()->with('success', 'Blog post deleted successfully.');
    }
}
