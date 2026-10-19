@extends('layouts.admin')

@section('title', 'Doctor Profile Settings')
@section('page_heading', 'Doctor Profile (drprofile Table Settings)')

@section('content')
  <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">
      <div class="col-lg-8">
        {{-- Theme & Color Palette Customizer --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4" style="border-left: 4px solid var(--admin-accent) !important;">
          <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h2 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-palette-fill text-success me-2"></i>Brand Theme & Color Palette (ওয়েবসাইট কালার পরিবর্তন)</h2>
            <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill fw-semibold">Dynamic Theme</span>
          </div>
          <div class="card-body p-4">
            <p class="small text-muted mb-3">
              যে কোনো ডাক্তারের নিজস্ব ব্র্যান্ডের জন্য ওয়েবসাইটের সম্পূর্ণ কালার স্কিম পরিবর্তন করুন। নিচের প্রিসেট থেকে পছন্দ করুন অথবা সরাসরি কালার পিকার ও হেক্স কোড ব্যবহার করুন:
            </p>

            {{-- One-Click Theme Presets --}}
            <div class="mb-4">
              <label class="form-label small fw-bold text-dark mb-2">One-Click Theme Presets (জনপ্রিয় কালার কম্বিনেশন):</label>
              <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-2 rounded-pill px-3 py-2 js-apply-theme"
                  data-primary="#0F3B66" data-primary-hover="#0a2744" data-accent="#059669" data-accent-hover="#047857" data-soft="#E0F2FE">
                  <span style="display:inline-block; width:14px; height:14px; border-radius:50%; background:#0F3B66;"></span>
                  <span style="display:inline-block; width:14px; height:14px; border-radius:50%; background:#059669;"></span>
                  <span class="small fw-semibold">Classic Royal Navy & Emerald</span>
                </button>

                <button type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-2 rounded-pill px-3 py-2 js-apply-theme"
                  data-primary="#0369a1" data-primary-hover="#075985" data-accent="#06b6d4" data-accent-hover="#0891b2" data-soft="#e0f2fe">
                  <span style="display:inline-block; width:14px; height:14px; border-radius:50%; background:#0369a1;"></span>
                  <span style="display:inline-block; width:14px; height:14px; border-radius:50%; background:#06b6d4;"></span>
                  <span class="small fw-semibold">Sapphire Blue & Cyan</span>
                </button>

                <button type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-2 rounded-pill px-3 py-2 js-apply-theme"
                  data-primary="#1e3a8a" data-primary-hover="#172554" data-accent="#3b82f6" data-accent-hover="#1d4ed8" data-soft="#eff6ff">
                  <span style="display:inline-block; width:14px; height:14px; border-radius:50%; background:#1e3a8a;"></span>
                  <span style="display:inline-block; width:14px; height:14px; border-radius:50%; background:#3b82f6;"></span>
                  <span class="small fw-semibold">Corporate Medical Blue</span>
                </button>

                <button type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-2 rounded-pill px-3 py-2 js-apply-theme"
                  data-primary="#14532d" data-primary-hover="#052e16" data-accent="#10b981" data-accent-hover="#059669" data-soft="#dcfce7">
                  <span style="display:inline-block; width:14px; height:14px; border-radius:50%; background:#14532d;"></span>
                  <span style="display:inline-block; width:14px; height:14px; border-radius:50%; background:#10b981;"></span>
                  <span class="small fw-semibold">Forest & Mint Green</span>
                </button>

                <button type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-2 rounded-pill px-3 py-2 js-apply-theme"
                  data-primary="#4c1d95" data-primary-hover="#2e1065" data-accent="#e11d48" data-accent-hover="#be123c" data-soft="#fae8ff">
                  <span style="display:inline-block; width:14px; height:14px; border-radius:50%; background:#4c1d95;"></span>
                  <span style="display:inline-block; width:14px; height:14px; border-radius:50%; background:#e11d48;"></span>
                  <span class="small fw-semibold">Imperial Indigo & Rose</span>
                </button>

                <button type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-2 rounded-pill px-3 py-2 js-apply-theme"
                  data-primary="#0f172a" data-primary-hover="#020617" data-accent="#2563eb" data-accent-hover="#1d4ed8" data-soft="#f1f5f9">
                  <span style="display:inline-block; width:14px; height:14px; border-radius:50%; background:#0f172a;"></span>
                  <span style="display:inline-block; width:14px; height:14px; border-radius:50%; background:#2563eb;"></span>
                  <span class="small fw-semibold">Modern Slate & Blue</span>
                </button>
              </div>
            </div>

            {{-- Color Pickers & Hex Inputs --}}
            <div class="row g-3">
              <div class="col-sm-6 col-md-4">
                <label for="primary_color" class="form-label small fw-semibold">Primary Brand Color (হেডার ও মূল কালার)</label>
                <div class="input-group">
                  <input type="color" class="form-control form-control-color p-1" id="primary_color_picker" value="{{ old('primary_color', $profile->primary_color ?? '#0F3B66') }}" title="Choose Primary Color" style="width: 48px; height: 38px;">
                  <input type="text" class="form-control" id="primary_color" name="primary_color" value="{{ old('primary_color', $profile->primary_color ?? '#0F3B66') }}" placeholder="#0F3B66">
                </div>
              </div>

              <div class="col-sm-6 col-md-4">
                <label for="primary_hover" class="form-label small fw-semibold">Primary Hover Color</label>
                <div class="input-group">
                  <input type="color" class="form-control form-control-color p-1" id="primary_hover_picker" value="{{ old('primary_hover', $profile->primary_hover ?? '#0a2744') }}" title="Choose Primary Hover" style="width: 48px; height: 38px;">
                  <input type="text" class="form-control" id="primary_hover" name="primary_hover" value="{{ old('primary_hover', $profile->primary_hover ?? '#0a2744') }}" placeholder="#0a2744">
                </div>
              </div>

              <div class="col-sm-6 col-md-4">
                <label for="accent_color" class="form-label small fw-semibold">Accent Action Color (বাটন ও অ্যাকসেন্ট)</label>
                <div class="input-group">
                  <input type="color" class="form-control form-control-color p-1" id="accent_color_picker" value="{{ old('accent_color', $profile->accent_color ?? '#059669') }}" title="Choose Accent Color" style="width: 48px; height: 38px;">
                  <input type="text" class="form-control" id="accent_color" name="accent_color" value="{{ old('accent_color', $profile->accent_color ?? '#059669') }}" placeholder="#059669">
                </div>
              </div>

              <div class="col-sm-6 col-md-4">
                <label for="accent_hover" class="form-label small fw-semibold">Accent Hover Color</label>
                <div class="input-group">
                  <input type="color" class="form-control form-control-color p-1" id="accent_hover_picker" value="{{ old('accent_hover', $profile->accent_hover ?? '#047857') }}" title="Choose Accent Hover" style="width: 48px; height: 38px;">
                  <input type="text" class="form-control" id="accent_hover" name="accent_hover" value="{{ old('accent_hover', $profile->accent_hover ?? '#047857') }}" placeholder="#047857">
                </div>
              </div>

              <div class="col-sm-6 col-md-4">
                <label for="soft_accent" class="form-label small fw-semibold">Soft Light Background Tint</label>
                <div class="input-group">
                  <input type="color" class="form-control form-control-color p-1" id="soft_accent_picker" value="{{ old('soft_accent', $profile->soft_accent ?? '#E0F2FE') }}" title="Choose Soft Tint" style="width: 48px; height: 38px;">
                  <input type="text" class="form-control" id="soft_accent" name="soft_accent" value="{{ old('soft_accent', $profile->soft_accent ?? '#E0F2FE') }}" placeholder="#E0F2FE">
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- Basic Information (Bilingual) --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
          <div class="card-header bg-white py-3 border-bottom">
            <h2 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-person-lines-fill text-primary me-2"></i>Doctor Identity & Qualifications</h2>
          </div>
          <div class="card-body p-4">
            <div class="row g-3">
              <div class="col-md-6">
                <label for="name_en" class="form-label small fw-semibold">Doctor Full Name (English) <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name_en" name="name_en" value="{{ old('name_en', $profile->name_en) }}" required>
              </div>

              <div class="col-md-6">
                <label for="name_bn" class="form-label small fw-semibold">Doctor Full Name (বাংলা) <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name_bn" name="name_bn" value="{{ old('name_bn', $profile->name_bn) }}" required>
              </div>

              <div class="col-md-6">
                <label for="designation_en" class="form-label small fw-semibold">Designation (English) <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="designation_en" name="designation_en" value="{{ old('designation_en', $profile->designation_en) }}" required>
              </div>

              <div class="col-md-6">
                <label for="designation_bn" class="form-label small fw-semibold">Designation (বাংলা) <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="designation_bn" name="designation_bn" value="{{ old('designation_bn', $profile->designation_bn) }}" required>
              </div>

              <div class="col-md-6">
                <label for="degrees_en" class="form-label small fw-semibold">Degrees & Certifications (English) <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="degrees_en" name="degrees_en" value="{{ old('degrees_en', $profile->degrees_en) }}" required>
              </div>

              <div class="col-md-6">
                <label for="degrees_bn" class="form-label small fw-semibold">Degrees & Certifications (বাংলা) <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="degrees_bn" name="degrees_bn" value="{{ old('degrees_bn', $profile->degrees_bn) }}" required>
              </div>

              <div class="col-md-4">
                <label for="bmdc_reg" class="form-label small fw-semibold">BMDC Reg No <span class="badge bg-light text-secondary border ms-1" style="font-size: 0.68rem;">Optional</span></label>
                <input type="text" class="form-control" id="bmdc_reg" name="bmdc_reg" value="{{ old('bmdc_reg', $profile->bmdc_reg) }}" placeholder="e.g. 84321 (ফাঁকা রাখলে দেখাবে না)">
                <div class="form-text small" style="font-size: 0.72rem;">ফাঁকা রাখলে ফ্রন্টএন্ডের কোথাও BMDC নম্বর প্রদর্শিত হবে না।</div>
              </div>

              <div class="col-md-4">
                <label for="consultation_fee" class="form-label small fw-semibold">Standard Consultation Fee <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="consultation_fee" name="consultation_fee" value="{{ old('consultation_fee', $profile->consultation_fee) }}" required>
              </div>

              <div class="col-md-4">
                <label for="experience_years" class="form-label small fw-semibold">Experience (e.g. 12+) <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="experience_years" name="experience_years" value="{{ old('experience_years', $profile->experience_years) }}" required>
              </div>

              <div class="col-md-6">
                <label for="patients_count" class="form-label small fw-semibold">Patients Treated Stat <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="patients_count" name="patients_count" value="{{ old('patients_count', $profile->patients_count ?? $profile->patients_treated) }}" required>
              </div>

              <div class="col-md-6">
                <label for="satisfaction_rate" class="form-label small fw-semibold">Satisfaction Rate Stat <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="satisfaction_rate" name="satisfaction_rate" value="{{ old('satisfaction_rate', $profile->satisfaction_rate) }}" required>
              </div>

              <div class="col-md-6">
                <label for="experience_stat_label_en" class="form-label small fw-semibold">Experience Label (English)</label>
                <input type="text" class="form-control" id="experience_stat_label_en" name="experience_stat_label_en" value="{{ old('experience_stat_label_en', $profile->experience_stat_label_en) }}" placeholder="e.g. Years of Hospital Experience">
              </div>

              <div class="col-md-6">
                <label for="experience_stat_label_bn" class="form-label small fw-semibold">Experience Label (বাংলা)</label>
                <input type="text" class="form-control" id="experience_stat_label_bn" name="experience_stat_label_bn" value="{{ old('experience_stat_label_bn', $profile->experience_stat_label_bn) }}" placeholder="যেমন: বছরের ক্লিনিক্যাল অভিজ্ঞতা">
              </div>

              <div class="col-md-6">
                <label for="patients_stat_label_en" class="form-label small fw-semibold">Patients Stat Label (English)</label>
                <input type="text" class="form-control" id="patients_stat_label_en" name="patients_stat_label_en" value="{{ old('patients_stat_label_en', $profile->patients_stat_label_en) }}" placeholder="e.g. Patients Successfully Treated">
              </div>

              <div class="col-md-6">
                <label for="patients_stat_label_bn" class="form-label small fw-semibold">Patients Stat Label (বাংলা)</label>
                <input type="text" class="form-control" id="patients_stat_label_bn" name="patients_stat_label_bn" value="{{ old('patients_stat_label_bn', $profile->patients_stat_label_bn) }}" placeholder="যেমন: সফলভাবে সুস্থ হওয়া রোগী">
              </div>

              <div class="col-md-6">
                <label for="satisfaction_stat_label_en" class="form-label small fw-semibold">Satisfaction Stat Label (English)</label>
                <input type="text" class="form-control" id="satisfaction_stat_label_en" name="satisfaction_stat_label_en" value="{{ old('satisfaction_stat_label_en', $profile->satisfaction_stat_label_en) }}" placeholder="e.g. Patient Trust & Satisfaction">
              </div>

              <div class="col-md-6">
                <label for="satisfaction_stat_label_bn" class="form-label small fw-semibold">Satisfaction Stat Label (বাংলা)</label>
                <input type="text" class="form-control" id="satisfaction_stat_label_bn" name="satisfaction_stat_label_bn" value="{{ old('satisfaction_stat_label_bn', $profile->satisfaction_stat_label_bn) }}" placeholder="যেমন: রোগীদের সন্তুষ্টি ও আস্থা">
              </div>
            </div>
          </div>
        </div>

        {{-- Biographies & Content --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
          <div class="card-header bg-white py-3 border-bottom">
            <h2 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-card-text text-primary me-2"></i>Biographies & Patient Notices</h2>
          </div>
          <div class="card-body p-4">
            <div class="row g-3">
              <div class="col-12">
                <label for="hero_bio_en" class="form-label small fw-semibold">Hero Short Bio (English)</label>
                <textarea class="form-control" id="hero_bio_en" name="hero_bio_en" rows="3">{{ old('hero_bio_en', $profile->hero_bio_en) }}</textarea>
              </div>

              <div class="col-12">
                <label for="hero_bio_bn" class="form-label small fw-semibold">Hero Short Bio (বাংলা)</label>
                <textarea class="form-control" id="hero_bio_bn" name="hero_bio_bn" rows="3">{{ old('hero_bio_bn', $profile->hero_bio_bn) }}</textarea>
              </div>

              <div class="col-md-6">
                <label for="about_headline_en" class="form-label small fw-semibold">About Section Headline (English)</label>
                <input type="text" class="form-control" id="about_headline_en" name="about_headline_en" value="{{ old('about_headline_en', $profile->about_headline_en) }}" placeholder="e.g. Clinical Accuracy Built on Careful Listening">
              </div>

              <div class="col-md-6">
                <label for="about_headline_bn" class="form-label small fw-semibold">About Section Headline (বাংলা)</label>
                <input type="text" class="form-control" id="about_headline_bn" name="about_headline_bn" value="{{ old('about_headline_bn', $profile->about_headline_bn) }}" placeholder="যেমন: ধৈর্যশীল শ্রবণ ও তথ্যভিত্তিক যুক্তিসম্মত চিকিৎসা">
              </div>

              <div class="col-md-6">
                <label for="about_p1_en" class="form-label small fw-semibold">About Narrative Para 1 (English)</label>
                <textarea class="form-control" id="about_p1_en" name="about_p1_en" rows="3">{{ old('about_p1_en', $profile->about_p1_en) }}</textarea>
              </div>

              <div class="col-md-6">
                <label for="about_p1_bn" class="form-label small fw-semibold">About Narrative Para 1 (বাংলা)</label>
                <textarea class="form-control" id="about_p1_bn" name="about_p1_bn" rows="3">{{ old('about_p1_bn', $profile->about_p1_bn) }}</textarea>
              </div>

              <div class="col-md-6">
                <label for="about_p2_en" class="form-label small fw-semibold">About Philosophy Para 2 (English)</label>
                <textarea class="form-control" id="about_p2_en" name="about_p2_en" rows="3">{{ old('about_p2_en', $profile->about_p2_en) }}</textarea>
              </div>

              <div class="col-md-6">
                <label for="about_p2_bn" class="form-label small fw-semibold">About Philosophy Para 2 (বাংলা)</label>
                <textarea class="form-control" id="about_p2_bn" name="about_p2_bn" rows="3">{{ old('about_p2_bn', $profile->about_p2_bn) }}</textarea>
              </div>

              <div class="col-md-6">
                <label for="academic_post1_en" class="form-label small fw-semibold">Current Hospital / Institutional Post (English)</label>
                <input type="text" class="form-control" id="academic_post1_en" name="academic_post1_en" value="{{ old('academic_post1_en', $profile->academic_post1_en) }}" placeholder="e.g. Associate Professor, Dept of Medicine">
              </div>

              <div class="col-md-6">
                <label for="academic_post1_bn" class="form-label small fw-semibold">Current Hospital / Institutional Post (বাংলা)</label>
                <input type="text" class="form-control" id="academic_post1_bn" name="academic_post1_bn" value="{{ old('academic_post1_bn', $profile->academic_post1_bn) }}" placeholder="যেমন: সহযোগী অধ্যাপক, মেডিসিন বিভাগ">
              </div>

              <div class="col-md-6">
                <label for="academic_desc1_en" class="form-label small fw-semibold">Hospital / Organization Name (English)</label>
                <input type="text" class="form-control" id="academic_desc1_en" name="academic_desc1_en" value="{{ old('academic_desc1_en', $profile->academic_desc1_en) }}" placeholder="e.g. Dhaka Medical College & Hospital">
              </div>

              <div class="col-md-6">
                <label for="academic_desc1_bn" class="form-label small fw-semibold">Hospital / Organization Name (বাংলা)</label>
                <input type="text" class="form-control" id="academic_desc1_bn" name="academic_desc1_bn" value="{{ old('academic_desc1_bn', $profile->academic_desc1_bn) }}" placeholder="যেমন: ঢাকা মেডিকেল কলেজ ও হাসপাতাল">
              </div>

              <div class="col-md-6">
                <label for="emergency_notice_en" class="form-label small fw-semibold">Emergency Notice (English)</label>
                <textarea class="form-control text-danger" id="emergency_notice_en" name="emergency_notice_en" rows="3">{{ old('emergency_notice_en', $profile->emergency_notice_en) }}</textarea>
              </div>

              <div class="col-md-6">
                <label for="emergency_notice_bn" class="form-label small fw-semibold">Emergency Notice (বাংলা)</label>
                <textarea class="form-control text-danger" id="emergency_notice_bn" name="emergency_notice_bn" rows="3">{{ old('emergency_notice_bn', $profile->emergency_notice_bn) }}</textarea>
              </div>
            </div>
          </div>
        </div>

        {{-- Clinical Philosophy & Care Values (About Page - ৩টি চিকিৎসা দর্শন) --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
          <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h2 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-shield-check text-success me-2"></i>Clinical Philosophy & Care Ethics (চিকিৎসা দর্শন ও নীতিসমূহ)</h2>
            <span class="badge bg-primary-subtle text-primary px-3 py-1 rounded-pill fw-semibold">About Page Cards</span>
          </div>
          <div class="card-body p-4">
            <p class="small text-muted mb-3">ডাক্তারের ব্যক্তিগত চিকিৎসা পদ্ধতি ও নীতিসমূহের ৩টি হাইলাইট কার্ড পরিবর্তন করুন:</p>
            
            {{-- Philosophy 1 --}}
            <div class="p-3 bg-light rounded-3 mb-3 border">
              <div class="fw-bold small text-primary mb-2"><i class="bi bi-1-circle-fill me-1"></i> Philosophy Point 1:</div>
              <div class="row g-2">
                <div class="col-md-6">
                  <label class="form-label small fw-semibold">Title (English)</label>
                  <input type="text" class="form-control form-control-sm" name="philosophy_title1_en" value="{{ old('philosophy_title1_en', $profile->philosophy_title1_en) }}" placeholder="e.g. Rational Antibiotic Stewardship">
                </div>
                <div class="col-md-6">
                  <label class="form-label small fw-semibold">Title (বাংলা)</label>
                  <input type="text" class="form-control form-control-sm" name="philosophy_title1_bn" value="{{ old('philosophy_title1_bn', $profile->philosophy_title1_bn) }}" placeholder="যেমন: যথাযথ অ্যান্টিবায়োটিক প্রয়োগ">
                </div>
                <div class="col-md-6">
                  <label class="form-label small fw-semibold">Description (English)</label>
                  <textarea class="form-control form-control-sm" name="philosophy_desc1_en" rows="2" placeholder="Strictly avoids unwarranted antibiotic prescriptions...">{{ old('philosophy_desc1_en', $profile->philosophy_desc1_en) }}</textarea>
                </div>
                <div class="col-md-6">
                  <label class="form-label small fw-semibold">Description (বাংলা)</label>
                  <textarea class="form-control form-control-sm" name="philosophy_desc1_bn" rows="2" placeholder="সাধারণ ভাইরাল জ্বরে অপ্রয়োজনীয় অ্যান্টিবায়োটিক পরিহার...">{{ old('philosophy_desc1_bn', $profile->philosophy_desc1_bn) }}</textarea>
                </div>
              </div>
            </div>

            {{-- Philosophy 2 --}}
            <div class="p-3 bg-light rounded-3 mb-3 border">
              <div class="fw-bold small text-primary mb-2"><i class="bi bi-2-circle-fill me-1"></i> Philosophy Point 2:</div>
              <div class="row g-2">
                <div class="col-md-6">
                  <label class="form-label small fw-semibold">Title (English)</label>
                  <input type="text" class="form-control form-control-sm" name="philosophy_title2_en" value="{{ old('philosophy_title2_en', $profile->philosophy_title2_en) }}" placeholder="e.g. Holistic Metabolic Stabilization">
                </div>
                <div class="col-md-6">
                  <label class="form-label small fw-semibold">Title (বাংলা)</label>
                  <input type="text" class="form-control form-control-sm" name="philosophy_title2_bn" value="{{ old('philosophy_title2_bn', $profile->philosophy_title2_bn) }}" placeholder="যেমন: সমন্বিত মেটাবলিক চিকিৎসা">
                </div>
                <div class="col-md-6">
                  <label class="form-label small fw-semibold">Description (English)</label>
                  <textarea class="form-control form-control-sm" name="philosophy_desc2_en" rows="2" placeholder="Combines dietary chronobiology and therapy...">{{ old('philosophy_desc2_en', $profile->philosophy_desc2_en) }}</textarea>
                </div>
                <div class="col-md-6">
                  <label class="form-label small fw-semibold">Description (বাংলা)</label>
                  <textarea class="form-control form-control-sm" name="philosophy_desc2_bn" rows="2" placeholder="ডায়াবেটিস ও উচ্চ রক্তচাপের দীর্ঘমেয়াদী নিয়ন্ত্রণ...">{{ old('philosophy_desc2_bn', $profile->philosophy_desc2_bn) }}</textarea>
                </div>
              </div>
            </div>

            {{-- Philosophy 3 --}}
            <div class="p-3 bg-light rounded-3 mb-1 border">
              <div class="fw-bold small text-primary mb-2"><i class="bi bi-3-circle-fill me-1"></i> Philosophy Point 3:</div>
              <div class="row g-2">
                <div class="col-md-6">
                  <label class="form-label small fw-semibold">Title (English)</label>
                  <input type="text" class="form-control form-control-sm" name="philosophy_title3_en" value="{{ old('philosophy_title3_en', $profile->philosophy_title3_en) }}" placeholder="e.g. Unrushed Patient Consultations">
                </div>
                <div class="col-md-6">
                  <label class="form-label small fw-semibold">Title (বাংলা)</label>
                  <input type="text" class="form-control form-control-sm" name="philosophy_title3_bn" value="{{ old('philosophy_title3_bn', $profile->philosophy_title3_bn) }}" placeholder="যেমন: সময় নিয়ে রোগীর কথা শোনা">
                </div>
                <div class="col-md-6">
                  <label class="form-label small fw-semibold">Description (English)</label>
                  <textarea class="form-control form-control-sm" name="philosophy_desc3_en" rows="2" placeholder="Dedicates comprehensive time to listen...">{{ old('philosophy_desc3_en', $profile->philosophy_desc3_en) }}</textarea>
                </div>
                <div class="col-md-6">
                  <label class="form-label small fw-semibold">Description (বাংলা)</label>
                  <textarea class="form-control form-control-sm" name="philosophy_desc3_bn" rows="2" placeholder="পুঙ্খানুপুঙ্খ ইতিহাস পর্যালোচনা ও রোগীকে বুঝিয়ে দেওয়া...">{{ old('philosophy_desc3_bn', $profile->philosophy_desc3_bn) }}</textarea>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- Expertise Banner Headings (Expertise Page) --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
          <div class="card-header bg-white py-3 border-bottom">
            <h2 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-diagram-3-fill text-primary me-2"></i>Expertise Page Banner & Hero Text</h2>
          </div>
          <div class="card-body p-4">
            <div class="row g-3">
              <div class="col-md-6">
                <label for="expertise_banner_title_en" class="form-label small fw-semibold">Banner Heading (English)</label>
                <input type="text" class="form-control" id="expertise_banner_title_en" name="expertise_banner_title_en" value="{{ old('expertise_banner_title_en', $profile->expertise_banner_title_en) }}" placeholder="e.g. Specialized Clinical Solutions">
              </div>
              <div class="col-md-6">
                <label for="expertise_banner_title_bn" class="form-label small fw-semibold">Banner Heading (বাংলা)</label>
                <input type="text" class="form-control" id="expertise_banner_title_bn" name="expertise_banner_title_bn" value="{{ old('expertise_banner_title_bn', $profile->expertise_banner_title_bn) }}" placeholder="যেমন: বিশেষজ্ঞ চিকিৎসা সেবা ও প্রোটোকল">
              </div>
              <div class="col-md-6">
                <label for="expertise_banner_desc_en" class="form-label small fw-semibold">Banner Description (English)</label>
                <textarea class="form-control" id="expertise_banner_desc_en" name="expertise_banner_desc_en" rows="2" placeholder="Systematic medical protocols developed through...">{{ old('expertise_banner_desc_en', $profile->expertise_banner_desc_en) }}</textarea>
              </div>
              <div class="col-md-6">
                <label for="expertise_banner_desc_bn" class="form-label small fw-semibold">Banner Description (বাংলা)</label>
                <textarea class="form-control" id="expertise_banner_desc_bn" name="expertise_banner_desc_bn" rows="2" placeholder="ক্লিনিক্যাল অভিজ্ঞতার ভিত্তিতে তৈরি সুনির্দিষ্ট চিকিৎসা প্রোটোকল...">{{ old('expertise_banner_desc_bn', $profile->expertise_banner_desc_bn) }}</textarea>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Sidebar Controls (Avatar, Contacts, Social) --}}
      <div class="col-lg-4">
        {{-- Profile Avatar Card --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4 text-center p-4">
          <div class="position-relative mb-3 mx-auto" style="width: 150px; height: 150px; border-radius: 20px; overflow: hidden; border: 3px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
            <img id="doctor_avatar_preview" src="{{ $profile->avatar ?? 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&crop=top&w=900&q=85' }}" alt="Doctor Avatar" class="w-100 h-100 object-fit-cover">
            <span id="avatar_new_badge" class="badge bg-success position-absolute bottom-0 start-50 translate-middle-x mb-1 shadow-sm d-none" style="font-size: 0.7rem;">
              <i class="bi bi-check-circle me-1"></i>New Selected
            </span>
          </div>
          <label for="avatar_file" class="form-label small fw-semibold">Upload New Profile Photo</label>
          <input type="file" class="form-control form-control-sm mb-2" id="avatar_file" name="avatar_file" accept="image/*">
          <div id="avatar_file_info" class="small text-muted" style="font-size: 0.75rem;">Square aspect ratio recommended (Max 4MB).</div>
        </div>

        {{-- Site Favicon & Browser Tab Branding Card --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
          <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h3 class="fs-6 fw-bold mb-0 text-dark brand-font">
              <i class="bi bi-browser-chrome text-primary me-2"></i>Website Favicon (ওয়েবসাইট আইকন)
            </h3>
            <span class="badge bg-primary-subtle text-primary px-2 py-1 rounded-pill" style="font-size: 0.7rem;">Browser Tab</span>
          </div>
          <div class="card-body p-4 text-center">
            {{-- Browser Tab Live Simulation Mockup --}}
            <div class="mb-3 p-2 rounded-3 text-start" style="background: #e2e8f0; border: 1px solid #cbd5e1;">
              <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-top-3 bg-white shadow-sm" style="max-width: 250px; border-bottom: 2px solid var(--admin-accent);">
                <img id="favicon_tab_preview" src="{{ $profile->favicon_url }}" alt="Favicon" style="width: 16px; height: 16px; object-fit: contain; border-radius: 2px;">
                <span class="small text-truncate fw-semibold text-dark" style="font-size: 0.75rem;">{{ $profile->name_en ?? 'Doctor Portal' }}</span>
                <span class="ms-auto text-muted" style="font-size: 0.7rem; cursor: default;">&times;</span>
              </div>
            </div>

            <div class="d-flex align-items-center justify-content-center gap-3 mb-3">
              <div class="position-relative p-2 rounded-3 border bg-light d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                <img id="favicon_preview_img" src="{{ $profile->favicon_url }}" alt="Favicon Preview" style="max-width: 48px; max-height: 48px; object-fit: contain;">
                <span id="favicon_new_badge" class="badge bg-success position-absolute bottom-0 start-50 translate-middle-x mb-0 shadow-sm d-none" style="font-size: 0.62rem;">New</span>
              </div>
              <div class="text-start">
                <div class="fw-bold small text-dark">Current Favicon</div>
                <div class="small text-muted" style="font-size: 0.72rem;">ব্রাউজার ট্যাব ও বুকমার্কে এই আইকনটি প্রদর্শিত হবে</div>
              </div>
            </div>

            <div class="text-start mb-2">
              <label for="favicon_file" class="form-label small fw-semibold">Upload New Favicon (.ico, .png, .svg, .webp)</label>
              <input type="file" class="form-control form-control-sm mb-1" id="favicon_file" name="favicon_file" accept=".ico,.png,.svg,.webp,.jpg,.jpeg">
              <div id="favicon_file_info" class="small text-muted" style="font-size: 0.72rem;">Square 32x32, 64x64, 192x192 বা SVG ফরম্যাট সবচেয়ে ভালো (Max 2MB)।</div>
            </div>

            <div class="text-start mt-3 pt-2 border-top">
              <label for="favicon_url_input" class="form-label small fw-semibold">অথবা Favicon Direct URL:</label>
              <input type="text" class="form-control form-control-sm" id="favicon_url_input" name="favicon" value="{{ old('favicon', $profile->favicon) }}" placeholder="https://... বা /favicon.svg">
            </div>
          </div>
        </div>

        {{-- Hotlines & Contacts --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
          <div class="card-header bg-white py-3 border-bottom">
            <h3 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-telephone-fill text-primary me-2"></i>Hotlines & Contact Info</h3>
          </div>
          <div class="card-body p-3">
            <div class="mb-3">
              <label for="hotline_phone" class="form-label small fw-semibold">Primary Serial Hotline <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="hotline_phone" name="hotline_phone" value="{{ old('hotline_phone', $profile->hotline_phone) }}" required>
            </div>

            <div class="mb-3">
              <label for="hotline_whatsapp" class="form-label small fw-semibold">WhatsApp Number (e.g. 8801700000000) <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="hotline_whatsapp" name="hotline_whatsapp" value="{{ old('hotline_whatsapp', $profile->hotline_whatsapp) }}" required>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label small fw-semibold">Official Doctor Email <span class="text-danger">*</span></label>
              <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $profile->email) }}" required>
            </div>
          </div>
        </div>

        {{-- Social Media Links --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
          <div class="card-header bg-white py-3 border-bottom">
            <h3 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-share-fill text-primary me-2"></i>Social Media Links</h3>
          </div>
          <div class="card-body p-3">
            <div class="mb-3">
              <label for="facebook_url" class="form-label small fw-semibold">Facebook Page URL</label>
              <input type="url" class="form-control" id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $profile->facebook_url) }}">
            </div>

            <div class="mb-3">
              <label for="youtube_url" class="form-label small fw-semibold">YouTube Channel URL</label>
              <input type="url" class="form-control" id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $profile->youtube_url) }}">
            </div>

            <div class="mb-3">
              <label for="linkedin_url" class="form-label small fw-semibold">LinkedIn Profile URL</label>
              <input type="url" class="form-control" id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url', $profile->linkedin_url) }}">
            </div>
          </div>
        </div>

        {{-- Footer & Copyright Settings --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
          <div class="card-header bg-white py-3 border-bottom">
            <h3 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-c-circle text-primary me-2"></i>Footer Custom Text</h3>
          </div>
          <div class="card-body p-3">
            <div class="mb-3">
              <label for="footer_copyright_en" class="form-label small fw-semibold">Custom Copyright (English)</label>
              <input type="text" class="form-control" id="footer_copyright_en" name="footer_copyright_en" value="{{ old('footer_copyright_en', $profile->footer_copyright_en) }}" placeholder="e.g. All Rights Reserved.">
            </div>

            <div class="mb-3">
              <label for="footer_copyright_bn" class="form-label small fw-semibold">Custom Copyright (বাংলা)</label>
              <input type="text" class="form-control" id="footer_copyright_bn" name="footer_copyright_bn" value="{{ old('footer_copyright_bn', $profile->footer_copyright_bn) }}" placeholder="যেমন: সর্বস্বত্ব সংরক্ষিত।">
            </div>

            <div class="mb-3 pt-2 border-top">
              <label for="prescription_footer_text" class="form-label small fw-semibold">Prescription Pad Footer Tagline / Notice</label>
              <input type="text" class="form-control" id="prescription_footer_text" name="prescription_footer_text" value="{{ old('prescription_footer_text', $profile->prescription_footer_text) }}" placeholder="e.g. Official Digital EMR">
              <div class="form-text small" style="font-size: 0.72rem;">ডিফল্ট: <code>Official Digital EMR</code>। এখানে যা লিখবেন তা প্রেসক্রিপশন প্রিন্ট প্যাডের ফুটারে হটলাইনের পাশে শো করবে।</div>
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-success btn-lg w-100 shadow-sm fw-bold">
          <i class="bi bi-check2-circle me-1"></i> Save Changes to drprofile
        </button>
      </div>
    </div>
  </form>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Helper to sync color input with text input
    function bindColorSync(pickerId, textId) {
      var picker = document.getElementById(pickerId);
      var text = document.getElementById(textId);
      if (picker && text) {
        picker.addEventListener('input', function() {
          text.value = picker.value;
        });
        text.addEventListener('input', function() {
          if (/^#[0-9A-Fa-f]{6}$/.test(text.value)) {
            picker.value = text.value;
          }
        });
      }
    }

    bindColorSync('primary_color_picker', 'primary_color');
    bindColorSync('primary_hover_picker', 'primary_hover');
    bindColorSync('accent_color_picker', 'accent_color');
    bindColorSync('accent_hover_picker', 'accent_hover');
    bindColorSync('soft_accent_picker', 'soft_accent');

    // Preset Applicators
    document.querySelectorAll('.js-apply-theme').forEach(function(btn) {
      btn.addEventListener('click', function() {
        var p = btn.getAttribute('data-primary');
        var ph = btn.getAttribute('data-primary-hover');
        var a = btn.getAttribute('data-accent');
        var ah = btn.getAttribute('data-accent-hover');
        var s = btn.getAttribute('data-soft');

        function setVal(id, pId, val) {
          var t = document.getElementById(id);
          var pkr = document.getElementById(pId);
          if (t && val) t.value = val;
          if (pkr && val && /^#[0-9A-Fa-f]{6}$/.test(val)) pkr.value = val;
        }

        setVal('primary_color', 'primary_color_picker', p);
        setVal('primary_hover', 'primary_hover_picker', ph);
        setVal('accent_color', 'accent_color_picker', a);
        setVal('accent_hover', 'accent_hover_picker', ah);
        setVal('soft_accent', 'soft_accent_picker', s);

        // Flash visual indication
        document.querySelectorAll('.js-apply-theme').forEach(function(b) { b.classList.remove('btn-success'); b.classList.add('btn-outline-secondary'); });
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add('btn-success');
      });
    });

    // Live Doctor Avatar Photo Preview
    var avatarInput = document.getElementById('avatar_file');
    var avatarPreview = document.getElementById('doctor_avatar_preview');
    var avatarBadge = document.getElementById('avatar_new_badge');
    var avatarInfo = document.getElementById('avatar_file_info');

    if (avatarInput && avatarPreview) {
      avatarInput.addEventListener('change', function(e) {
        var file = e.target.files && e.target.files[0];
        if (file) {
          if (!file.type.startsWith('image/')) {
            alert('Please select an image file (JPG, PNG, WebP).');
            return;
          }
          if (file.size > 4 * 1024 * 1024) {
            alert('Image size exceeds 4MB. Please select a smaller photo.');
            return;
          }
          var reader = new FileReader();
          reader.onload = function(evt) {
            avatarPreview.src = evt.target.result;
            if (avatarBadge) avatarBadge.classList.remove('d-none');
            if (avatarInfo) {
              avatarInfo.innerHTML = '<span class="text-success fw-semibold"><i class="bi bi-check2-circle me-1"></i>' + file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)</span>';
            }
          };
          reader.readAsDataURL(file);
        }
      });
    }

    // Live Website Favicon Preview
    var favInput = document.getElementById('favicon_file');
    var favUrlInput = document.getElementById('favicon_url_input');
    var favPreviewImg = document.getElementById('favicon_preview_img');
    var favTabPreview = document.getElementById('favicon_tab_preview');
    var favBadge = document.getElementById('favicon_new_badge');
    var favInfo = document.getElementById('favicon_file_info');

    if (favInput) {
      favInput.addEventListener('change', function(e) {
        var file = e.target.files && e.target.files[0];
        if (file) {
          if (file.size > 2 * 1024 * 1024) {
            alert('Favicon file exceeds 2MB.');
            return;
          }
          var reader = new FileReader();
          reader.onload = function(evt) {
            if (favPreviewImg) favPreviewImg.src = evt.target.result;
            if (favTabPreview) favTabPreview.src = evt.target.result;
            if (favBadge) favBadge.classList.remove('d-none');
            if (favInfo) {
              favInfo.innerHTML = '<span class="text-success fw-semibold"><i class="bi bi-check2-circle me-1"></i>' + file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)</span>';
            }
          };
          reader.readAsDataURL(file);
        }
      });
    }

    if (favUrlInput) {
      favUrlInput.addEventListener('input', function(e) {
        var val = e.target.value.trim();
        if (val) {
          if (favPreviewImg) favPreviewImg.src = val;
          if (favTabPreview) favTabPreview.src = val;
          if (favBadge) favBadge.classList.remove('d-none');
        }
      });
    }
  });
</script>
@endsection

