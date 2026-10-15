@extends('layouts.app')

@section('content')
  <section class="hero-faq-banner">
    <div class="container">
      <div class="text-center banner-hero-wrapper mx-auto">
        <div class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-bold mb-3 d-inline-flex align-items-center gap-2">
          <i class="bi bi-question-circle-fill fs-6"></i>
          <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'রোগী নির্দেশিকা ও সহায়তা' : 'Patient Support & Guidelines' }}</span>
        </div>
        <h1 class="display-5 fw-extrabold mb-3">
          {{ ($locale ?? app()->getLocale()) === 'bn' ? 'সচরাচর জিজ্ঞাসিত প্রশ্নোত্তর' : 'Patient Help Guide & FAQs' }}
        </h1>
        <p class="fs-5 text-muted mb-4 mx-auto" style="max-width: 760px;">
          {{ ($locale ?? app()->getLocale()) === 'bn' ? 'সিরিয়াল বুকিং নিয়মাবলী, রিপোর্ট দেখানোর সময়সীমা এবং চেম্বারে আসার পূর্বে প্রয়োজনীয় প্রস্তুতি সংক্রান্ত যাবতীয় তথ্য।' : 'Clear instructions on serial bookings, report evaluation rules, required medical documents, and what to expect during your consultation.' }}
        </p>
        <a href="{{ route('booking') }}" class="btn btn-brand-primary px-4 py-3">
          <i class="bi bi-calendar2-check-fill me-2"></i>
          <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সিরিয়াল বুক করুন' : 'Book Consultation Serial' }}</span>
        </a>
      </div>
    </div>
  </section>

  <section class="py-5" style="background-color: #FFFFFF;">
    <div class="container py-lg-4">
      <div class="row justify-content-center">
        <div class="col-lg-9">
          <div class="accordion" id="faqPageAccordion">
            @foreach($faqs as $idx => $fq)
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $idx }}">
                  <button class="accordion-button {{ $idx > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $idx }}" aria-expanded="{{ $idx === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $idx }}">
                    {{ ($locale ?? app()->getLocale()) === 'bn' ? $fq->question_bn : $fq->question_en }}
                  </button>
                </h2>
                <div id="collapse{{ $idx }}" class="accordion-collapse collapse {{ $idx === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $idx }}" data-bs-parent="#faqPageAccordion">
                  <div class="accordion-body text-muted small">
                    {{ ($locale ?? app()->getLocale()) === 'bn' ? $fq->answer_bn : $fq->answer_en }}
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>

      <div class="mt-5 p-4 p-md-5 rounded-4 text-center text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #0F3B66 0%, #082440 100%); border: 1px solid rgba(255, 255, 255, 0.1);">
        <div class="max-w-700 mx-auto position-relative" style="z-index: 2;">
          <div class="badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill mb-3">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'আরও কোনো প্রশ্ন আছে?' : 'Still Have Questions?' }}</div>
          <h2 class="display-6 fw-bold mb-3 text-white">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'আমরা আপনাকে সহযোগিতা করতে প্রস্তুত' : 'We Are Here to Assist Your Care Journey' }}</h2>
          <p class="text-slate-300 fs-5 mb-4 mx-auto" style="color: #cbd5e1; max-width: 600px;">
            {{ ($locale ?? app()->getLocale()) === 'bn' ? 'সরাসরি চেম্বার হটলাইনে ফোন করুন অথবা অনলাইনে তাৎক্ষণিক সিরিয়াল নিশ্চিত করুন।' : 'Reach our chamber staff directly by phone, WhatsApp, or reserve your serial online.' }}
          </p>
          <div class="d-flex flex-wrap gap-3 justify-content-center">
            <a href="{{ route('booking') }}" class="btn btn-brand-primary px-4 py-3 fs-6">
              <i class="bi bi-calendar2-check-fill me-2"></i>
              <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সিরিয়াল বুক করুন' : 'Book Consultation Serial' }}</span>
            </a>
            <a href="tel:{{ $profile->hotline_phone ?? '+8801700000000' }}" class="btn btn-outline-light rounded-3 px-4 py-3 fw-bold fs-6">
              <i class="bi bi-telephone-fill me-2"></i>
              <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'হটলাইনে কল করুন' : 'Call Hotline' }}</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

