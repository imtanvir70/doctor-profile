<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Prescription {{ $prescription->prescription_no }} - {{ $prescription->patient_name }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Noto+Sans+Bengali:wght@400;500;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  
  <style>
    @media print {
      .no-print { display: none !important; }
      body { margin: 0; padding: 0; background: #fff !important; font-size: 13px; }
      .prescription-sheet { border: none !important; box-shadow: none !important; width: 100% !important; min-height: 100vh !important; margin: 0 !important; padding: 0.5cm !important; }
      @page { size: A4 portrait; margin: 0.8cm; }
    }

    body {
      font-family: 'Inter', 'Noto Sans Bengali', sans-serif;
      background-color: #f1f5f9;
      color: #0f172a;
      padding: 2rem 0;
    }

    .prescription-sheet {
      width: 210mm;
      min-height: 297mm;
      margin: 0 auto;
      background: #ffffff;
      padding: 1.2cm 1.5cm;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      position: relative;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .doctor-header {
      border-bottom: 2.5px solid #0F3B66;
      padding-bottom: 1rem;
      margin-bottom: 1rem;
    }

    .doctor-name-en {
      font-family: 'Outfit', sans-serif;
      font-weight: 800;
      color: #0F3B66;
      font-size: 1.5rem;
      line-height: 1.2;
    }

    .doctor-name-bn {
      font-family: 'Noto Sans Bengali', sans-serif;
      font-weight: 700;
      font-size: 1.35rem;
      color: #0F3B66;
      line-height: 1.2;
    }

    .bmdc-badge-pill {
      background: #e0f2fe;
      color: #0369a1;
      padding: 2px 10px;
      border-radius: 9999px;
      font-size: 0.78rem;
      font-weight: 700;
      display: inline-block;
    }

    .patient-vitals-box {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 0.6rem 0.9rem;
      margin-bottom: 1.25rem;
      font-size: 0.85rem;
    }

    .clinical-body {
      display: flex;
      gap: 1.5rem;
      flex-grow: 1;
    }

    .left-col {
      width: 32%;
      border-right: 1.5px solid #e2e8f0;
      padding-right: 1rem;
    }

    .right-col {
      width: 68%;
      padding-left: 0.5rem;
    }

    .rx-symbol {
      font-family: 'Outfit', serif;
      font-size: 2.2rem;
      font-weight: 800;
      color: #0F3B66;
      line-height: 1;
      margin-bottom: 0.75rem;
    }

    .med-item {
      margin-bottom: 0.9rem;
      padding-bottom: 0.5rem;
      border-bottom: 1px dashed #e2e8f0;
    }

    .med-name {
      font-weight: 700;
      color: #0f172a;
      font-size: 0.96rem;
    }

    .med-dose {
      font-family: 'Noto Sans Bengali', sans-serif;
      font-weight: 700;
      color: #059669;
      font-size: 0.95rem;
    }

    .prescription-footer {
      border-top: 1.5px solid #e2e8f0;
      padding-top: 1rem;
      margin-top: 2rem;
      font-size: 0.78rem;
      color: #64748b;
    }

    .signature-block {
      text-align: right;
      padding-top: 2rem;
    }
    .signature-line {
      width: 180px;
      border-top: 1.5px solid #0f172a;
      display: inline-block;
      margin-bottom: 0.25rem;
    }
  </style>
</head>
<body>

  {{-- Print Action Controls (Hidden on Print) --}}
  <div class="no-print text-center mb-4">
    <div class="d-inline-flex gap-2">
      <button onclick="window.print()" class="btn btn-success fw-bold px-4 py-2 shadow-sm">
        <i class="bi bi-printer-fill me-1"></i> Print / Save as PDF (A4)
      </button>
      <a href="{{ route('admin.prescriptions.show', $prescription->id) }}" class="btn btn-outline-secondary px-3 py-2">
        <i class="bi bi-arrow-left me-1"></i> Back to Prescription Details
      </a>
    </div>
  </div>

  {{-- A4 Prescription Sheet --}}
  <div class="prescription-sheet">
    <div>
      {{-- Doctor Letterhead --}}
      <div class="doctor-header d-flex justify-content-between align-items-start">
        <div style="width: 55%;">
          <div class="doctor-name-en">{{ $profile->name_en ?? 'Dr. Abu Hanif Rakib' }}</div>
          <div class="small fw-semibold text-secondary">{{ $profile->degrees_en ?? 'MBBS (DMC), BCS (Health), FCPS (Medicine)' }}</div>
          <div class="small fw-bold text-dark">{{ $profile->designation_en ?? 'Associate Professor & Consultant, Department of Medicine' }}</div>
          <div class="mt-1">
            <span class="bmdc-badge-pill">BMDC Reg No: {{ $profile->bmdc_reg ?? '84321' }}</span>
          </div>
        </div>
        <div class="text-end" style="width: 45%;">
          <div class="doctor-name-bn">{{ $profile->name_bn ?? 'ডাঃ মোঃ আবু হানিফ রাকিব' }}</div>
          <div class="small fw-semibold text-secondary">{{ $profile->degrees_bn ?? 'এমবিবিএস (ডিএমসি), বিসিএস (স্বাস্থ্য), এফসিপিএস (মেডিসিন)' }}</div>
          <div class="small fw-bold text-dark">{{ $profile->designation_bn ?? 'সহযোগী অধ্যাপক ও কনসালট্যান্ট মেডিসিন বিশেষজ্ঞ' }}</div>
          <div class="small text-muted mt-1"><i class="bi bi-telephone-fill me-1 text-primary"></i>{{ $prescription->chamber->phone1 ?? $profile->hotline_phone ?? '01711-000001' }}</div>
        </div>
      </div>

      {{-- Patient Information & Vitals Row --}}
      <div class="patient-vitals-box">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-1">
          <div><strong>Patient:</strong> {{ $prescription->patient_name }}</div>
          <div><strong>Age / Sex:</strong> {{ $prescription->patient_age ? $prescription->patient_age . ' Yrs' : 'Adult' }} / {{ ucfirst($prescription->patient_gender) }}</div>
          <div><strong>RX ID:</strong> <span class="fw-bold text-primary">{{ $prescription->prescription_no }}</span></div>
          <div><strong>Date:</strong> {{ date('d/m/Y', strtotime($prescription->consultation_date)) }}</div>
        </div>
        @if($prescription->bp_systolic || $prescription->pulse || $prescription->weight || $prescription->blood_sugar)
          <div class="border-top pt-1 mt-1 text-muted d-flex gap-3 flex-wrap" style="font-size: 0.8rem;">
            @if($prescription->bp_systolic) <span><strong>BP:</strong> {{ $prescription->bp_systolic }}/{{ $prescription->bp_diastolic }} mmHg</span> @endif
            @if($prescription->pulse) <span><strong>Pulse:</strong> {{ $prescription->pulse }} bpm</span> @endif
            @if($prescription->weight) <span><strong>Weight:</strong> {{ $prescription->weight }} kg</span> @endif
            @if($prescription->blood_sugar) <span><strong>Sugar:</strong> {{ $prescription->blood_sugar }}</span> @endif
            @if($prescription->temperature) <span><strong>Temp:</strong> {{ $prescription->temperature }}°F</span> @endif
          </div>
        @endif
      </div>

      {{-- Clinical 2-Column Section --}}
      <div class="clinical-body">
        {{-- Left Column: Complaints, Diagnosis, Investigations --}}
        <div class="left-col">
          @if($prescription->chief_complaints)
            <div class="mb-3">
              <div class="fw-bold text-dark small text-uppercase">C/C:</div>
              <div class="small text-muted" style="line-height: 1.4;">{{ $prescription->chief_complaints }}</div>
            </div>
          @endif

          @if($prescription->diagnosis)
            <div class="mb-3">
              <div class="fw-bold text-dark small text-uppercase">Diagnosis:</div>
              <div class="small fw-semibold text-danger" style="line-height: 1.4;">{{ $prescription->diagnosis }}</div>
            </div>
          @endif

          @if(!empty($prescription->investigations) && is_array($prescription->investigations))
            <div class="mb-3">
              <div class="fw-bold text-dark small text-uppercase">Investigations Advised:</div>
              <ol class="small ps-3 text-muted mb-0">
                @foreach($prescription->investigations as $inv)
                  @if(!empty($inv['name']))
                    <li><strong>{{ $inv['name'] }}</strong> @if(!empty($inv['instructions'])) <span>({{ $inv['instructions'] }})</span> @endif</li>
                  @endif
                @endforeach
              </ol>
            </div>
          @endif
        </div>

        {{-- Right Column: Rx, Medicines, Instructions --}}
        <div class="right-col">
          <div class="rx-symbol">℞</div>

          @if(!empty($prescription->medicines) && is_array($prescription->medicines))
            <div class="medicines-container mb-4">
              @foreach($prescription->medicines as $idx => $med)
                <div class="med-item">
                  <div class="d-flex justify-content-between align-items-baseline">
                    <span class="med-name">{{ $idx + 1 }}. {{ $med['name'] ?? '' }}</span>
                    <span class="med-dose">{{ $med['dose'] ?? '' }}</span>
                  </div>
                  <div class="small text-muted ps-3">
                    {{ $med['timing'] ?? '' }} — <span class="fw-semibold text-dark">{{ $med['duration'] ?? '' }}</span>
                    @if(!empty($med['instructions'])) ({{ $med['instructions'] }}) @endif
                  </div>
                </div>
              @endforeach
            </div>
          @endif

          {{-- Special Advice --}}
          @if($prescription->special_advice)
            <div class="p-2 px-3 rounded-2 bg-light border mb-3" style="font-size: 0.82rem; line-height: 1.5;">
              <strong class="text-dark">পরামর্শ / Advice:</strong> {{ $prescription->special_advice }}
            </div>
          @endif

          {{-- Next Visit --}}
          @if($prescription->next_visit_date)
            <div class="small text-muted">
              <strong>পরবর্তী সাক্ষাত / Next Review:</strong> {{ date('F d, Y', strtotime($prescription->next_visit_date)) }}
            </div>
          @endif
        </div>
      </div>
    </div>

    {{-- Footer & Signature --}}
    <div>
      <div class="signature-block">
        <div class="signature-line"></div>
        <div class="small fw-bold text-dark">{{ $profile->name_en ?? 'Dr. Abu Hanif Rakib' }}</div>
        <div class="text-muted" style="font-size: 0.72rem;">Consultant Medicine Specialist</div>
      </div>

      <div class="prescription-footer d-flex justify-content-between align-items-center">
        <div>
          <strong>Chamber:</strong> {{ $prescription->chamber->name_en ?? 'Popular Diagnostic Centre, Dhanmondi' }} • {{ $prescription->chamber->address_en ?? 'Dhanmondi, Dhaka' }}
        </div>
        <div>
          Official Digital EMR • Hotline: {{ $profile->hotline_phone ?? '+880 1700-000000' }}
        </div>
      </div>
    </div>
  </div>

</body>
</html>

