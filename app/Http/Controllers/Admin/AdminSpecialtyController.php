<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Specialty;

class AdminSpecialtyController extends Controller
{
    public function index()
    {
        $specialties = Specialty::orderBy('display_order')->get();
        return view('admin.specialties.index', compact('specialties'));
    }

    public function create()
    {
        return view('admin.specialties.form', ['specialty' => new Specialty()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:200',
            'title_bn' => 'required|string|max:200',
            'badge_en' => 'nullable|string|max:100',
            'badge_bn' => 'nullable|string|max:100',
            'description_en' => 'required|string',
            'description_bn' => 'required|string',
            'approach_en' => 'nullable|string',
            'approach_bn' => 'nullable|string',
            'icon_class' => 'nullable|string|max:100',
            'icon_color' => 'nullable|string|max:100',
            'tags_en_text' => 'nullable|string',
            'tags_bn_text' => 'nullable|string',
            'display_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title_en']) . '-' . rand(100, 999);
        $validated['is_active'] = $request->has('is_active');
        $validated['display_order'] = (int)($request->input('display_order') ?? 0);
        $validated['icon_class'] = $request->input('icon_class') ?: 'bi-heart-pulse-fill';
        $validated['icon_color'] = $request->input('icon_color') ?: 'clinical-icon-blue';

        if (!empty($validated['tags_en_text'])) {
            $validated['tags_en'] = array_map('trim', explode(',', $validated['tags_en_text']));
        }
        if (!empty($validated['tags_bn_text'])) {
            $validated['tags_bn'] = array_map('trim', explode(',', $validated['tags_bn_text']));
        }

        Specialty::create($validated);

        return redirect()->route('admin.specialties.index')->with('success', 'Specialty service added successfully!');
    }

    public function edit(Specialty $specialty)
    {
        return view('admin.specialties.form', compact('specialty'));
    }

    public function update(Request $request, Specialty $specialty)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:200',
            'title_bn' => 'required|string|max:200',
            'badge_en' => 'nullable|string|max:100',
            'badge_bn' => 'nullable|string|max:100',
            'description_en' => 'required|string',
            'description_bn' => 'required|string',
            'approach_en' => 'nullable|string',
            'approach_bn' => 'nullable|string',
            'icon_class' => 'nullable|string|max:100',
            'icon_color' => 'nullable|string|max:100',
            'tags_en_text' => 'nullable|string',
            'tags_bn_text' => 'nullable|string',
            'display_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['display_order'] = (int)($request->input('display_order') ?? 0);
        $validated['icon_class'] = $request->input('icon_class') ?: 'bi-heart-pulse-fill';
        $validated['icon_color'] = $request->input('icon_color') ?: 'clinical-icon-blue';

        if (isset($validated['tags_en_text'])) {
            $validated['tags_en'] = !empty($validated['tags_en_text']) ? array_map('trim', explode(',', $validated['tags_en_text'])) : [];
        }
        if (isset($validated['tags_bn_text'])) {
            $validated['tags_bn'] = !empty($validated['tags_bn_text']) ? array_map('trim', explode(',', $validated['tags_bn_text'])) : [];
        }

        $specialty->update($validated);

        return redirect()->route('admin.specialties.index')->with('success', 'Specialty service updated successfully!');
    }

    public function destroy(Specialty $specialty)
    {
        $specialty->delete();
        return redirect()->route('admin.specialties.index')->with('success', 'Specialty service deleted successfully!');
    }
}
