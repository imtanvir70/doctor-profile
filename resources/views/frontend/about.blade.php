@extends('layouts.app')

@section('content')
  <section class="hero-about-banner">
    <div class="container">
      <div class="row align-items-center g-4">
        <div class="col-lg-8">
          <div class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-bold mb-3 d-inline-flex align-items-center gap-2">
            <i class="bi bi-patch-check-fill fs-6"></i>
            <span>{{ !empty($profile->bmdc_reg) ? ('BMDC Reg No: ' . $profile->bmdc_reg . ' • ') : '' }}{{ ($locale ?? app()->getLocale()) === 'bn' ? ($profile->designation_bn ?? 'মেডিসিন বিশেষজ্ঞ') : ($profile->designation_en ?? 'Internal Medicine') }}</span>
          </div>
          <h1 class="display-5 fw-extrabold mb-3">
            {{ ($locale ?? app()->getLocale()) === 'bn' ? ($profile->name_bn ?? 'ডাঃ মোঃ আবু হানিফ রাকিব') : ($profile->name_en ?? 'Dr. Abu Hanif Rakib') }}
          </h1>
          <p class="fs-5 text-muted mb-0" style="max-width: 720px;">
            {{ ($locale ?? app()->getLocale()) === 'bn' ? ($profile->designation_bn ?? 'সহযোগী অধ্যাপক ও সিনিয়র কনসালট্যান্ট, মেডিসিন বিভাগ। দীর্ঘ ১৫+ বছরের চিকিৎসা সেবা ও পাঠদানের অভিজ্ঞতা।') : ($profile->designation_en ?? 'Associate Professor & Senior Consultant in Internal Medicine with extensive clinical practice and postgraduate teaching experience.') }}
          </p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="{{ route('booking') }}" class="btn btn-brand-primary px-4 py-3">
            <i class="bi bi-calendar2-check-fill me-2"></i>
            <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সিরিয়াল বুক করুন' : 'Book Consultation Serial' }}</span>
          </a>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5">
    <div class="container py-lg-4">
      <div class="row g-5 align-items-center mb-5">
        <div class="col-lg-5">
          <div class="about-lead-card">
            <div class="about-image-frame">
              <img src="{{ $profile->avatar ?? 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&crop=top&w=900&q=85' }}" alt="{{ $profile->name_en ?? 'Dr. Abu Hanif Rakib' }}">
            </div>
          </div>
        </div>
        <div class="col-lg-7">
          <div class="ps-lg-3">
            <div class="small fw-bold text-accent text-uppercase letter-spacing-1 mb-2">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'ব্যক্তিগত পরিচিতি ও চিকিৎসা দর্শন' : 'Personal Biography & Philosophy' }}</div>
            <h2 class="display-6 fw-bold mb-3 brand-font">{{ ($locale ?? app()->getLocale()) === 'bn' ? ($profile->about_headline_bn ?? 'ধৈর্যশীল শ্রবণ ও তথ্যভিত্তিক যুক্তিসম্মত চিকিৎসা') : ($profile->about_headline_en ?? 'Clinical Accuracy Built on Careful Listening & Rational Medicine') }}</h2>
            <p class="text-muted mb-4">
              {{ ($locale ?? app()->getLocale()) === 'bn' ? ($profile->about_p1_bn ?? 'আধুনিক চিকিৎসা বিজ্ঞান ও ক্লিনিক্যাল অভিজ্ঞতার সমন্বয়ে রোগীদের নির্ভরযোগ্য ও তথ্যভিত্তিক স্বাস্থ্যসেবা প্রদানে নিবেদিতপ্রাণ।') : ($profile->about_p1_en ?? 'Providing authoritative, evidence-based diagnostic care and individualized treatment protocols with extensive clinical practice.') }}
            </p>
            @if($profile->about_p2_bn || $profile->about_p2_en)
              <p class="text-muted mb-4">
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
                    <div class="about-feature-title">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'চিকিৎসা ডিগ্রি ও সনদ' : 'Medical Qualifications' }}</div>
                    <div class="about-feature-desc">{{ ($locale ?? app()->getLocale()) === 'bn' ? ($profile->degrees_bn ?? 'এমবিবিএস, এফসিপিএস') : ($profile->degrees_en ?? 'MBBS, FCPS') }}</div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="about-feature-box">
                  <div class="about-feature-icon-circle about-feature-icon-emerald">
                    <i class="bi bi-hospital-fill"></i>
                  </div>
                  <div>
                    <div class="about-feature-title">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'বর্তমান পদবী ও বিশেষজ্ঞতা' : 'Designation & Specialty' }}</div>
                    <div class="about-feature-desc">{{ ($locale ?? app()->getLocale()) === 'bn' ? ($profile->designation_bn ?? 'কনসালট্যান্ট স্পেশালিস্ট') : ($profile->designation_en ?? 'Consultant Specialist') }}</div>
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
                <span>{{ $profile->experience_years }} {{ ($locale ?? app()->getLocale()) === 'bn' ? 'বছরের ক্লিনিক্যাল অভিজ্ঞতা' : 'Years Clinical Experience' }}</span>
              </span>
              <span class="about-affiliation-pill">
                <i class="bi bi-people-fill text-info"></i>
                <span>{{ $profile->patients_count }} {{ ($locale ?? app()->getLocale()) === 'bn' ? 'রোগী সেবা' : 'Patients Consulted' }}</span>
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="row g-5">
        <div class="col-lg-6">
          <div class="medical-credentials-card p-4 p-md-5 h-100">
            <div class="d-flex align-items-center gap-3 mb-4 pb-2 border-bottom">
              <div class="about-feature-icon-circle about-feature-icon-primary">
                <i class="bi bi-award-fill"></i>
              </div>
              <div>
                <h3 class="fs-4 fw-bold mb-0 brand-font text-primary">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'পেশাগত পরিচিতি ও যোগ্যতা' : 'Academic Track Record & Credentials' }}</h3>
                <div class="text-muted small">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'ক্লিনিক্যাল এক্সিলেন্স ও প্রাতিষ্ঠানিক সেবা' : 'Clinical Excellence & Professional Standing' }}</div>
              </div>
            </div>

            <div class="med-timeline">
              <div class="med-timeline-item">
                <div class="med-timeline-badge">
                  <i class="bi bi-hospital-fill"></i>
                </div>
                <div class="med-timeline-content">
                  <div class="med-timeline-title">{{ ($locale ?? app()->getLocale()) === 'bn' ? ($profile->academic_post1_bn ?? $profile->designation_bn) : ($profile->academic_post1_en ?? $profile->designation_en) }}</div>
                  <div class="med-timeline-meta">
                    <span class="med-timeline-org"><i class="bi bi-geo-alt-fill text-primary"></i> {{ ($locale ?? app()->getLocale()) === 'bn' ? ($profile->academic_desc1_bn ?? $profile->designation_bn) : ($profile->academic_desc1_en ?? $profile->designation_en) }}</span>
                    <span class="med-timeline-year current"><i class="bi bi-clock-history me-1"></i> {{ ($locale ?? app()->getLocale()) === 'bn' ? 'বর্তমান' : 'Active / Present' }}</span>
                  </div>
                </div>
              </div>

              <div class="med-timeline-item">
                <div class="med-timeline-badge">
                  <i class="bi bi-patch-check-fill text-success"></i>
                </div>
                <div class="med-timeline-content">
                  <div class="med-timeline-title">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'চিকিৎসা ডিগ্রি ও উচ্চতর সনদ' : 'Medical Degrees & Certifications' }}</div>
                  <div class="med-timeline-meta">
                    <span class="med-timeline-org"><i class="bi bi-award-fill text-success"></i> {{ ($locale ?? app()->getLocale()) === 'bn' ? $profile->degrees_bn : $profile->degrees_en }}</span>
                  </div>
                </div>
              </div>

              @if (!empty($profile->bmdc_reg))
              <div class="med-timeline-item">
                <div class="med-timeline-badge">
                  <i class="bi bi-shield-fill-check text-primary"></i>
                </div>
                <div class="med-timeline-content">
                  <div class="med-timeline-title">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সরকারি বিএমডিসি সনদ' : 'Official BMDC Registration' }}</div>
                  <div class="med-timeline-meta">
                    <span class="med-timeline-org"><i class="bi bi-patch-check-fill text-primary"></i> Reg No: {{ $profile->bmdc_reg }}</span>
                    <span class="med-timeline-year"><i class="bi bi-check-circle-fill me-1"></i> {{ ($locale ?? app()->getLocale()) === 'bn' ? 'ভেরিফাইড' : 'Verified' }}</span>
                  </div>
                </div>
              </div>
              @endif

              <div class="med-timeline-item">
                <div class="med-timeline-badge">
                  <i class="bi bi-person-workspace text-info"></i>
                </div>
                <div class="med-timeline-content">
                  <div class="med-timeline-title">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'ক্লিনিক্যাল সেবা ও কনসালটেন্সি' : 'Clinical Consultations & Experience' }}</div>
                  <div class="med-timeline-meta">
                    <span class="med-timeline-org"><i class="bi bi-calendar2-check-fill text-info"></i> {{ $profile->experience_years }} {{ ($locale ?? app()->getLocale()) === 'bn' ? 'বছরের অভিজ্ঞতা' : 'Years Experience' }} • {{ $profile->patients_count }} {{ ($locale ?? app()->getLocale()) === 'bn' ? 'রোগী সেবা' : 'Patients' }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="p-4 p-md-5 rounded-4 bg-white border border-light-subtle shadow-sm h-100">
            <h3 class="fs-4 fw-bold mb-4 brand-font text-primary">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'চিকিৎসা দর্শন ও রোগীসেবার অঙ্গীকার' : 'Clinical Philosophy & Patient Care' }}</h3>
            
            <div class="d-flex flex-column gap-4">
              <div class="d-flex gap-3">
                <div class="clinical-icon clinical-icon-emerald flex-shrink-0">
                  <i class="bi bi-shield-check"></i>
                </div>
                <div>
                  <h4 class="fs-6 fw-bold mb-1">
                    {{ ($locale ?? app()->getLocale()) === 'bn' 
                      ? ($profile->philosophy_title1_bn ?: 'যথাযথ অ্যান্টিবায়োটিক প্রয়োগ') 
                      : ($profile->philosophy_title1_en ?: 'Rational Antibiotic Stewardship') }}
                  </h4>
                  <p class="small text-muted mb-0">
                    {{ ($locale ?? app()->getLocale()) === 'bn' 
                      ? ($profile->philosophy_desc1_bn ?: 'সাধারণ ভাইরাল জ্বরে অপ্রয়োজনীয় অ্যান্টিবায়োটিক প্রেসক্রিপশন সম্পূর্ণ পরিহার করে ওষুধের কার্যকারিতা সংরক্ষণ।') 
                      : ($profile->philosophy_desc1_en ?: 'Strictly avoids unwarranted antibiotic prescriptions for self-limiting viral fevers, guarding patients against toxic side-effects and drug resistance.') }}
                  </p>
                </div>
              </div>

              <div class="d-flex gap-3">
                <div class="clinical-icon clinical-icon-blue flex-shrink-0">
                  <i class="bi bi-heart-pulse"></i>
                </div>
                <div>
                  <h4 class="fs-6 fw-bold mb-1">
                    {{ ($locale ?? app()->getLocale()) === 'bn' 
                      ? ($profile->philosophy_title2_bn ?: 'সমন্বিত মেটাবলিক চিকিৎসা') 
                      : ($profile->philosophy_title2_en ?: 'Holistic Metabolic Stabilization') }}
                  </h4>
                  <p class="small text-muted mb-0">
                    {{ ($locale ?? app()->getLocale()) === 'bn' 
                      ? ($profile->philosophy_desc2_bn ?: 'ডায়াবেটিস ও উচ্চ রক্তচাপের দীর্ঘমেয়াদী নিয়ন্ত্রণে খাদ্যাভ্যাস, শারীরিক ব্যায়াম ও আধুনিক ওষুধের সুষম সমন্বয়।') 
                      : ($profile->philosophy_desc2_en ?: 'Combines dietary chronobiology, physical routine guidance, and pharmacological therapy to reverse pre-diabetes and achieve long-term glycemic control.') }}
                  </p>
                </div>
              </div>

              <div class="d-flex gap-3">
                <div class="clinical-icon clinical-icon-emerald flex-shrink-0">
                  <i class="bi bi-chat-heart"></i>
                </div>
                <div>
                  <h4 class="fs-6 fw-bold mb-1">
                    {{ ($locale ?? app()->getLocale()) === 'bn' 
                      ? ($profile->philosophy_title3_bn ?: 'সময় নিয়ে রোগীর কথা শোনা') 
                      : ($profile->philosophy_title3_en ?: 'Unrushed Patient Consultations') }}
                  </h4>
                  <p class="small text-muted mb-0">
                    {{ ($locale ?? app()->getLocale()) === 'bn' 
                      ? ($profile->philosophy_desc3_bn ?: 'প্রতিটি রোগীর শারীরিক সমস্যার পুঙ্খানুপুঙ্খ ইতিহাস পর্যালোচনা ও রোগীকে রোগের কারণ স্পষ্টভাবে বুঝিয়ে দেওয়া।') 
                      : ($profile->philosophy_desc3_en ?: 'Dedicates comprehensive time to listen, review previous health trajectories, explain medical findings, and involve the patient in every decision.') }}
                  </p>
                </div>
              </div>
            </div>

            <div class="mt-4 pt-3 border-top text-center">
              <a href="{{ route('expertise') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-bold small">
                <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'বিশেষজ্ঞ সেবা সম্পর্কে জানুন' : 'Explore Clinical Expertise Areas' }}</span>
                <i class="bi bi-arrow-right ms-2"></i>
              </a>
            </div>
          </div>
        </div>
      </div>

      {{-- International Projects & Global Collaborations in About Page --}}
      @if(isset($internationalProjects) && count($internationalProjects) > 0)
        <div class="mt-5 pt-4">
          <div class="text-center max-w-700 mx-auto mb-5">
            <div class="section-eyebrow">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'আন্তর্জাতিক অভিজ্ঞতা ও গবেষণা' : 'Global Research & Collaborations' }}</div>
            <h3 class="display-6 fw-bold mb-3 brand-font">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'আন্তর্জাতিক গবেষণা ও বৈশ্বিক স্বাস্থ্য প্রকল্প' : 'International Clinical Projects & Global Health Initiatives' }}</h3>
            <p class="text-muted mx-auto" style="max-width: 650px;">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'বিশ্ব স্বাস্থ্য সংস্থা (WHO), অক্সফোর্ড রিসার্চ নেটওয়ার্ক ও আন্তর্জাতিক চিকিৎসা সংস্থার সাথে পরিচালিত গবেষণা প্রকল্পসমূহ।' : 'Collaborative clinical trials, observational epidemiologic registries, and global health research initiatives conducted with international institutions.' }}</p>
          </div>

          <div class="row g-4 align-items-stretch">
            @foreach($internationalProjects as $project)
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
                      @if($project->badge_text)
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
                      <span class="meta-icon-bubble role-bubble"><i class="bi bi-person-workspace"></i></span>
                      <div class="meta-text d-flex flex-wrap align-items-center gap-1.5">
                        <span class="fw-semibold text-secondary">{{ ($locale ?? app()->getLocale()) === 'bn' ? $project->role_bn : $project->role_en }}</span>
                        @if($project->country_or_location)
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
                    @if($project->duration)
                      <span class="project-duration-badge">
                        <i class="bi bi-calendar2-range"></i>
                        <span>{{ $project->duration }}</span>
                      </span>
                    @else
                      <span></span>
                    @endif
                    @if($project->project_url)
                      <a href="{{ $project->project_url }}" target="_blank" rel="noopener noreferrer" class="project-explore-btn">
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
      @endif

      <div class="mt-5 p-4 p-md-5 rounded-4 text-center text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #0F3B66 0%, #082440 100%); border: 1px solid rgba(255, 255, 255, 0.1);">
        <div class="max-w-700 mx-auto position-relative" style="z-index: 2;">
          <div class="badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill mb-3">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'চেম্বার অ্যাপয়েন্টমেন্ট' : 'Chamber Consultations' }}</div>
          <h2 class="display-6 fw-bold mb-3 text-white">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সরাসরি ডাক্তারের পরামর্শ নিতে চান?' : 'Looking for an In-Person Medical Review?' }}</h2>
          <p class="text-slate-300 fs-5 mb-4 mx-auto" style="color: #cbd5e1; max-width: 600px;">
            {{ ($locale ?? app()->getLocale()) === 'bn' ? 'আপনার নিকটস্থ চেম্বার নির্বাচন করে দ্রুত সিরিয়াল গ্রহণ করুন।' : 'Consult with ' . ($profile->name_en ?? 'the specialist') . ' at your nearest diagnostic chamber.' }}
          </p>
          <div class="d-flex flex-wrap gap-3 justify-content-center">
            <a href="{{ route('booking') }}" class="btn btn-brand-primary px-4 py-3 fs-6">
              <i class="bi bi-calendar2-check-fill me-2"></i>
              <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সিরিয়াল বুক করুন' : 'Book Consultation Serial' }}</span>
            </a>
            <a href="{{ route('chambers') }}" class="btn btn-outline-light rounded-3 px-4 py-3 fw-bold fs-6">
              <i class="bi bi-geo-alt-fill me-2"></i>
              <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'চেম্বার ও সময়সূচী' : 'View Chambers & Timings' }}</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

