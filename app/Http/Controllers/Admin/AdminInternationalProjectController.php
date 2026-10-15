<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InternationalProject;

class AdminInternationalProjectController extends Controller
{
    public function index()
    {
        $projects = InternationalProject::orderBy('display_order')->latest('id')->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.form', ['project' => new InternationalProject()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_bn' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
            'country_or_location' => 'nullable|string|max:255',
            'role_en' => 'required|string|max:255',
            'role_bn' => 'required|string|max:255',
            'duration' => 'nullable|string|max:100',
            'category' => 'required|string|max:100',
            'badge_text' => 'nullable|string|max:100',
            'description_en' => 'nullable|string',
            'description_bn' => 'nullable|string',
            'project_url' => 'nullable|url|max:255',
            'icon' => 'nullable|string|max:50',
            'display_order' => 'nullable|integer',
        ]);

        $validated['icon'] = $validated['icon'] ?? 'bi-globe-americas';
        $validated['display_order'] = $validated['display_order'] ?? 0;
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        InternationalProject::create($validated);
        return redirect()->route('admin.projects.index')->with('success', 'International Project added successfully!');
    }

    public function edit($id)
    {
        $project = InternationalProject::findOrFail($id);
        return view('admin.projects.form', compact('project'));
    }

    public function update(Request $request, $id)
    {
        $project = InternationalProject::findOrFail($id);

        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_bn' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
            'country_or_location' => 'nullable|string|max:255',
            'role_en' => 'required|string|max:255',
            'role_bn' => 'required|string|max:255',
            'duration' => 'nullable|string|max:100',
            'category' => 'required|string|max:100',
            'badge_text' => 'nullable|string|max:100',
            'description_en' => 'nullable|string',
            'description_bn' => 'nullable|string',
            'project_url' => 'nullable|url|max:255',
            'icon' => 'nullable|string|max:50',
            'display_order' => 'nullable|integer',
        ]);

        $validated['icon'] = $validated['icon'] ?? 'bi-globe-americas';
        $validated['display_order'] = $validated['display_order'] ?? 0;
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        $project->update($validated);
        return redirect()->route('admin.projects.index')->with('success', 'International Project updated successfully!');
    }

    public function destroy($id)
    {
        $project = InternationalProject::findOrFail($id);
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'International Project deleted successfully!');
    }
}

