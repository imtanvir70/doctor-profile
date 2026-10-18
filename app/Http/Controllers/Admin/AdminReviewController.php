<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class AdminReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::latest()->get();
        return view('admin.reviews.index', compact('reviews'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:150',
            'location_tag_en' => 'required|string|max:150',
            'location_tag_bn' => 'required|string|max:150',
            'rating' => 'required|integer|min:1|max:5',
            'review_text_en' => 'required|string',
            'review_text_bn' => 'required|string',
        ]);

        $initials = collect(explode(' ', $validated['patient_name']))
            ->map(fn($w) => strtoupper(substr($w, 0, 1)))
            ->take(2)
            ->join('');
        $validated['patient_initials'] = $initials ?: 'PT';
        $validated['is_approved'] = $request->has('is_approved');
        $validated['is_featured'] = $request->has('is_featured');

        Review::create($validated);
        return back()->with('success', 'Testimonial added successfully!');
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $validated = $request->validate([
            'patient_name' => 'required|string|max:150',
            'patient_phone' => ['nullable', 'string', 'regex:/^01[3-9]\d{8}$/'],
            'last_visit_date' => 'nullable|date',
            'treated_for' => 'nullable|string|max:150',
            'location_tag_en' => 'nullable|string|max:150',
            'location_tag_bn' => 'nullable|string|max:150',
            'rating' => 'required|integer|min:1|max:5',
            'review_text_en' => 'nullable|string',
            'review_text_bn' => 'nullable|string',
        ]);

        $initials = collect(explode(' ', $validated['patient_name']))
            ->filter()
            ->map(fn($w) => mb_substr($w, 0, 1))
            ->take(2)
            ->join('');
        $validated['patient_initials'] = strtoupper($initials) ?: ($review->patient_initials ?? 'PT');
        $validated['is_approved'] = $request->has('is_approved');
        $validated['is_featured'] = $request->has('is_featured');

        // Ensure review text is not empty in both fields
        if (empty($validated['review_text_en']) && !empty($validated['review_text_bn'])) {
            $validated['review_text_en'] = $validated['review_text_bn'];
        }
        if (empty($validated['review_text_bn']) && !empty($validated['review_text_en'])) {
            $validated['review_text_bn'] = $validated['review_text_en'];
        }

        $review->update($validated);
        return back()->with('success', 'Patient review updated successfully!');
    }

    public function toggleApproval($id)
    {
        $review = Review::findOrFail($id);
        $review->is_approved = !$review->is_approved;
        $review->save();
        return back()->with('success', 'Review status updated.');
    }

    public function destroy($id)
    {
        Review::findOrFail($id)->delete();
        return back()->with('success', 'Review deleted.');
    }
}

