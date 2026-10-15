@extends('layouts.app')

@section('content')
  <section class="hero-video-banner">
    <div class="container">
      <div class="text-center banner-hero-wrapper mx-auto">
        <div class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-bold mb-3 d-inline-flex align-items-center gap-2">
          <i class="bi bi-youtube fs-6"></i>
          <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'ডাক্তারের ভিডিও আর্কাইভ' : "Doctor's Video Archive" }}</span>
        </div>
        <h1 class="display-5 fw-extrabold mb-3">
          {{ ($locale ?? app()->getLocale()) === 'bn' ? 'ভিডিও স্বাস্থ্য পরামর্শ ও রোগ নির্দেশিকা' : 'Clinical Video Guides & Health Advice' }}
        </h1>
        <p class="fs-5 text-muted mb-4 mx-auto" style="max-width: 760px;">
          {{ ($locale ?? app()->getLocale()) === 'bn' ? ('বিভিন্ন রোগ প্রতিরোধ ও সঠিক পথ্য নিয়ে ' . ($profile->name_bn ?? 'ডাক্তার') . '-এর ভিডিও পরামর্শ সরাসরি এই ওয়েবসাইটে দেখুন।') : ('Authentic, evidence-based health guidance and disease prevention discussions directly from ' . ($profile->name_en ?? 'the specialist') . '. Play any video directly inside this website.') }}
        </p>

        <div class="d-flex flex-wrap gap-2 justify-content-center pt-2" id="videoFilters">
          <button type="button" class="filter-pill-btn active" data-filter="all">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সকল ভিডিও' : 'All Guides' }}</button>
          <button type="button" class="filter-pill-btn" data-filter="diabetes">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'ডায়াবেটিস ও মেটাবলিজম' : 'Diabetes & Metabolism' }}</button>
          <button type="button" class="filter-pill-btn" data-filter="hypertension">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'ব্লাড প্রেশার ও হার্ট' : 'Blood Pressure & Heart' }}</button>
          <button type="button" class="filter-pill-btn" data-filter="antibiotic">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'অ্যান্টিবায়োটিক সতর্কতা' : 'Antibiotic Safety' }}</button>
          <button type="button" class="filter-pill-btn" data-filter="fever">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'জ্বর ও ডেঙ্গু' : 'Fever & Dengue' }}</button>
          <button type="button" class="filter-pill-btn" data-filter="respiratory">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'অ্যাজমা ও বক্ষব্যাধি' : 'Asthma & Chest' }}</button>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5" style="background: linear-gradient(180deg, var(--bg-slate) 0%, #FFFFFF 50%, var(--bg-slate) 100%);">
    <div class="container py-lg-4">
      <div class="row g-4" id="videoListContainer">
        @foreach($videos as $vid)
          <div class="col-md-6 col-lg-4 video-grid-item" data-category="{{ strtolower($vid->category ?? 'diabetes') }}">
            <div class="video-card">
              <div class="video-thumb-container js-play-video" 
                   data-video-id="{{ $vid->youtube_video_id }}" 
                   data-title="{{ ($locale ?? app()->getLocale()) === 'bn' ? $vid->title_bn : $vid->title_en }}" 
                   data-desc="{{ ($locale ?? app()->getLocale()) === 'bn' ? $vid->description_bn : $vid->description_en }}" 
                   role="button" tabindex="0">
                <img src="{{ $vid->thumbnail_url ?? 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=800&q=80' }}" alt="{{ $vid->title_en }}" class="video-thumb-img" loading="lazy">
                <div class="video-play-btn-circle"><i class="bi bi-play-fill"></i></div>
                @if(!empty($vid->duration))
                  <span class="video-duration-tag"><i class="bi bi-clock me-1"></i>{{ $vid->duration }}</span>
                @endif
              </div>
              <div class="p-4 d-flex flex-column justify-content-between flex-grow-1">
                <div>
                  <div class="d-flex align-items-center gap-2 text-danger small fw-bold mb-2">
                    <i class="bi bi-youtube"></i> <span>{{ $vid->category }}</span>
                  </div>
                  <h3 class="fs-5 fw-bold mb-2 text-dark">{{ ($locale ?? app()->getLocale()) === 'bn' ? $vid->title_bn : $vid->title_en }}</h3>
                  <p class="small text-muted mb-3">{{ ($locale ?? app()->getLocale()) === 'bn' ? $vid->description_bn : $vid->description_en }}</p>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                  <button type="button" class="btn btn-sm btn-danger rounded-pill px-3 py-1 js-play-video" 
                          data-video-id="{{ $vid->youtube_video_id }}" 
                          data-title="{{ ($locale ?? app()->getLocale()) === 'bn' ? $vid->title_bn : $vid->title_en }}" 
                          data-desc="{{ ($locale ?? app()->getLocale()) === 'bn' ? $vid->description_bn : $vid->description_en }}">
                    <i class="bi bi-play-circle me-1"></i> <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'প্লে করুন' : 'Play Inside' }}</span>
                  </button>
                  <span class="badge bg-light text-secondary border small">{{ $vid->category }}</span>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <div class="mt-5 p-4 p-md-5 rounded-4 text-center text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #0F3B66 0%, #082440 100%); border: 1px solid rgba(255, 255, 255, 0.1);">
        <div class="max-w-700 mx-auto position-relative" style="z-index: 2;">
          <div class="badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill mb-3">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সরাসরি চিকিৎসা পরামর্শ' : 'Need In-Person Consultation?' }}</div>
          <h2 class="display-6 fw-bold mb-3 text-white">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'ডাক্তারের চেম্বার অ্যাপয়েন্টমেন্ট নিন' : 'Book a Chamber Serial with ' . ($profile->name_en ?? 'Doctor') }}</h2>
          <p class="text-slate-300 fs-5 mb-4 mx-auto" style="color: #cbd5e1; max-width: 600px;">
            {{ ($locale ?? app()->getLocale()) === 'bn' ? 'সরাসরি শারীরিক পরীক্ষা, পূর্বের রক্তের টেস্ট ও ইমেজিং রিপোর্ট প্রদর্শন এবং রোগমুক্তির চিকিৎসা গ্রহণ করুন।' : 'Direct physical examinations, review of prior blood tests and imaging reports, and customized treatment plans.' }}
          </p>
          <a href="{{ route('booking') }}" class="btn btn-brand-primary px-4 py-3 fs-6">
            <i class="bi bi-calendar2-check-fill me-2"></i>
            <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সিরিয়াল বুক করুন' : 'Book Appointment / Serial' }}</span>
          </a>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('scripts')
<script>
  (function() {
    function initVideoFilters() {
      var filterBtns = document.querySelectorAll('#videoFilters .filter-pill-btn');
      var items = document.querySelectorAll('.video-grid-item');

      filterBtns.forEach(function(btn) {
        if (!btn.dataset.turboBound) {
          btn.dataset.turboBound = 'true';
          btn.addEventListener('click', function() {
            filterBtns.forEach(function(b) { b.classList.remove('active'); });
            btn.classList.add('active');
            var filter = btn.getAttribute('data-filter');

            items.forEach(function(item) {
              var cat = item.getAttribute('data-category');
              if (filter === 'all' || cat.includes(filter)) {
                item.style.display = '';
              } else {
                item.style.display = 'none';
              }
            });
          });
        }
      });
    }

    document.addEventListener('DOMContentLoaded', initVideoFilters);
    document.addEventListener('turbo:load', initVideoFilters);
  })();
</script>
@endsection

