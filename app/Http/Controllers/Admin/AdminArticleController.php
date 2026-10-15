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
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_bn' => 'required|string|max:255',
            'category' => 'required|string',
            'badge_en' => 'nullable|string',
            'badge_bn' => 'nullable|string',
            'excerpt_en' => 'required|string',
            'excerpt_bn' => 'required|string',
            'content_en' => 'required|string',
            'content_bn' => 'required|string',
            'read_time' => 'nullable|string',
            'featured_image_file' => 'nullable|image|max:4096',
        ]);

        $validated['slug'] = Str::slug($validated['title_en']) . '-' . rand(100, 999);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_published'] = $request->has('is_published');

        if ($request->hasFile('featured_image_file')) {
            $path = $request->file('featured_image_file')->store('articles', 'public');
            $validated['featured_image'] = asset('storage/' . $path);
        }

        Article::create($validated);
        return redirect()->route('admin.articles.index')->with('success', 'Article created successfully!');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('admin.articles.form', compact('article'));
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_bn' => 'required|string|max:255',
            'category' => 'required|string',
            'badge_en' => 'nullable|string',
            'badge_bn' => 'nullable|string',
            'excerpt_en' => 'required|string',
            'excerpt_bn' => 'required|string',
            'content_en' => 'required|string',
            'content_bn' => 'required|string',
            'read_time' => 'nullable|string',
            'featured_image_file' => 'nullable|image|max:4096',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_published'] = $request->has('is_published');

        if ($request->hasFile('featured_image_file')) {
            $path = $request->file('featured_image_file')->store('articles', 'public');
            $validated['featured_image'] = asset('storage/' . $path);
        }

        $article->update($validated);
        return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully!');
    }

    public function destroy($id)
    {
        Article::findOrFail($id)->delete();
        return back()->with('success', 'Article deleted.');
    }
}

