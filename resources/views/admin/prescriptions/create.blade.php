@extends('layouts.admin')

@section('title', 'Write Digital Prescription')
@section('page_heading', 'Digital Prescription (EMR Pad)')

@push('styles')
<style>
  /* 1-Click Clinical Disease Presets - Perfect Hover and Lift */
  .clinical-preset-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.45rem 0.95rem;
    font-size: 0.83rem;
    font-weight: 600;
    border-radius: 50rem;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    border: 1px solid transparent;
    background-color: #ffffff;
    color: #1e293b;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    user-select: none;
    text-decoration: none;
    white-space: nowrap;
  }
  .clinical-preset-pill:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
  }
  .clinical-preset-pill:active {
    transform: scale(0.97);
  }
  .clinical-preset-pill.preset-diabetes {
    border-color: #86efac;
    color: #166534;
    background: #f0fdf4;
  }
  .clinical-preset-pill.preset-diabetes:hover {
    background: #16a34a !important;
    color: #ffffff !important;
    border-color: #16a34a;
  }
  .clinical-preset-pill.preset-diabetes:hover i {
    color: #ffffff !important;
  }
  .clinical-preset-pill.preset-hypertension {
    border-color: #fca5a5;
    color: #991b1b;
    background: #fef2f2;
  }
  .clinical-preset-pill.preset-hypertension:hover {
    background: #dc2626 !important;
    color: #ffffff !important;
    border-color: #dc2626;
  }
  .clinical-preset-pill.preset-hypertension:hover i {
    color: #ffffff !important;
  }
  .clinical-preset-pill.preset-gastric {
    border-color: #93c5fd;
    color: #1e40af;
    background: #eff6ff;
  }
  .clinical-preset-pill.preset-gastric:hover {
    background: #2563eb !important;
    color: #ffffff !important;
    border-color: #2563eb;
  }
  .clinical-preset-pill.preset-gastric:hover i {
    color: #ffffff !important;
  }
  .clinical-preset-pill.preset-fever {
    border-color: #fde047;
    color: #854d0e;
    background: #fefce8;
  }
  .clinical-preset-pill.preset-fever:hover {
    background: #ca8a04 !important;
    color: #ffffff !important;
    border-color: #ca8a04;
  }
  .clinical-preset-pill.preset-fever:hover i {
    color: #ffffff !important;
  }
  .clinical-preset-pill.preset-thyroid {
    border-color: #a5f3fc;
    color: #155e75;
    background: #ecfeff;
  }
  .clinical-preset-pill.preset-thyroid:hover {
    background: #0891b2 !important;
    color: #ffffff !important;
    border-color: #0891b2;
  }
  .clinical-preset-pill.preset-thyroid:hover i {
    color: #ffffff !important;
  }

  /* Quick Dose Pills - High Contrast, Always Visible */
  .quick-pills-bar {
    background: #f8fafc;
    border: 1px solid #cbd5e1;
  }
  .dose-chip {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: #ffffff;
    color: #0f172a !important;
    border: 1.5px solid #94a3b8;
    border-radius: 6px;
    font-size: 0.82rem;
    font-weight: 700;
    padding: 0.28rem 0.65rem;
    line-height: 1.2;
    cursor: pointer;
    transition: all 0.15s ease-in-out;
    box-shadow: 0 1px 2px rgba(0,0,0,0.06);
    user-select: none;
  }
  .dose-chip:hover {
    background-color: #0d6efd;
    color: #ffffff !important;
    border-color: #0d6efd;
    transform: translateY(-1px);
    box-shadow: 0 3px 6px rgba(13, 110, 253, 0.25);
  }
  .dose-chip:active {
    transform: scale(0.95);
  }
  .dose-chip.dose-chip-sos {
    background-color: #fef2f2;
    color: #dc2626 !important;
    border-color: #fca5a5;
  }
  .dose-chip.dose-chip-sos:hover {
    background-color: #dc2626;
    color: #ffffff !important;
    border-color: #dc2626;
  }
  .timing-chip {
    display: inline-flex;
    align-items: center;
    background-color: #ffffff;
    color: #334155 !important;
    border: 1px dashed #64748b;
    border-radius: 6px;
    font-size: 0.78rem;
    font-weight: 600;
    padding: 0.25rem 0.55rem;
    cursor: pointer;
    transition: all 0.15s ease-in-out;
    user-select: none;
  }
  .timing-chip:hover {
    background-color: #0f172a;
    color: #ffffff !important;
    border-color: #0f172a;
    border-style: solid;
  }

  /* Diagnostic Test Chips */
  .test-chips-wrapper {
    overflow-x: auto;
    white-space: nowrap;
    -webkit-overflow-scrolling: touch;
    padding-bottom: 4px;
    scrollbar-width: thin;
  }
  .test-chips-wrapper::-webkit-scrollbar {
    height: 4px;
  }
  .test-chips-wrapper::-webkit-scrollbar-thumb {
    background-color: #cbd5e1;
    border-radius: 4px;
  }
  .test-chip {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    background-color: #f0f9ff;
    color: #0369a1 !important;
    border: 1px solid #7dd3fc;
    border-radius: 6px;
    font-size: 0.76rem;
    font-weight: 600;
    padding: 0.22rem 0.55rem;
    cursor: pointer;
    transition: all 0.15s ease;
    user-select: none;
    flex-shrink: 0;
  }
  .test-chip:hover {
    background-color: #0284c7;
    color: #ffffff !important;
    border-color: #0284c7;
    transform: translateY(-1px);
  }
  .test-chip:active {
    transform: scale(0.95);
  }
  .test-chip .plus-icon {
    font-weight: bold;
    font-size: 0.85rem;
    line-height: 1;
  }

  /* Pulse Animation on field insertion */
  @keyframes inputPulseSuccess {
    0% { box-shadow: 0 0 0 0 rgba(25, 135, 84, 0.5); border-color: #198754; }
    70% { box-shadow: 0 0 0 6px rgba(25, 135, 84, 0); border-color: #198754; }
    100% { box-shadow: none; }
  }
  .field-updated-pulse {
    animation: inputPulseSuccess 0.8s ease-out;
  }
</style>
@endpush

@section('content')
  {{-- Safety Alert Banner (Dynamic via JS) --}}
  <div id="clinicalSafetyBanner" class="alert alert-warning border-warning shadow-sm rounded-4 mb-4 d-none" role="alert">
    <div class="d-flex align-items-center gap-2">
      <i class="bi bi-shield-exclamation fs-4 text-warning"></i>
      <div>
        <div class="fw-bold fs-6" id="safetyAlertTitle">Clinical Safety Notice</div>
        <div class="small" id="safetyAlertDesc">Check clinical vitals or dosage before confirming prescription.</div>
      </div>
    </div>
  </div>

  <form action="{{ route('admin.prescriptions.store') }}" method="POST" id="prescriptionForm">
    @csrf

    {{-- Top Action & Queue Selector Bar --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
      <div class="card-header bg-white py-3 px-4 border-bottom d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div class="d-flex align-items-center gap-2">
          <span class="badge bg-primary fs-6 px-3 py-2 rounded-pill font-monospace">
            <i class="bi bi-prescription2 me-1"></i> {{ old('prescription_no', $nextPrescriptionNo) }}
          </span>
          <input type="hidden" name="prescription_no" value="{{ old('prescription_no', $nextPrescriptionNo) }}">
          <span class="text-muted small">Consultation Date: <strong>{{ date('d M, Y') }}</strong></span>
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
          <label class="small fw-semibold text-dark"><i class="bi bi-person-lines-fill text-success me-1"></i>Queue Shortcut:</label>
          @if(count($recentSerials) > 0)
            <div class="d-flex flex-wrap gap-1 align-items-center">
              @foreach($recentSerials->take(4) as $ser)
                <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2 rounded-pill small js-quick-queue-chip"
                        data-id="{{ $ser->id }}"
                        data-name="{{ $ser->patient_name }}"
                        data-phone="{{ $ser->patient_phone }}"
                        data-age="{{ $ser->patient_age ?? '' }}"
                        data-gender="{{ $ser->patient_gender ?? 'male' }}"
                        data-chamber="{{ $ser->chamber_id ?? '' }}"
                        data-symptoms="{{ $ser->symptoms_summary ?? '' }}"
                        title="Click to auto-fill {{ $ser->patient_name }}">
                  <i class="bi bi-person-check me-1"></i>#{{ $ser->serial_number }} {{ Str::limit($ser->patient_name, 12) }}
                </button>
              @endforeach
            </div>
          @endif
          <select id="quickQueueSelect" class="form-select form-select-sm" style="max-width: 240px;">
            <option value="">-- All Serial Queue Patients --</option>
            @foreach($recentSerials as $ser)
              <option value="{{ $ser->id }}" 
                      data-name="{{ $ser->patient_name }}"
                      data-phone="{{ $ser->patient_phone }}"
                      data-age="{{ $ser->patient_age ?? '' }}"
                      data-gender="{{ $ser->patient_gender ?? 'male' }}"
                      data-chamber="{{ $ser->chamber_id ?? '' }}"
                      data-symptoms="{{ $ser->symptoms_summary ?? '' }}"
                      {{ ($serial && $serial->id == $ser->id) ? 'selected' : '' }}>
                {{ $ser->serial_number }} - {{ $ser->patient_name }} ({{ $ser->patient_phone }})
              </option>
            @endforeach
          </select>
        </div>
      </div>

      {{-- Patient Intake Form --}}
      <div class="card-body p-4">
        <input type="hidden" name="serial_id" id="serialIdInput" value="{{ old('serial_id', $serial->id ?? '') }}">

        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label small fw-semibold text-dark">Patient Full Name <span class="text-danger">*</span></label>
            <input type="text" name="patient_name" id="patientNameInput" class="form-control" value="{{ old('patient_name', $serial->patient_name ?? '') }}" placeholder="e.g. Mohammad Anwar Hossain" required autofocus>
          </div>

          <div class="col-md-3">
            <label class="form-label small fw-semibold text-dark">Mobile Phone</label>
            <input type="tel" name="patient_phone" id="patientPhoneInput" class="form-control" value="{{ old('patient_phone', $serial->patient_phone ?? '') }}" placeholder="017XXXXXXXX (Optional)">
          </div>

          <div class="col-md-2">
            <label class="form-label small fw-semibold text-dark">Age (Years)</label>
            <div class="input-group">
              <input type="number" name="patient_age" id="patientAgeInput" class="form-control" value="{{ old('patient_age', $serial->patient_age ?? '') }}" placeholder="45" min="1" max="120">
              <span class="input-group-text small">Yrs</span>
            </div>
            <div id="ageAlertBadge" class="small mt-1"></div>
          </div>

          <div class="col-md-3">
            <label class="form-label small fw-semibold text-dark">Gender <span class="text-danger">*</span></label>
            <select name="patient_gender" id="patientGenderInput" class="form-select" required>
              <option value="male" {{ old('patient_gender', $serial->patient_gender ?? 'male') == 'male' ? 'selected' : '' }}>Male (পুরুষ)</option>
              <option value="female" {{ old('patient_gender', $serial->patient_gender ?? '') == 'female' ? 'selected' : '' }}>Female (মহিলা)</option>
              <option value="other" {{ old('patient_gender', $serial->patient_gender ?? '') == 'other' ? 'selected' : '' }}>Other (অন্যান্য)</option>
            </select>
          </div>

          <div class="col-md-4">
            <label class="form-label small fw-semibold text-dark">Chamber Location</label>
            <select name="chamber_id" id="chamberIdInput" class="form-select">
              <option value="">-- Select Chamber --</option>
              @foreach($chambers as $ch)
                <option value="{{ $ch->id }}" {{ old('chamber_id', $serial->chamber_id ?? ($loop->first ? $ch->id : '')) == $ch->id ? 'selected' : '' }}>{{ $ch->name_en }} ({{ $ch->badge_en ?? 'Chamber' }})</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-4">
            <label class="form-label small fw-semibold text-dark">Consultation Date <span class="text-danger">*</span></label>
            <input type="date" name="consultation_date" class="form-control" value="{{ old('consultation_date', date('Y-m-d')) }}" required>
          </div>

          <div class="col-md-4">
            <label class="form-label small fw-semibold text-dark">Patient Address / City</label>
            <input type="text" name="patient_address" class="form-control" value="{{ old('patient_address') }}" placeholder="e.g. Dhanmondi, Dhaka">
          </div>
        </div>
      </div>
    </div>

    {{-- Clinical Vitals with Instant Safety Flags --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
      <div class="card-header bg-light py-2 px-4 border-bottom d-flex align-items-center justify-content-between">
        <h3 class="fs-6 fw-bold mb-0 text-dark brand-font d-flex align-items-center gap-2">
          <i class="bi bi-activity text-danger"></i>
          <span>Clinical Vitals & Measurements</span>
        </h3>
        <span class="small text-muted" id="vitalsSafetyStatus"><i class="bi bi-check-circle text-success me-1"></i>Normal parameters</span>
      </div>
      <div class="card-body p-4">
        <div class="row g-3 align-items-end">
          <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold">BP (Systolic)</label>
            <div class="input-group input-group-sm">
              <input type="number" name="bp_systolic" id="bpSystolicInput" class="form-control" value="{{ old('bp_systolic', '120') }}" placeholder="120">
              <span class="input-group-text">mmHg</span>
            </div>
          </div>

          <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold">BP (Diastolic)</label>
            <div class="input-group input-group-sm">
              <input type="number" name="bp_diastolic" id="bpDiastolicInput" class="form-control" value="{{ old('bp_diastolic', '80') }}" placeholder="80">
              <span class="input-group-text">mmHg</span>
            </div>
          </div>

          <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold">Pulse Rate</label>
            <div class="input-group input-group-sm">
              <input type="number" name="pulse" id="pulseInput" class="form-control" value="{{ old('pulse', '76') }}" placeholder="76">
              <span class="input-group-text">bpm</span>
            </div>
          </div>

          <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold">Weight</label>
            <div class="input-group input-group-sm">
              <input type="text" name="weight" class="form-control" value="{{ old('weight') }}" placeholder="70">
              <span class="input-group-text">kg</span>
            </div>
          </div>

          <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold">Temperature</label>
            <div class="input-group input-group-sm">
              <input type="text" name="temperature" class="form-control" value="{{ old('temperature', '98.4') }}" placeholder="98.4">
              <span class="input-group-text">°F</span>
            </div>
          </div>

          <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold">Blood Sugar</label>
            <input type="text" name="blood_sugar" id="bloodSugarInput" class="form-control form-control-sm" value="{{ old('blood_sugar') }}" placeholder="6.5 mmol/L">
          </div>
        </div>

        {{-- Dynamic Live Vital Safety Badges --}}
        <div class="mt-2 pt-2 border-top d-flex flex-wrap gap-2" id="vitalsBadgesContainer">
          <span id="bpBadge" class="badge bg-success-subtle text-success border border-success-subtle fw-normal">BP: Normal</span>
        </div>
      </div>
    </div>

    {{-- Diagnosis & History --}}
    <div class="row g-4 mb-4">
      <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
          <div class="card-header bg-white py-3 border-bottom">
            <h3 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-chat-text text-primary me-2"></i>Chief Complaints & History</h3>
          </div>
          <div class="card-body p-3">
            <label class="form-label small fw-semibold">Chief Complaints (উপসর্গ ও লক্ষণ)</label>
            <textarea name="chief_complaints" id="chiefComplaintsInput" class="form-control mb-3" rows="3" placeholder="e.g. Uncontrolled diabetes, weakness for 2 weeks, polyuria, headache...">{{ old('chief_complaints', $serial->symptoms_summary ?? '') }}</textarea>
            
            <label class="form-label small fw-semibold">Clinical Examination & Past Medical History</label>
            <textarea name="clinical_history" class="form-control" rows="2" placeholder="e.g. Known hypertensive for 5 years on Telmisartan; non-smoker. No drug allergies.">{{ old('clinical_history') }}</textarea>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
          <div class="card-header bg-white py-3 border-bottom">
            <h3 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-search-heart text-danger me-2"></i>Clinical Diagnosis / Impression</h3>
          </div>
          <div class="card-body p-3">
            <div class="d-flex flex-wrap align-items-center gap-1 mb-2">
              <span class="small text-muted me-1" style="font-size: 0.74rem;"><i class="bi bi-tag-fill text-danger me-1"></i>Quick Diagnosis:</span>
              <button type="button" class="btn btn-xs btn-light border py-0 px-2 rounded-pill small js-chip-diag" data-diag="Type 2 Diabetes Mellitus">+ Type 2 DM</button>
              <button type="button" class="btn btn-xs btn-light border py-0 px-2 rounded-pill small js-chip-diag" data-diag="Essential Hypertension">+ Hypertension</button>
              <button type="button" class="btn btn-xs btn-light border py-0 px-2 rounded-pill small js-chip-diag" data-diag="GERD & Functional Dyspepsia">+ Gastric / GERD</button>
              <button type="button" class="btn btn-xs btn-light border py-0 px-2 rounded-pill small js-chip-diag" data-diag="Acute Viral Fever with URTI">+ Viral Fever</button>
              <button type="button" class="btn btn-xs btn-light border py-0 px-2 rounded-pill small js-chip-diag" data-diag="Primary Hypothyroidism">+ Hypothyroidism</button>
              <button type="button" class="btn btn-xs btn-light border py-0 px-2 rounded-pill small js-chip-diag" data-diag="Dyslipidemia">+ Dyslipidemia</button>
            </div>
            <label class="form-label small fw-semibold">Primary Diagnosis (রোগ নির্ণয় / ডায়াগনসিস)</label>
            <textarea name="diagnosis" id="diagnosisInput" class="form-control mb-3" rows="3" placeholder="e.g. Type 2 Diabetes Mellitus with Poor Glycemic Control, Essential Hypertension...">{{ old('diagnosis') }}</textarea>
            
            <label class="form-label small fw-semibold">Confidential Doctor Notes (Internal Doctor Diary)</label>
            <textarea name="doctor_notes" class="form-control" rows="2" placeholder="Notes for doctor reference only (not shown to patient)...">{{ old('doctor_notes') }}</textarea>
          </div>
        </div>
      </div>
    </div>

    {{-- 1-Click Clinical Disease Templates (FAST PRESETS) --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: #f0fdf4; border: 1px solid #bbf7d0 !important;">
      <div class="card-body p-3 p-md-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-2">
          <div>
            <div class="fw-bold text-success d-flex align-items-center gap-2">
              <i class="bi bi-lightning-charge-fill"></i>
              <span>1-Click Clinical Disease Presets (দ্রুত প্রেসক্রিপশন টেমপ্লেট)</span>
            </div>
            <div class="text-muted small" style="font-size: 0.78rem;">
              ক্লিক করলেই প্রচলিত রোগের ওষুধ, ডোজ, পরীক্ষা এবং খাদ্যাভ্যাস পরামর্শ স্বয়ংক্রিয়ভাবে সাজানো হবে।
            </div>
          </div>
        </div>

        <div class="d-flex gap-2 pt-1 overflow-x-auto pb-1 flex-nowrap flex-md-wrap presets-scroll-container">
          <button type="button" class="clinical-preset-pill preset-diabetes flex-shrink-0 js-apply-template" data-template="diabetes">
            <i class="bi bi-droplet-half text-success"></i>
            <span>ডায়াবেটিস রুটিন (Diabetes Followup)</span>
          </button>
          <button type="button" class="clinical-preset-pill preset-hypertension flex-shrink-0 js-apply-template" data-template="hypertension">
            <i class="bi bi-heart-pulse text-danger"></i>
            <span>উচ্চ রক্তচাপ (High BP / Hypertension)</span>
          </button>
          <button type="button" class="clinical-preset-pill preset-gastric flex-shrink-0 js-apply-template" data-template="gastric">
            <i class="bi bi-capsule text-primary"></i>
            <span>গ্যাস্ট্রিক ও এসিডিটি (Dyspepsia / Acid Peptic)</span>
          </button>
          <button type="button" class="clinical-preset-pill preset-fever flex-shrink-0 js-apply-template" data-template="fever">
            <i class="bi bi-thermometer-sun text-warning"></i>
            <span>সাধারণ জ্বর ও সর্দি (Fever & Flu)</span>
          </button>
          <button type="button" class="clinical-preset-pill preset-thyroid flex-shrink-0 js-apply-template" data-template="thyroid">
            <i class="bi bi-shield-check text-info"></i>
            <span>হাইপোথাইরয়েড (Hypothyroidism)</span>
          </button>
        </div>
      </div>
    </div>

    {{-- Rx Prescribed Medicines & Dosages --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
      <div class="card-header bg-white py-3 px-3 px-md-4 border-bottom d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2">
        <div class="d-flex align-items-center gap-2">
          <span class="fs-4 fw-bold text-primary font-monospace">Rx</span>
          <div>
            <h3 class="fs-6 fw-bold mb-0 text-dark brand-font">Prescribed Medicines & Dosages</h3>
            <div class="text-muted" style="font-size: 0.75rem;">খালি সারি রাখলে স্বয়ংক্রিয়ভাবে বাদ দেওয়া হবে (Safe auto-clean on save).</div>
          </div>
        </div>
        <button type="button" class="btn btn-sm btn-success fw-bold px-3 py-2 w-100 w-sm-auto" id="addMedicineBtn">
          <i class="bi bi-plus-circle me-1"></i> Add Another Medicine
        </button>
      </div>

      {{-- Duplicate Warning Alert --}}
      <div id="duplicateMedicineAlert" class="alert alert-warning m-3 mb-0 rounded-3 d-none">
        <i class="bi bi-exclamation-triangle-fill me-1"></i>
        <span><strong>ডুপ্লিকেট ওষুধ সতর্কতা:</strong> একই ওষুধ একাধিক সারিতে যোগ করা হয়েছে!</span>
      </div>

      <div class="card-body p-3 p-md-4">
        {{-- Fast 1-Click Popular Medicines Palette --}}
        <div class="p-2 mb-2 rounded-3 bg-white border border-primary-subtle d-flex flex-nowrap flex-md-wrap align-items-center gap-1 shadow-xs overflow-x-auto">
          <span class="text-primary fw-bold small me-1 flex-shrink-0" style="font-size: 0.76rem;">
            <i class="bi bi-lightning-charge-fill text-warning"></i> 1-Click Fast Drugs:
          </span>
          <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2 rounded-pill small flex-shrink-0 js-fast-add-med" data-name="Tab. Napa Extra" data-dose="১ + ০ + ১" data-timing="খাবারের পরে (After Meal)" data-duration="৫ দিন" data-inst="ভরা পেটে সেব্য">+ Napa Extra</button>
          <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2 rounded-pill small flex-shrink-0 js-fast-add-med" data-name="Cap. Seclo 20mg" data-dose="১ + ০ + ১" data-timing="খাবারের ৩০ মিনিট আগে (Before Meal)" data-duration="১৪ দিন" data-inst="খালি পেটে সেব্য">+ Seclo 20</button>
          <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2 rounded-pill small flex-shrink-0 js-fast-add-med" data-name="Tab. Monas 10mg" data-dose="০ + ০ + ১" data-timing="রাতে ঘুমানোর আগে (Bedtime)" data-duration="১ মাস" data-inst="রাতে সেব্য">+ Monas 10</button>
          <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2 rounded-pill small flex-shrink-0 js-fast-add-med" data-name="Tab. Fexofenadine 120mg" data-dose="০ + ০ + ১" data-timing="রাতে ঘুমানোর আগে (Bedtime)" data-duration="৭ দিন" data-inst="অ্যালার্জির জন্য">+ Fexo 120</button>
          <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2 rounded-pill small flex-shrink-0 js-fast-add-med" data-name="Tab. Metformin 500mg" data-dose="১ + ০ + ১" data-timing="খাবার সাথে সাথে (With Meal)" data-duration="চলবে" data-inst="নিয়মিত সেব্য">+ Metformin 500</button>
          <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2 rounded-pill small flex-shrink-0 js-fast-add-med" data-name="Tab. Telmisartan 40mg" data-dose="১ + ০ + ০" data-timing="সকালে খাবারের পর (Morning)" data-duration="চলবে" data-inst="প্রেশারের ওষুধ">+ Telmisartan 40</button>
          <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2 rounded-pill small flex-shrink-0 js-fast-add-med" data-name="Tab. Bicozin" data-dose="১ + ০ + ১" data-timing="খাবারের পরে (After Meal)" data-duration="১ মাস" data-inst="ভিটামিন">+ Bicozin</button>
          <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2 rounded-pill small flex-shrink-0 js-fast-add-med" data-name="Cap. Azithromycin 500mg" data-dose="১ + ০ + ০" data-timing="খাবারের ১ ঘণ্টা আগে (Empty Stomach)" data-duration="৫ দিন" data-inst="অ্যান্টিবায়োটিক">+ Azithromycin 500</button>
          <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2 rounded-pill small flex-shrink-0 js-fast-add-med" data-name="Tab. Ceevit 250mg" data-dose="১ + ০ + ১" data-timing="খাবারের পরে (After Meal)" data-duration="১৫ দিন" data-inst="চুষে সেব্য">+ Ceevit</button>
        </div>

        {{-- Quick Dosage & Timing Chips Helper (High Contrast, Bold, Guaranteed Visible) --}}
        <div class="quick-pills-bar p-2 p-md-3 mb-3 rounded-3 d-flex flex-nowrap flex-md-wrap align-items-center gap-1 gap-md-2 overflow-x-auto">
          <span class="text-dark fw-bold small me-1 d-flex align-items-center gap-1 flex-shrink-0">
            <i class="bi bi-capsule-pill text-primary"></i> Quick Dose Pills:
          </span>
          <button type="button" class="dose-chip flex-shrink-0 js-chip-dose" data-val="১ + ০ + ১">১+০+১</button>
          <button type="button" class="dose-chip flex-shrink-0 js-chip-dose" data-val="১ + ০ + ০">১+০+০</button>
          <button type="button" class="dose-chip flex-shrink-0 js-chip-dose" data-val="০ + ০ + ১">০+০+১</button>
          <button type="button" class="dose-chip flex-shrink-0 js-chip-dose" data-val="১ + ১ + ১">১+১+১</button>
          <button type="button" class="dose-chip flex-shrink-0 js-chip-dose" data-val="০ + ১ + ০">০+১+০</button>
          <button type="button" class="dose-chip flex-shrink-0 js-chip-dose" data-val="১/২ + ০ + ১/২">১/২+০+১/২</button>
          <button type="button" class="dose-chip flex-shrink-0 js-chip-dose" data-val="১ চামচ করে ৩ বার">১ চামচ ৩ বার</button>
          <button type="button" class="dose-chip dose-chip-sos flex-shrink-0 js-chip-dose" data-val="প্রয়োজনে (SOS)">🚨 প্রয়োজনে (SOS)</button>
          
          <div class="vr mx-1 d-none d-sm-inline-block text-secondary"></div>
          <button type="button" class="timing-chip flex-shrink-0 js-chip-timing" data-val="খাবারের পরে (After Meal)">খাবারের পরে</button>
          <button type="button" class="timing-chip flex-shrink-0 js-chip-timing" data-val="খাবারের আগে (Before Meal)">খাবারের আগে</button>
          <button type="button" class="timing-chip flex-shrink-0 js-chip-timing" data-val="সকালে খালি পেটে (Empty Stomach)">খালি পেটে</button>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered align-middle mb-0 mobile-card-table" id="medicinesTable">
            <thead class="table-light small text-muted text-uppercase">
              <tr>
                <th style="width: 32%;">Medicine Name & Strength <span class="text-danger">*</span></th>
                <th style="width: 17%;">Dosage (ডোজ)</th>
                <th style="width: 19%;">Timing (সময়)</th>
                <th style="width: 14%;">Duration (মেয়াদ)</th>
                <th style="width: 14%;">Instruction</th>
                <th style="width: 4%;" class="text-center">Action</th>
              </tr>
            </thead>
            <tbody id="medicineRowsContainer">
              {{-- Default Row 1 --}}
              <tr class="medicine-row">
                <td data-label="Medicine Name & Strength">
                  <input type="text" name="medicines[0][name]" list="commonMedicineNames" class="form-control form-control-sm js-med-name" placeholder="e.g. Tab. Metformin 500mg" required>
                </td>
                <td data-label="Dosage (ডোজ)">
                  <input type="text" name="medicines[0][dose]" class="form-control form-control-sm js-med-dose" placeholder="১ + ০ + ১" value="১ + ০ + ১">
                  <div class="d-flex flex-wrap gap-1 mt-1">
                    <button type="button" class="btn btn-xs btn-light border py-0 px-1 js-inline-dose" data-val="১ + ০ + ১" style="font-size:0.7rem;">১+০+১</button>
                    <button type="button" class="btn btn-xs btn-light border py-0 px-1 js-inline-dose" data-val="১ + ০ + ০" style="font-size:0.7rem;">১+০+০</button>
                    <button type="button" class="btn btn-xs btn-light border py-0 px-1 js-inline-dose" data-val="০ + ০ + ১" style="font-size:0.7rem;">০+০+১</button>
                    <button type="button" class="btn btn-xs btn-light border py-0 px-1 js-inline-dose" data-val="১ + ১ + ১" style="font-size:0.7rem;">১+১+১</button>
                  </div>
                </td>
                <td data-label="Timing (সময়)">
                  <select name="medicines[0][timing]" class="form-select form-select-sm js-med-timing">
                    <option value="খাবারের পরে (After Meal)">খাবারের পরে (After Meal)</option>
                    <option value="খাবারের আগে (Before Meal)">খাবারের আগে (Before Meal)</option>
                    <option value="সকালে খালি পেটে (Empty Stomach)">সকালে খালি পেটে (Empty Stomach)</option>
                    <option value="খাবার সাথে সাথে (With Meal)">খাবার সাথে সাথে (With Meal)</option>
                    <option value="রাতে ঘুমানোর আগে (Bedtime)">রাতে ঘুমানোর আগে (Bedtime)</option>
                    <option value="ব্যথার সময় প্রয়োজনে (When Needed/SOS)">ব্যথার সময় প্রয়োজনে (SOS)</option>
                  </select>
                </td>
                <td data-label="Duration (মেয়াদ)">
                  <input type="text" name="medicines[0][duration]" class="form-control form-control-sm js-med-duration" placeholder="১ মাস / চলবে" value="১ মাস">
                </td>
                <td data-label="Instruction (নির্দেশনা)">
                  <input type="text" name="medicines[0][instructions]" class="form-control form-control-sm js-med-instruction" placeholder="নিয়মিত সেব্য" value="নিয়মিত সেব্য">
                </td>
                <td class="text-center" data-label="">
                  <button type="button" class="btn btn-sm btn-outline-danger p-1 px-2 remove-row-btn" title="Remove Medicine">
                    <i class="bi bi-trash me-1"></i><span class="d-md-none">Remove</span>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    {{-- Diagnostic Investigations & Advice --}}
    <div class="row g-4 mb-4">
      <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
          <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h3 class="fs-6 fw-bold mb-0 text-dark brand-font d-flex align-items-center gap-2">
              <i class="bi bi-eyedropper text-info"></i>
              <span>Diagnostic Tests (ল্যাব ও টেস্ট)</span>
            </h3>
            <button type="button" class="btn btn-sm btn-outline-info fw-semibold" id="addInvestigationBtn">
              <i class="bi bi-plus-lg me-1"></i> Add Custom Test
            </button>
          </div>
          <div class="card-body p-3">
            {{-- Quick Select Test Dropdown (Categorized, Zero Typing) --}}
            <div class="mb-2">
              <div class="input-group input-group-sm">
                <span class="input-group-text bg-light text-primary border-secondary-subtle fw-bold">
                  <i class="bi bi-search me-1"></i> Quick Test Select:
                </span>
                <select id="quickTestDropdown" class="form-select form-select-sm">
                  <option value="">-- Choose Common Test from List --</option>
                  <optgroup label="🩸 Blood Tests (রক্ত পরীক্ষা)">
                    <option value="CBC with ESR" data-inst="Routine">CBC with ESR</option>
                    <option value="RBS (Random Blood Sugar)" data-inst="Before Consultation">RBS (Random Blood Sugar)</option>
                    <option value="FBS & 2HABF" data-inst="Overnight 8-10 hrs fasting & 2h after breakfast">FBS & 2HABF</option>
                    <option value="HbA1c" data-inst="Routine">HbA1c</option>
                    <option value="Serum Creatinine" data-inst="Routine">Serum Creatinine</option>
                    <option value="Lipid Profile" data-inst="10-12 hrs fasting">Lipid Profile</option>
                    <option value="SGPT (ALT)" data-inst="Routine">SGPT (ALT)</option>
                    <option value="SGOT (AST)" data-inst="Routine">SGOT (AST)</option>
                    <option value="Serum Bilirubin (Total & Direct)" data-inst="Routine">Serum Bilirubin</option>
                    <option value="Serum Electrolytes (Na+, K+, Cl-)" data-inst="Routine">Serum Electrolytes</option>
                    <option value="Serum Uric Acid" data-inst="Routine">Serum Uric Acid</option>
                    <option value="Serum TSH" data-inst="Early morning sample">Serum TSH</option>
                    <option value="Free T4 (FT4)" data-inst="Routine">Free T4 (FT4)</option>
                    <option value="Serum Calcium & Albumin" data-inst="Routine">Serum Calcium & Albumin</option>
                    <option value="Serum Vitamin D3 (25-OH)" data-inst="Routine">Serum Vitamin D3</option>
                    <option value="Serum Ferritin" data-inst="Routine">Serum Ferritin</option>
                    <option value="CRP (Quantitative)" data-inst="Routine">CRP (Quantitative)</option>
                    <option value="Troponin-I (High Sensitive)" data-inst="Urgent / STAT">Troponin-I</option>
                    <option value="Dengue NS1 Ag & CBC" data-inst="Immediate / STAT">Dengue NS1 Ag & CBC</option>
                    <option value="Widal Test" data-inst="Routine">Widal Test</option>
                    <option value="HBsAg (Screening)" data-inst="Routine">HBsAg</option>
                  </optgroup>
                  <optgroup label="🧪 Urine & Stool (প্রস্রাব ও মল পরীক্ষা)">
                    <option value="Urine R/M/E" data-inst="Clean catch midstream morning sample">Urine R/M/E</option>
                    <option value="Urine C/S" data-inst="Sterile container midstream">Urine C/S</option>
                    <option value="Urine for Microalbumin" data-inst="First morning void">Urine for Microalbumin</option>
                    <option value="Stool R/M/E" data-inst="Routine fresh stool">Stool R/M/E</option>
                    <option value="Stool for Occult Blood (OBT)" data-inst="No red meat for 3 days">Stool OBT</option>
                  </optgroup>
                  <optgroup label="📷 Radiology & Imaging (এক্স-রে ও আল্ট্রা)">
                    <option value="Chest X-Ray P/A View" data-inst="Full inspiration">Chest X-Ray P/A View</option>
                    <option value="USG of Whole Abdomen" data-inst="Overnight fasting & full bladder">USG of Whole Abdomen</option>
                    <option value="USG of KUB & Prostate" data-inst="Full bladder with strong urge">USG of KUB & Prostate</option>
                    <option value="USG of Thyroid Gland" data-inst="Routine">USG of Thyroid Gland</option>
                    <option value="X-Ray Lumbo-Sacral Spine (B/V)" data-inst="Routine">X-Ray LS Spine (B/V)</option>
                    <option value="X-Ray Both Knee Joints (A/P & Lat)" data-inst="Standing">X-Ray Both Knee Joints</option>
                  </optgroup>
                  <optgroup label="🫀 Cardiology & Special (ইসিজি ও অন্যান্য)">
                    <option value="ECG (12-Lead Resting)" data-inst="At rest">ECG (12-Lead Resting)</option>
                    <option value="Echocardiogram (2D & Color Doppler)" data-inst="Routine">Echocardiogram (Echo)</option>
                    <option value="ETT (Exercise Tolerance Test)" data-inst="Comfortable clothing & light meal">ETT</option>
                    <option value="Endoscopy of Upper GI (OGD)" data-inst="Overnight fasting (8 hours)">Endoscopy (OGD)</option>
                    <option value="Colonoscopy" data-inst="Bowel preparation as advised">Colonoscopy</option>
                    <option value="Spirometry (PFT)" data-inst="Routine">Spirometry (PFT)</option>
                  </optgroup>
                </select>
              </div>
            </div>

            {{-- 1-Click Most Common Test Badges (Mobile-friendly horizontal scroll) --}}
            <div class="test-chips-wrapper mb-3 d-flex align-items-center gap-1">
              <span class="small text-muted me-1 flex-shrink-0" style="font-size: 0.72rem;"><i class="bi bi-stars text-warning"></i> Frequent:</span>
              <button type="button" class="test-chip js-quick-add-test" data-test="CBC with ESR" data-inst="Routine"><span class="plus-icon">+</span> CBC</button>
              <button type="button" class="test-chip js-quick-add-test" data-test="RBS (Random Blood Sugar)" data-inst="Before Consultation"><span class="plus-icon">+</span> RBS</button>
              <button type="button" class="test-chip js-quick-add-test" data-test="HbA1c" data-inst="Routine"><span class="plus-icon">+</span> HbA1c</button>
              <button type="button" class="test-chip js-quick-add-test" data-test="Serum Creatinine" data-inst="Routine"><span class="plus-icon">+</span> S. Creatinine</button>
              <button type="button" class="test-chip js-quick-add-test" data-test="Lipid Profile" data-inst="10-12 hrs fasting"><span class="plus-icon">+</span> Lipid Profile</button>
              <button type="button" class="test-chip js-quick-add-test" data-test="SGPT (ALT)" data-inst="Routine"><span class="plus-icon">+</span> SGPT</button>
              <button type="button" class="test-chip js-quick-add-test" data-test="Serum Electrolytes" data-inst="Routine"><span class="plus-icon">+</span> Electrolytes</button>
              <button type="button" class="test-chip js-quick-add-test" data-test="Serum TSH" data-inst="Early morning"><span class="plus-icon">+</span> TSH</button>
              <button type="button" class="test-chip js-quick-add-test" data-test="Urine R/M/E" data-inst="Clean catch midstream morning sample"><span class="plus-icon">+</span> Urine R/E</button>
              <button type="button" class="test-chip js-quick-add-test" data-test="ECG (12-Lead Resting)" data-inst="At rest"><span class="plus-icon">+</span> ECG</button>
              <button type="button" class="test-chip js-quick-add-test" data-test="Chest X-Ray P/A View" data-inst="Full inspiration"><span class="plus-icon">+</span> Chest X-Ray</button>
              <button type="button" class="test-chip js-quick-add-test" data-test="USG of Whole Abdomen" data-inst="Overnight fasting & full bladder"><span class="plus-icon">+</span> USG Abdomen</button>
            </div>

            {{-- Investigation Rows Container --}}
            <div id="investigationsContainer">
              <div class="input-group input-group-sm mb-2 investigation-row">
                <input type="text" name="investigations[0][name]" list="commonDiagnosticTests" class="form-control" placeholder="Test Name (e.g. HbA1c)" value="HbA1c">
                <input type="text" name="investigations[0][instructions]" list="commonTestInstructions" class="form-control" placeholder="Fast 8-10 hrs" value="Fasting">
                <button type="button" class="btn btn-outline-danger remove-inv-btn" title="Remove"><i class="bi bi-trash"></i></button>
              </div>
              <div class="input-group input-group-sm mb-2 investigation-row">
                <input type="text" name="investigations[1][name]" list="commonDiagnosticTests" class="form-control" placeholder="Test Name (e.g. Serum Creatinine)" value="Serum Creatinine">
                <input type="text" name="investigations[1][instructions]" list="commonTestInstructions" class="form-control" placeholder="Routine" value="Routine">
                <button type="button" class="btn btn-outline-danger remove-inv-btn" title="Remove"><i class="bi bi-trash"></i></button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
          <div class="card-header bg-white py-3 border-bottom">
            <h3 class="fs-6 fw-bold mb-0 text-dark brand-font d-flex align-items-center gap-2">
              <i class="bi bi-heart-pulse-fill text-success"></i>
              <span>Dietary & Clinical Advice (রোগীর পরামর্শ)</span>
            </h3>
          </div>
          <div class="card-body p-3">
            <div class="d-flex flex-wrap align-items-center gap-1 mb-2">
              <span class="small text-muted me-1" style="font-size: 0.74rem;"><i class="bi bi-chat-heart text-success me-1"></i>Quick Advice:</span>
              <button type="button" class="btn btn-xs btn-light border py-0 px-2 rounded-pill small js-chip-advice" data-text="প্রতিদিন ৪৫ মিনিট দ্রুত হাঁটবেন।">+ ৪৫ মি. হাঁটা</button>
              <button type="button" class="btn btn-xs btn-light border py-0 px-2 rounded-pill small js-chip-advice" data-text="মিষ্টি, চিনি ও মিষ্টিজাতীয় খাবার সম্পূর্ণ পরিহার করবেন।">+ মিষ্টি বর্জন</button>
              <button type="button" class="btn btn-xs btn-light border py-0 px-2 rounded-pill small js-chip-advice" data-text="খাবারে বাড়তি কাঁচা লবণ খাবেন না।">+ কাঁচা লবণ নিষেধ</button>
              <button type="button" class="btn btn-xs btn-light border py-0 px-2 rounded-pill small js-chip-advice" data-text="অতিরিক্ত তেল-চর্বি ও ভাজাপোড়া খাবার পরিহার করবেন।">+ তেল-চর্বি নিষেধ</button>
              <button type="button" class="btn btn-xs btn-light border py-0 px-2 rounded-pill small js-chip-advice" data-text="প্রতিদিন প্রচুর পরিমাণে বিশুদ্ধ পানি পান করবেন।">+ প্রচুর পানি পান</button>
              <button type="button" class="btn btn-xs btn-light border py-0 px-2 rounded-pill small js-chip-advice" data-text="ধূমপান ও জর্দা সম্পূর্ণ পরিহার করুন।">+ ধূমপান বর্জন</button>
              <button type="button" class="btn btn-xs btn-light border py-0 px-2 rounded-pill small js-chip-advice" data-text="প্রেসার ও ডায়াবেটিসের ওষুধ নিজে নিজে বন্ধ করবেন না।">+ ওষুধ বন্ধ নিষেধ</button>
            </div>
            <textarea name="special_advice" id="specialAdviceInput" class="form-control mb-3" rows="3" placeholder="Advice for patient...">নিয়মিত ৪৫ মিনিট দ্রুত হাঁটবেন। খাবারে বাড়তি লবণ ও চিনি পরিহার করবেন। পর্যাপ্ত পানি পান করবেন এবং প্রেসার ও ডায়াবেটিসের ওষুধ বন্ধ করবেন না।</textarea>
            
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-1">
              <label class="form-label small fw-semibold mb-0">Next Review / Visit Date (পরবর্তী সাক্ষাতের তারিখ)</label>
              <div class="d-flex flex-wrap gap-1">
                <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 rounded-pill js-chip-followup" data-days="7">৭ দিন পর</button>
                <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 rounded-pill js-chip-followup" data-days="10">১০ দিন পর</button>
                <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 rounded-pill js-chip-followup" data-days="14">১৪ দিন পর</button>
                <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 rounded-pill js-chip-followup" data-days="30">১ মাস পর</button>
                <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 rounded-pill js-chip-followup" data-days="90">৩ মাস পর</button>
              </div>
            </div>
            <input type="date" name="next_visit_date" id="nextVisitDateInput" class="form-control" value="{{ date('Y-m-d', strtotime('+30 days')) }}">
          </div>
        </div>
      </div>
    </div>

    {{-- Sticky Submit Action Bar --}}
    <div class="card border-0 shadow rounded-4 mb-5 p-3 bg-white d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center justify-content-between gap-3">
      <div class="d-flex align-items-center justify-content-between gap-2">
        <a href="{{ route('admin.prescriptions.index') }}" class="btn btn-outline-secondary px-3 py-2">
          <i class="bi bi-x-lg me-1"></i> Cancel
        </a>
        <span class="badge bg-light text-muted border d-none d-md-inline-block">
          <kbd>Ctrl</kbd> + <kbd>Enter</kbd> to Save & Print
        </span>
      </div>
      <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-2">
        <button type="submit" class="btn btn-success btn-lg px-3 px-md-4 fw-bold shadow-sm d-inline-flex align-items-center justify-content-center gap-2" id="saveBtn">
          <i class="bi bi-check2-circle fs-5"></i>
          <span>Save Prescription</span>
        </button>
        <button type="submit" name="action" value="save_and_print" class="btn btn-primary btn-lg px-3 px-md-4 fw-bold shadow-sm d-inline-flex align-items-center justify-content-center gap-2" id="saveAndPrintBtn">
          <i class="bi bi-printer-fill fs-5"></i>
          <span>Save & Print Directly</span>
        </button>
      </div>
    </div>

    {{-- Common Medicine Names Autocomplete Datalist --}}
    <datalist id="commonMedicineNames">
      <option value="Tab. Napa 500mg">
      <option value="Tab. Napa Extra">
      <option value="Tab. Napa Extend 665mg">
      <option value="Syp. Napa">
      <option value="Tab. Ace 500mg">
      <option value="Tab. Ace Plus">
      <option value="Cap. Seclo 20mg">
      <option value="Cap. Sergel 20mg">
      <option value="Tab. Maxpro 20mg">
      <option value="Cap. Pantonix 20mg">
      <option value="Tab. Finix 20mg">
      <option value="Tab. Monas 10mg">
      <option value="Tab. Montene 10mg">
      <option value="Tab. Fexofenadine 120mg">
      <option value="Tab. Fexo 180mg">
      <option value="Tab. Alatrol 10mg">
      <option value="Tab. Bilastin 20mg">
      <option value="Tab. Metformin 500mg">
      <option value="Tab. Metfo 850mg">
      <option value="Tab. Comet 500mg">
      <option value="Tab. Empagliflozin 10mg">
      <option value="Tab. Jardiance 10mg">
      <option value="Tab. Linagliptin 5mg">
      <option value="Tab. Trajenta 5mg">
      <option value="Tab. Telmisartan 40mg">
      <option value="Tab. Telma 40mg">
      <option value="Tab. Bisoprolol 2.5mg">
      <option value="Tab. Bisocor 2.5mg">
      <option value="Tab. Amlodipine 5mg">
      <option value="Tab. Camlosart 5/40">
      <option value="Tab. Losartan Potassium 50mg">
      <option value="Tab. Osartil 50mg">
      <option value="Tab. Rosuvastatin 10mg">
      <option value="Tab. Rovator 10mg">
      <option value="Tab. Atorvastatin 10mg">
      <option value="Tab. Storvas 10mg">
      <option value="Tab. Bicozin">
      <option value="Tab. Aristovit B">
      <option value="Tab. Neuro-B">
      <option value="Tab. Calbo-D">
      <option value="Tab. Coralcal-D">
      <option value="Cap. D-Rise 20000 IU">
      <option value="Cap. Azithromycin 500mg">
      <option value="Cap. Zithrin 500mg">
      <option value="Cap. Cefixime 200mg">
      <option value="Cap. Cef-3 200mg">
      <option value="Tab. Ciprocin 500mg">
      <option value="Tab. Moxaclav 625mg">
      <option value="Tab. Domperidone 10mg">
      <option value="Tab. Motigut 10mg">
      <option value="Tab. Levothyroxine 50mcg">
      <option value="Tab. Thyrox 50mcg">
      <option value="Tab. Ketorolac 10mg">
      <option value="Tab. Naproxen 500mg">
      <option value="Tab. Ceevit 250mg">
    </datalist>

    {{-- Comprehensive Clinical Datalists for Autocomplete --}}
    <datalist id="commonDiagnosticTests">
      <option value="CBC with ESR">
      <option value="RBS (Random Blood Sugar)">
      <option value="FBS (Fasting Blood Sugar)">
      <option value="2HABF (2 Hours After Breakfast)">
      <option value="HbA1c">
      <option value="Serum Creatinine">
      <option value="Lipid Profile">
      <option value="SGPT (ALT)">
      <option value="SGOT (AST)">
      <option value="Serum Bilirubin (Total & Direct)">
      <option value="Serum Electrolytes (Na+, K+, Cl-)">
      <option value="Serum Uric Acid">
      <option value="Serum TSH">
      <option value="Free T4 (FT4)">
      <option value="Serum Calcium & Albumin">
      <option value="Serum Vitamin D3 (25-OH)">
      <option value="Serum Ferritin">
      <option value="CRP (Quantitative)">
      <option value="Troponin-I (High Sensitive)">
      <option value="Dengue NS1 Ag & CBC">
      <option value="Widal Test">
      <option value="HBsAg (Screening)">
      <option value="Anti-HCV">
      <option value="Urine R/M/E">
      <option value="Urine C/S">
      <option value="Urine for Microalbumin">
      <option value="Stool R/M/E">
      <option value="Stool for Occult Blood (OBT)">
      <option value="Chest X-Ray P/A View">
      <option value="USG of Whole Abdomen">
      <option value="USG of KUB & Prostate">
      <option value="USG of Thyroid Gland">
      <option value="ECG (12-Lead Resting)">
      <option value="Echocardiogram (Echo)">
      <option value="ETT (Exercise Tolerance Test)">
      <option value="Endoscopy of Upper GI (OGD)">
      <option value="Colonoscopy">
      <option value="Spirometry (PFT)">
    </datalist>

    <datalist id="commonTestInstructions">
      <option value="Overnight fasting (8-10 hrs)">
      <option value="10-12 hrs fasting">
      <option value="Full bladder with strong urge">
      <option value="Clean catch midstream morning sample">
      <option value="Routine">
      <option value="Urgent / STAT">
      <option value="Early morning sample">
      <option value="Before consultation">
      <option value="At rest">
    </datalist>
  </form>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var medIdx = 1;
    var invIdx = 2;
    var rowsContainer = document.getElementById('medicineRowsContainer');
    var addMedicineBtn = document.getElementById('addMedicineBtn');
    var activeDoseInput = null;

    // Track active dose input for quick chips
    document.addEventListener('focusin', function(e) {
      if (e.target && e.target.classList.contains('js-med-dose')) {
        activeDoseInput = e.target;
      }
    });

    // 1. Quick Dose & Timing Pills (Always visible & interactive with visual pulse)
    document.querySelectorAll('.js-chip-dose').forEach(function(chip) {
      chip.addEventListener('click', function() {
        var val = this.getAttribute('data-val');
        if (!activeDoseInput || !document.contains(activeDoseInput)) {
          var allDose = document.querySelectorAll('.js-med-dose');
          if (allDose.length > 0) activeDoseInput = allDose[allDose.length - 1];
        }
        if (activeDoseInput) {
          activeDoseInput.value = val;
          activeDoseInput.focus();
          activeDoseInput.classList.add('field-updated-pulse');
          setTimeout(function() {
            activeDoseInput.classList.remove('field-updated-pulse');
          }, 800);
        }
      });
    });

    document.querySelectorAll('.js-chip-timing').forEach(function(chip) {
      chip.addEventListener('click', function() {
        var val = this.getAttribute('data-val');
        var allTiming = document.querySelectorAll('.js-med-timing');
        if (allTiming.length > 0) {
          var targetSelect = allTiming[allTiming.length - 1];
          if (activeDoseInput && document.contains(activeDoseInput)) {
            var row = activeDoseInput.closest('.medicine-row');
            if (row) {
              var rowSelect = row.querySelector('.js-med-timing');
              if (rowSelect) targetSelect = rowSelect;
            }
          }
          targetSelect.value = val;
          targetSelect.classList.add('field-updated-pulse');
          setTimeout(function() {
            targetSelect.classList.remove('field-updated-pulse');
          }, 800);
        }
      });
    });

    // 2. Add New Medicine Row
    if (addMedicineBtn && rowsContainer) {
      addMedicineBtn.addEventListener('click', function() {
        addMedicineRow('', '১ + ০ + ১', 'খাবারের পরে (After Meal)', '১ মাস', 'নিয়মিত সেব্য');
      });

      // Remove row
      rowsContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-row-btn')) {
          var rows = rowsContainer.querySelectorAll('.medicine-row');
          if (rows.length > 1) {
            e.target.closest('.medicine-row').remove();
            checkDuplicateMedicines();
          } else {
            alert('At least one medicine row must remain.');
          }
        }
      });
    }

    function addMedicineRow(name, dose, timing, duration, instructions, shouldPulse) {
      var tr = document.createElement('tr');
      tr.className = 'medicine-row';
      tr.innerHTML = `
        <td data-label="Medicine Name & Strength">
          <input type="text" name="medicines[${medIdx}][name]" list="commonMedicineNames" class="form-control form-control-sm js-med-name ${shouldPulse ? 'field-updated-pulse' : ''}" placeholder="Medicine Name & Strength" value="${name || ''}">
        </td>
        <td data-label="Dosage (ডোজ)">
          <input type="text" name="medicines[${medIdx}][dose]" class="form-control form-control-sm js-med-dose" placeholder="১ + ০ + ১" value="${dose || '১ + ০ + ১'}">
          <div class="d-flex flex-wrap gap-1 mt-1">
            <button type="button" class="btn btn-xs btn-light border py-0 px-1 js-inline-dose" data-val="১ + ০ + ১" style="font-size:0.7rem;">১+০+১</button>
            <button type="button" class="btn btn-xs btn-light border py-0 px-1 js-inline-dose" data-val="১ + ০ + ০" style="font-size:0.7rem;">১+০+০</button>
            <button type="button" class="btn btn-xs btn-light border py-0 px-1 js-inline-dose" data-val="০ + ০ + ১" style="font-size:0.7rem;">০+০+১</button>
            <button type="button" class="btn btn-xs btn-light border py-0 px-1 js-inline-dose" data-val="১ + ১ + ১" style="font-size:0.7rem;">১+১+১</button>
          </div>
        </td>
        <td data-label="Timing (সময়)">
          <select name="medicines[${medIdx}][timing]" class="form-select form-select-sm js-med-timing">
            <option value="খাবারের পরে (After Meal)" ${timing === 'খাবারের পরে (After Meal)' ? 'selected' : ''}>খাবারের পরে (After Meal)</option>
            <option value="খাবারের আগে (Before Meal)" ${timing === 'খাবারের আগে (Before Meal)' ? 'selected' : ''}>খাবারের আগে (Before Meal)</option>
            <option value="সকালে খালি পেটে (Empty Stomach)" ${timing === 'সকালে খালি পেটে (Empty Stomach)' ? 'selected' : ''}>সকালে খালি পেটে (Empty Stomach)</option>
            <option value="খাবার সাথে সাথে (With Meal)" ${timing === 'খাবার সাথে সাথে (With Meal)' ? 'selected' : ''}>খাবার সাথে সাথে (With Meal)</option>
            <option value="রাতে ঘুমানোর আগে (Bedtime)" ${timing === 'রাতে ঘুমানোর আগে (Bedtime)' ? 'selected' : ''}>রাতে ঘুমানোর আগে (Bedtime)</option>
            <option value="ব্যথার সময় প্রয়োজনে (When Needed/SOS)" ${timing === 'ব্যথার সময় প্রয়োজনে (When Needed/SOS)' ? 'selected' : ''}>ব্যথার সময় প্রয়োজনে (SOS)</option>
          </select>
        </td>
        <td data-label="Duration (মেয়াদ)">
          <input type="text" name="medicines[${medIdx}][duration]" class="form-control form-control-sm js-med-duration" placeholder="১ মাস / চলবে" value="${duration || '১ মাস'}">
        </td>
        <td data-label="Instruction (নির্দেশনা)">
          <input type="text" name="medicines[${medIdx}][instructions]" class="form-control form-control-sm js-med-instruction" placeholder="নিয়মিত সেব্য" value="${instructions || 'নিয়মিত সেব্য'}">
        </td>
        <td class="text-center" data-label="">
          <button type="button" class="btn btn-sm btn-outline-danger p-1 px-2 remove-row-btn" title="Remove Medicine">
            <i class="bi bi-trash me-1"></i><span class="d-md-none">Remove</span>
          </button>
        </td>
      `;
      rowsContainer.appendChild(tr);
      medIdx++;
      if (shouldPulse) {
        var addedInput = tr.querySelector('.js-med-name');
        setTimeout(function() { if (addedInput) addedInput.classList.remove('field-updated-pulse'); }, 1000);
      }
      checkDuplicateMedicines();
    }

    // 3. Duplicate Medicine Detection (SAFETY)
    function checkDuplicateMedicines() {
      var names = [];
      var hasDuplicate = false;
      var dupName = '';

      document.querySelectorAll('.js-med-name').forEach(function(input) {
        var val = input.value.trim().toLowerCase();
        if (val) {
          if (names.includes(val)) {
            hasDuplicate = true;
            dupName = input.value.trim();
            input.classList.add('is-invalid');
          } else {
            names.push(val);
            input.classList.remove('is-invalid');
          }
        } else {
          input.classList.remove('is-invalid');
        }
      });

      var alertBox = document.getElementById('duplicateMedicineAlert');
      if (alertBox) {
        if (hasDuplicate) {
          alertBox.classList.remove('d-none');
          alertBox.querySelector('span').innerHTML = `<strong>⚠️ ডুপ্লিকেট ওষুধ সতর্কতা:</strong> "${dupName}" একই প্রেসক্রিপশনে একাধিকবার যোগ করা হয়েছে!`;
        } else {
          alertBox.classList.add('d-none');
        }
      }
    }

    document.addEventListener('input', function(e) {
      if (e.target && e.target.classList.contains('js-med-name')) {
        checkDuplicateMedicines();
      }
    });

    // 4. Clinical Vitals Safety Alerts (SAFETY)
    function checkVitalsSafety() {
      var sys = parseInt(document.getElementById('bpSystolicInput').value, 10);
      var dia = parseInt(document.getElementById('bpDiastolicInput').value, 10);
      var pulse = parseInt(document.getElementById('pulseInput').value, 10);
      var bsStr = (document.getElementById('bloodSugarInput').value || '').trim();
      var bs = parseFloat(bsStr);
      var age = parseInt(document.getElementById('patientAgeInput').value, 10);

      var bpBadge = document.getElementById('bpBadge');
      var vitalsStatus = document.getElementById('vitalsSafetyStatus');
      var safetyBanner = document.getElementById('clinicalSafetyBanner');
      var safetyTitle = document.getElementById('safetyAlertTitle');
      var safetyDesc = document.getElementById('safetyAlertDesc');

      var warnings = [];

      // BP Check
      if (sys >= 180 || dia >= 120) {
        bpBadge.className = 'badge bg-danger text-white fw-bold';
        bpBadge.textContent = 'BP: Hypertensive Crisis (উচ্চ রক্তচাপ সতর্কতা!)';
        warnings.push('Severe Hypertension Alert: BP ' + sys + '/' + dia + ' mmHg');
      } else if (sys >= 140 || dia >= 90) {
        bpBadge.className = 'badge bg-warning-subtle text-warning-emphasis border border-warning fw-semibold';
        bpBadge.textContent = 'BP: Stage 2 Hypertension';
        warnings.push('High BP (Stage 2): ' + sys + '/' + dia + ' mmHg');
      } else if (sys < 90 && sys > 0) {
        bpBadge.className = 'badge bg-danger-subtle text-danger border fw-semibold';
        bpBadge.textContent = 'BP: Hypotension (Low BP)';
        warnings.push('Low BP detected: ' + sys + '/' + dia + ' mmHg');
      } else {
        bpBadge.className = 'badge bg-success-subtle text-success border border-success-subtle fw-normal';
        bpBadge.textContent = 'BP: Normal (' + (sys || 120) + '/' + (dia || 80) + ')';
      }

      // Age Check
      var ageBadge = document.getElementById('ageAlertBadge');
      if (age >= 65) {
        ageBadge.innerHTML = '<span class="badge bg-warning-subtle text-warning-emphasis"><i class="bi bi-person-fill-exclamation"></i> Geriatric (বয়োজ্যেষ্ঠ রোগী)</span>';
      } else if (age <= 12 && age > 0) {
        ageBadge.innerHTML = '<span class="badge bg-info-subtle text-info"><i class="bi bi-balloon-fill"></i> Pediatric (শিশু রোগী)</span>';
      } else {
        ageBadge.innerHTML = '';
      }

      // Blood Sugar Check
      if (bs >= 11.1) {
        warnings.push('High Blood Sugar: ' + bsStr + ' (অনিয়ন্ত্রিত গ্লুকোজ)');
      } else if (bs <= 3.9 && bs > 0) {
        warnings.push('Hypoglycemia Alert: Blood sugar ' + bsStr + ' (হাইপোগ্লাইসেমিয়া সতর্কতা!)');
      }

      if (warnings.length > 0) {
        safetyBanner.classList.remove('d-none');
        safetyTitle.textContent = 'Clinical Safety Notice (' + warnings.length + ' alert' + (warnings.length > 1 ? 's' : '') + ')';
        safetyDesc.innerHTML = warnings.join(' • ');
        vitalsStatus.innerHTML = '<span class="text-danger fw-bold"><i class="bi bi-exclamation-triangle-fill"></i> Attention Required</span>';
      } else {
        safetyBanner.classList.add('d-none');
        vitalsStatus.innerHTML = '<span class="text-success small"><i class="bi bi-check-circle-fill"></i> Normal Parameters</span>';
      }
    }

    ['bpSystolicInput', 'bpDiastolicInput', 'pulseInput', 'bloodSugarInput', 'patientAgeInput'].forEach(function(id) {
      var el = document.getElementById(id);
      if (el) el.addEventListener('input', checkVitalsSafety);
    });

    checkVitalsSafety();

    // 5. Quick Queue Import
    var queueSelect = document.getElementById('quickQueueSelect');
    if (queueSelect) {
      queueSelect.addEventListener('change', function() {
        var opt = this.options[this.selectedIndex];
        if (!opt || !opt.value) return;

        document.getElementById('serialIdInput').value = opt.value;
        document.getElementById('patientNameInput').value = opt.getAttribute('data-name') || '';
        document.getElementById('patientPhoneInput').value = opt.getAttribute('data-phone') || '';
        document.getElementById('patientAgeInput').value = opt.getAttribute('data-age') || '';
        document.getElementById('patientGenderInput').value = opt.getAttribute('data-gender') || 'male';
        
        var chamberId = opt.getAttribute('data-chamber');
        if (chamberId) {
          document.getElementById('chamberIdInput').value = chamberId;
        }

        var symptoms = opt.getAttribute('data-symptoms');
        if (symptoms) {
          document.getElementById('chiefComplaintsInput').value = symptoms;
        }

        checkVitalsSafety();
      });
    }

    // 6. 1-Click Clinical Disease Templates (EASY PRESETS)
    var diseasePresets = {
      diabetes: {
        diagnosis: 'Type 2 Diabetes Mellitus with Poor Glycemic Control',
        advice: 'প্রতিদিন সকালে ও সন্ধ্যায় ৪০ মিনিট দ্রুত হাঁটবেন। মিষ্টি, চিনি, কোমল পানীয় ও অতিরিক্ত ভাত সম্পূর্ণ পরিহার করবেন। নিয়মিত ব্লাড সুগার চার্ট সংরক্ষণ করবেন।',
        medicines: [
          { name: 'Tab. Metformin 500mg', dose: '১ + ০ + ১', timing: 'খাবার সাথে সাথে (With Meal)', duration: 'চলবে', instructions: 'ভরা পেটে সেব্য' },
          { name: 'Tab. Empagliflozin 10mg', dose: '১ + ০ + ০', timing: 'সকালে খালি পেটে (Empty Stomach)', duration: 'চলবে', instructions: 'প্রচুর পানি পান করবেন' }
        ],
        investigations: [
          { name: 'HbA1c', instructions: 'Fasting' },
          { name: 'Fasting Blood Sugar (FBS)', instructions: '8-10 hrs Fasting' },
          { name: 'Serum Creatinine', instructions: 'Routine' }
        ]
      },
      hypertension: {
        diagnosis: 'Essential Hypertension (Stage 2)',
        advice: 'খাবারে কোনো বাড়তি কাঁচা লবণ খাবেন না। তেল-চর্বিযুক্ত ও প্রসেসড খাবার এড়িয়ে চলবেন। প্রতিদিন রক্তচাপ মেপে ডায়েরিতে লিখে রাখবেন।',
        medicines: [
          { name: 'Tab. Telmisartan 40mg', dose: '১ + ০ + ০', timing: 'সকালে খাবারের পর (Morning)', duration: 'চলবে', instructions: 'প্রতিদিন নির্দিষ্ট সময়ে সেব্য' },
          { name: 'Tab. Amlodipine 5mg', dose: '০ + ০ + ১', timing: 'রাতে ঘুমানোর আগে (Bedtime)', duration: 'চলবে', instructions: 'নিয়মিত সেব্য' }
        ],
        investigations: [
          { name: 'Serum Electrolytes', instructions: 'Routine' },
          { name: 'ECG (12 Lead)', instructions: 'At rest' },
          { name: 'Lipid Profile', instructions: '12 hrs Fasting' }
        ]
      },
      gastric: {
        diagnosis: 'Gastroesophageal Reflux Disease (GERD) & Functional Dyspepsia',
        advice: 'ঝাল, অতিরিক্ত তেল-মসলা ও ভাজাপোড়া পরিহার করবেন। খাওয়ার সাথে সাথে শুয়ে পড়বেন না (কমপক্ষে ২ ঘণ্টা পর ঘুমাবেন)। রাতে হালকা খাবার গ্রহণ করুন।',
        medicines: [
          { name: 'Cap. Esomeprazole 20mg', dose: '১ + ০ + ১', timing: 'খাবারের ৩০ মিনিট আগে (Before Meal)', duration: '১৪ দিন', instructions: 'পানি দিয়ে গিলে সেব্য' },
          { name: 'Tab. Domperidone 10mg', dose: '১ + ১ + ১', timing: 'খাবারের ১৫ মিনিট আগে (Before Meal)', duration: '৭ দিন', instructions: 'বমি ভাব কমলে বন্ধ' }
        ],
        investigations: [
          { name: 'USG of Whole Abdomen', instructions: 'Fasting' },
          { name: 'Endoscopy of Upper GIT (If needed)', instructions: 'Consult first' }
        ]
      },
      fever: {
        diagnosis: 'Acute Viral Fever with Upper Respiratory Tract Infection',
        advice: 'পর্যাপ্ত বিশ্রাম নিন। প্রচুর পরিমাণে তরল খাবার, ডাবের পানি ও কুসুম গরম পানি পান করুন। তাপমাত্রা ১০১° এর বেশি হলে কুসুম গরম পানিতে শরীর স্পঞ্জ করুন।',
        medicines: [
          { name: 'Tab. Paracetamol 665mg', dose: '১ + ১ + ১', timing: 'খাবারের পরে (After Meal)', duration: '৫ দিন', instructions: 'ভরা পেটে সেব্য' },
          { name: 'Tab. Fexofenadine 120mg', dose: '০ + ০ + ১', timing: 'রাতে ঘুমানোর আগে (Bedtime)', duration: '৭ দিন', instructions: 'অ্যালার্জির জন্য' }
        ],
        investigations: [
          { name: 'CBC with ESR', instructions: 'Routine' },
          { name: 'Dengue NS1 Antigen (If fever > 2 days)', instructions: 'Immediate' }
        ]
      },
      thyroid: {
        diagnosis: 'Primary Hypothyroidism',
        advice: 'ওষুধটি প্রতিদিন সকালে ঘুম থেকে উঠে এক গ্লাস পানি দিয়ে খালি পেটে খাবেন এবং কমপক্ষে ৪৫ মিনিট পর্যন্ত চা, কফি বা নাস্তা করবেন না। ৬ সপ্তাহ পর আবার TSH পরীক্ষা করবেন।',
        medicines: [
          { name: 'Tab. Levothyroxine 50mcg', dose: '১ + ০ + ০', timing: 'সকালে খালি পেটে (Empty Stomach)', duration: 'চলবে', instructions: 'ঘুম থেকে উঠেই খালি পেটে সেব্য' }
        ],
        investigations: [
          { name: 'Serum TSH', instructions: 'Early morning' },
          { name: 'Free T4 (FT4)', instructions: 'Routine' }
        ]
      }
    };

    document.querySelectorAll('.js-apply-template').forEach(function(btn) {
      btn.addEventListener('click', function() {
        var key = this.getAttribute('data-template');
        var tmpl = diseasePresets[key];
        if (!tmpl) return;

        // Set Diagnosis & Advice
        if (tmpl.diagnosis) document.getElementById('diagnosisInput').value = tmpl.diagnosis;
        if (tmpl.advice) document.getElementById('specialAdviceInput').value = tmpl.advice;

        // Clear existing rows and load template medicines
        rowsContainer.innerHTML = '';
        medIdx = 0;
        tmpl.medicines.forEach(function(m) {
          addMedicineRow(m.name, m.dose, m.timing, m.duration, m.instructions);
        });

        // Load template investigations
        var invContainer = document.getElementById('investigationsContainer');
        invContainer.innerHTML = '';
        invIdx = 0;
        tmpl.investigations.forEach(function(inv) {
          addInvestigationRow(inv.name, inv.instructions);
        });
      });
    });

    // 7. Diagnostic Tests Management (Fast, Non-Cluttered, Mobile-Friendly)
    var addInvBtn = document.getElementById('addInvestigationBtn');
    var invContainer = document.getElementById('investigationsContainer');
    var quickTestDropdown = document.getElementById('quickTestDropdown');

    function addInvestigationRow(name, instructions, shouldPulse) {
      var div = document.createElement('div');
      div.className = 'input-group input-group-sm mb-2 investigation-row';
      div.innerHTML = `
        <input type="text" name="investigations[${invIdx}][name]" list="commonDiagnosticTests" class="form-control ${shouldPulse ? 'field-updated-pulse' : ''}" placeholder="Test Name (e.g. HbA1c)" value="${name || ''}">
        <input type="text" name="investigations[${invIdx}][instructions]" list="commonTestInstructions" class="form-control" placeholder="Instructions (e.g. Fasting)" value="${instructions || ''}">
        <button type="button" class="btn btn-outline-danger remove-inv-btn" title="Remove"><i class="bi bi-trash"></i></button>
      `;
      invContainer.appendChild(div);
      invIdx++;
      if (shouldPulse) {
        var addedInput = div.querySelector('input[name*="[name]"]');
        setTimeout(function() { if (addedInput) addedInput.classList.remove('field-updated-pulse'); }, 1000);
      }
    }

    function addOrFillInvestigation(name, instructions) {
      if (!name) return;
      var rows = invContainer.querySelectorAll('.investigation-row');
      var targetRow = null;

      // Check if any existing row has an empty name
      for (var i = 0; i < rows.length; i++) {
        var nameInput = rows[i].querySelector('input[name*="[name]"]');
        if (nameInput && !nameInput.value.trim()) {
          targetRow = rows[i];
          break;
        }
      }

      if (targetRow) {
        var nameInput = targetRow.querySelector('input[name*="[name]"]');
        var instInput = targetRow.querySelector('input[name*="[instructions]"]');
        if (nameInput) {
          nameInput.value = name;
          nameInput.classList.add('field-updated-pulse');
          setTimeout(function() { nameInput.classList.remove('field-updated-pulse'); }, 1000);
        }
        if (instInput && instructions) {
          instInput.value = instructions;
        }
      } else {
        addInvestigationRow(name, instructions || 'Routine', true);
      }
    }

    // Quick Test Dropdown Selection
    if (quickTestDropdown) {
      quickTestDropdown.addEventListener('change', function() {
        var sel = this.options[this.selectedIndex];
        if (sel && sel.value) {
          var name = sel.value;
          var inst = sel.getAttribute('data-inst') || 'Routine';
          addOrFillInvestigation(name, inst);
          this.selectedIndex = 0;
        }
      });
    }

    // 1-Click Frequent Test Chips
    document.querySelectorAll('.js-quick-add-test').forEach(function(chip) {
      chip.addEventListener('click', function() {
        var name = this.getAttribute('data-test');
        var inst = this.getAttribute('data-inst') || 'Routine';
        addOrFillInvestigation(name, inst);
      });
    });

    if (addInvBtn && invContainer) {
      addInvBtn.addEventListener('click', function() {
        addInvestigationRow('', '');
      });

      invContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-inv-btn')) {
          e.target.closest('.investigation-row').remove();
        }
      });
    }

    // 8. 1-Click Fast Drugs Palette
    document.querySelectorAll('.js-fast-add-med').forEach(function(btn) {
      btn.addEventListener('click', function() {
        var name = this.getAttribute('data-name');
        var dose = this.getAttribute('data-dose') || '১ + ০ + ১';
        var timing = this.getAttribute('data-timing') || 'খাবারের পরে (After Meal)';
        var duration = this.getAttribute('data-duration') || '১ মাস';
        var inst = this.getAttribute('data-inst') || 'নিয়মিত সেব্য';

        var rows = rowsContainer.querySelectorAll('.medicine-row');
        var targetRow = null;
        for (var i = 0; i < rows.length; i++) {
          var nInput = rows[i].querySelector('.js-med-name');
          if (nInput && !nInput.value.trim()) {
            targetRow = rows[i];
            break;
          }
        }

        if (targetRow) {
          var nInput = targetRow.querySelector('.js-med-name');
          var dInput = targetRow.querySelector('.js-med-dose');
          var tInput = targetRow.querySelector('.js-med-timing');
          var durInput = targetRow.querySelector('.js-med-duration');
          var iInput = targetRow.querySelector('.js-med-instruction');
          if (nInput) {
            nInput.value = name;
            nInput.classList.add('field-updated-pulse');
            setTimeout(function() { nInput.classList.remove('field-updated-pulse'); }, 800);
          }
          if (dInput) dInput.value = dose;
          if (tInput) tInput.value = timing;
          if (durInput) durInput.value = duration;
          if (iInput) iInput.value = inst;
        } else {
          addMedicineRow(name, dose, timing, duration, inst, true);
        }
        checkDuplicateMedicines();
      });
    });

    // 9. Inline Dosage Buttons (Row Level)
    rowsContainer.addEventListener('click', function(e) {
      var btn = e.target.closest('.js-inline-dose');
      if (btn) {
        var row = btn.closest('.medicine-row');
        if (row) {
          var doseInput = row.querySelector('.js-med-dose');
          if (doseInput) {
            doseInput.value = btn.getAttribute('data-val');
            doseInput.classList.add('field-updated-pulse');
            setTimeout(function() { doseInput.classList.remove('field-updated-pulse'); }, 800);
          }
        }
      }
    });

    // 10. Quick Diagnosis Chips
    document.querySelectorAll('.js-chip-diag').forEach(function(chip) {
      chip.addEventListener('click', function() {
        var diagVal = this.getAttribute('data-diag');
        var diagInput = document.getElementById('diagnosisInput');
        if (diagInput) {
          var current = diagInput.value.trim();
          if (!current) {
            diagInput.value = diagVal;
          } else if (!current.includes(diagVal)) {
            diagInput.value = current + ', ' + diagVal;
          }
          diagInput.classList.add('field-updated-pulse');
          setTimeout(function() { diagInput.classList.remove('field-updated-pulse'); }, 800);
        }
      });
    });

    // 11. Quick Advice Chips
    document.querySelectorAll('.js-chip-advice').forEach(function(chip) {
      chip.addEventListener('click', function() {
        var adviceVal = this.getAttribute('data-text');
        var adviceInput = document.getElementById('specialAdviceInput');
        if (adviceInput) {
          var current = adviceInput.value.trim();
          if (!current) {
            adviceInput.value = adviceVal;
          } else if (!current.includes(adviceVal)) {
            adviceInput.value = current + ' ' + adviceVal;
          }
          adviceInput.classList.add('field-updated-pulse');
          setTimeout(function() { adviceInput.classList.remove('field-updated-pulse'); }, 800);
        }
      });
    });

    // 12. Quick Followup Date Chips
    document.querySelectorAll('.js-chip-followup').forEach(function(chip) {
      chip.addEventListener('click', function() {
        var days = parseInt(this.getAttribute('data-days'), 10);
        var targetDate = new Date();
        targetDate.setDate(targetDate.getDate() + days);
        var yyyy = targetDate.getFullYear();
        var mm = String(targetDate.getMonth() + 1).padStart(2, '0');
        var dd = String(targetDate.getDate()).padStart(2, '0');
        var dateStr = yyyy + '-' + mm + '-' + dd;
        var dateInput = document.getElementById('nextVisitDateInput');
        if (dateInput) {
          dateInput.value = dateStr;
          dateInput.classList.add('field-updated-pulse');
          setTimeout(function() { dateInput.classList.remove('field-updated-pulse'); }, 800);
        }
      });
    });

    // 13. Queue Patient Shortcut Chips
    document.querySelectorAll('.js-quick-queue-chip').forEach(function(chip) {
      chip.addEventListener('click', function() {
        document.getElementById('serialIdInput').value = this.getAttribute('data-id') || '';
        document.getElementById('patientNameInput').value = this.getAttribute('data-name') || '';
        document.getElementById('patientPhoneInput').value = this.getAttribute('data-phone') || '';
        document.getElementById('patientAgeInput').value = this.getAttribute('data-age') || '';
        document.getElementById('patientGenderInput').value = this.getAttribute('data-gender') || 'male';
        var chamberId = this.getAttribute('data-chamber');
        if (chamberId) document.getElementById('chamberIdInput').value = chamberId;
        var symptoms = this.getAttribute('data-symptoms');
        if (symptoms) document.getElementById('chiefComplaintsInput').value = symptoms;
        checkVitalsSafety();
      });
    });

    // 14. Doctor Keyboard Shortcuts (Ultra Fast)
    document.addEventListener('keydown', function(e) {
      if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
        e.preventDefault();
        var printBtn = document.getElementById('saveAndPrintBtn');
        if (printBtn) {
          printBtn.click();
        } else {
          var form = document.getElementById('prescriptionForm');
          if (form) form.submit();
        }
      }
      if (e.altKey && (e.key === 'm' || e.key === 'M')) {
        e.preventDefault();
        addMedicineRow('', '১ + ০ + ১', 'খাবারের পরে (After Meal)', '১ মাস', 'নিয়মিত সেব্য', true);
      }
      if (e.altKey && (e.key === 't' || e.key === 'T')) {
        e.preventDefault();
        addInvestigationRow('', '', true);
      }
    });
  });
</script>
@endpush
