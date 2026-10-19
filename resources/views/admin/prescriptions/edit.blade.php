@extends('layouts.admin')

@section('title', 'Edit Prescription: ' . $prescription->prescription_no)
@section('page_heading', 'Edit Prescription ' . $prescription->prescription_no)

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

  <form action="{{ route('admin.prescriptions.update', $prescription->id) }}" method="POST" id="prescriptionForm">
    @csrf
    @method('PUT')

    {{-- Top Action & Info Bar --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
      <div class="card-header bg-white py-3 px-4 border-bottom d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div class="d-flex align-items-center gap-2">
          <a href="{{ route('admin.prescriptions.show', $prescription->id) }}" class="btn btn-sm btn-outline-secondary rounded-circle" style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;" title="Back">
            <i class="bi bi-arrow-left"></i>
          </a>
          <span class="badge bg-primary fs-6 px-3 py-2 rounded-pill font-monospace">
            <i class="bi bi-prescription2 me-1"></i> {{ $prescription->prescription_no }}
          </span>
          <input type="hidden" name="prescription_no" value="{{ $prescription->prescription_no }}">
          <span class="text-muted small">Consultation Date: <strong>{{ date('d M, Y', strtotime($prescription->consultation_date)) }}</strong></span>
        </div>

        <div class="d-flex align-items-center gap-2">
          <a href="{{ route('admin.prescriptions.print', $prescription->id) }}" target="_blank" class="btn btn-sm btn-outline-success fw-bold">
            <i class="bi bi-printer me-1"></i> Print Prescription
          </a>
        </div>
      </div>

      {{-- Patient Intake Form --}}
      <div class="card-body p-4">
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label small fw-semibold text-dark">Patient Full Name <span class="text-danger">*</span></label>
            <input type="text" name="patient_name" id="patientNameInput" class="form-control" value="{{ old('patient_name', $prescription->patient_name) }}" required>
          </div>

          <div class="col-md-3">
            <label class="form-label small fw-semibold text-dark">Mobile Phone <span class="text-danger">*</span></label>
            <input type="tel" name="patient_phone" id="patientPhoneInput" class="form-control" value="{{ old('patient_phone', $prescription->patient_phone) }}" required>
          </div>

          <div class="col-md-2">
            <label class="form-label small fw-semibold text-dark">Age (Years)</label>
            <div class="input-group">
              <input type="number" name="patient_age" id="patientAgeInput" class="form-control" value="{{ old('patient_age', $prescription->patient_age) }}" min="1" max="120">
              <span class="input-group-text small">Yrs</span>
            </div>
            <div id="ageAlertBadge" class="small mt-1"></div>
          </div>

          <div class="col-md-3">
            <label class="form-label small fw-semibold text-dark">Gender <span class="text-danger">*</span></label>
            <select name="patient_gender" id="patientGenderInput" class="form-select" required>
              <option value="male" {{ old('patient_gender', $prescription->patient_gender) == 'male' ? 'selected' : '' }}>Male (পুরুষ)</option>
              <option value="female" {{ old('patient_gender', $prescription->patient_gender) == 'female' ? 'selected' : '' }}>Female (মহিলা)</option>
              <option value="other" {{ old('patient_gender', $prescription->patient_gender) == 'other' ? 'selected' : '' }}>Other (অন্যান্য)</option>
            </select>
          </div>

          <div class="col-md-4">
            <label class="form-label small fw-semibold text-dark">Chamber Location</label>
            <select name="chamber_id" id="chamberIdInput" class="form-select">
              <option value="">-- Select Chamber --</option>
              @foreach($chambers as $ch)
                <option value="{{ $ch->id }}" {{ old('chamber_id', $prescription->chamber_id) == $ch->id ? 'selected' : '' }}>{{ $ch->name_en }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-4">
            <label class="form-label small fw-semibold text-dark">Consultation Date <span class="text-danger">*</span></label>
            <input type="date" name="consultation_date" class="form-control" value="{{ old('consultation_date', date('Y-m-d', strtotime($prescription->consultation_date))) }}" required>
          </div>

          <div class="col-md-4">
            <label class="form-label small fw-semibold text-dark">Patient Address / City</label>
            <input type="text" name="patient_address" class="form-control" value="{{ old('patient_address', $prescription->patient_address) }}" placeholder="e.g. Dhanmondi, Dhaka">
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
              <input type="number" name="bp_systolic" id="bpSystolicInput" class="form-control" value="{{ old('bp_systolic', $prescription->bp_systolic ?? '120') }}" placeholder="120">
              <span class="input-group-text">mmHg</span>
            </div>
          </div>

          <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold">BP (Diastolic)</label>
            <div class="input-group input-group-sm">
              <input type="number" name="bp_diastolic" id="bpDiastolicInput" class="form-control" value="{{ old('bp_diastolic', $prescription->bp_diastolic ?? '80') }}" placeholder="80">
              <span class="input-group-text">mmHg</span>
            </div>
          </div>

          <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold">Pulse Rate</label>
            <div class="input-group input-group-sm">
              <input type="number" name="pulse" id="pulseInput" class="form-control" value="{{ old('pulse', $prescription->pulse ?? '76') }}" placeholder="76">
              <span class="input-group-text">bpm</span>
            </div>
          </div>

          <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold">Weight</label>
            <div class="input-group input-group-sm">
              <input type="text" name="weight" class="form-control" value="{{ old('weight', $prescription->weight) }}" placeholder="70">
              <span class="input-group-text">kg</span>
            </div>
          </div>

          <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold">Temperature</label>
            <div class="input-group input-group-sm">
              <input type="text" name="temperature" class="form-control" value="{{ old('temperature', $prescription->temperature ?? '98.4') }}" placeholder="98.4">
              <span class="input-group-text">°F</span>
            </div>
          </div>

          <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold">Blood Sugar</label>
            <input type="text" name="blood_sugar" id="bloodSugarInput" class="form-control form-control-sm" value="{{ old('blood_sugar', $prescription->blood_sugar) }}" placeholder="6.5 mmol/L">
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
            <textarea name="chief_complaints" id="chiefComplaintsInput" class="form-control mb-3" rows="3">{{ old('chief_complaints', $prescription->chief_complaints) }}</textarea>
            
            <label class="form-label small fw-semibold">Clinical Examination & Past Medical History</label>
            <textarea name="clinical_history" class="form-control" rows="2">{{ old('clinical_history', $prescription->clinical_history) }}</textarea>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
          <div class="card-header bg-white py-3 border-bottom">
            <h3 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-search-heart text-danger me-2"></i>Clinical Diagnosis / Impression</h3>
          </div>
          <div class="card-body p-3">
            <label class="form-label small fw-semibold">Primary Diagnosis (রোগ নির্ণয় / ডায়াগনসিস)</label>
            <textarea name="diagnosis" id="diagnosisInput" class="form-control mb-3" rows="3">{{ old('diagnosis', $prescription->diagnosis) }}</textarea>
            
            <label class="form-label small fw-semibold">Confidential Doctor Notes (Internal Doctor Diary)</label>
            <textarea name="doctor_notes" class="form-control" rows="2">{{ old('doctor_notes', $prescription->doctor_notes) }}</textarea>
          </div>
        </div>
      </div>
    </div>

    {{-- Rx Prescribed Medicines & Dosages --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
      <div class="card-header bg-white py-3 px-4 border-bottom d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2">
        <div class="d-flex align-items-center gap-2">
          <span class="fs-4 fw-bold text-primary font-monospace">Rx</span>
          <div>
            <h3 class="fs-6 fw-bold mb-0 text-dark brand-font">Prescribed Medicines & Dosages</h3>
            <div class="text-muted" style="font-size: 0.75rem;">খালি সারি রাখলে স্বয়ংক্রিয়ভাবে বাদ দেওয়া হবে।</div>
          </div>
        </div>
        <button type="button" class="btn btn-sm btn-success fw-bold px-3" id="addMedicineBtn">
          <i class="bi bi-plus-circle me-1"></i> Add Another Medicine
        </button>
      </div>

      {{-- Duplicate Warning Alert --}}
      <div id="duplicateMedicineAlert" class="alert alert-warning m-3 mb-0 rounded-3 d-none">
        <i class="bi bi-exclamation-triangle-fill me-1"></i>
        <span><strong>ডুপ্লিকেট ওষুধ সতর্কতা:</strong> একই ওষুধ একাধিক সারিতে যোগ করা হয়েছে!</span>
      </div>

      <div class="card-body p-3 p-md-4">
        {{-- Quick Dosage & Timing Chips Helper (High Contrast, Bold, Guaranteed Visible) --}}
        <div class="quick-pills-bar p-2 p-md-3 mb-3 rounded-3 d-flex flex-wrap align-items-center gap-1 gap-md-2">
          <span class="text-dark fw-bold small me-1 d-flex align-items-center gap-1">
            <i class="bi bi-capsule-pill text-primary"></i> Quick Dose Pills:
          </span>
          <button type="button" class="dose-chip js-chip-dose" data-val="১ + ০ + ১">১+০+১</button>
          <button type="button" class="dose-chip js-chip-dose" data-val="১ + ০ + ০">১+০+০</button>
          <button type="button" class="dose-chip js-chip-dose" data-val="০ + ০ + ১">০+০+১</button>
          <button type="button" class="dose-chip js-chip-dose" data-val="১ + ১ + ১">১+১+১</button>
          <button type="button" class="dose-chip js-chip-dose" data-val="০ + ১ + ০">০+১+০</button>
          <button type="button" class="dose-chip js-chip-dose" data-val="১/২ + ০ + ১/২">১/২+০+১/২</button>
          <button type="button" class="dose-chip js-chip-dose" data-val="১ চামচ করে ৩ বার">১ চামচ ৩ বার</button>
          <button type="button" class="dose-chip dose-chip-sos js-chip-dose" data-val="প্রয়োজনে (SOS)">🚨 প্রয়োজনে (SOS)</button>
          
          <div class="vr mx-1 d-none d-sm-inline-block text-secondary"></div>
          <button type="button" class="timing-chip js-chip-timing" data-val="খাবারের পরে (After Meal)">খাবারের পরে</button>
          <button type="button" class="timing-chip js-chip-timing" data-val="খাবারের আগে (Before Meal)">খাবারের আগে</button>
          <button type="button" class="timing-chip js-chip-timing" data-val="সকালে খালি পেটে (Empty Stomach)">খালি পেটে</button>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered align-middle mb-0" id="medicinesTable">
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
              @php
                $meds = old('medicines', $prescription->medicines ?? []);
                if(empty($meds)) $meds = [['name' => '', 'dose' => '১ + ০ + ১', 'timing' => 'খাবারের পরে (After Meal)', 'duration' => '১ মাস', 'instructions' => 'নিয়মিত সেব্য']];
              @endphp
              @foreach($meds as $idx => $m)
                <tr class="medicine-row">
                  <td>
                    <input type="text" name="medicines[{{ $idx }}][name]" class="form-control form-control-sm js-med-name" placeholder="e.g. Tab. Metformin 500mg" value="{{ $m['name'] ?? '' }}" required>
                  </td>
                  <td>
                    <input type="text" name="medicines[{{ $idx }}][dose]" class="form-control form-control-sm js-med-dose" placeholder="১ + ০ + ১" value="{{ $m['dose'] ?? '১ + ০ + ১' }}">
                  </td>
                  <td>
                    <select name="medicines[{{ $idx }}][timing]" class="form-select form-select-sm js-med-timing">
                      <option value="খাবারের পরে (After Meal)" {{ ($m['timing'] ?? '') == 'খাবারের পরে (After Meal)' ? 'selected' : '' }}>খাবারের পরে (After Meal)</option>
                      <option value="খাবারের আগে (Before Meal)" {{ ($m['timing'] ?? '') == 'খাবারের আগে (Before Meal)' ? 'selected' : '' }}>খাবারের আগে (Before Meal)</option>
                      <option value="সকালে খালি পেটে (Empty Stomach)" {{ ($m['timing'] ?? '') == 'সকালে খালি পেটে (Empty Stomach)' ? 'selected' : '' }}>সকালে খালি পেটে (Empty Stomach)</option>
                      <option value="খাবার সাথে সাথে (With Meal)" {{ ($m['timing'] ?? '') == 'খাবার সাথে সাথে (With Meal)' ? 'selected' : '' }}>খাবার সাথে সাথে (With Meal)</option>
                      <option value="রাতে ঘুমানোর আগে (Bedtime)" {{ ($m['timing'] ?? '') == 'রাতে ঘুমানোর আগে (Bedtime)' ? 'selected' : '' }}>রাতে ঘুমানোর আগে (Bedtime)</option>
                      <option value="ব্যথার সময় প্রয়োজনে (When Needed/SOS)" {{ ($m['timing'] ?? '') == 'ব্যথার সময় প্রয়োজনে (When Needed/SOS)' ? 'selected' : '' }}>ব্যথার সময় প্রয়োজনে (SOS)</option>
                    </select>
                  </td>
                  <td>
                    <input type="text" name="medicines[{{ $idx }}][duration]" class="form-control form-control-sm js-med-duration" placeholder="১ মাস / চলবে" value="{{ $m['duration'] ?? '১ মাস' }}">
                  </td>
                  <td>
                    <input type="text" name="medicines[{{ $idx }}][instructions]" class="form-control form-control-sm js-med-instruction" placeholder="নিয়মিত সেব্য" value="{{ $m['instructions'] ?? 'নিয়মিত সেব্য' }}">
                  </td>
                  <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger p-1 remove-row-btn" title="Remove Medicine">
                      <i class="bi bi-trash"></i>
                    </button>
                  </td>
                </tr>
              @endforeach
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
              @php
                $invs = old('investigations', $prescription->investigations ?? []);
                if(empty($invs)) $invs = [['name' => '', 'instructions' => '']];
              @endphp
              @foreach($invs as $iIdx => $inv)
                <div class="input-group input-group-sm mb-2 investigation-row">
                  <input type="text" name="investigations[{{ $iIdx }}][name]" list="commonDiagnosticTests" class="form-control" placeholder="Test Name" value="{{ $inv['name'] ?? '' }}">
                  <input type="text" name="investigations[{{ $iIdx }}][instructions]" list="commonTestInstructions" class="form-control" placeholder="Instructions" value="{{ $inv['instructions'] ?? '' }}">
                  <button type="button" class="btn btn-outline-danger remove-inv-btn" title="Remove"><i class="bi bi-trash"></i></button>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
          <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h3 class="fs-6 fw-bold mb-0 text-dark brand-font d-flex align-items-center gap-2">
              <i class="bi bi-heart-pulse-fill text-success"></i>
              <span>Dietary & Clinical Advice (রোগীর পরামর্শ)</span>
            </h3>
          </div>
          <div class="card-body p-3">
            <label class="form-label small fw-semibold">Patient Lifestyle & Food Advice</label>
            <textarea name="special_advice" id="specialAdviceInput" class="form-control mb-3" rows="4">{{ old('special_advice', $prescription->special_advice) }}</textarea>
            
            <label class="form-label small fw-semibold">Next Review / Visit Date</label>
            <input type="date" name="next_visit_date" class="form-control" value="{{ old('next_visit_date', $prescription->next_visit_date ? date('Y-m-d', strtotime($prescription->next_visit_date)) : '') }}">
          </div>
        </div>
      </div>
    </div>

    {{-- Sticky Submit Action Bar --}}
    <div class="card border-0 shadow rounded-4 mb-5 p-3 bg-white d-flex flex-column flex-sm-row align-items-center justify-content-between gap-3">
      <div class="d-flex align-items-center gap-2">
        <a href="{{ route('admin.prescriptions.show', $prescription->id) }}" class="btn btn-outline-secondary px-3">
          Cancel
        </a>
      </div>
      <div class="d-flex align-items-center gap-3">
        <button type="submit" class="btn btn-success btn-lg px-5 fw-bold shadow-sm d-inline-flex align-items-center gap-2">
          <i class="bi bi-check2-circle fs-5"></i>
          <span>Save Changes to Prescription</span>
        </button>
      </div>
    </div>

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
    var medIdx = {{ count($meds) }};
    var invIdx = {{ count($invs) }};
    var rowsContainer = document.getElementById('medicineRowsContainer');
    var addMedicineBtn = document.getElementById('addMedicineBtn');
    var activeDoseInput = null;

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

    if (addMedicineBtn && rowsContainer) {
      addMedicineBtn.addEventListener('click', function() {
        addMedicineRow('', '১ + ০ + ১', 'খাবারের পরে (After Meal)', '১ মাস', 'নিয়মিত সেব্য');
      });

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

    function addMedicineRow(name, dose, timing, duration, instructions) {
      var tr = document.createElement('tr');
      tr.className = 'medicine-row';
      tr.innerHTML = `
        <td>
          <input type="text" name="medicines[${medIdx}][name]" class="form-control form-control-sm js-med-name" placeholder="Medicine Name & Strength" value="${name || ''}">
        </td>
        <td>
          <input type="text" name="medicines[${medIdx}][dose]" class="form-control form-control-sm js-med-dose" placeholder="১ + ০ + ১" value="${dose || '১ + ০ + ১'}">
        </td>
        <td>
          <select name="medicines[${medIdx}][timing]" class="form-select form-select-sm js-med-timing">
            <option value="খাবারের পরে (After Meal)">খাবারের পরে (After Meal)</option>
            <option value="খাবারের আগে (Before Meal)">খাবারের আগে (Before Meal)</option>
            <option value="সকালে খালি পেটে (Empty Stomach)">সকালে খালি পেটে (Empty Stomach)</option>
            <option value="খাবার সাথে সাথে (With Meal)">খাবার সাথে সাথে (With Meal)</option>
            <option value="রাতে ঘুমানোর আগে (Bedtime)">রাতে ঘুমানোর আগে (Bedtime)</option>
            <option value="ব্যথার সময় প্রয়োজনে (When Needed/SOS)">ব্যথার সময় প্রয়োজনে (SOS)</option>
          </select>
        </td>
        <td>
          <input type="text" name="medicines[${medIdx}][duration]" class="form-control form-control-sm js-med-duration" placeholder="১ মাস / চলবে" value="${duration || '১ মাস'}">
        </td>
        <td>
          <input type="text" name="medicines[${medIdx}][instructions]" class="form-control form-control-sm js-med-instruction" placeholder="নিয়মিত সেব্য" value="${instructions || 'নিয়মিত সেব্য'}">
        </td>
        <td class="text-center">
          <button type="button" class="btn btn-sm btn-outline-danger p-1 remove-row-btn" title="Remove Medicine">
            <i class="bi bi-trash"></i>
          </button>
        </td>
      `;
      rowsContainer.appendChild(tr);
      medIdx++;
      checkDuplicateMedicines();
    }

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

    // 7. Diagnostic Tests Management (Fast, Non-Cluttered, Mobile-Friendly)
    var addInvBtn = document.getElementById('addInvestigationBtn');
    var invContainer = document.getElementById('investigationsContainer');
    var quickTestDropdown = document.getElementById('quickTestDropdown');

    function addInvestigationRow(name, instructions, shouldPulse) {
      var div = document.createElement('div');
      div.className = 'input-group input-group-sm mb-2 investigation-row';
      div.innerHTML = `
        <input type="text" name="investigations[${invIdx}][name]" list="commonDiagnosticTests" class="form-control ${shouldPulse ? 'field-updated-pulse' : ''}" placeholder="Test Name" value="${name || ''}">
        <input type="text" name="investigations[${invIdx}][instructions]" list="commonTestInstructions" class="form-control" placeholder="Instructions" value="${instructions || ''}">
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

    checkDuplicateMedicines();
  });
</script>
@endpush

