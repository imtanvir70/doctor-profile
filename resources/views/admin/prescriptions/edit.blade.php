@extends('layouts.admin')

@section('title', 'Edit Prescription: ' . $prescription->prescription_no)
@section('page_heading', 'Edit Prescription ' . $prescription->prescription_no)

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
        {{-- Quick Dosage Pills Helper --}}
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
              <span>Diagnostic Tests (Investigations)</span>
            </h3>
            <button type="button" class="btn btn-sm btn-outline-info fw-semibold" id="addInvestigationBtn">
              <i class="bi bi-plus-lg me-1"></i> Add Test
            </button>
          </div>
          <div class="card-body p-3" id="investigationsContainer">
            @php
              $invs = old('investigations', $prescription->investigations ?? []);
              if(empty($invs)) $invs = [['name' => '', 'instructions' => '']];
            @endphp
            @foreach($invs as $iIdx => $inv)
              <div class="input-group input-group-sm mb-2 investigation-row">
                <input type="text" name="investigations[{{ $iIdx }}][name]" class="form-control" placeholder="Test Name" value="{{ $inv['name'] ?? '' }}">
                <input type="text" name="investigations[{{ $iIdx }}][instructions]" class="form-control" placeholder="Instructions" value="{{ $inv['instructions'] ?? '' }}">
                <button type="button" class="btn btn-outline-danger remove-inv-btn" title="Remove"><i class="bi bi-trash"></i></button>
              </div>
            @endforeach
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

    var addInvBtn = document.getElementById('addInvestigationBtn');
    var invContainer = document.getElementById('investigationsContainer');

    function addInvestigationRow(name, instructions) {
      var div = document.createElement('div');
      div.className = 'input-group input-group-sm mb-2 investigation-row';
      div.innerHTML = `
        <input type="text" name="investigations[${invIdx}][name]" class="form-control" placeholder="Test Name" value="${name || ''}">
        <input type="text" name="investigations[${invIdx}][instructions]" class="form-control" placeholder="Instructions" value="${instructions || ''}">
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

    checkDuplicateMedicines();
  });
</script>
@endpush
