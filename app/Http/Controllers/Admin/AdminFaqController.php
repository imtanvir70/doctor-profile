<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

class AdminFaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('display_order')->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question_en' => 'required|string',
            'question_bn' => 'required|string',
            'answer_en' => 'required|string',
            'answer_bn' => 'required|string',
            'display_order' => 'integer',
        ]);

        $validated['is_active'] = $request->has('is_active');
        Faq::create($validated);
        return back()->with('success', 'FAQ added successfully!');
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);
        $validated = $request->validate([
            'question_en' => 'required|string',
            'question_bn' => 'required|string',
            'answer_en' => 'required|string',
            'answer_bn' => 'required|string',
            'display_order' => 'integer',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $faq->update($validated);
        return back()->with('success', 'FAQ updated successfully!');
    }

    public function destroy($id)
    {
        Faq::findOrFail($id)->delete();
        return back()->with('success', 'FAQ removed.');
    }
}

