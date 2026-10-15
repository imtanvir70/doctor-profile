@extends('layouts.app')

@section('content')
  <section class="hero-chambers-banner">
    <div class="container">
      <div class="text-center banner-hero-wrapper mx-auto">
        <div class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-bold mb-3 d-inline-flex align-items-center gap-2">
          <i class="bi bi-geo-alt-fill fs-6"></i>
          <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'ঢাকার চেম্বার লোকেশন' : 'Dhaka Consultation Locations' }}</span>
        </div>
        <h1 class="display-5 fw-extrabold mb-3">
          {{ ($locale ?? app()->getLocale()) === 'bn' ? 'চেম্বার ও রোগী দেখার সময়সূচী' : 'Chambers & Visiting Schedule' }}
        </h1>
        <p class="fs-5 text-muted mb-4 mx-auto" style="max-width: 760px;">
          {{ ($locale ?? app()->getLocale()) === 'bn' ? ($profile->name_bn ?? 'ডাক্তার') . ' নিয়মিত বিভিন্ন ডায়াগনস্টিক সেন্টারে রোগী দেখেন। আপনার সুবিধাজনক চেম্বার নির্বাচন করে দ্রুত সিরিয়াল গ্রহণ করুন।' : 'Consult with ' . ($profile->name_en ?? 'the specialist') . ' across modern diagnostic centres. Choose your preferred location to secure an instant chamber serial.' }}
        </p>
        <a href="{{ route('booking') }}" class="btn btn-brand-primary px-4 py-3">
          <i class="bi bi-calendar2-check-fill me-2"></i>
          <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'অনলাইন সিরিয়াল বুক করুন' : 'Book Online Serial' }}</span>
        </a>
      </div>
    </div>
  </section>

  <section class="py-5">
    <div class="container py-lg-4">
      <div class="row g-5 justify-content-center">
        @foreach($chambers as $index => $ch)
          <div class="col-lg-6">
            <article class="chamber-card {{ $index === 0 ? 'featured' : '' }}">
              <div>
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                  <span class="badge {{ $index === 0 ? 'bg-primary text-white' : 'bg-secondary-subtle text-dark' }} px-3 py-2 rounded-pill fw-semibold">
                    {{ ($locale ?? app()->getLocale()) === 'bn' ? ($index === 0 ? 'প্রধান চেম্বার' : 'সান্ধ্যকালীন চেম্বার') : ($index === 0 ? 'Primary Center' : 'Evening Center') }}
                  </span>
                  <div class="fs-5 fw-bold text-primary">
                    <i class="bi bi-cash-stack me-1"></i>
                    <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'ভিজিট ফি: ' . ($ch->fee ?: ($ch->consultation_fee ?: ($profile->consultation_fee ?: 'BDT 1,200'))) : 'Fee: ' . ($ch->fee ?: ($ch->consultation_fee ?: ($profile->consultation_fee ?: 'BDT 1,200'))) }}</span>
                  </div>
                </div>

                <h2 class="fs-4 fw-bold mb-1 brand-font">{{ ($locale ?? app()->getLocale()) === 'bn' ? $ch->name_bn : $ch->name_en }}</h2>
                <p class="text-muted small mb-3"><i class="bi bi-geo-alt-fill text-danger me-1"></i> <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? $ch->address_bn : $ch->address_en }}</span></p>

                <div class="chamber-schedule-grid">
                  <div class="row g-2">
                    <div class="col-6">
                      <div class="small text-muted fw-semibold">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'রোগী দেখার দিন' : 'Visiting Days' }}</div>
                      <div class="fw-bold text-dark">{{ ($locale ?? app()->getLocale()) === 'bn' ? $ch->visiting_days_bn : $ch->visiting_days_en }}</div>
                    </div>
                    <div class="col-6">
                      <div class="small text-muted fw-semibold">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'রোগী দেখার সময়' : 'Visiting Hours' }}</div>
                      <div class="fw-bold text-primary">{{ ($locale ?? app()->getLocale()) === 'bn' ? $ch->visiting_hours_bn : $ch->visiting_hours_en }}</div>
                    </div>
                    <div class="col-12 mt-2 pt-2 border-top">
                      <div class="small text-muted"><span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সাপ্তাহিক বন্ধ:' : 'Weekly Off:' }}</span> <span class="text-danger fw-semibold">{{ ($locale ?? app()->getLocale()) === 'bn' ? ($ch->weekly_off_bn ?? 'ছুটির দিন') : ($ch->weekly_off_en ?? 'Off Days') }}</span></div>
                    </div>
                  </div>
                </div>

                <div class="d-flex flex-wrap gap-2 mb-4">
                  <a href="tel:{{ $ch->phone1 }}" class="btn btn-brand-primary flex-grow-1 justify-content-center py-2">
                    <i class="bi bi-telephone-outbound-fill"></i>
                    <span>{{ $ch->phone1 }}</span>
                  </a>
                  @if(!empty($ch->phone2))
                    <a href="tel:{{ $ch->phone2 }}" class="btn btn-brand-outline py-2">
                      <i class="bi bi-telephone-fill"></i>
                      <span>{{ $ch->phone2 }}</span>
                    </a>
                  @endif
                  @if(!empty($ch->map_url))
                    <a href="{{ $ch->map_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-brand-outline py-2">
                      <i class="bi bi-compass"></i>
                      <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'গুগল ম্যাপ' : 'Google Map' }}</span>
                    </a>
                  @endif
                </div>

                <div class="p-3 rounded-3 bg-light border mb-4">
                  <div class="fw-bold small text-dark mb-1"><i class="bi bi-info-circle-fill text-primary me-1"></i> <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'ইন-হাউজ সুবিধাসমূহ:' : 'On-Site Facilities:' }}</span></div>
                  <div class="small text-muted">{{ ($locale ?? app()->getLocale()) === 'bn' ? $ch->notes_bn : $ch->notes_en }}</div>
                </div>
              </div>

              <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                <span class="small text-muted"><i class="bi bi-check2-circle text-success me-1"></i> <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'চেম্বারে সরাসরি সিরিয়াল কাউন্টার' : 'Direct on-site lab & pharmacy assistance.' }}</span></span>
                <a href="{{ route('booking') }}" class="btn btn-sm btn-outline-primary rounded-pill fw-bold px-3">
                  <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সিরিয়াল বুক করুন' : 'Book Serial' }}</span> <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </article>
          </div>
        @endforeach
      </div>

      <div class="mt-5 p-4 p-md-5 rounded-4 text-center text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #0F3B66 0%, #082440 100%); border: 1px solid rgba(255, 255, 255, 0.1);">
        <div class="max-w-700 mx-auto position-relative" style="z-index: 2;">
          <div class="badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill mb-3">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'অনলাইন সিরিয়াল বুকিং' : 'Online Chamber Reservation' }}</div>
          <h2 class="display-6 fw-bold mb-3 text-white">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'মাত্র ২ মিনিটে নিশ্চিত সিরিয়াল নিন' : 'Reserve Your Consultation Serial in 2 Minutes' }}</h2>
          <p class="text-slate-300 fs-5 mb-4 mx-auto" style="color: #cbd5e1; max-width: 600px;">
            {{ ($locale ?? app()->getLocale()) === 'bn' ? 'কোনো অগ্রিম ফি প্রয়োজন নেই। আপনার মোবাইলে এসএমএস-এর মাধ্যমে সিরিয়াল নম্বর ও নির্দেশিকা পাঠানো হবে।' : 'No advance payment required. Secure a confirmed queue number with direct SMS notifications on your mobile phone.' }}
          </p>
          <a href="{{ route('booking') }}" class="btn btn-brand-primary px-4 py-3 fs-6">
            <i class="bi bi-calendar2-check-fill me-2"></i>
            <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'অনলাইন সিরিয়াল বুকিং পোর্টালে যান' : 'Go to Online Serial Booking Portal' }}</span>
          </a>
        </div>
      </div>
    </div>
  </section>
@endsection

