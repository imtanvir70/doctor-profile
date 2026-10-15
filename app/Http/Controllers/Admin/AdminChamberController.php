<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chamber;
use Illuminate\Support\Str;

class AdminChamberController extends Controller
{
    public function index()
    {
        $chambers = Chamber::orderBy('display_order')->get();
        return view('admin.chambers.index', compact('chambers'));
    }

    public function create()
    {
        return view('admin.chambers.form', ['chamber' => new Chamber()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:200',
            'name_bn' => 'required|string|max:200',
            'badge_en' => 'nullable|string|max:100',
            'badge_bn' => 'nullable|string|max:100',
            'address_en' => 'required|string',
            'address_bn' => 'required|string',
            'visiting_days_en' => 'required|string',
            'visiting_days_bn' => 'required|string',
            'visiting_hours_en' => 'required|string',
            'visiting_hours_bn' => 'required|string',
            'weekly_off_en' => 'nullable|string',
            'weekly_off_bn' => 'nullable|string',
            'phone1' => 'required|string|max:50',
            'phone2' => 'nullable|string|max:50',
            'fee' => 'required|string|max:50',
            'map_url' => 'nullable|string',
            'facilities_en' => 'nullable|string',
            'facilities_bn' => 'nullable|string',
            'note_en' => 'nullable|string',
            'note_bn' => 'nullable|string',
            'display_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name_en']);
        $validated['is_active'] = $request->has('is_active');

        Chamber::create($validated);
        return redirect()->route('admin.chambers.index')->with('success', 'Chamber created successfully!');
    }

    public function edit($id)
    {
        $chamber = Chamber::findOrFail($id);
        return view('admin.chambers.form', compact('chamber'));
    }

    public function update(Request $request, $id)
    {
        $chamber = Chamber::findOrFail($id);
        $validated = $request->validate([
            'name_en' => 'required|string|max:200',
            'name_bn' => 'required|string|max:200',
            'badge_en' => 'nullable|string|max:100',
            'badge_bn' => 'nullable|string|max:100',
            'address_en' => 'required|string',
            'address_bn' => 'required|string',
            'visiting_days_en' => 'required|string',
            'visiting_days_bn' => 'required|string',
            'visiting_hours_en' => 'required|string',
            'visiting_hours_bn' => 'required|string',
            'weekly_off_en' => 'nullable|string',
            'weekly_off_bn' => 'nullable|string',
            'phone1' => 'required|string|max:50',
            'phone2' => 'nullable|string|max:50',
            'fee' => 'required|string|max:50',
            'map_url' => 'nullable|string',
            'facilities_en' => 'nullable|string',
            'facilities_bn' => 'nullable|string',
            'note_en' => 'nullable|string',
            'note_bn' => 'nullable|string',
            'display_order' => 'integer',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $chamber->update($validated);

        return redirect()->route('admin.chambers.index')->with('success', 'Chamber updated successfully!');
    }

    public function destroy($id)
    {
        Chamber::findOrFail($id)->delete();
        return back()->with('success', 'Chamber deleted.');
    }
}

