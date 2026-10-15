<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DrProfile;

class AdminProfileController extends Controller
{
    public function edit()
    {
        $profile = DrProfile::firstOrCreate(['id' => 1]);
        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = DrProfile::firstOrCreate(['id' => 1]);

        $validated = $request->validate([
            'name_en' => 'required|string|max:150',
            'name_bn' => 'required|string|max:150',
            'designation_en' => 'required|string|max:200',
            'designation_bn' => 'required|string|max:200',
            'degrees_en' => 'required|string|max:255',
            'degrees_bn' => 'required|string|max:255',
            'bmdc_reg' => 'required|string|max:50',
            'experience_years' => 'required|string|max:50',
            'patients_count' => 'required|string|max:50',
            'satisfaction_rate' => 'required|string|max:50',
            'hero_badge_en' => 'nullable|string|max:100',
            'hero_badge_bn' => 'nullable|string|max:100',
            'hero_bio_en' => 'nullable|string',
            'hero_bio_bn' => 'nullable|string',
            'about_headline_en' => 'nullable|string',
            'about_headline_bn' => 'nullable|string',
            'about_p1_en' => 'nullable|string',
            'about_p1_bn' => 'nullable|string',
            'about_p2_en' => 'nullable|string',
            'about_p2_bn' => 'nullable|string',
            'academic_post1_en' => 'nullable|string',
            'academic_post1_bn' => 'nullable|string',
            'academic_desc1_en' => 'nullable|string',
            'academic_desc1_bn' => 'nullable|string',
            'hotline_phone' => 'required|string|max:50',
            'hotline_whatsapp' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'consultation_fee' => 'required|string|max:50',
            'emergency_notice_en' => 'nullable|string',
            'emergency_notice_bn' => 'nullable|string',
            'facebook_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'avatar_file' => 'nullable|image|max:4096',
            'primary_color' => 'nullable|string|max:20',
            'primary_hover' => 'nullable|string|max:20',
            'accent_color' => 'nullable|string|max:20',
            'accent_hover' => 'nullable|string|max:20',
            'soft_accent' => 'nullable|string|max:20',
            'site_title_en' => 'nullable|string|max:150',
            'site_title_bn' => 'nullable|string|max:150',
        ]);

        if ($request->hasFile('avatar_file')) {
            $path = $request->file('avatar_file')->store('profile', 'public');
            $validated['avatar'] = asset('storage/' . $path);
        }

        $profile->update($validated);

        return back()->with('success', 'Doctor Profile (drprofile) updated successfully!');
    }
}

