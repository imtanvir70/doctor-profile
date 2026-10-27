<!DOCTYPE html>
<html lang="{{ $locale ?? app()->getLocale() }}" class="{{ ($locale ?? app()->getLocale()) === 'bn' ? 'lang-bn' : '' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Dynamic SEO Meta Tags --}}
    <title>
        {{ ($locale ?? app()->getLocale()) === 'bn' ? $seo->meta_title_bn ?? $profile->name_bn : $seo->meta_title_en ?? $profile->name_en }}
    </title>
    <meta name="description"
        content="{{ ($locale ?? app()->getLocale()) === 'bn' ? $seo->meta_description_bn ?? $profile->hero_bio_bn : $seo->meta_description_en ?? $profile->hero_bio_en }}">
    <meta name="keywords"
        content="{{ ($locale ?? app()->getLocale()) === 'bn' ? $seo->keywords_bn ?? '' : $seo->keywords_en ?? '' }}">
    <meta name="author" content="{{ $profile->name_en ?? 'Dr. Abu Hanif Rakib' }}">
    <meta name="robots" content="{{ $seo->robots ?? 'index, follow' }}">
    @if (!empty($seo->canonical_url))
        <link rel="canonical" href="{{ $seo->canonical_url }}">
    @endif

    {{-- OpenGraph & Social Media Meta --}}
    <meta property="og:type" content="{{ $seo->schema_type ?? 'profile' }}">
    <meta property="og:title"
        content="{{ ($locale ?? app()->getLocale()) === 'bn' ? $seo->meta_title_bn ?? $profile->name_bn : $seo->meta_title_en ?? $profile->name_en }}">
    <meta property="og:description"
        content="{{ ($locale ?? app()->getLocale()) === 'bn' ? $seo->meta_description_bn ?? $profile->hero_bio_bn : $seo->meta_description_en ?? $profile->hero_bio_en }}">
    <meta property="og:image" content="{{ $seo->og_image ?? ($globalSeo->og_image ?? $profile->avatar) }}">
    <meta property="og:url" content="{{ url()->current() }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title"
        content="{{ ($locale ?? app()->getLocale()) === 'bn' ? $seo->meta_title_bn ?? $profile->name_bn : $seo->meta_title_en ?? $profile->name_en }}">
    <meta name="twitter:description"
        content="{{ ($locale ?? app()->getLocale()) === 'bn' ? $seo->meta_description_bn ?? $profile->hero_bio_bn : $seo->meta_description_en ?? $profile->hero_bio_en }}">
    <meta name="twitter:image" content="{{ $seo->og_image ?? ($globalSeo->og_image ?? $profile->avatar) }}">

    {{-- Dynamic Site Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ $profile->favicon_url }}">
    <link rel="alternate icon" href="{{ $profile->favicon_url }}">
    <link rel="apple-touch-icon" href="{{ $profile->favicon_url }}">

    {{-- Fonts & Bootstrap 5 --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+Bengali:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor.css') }}">
    <style id="dynamic-doctor-theme">
        :root {
            --primary: {{ $profile->primary_color ?? '#0F3B66' }} !important;
            --primary-hover: {{ $profile->primary_hover ?? '#0a2744' }} !important;
            --accent: {{ $profile->accent_color ?? '#059669' }} !important;
            --accent-hover: {{ $profile->accent_hover ?? '#047857' }} !important;
            --soft-accent: {{ $profile->soft_accent ?? '#E0F2FE' }} !important;
            --accent-light: {{ $profile->soft_accent ?? '#d1fae5' }} !important;
        }
        .turbo-progress-bar {
            background-color: var(--accent) !important;
            box-shadow: 0 0 10px var(--accent) !important;
        }

        /* Minimalist Tech Partner Section (Frontend Only) */
        .footer-tech-partner-strip {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.09);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            transition: all 0.25s ease;
        }
        .footer-tech-partner-strip:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.16);
        }
        .tech-partner-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.25);
            color: #10b981;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            flex-shrink: 0;
        }
        .tech-partner-name {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 1.02rem;
            color: #ffffff;
            letter-spacing: -0.01em;
        }
        .tech-partner-badge {
            font-size: 0.68rem;
            font-weight: 600;
            color: #38bdf8;
            background: rgba(56, 189, 248, 0.1);
            border: 1px solid rgba(56, 189, 248, 0.2);
            padding: 0.12rem 0.5rem;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            letter-spacing: 0.02em;
        }
        .partner-pulse-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 6px #10b981;
        }
        .tech-partner-desc {
            font-size: 0.8rem;
            color: #94a3b8;
            line-height: 1.4;
            margin-top: 0.15rem;
        }
        .tech-partner-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.16);
            color: #e2e8f0 !important;
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
            font-size: 0.76rem;
            padding: 0.28rem 0.75rem;
            border-radius: 9999px;
            text-decoration: none;
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .tech-partner-btn:hover {
            background: rgba(16, 185, 129, 0.16);
            border-color: rgba(16, 185, 129, 0.5);
            color: #ffffff !important;
            transform: translateY(-1px);
        }

        /* Solve IT Simple Text Credit Link */
        .footer-developer-credit {
            display: inline-flex;
            align-items: center;
            font-size: 0.82rem;
        }
        .footer-credit-text-link {
            color: rgba(255, 255, 255, 0.65);
            text-decoration: none;
            transition: color 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }
        .footer-credit-text-link:hover {
            color: #38bdf8;
        }
        .footer-credit-text-link span {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
            transition: color 0.2s ease;
        }
        .footer-credit-text-link:hover span {
            color: #38bdf8;
            text-decoration: underline;
        }
        @media (min-width: 992px) {
            .footer-bottom-bar {
                padding-right: 90px;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/swiper.min.js') }}"></script>
    <script src="{{ asset('js/turbo.js') }}"></script>

    {{-- Dynamic Schema.org JSON-LD --}}
    <script type="application/ld+json">
  {
    "{{ '@' }}context": "https://schema.org",
    "{{ '@' }}graph": [
      {
        "{{ '@' }}type": "Person",
        "{{ '@' }}id": "{{ url('/') }}/#person",
        "name": "{{ $profile->name_en ?? 'Dr. Abu Hanif Rakib' }}",
        "jobTitle": "{{ $profile->designation_en ?? 'Senior Consultant Medicine Specialist' }}",
        "telephone": "{{ $profile->hotline_phone ?? '+8801700000000' }}",
        "image": "{{ $profile->avatar ?? '' }}",
        "knowsAbout": ["Internal Medicine", "Diabetes Mellitus", "Hypertension", "Respiratory Diseases", "Thyroid Disorders"]
      },
      {
        "{{ '@' }}type": "Physician",
        "{{ '@' }}id": "{{ url('/') }}/#physician",
        "name": "{{ $profile->name_en ?? 'Dr. Abu Hanif Rakib' }}",
        "medicalSpecialty": "Internal Medicine",
        "image": "{{ $profile->avatar ?? '' }}",
        "telephone": "{{ $profile->hotline_phone ?? '+8801700000000' }}",
        "isAcceptingNewPatients": true,
        "priceRange": "{{ $profile->consultation_fee ?? 'BDT 1,200' }}"
      }
    ]
  }
  </script>

    <style id="i18n-anti-flash">
        html.i18n-pending body {
            visibility: hidden !important;
            opacity: 0 !important;
        }
    </style>

    {{-- Anti-Flash Script for Zero FOUC on Reload --}}
    <style id="i18n-anti-flash">
        html.i18n-pending body {
            visibility: hidden !important;
            opacity: 0 !important;
        }
    </style>
    <script>
        (function() {
            try {
                var saved = localStorage.getItem('dr_rakib_user_lang');
                var serverLocale = "{{ $locale ?? app()->getLocale() }}";
                if (saved && saved !== serverLocale) {
                    // If local storage has different lang than server, redirect to sync
                    window.location.replace("{{ url('/lang') }}/" + saved);
                }
            } catch (e) {}
        })();
    </script>
</head>

<body class="{{ ($locale ?? app()->getLocale()) === 'bn' ? 'lang-bn' : '' }}">

    {{-- Site Header --}}
    <header class="site-header fixed-top">
        <nav class="navbar navbar-expand-lg py-2 py-lg-3" aria-label="Primary Navigation">
            <div class="container navbar-container-responsive">
                <!-- Header Top Bar (Brand on left, Mobile togglers on right: ALWAYS 1 row) -->
                <div class="header-top-bar d-flex align-items-center justify-content-between">
                    <a class="navbar-brand d-flex align-items-center gap-2 gap-sm-3" href="{{ route('home') }}">
                        <div class="brand-avatar-badge">
                            <i class="bi bi-heart-pulse-fill"></i>
                        </div>
                        <div class="brand-text-block">
                            <div class="brand-title">
                                {{ ($locale ?? app()->getLocale()) === 'bn' ? $profile->name_bn ?? 'ডাঃ মোঃ আবু হানিফ রাকিব' : $profile->name_en ?? 'Dr. Abu Hanif Rakib' }}
                            </div>
                            <div class="brand-subtitle">
                                {{ ($locale ?? app()->getLocale()) === 'bn' ? $profile->designation_bn ?? 'মেডিসিন বিশেষজ্ঞ' : $profile->designation_en ?? 'Medicine Specialist' }}
                            </div>
                        </div>
                    </a>

                    <!-- Mobile Header Actions (Language Switcher + Hamburger Toggler) -->
                    <div class="d-flex align-items-center gap-2 d-lg-none mobile-header-actions">
                        <a href="{{ route('lang.switch', ($locale ?? app()->getLocale()) === 'bn' ? 'en' : 'bn') }}"
                            data-turbo="false"
                            class="btn btn-sm btn-outline-primary rounded-pill px-2 px-sm-3 py-1 d-flex align-items-center gap-1 nav-lang-toggle-btn"
                            aria-label="Toggle Language / ভাষা পরিবর্তন">
                            <i class="bi bi-translate"></i>
                            <span class="d-none d-sm-inline">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'English' : 'বাংলা' }}</span>
                            <span class="d-inline d-sm-none fw-bold" style="font-size: 0.72rem;">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'EN' : 'বাং' }}</span>
                        </a>
                        <button class="navbar-toggler border-0 shadow-none p-1" type="button" data-bs-toggle="collapse"
                            data-bs-target="#primaryNav" aria-controls="primaryNav" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <i class="bi bi-list fs-2 text-primary"></i>
                        </button>
                    </div>
                </div>

                <!-- Collapsible Navigation Menu (Expands DOWNWARDS directly below header) -->
                <div class="collapse navbar-collapse" id="primaryNav">
                    <div class="ms-auto my-3 my-lg-0">
                        <ul
                            class="navbar-nav nav-pill-container d-flex flex-column flex-lg-row align-items-stretch align-items-lg-center mb-0">
                            <li class="nav-item">
                                <a class="nav-link nav-pill-item {{ request()->routeIs('home') ? 'active' : '' }}"
                                    href="{{ route('home') }}">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'হোম' : 'Home' }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-pill-item {{ request()->routeIs('about') ? 'active' : '' }}"
                                    href="{{ route('about') }}">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'ডাক্তার পরিচিতি' : 'About Doctor' }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-pill-item {{ request()->routeIs('expertise') ? 'active' : '' }}"
                                    href="{{ route('expertise') }}">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'বিশেষজ্ঞ সেবা' : 'Clinical Expertise' }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-pill-item {{ request()->routeIs('chambers') ? 'active' : '' }}"
                                    href="{{ route('chambers') }}">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'চেম্বার ও সময়' : 'Chambers' }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-pill-item {{ request()->routeIs('blog') ? 'active' : '' }}"
                                    href="{{ route('blog') }}">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'স্বাস্থ্য পরামর্শ' : 'Health Articles' }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-pill-item {{ request()->routeIs('videos') ? 'active' : '' }}"
                                    href="{{ route('videos') }}">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'ভিডিও গাইড' : 'Video Guides' }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-pill-item {{ request()->routeIs('faq') ? 'active' : '' }}"
                                    href="{{ route('faq') }}">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'প্রশ্নোত্তর' : 'Patient Guide' }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Site Footer --}}
    <footer class="site-footer">
        <div class="site-footer-top-accent"></div>
        <div class="container">
            <div class="row g-4 g-lg-5 mb-5">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="footer-brand-badge">
                            <i class="bi bi-heart-pulse-fill"></i>
                        </div>
                        <div>
                            <div class="footer-brand-title">
                                {{ ($locale ?? app()->getLocale()) === 'bn' ? $profile->name_bn ?? '' : $profile->name_en ?? '' }}
                            </div>
                            <div class="footer-brand-subtitle">
                                {{ ($locale ?? app()->getLocale()) === 'bn' ? $profile->designation_bn ?? '' : $profile->designation_en ?? '' }}
                            </div>
                        </div>
                    </div>

                    @if (!empty($profile->bmdc_reg))
                    <div class="mb-3">
                        <span class="footer-badge-bmdc">
                            <i class="bi bi-patch-check-fill"></i>
                            <span>BMDC Reg: {{ $profile->bmdc_reg }}</span>
                        </span>
                    </div>
                    @endif

                    <p class="footer-bio-text mb-4 pe-lg-3">
                        {{ ($locale ?? app()->getLocale()) === 'bn' ? $profile->hero_bio_bn ?? '' : $profile->hero_bio_en ?? '' }}
                    </p>

                    <div class="d-flex gap-2">
                        @if (!empty($profile->facebook_url))
                            <a href="{{ $profile->facebook_url }}" target="_blank" rel="noopener noreferrer"
                                class="footer-social-btn" aria-label="Facebook Page"><i
                                    class="bi bi-facebook"></i></a>
                        @endif
                        @if (!empty($profile->youtube_url))
                            <a href="{{ $profile->youtube_url }}" target="_blank" rel="noopener noreferrer"
                                class="footer-social-btn" aria-label="YouTube Channel"><i
                                    class="bi bi-youtube"></i></a>
                        @endif
                        @if (!empty($profile->linkedin_url))
                            <a href="{{ $profile->linkedin_url }}" target="_blank" rel="noopener noreferrer"
                                class="footer-social-btn" aria-label="LinkedIn Profile"><i
                                    class="bi bi-linkedin"></i></a>
                        @endif
                        <a href="https://wa.me/{{ $profile->hotline_whatsapp ?? '8801700000000' }}" target="_blank"
                            rel="noopener noreferrer" class="footer-social-btn" aria-label="WhatsApp Assistant"><i
                                class="bi bi-whatsapp"></i></a>
                    </div>
                </div>

                <div class="col-6 col-md-3 col-lg-2">
                    <h3 class="footer-section-heading">
                        <span class="heading-accent-dot"></span>
                        <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'প্রয়োজনীয় লিংক' : 'Quick Links' }}</span>
                    </h3>
                    <ul class="list-unstyled mb-0 d-flex flex-column gap-2 footer-nav-list">
                        <li><a href="{{ route('home') }}"><i class="bi bi-chevron-right"></i> {{ ($locale ?? app()->getLocale()) === 'bn' ? 'হোম' : 'Home' }}</a></li>
                        <li><a href="{{ route('about') }}"><i class="bi bi-chevron-right"></i> {{ ($locale ?? app()->getLocale()) === 'bn' ? 'ডাক্তার পরিচিতি' : 'About Doctor' }}</a></li>
                        <li><a href="{{ route('expertise') }}"><i class="bi bi-chevron-right"></i> {{ ($locale ?? app()->getLocale()) === 'bn' ? 'চিকিৎসা সেবা' : 'Clinical Specialties' }}</a></li>
                        <li><a href="{{ route('chambers') }}"><i class="bi bi-chevron-right"></i> {{ ($locale ?? app()->getLocale()) === 'bn' ? 'চেম্বার ও সময়' : 'Chambers' }}</a></li>
                        <li><a href="{{ route('blog') }}"><i class="bi bi-chevron-right"></i> {{ ($locale ?? app()->getLocale()) === 'bn' ? 'স্বাস্থ্য পরামর্শ' : 'Health Articles' }}</a></li>
                        <li><a href="{{ route('videos') }}"><i class="bi bi-chevron-right"></i> {{ ($locale ?? app()->getLocale()) === 'bn' ? 'ভিডিও গাইড' : 'Video Guides' }}</a></li>
                        <li><a href="{{ route('booking') }}"><i class="bi bi-chevron-right"></i> {{ ($locale ?? app()->getLocale()) === 'bn' ? 'সিরিয়াল বুকিং' : 'Instant Booking' }}</a></li>
                        <li><a href="{{ route('faq') }}"><i class="bi bi-chevron-right"></i> {{ ($locale ?? app()->getLocale()) === 'bn' ? 'প্রশ্নোত্তর' : 'FAQ' }}</a></li>
                    </ul>
                </div>

                <div class="col-6 col-md-4 col-lg-3">
                    <h3 class="footer-section-heading">
                        <span class="heading-accent-dot"></span>
                        <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'চেম্বার হটলাইন' : 'Chamber Hotlines' }}</span>
                    </h3>
                    <div class="d-flex flex-column gap-2">
                        @foreach ($chambers as $ch)
                            <div class="footer-chamber-card">
                                <div class="chamber-card-name">{{ ($locale ?? app()->getLocale()) === 'bn' ? $ch->name_bn : $ch->name_en }}</div>
                                <a href="tel:{{ $ch->phone1 }}" class="chamber-card-phone">
                                    <i class="bi bi-telephone-fill"></i>
                                    <span>{{ $ch->phone1 }}</span>
                                </a>
                                <div class="chamber-card-schedule">
                                    <i class="bi bi-clock-history me-1"></i>
                                    <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? $ch->visiting_days_bn : $ch->visiting_days_en }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-3">
                    <h3 class="footer-section-heading">
                        <span class="heading-accent-dot"></span>
                        <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'জরুরি বিজ্ঞপ্তি' : 'Emergency Notice' }}</span>
                    </h3>
                    <div class="footer-emergency-box">
                        <div class="emergency-box-header">
                            <i class="bi bi-shield-exclamation"></i>
                            <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'জরুরি রোগীর ক্ষেত্রে' : 'Urgent Medical Cases' }}</span>
                        </div>
                        <p class="emergency-box-desc">
                            {{ ($locale ?? app()->getLocale()) === 'bn' ? $profile->emergency_notice_bn ?? '' : $profile->emergency_notice_en ?? '' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Minimalist Digital Partner Strip --}}
            <div class="footer-tech-partner-strip my-4 p-3 rounded-3">
                <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="tech-partner-icon">
                            <i class="bi bi-code-square"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <span class="tech-partner-name">Solve IT</span>
                                <span class="tech-partner-badge">
                                    <span class="partner-pulse-dot"></span>
                                    <span>IT & Web Solutions</span>
                                </span>
                            </div>
                            <div class="tech-partner-desc">
                                {{ ($locale ?? app()->getLocale()) === 'bn' 
                                    ? 'ক্লিনিক্যাল সফটওয়্যার, ডক্টর পোর্টাল ও কাস্টম ওয়েব অ্যাপ্লিকেশন ডেভেলপমেন্ট' 
                                    : 'Custom Web & Software Development, Clinical Portals & IT Solutions' }}
                            </div>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="https://solveitbd.com/" target="_blank" rel="noopener noreferrer" class="tech-partner-btn">
                            <span>solveitbd.com</span>
                            <i class="bi bi-arrow-up-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom-bar">
                <div class="footer-copyright">
                    © {{ date('Y') }} <strong>{{ ($locale ?? app()->getLocale()) === 'bn' ? $profile->name_bn ?? '' : $profile->name_en ?? '' }}</strong> | 
                    {{ ($locale ?? app()->getLocale()) === 'bn' 
                      ? ($profile->footer_copyright_bn ?: 'সর্বস্বত্ব সংরক্ষিত।') 
                      : ($profile->footer_copyright_en ?: 'All Rights Reserved.') }}
                </div>
                <div class="footer-developer-credit">
                    <a href="https://solveitbd.com/" target="_blank" rel="noopener noreferrer" class="footer-credit-text-link">
                        Developed by <span>Solve IT</span>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    {{-- Sticky Mobile Bar --}}
    <div class="sticky-mobile-bar" aria-label="Mobile Quick Contacts">
        <a href="tel:{{ $profile->hotline_phone ?? '+8801700000000' }}" class="btn-mobile-quick btn-mobile-call">
            <i class="bi bi-telephone-fill"></i>
            <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'কল করুন' : 'Call' }}</span>
        </a>
        <a href="https://wa.me/{{ $profile->hotline_whatsapp ?? '8801700000000' }}?text={{ urlencode('Hello ' . ($profile->name_en ?? 'Doctor')) }}"
            target="_blank" rel="noopener noreferrer" class="btn-mobile-quick btn-mobile-whatsapp">
            <i class="bi bi-whatsapp"></i>
            <span>WhatsApp</span>
        </a>
        <a href="{{ request()->routeIs('booking') ? '#bookingFormSection' : route('booking') }}"
            class="btn-mobile-quick btn-mobile-book">
            <i class="bi bi-calendar2-check-fill"></i>
            <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সিরিয়াল বুক' : 'Book Serial' }}</span>
        </a>
    </div>

    {{-- Floating Action Dock on Desktop --}}
    <div class="floating-action-dock d-none d-lg-flex" aria-label="Quick Actions">
        <div class="dock-btn-wrapper">
            <div class="dock-tooltip-pill">
                <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'Switch to English' : 'বাংলায় দেখুন' }}</span>
            </div>
            <a href="{{ route('lang.switch', ($locale ?? app()->getLocale()) === 'bn' ? 'en' : 'bn') }}"
                data-turbo="false"
                class="dock-action-btn" aria-label="Toggle Language">
                <i class="bi bi-translate"></i>
            </a>
        </div>

        <div class="dock-btn-wrapper">
            <div class="dock-tooltip-pill">
                <i class="bi bi-telephone-outbound-fill text-info me-1"></i>
                <span>{{ $profile->hotline_phone ?? '+880 1700-000000' }}</span>
            </div>
            <a href="tel:{{ $profile->hotline_phone ?? '+8801700000000' }}" class="dock-action-btn"
                aria-label="Call Hotline">
                <i class="bi bi-telephone-fill"></i>
            </a>
        </div>

        <div class="dock-btn-wrapper">
            <div class="dock-tooltip-pill">
                <i class="bi bi-lightning-charge-fill text-warning me-1"></i>
                <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সিরিয়াল বুকিং' : 'Instant Serial Booking' }}</span>
            </div>
            <div class="dock-pulse-wave"></div>
            <a href="{{ route('booking') }}" class="dock-action-btn dock-btn-appointment"
                aria-label="Book Instant Serial">
                <i class="bi bi-calendar2-check-fill"></i>
            </a>
        </div>
    </div>

    {{-- Video Player Modal --}}
    <div class="modal fade" id="videoPlayerModal" tabindex="-1" aria-labelledby="videoModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-video-dialog">
            <div class="modal-content modal-video-content">
                <div class="modal-header border-0 py-3 px-4 d-flex align-items-center justify-content-between"
                    style="background: #0d2847;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-play-circle-fill text-danger fs-5"></i>
                        <h5 class="modal-title text-white fw-bold fs-6 mb-0" id="videoModalTitle">
                            {{ ($locale ?? app()->getLocale()) === 'bn' ? ($profile->name_bn ?? '') . ' ভিডিও গাইড' : ($profile->name_en ?? '') . ' Video Guide' }}
                        </h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-video-aspect">
                    <iframe id="videoPlayerFrame" src="" title="Doctor Video Advice Player"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
                <div class="p-3 px-4 small border-top"
                    style="background: #071728; border-color: rgba(255,255,255,0.08) !important;">
                    <p class="mb-0 text-white-50" id="videoModalDesc">
                        {{ ($locale ?? app()->getLocale()) === 'bn' ? 'রোগী সচেতনতায় ' . ($profile->name_bn ?? '') . '-এর চিকিৎসা পরামর্শ।' : 'Official patient educational advice by ' . ($profile->name_en ?? '') . '.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function() {
            // Event delegation for video player modal triggers across all pages
            document.addEventListener('click', function(e) {
                var btn = e.target.closest('.js-play-video');
                if (!btn) return;
                e.preventDefault();
                var vidId = btn.getAttribute('data-video-id') || 'ScMzIvxBSi4';
                var title = btn.getAttribute('data-title');
                var desc = btn.getAttribute('data-desc');
                var videoPlayerFrame = document.getElementById('videoPlayerFrame');
                var videoModalTitle = document.getElementById('videoModalTitle');
                var videoModalDesc = document.getElementById('videoModalDesc');
                var videoModalEl = document.getElementById('videoPlayerModal');

                if (videoPlayerFrame) {
                    videoPlayerFrame.src = 'https://www.youtube-nocookie.com/embed/' + vidId + '?autoplay=1&rel=0';
                }
                if (videoModalTitle && title) {
                    videoModalTitle.textContent = title;
                }
                if (videoModalDesc && desc) {
                    videoModalDesc.textContent = desc;
                }
                if (videoModalEl && window.bootstrap) {
                    var bsModal = bootstrap.Modal.getInstance(videoModalEl) || new bootstrap.Modal(videoModalEl);
                    bsModal.show();
                }
            });

            // Cleanly pause video when modal is hidden
            document.addEventListener('hidden.bs.modal', function(e) {
                if (e.target && e.target.id === 'videoPlayerModal') {
                    var videoPlayerFrame = document.getElementById('videoPlayerFrame');
                    if (videoPlayerFrame) {
                        videoPlayerFrame.src = '';
                    }
                }
            });

            // Header sticky / fixed scroll effect
            function checkHeaderScroll() {
                var siteHeader = document.querySelector('.site-header');
                if (!siteHeader) return;
                if (window.scrollY > 15) {
                    siteHeader.classList.add('scrolled');
                } else {
                    siteHeader.classList.remove('scrolled');
                }
            }

            window.addEventListener('scroll', checkHeaderScroll, { passive: true });

            // Automatically close mobile navbar collapse before transitioning to a new page
            document.addEventListener('turbo:before-visit', function() {
                var primaryNav = document.getElementById('primaryNav');
                if (primaryNav && primaryNav.classList.contains('show') && window.bootstrap) {
                    var bsCollapse = bootstrap.Collapse.getInstance(primaryNav);
                    if (bsCollapse) {
                        bsCollapse.hide();
                    } else {
                        primaryNav.classList.remove('show');
                    }
                }
                var siteHeader = document.querySelector('.site-header');
                if (siteHeader) {
                    siteHeader.classList.remove('menu-open');
                }
            });

            // Initialize page state on initial load and every Turbo navigation
            function initAppPage() {
                checkHeaderScroll();

                var siteHeader = document.querySelector('.site-header');
                var primaryNav = document.getElementById('primaryNav');
                if (siteHeader && primaryNav && !primaryNav.dataset.turboNavBound) {
                    primaryNav.dataset.turboNavBound = 'true';
                    primaryNav.addEventListener('show.bs.collapse', function() {
                        siteHeader.classList.add('menu-open');
                    });
                    primaryNav.addEventListener('hide.bs.collapse', function() {
                        siteHeader.classList.remove('menu-open');
                    });
                }
            }

            document.addEventListener('DOMContentLoaded', initAppPage);
            document.addEventListener('turbo:load', initAppPage);
        })();
    </script>

    @yield('scripts')
</body>

</html>
