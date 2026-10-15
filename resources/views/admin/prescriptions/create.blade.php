@extends('layouts.admin')

@section('title', 'Write Digital Prescription')
@section('page_heading', 'Doctor Prescription (EMR Pad)')

@section('content')
  <form action="{{ route('admin.prescriptions.store') }}" method="POST" id="prescriptionForm">
    @csrf

    @if($serial)
      <input type="hidden" name="serial_id" value="{{ $serial->id }}">
      <div class="alert alert-info d-flex align-items-center justify-content-between mb-4">
        <div>
          <i class="bi bi-link-45deg me-1 fs-5"></i>
          Linked to Appointment Serial: <strong>{{ $serial->serial_number }}</strong> (Patient: {{ $serial->patient_name }})
        </div>
        <span class="badge bg-primary">Auto-filled</span>
      </div>
    @endif

    {{-- Top Patient & Prescription Header Card --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
      <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <h2 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-person-fill text-primary me-2"></i>Patient Intake Information</h2>
        <div class="d-flex align-items-center gap-2">
          <label class="small text-muted fw-semibold">Prescription No:</label>
          <input type="text" name="prescription_no" class="form-control form-control-sm fw-bold text-primary" style="width: 150px;" value="{{ old('prescription_no', $nextPrescriptionNo) }}" required readonly>
        </div>
      </div>
      <div class="card-body p-4">
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label small fw-semibold">Patient Full Name <span class="text-danger">*</span></label>
            <input type="text" name="patient_name" class="form-control" value="{{ old('patient_name', $serial->patient_name ?? '') }}" placeholder="e.g. Mohammad Hossain" required>
          </div>

          <div class="col-md-4">
            <label class="form-label small fw-semibold">Mobile Phone <span class="text-danger">*</span></label>
            <input type="tel" name="patient_phone" class="form-control" value="{{ old('patient_phone', $serial->patient_phone ?? '') }}" placeholder="017XXXXXXXX" required>
          </div>

          <div class="col-md-2">
            <label class="form-label small fw-semibold">Age (Years)</label>
            <input type="number" name="patient_age" class="form-control" value="{{ old('patient_age', $serial->patient_age ?? '') }}" placeholder="45" min="1" max="120">
          </div>

          <div class="col-md-2">
            <label class="form-label small fw-semibold">Gender <span class="text-danger">*</span></label>
            <select name="patient_gender" class="form-select" required>
              <option value="male" {{ old('patient_gender', $serial->patient_gender ?? 'male') == 'male' ? 'selected' : '' }}>Male</option>
              <option value="female" {{ old('patient_gender', $serial->patient_gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
              <option value="other" {{ old('patient_gender', $serial->patient_gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
            </select>
          </div>

          <div class="col-md-4">
            <label class="form-label small fw-semibold">Chamber Location</label>
            <select name="chamber_id" class="form-select">
              <option value="">Select Chamber</option>
              @foreach($chambers as $ch)
                <option value="{{ $ch->id }}" {{ old('chamber_id', $serial->chamber_id ?? '') == $ch->id ? 'selected' : '' }}>{{ $ch->name_en }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-4">
            <label class="form-label small fw-semibold">Consultation Date <span class="text-danger">*</span></label>
            <input type="date" name="consultation_date" class="form-control" value="{{ old('consultation_date', date('Y-m-d')) }}" required>
          </div>

          <div class="col-md-4">
            <label class="form-label small fw-semibold">Patient Address / City</label>
            <input type="text" name="patient_address" class="form-control" value="{{ old('patient_address') }}" placeholder="Dhanmondi, Dhaka">
          </div>
        </div>
      </div>
    </div>

    {{-- Clinical Vitals Bar --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
      <div class="card-header bg-light py-2 px-4 border-bottom">
        <h3 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-activity text-danger me-2"></i>Clinical Vitals & Measurements</h3>
      </div>
      <div class="card-body p-4">
        <div class="row g-3">
          <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold">BP (Systolic)</label>
            <input type="text" name="bp_systolic" class="form-control form-control-sm" value="{{ old('bp_systolic', '120') }}" placeholder="120">
          </div>
          <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold">BP (Diastolic)</label>
            <input type="text" name="bp_diastolic" class="form-control form-control-sm" value="{{ old('bp_diastolic', '80') }}" placeholder="80">
          </div>
          <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold">Pulse (bpm)</label>
            <input type="text" name="pulse" class="form-control form-control-sm" value="{{ old('pulse', '76') }}" placeholder="76">
          </div>
          <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold">Weight (kg)</label>
            <input type="text" name="weight" class="form-control form-control-sm" value="{{ old('weight') }}" placeholder="70">
          </div>
          <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold">Temp (°F)</label>
            <input type="text" name="temperature" class="form-control form-control-sm" value="{{ old('temperature', '98.4') }}" placeholder="98.4">
          </div>
          <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold">Blood Sugar</label>
            <input type="text" name="blood_sugar" class="form-control form-control-sm" value="{{ old('blood_sugar') }}" placeholder="6.5 mmol/L">
          </div>
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
            <textarea name="chief_complaints" class="form-control mb-3" rows="3" placeholder="Chief complaints (e.g. Uncontrolled diabetes, weakness for 2 weeks, polyuria)...">{{ old('chief_complaints', $serial->symptoms_summary ?? '') }}</textarea>
            <label class="form-label small fw-semibold">Clinical Examination & Past Medical History</label>
            <textarea name="clinical_history" class="form-control" rows="2" placeholder="e.g. Known hypertensive for 5 years on Telmisartan; non-smoker.">{{ old('clinical_history') }}</textarea>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
          <div class="card-header bg-white py-3 border-bottom">
            <h3 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-search-heart text-danger me-2"></i>Clinical Diagnosis / Impression</h3>
          </div>
          <div class="card-body p-3">
            <textarea name="diagnosis" class="form-control mb-3" rows="3" placeholder="Primary Diagnosis (e.g. Type 2 Diabetes Mellitus with Poor Glycemic Control, Essential Hypertension)...">{{ old('diagnosis') }}</textarea>
            <label class="form-label small fw-semibold">Confidential Doctor Notes (Internal only)</label>
            <textarea name="doctor_notes" class="form-control" rows="2" placeholder="Notes for doctor reference only...">{{ old('doctor_notes') }}</textarea>
          </div>
        </div>
      </div>
    </div>

    {{-- Rx Medicine Table (Dynamic Rows) --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
      <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
          <span class="fs-4 fw-bold text-primary font-monospace">Rx</span>
          <h3 class="fs-6 fw-bold mb-0 text-dark brand-font">Prescribed Medicines & Dosages</h3>
        </div>
        <button type="button" class="btn btn-sm btn-outline-primary fw-semibold" id="addMedicineBtn">
          <i class="bi bi-plus-lg me-1"></i> Add Another Medicine
        </button>
      </div>
      <div class="card-body p-3 p-md-4">
        <div class="table-responsive">
          <table class="table table-bordered align-middle mb-0" id="medicinesTable">
            <thead class="table-light small text-muted text-uppercase">
              <tr>
                <th style="width: 32%;">Medicine Name & Strength</th>
                <th style="width: 18%;">Dosage (১+০+১)</th>
                <th style="width: 18%;">Timing</th>
                <th style="width: 14%;">Duration</th>
                <th style="width: 14%;">Special Instruction</th>
                <th style="width: 4%;"></th>
              </tr>
            </thead>
            <tbody id="medicineRowsContainer">
              {{-- Row 1 --}}
              <tr class="medicine-row">
                <td>
                  <input type="text" name="medicines[0][name]" class="form-control form-control-sm" placeholder="Tab. Metformin 500mg" required>
                </td>
                <td>
                  <input type="text" name="medicines[0][dose]" class="form-control form-control-sm" placeholder="১ + ০ + ১" value="১ + ০ + ১">
                </td>
                <td>
                  <select name="medicines[0][timing]" class="form-select form-select-sm">
                    <option value="খাবারের পরে (After Meal)">খাবারের পরে (After Meal)</option>
                    <option value="খাবারের আগে (Before Meal)">খাবারের আগে (Before Meal)</option>
                    <option value="খাবার সাথে সাথে (With Meal)">খাবার সাথে সাথে (With Meal)</option>
                    <option value="রাতে ঘুমানোর আগে (Bedtime)">রাতে ঘুমানোর আগে (Bedtime)</option>
                  </select>
                </td>
                <td>
                  <input type="text" name="medicines[0][duration]" class="form-control form-control-sm" placeholder="১ মাস / চলতেই থাকবে" value="১ মাস">
                </td>
                <td>
                  <input type="text" name="medicines[0][instructions]" class="form-control form-control-sm" placeholder="নিয়মিত সেব্য">
                </td>
                <td class="text-center">
                  <button type="button" class="btn btn-sm btn-outline-danger p-1 remove-row-btn" title="Remove"><i class="bi bi-trash"></i></button>
                </td>
              </tr>

              {{-- Row 2 --}}
              <tr class="medicine-row">
                <td>
                  <input type="text" name="medicines[1][name]" class="form-control form-control-sm" placeholder="Tab. Telmisartan 40mg">
                </td>
                <td>
                  <input type="text" name="medicines[1][dose]" class="form-control form-control-sm" placeholder="১ + ০ + ০" value="১ + ০ + ০">
                </td>
                <td>
                  <select name="medicines[1][timing]" class="form-select form-select-sm">
                    <option value="খাবারের পরে (After Meal)">খাবারের পরে (After Meal)</option>
                    <option value="সকালে খাবারের পর (Morning)">সকালে খাবারের পর (Morning)</option>
                    <option value="খাবারের আগে (Before Meal)">খাবারের আগে (Before Meal)</option>
                  </select>
                </td>
                <td>
                  <input type="text" name="medicines[1][duration]" class="form-control form-control-sm" placeholder="চলবে" value="চলবে">
                </td>
                <td>
                  <input type="text" name="medicines[1][instructions]" class="form-control form-control-sm" placeholder="প্রতিদিন সকালে">
                </td>
                <td class="text-center">
                  <button type="button" class="btn btn-sm btn-outline-danger p-1 remove-row-btn" title="Remove"><i class="bi bi-trash"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    {{-- Investigations & Advice --}}
    <div class="row g-4 mb-4">
      <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
          <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h3 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-eyedropper text-info me-2"></i>Diagnostic Tests (Investigations)</h3>
            <button type="button" class="btn btn-sm btn-outline-info" id="addInvestigationBtn"><i class="bi bi-plus"></i> Add Test</button>
          </div>
          <div class="card-body p-3" id="investigationsContainer">
            <div class="input-group input-group-sm mb-2 investigation-row">
              <input type="text" name="investigations[0][name]" class="form-control" placeholder="e.g. HbA1c" value="HbA1c">
              <input type="text" name="investigations[0][instructions]" class="form-control" placeholder="Fast 8-10 hrs" value="Fasting">
            </div>
            <div class="input-group input-group-sm mb-2 investigation-row">
              <input type="text" name="investigations[1][name]" class="form-control" placeholder="e.g. Serum Creatinine" value="Serum Creatinine">
              <input type="text" name="investigations[1][instructions]" class="form-control" placeholder="Routine" value="Routine">
            </div>
            <div class="input-group input-group-sm mb-2 investigation-row">
              <input type="text" name="investigations[2][name]" class="form-control" placeholder="e.g. Lipid Profile" value="Lipid Profile">
              <input type="text" name="investigations[2][instructions]" class="form-control" placeholder="Fasting" value="12h Fasting">
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
          <div class="card-header bg-white py-3 border-bottom">
            <h3 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-heart-pulse-fill text-success me-2"></i>Dietary & Clinical Advice</h3>
          </div>
          <div class="card-body p-3">
            <textarea name="special_advice" class="form-control mb-3" rows="4" placeholder="Advice for patient (e.g. নিয়মিত ৪৫ মিনিট দ্রুত হাঁটবেন, খাবারে বাড়তি লবণ পরিহার করবেন, তেল-চর্বিযুক্ত খাবার এড়িয়ে চলবেন)...">নিয়মিত ৪৫ মিনিট দ্রুত হাঁটবেন। খাবারে বাড়তি লবণ ও চিনি পরিহার করবেন। পর্যাপ্ত পানি পান করবেন এবং প্রেসার ও ডায়াবেটিসের ওষুধ বন্ধ করবেন না।</textarea>
            
            <label class="form-label small fw-semibold">Next Review / Visit Date</label>
            <input type="date" name="next_visit_date" class="form-control" value="{{ date('Y-m-d', strtotime('+30 days')) }}">
          </div>
        </div>
      </div>
    </div>

    {{-- Submission Buttons --}}
    <div class="d-flex align-items-center justify-content-end gap-3 mb-5">
      <a href="{{ route('admin.prescriptions.index') }}" class="btn btn-outline-secondary">Cancel</a>
      <button type="submit" class="btn btn-success btn-lg px-5 fw-bold shadow">
        <i class="bi bi-check2-circle me-1"></i> Save & Generate Prescription
      </button>
    </div>
  </form>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var medIdx = 2;
    var addMedicineBtn = document.getElementById('addMedicineBtn');
    var rowsContainer = document.getElementById('medicineRowsContainer');

    if (addMedicineBtn && rowsContainer) {
      addMedicineBtn.addEventListener('click', function() {
        var tr = document.createElement('tr');
        tr.className = 'medicine-row';
        tr.innerHTML = `
          <td><input type="text" name="medicines[${medIdx}][name]" class="form-control form-control-sm" placeholder="Medicine Name & Strength" required></td>
          <td><input type="text" name="medicines[${medIdx}][dose]" class="form-control form-control-sm" placeholder="১ + ০ + ১" value="১ + ০ + ১"></td>
          <td>
            <select name="medicines[${medIdx}][timing]" class="form-select form-select-sm">
              <option value="খাবারের পরে (After Meal)">খাবারের পরে (After Meal)</option>
              <option value="খাবারের আগে (Before Meal)">খাবারের আগে (Before Meal)</option>
              <option value="রাতে ঘুমানোর আগে (Bedtime)">রাতে ঘুমানোর আগে (Bedtime)</option>
              <option value="সকালে খাবারের পর (Morning)">সকালে খাবারের পর (Morning)</option>
            </select>
          </td>
          <td><input type="text" name="medicines[${medIdx}][duration]" class="form-control form-control-sm" placeholder="৭ দিন / ১ মাস" value="১ মাস"></td>
          <td><input type="text" name="medicines[${medIdx}][instructions]" class="form-control form-control-sm" placeholder="নিয়মিত সেব্য"></td>
          <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger p-1 remove-row-btn" title="Remove"><i class="bi bi-trash"></i></button></td>
        `;
        rowsContainer.appendChild(tr);
        medIdx++;
      });

      rowsContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-row-btn')) {
          var row = e.target.closest('tr');
          if (rowsContainer.querySelectorAll('tr').length > 1) {
            row.remove();
          } else {
            alert('At least one medicine is required.');
          }
        }
      });
    }

    var invIdx = 3;
    var addInvestigationBtn = document.getElementById('addInvestigationBtn');
    var invContainer = document.getElementById('investigationsContainer');
    if (addInvestigationBtn && invContainer) {
      addInvestigationBtn.addEventListener('click', function() {
        var div = document.createElement('div');
        div.className = 'input-group input-group-sm mb-2 investigation-row';
        div.innerHTML = `
          <input type="text" name="investigations[${invIdx}][name]" class="form-control" placeholder="Test Name">
          <input type="text" name="investigations[${invIdx}][instructions]" class="form-control" placeholder="Instructions">
        `;
        invContainer.appendChild(div);
        invIdx++;
      });
    }
  });
</script>
@endsection

