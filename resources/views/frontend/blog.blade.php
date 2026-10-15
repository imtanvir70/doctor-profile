@extends('layouts.app')

@section('content')
  <section class="hero-blog-banner">
    <div class="container">
      <div class="text-center banner-hero-wrapper mx-auto">
        <div class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold mb-3 d-inline-flex align-items-center gap-2">
          <i class="bi bi-journal-medical fs-6"></i>
          <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'ডাক্তারের স্বাস্থ্য কলাম' : "Doctor's Medical Writings" }}</span>
        </div>
        <h1 class="display-5 fw-extrabold mb-3">
          {{ ($locale ?? app()->getLocale()) === 'bn' ? 'চিকিৎসা জার্নাল ও স্বাস্থ্য পরামর্শ' : 'Medical Journal & Health Articles' }}
        </h1>
        <p class="fs-5 text-muted mb-4 mx-auto" style="max-width: 760px;">
          {{ ($locale ?? app()->getLocale()) === 'bn' ? 'রোগ প্রতিরোধ, জনসচেতনতা এবং সঠিক চিকিৎসা নির্দেশনায় ' . ($profile->name_bn ?? 'ডাক্তার') . '-এর নিয়মিত বৈজ্ঞানিক প্রবন্ধ।' : 'Authoritative, evidence-based clinical articles and health insights written by ' . ($profile->name_en ?? 'the specialist') . ' to foster patient awareness and rational medical choices.' }}
        </p>

        <div class="d-flex flex-wrap gap-2 justify-content-center pt-2" id="articleFilters">
          <button type="button" class="filter-pill-btn active" data-filter="all">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সকল প্রবন্ধ' : 'All Articles' }}</button>
          <button type="button" class="filter-pill-btn" data-filter="diabetes">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'ডায়াবেটিস ও মেটাবলিজম' : 'Diabetes & Metabolism' }}</button>
          <button type="button" class="filter-pill-btn" data-filter="heart">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'উচ্চ রক্তচাপ ও হার্ট' : 'Hypertension & Heart' }}</button>
          <button type="button" class="filter-pill-btn" data-filter="infection">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'জ্বর ও ইনফেকশন' : 'Fever & Infections' }}</button>
          <button type="button" class="filter-pill-btn" data-filter="lifestyle">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'জীবনযাত্রা ও পথ্য' : 'Lifestyle & Diet' }}</button>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5" style="background: linear-gradient(180deg, var(--bg-slate) 0%, #FFFFFF 50%, var(--bg-slate) 100%);">
    <div class="container py-lg-4">

      @if($leadArticle)
        <div class="mb-5">
          <div class="featured-lead-article p-4 p-md-5">
            <div class="row g-4 align-items-center">
              <div class="col-lg-6">
                <div class="position-relative rounded-4 overflow-hidden" style="height: 320px;">
                  <img src="{{ $leadArticle->featured_image ?? 'https://images.unsplash.com/photo-1505751172876-fa1923c5c528?auto=format&fit=crop&w=1000&q=80' }}" alt="{{ $leadArticle->title_en }}" class="w-100 h-100 object-fit-cover">
                  <span class="article-tag">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'বিশেষ কলাম' : 'Featured Clinical Column' }}</span>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="small text-muted mb-2"><i class="bi bi-calendar3 me-1"></i> {{ date('F Y', strtotime($leadArticle->published_at ?? $leadArticle->created_at)) }} • {{ $leadArticle->read_time_minutes ?? '6' }} min read • By {{ $profile->name_en ?? 'Specialist' }}</div>
                <h2 class="display-6 fw-bold mb-3 brand-font text-dark">{{ ($locale ?? app()->getLocale()) === 'bn' ? $leadArticle->title_bn : $leadArticle->title_en }}</h2>
                <p class="text-muted mb-4">
                  {{ ($locale ?? app()->getLocale()) === 'bn' ? $leadArticle->excerpt_bn : $leadArticle->excerpt_en }}
                </p>
                <div class="p-3 rounded-3 mb-4" style="background-color: var(--soft-accent); border: 1px solid rgba(15, 59, 102, 0.1);">
                  <div class="fw-bold text-primary small mb-1"><i class="bi bi-check-circle-fill text-success me-1"></i> <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'ক্লিনিক্যাল গুরুত্ব:' : 'Key Clinical Insight:' }}</span></div>
                  <div class="small text-muted">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'খাবার গ্রহণের পর ১৫ মিনিট হাঁটাহাঁটি পোস্টপ্রান্ডিয়াল গ্লুকোজ প্রায় ২২% কমিয়ে দেয়।' : 'A 15-minute post-meal brisk walk lowers peak postprandial glucose significantly by activating GLUT4 receptors.' }}</div>
                </div>
                <button type="button" class="btn btn-brand-primary js-open-article" 
                        data-title="{{ ($locale ?? app()->getLocale()) === 'bn' ? $leadArticle->title_bn : $leadArticle->title_en }}"
                        data-category="{{ $leadArticle->category }}"
                        data-body="{{ ($locale ?? app()->getLocale()) === 'bn' ? ($leadArticle->content_bn ?? $leadArticle->excerpt_bn) : ($leadArticle->content_en ?? $leadArticle->excerpt_en) }}">
                  <i class="bi bi-book-half me-2"></i> <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সম্পূর্ণ প্রবন্ধ পড়ুন' : 'Read Full Article' }}</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      @endif

      <div class="row g-4" id="articleListContainer">
        @foreach($articles as $art)
          <div class="col-md-6 col-lg-4 article-grid-item" data-category="{{ strtolower($art->category ?? 'lifestyle') }}">
            <article class="article-card">
              <div class="article-img-wrap">
                <img src="{{ $art->featured_image ?? 'https://images.unsplash.com/photo-1584362917165-526a968579e8?auto=format&fit=crop&w=800&q=80' }}" alt="{{ $art->title_en }}" loading="lazy">
                <span class="article-tag">{{ $art->category }}</span>
                <span class="article-reading-time"><i class="bi bi-clock me-1"></i>{{ $art->read_time_minutes ?? '5' }} min read</span>
              </div>
              <div class="p-4 d-flex flex-column justify-content-between flex-grow-1">
                <div>
                  <div class="small text-muted mb-2"><i class="bi bi-calendar3 me-1"></i> {{ date('F Y', strtotime($art->published_at ?? $art->created_at)) }}</div>
                  <h3 class="fs-5 fw-bold mb-2 text-dark">{{ ($locale ?? app()->getLocale()) === 'bn' ? $art->title_bn : $art->title_en }}</h3>
                  <p class="small text-muted mb-3">{{ ($locale ?? app()->getLocale()) === 'bn' ? $art->excerpt_bn : $art->excerpt_en }}</p>
                </div>
                <div class="pt-3 border-top d-flex align-items-center justify-content-between">
                  <button type="button" class="btn btn-link p-0 text-primary fw-bold small text-decoration-none js-open-article"
                          data-title="{{ ($locale ?? app()->getLocale()) === 'bn' ? $art->title_bn : $art->title_en }}"
                          data-category="{{ $art->category }}"
                          data-body="{{ ($locale ?? app()->getLocale()) === 'bn' ? ($art->content_bn ?? $art->excerpt_bn) : ($art->content_en ?? $art->excerpt_en) }}">
                    <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সম্পূর্ণ পড়ুন' : 'Read Article' }}</span> <i class="bi bi-arrow-right"></i>
                  </button>
                  <span class="badge bg-light text-secondary border small">{{ $art->category }}</span>
                </div>
              </div>
            </article>
          </div>
        @endforeach
      </div>

      <div class="mt-5 p-4 p-md-5 rounded-4 text-center text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #0F3B66 0%, #082440 100%); border: 1px solid rgba(255, 255, 255, 0.1);">
        <div class="max-w-700 mx-auto position-relative" style="z-index: 2;">
          <div class="badge bg-success text-white fw-bold px-3 py-2 rounded-pill mb-3">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'চিকিৎসা পরামর্শ' : 'Personalized Medical Attention' }}</div>
          <h2 class="display-6 fw-bold mb-3 text-white">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'আপনার টেস্ট রিপোর্ট বা রোগ নিয়ে চিন্তিত?' : 'Have Questions About Your Health Reports?' }}</h2>
          <p class="text-slate-300 fs-5 mb-4 mx-auto" style="color: #cbd5e1; max-width: 600px;">
            {{ ($locale ?? app()->getLocale()) === 'bn' ? 'সরাসরি চেম্বারে এসে অথবা অনলাইন সিরিয়াল নিয়ে আপনার মেডিকেল হিস্ট্রি ' . ($profile->name_bn ?? 'ডাক্তার') . '-কে প্রদর্শন করুন।' : 'Book a consultation serial to discuss your diagnostic tests, chronic health challenges, and tailored therapeutic roadmap with ' . ($profile->name_en ?? 'the specialist') . '.' }}
          </p>
          <a href="{{ route('booking') }}" class="btn btn-brand-primary px-4 py-3 fs-6">
            <i class="bi bi-calendar2-check-fill me-2"></i>
            <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সিরিয়াল বুক করুন' : 'Book Appointment / Serial' }}</span>
          </a>
        </div>
      </div>
    </div>
  </section>

  {{-- Article Reader Modal --}}
  <div class="modal fade" id="articleReaderModal" tabindex="-1" aria-labelledby="readerModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
      <div class="modal-content" style="border-radius: 18px; border: 1px solid var(--border-color);">
        <div class="modal-header border-bottom py-3 px-4" style="background: var(--bg-slate);">
          <div>
            <span class="badge bg-primary text-white px-2 py-1 small rounded-pill mb-1" id="readerBadge">Clinical Column</span>
            <h5 class="modal-title fw-bold text-dark fs-5 brand-font" id="readerModalTitle">Article Title</h5>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4 p-md-5 text-dark" style="line-height: 1.8; font-size: 1.02rem;" id="readerModalBody">
          <p>Article content...</p>
        </div>
        <div class="modal-footer border-top py-3 px-4 d-flex align-items-center justify-content-between" style="background: var(--bg-slate);">
          <div class="small text-muted">
            <i class="bi bi-patch-check-fill text-success me-1"></i>
            <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'লেখক: ' . ($profile->name_bn ?? '') . ', ' . ($profile->degrees_bn ?? '') : 'Written by ' . ($profile->name_en ?? '') . ', ' . ($profile->degrees_en ?? '') }}</span>
          </div>
          <a href="{{ route('booking') }}" class="btn btn-brand-primary btn-sm px-3 py-2">
            <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সিরিয়াল বুক করুন' : 'Book Appointment / Serial' }}</span>
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script>
  (function() {
    function initBlog() {
      var modalEl = document.getElementById('articleReaderModal');
      var readerTitle = document.getElementById('readerModalTitle');
      var readerBadge = document.getElementById('readerBadge');
      var readerBody = document.getElementById('readerModalBody');

      document.querySelectorAll('.js-open-article').forEach(function(btn) {
        if (!btn.dataset.turboBound) {
          btn.dataset.turboBound = 'true';
          btn.addEventListener('click', function(e) {
            e.preventDefault();
            var title = btn.getAttribute('data-title');
            var cat = btn.getAttribute('data-category');
            var body = btn.getAttribute('data-body');

            if (readerTitle) readerTitle.textContent = title;
            if (readerBadge) readerBadge.textContent = cat;
            if (readerBody) readerBody.innerHTML = '<p class="lead text-dark fw-medium mb-3">' + body.replace(/\n\n/g, '</p><p>') + '</p>';

            if (modalEl && window.bootstrap) {
              var bsModal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
              bsModal.show();
            }
          });
        }
      });

      // Category Filter Buttons
      var filterBtns = document.querySelectorAll('.filter-pill-btn');
      var cards = document.querySelectorAll('.article-grid-item');

      filterBtns.forEach(function(btn) {
        if (!btn.dataset.turboBound) {
          btn.dataset.turboBound = 'true';
          btn.addEventListener('click', function() {
            filterBtns.forEach(function(b) { b.classList.remove('active'); });
            btn.classList.add('active');
            var filter = btn.getAttribute('data-filter');

            cards.forEach(function(card) {
              var cat = card.getAttribute('data-category');
              if (filter === 'all' || cat.includes(filter)) {
                card.style.display = '';
              } else {
                card.style.display = 'none';
              }
            });
          });
        }
      });
    }

    document.addEventListener('DOMContentLoaded', initBlog);
    document.addEventListener('turbo:load', initBlog);
  })();
</script>
@endsection

