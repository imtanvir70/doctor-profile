<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use App\Models\DrProfile;
use App\Models\SeoSetting;
use App\Models\Chamber;
use App\Models\Specialty;
use App\Models\Article;
use App\Models\Video;
use App\Models\Faq;
use App\Models\Review;
use App\Models\Serial;
use App\Models\InternationalProject;

class FrontendController extends Controller
{
    protected function getCommonData($pageKey = 'home')
    {
        $profile = DrProfile::first() ?? new DrProfile();
        $seo = SeoSetting::where('page_key', $pageKey)->first() 
            ?? SeoSetting::where('page_key', 'global')->first();
        $globalSeo = SeoSetting::where('page_key', 'global')->first();
        $chambers = Chamber::where('is_active', true)->orderBy('display_order')->get();
        $internationalProjects = InternationalProject::where('is_active', true)->orderBy('display_order')->get();
        $locale = App::getLocale();

        return compact('profile', 'seo', 'globalSeo', 'chambers', 'internationalProjects', 'locale');
    }

    public function index()
    {
        $data = $this->getCommonData('home');
        $data['specialties'] = Specialty::where('is_active', true)->orderBy('display_order')->get();
        $data['articles'] = Article::where('is_published', true)->orderByDesc('is_featured')->latest()->take(3)->get();
        $data['videos'] = Video::where('is_active', true)->orderBy('display_order')->take(3)->get();
        $data['reviews'] = Review::where('is_approved', true)->orderByDesc('is_featured')->latest()->get();
        $data['faqs'] = Faq::where('is_active', true)->orderBy('display_order')->take(4)->get();

        return view('frontend.index', $data);
    }

    public function about()
    {
        $data = $this->getCommonData('about');
        return view('frontend.about', $data);
    }

    public function expertise()
    {
        $data = $this->getCommonData('expertise');
        $data['specialties'] = Specialty::where('is_active', true)->orderBy('display_order')->get();
        return view('frontend.expertise', $data);
    }

    public function chambers()
    {
        $data = $this->getCommonData('chambers');
        return view('frontend.chambers', $data);
    }

    public function blog(Request $request)
    {
        $data = $this->getCommonData('blog');
        $category = $request->get('category');
        $query = Article::where('is_published', true);
        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }
        $data['articles'] = $query->latest()->get();
        $data['leadArticle'] = Article::where('is_featured', true)->first() ?? $data['articles']->first();
        return view('frontend.blog', $data);
    }

    public function videos()
    {
        $data = $this->getCommonData('videos');
        $data['videos'] = Video::where('is_active', true)->orderBy('display_order')->get();
        return view('frontend.videos', $data);
    }

    public function faq()
    {
        $data = $this->getCommonData('faq');
        $data['faqs'] = Faq::where('is_active', true)->orderBy('display_order')->get();
        return view('frontend.faq', $data);
    }

    public function booking()
    {
        $data = $this->getCommonData('booking');
        return view('frontend.booking', $data);
    }

    public function storeSerial(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:150',
            'patient_phone' => 'required|string|max:20',
            'chamber' => 'required|string',
            'preferred_date' => 'required|date|after_or_equal:today',
            'patient_age' => 'nullable|integer|min:1|max:120',
            'patient_gender' => 'nullable|in:male,female,other',
            'visit_type' => 'nullable|in:new,followup,report',
            'symptoms_summary' => 'nullable|string|max:1000',
            'medical_reports.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:15360',
        ]);

        $chamber = Chamber::where('slug', $request->chamber)->first() 
            ?? Chamber::first();

        // Generate serial number for today
        $dateStr = date('Ymd', strtotime($request->preferred_date));
        $count = Serial::whereDate('preferred_date', $request->preferred_date)
            ->where('chamber_id', $chamber->id)
            ->count() + 1;
        $serialNumber = 'SL-' . $dateStr . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

        // Upload reports if any
        $uploadedFiles = [];
        if ($request->hasFile('medical_reports')) {
            foreach ($request->file('medical_reports') as $file) {
                $path = $file->store('reports/' . date('Y/m'), 'public');
                $uploadedFiles[] = [
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $path,
                ];
            }
        }

        $serial = Serial::create([
            'serial_number' => $serialNumber,
            'chamber_id' => $chamber->id,
            'chamber_name' => $chamber->name_en,
            'patient_name' => $validated['patient_name'],
            'patient_phone' => $validated['patient_phone'],
            'preferred_date' => $validated['preferred_date'],
            'patient_age' => $validated['patient_age'] ?? null,
            'patient_gender' => $validated['patient_gender'] ?? 'male',
            'visit_type' => $validated['visit_type'] ?? 'new',
            'symptoms_summary' => $validated['symptoms_summary'] ?? null,
            'medical_reports' => $uploadedFiles,
            'status' => 'pending',
            'admin_notes' => 'Booked online from website portal.',
        ]);

        $locale = App::getLocale();
        $message = $locale === 'bn'
            ? "আপনার সিরিয়াল সফলভাবে গৃহীত হয়েছে! সিরিয়াল নম্বর: {$serialNumber}। চেম্বার: {$chamber->name_bn}। তারিখ: {$validated['preferred_date']}।"
            : "Your serial request has been submitted successfully! Serial Number: {$serialNumber}. Chamber: {$chamber->name_en}. Date: {$validated['preferred_date']}.";

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'serial_number' => $serialNumber,
                'message' => $message,
            ]);
        }

        return redirect()->back()->with('success_serial', [
            'number' => $serialNumber,
            'message' => $message,
        ]);
    }

    public function switchLocale($locale)
    {
        if (in_array($locale, ['en', 'bn'])) {
            Session::put('locale', $locale);
            Cookie::queue('app_locale', $locale, 60 * 24 * 365);
        }

        return redirect()->back();
    }
}

