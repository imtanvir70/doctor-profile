@extends('layouts.app')

@section('content')
  <section class="hero-expertise-banner">
    <div class="container">
      <div class="text-center banner-hero-wrapper mx-auto">
        <div class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-bold mb-3 d-inline-flex align-items-center gap-2">
          <i class="bi bi-diagram-3-fill fs-6"></i>
          <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'মেডিসিন বিশেষায়িত সেবা' : 'Internal Medicine Disciplines' }}</span>
        </div>
        <h1 class="display-5 fw-extrabold mb-3">
          {{ ($locale ?? app()->getLocale()) === 'bn' ? 'বিশেষজ্ঞ চিকিৎসা সেবা ও প্রোটোকল' : 'Specialized Clinical Solutions' }}
        </h1>
        <p class="fs-5 text-muted mb-4 mx-auto" style="max-width: 760px;">
          {{ ($locale ?? app()->getLocale()) === 'bn' ? '১৫+ বছরের ক্লিনিক্যাল অভিজ্ঞতার ভিত্তিতে তৈরি সুনির্দিষ্ট চিকিৎসা প্রোটোকল, অঙ্গ-প্রত্যঙ্গের সুরক্ষা এবং ওষুধের অপব্যবহার রোধে অঙ্গীকারবদ্ধ সেবা।' : 'Systematic medical protocols developed through 15+ years of clinical practice, dedicated to organ preservation, rational antibiotic therapy, and sustainable metabolic stabilization.' }}
        </p>
        <a href="{{ route('booking') }}" class="btn btn-brand-primary px-4 py-3">
          <i class="bi bi-calendar2-check-fill me-2"></i>
          <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সিরিয়াল বুক করুন' : 'Book Consultation Serial' }}</span>
        </a>
      </div>
    </div>
  </section>

  <section class="py-5">
    <div class="container py-lg-4">
      <div class="row g-4">
        @foreach($specialties as $sp)
          <div class="col-lg-6">
            <article class="expertise-detail-card">
              <div>
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <div class="clinical-icon clinical-icon-blue">
                    <i class="bi {{ $sp->icon ?? 'bi-heart-pulse-fill' }}"></i>
                  </div>
                  <span class="badge bg-light text-primary border fw-semibold">{{ $sp->category ?? 'Medicine' }}</span>
                </div>
                <h2 class="fs-4 fw-bold mb-2 brand-font">{{ ($locale ?? app()->getLocale()) === 'bn' ? $sp->title_bn : $sp->title_en }}</h2>
                <p class="text-muted small mb-3">
                  {{ ($locale ?? app()->getLocale()) === 'bn' ? $sp->description_bn : $sp->description_en }}
                </p>
                <div class="approach-box">
                  <div class="fw-bold text-dark small mb-1"><i class="bi bi-check2-circle text-success me-1"></i> <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'ডাক্তারের চিকিৎসা পদ্ধতি:' : "Doctor's Clinical Approach:" }}</span></div>
                  <div class="small text-muted">
                    {{ ($locale ?? app()->getLocale()) === 'bn' 
                      ? ($sp->approach_bn ?? 'অপ্রয়োজনীয় অ্যান্টিবায়োটিক পরিহার, সঠিক খাদ্যাভ্যাস ও আধুনিক চিকিৎসা নির্দেশিকার মেলবন্ধন।')
                      : ($sp->approach_en ?? 'Prioritizes organ-protective therapy alongside strict nutritional timing to achieve target clinical control without drug side-effects.') }}
                  </div>
                </div>
              </div>
              <div class="border-top pt-3 mt-4 d-flex align-items-center justify-content-between">
                <div class="d-flex gap-2">
                  @if(!empty($sp->tags))
                    @foreach(explode(',', $sp->tags) as $tag)
                      <span class="badge bg-light text-secondary border small">{{ trim($tag) }}</span>
                    @endforeach
                  @endif
                </div>
                <a href="{{ route('booking') }}" class="text-primary fw-bold small">
                  <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সিরিয়াল নিন' : 'Consult Specialist' }}</span> <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </article>
          </div>
        @endforeach
      </div>

      <div class="mt-5 p-4 p-md-5 rounded-4 text-center text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #0F3B66 0%, #082440 100%); border: 1px solid rgba(255, 255, 255, 0.1);">
        <div class="max-w-700 mx-auto position-relative" style="z-index: 2;">
          <div class="badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill mb-3">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'ব্যক্তিগত চিকিৎসা পরিকল্পনা' : 'Personalized Treatment Plans' }}</div>
          <h2 class="display-6 fw-bold mb-3 text-white">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'বিশেষজ্ঞ ডাক্তারের সাথে পরামর্শ নিশ্চিত করুন' : 'Schedule a Detailed Clinical Consultation' }}</h2>
          <p class="text-slate-300 fs-5 mb-4 mx-auto" style="color: #cbd5e1; max-width: 600px;">
            {{ ($locale ?? app()->getLocale()) === 'bn' ? 'সুনির্দিষ্ট রোগ নির্ণয়, পূর্বের প্রেসক্রিপশন পর্যালোচনা ও কার্যকর সুস্থতার জন্য ' . ($profile->name_bn ?? 'ডাক্তার') . '-এর অ্যাপয়েন্টমেন্ট নিন।' : 'Consult with ' . ($profile->name_en ?? 'the specialist') . ' for precision diagnosis, medication review, and evidence-based clinical recovery.' }}
          </p>
          <a href="{{ route('booking') }}" class="btn btn-brand-primary px-4 py-3 fs-6">
            <i class="bi bi-calendar2-check-fill me-2"></i>
            <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সিরিয়াল বুক করুন' : 'Book Consultation Serial' }}</span>
          </a>
        </div>
      </div>
    </div>
  </section>
@endsection

