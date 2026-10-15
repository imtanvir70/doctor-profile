<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SeoSetting;

class AdminSeoController extends Controller
{
    public function index()
    {
        $settings = SeoSetting::orderBy('id')->get();
        return view('admin.seo.index', compact('settings'));
    }

    public function edit($id)
    {
        $setting = SeoSetting::findOrFail($id);
        return view('admin.seo.edit', compact('setting'));
    }

    public function update(Request $request, $id)
    {
        $setting = SeoSetting::findOrFail($id);

        $validated = $request->validate([
            'meta_title_en' => 'required|string|max:100',
            'meta_title_bn' => 'required|string|max:100',
            'meta_description_en' => 'required|string|max:300',
            'meta_description_bn' => 'required|string|max:300',
            'keywords_en' => 'nullable|string',
            'keywords_bn' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'robots' => 'required|string|max:50',
            'schema_type' => 'required|string|max:50',
            'og_image_file' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('og_image_file')) {
            $path = $request->file('og_image_file')->store('seo', 'public');
            $validated['og_image'] = asset('storage/' . $path);
        }

        $setting->update($validated);

        return redirect()->route('admin.seo.index')->with('success', "SEO Settings for '{$setting->page_key}' updated successfully!");
    }
}

