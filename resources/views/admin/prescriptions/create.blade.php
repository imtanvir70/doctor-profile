@extends('layouts.admin')

@section('title', 'Write Digital Prescription')
@section('page_heading', 'Digital Prescription (EMR Pad)')

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
          <label class="small fw-semibold text-dark"><i class="bi bi-person-lines-fill text-success me-1"></i>Quick Import from Queue:</label>
          <select id="quickQueueSelect" class="form-select form-select-sm" style="max-width: 280px;">
            <option value="">-- Select Patient from Serial Queue --</option>
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
            <input type="text" name="patient_name" id="patientNameInput" class="form-control" value="{{ old('patient_name', $serial->patient_name ?? '') }}" placeholder="e.g. Mohammad Anwar Hossain" required>
          </div>

          <div class="col-md-3">
            <label class="form-label small fw-semibold text-dark">Mobile Phone <span class="text-danger">*</span></label>
            <input type="tel" name="patient_phone" id="patientPhoneInput" class="form-control" value="{{ old('patient_phone', $serial->patient_phone ?? '') }}" placeholder="017XXXXXXXX" required>
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
                <option value="{{ $ch->id }}" {{ old('chamber_id', $serial->chamber_id ?? '') == $ch->id ? 'selected' : '' }}>{{ $ch->name_en }}</option>
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

        <div class="d-flex flex-wrap gap-2 pt-1">
          <button type="button" class="btn btn-sm btn-outline-success bg-white fw-semibold js-apply-template" data-template="diabetes">
            🩺 ডায়াবেটিস রুটিন (Diabetes Followup)
          </button>
          <button type="button" class="btn btn-sm btn-outline-danger bg-white fw-semibold js-apply-template" data-template="hypertension">
            💓 উচ্চ রক্তচাপ (High BP / Hypertension)
          </button>
          <button type="button" class="btn btn-sm btn-outline-primary bg-white fw-semibold js-apply-template" data-template="gastric">
            💊 গ্যাস্ট্রিক ও এসিডিটি (Dyspepsia / Acid Peptic)
          </button>
          <button type="button" class="btn btn-sm btn-outline-warning text-dark bg-white fw-semibold js-apply-template" data-template="fever">
            🌡️ সাধারণ জ্বর ও সর্দি (Fever & Flu)
          </button>
          <button type="button" class="btn btn-sm btn-outline-info bg-white fw-semibold js-apply-template" data-template="thyroid">
            🦋 হাইপোথাইরয়েড (Hypothyroidism)
          </button>
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
            <div class="text-muted" style="font-size: 0.75rem;">খালি সারি রাখলে স্বয়ংক্রিয়ভাবে বাদ দেওয়া হবে (Safe auto-clean on save).</div>
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
        {{-- Quick Dosage & Timing Chips Helper --}}
        <div class="p-2 mb-3 rounded-2 bg-light border small d-flex flex-wrap align-items-center gap-1">
          <span class="text-muted fw-semibold me-1">Quick Dose Pills:</span>
          <button type="button" class="badge btn btn-outline-secondary py-1 px-2 js-chip-dose" data-val="১ + ০ + ১">১+০+১</button>
          <button type="button" class="badge btn btn-outline-secondary py-1 px-2 js-chip-dose" data-val="১ + ০ + ০">১+০+০</button>
          <button type="button" class="badge btn btn-outline-secondary py-1 px-2 js-chip-dose" data-val="০ + ০ + ১">০+০+১</button>
          <button type="button" class="badge btn btn-outline-secondary py-1 px-2 js-chip-dose" data-val="১ + ১ + ১">১+১+১</button>
          <button type="button" class="badge btn btn-outline-secondary py-1 px-2 js-chip-dose" data-val="০ + ১ + ০">০+১+০</button>
          <button type="button" class="badge btn btn-outline-secondary py-1 px-2 js-chip-dose" data-val="১/২ + ০ + ১/২">১/২+০+১/২</button>
          <button type="button" class="badge btn btn-outline-secondary py-1 px-2 js-chip-dose" data-val="১ চামচ করে ৩ বার">১ চামচ ৩ বার</button>
          <button type="button" class="badge btn btn-outline-warning text-dark py-1 px-2 js-chip-dose" data-val="প্রয়োজনে (SOS)">প্রয়োজনে (SOS)</button>
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
              {{-- Default Row 1 --}}
              <tr class="medicine-row">
                <td>
                  <input type="text" name="medicines[0][name]" class="form-control form-control-sm js-med-name" placeholder="e.g. Tab. Metformin 500mg" required>
                </td>
                <td>
                  <input type="text" name="medicines[0][dose]" class="form-control form-control-sm js-med-dose" placeholder="১ + ০ + ১" value="১ + ০ + ১">
                </td>
                <td>
                  <select name="medicines[0][timing]" class="form-select form-select-sm js-med-timing">
                    <option value="খাবারের পরে (After Meal)">খাবারের পরে (After Meal)</option>
                    <option value="খাবারের আগে (Before Meal)">খাবারের আগে (Before Meal)</option>
                    <option value="সকালে খালি পেটে (Empty Stomach)">সকালে খালি পেটে (Empty Stomach)</option>
                    <option value="খাবার সাথে সাথে (With Meal)">খাবার সাথে সাথে (With Meal)</option>
                    <option value="রাতে ঘুমানোর আগে (Bedtime)">রাতে ঘুমানোর আগে (Bedtime)</option>
                    <option value="ব্যথার সময় প্রয়োজনে (When Needed/SOS)">ব্যথার সময় প্রয়োজনে (SOS)</option>
                  </select>
                </td>
                <td>
                  <input type="text" name="medicines[0][duration]" class="form-control form-control-sm js-med-duration" placeholder="১ মাস / চলবে" value="১ মাস">
                </td>
                <td>
                  <input type="text" name="medicines[0][instructions]" class="form-control form-control-sm js-med-instruction" placeholder="নিয়মিত সেব্য" value="নিয়মিত সেব্য">
                </td>
                <td class="text-center">
                  <button type="button" class="btn btn-sm btn-outline-danger p-1 remove-row-btn" title="Remove Medicine">
                    <i class="bi bi-trash"></i>
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
              <span>Diagnostic Tests (Investigations)</span>
            </h3>
            <button type="button" class="btn btn-sm btn-outline-info fw-semibold" id="addInvestigationBtn">
              <i class="bi bi-plus-lg me-1"></i> Add Test
            </button>
          </div>
          <div class="card-body p-3" id="investigationsContainer">
            <div class="input-group input-group-sm mb-2 investigation-row">
              <input type="text" name="investigations[0][name]" class="form-control" placeholder="e.g. HbA1c" value="HbA1c">
              <input type="text" name="investigations[0][instructions]" class="form-control" placeholder="Fast 8-10 hrs" value="Fasting">
              <button type="button" class="btn btn-outline-danger remove-inv-btn" title="Remove"><i class="bi bi-trash"></i></button>
            </div>
            <div class="input-group input-group-sm mb-2 investigation-row">
              <input type="text" name="investigations[1][name]" class="form-control" placeholder="e.g. Serum Creatinine" value="Serum Creatinine">
              <input type="text" name="investigations[1][instructions]" class="form-control" placeholder="Routine" value="Routine">
              <button type="button" class="btn btn-outline-danger remove-inv-btn" title="Remove"><i class="bi bi-trash"></i></button>
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
            <label class="form-label small fw-semibold">Patient Lifestyle & Food Advice</label>
            <textarea name="special_advice" id="specialAdviceInput" class="form-control mb-3" rows="4" placeholder="Advice for patient...">নিয়মিত ৪৫ মিনিট দ্রুত হাঁটবেন। খাবারে বাড়তি লবণ ও চিনি পরিহার করবেন। পর্যাপ্ত পানি পান করবেন এবং প্রেসার ও ডায়াবেটিসের ওষুধ বন্ধ করবেন না।</textarea>
            
            <label class="form-label small fw-semibold">Next Review / Visit Date (পরবর্তী সাক্ষাতের তারিখ)</label>
            <input type="date" name="next_visit_date" class="form-control" value="{{ date('Y-m-d', strtotime('+30 days')) }}">
          </div>
        </div>
      </div>
    </div>

    {{-- Sticky Submit Action Bar --}}
    <div class="card border-0 shadow rounded-4 mb-5 p-3 bg-white d-flex flex-column flex-sm-row align-items-center justify-content-between gap-3">
      <div class="d-flex align-items-center gap-2">
        <a href="{{ route('admin.prescriptions.index') }}" class="btn btn-outline-secondary px-3">
          Cancel
        </a>
      </div>
      <div class="d-flex align-items-center gap-3">
        <button type="submit" class="btn btn-success btn-lg px-5 fw-bold shadow-sm d-inline-flex align-items-center gap-2">
          <i class="bi bi-check2-circle fs-5"></i>
          <span>Save & Generate Prescription</span>
        </button>
      </div>
    </div>
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

    // 1. Quick Dose Pills
    document.querySelectorAll('.js-chip-dose').forEach(function(chip) {
      chip.addEventListener('click', function() {
        var val = this.getAttribute('data-val');
        if (!activeDoseInput) {
          var allDose = document.querySelectorAll('.js-med-dose');
          if (allDose.length > 0) activeDoseInput = allDose[allDose.length - 1];
        }
        if (activeDoseInput) {
          activeDoseInput.value = val;
          activeDoseInput.focus();
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
            <option value="খাবারের পরে (After Meal)" ${timing === 'খাবারের পরে (After Meal)' ? 'selected' : ''}>খাবারের পরে (After Meal)</option>
            <option value="খাবারের আগে (Before Meal)" ${timing === 'খাবারের আগে (Before Meal)' ? 'selected' : ''}>খাবারের আগে (Before Meal)</option>
            <option value="সকালে খালি পেটে (Empty Stomach)" ${timing === 'সকালে খালি পেটে (Empty Stomach)' ? 'selected' : ''}>সকালে খালি পেটে (Empty Stomach)</option>
            <option value="খাবার সাথে সাথে (With Meal)" ${timing === 'খাবার সাথে সাথে (With Meal)' ? 'selected' : ''}>খাবার সাথে সাথে (With Meal)</option>
            <option value="রাতে ঘুমানোর আগে (Bedtime)" ${timing === 'রাতে ঘুমানোর আগে (Bedtime)' ? 'selected' : ''}>রাতে ঘুমানোর আগে (Bedtime)</option>
            <option value="ব্যথার সময় প্রয়োজনে (When Needed/SOS)" ${timing === 'ব্যথার সময় প্রয়োজনে (When Needed/SOS)' ? 'selected' : ''}>ব্যথার সময় প্রয়োজনে (SOS)</option>
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

    // 7. Add Investigation Row
    var addInvBtn = document.getElementById('addInvestigationBtn');
    var invContainer = document.getElementById('investigationsContainer');

    function addInvestigationRow(name, instructions) {
      var div = document.createElement('div');
      div.className = 'input-group input-group-sm mb-2 investigation-row';
      div.innerHTML = `
        <input type="text" name="investigations[${invIdx}][name]" class="form-control" placeholder="Test Name (e.g. HbA1c)" value="${name || ''}">
        <input type="text" name="investigations[${invIdx}][instructions]" class="form-control" placeholder="Instructions (e.g. Fasting)" value="${instructions || ''}">
        <button type="button" class="btn btn-outline-danger remove-inv-btn" title="Remove"><i class="bi bi-trash"></i></button>
      `;
      invContainer.appendChild(div);
      invIdx++;
    }

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
  });
</script>
@endpush
