@extends('layouts.app')

@section('content')
    {{-- Hero Spotlight Section --}}
    <section id="home" class="hero-spotlight">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7 text-center text-lg-start">
                    <div
                        class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start gap-2 mb-3">
                        @if (!empty($profile->bmdc_reg))
                        <span class="badge-bmdc">
                            <i class="bi bi-patch-check-fill text-primary"></i>
                            <span>BMDC Reg No: {{ $profile->bmdc_reg }}</span>
                        </span>
                        @endif
                        <span class="badge-experience">
                            <i class="bi bi-award-fill"></i>
                            <span>{{ $profile->experience_years ?? '12+' }}
                                {{ ($locale ?? app()->getLocale()) === 'bn' ? 'বছরের চিকিৎসা অভিজ্ঞতা' : 'Years Clinical Excellence' }}</span>
                        </span>
                    </div>

                    <h1 class="hero-doctor-name">
                        {{ ($locale ?? app()->getLocale()) === 'bn' ? $profile->name_bn ?? 'ডাঃ মোঃ আবু হানিফ রাকিব' : $profile->name_en ?? 'Dr. Abu Hanif Rakib' }}
                    </h1>

                    <div class="fs-4 fw-semibold text-primary mb-3">
                        {{ ($locale ?? app()->getLocale()) === 'bn' ? $profile->designation_bn ?? 'কনসালট্যান্ট মেডিসিন বিশেষজ্ঞ' : $profile->designation_en ?? 'Senior Consultant & Medicine Specialist' }}
                    </div>

                    <p class="fs-5 text-muted mb-4 pe-lg-4" style="line-height: 1.7;">
                        {{ ($locale ?? app()->getLocale()) === 'bn' ? $profile->hero_bio_bn ?? 'আধুনিক চিকিৎসা বিজ্ঞান ও দীর্ঘদিনের ক্লিনিক্যাল অভিজ্ঞতার সমন্বয়ে ডায়াবেটিস, উচ্চ রক্তচাপ ও জটিল মেডিসিন রোগের নির্ভরযোগ্য চিকিৎসা।' : $profile->hero_bio_en ?? 'Providing authoritative, evidence-based diagnostic care and individualized treatment protocols for chronic, metabolic, and complex non-surgical conditions. Dedicated to clinical precision and patient dignity.' }}
                    </p>

                    <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start mb-5">
                        <a href="{{ route('booking') }}" class="btn btn-brand-primary">
                            <i class="bi bi-calendar2-plus-fill"></i>
                            <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সিরিয়াল বুকিং করুন' : 'Book Appointment / Serial' }}</span>
                        </a>
                        <a href="{{ route('chambers') }}" class="btn btn-brand-outline">
                            <i class="bi bi-geo-alt-fill text-primary"></i>
                            <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'চেম্বার ও সময়সূচী' : 'View Chambers & Schedule' }}</span>
                        </a>
                    </div>

                    <div class="row g-3 text-start">
                        <div class="col-6 col-md-4">
                            <div class="metric-box">
                                <div class="metric-number">{{ $profile->experience_years ?? '12+' }}</div>
                                <div class="text-muted small fw-semibold mt-1">
                                    {{ ($locale ?? app()->getLocale()) === 'bn'
                                        ? ($profile->experience_stat_label_bn ?:
                                            'বছরের ক্লিনিক্যাল অভিজ্ঞতা')
                                        : ($profile->experience_stat_label_en ?:
                                            'Years of Hospital Experience') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="metric-box">
                                <div class="metric-number text-success">
                                    {{ $profile->patients_count ?? ($profile->patients_treated ?? '25,000+') }}</div>
                                <div class="text-muted small fw-semibold mt-1">
                                    {{ ($locale ?? app()->getLocale()) === 'bn'
                                        ? ($profile->patients_stat_label_bn ?:
                                            'সফলভাবে সুস্থ হওয়া রোগী')
                                        : ($profile->patients_stat_label_en ?:
                                            'Patients Successfully Treated') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="metric-box">
                                <div class="metric-number" style="color: var(--accent);">
                                    {{ $profile->satisfaction_rate ?? '99.2%' }}</div>
                                <div class="text-muted small fw-semibold mt-1">
                                    {{ ($locale ?? app()->getLocale()) === 'bn'
                                        ? ($profile->satisfaction_stat_label_bn ?:
                                            'রোগীদের সন্তুষ্টি ও আস্থা')
                                        : ($profile->satisfaction_stat_label_en ?:
                                            'Patient Trust & Satisfaction') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="hero-doctor-showcase">
                        <div class="doctor-stage-card">
                            <div class="doctor-image-container">
                                <img src="{{ $profile->avatar ?? 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&crop=top&w=900&q=85' }}"
                                    alt="{{ $profile->name_en ?? 'Doctor Profile' }}" class="doctor-photo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- About Excerpt Section --}}
    <section id="about" class="py-5 section-transition-soft-white">
        <div class="container py-lg-4">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="section-eyebrow">
                        {{ ($locale ?? app()->getLocale()) === 'bn' ? 'ব্যক্তিগত পরিচিতি ও চিকিৎসা দর্শন' : 'Personal Biography & Philosophy' }}
                    </div>
                    <h2 class="section-headline mb-3">
                        {{ ($locale ?? app()->getLocale()) === 'bn' ? $profile->about_headline_bn ?? 'ধৈর্যশীল শ্রবণ ও তথ্যভিত্তিক যুক্তিসম্মত চিকিৎসা' : $profile->about_headline_en ?? 'Clinical Accuracy Built on Careful Listening & Rational Medicine' }}
                    </h2>
                    <p class="text-muted mb-4 pe-lg-3" style="line-height: 1.75; font-size: 1.02rem;">
                        {{ ($locale ?? app()->getLocale()) === 'bn' ? $profile->about_p1_bn ?? 'আধুনিক চিকিৎসা বিজ্ঞান ও ক্লিনিক্যাল অভিজ্ঞতার সমন্বয়ে রোগীদের নির্ভরযোগ্য ও তথ্যভিত্তিক স্বাস্থ্যসেবা প্রদানে নিবেদিতপ্রাণ।' : $profile->about_p1_en ?? 'Providing authoritative, evidence-based diagnostic care and individualized treatment protocols with extensive clinical practice.' }}
                    </p>
                    @if ($profile->about_p2_bn || $profile->about_p2_en)
                        <p class="text-muted mb-4 pe-lg-3" style="line-height: 1.75; font-size: 1.02rem;">
                            {{ ($locale ?? app()->getLocale()) === 'bn' ? $profile->about_p2_bn : $profile->about_p2_en }}
                        </p>
                    @endif

                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <div class="about-feature-box">
                                <div class="about-feature-icon-circle about-feature-icon-primary">
                                    <i class="bi bi-mortarboard-fill"></i>
                                </div>
                                <div>
                                    <div class="about-feature-title">
                                        {{ ($locale ?? app()->getLocale()) === 'bn' ? 'চিকিৎসা ডিগ্রি ও সনদ' : 'Medical Qualifications' }}
                                    </div>
                                    <div class="about-feature-desc">
                                        {{ ($locale ?? app()->getLocale()) === 'bn' ? $profile->degrees_bn ?? 'এমবিবিএস, এফসিপিএস' : $profile->degrees_en ?? 'MBBS, FCPS' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="about-feature-box">
                                <div class="about-feature-icon-circle about-feature-icon-emerald">
                                    <i class="bi bi-hospital-fill"></i>
                                </div>
                                <div>
                                    <div class="about-feature-title">
                                        {{ ($locale ?? app()->getLocale()) === 'bn' ? 'বর্তমান পদবী ও বিশেষজ্ঞতা' : 'Designation & Specialty' }}
                                    </div>
                                    <div class="about-feature-desc">
                                        {{ ($locale ?? app()->getLocale()) === 'bn' ? $profile->designation_bn ?? 'কনসালট্যান্ট স্পেশালিস্ট' : $profile->designation_en ?? 'Consultant Specialist' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        @if (!empty($profile->bmdc_reg))
                        <span class="about-affiliation-pill">
                            <i class="bi bi-patch-check-fill text-primary"></i>
                            <span>BMDC Reg: {{ $profile->bmdc_reg }}</span>
                        </span>
                        @endif
                        <span class="about-affiliation-pill">
                            <i class="bi bi-award-fill text-success"></i>
                            <span>{{ $profile->experience_years }}
                                {{ ($locale ?? app()->getLocale()) === 'bn' ? 'বছরের ক্লিনিক্যাল অভিজ্ঞতা' : 'Years Clinical Experience' }}</span>
                        </span>
                        <span class="about-affiliation-pill">
                            <i class="bi bi-people-fill text-info"></i>
                            <span>{{ $profile->patients_count }}
                                {{ ($locale ?? app()->getLocale()) === 'bn' ? 'রোগী সেবা' : 'Patients Consulted' }}</span>
                        </span>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="medical-credentials-card p-4 p-md-5">
                        <div class="d-flex align-items-center gap-3 mb-4 pb-2 border-bottom">
                            <div class="about-feature-icon-circle about-feature-icon-primary">
                                <i class="bi bi-award-fill"></i>
                            </div>
                            <div>
                                <h3 class="fs-4 fw-bold mb-0 brand-font text-primary">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'পেশাগত পরিচিতি ও যোগ্যতা' : 'Academic Track Record & Credentials' }}
                                </h3>
                                <div class="text-muted small">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'ক্লিনিক্যাল এক্সিলেন্স ও প্রাতিষ্ঠানিক সেবা' : 'Clinical Excellence & Professional Standing' }}
                                </div>
                            </div>
                        </div>

                        <div class="med-timeline">
                            <div class="med-timeline-item">
                                <div class="med-timeline-badge">
                                    <i class="bi bi-hospital-fill"></i>
                                </div>
                                <div class="med-timeline-content">
                                    <div class="med-timeline-title">
                                        {{ ($locale ?? app()->getLocale()) === 'bn' ? $profile->academic_post1_bn ?? $profile->designation_bn : $profile->academic_post1_en ?? $profile->designation_en }}
                                    </div>
                                    <div class="med-timeline-meta">
                                        <span class="med-timeline-org"><i class="bi bi-geo-alt-fill text-primary"></i>
                                            {{ ($locale ?? app()->getLocale()) === 'bn' ? $profile->academic_desc1_bn ?? $profile->designation_bn : $profile->academic_desc1_en ?? $profile->designation_en }}</span>
                                        <span class="med-timeline-year current"><i class="bi bi-clock-history me-1"></i>
                                            {{ ($locale ?? app()->getLocale()) === 'bn' ? 'বর্তমান' : 'Active / Present' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="med-timeline-item">
                                <div class="med-timeline-badge">
                                    <i class="bi bi-patch-check-fill text-success"></i>
                                </div>
                                <div class="med-timeline-content">
                                    <div class="med-timeline-title">
                                        {{ ($locale ?? app()->getLocale()) === 'bn' ? 'চিকিৎসা ডিগ্রি ও উচ্চতর সনদ' : 'Medical Degrees & Certifications' }}
                                    </div>
                                    <div class="med-timeline-meta">
                                        <span class="med-timeline-org"><i class="bi bi-award-fill text-success"></i>
                                            {{ ($locale ?? app()->getLocale()) === 'bn' ? $profile->degrees_bn : $profile->degrees_en }}</span>
                                    </div>
                                </div>
                            </div>

                            @if (!empty($profile->bmdc_reg))
                            <div class="med-timeline-item">
                                <div class="med-timeline-badge">
                                    <i class="bi bi-shield-fill-check text-primary"></i>
                                </div>
                                <div class="med-timeline-content">
                                    <div class="med-timeline-title">
                                        {{ ($locale ?? app()->getLocale()) === 'bn' ? 'সরকারি বিএমডিসি সনদ' : 'Official BMDC Registration' }}
                                    </div>
                                    <div class="med-timeline-meta">
                                        <span class="med-timeline-org"><i class="bi bi-patch-check-fill text-primary"></i>
                                            Reg No: {{ $profile->bmdc_reg }}</span>
                                        <span class="med-timeline-year"><i class="bi bi-check-circle-fill me-1"></i>
                                            {{ ($locale ?? app()->getLocale()) === 'bn' ? 'ভেরিফাইড' : 'Verified' }}</span>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="med-timeline-item">
                                <div class="med-timeline-badge">
                                    <i class="bi bi-person-workspace text-info"></i>
                                </div>
                                <div class="med-timeline-content">
                                    <div class="med-timeline-title">
                                        {{ ($locale ?? app()->getLocale()) === 'bn' ? 'ক্লিনিক্যাল সেবা ও কনসালটেন্সি' : 'Clinical Consultations & Experience' }}
                                    </div>
                                    <div class="med-timeline-meta">
                                        <span class="med-timeline-org"><i
                                                class="bi bi-calendar2-check-fill text-info"></i>
                                            {{ $profile->experience_years }}
                                            {{ ($locale ?? app()->getLocale()) === 'bn' ? 'বছরের অভিজ্ঞতা' : 'Years Experience' }}
                                            • {{ $profile->patients_count }}
                                            {{ ($locale ?? app()->getLocale()) === 'bn' ? 'রোগী সেবা' : 'Patients' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- International Projects & Global Collaborations Section --}}
    @if (isset($internationalProjects) && count($internationalProjects) > 0)
        <section id="international-projects" class="py-5">
            <div class="container py-lg-4">
                <div class="text-center max-w-700 mx-auto mb-5">
                    <div class="section-eyebrow">
                        {{ ($locale ?? app()->getLocale()) === 'bn' ? 'আন্তর্জাতিক অভিজ্ঞতা ও গবেষণা' : 'Global Research & Collaborations' }}
                    </div>
                    <h2 class="section-headline">
                        {{ ($locale ?? app()->getLocale()) === 'bn' ? 'আন্তর্জাতিক গবেষণা ও বৈশ্বিক স্বাস্থ্য প্রকল্প' : 'International Projects & Clinical Trials' }}
                    </h2>
                    <p class="mx-auto text-muted" style="max-width: 650px;">
                        {{ ($locale ?? app()->getLocale()) === 'bn' ? 'বিশ্ব স্বাস্থ্য সংস্থা (WHO), অক্সফোর্ড রিসার্চ নেটওয়ার্ক ও আন্তর্জাতিক চিকিৎসা সংস্থার সাথে পরিচালিত গবেষণা প্রকল্পসমূহ।' : 'Collaborative clinical trials, observational epidemiologic registries, and global health research initiatives conducted with international institutions.' }}
                    </p>
                </div>

                <div class="row g-4 align-items-stretch">
                    @foreach ($internationalProjects as $project)
                        <div class="col-lg-4 col-md-6 d-flex">
                            <div class="international-project-card w-100 d-flex flex-column">
                                <div class="international-project-header">
                                    <div class="international-project-icon-box">
                                        <i class="bi {{ $project->icon ?? 'bi-globe-americas' }}"></i>
                                    </div>
                                    <div class="international-project-badges">
                                        <span class="project-pill-category">
                                            {{ $project->category }}
                                        </span>
                                        @if ($project->badge_text)
                                            <span class="project-pill-sponsor">
                                                <i class="bi bi-patch-check-fill me-1"></i>{{ $project->badge_text }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <h3 class="international-project-title">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? $project->title_bn : $project->title_en }}
                                </h3>

                                <div class="international-project-meta-box">
                                    <div class="project-meta-row org-row">
                                        <span class="meta-icon-bubble"><i class="bi bi-buildings-fill"></i></span>
                                        <span class="meta-text text-dark fw-bold">{{ $project->organization }}</span>
                                    </div>
                                    <div class="project-meta-row role-row">
                                        <span class="meta-icon-bubble role-bubble"><i
                                                class="bi bi-person-workspace"></i></span>
                                        <div class="meta-text d-flex flex-wrap align-items-center gap-1.5">
                                            <span
                                                class="fw-semibold text-secondary">{{ ($locale ?? app()->getLocale()) === 'bn' ? $project->role_bn : $project->role_en }}</span>
                                            @if ($project->country_or_location)
                                                <span class="project-location-tag">
                                                    <i class="bi bi-geo-alt-fill"></i>{{ $project->country_or_location }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <p class="international-project-desc">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? $project->description_bn : $project->description_en }}
                                </p>

                                <div class="international-project-footer">
                                    @if ($project->duration)
                                        <span class="project-duration-badge">
                                            <i class="bi bi-calendar2-range"></i>
                                            <span>{{ $project->duration }}</span>
                                        </span>
                                    @else
                                        <span></span>
                                    @endif
                                    @if ($project->project_url)
                                        <a href="{{ $project->project_url }}" target="_blank" rel="noopener noreferrer"
                                            class="project-explore-btn">
                                            <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'বিস্তারিত দেখুন' : 'Explore Link' }}</span>
                                            <i class="bi bi-arrow-up-right"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Clinical Specialties Grid --}}
    <section id="expertise" class="py-5 section-transition-soft-slate">
        <div class="container py-lg-4">
            <div class="text-center max-w-700 mx-auto mb-5">
                <div class="section-eyebrow">
                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'বিশেষজ্ঞ চিকিৎসা সেবা' : 'Core Clinical Solutions' }}
                </div>
                <h2 class="section-headline">
                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'জটিল রোগের কার্যকরী চিকিৎসা প্রোটোকল' : 'Proven Protocols for Complex Conditions' }}
                </h2>
                <p class="mx-auto" style="max-width: 620px;">
                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'প্রতিটি রোগীর জন্য সুনির্দিষ্ট পর্যবেক্ষণ ও দীর্ঘমেয়াদী সুস্থতার সমন্বিত চিকিৎসা পরিকল্পনা।' : 'Dedicated, systematic medical management focused on long-term disease remission and organ preservation.' }}
                </p>
            </div>

            <div class="row g-4">
                @foreach ($specialties as $sp)
                    <div class="col-md-6 col-lg-4">
                        <article class="glass-card p-4 h-100">
                            <div class="clinical-icon clinical-icon-blue mb-3">
                                <i class="bi {{ $sp->icon ?? 'bi-heart-pulse-fill' }}"></i>
                            </div>
                            <h3 class="fs-5 fw-bold mb-2">
                                {{ ($locale ?? app()->getLocale()) === 'bn' ? $sp->title_bn : $sp->title_en }}</h3>
                            <p class="small text-muted mb-3">
                                {{ ($locale ?? app()->getLocale()) === 'bn' ? $sp->description_bn : $sp->description_en }}
                            </p>
                            @if (!empty($sp->tags))
                                <div class="border-top pt-3">
                                    @foreach (explode(',', $sp->tags) as $tag)
                                        <span class="badge bg-light text-primary border small">{{ trim($tag) }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Chambers Section --}}
    <section id="chambers" class="py-5 section-transition-soft-white">
        <div class="container py-lg-4">
            <div class="text-center max-w-700 mx-auto mb-5">
                <div class="section-eyebrow">
                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'চেম্বার ও সময়সূচী' : 'Visiting Schedule' }}</div>
                <h2 class="section-headline">
                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'চেম্বার লোকেশন ও সিরিয়াল হটলাইন' : 'Consultation Chambers & Direct Serials' }}
                </h2>
                <p class="mx-auto" style="max-width: 600px;">
                    {{ ($locale ?? app()->getLocale()) === 'bn' ? ($profile->name_bn ?? 'ডাক্তার') . ' ঢাকার স্বনামধন্য সেন্টারে নিয়মিত রোগী দেখেন।' : 'Consult with ' . ($profile->name_en ?? 'the specialist') . ' at premier medical diagnostic centers. Select your preferred chamber to secure a serial.' }}
                </p>
            </div>

            <div class="row g-4 justify-content-center">
                @foreach ($chambers as $index => $ch)
                    <div class="col-lg-6">
                        <article class="chamber-card {{ $index === 0 ? 'featured' : '' }}">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                                <span
                                    class="badge {{ $index === 0 ? 'bg-primary text-white' : 'bg-secondary-subtle text-dark' }} px-3 py-2 rounded-pill fw-semibold">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? ($index === 0 ? 'প্রধান চেম্বার' : 'সান্ধ্যকালীন চেম্বার') : ($index === 0 ? 'Primary Center' : 'Evening Center') }}
                                </span>
                                <div class="fs-5 fw-bold text-primary">
                                    <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'ভিজিট ফি: ' . ($ch->fee ?: ($ch->consultation_fee ?: ($profile->consultation_fee ?: 'BDT 1,200'))) : 'Fee: ' . ($ch->fee ?: ($ch->consultation_fee ?: ($profile->consultation_fee ?: 'BDT 1,200'))) }}</span>
                                </div>
                            </div>

                            <h3 class="fs-4 fw-bold mb-1">
                                {{ ($locale ?? app()->getLocale()) === 'bn' ? $ch->name_bn : $ch->name_en }}</h3>
                            <p class="text-muted small mb-3"><i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? $ch->address_bn : $ch->address_en }}</span>
                            </p>

                            <div class="p-3 rounded-3 mb-4"
                                style="background-color: var(--bg-slate); border: 1px solid var(--border-color);">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="small text-muted fw-semibold">
                                            {{ ($locale ?? app()->getLocale()) === 'bn' ? 'রোগী দেখার দিন' : 'Visiting Days' }}
                                        </div>
                                        <div class="fw-bold text-dark">
                                            {{ ($locale ?? app()->getLocale()) === 'bn' ? $ch->visiting_days_bn : $ch->visiting_days_en }}
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="small text-muted fw-semibold">
                                            {{ ($locale ?? app()->getLocale()) === 'bn' ? 'রোগী দেখার সময়' : 'Visiting Hours' }}
                                        </div>
                                        <div class="fw-bold text-primary">
                                            {{ ($locale ?? app()->getLocale()) === 'bn' ? $ch->visiting_hours_bn : $ch->visiting_hours_en }}
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2 pt-2 border-top">
                                        <div class="small text-muted">
                                            <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সাপ্তাহিক বন্ধ:' : 'Weekly Off:' }}</span>
                                            <span
                                                class="text-danger fw-semibold">{{ ($locale ?? app()->getLocale()) === 'bn' ? $ch->weekly_off_bn ?? 'ছুটির দিন' : $ch->weekly_off_en ?? 'Off Days' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2 mb-4">
                                <a href="tel:{{ $ch->phone1 }}"
                                    class="btn btn-brand-primary flex-grow-1 justify-content-center py-2">
                                    <i class="bi bi-telephone-outbound-fill"></i>
                                    <span>{{ $ch->phone1 }}</span>
                                </a>
                                @if (!empty($ch->map_url))
                                    <a href="{{ $ch->map_url }}" target="_blank" rel="noopener noreferrer"
                                        class="btn btn-brand-outline py-2">
                                        <i class="bi bi-compass"></i>
                                        <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'ম্যাপ' : 'Map' }}</span>
                                    </a>
                                @endif
                            </div>

                            <div class="small text-muted d-flex align-items-center gap-2">
                                <i class="bi bi-check2-circle text-success fs-5"></i>
                                <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? $ch->notes_bn : $ch->notes_en }}</span>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Video Guides Section --}}
    <section id="videos" class="py-5 section-transition-soft-slate">
        <div class="container py-lg-4">
            <div class="text-center max-w-700 mx-auto mb-5">
                <div class="section-eyebrow">
                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'ভিডিও স্বাস্থ্য পরামর্শ' : 'Patient Education & Video Guides' }}
                </div>
                <h2 class="section-headline">
                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'ডাক্তারের প্রয়োজনীয় স্বাস্থ্য নির্দেশিকা' : "Clinical Health Tips & Doctor's Advice" }}
                </h2>
                <p class="mx-auto" style="max-width: 620px;">
                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'বিভিন্ন রোগ প্রতিরোধ ও সঠিক পথ্য নিয়ে ' . ($profile->name_bn ?? 'ডাক্তার') . '-এর ভিডিও পরামর্শ দেখুন।' : 'Watch ' . ($profile->name_en ?? 'the specialist') . ' discuss prevention, symptom management, and rational medical treatment directly on this website.' }}
                </p>
            </div>

            <div class="row g-4">
                @foreach ($videos as $vid)
                    <div class="col-md-6 col-lg-4">
                        <div class="video-card">
                            <div class="video-thumb-container js-play-video"
                                data-video-id="{{ $vid->youtube_id ?? ($vid->youtube_video_id ?? 'ScMzIvxBSi4') }}"
                                data-title="{{ ($locale ?? app()->getLocale()) === 'bn' ? $vid->title_bn : $vid->title_en }}"
                                data-desc="{{ ($locale ?? app()->getLocale()) === 'bn' ? $vid->description_bn : $vid->description_en }}"
                                role="button" tabindex="0">
                                <img src="{{ $vid->thumbnail ?? ($vid->thumbnail_url ?? 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=800&q=80') }}"
                                    alt="{{ $vid->title_en }}" class="video-thumb-img" loading="lazy">
                                <div class="video-play-btn-circle">
                                    <i class="bi bi-play-fill"></i>
                                </div>
                                @if (!empty($vid->duration))
                                    <span class="video-duration-tag"><i
                                            class="bi bi-clock me-1"></i>{{ $vid->duration }}</span>
                                @endif
                            </div>
                            <div class="p-4 d-flex flex-column justify-content-between flex-grow-1">
                                <div>
                                    <div class="d-flex align-items-center gap-2 text-danger small fw-bold mb-2">
                                        <i class="bi bi-youtube fs-6"></i>
                                        <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? $vid->category : $vid->category }}</span>
                                    </div>
                                    <h3 class="fs-5 fw-bold mb-2 text-dark">
                                        {{ ($locale ?? app()->getLocale()) === 'bn' ? $vid->title_bn : $vid->title_en }}
                                    </h3>
                                    <p class="small text-muted mb-3">
                                        {{ ($locale ?? app()->getLocale()) === 'bn' ? $vid->description_bn : $vid->description_en }}
                                    </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                                    <button type="button"
                                        class="btn btn-sm btn-danger rounded-pill px-3 py-1 js-play-video"
                                        data-video-id="{{ $vid->youtube_id ?? ($vid->youtube_video_id ?? 'ScMzIvxBSi4') }}"
                                        data-title="{{ ($locale ?? app()->getLocale()) === 'bn' ? $vid->title_bn : $vid->title_en }}"
                                        data-desc="{{ ($locale ?? app()->getLocale()) === 'bn' ? $vid->description_bn : $vid->description_en }}">
                                        <i class="bi bi-play-circle me-1"></i>
                                        <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'প্লে করুন' : 'Play Inside' }}</span>
                                    </button>
                                    <span class="badge bg-light text-secondary border small">{{ $vid->category }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('videos') }}" class="btn btn-brand-primary px-4 py-3">
                    <i class="bi bi-play-btn-fill me-2"></i>
                    <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সকল ভিডিও দেখুন' : 'View All Video Guides' }}</span>
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- Health Articles Section --}}
    <section id="articles" class="py-5 section-transition-soft-white">
        <div class="container py-lg-4">
            <div class="text-center max-w-700 mx-auto mb-5">
                <div class="section-eyebrow">
                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'স্বাস্থ্য পরামর্শ ও কলাম' : 'Medical Insights & Writings' }}
                </div>
                <h2 class="section-headline">
                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'ডাক্তারের তথ্যবহুল স্বাস্থ্য প্রবন্ধ' : 'Articles & Clinical Columns' }}
                </h2>
                <p class="mx-auto" style="max-width: 620px;">
                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'জনসচেতনতা বৃদ্ধি এবং সঠিক জীবনযাপন সংক্রান্ত তথ্যবহুল লেখালেখি।' : 'Educational articles and health columns written by ' . ($profile->name_en ?? 'the specialist') . ' to foster public health literacy.' }}
                </p>
            </div>

            <div class="row g-4">
                @foreach ($articles as $art)
                    <div class="col-md-6 col-lg-4">
                        <article class="article-card">
                            <div class="article-img-wrap">
                                <img src="{{ $art->featured_image ?? 'https://images.unsplash.com/photo-1505751172876-fa1923c5c528?auto=format&fit=crop&w=800&q=80' }}"
                                    alt="{{ $art->title_en }}" loading="lazy">
                                <span class="article-tag">{{ $art->category }}</span>
                            </div>
                            <div class="p-4 d-flex flex-column justify-content-between flex-grow-1">
                                <div>
                                    <div class="small text-muted mb-2"><i class="bi bi-calendar3 me-1"></i>
                                        {{ date('F Y', strtotime($art->published_at ?? $art->created_at)) }} •
                                        {{ $art->read_time_minutes ?? '5' }} min read</div>
                                    <h3 class="fs-5 fw-bold mb-2 text-dark">
                                        {{ ($locale ?? app()->getLocale()) === 'bn' ? $art->title_bn : $art->title_en }}
                                    </h3>
                                    <p class="small text-muted mb-3">
                                        {{ ($locale ?? app()->getLocale()) === 'bn' ? $art->excerpt_bn : $art->excerpt_en }}
                                    </p>
                                </div>
                                <div class="pt-3 border-top d-flex align-items-center justify-content-between">
                                    <a href="{{ route('blog') }}" class="text-primary fw-bold small">
                                        <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সম্পূর্ণ পড়ুন' : 'Read Full Column' }}</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                    <span class="badge bg-light text-secondary border small">{{ $art->category }}</span>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('blog') }}" class="btn btn-brand-primary px-4 py-3">
                    <i class="bi bi-journal-text me-2"></i>
                    <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সকল স্বাস্থ্য পরামর্শ দেখুন' : 'View All Health Articles' }}</span>
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- Booking Form Section --}}
    <section id="booking" class="py-5 section-transition-booking">
        <div class="container py-lg-4">
            <div class="row g-5 align-items-center justify-content-center">
                <div class="col-lg-5">
                    <div class="section-eyebrow">
                        {{ ($locale ?? app()->getLocale()) === 'bn' ? 'সিরিয়াল বুকিং' : 'Instant Reservation' }}</div>
                    <h2 class="section-headline">
                        {{ ($locale ?? app()->getLocale()) === 'bn' ? 'সহজেই ডাক্তারের সিরিয়াল নিশ্চিত করুন' : 'Priority Consultation Booking' }}
                    </h2>
                    <p class="text-muted mb-4">
                        {{ ($locale ?? app()->getLocale()) === 'bn' ? 'ফর্ম পূরণ করে সাবমিট করুন। আমাদের প্রতিনিধি আপনার সাথে যোগাযোগ করে দ্রুত সিরিয়াল নিশ্চিত করবেন।' : 'Fast verification and direct serial confirmation with chamber staff. Fill in your details below to secure your consultation appointment.' }}
                    </p>

                    <div class="d-flex flex-column gap-3 mb-4">
                        <div class="d-flex align-items-start gap-3">
                            <div class="clinical-icon clinical-icon-emerald flex-shrink-0"
                                style="width: 42px; height: 42px;">
                                <i class="bi bi-lightning-charge-fill"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'ইনস্ট্যান্ট মোবাইল এসএমএস ও কনফার্মেশন' : 'Instant Mobile Confirmation' }}
                                </div>
                                <div class="text-muted small">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'আপনার মোবাইল নম্বরে সিরিয়াল ট্র্যাকিং আইডি ও সম্ভাব্য সময় পৌঁছাবে।' : 'Receive serial number and estimated arrival time directly on your phone.' }}
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3">
                            <div class="clinical-icon clinical-icon-blue flex-shrink-0"
                                style="width: 42px; height: 42px;">
                                <i class="bi bi-shield-lock-fill"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'অগ্রিম কোনো পেমেন্ট লাগবে না' : 'Zero Upfront Payment Required' }}
                                </div>
                                <div class="text-muted small">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'পরামর্শ ফি (৳১,২০০) চেম্বারে এসে কাউন্টারে প্রদান করবেন।' : 'Consultation fee (BDT 1,200) is paid on-site at the chamber reception counter.' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 rounded-3" style="background-color: #FEF2F2; border: 1px solid #FEE2E2;">
                        <div class="d-flex align-items-center gap-2 text-danger fw-bold small">
                            <i class="bi bi-exclamation-octagon-fill"></i>
                            <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'জরুরি রোগীর ক্ষেত্রে সতর্কতা' : 'Medical Emergency Warning' }}</span>
                        </div>
                        <p class="small text-muted mt-1 mb-0">
                            {{ ($locale ?? app()->getLocale()) === 'bn' ? $profile->emergency_notice_bn ?? 'অতিরিক্ত বুকে ব্যথা, তীব্র শ্বাসকষ্ট বা প্যারালাইসিস সংক্রান্ত উপসর্গের ক্ষেত্রে অবিলম্বে নিকটস্থ জরুরি বিভাগে যোগাযোগ করুন।' : $profile->emergency_notice_en ?? 'For severe chest pain, acute breathlessness, or signs of acute stroke, please visit the nearest hospital emergency department immediately or dial 999.' }}
                        </p>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="frictionless-booking-card p-4 p-md-5">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <h3 class="fs-4 fw-bold mb-0 brand-font text-primary">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'সিরিয়াল বুকিং ফর্ম' : 'Quick Appointment Form' }}
                                </h3>
                                <div class="text-muted small">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'সহজ ২-ধাপ • দ্রুত সিরিয়াল প্রসেসিং' : 'Priority Chamber Queue • Fast 2-Step' }}
                                </div>
                            </div>
                            <span
                                class="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সিরিয়াল চালু আছে' : 'Open For Serials' }}</span>
                        </div>

                        @if (session('success_serial'))
                            <div class="alert alert-success d-flex align-items-center gap-3 mb-4" role="alert">
                                <i class="bi bi-check-circle-fill fs-3 text-success flex-shrink-0"></i>
                                <div>
                                    <div class="fw-bold fs-6">
                                        {{ ($locale ?? app()->getLocale()) === 'bn' ? 'সিরিয়াল নিশ্চিত হয়েছে!' : 'Serial Request Confirmed!' }}
                                    </div>
                                    <div class="small">{{ session('success_serial')['message'] }}</div>
                                </div>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul class="mb-0 small">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data"
                            aria-label="Priority Doctor Consultation Booking" data-turbo="false">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="fullName"
                                        class="form-label">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'রোগীর পূর্ণ নাম' : 'Patient Name' }}
                                        <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="fullName" name="patient_name"
                                        value="{{ old('patient_name') }}"
                                        placeholder="{{ ($locale ?? app()->getLocale()) === 'bn' ? 'উদাঃ মোঃ কামাল উদ্দিন' : 'e.g. Mohammad Hossain' }}"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <label for="phoneNumber"
                                        class="form-label">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'মোবাইল নম্বর' : 'Mobile Number' }}
                                        <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" id="phoneNumber" name="patient_phone"
                                        value="{{ old('patient_phone') }}" placeholder="017XXXXXXXX" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="selectedChamber"
                                        class="form-label">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'কাঙ্ক্ষিত চেম্বার' : 'Select Chamber' }}
                                        <span class="text-danger">*</span></label>
                                    <select class="form-select" id="selectedChamber" name="chamber" required>
                                        @foreach ($chambers as $ch)
                                            <option value="{{ $ch->slug }}"
                                                {{ old('chamber') == $ch->slug ? 'selected' : '' }}>
                                                {{ ($locale ?? app()->getLocale()) === 'bn' ? $ch->name_bn : $ch->name_en }}
                                                ({{ ($locale ?? app()->getLocale()) === 'bn' ? $ch->visiting_days_bn : $ch->visiting_days_en }}
                                                —
                                                {{ ($locale ?? app()->getLocale()) === 'bn' ? 'ফি: ' . ($ch->fee ?? $profile->consultation_fee) : 'Fee: ' . ($ch->fee ?? $profile->consultation_fee) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="consultationDate"
                                        class="form-label">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'পরামর্শের তারিখ' : 'Preferred Date' }}
                                        <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="consultationDate"
                                        name="preferred_date" value="{{ old('preferred_date', date('Y-m-d')) }}"
                                        min="{{ date('Y-m-d') }}" required>
                                </div>

                                <div class="col-12 mt-3">
                                    <button class="clinical-collapse-btn" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#clinicalDetailsCollapse" aria-expanded="false"
                                        aria-controls="clinicalDetailsCollapse">
                                        <span class="d-flex align-items-center gap-2">
                                            <i class="bi bi-file-earmark-medical-fill text-accent"></i>
                                            <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'চিকিৎসা সংক্রান্ত অতিরিক্ত তথ্য (ঐচ্ছিক)' : 'Add Clinical Details (Optional)' }}</span>
                                        </span>
                                        <i class="bi bi-chevron-down collapse-chevron"></i>
                                    </button>

                                    <div class="collapse" id="clinicalDetailsCollapse">
                                        <div class="clinical-collapse-card mt-2">
                                            <div class="row g-3">
                                                <div class="col-6 col-md-4">
                                                    <label for="age"
                                                        class="form-label">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'বয়স' : 'Age' }}</label>
                                                    <input type="number" class="form-control" id="age"
                                                        name="patient_age" value="{{ old('patient_age') }}"
                                                        placeholder="45" min="1" max="120">
                                                </div>

                                                <div class="col-6 col-md-4">
                                                    <label for="gender"
                                                        class="form-label">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'লিঙ্গ' : 'Gender' }}</label>
                                                    <select class="form-select" id="gender" name="patient_gender">
                                                        <option value="male"
                                                            {{ old('patient_gender') == 'male' ? 'selected' : '' }}>
                                                            {{ ($locale ?? app()->getLocale()) === 'bn' ? 'পুরুষ' : 'Male' }}
                                                        </option>
                                                        <option value="female"
                                                            {{ old('patient_gender') == 'female' ? 'selected' : '' }}>
                                                            {{ ($locale ?? app()->getLocale()) === 'bn' ? 'মহিলা' : 'Female' }}
                                                        </option>
                                                        <option value="other"
                                                            {{ old('patient_gender') == 'other' ? 'selected' : '' }}>
                                                            {{ ($locale ?? app()->getLocale()) === 'bn' ? 'অন্যান্য' : 'Other' }}
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="visitCategory"
                                                        class="form-label">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'ভিজিটের ধরণ' : 'Visit Type' }}</label>
                                                    <select class="form-select" id="visitCategory" name="visit_type">
                                                        <option value="new"
                                                            {{ old('visit_type') == 'new' ? 'selected' : '' }}>
                                                            {{ ($locale ?? app()->getLocale()) === 'bn' ? 'নতুন রোগী' : 'New Consultation' }}
                                                        </option>
                                                        <option value="followup"
                                                            {{ old('visit_type') == 'followup' ? 'selected' : '' }}>
                                                            {{ ($locale ?? app()->getLocale()) === 'bn' ? 'পুরাতন ফলোআপ' : 'Follow-Up' }}
                                                        </option>
                                                        <option value="report"
                                                            {{ old('visit_type') == 'report' ? 'selected' : '' }}>
                                                            {{ ($locale ?? app()->getLocale()) === 'bn' ? 'রিপোর্ট দেখানো' : 'Report Evaluation' }}
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="col-12">
                                                    <label for="medicalIssue"
                                                        class="form-label">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'প্রধান সমস্যা বা উপসর্গ' : 'Primary Symptoms / Reason for Visit' }}</label>
                                                    <textarea class="form-control" id="medicalIssue" name="symptoms_summary" rows="2"
                                                        placeholder="{{ ($locale ?? app()->getLocale()) === 'bn' ? 'আপনার মূল সমস্যা সংক্ষেপে লিখুন (উদাঃ অনিয়ন্ত্রিত সুগার, উচ্চ রক্তচাপ, ৪ দিনের জ্বর...)' : 'Briefly describe your symptoms (e.g. Uncontrolled diabetes, high BP, fever for 4 days...)' }}">{{ old('symptoms_summary') }}</textarea>
                                                </div>

                                                <div class="col-12">
                                                    <label
                                                        class="form-label d-flex align-items-center justify-content-between">
                                                        <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'পূর্বের প্রেসক্রিপশন বা টেস্ট রিপোর্ট আপলোড' : 'Attach Previous Prescriptions / Lab Reports' }}</span>
                                                        <span
                                                            class="badge bg-light text-secondary border fw-normal">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'ঐচ্ছিক' : 'Optional' }}</span>
                                                    </label>
                                                    <div class="medical-upload-area" id="medicalUploadArea">
                                                        <input type="file" class="medical-upload-input"
                                                            id="reportFiles" name="medical_reports[]" multiple
                                                            accept=".pdf,.jpg,.jpeg,.png">
                                                        <div class="upload-icon-circle">
                                                            <i class="bi bi-cloud-arrow-up-fill"></i>
                                                        </div>
                                                        <div class="fw-bold text-dark small">
                                                            {{ ($locale ?? app()->getLocale()) === 'bn' ? 'ফাইল সিলেক্ট করতে ক্লিক করুন অথবা টেনে আনুন' : 'Click to browse or drag & drop reports here' }}
                                                        </div>
                                                        <div class="text-muted" style="font-size: 0.76rem;">PDF, JPG, PNG
                                                            (Max 15MB)</div>
                                                        <div class="upload-file-status" id="uploadStatus"
                                                            style="display: none;">
                                                            <i class="bi bi-file-earmark-check-fill"></i>
                                                            <span id="uploadFileName">No file selected</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="termsCheck" required checked>
                                        <label class="form-check-label small text-muted" for="termsCheck">
                                            {{ ($locale ?? app()->getLocale()) === 'bn' ? 'আমি সিরিয়াল সংক্রান্ত তথ্য ও রিমাইন্ডার এসএমএস মোবাইলে গ্রহণে সম্মত।' : 'I agree to receive appointment serial confirmation and reminder SMS on my phone.' }}
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12 pt-2">
                                    <button type="submit"
                                        class="btn btn-brand-accent w-100 justify-content-center py-3 fs-6">
                                        <i class="bi bi-check2-circle fs-5"></i>
                                        <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সিরিয়াল রিকোয়েস্ট জমা দিন' : 'Confirm Serial Request & Get Confirmation' }}</span>
                                    </button>
                                    <div class="text-center text-muted small mt-2 d-flex align-items-center justify-content-center gap-2"
                                        style="font-size: 0.82rem;">
                                        <i class="bi bi-shield-check text-success"></i>
                                        <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'অগ্রিম কোনো ফি নেই। এসএমএস-এ সিরিয়াল নিশ্চিত করা হবে।' : 'No advance payment needed. Serial confirmed via SMS.' }}</span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Patient Reviews / Testimonials --}}
    <section id="reviews" class="py-5 section-transition-soft-white position-relative">
        <div class="container py-lg-4">
            <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between mb-4 mb-md-5 gap-3">
                <div class="max-w-700">
                    <div class="section-eyebrow">
                        {{ ($locale ?? app()->getLocale()) === 'bn' ? 'রোগীদের অভিজ্ঞতা' : 'Patient Testimonials' }}
                    </div>
                    <h2 class="section-headline mb-2">
                        {{ ($locale ?? app()->getLocale()) === 'bn' ? 'রোগীদের মুখে সুস্থতার গল্প' : 'Stories of Healing & Recovery' }}
                    </h2>
                    <p class="text-muted mb-0" style="max-width: 620px;">
                        {{ ($locale ?? app()->getLocale()) === 'bn' ? ($profile->name_bn ?? 'ডাক্তার') . '-এর চিকিৎসা নিয়ে সুস্থ হওয়া সম্মানিত রোগীদের বাস্তব অভিজ্ঞতা ও মন্তব্য।' : 'Direct feedback and verified recovery experiences from individuals treated under ' . ($profile->name_en ?? 'the doctor') . "'s direct clinical supervision." }}
                    </p>
                </div>

                {{-- Review Action Button & Slider Prev / Next Navigation Arrows --}}
                <div class="d-flex align-items-center gap-3 align-self-start align-self-md-auto flex-wrap">
                    <button type="button" class="btn btn-brand-primary px-3 py-2 rounded-pill fw-semibold shadow-sm d-inline-flex align-items-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#patientReviewModal">
                        <i class="bi bi-pencil-square"></i>
                        <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'মতামত বা রিভিউ দিন' : 'Write a Review' }}</span>
                    </button>

                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn-testimonial-nav swiper-button-prev-custom" aria-label="Previous Testimonial">
                            <i class="bi bi-arrow-left"></i>
                        </button>
                        <button type="button" class="btn-testimonial-nav swiper-button-next-custom" aria-label="Next Testimonial">
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            @if (session('success_review'))
                <div class="alert alert-success d-flex align-items-center gap-3 mb-4 rounded-3 shadow-xs" role="alert">
                    <i class="bi bi-check-circle-fill fs-3 text-success flex-shrink-0"></i>
                    <div>
                        <div class="fw-bold fs-6">
                            {{ ($locale ?? app()->getLocale()) === 'bn' ? 'মতামত সফলভাবে গৃহীত হয়েছে!' : 'Review Submitted Successfully!' }}
                        </div>
                        <div class="small">{{ session('success_review') }}</div>
                    </div>
                </div>
            @endif

            @if ($errors->has('patient_name') || $errors->has('patient_phone') || $errors->has('last_visit_date') || $errors->has('review_text'))
                <div class="alert alert-danger mb-4 rounded-3">
                    <div class="fw-bold small mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> {{ ($locale ?? app()->getLocale()) === 'bn' ? 'রিভিউ জমাদানে ত্রুটি হয়েছে:' : 'Review submission errors:' }}</div>
                    <ul class="mb-0 small ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Swiper Slider Container -->
            <div class="swiper testimonials-swiper">
                <div class="swiper-wrapper">
                    @foreach ($reviews as $rev)
                        <div class="swiper-slide">
                            <div class="testimonial-card w-100 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="text-warning d-flex gap-1" aria-label="{{ $rev->rating ?? 5 }} out of 5 stars">
                                            @for ($i = 0; $i < ($rev->rating ?? 5); $i++)
                                                <i class="bi bi-star-fill"></i>
                                            @endfor
                                        </div>
                                        <div class="quote-badge">
                                            <i class="bi bi-quote quote-mark"></i>
                                        </div>
                                    </div>
                                    <p class="testimonial-text mb-4">
                                        "{{ ($locale ?? app()->getLocale()) === 'bn' ? ($rev->review_text_bn ?: $rev->review_text_en) : ($rev->review_text_en ?: $rev->review_text_bn) }}"
                                    </p>
                                </div>
                                <div class="d-flex align-items-center gap-3 pt-3 border-top mt-auto">
                                    <div class="clinical-icon {{ $rev->color_class ?? 'clinical-icon-blue' }} rounded-circle flex-shrink-0"
                                        style="width: 44px; height: 44px; font-weight: 700; font-size: 0.95rem; display: flex; align-items: center; justify-content: center;">
                                        {{ $rev->patient_initials ?? mb_substr($rev->patient_name ?? 'P', 0, 2) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="fw-bold text-dark small text-truncate">{{ $rev->patient_name }}</div>
                                        <div class="text-muted text-truncate" style="font-size: 0.78rem;">
                                            <i class="bi bi-patch-check-fill text-success me-1"></i>
                                            {{ ($locale ?? app()->getLocale()) === 'bn' ? ($rev->location_tag_bn ?: $rev->location_tag_en) : ($rev->location_tag_en ?: $rev->location_tag_bn) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination Bullets -->
                <div class="swiper-pagination testimonials-pagination"></div>
            </div>
        </div>
    </section>

    <style>
        .star-rating-group {
            display: inline-flex;
            flex-direction: row-reverse;
            gap: 4px;
        }
        .star-rating-group input {
            display: none;
        }
        .star-rating-group label {
            font-size: 1.5rem;
            color: #cbd5e1;
            cursor: pointer;
            transition: color 0.15s ease-in-out, transform 0.15s;
            padding: 0 2px;
        }
        .star-rating-group label:hover,
        .star-rating-group label:hover ~ label,
        .star-rating-group input:checked ~ label {
            color: #f59e0b !important;
        }
        .star-rating-group label:hover {
            transform: scale(1.15);
        }
    </style>

    {{-- Patient Review Submission Modal (Static Backdrop - Close button only) --}}
    <div class="modal fade" id="patientReviewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="patientReviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
                <div class="modal-header bg-light py-3 px-4 border-bottom">
                    <div>
                        <h5 class="modal-title fs-5 fw-bold text-dark d-flex align-items-center gap-2 mb-1" id="patientReviewModalLabel">
                            <i class="bi bi-pencil-square text-primary"></i>
                            <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'চিকিৎসাসেবা সম্পর্কে আপনার রিভিউ দিন' : 'Share Your Patient Experience' }}</span>
                        </h5>
                        <p class="text-muted small mb-0">
                            {{ ($locale ?? app()->getLocale()) === 'bn' ? 'আপনার বাস্তব অভিজ্ঞতা অন্য রোগীদের সঠিক সিদ্ধান্ত নিতে সাহায্য করবে।' : 'Your real feedback helps fellow patients find trusted healthcare guidance.' }}
                        </p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('reviews.store') }}" method="POST" id="patientReviewForm" data-turbo="false">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="revPatientName" class="form-label small fw-semibold text-dark">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'রোগীর পূর্ণ নাম' : 'Patient Full Name' }} <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="revPatientName" name="patient_name"
                                    required maxlength="150" placeholder="{{ ($locale ?? app()->getLocale()) === 'bn' ? 'যেমন: মোহাম্মদ রফিকুল ইসলাম' : 'e.g. Md. Rafiqul Islam' }}"
                                    value="{{ old('patient_name') }}">
                            </div>

                            <div class="col-md-6">
                                <label for="revPatientPhone" class="form-label small fw-semibold text-dark">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'মোবাইল নম্বর (১১ ডিজিট)' : 'Mobile Phone (11-digit BD)' }} <span class="text-danger">*</span>
                                </label>
                                <input type="tel" class="form-control" id="revPatientPhone" name="patient_phone"
                                    required pattern="01[3-9][0-9]{8}" maxlength="11" minlength="11" inputmode="numeric"
                                    placeholder="017XXXXXXXX" value="{{ old('patient_phone') }}">
                                <div class="form-text small text-muted" style="font-size: 0.76rem;">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? '১১ ডিজিটের বাংলাদেশি নম্বর (যেমন: 01712345678)। ভেরিফিকেশনের জন্য সংরক্ষিত থাকবে।' : '11-digit BD format (e.g. 01712345678). Used for verification only.' }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="revLastVisitDate" class="form-label small fw-semibold text-dark">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'সর্বশেষ ডাক্তার দেখানোর তারিখ' : 'Last Consultation Date' }} <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control" id="revLastVisitDate" name="last_visit_date"
                                    required max="{{ date('Y-m-d') }}" value="{{ old('last_visit_date') }}">
                                <div class="form-text small text-muted" style="font-size: 0.76rem;">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'সর্বশেষ যে তারিখে ডাক্তারকে দেখিয়েছেন (আজ বা অতীতের তারিখ)।' : 'Date of your last visit (must be today or in the past).' }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="revTreatedFor" class="form-label small fw-semibold text-dark">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'রোগের ধরন বা বিভাগ' : 'Condition / Treated For' }}
                                </label>
                                <input type="text" class="form-control" id="revTreatedFor" name="treated_for"
                                    maxlength="150" placeholder="{{ ($locale ?? app()->getLocale()) === 'bn' ? 'যেমন: ডায়াবেটিস, থাইরয়েড, হরমোন' : 'e.g. Diabetes, Thyroid, Hormone' }}"
                                    value="{{ old('treated_for') }}">
                                <div class="form-text small text-muted" style="font-size: 0.76rem;">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'ঐচ্ছিক: যে রোগের জন্য চিকিৎসা নিয়েছিলেন।' : 'Optional: The condition you were treated for.' }}
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-semibold text-dark d-block mb-1">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'আপনার রেটিং' : 'Your Rating' }} <span class="text-danger">*</span>
                                </label>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="star-rating-group">
                                        @for ($star = 5; $star >= 1; $star--)
                                            <input type="radio" name="rating" id="revStar{{ $star }}" value="{{ $star }}" {{ $star === 5 ? 'checked' : '' }} required>
                                            <label for="revStar{{ $star }}" title="{{ $star }} Stars"><i class="bi bi-star-fill"></i></label>
                                        @endfor
                                    </div>
                                    <span class="small text-muted fw-semibold" id="ratingTextDisplay">
                                        {{ ($locale ?? app()->getLocale()) === 'bn' ? '৫ স্টার (অসাধারণ)' : '5 Stars (Excellent)' }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="revReviewText" class="form-label small fw-semibold text-dark">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'আপনার বাস্তব অভিজ্ঞতা বা মন্তব্য' : 'Your Review & Experience' }} <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" id="revReviewText" name="review_text" rows="4"
                                    required minlength="10" maxlength="2000"
                                    placeholder="{{ ($locale ?? app()->getLocale()) === 'bn' ? 'ডাক্তারের চিকিৎসাসেবা, চেম্বার পরিবেশ এবং আপনার আরোগ্য লাভের অনুভূতি সংক্ষেপে বর্ণনা করুন...' : 'Describe how the consultation helped you, doctor behavior, and recovery...' }}">{{ old('review_text') }}</textarea>
                                <div class="form-text small text-muted" style="font-size: 0.76rem;">
                                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'কমপক্ষে ১০ অক্ষর। শালীন ও গঠনমূলক মতামত কাম্য।' : 'Minimum 10 characters. Constructive and helpful feedback.' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light py-3 px-4 border-top d-flex align-items-center justify-content-between">
                        <button type="button" class="btn btn-outline-secondary px-3 py-2" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i>
                            <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'বন্ধ করুন' : 'Cancel' }}</span>
                        </button>
                        <button type="submit" class="btn btn-brand-primary px-4 py-2 fw-bold d-inline-flex align-items-center gap-2">
                            <i class="bi bi-send-fill"></i>
                            <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'রিভিউ জমা দিন' : 'Submit Review' }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- FAQ Section --}}
    <section id="faq" class="py-5 section-transition-faq">
        <div class="container py-lg-4">
            <div class="text-center max-w-700 mx-auto mb-5">
                <div class="section-eyebrow">
                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'সাধারণ জিজ্ঞাসা' : 'Patient Help Center' }}</div>
                <h2 class="section-headline">
                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'সচরাচর জিজ্ঞাসিত প্রশ্নোত্তর' : 'Frequently Asked Questions' }}
                </h2>
                <p class="mx-auto" style="max-width: 600px;">
                    {{ ($locale ?? app()->getLocale()) === 'bn' ? 'সিরিয়াল বুকিং, ভিজিট ও চেম্বার সম্পর্কিত প্রয়োজনীয় তথ্য।' : 'Clear guidance on scheduling serials, previous report reviews, and chamber etiquette.' }}
                </p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion">
                        @foreach ($faqs as $idx => $fq)
                            <div class="accordion-item">
                                <h3 class="accordion-header" id="heading{{ $idx }}">
                                    <button class="accordion-button {{ $idx > 0 ? 'collapsed' : '' }}" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse{{ $idx }}"
                                        aria-expanded="{{ $idx === 0 ? 'true' : 'false' }}"
                                        aria-controls="collapse{{ $idx }}">
                                        {{ ($locale ?? app()->getLocale()) === 'bn' ? $fq->question_bn : $fq->question_en }}
                                    </button>
                                </h3>
                                <div id="collapse{{ $idx }}"
                                    class="accordion-collapse collapse {{ $idx === 0 ? 'show' : '' }}"
                                    aria-labelledby="heading{{ $idx }}" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-muted small">
                                        {{ ($locale ?? app()->getLocale()) === 'bn' ? $fq->answer_bn : $fq->answer_en }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        (function() {
            var testimonialsSwiper = null;

            function initTestimonialsSlider() {
                var sliderEl = document.querySelector('.testimonials-swiper');
                if (!sliderEl) return;
                if (typeof Swiper === 'undefined') {
                    setTimeout(initTestimonialsSlider, 50);
                    return;
                }

                if (testimonialsSwiper) {
                    try {
                        testimonialsSwiper.destroy(true, true);
                    } catch (e) {}
                    testimonialsSwiper = null;
                }

                testimonialsSwiper = new Swiper('.testimonials-swiper', {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    loop: {{ $reviews->count() > 3 ? 'true' : 'false' }},
                    speed: 650,
                    grabCursor: true,
                    autoplay: {
                        delay: 4500,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                    },
                    pagination: {
                        el: '.testimonials-pagination',
                        clickable: true,
                        dynamicBullets: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next-custom',
                        prevEl: '.swiper-button-prev-custom',
                    },
                    breakpoints: {
                        576: {
                            slidesPerView: 1.15,
                            spaceBetween: 20,
                        },
                        768: {
                            slidesPerView: 2,
                            spaceBetween: 24,
                        },
                        1024: {
                            slidesPerView: 3,
                            spaceBetween: 28,
                        },
                    },
                });
            }

            function initIndexUpload() {
                var uploadInput = document.getElementById('reportFiles');
                var uploadStatus = document.getElementById('uploadStatus');
                var uploadFileName = document.getElementById('uploadFileName');
                var currentLang = '{{ $locale ?? app()->getLocale() }}';

                if (uploadInput && uploadStatus && uploadFileName && !uploadInput.dataset.turboBound) {
                    uploadInput.dataset.turboBound = 'true';
                    uploadInput.addEventListener('change', function(e) {
                        var files = e.target.files;
                        if (files && files.length > 0) {
                            uploadStatus.style.display = 'inline-flex';
                            if (files.length === 1) {
                                uploadFileName.textContent = files[0].name;
                            } else {
                                uploadFileName.textContent = files.length + (currentLang === 'bn' ?
                                    ' টি ফাইল সিলেক্ট করা হয়েছে' : ' files selected');
                            }
                        } else {
                            uploadStatus.style.display = 'none';
                        }
                    });
                }
            }

            function initReviewRating() {
                var ratingInputs = document.querySelectorAll('input[name="rating"]');
                var ratingText = document.getElementById('ratingTextDisplay');
                var isBn = '{{ ($locale ?? app()->getLocale()) }}' === 'bn';
                var labels = isBn ? {
                    '5': '৫ স্টার (অসাধারণ)',
                    '4': '৪ স্টার (খুব ভালো)',
                    '3': '৩ স্টার (ভালো)',
                    '2': '২ স্টার (মোটামুটি)',
                    '1': '১ স্টার (সন্তোষজনক নয়)'
                } : {
                    '5': '5 Stars (Excellent)',
                    '4': '4 Stars (Very Good)',
                    '3': '3 Stars (Good)',
                    '2': '2 Stars (Fair)',
                    '1': '1 Star (Poor)'
                };

                ratingInputs.forEach(function(input) {
                    input.addEventListener('change', function() {
                        if (ratingText && labels[this.value]) {
                            ratingText.textContent = labels[this.value];
                        }
                    });
                });
            }

            function initIndexPage() {
                initIndexUpload();
                initTestimonialsSlider();
                initReviewRating();
            }

            document.addEventListener('turbo:before-cache', function() {
                if (testimonialsSwiper) {
                    try {
                        testimonialsSwiper.destroy(true, true);
                    } catch (e) {}
                    testimonialsSwiper = null;
                }
            });

            document.addEventListener('DOMContentLoaded', initIndexPage);
            document.addEventListener('turbo:load', initIndexPage);
        })();
    </script>
@endsection
