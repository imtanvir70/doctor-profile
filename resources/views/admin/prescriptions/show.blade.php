@extends('layouts.admin')

@section('title', 'Prescription: ' . $prescription->prescription_no)
@section('page_heading', 'Prescription ' . $prescription->prescription_no)

@section('content')
  <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-2 mb-3">
    <div class="d-flex flex-wrap align-items-center gap-2">
      <span class="badge bg-primary px-2.5 py-1.5 fs-6">{{ $prescription->prescription_no }}</span>
      <span class="badge bg-light text-dark border px-2 py-1 small">{{ date('d M, Y', strtotime($prescription->consultation_date)) }}</span>
    </div>

    <div class="d-flex flex-wrap gap-2 w-100 w-sm-auto justify-content-start justify-content-sm-end">
      <a href="{{ route('admin.prescriptions.edit', $prescription->id) }}" class="btn btn-sm btn-outline-warning text-dark fw-semibold flex-fill flex-sm-grow-0 d-inline-flex align-items-center justify-content-center gap-1">
        <i class="bi bi-pencil-square"></i><span>Edit</span>
      </a>
      <a href="{{ route('admin.prescriptions.print', $prescription->id) }}" target="_blank" class="btn btn-sm btn-success fw-semibold flex-fill flex-sm-grow-0 d-inline-flex align-items-center justify-content-center gap-1">
        <i class="bi bi-printer-fill"></i><span>Print (A4)</span>
      </a>
      <a href="{{ route('admin.prescriptions.index') }}" class="btn btn-sm btn-outline-secondary flex-fill flex-sm-grow-0 d-inline-flex align-items-center justify-content-center gap-1">
        <i class="bi bi-arrow-left"></i><span>Back</span>
      </a>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-lg-8">
      {{-- Prescription Sheet Preview --}}
      <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 bg-white mb-3">
        {{-- Header Preview --}}
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 border-bottom pb-4 mb-4">
          <div>
            <h2 class="fs-4 fw-bold text-primary mb-1 brand-font">{{ $profile->name_en ?? 'Dr. Abu Hanif Rakib' }}</h2>
            <div class="small fw-semibold text-secondary">{{ $profile->designation_en ?? 'Consultant Medicine Specialist' }}</div>
            @if (!empty($profile->bmdc_reg))
            <div class="small text-success fw-semibold">BMDC Reg No: {{ $profile->bmdc_reg }}</div>
            @endif
          </div>
          <div class="text-sm-end">
            <h3 class="fs-5 fw-bold text-dark mb-1">{{ $profile->name_bn ?? $profile->name_en ?? '' }}</h3>
            <div class="small text-muted">{{ $profile->designation_bn ?? $profile->designation_en ?? '' }}</div>
            @if($chamber)
              <div class="small text-muted">{{ $chamber->name_en ?? $chamber->name_bn }}</div>
            @endif
          </div>
        </div>

        {{-- Patient & Vitals Banner --}}
        <div class="p-3 rounded-3 mb-4" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
          <div class="row g-2 small">
            <div class="col-sm-4">
              <strong>Patient:</strong> {{ $prescription->patient_name }}
            </div>
            <div class="col-sm-2">
              <strong>Age/Sex:</strong> {{ $prescription->patient_age }}y / {{ ucfirst($prescription->patient_gender) }}
            </div>
            <div class="col-sm-3">
              <strong>Phone:</strong> {{ $prescription->patient_phone }}
            </div>
            <div class="col-sm-3 text-sm-end">
              <strong>Date:</strong> {{ date('d M, Y', strtotime($prescription->consultation_date)) }}
            </div>
            @if($prescription->bp_systolic || $prescription->pulse || $prescription->weight || $prescription->blood_sugar)
              <div class="col-12 mt-2 pt-2 border-top text-muted">
                <strong>Vitals:</strong> 
                @if($prescription->bp_systolic) BP: {{ $prescription->bp_systolic }}/{{ $prescription->bp_diastolic }} mmHg • @endif
                @if($prescription->pulse) Pulse: {{ $prescription->pulse }} bpm • @endif
                @if($prescription->weight) Weight: {{ $prescription->weight }} kg • @endif
                @if($prescription->blood_sugar) Sugar: {{ $prescription->blood_sugar }} • @endif
                @if($prescription->temperature) Temp: {{ $prescription->temperature }}°F @endif
              </div>
            @endif
          </div>
        </div>

        {{-- Two-column clinical area --}}
        <div class="row g-4">
          <div class="col-md-4 border-end">
            @if($prescription->chief_complaints)
              <div class="mb-3">
                <div class="fw-bold text-dark small text-uppercase">Complaints</div>
                <div class="small text-muted">{{ $prescription->chief_complaints }}</div>
              </div>
            @endif

            @if($prescription->diagnosis)
              <div class="mb-3">
                <div class="fw-bold text-danger small text-uppercase">Diagnosis</div>
                <div class="small fw-semibold text-dark">{{ $prescription->diagnosis }}</div>
              </div>
            @endif

            @if(!empty($prescription->investigations) && is_array($prescription->investigations))
              <div class="mb-3">
                <div class="fw-bold text-primary small text-uppercase">Investigations Advised</div>
                <ul class="list-unstyled small text-muted mb-0">
                  @foreach($prescription->investigations as $inv)
                    @if(!empty($inv['name']))
                      <li><i class="bi bi-dot"></i> {{ $inv['name'] }} @if(!empty($inv['instructions'])) <span class="text-secondary">({{ $inv['instructions'] }})</span> @endif</li>
                    @endif
                  @endforeach
                </ul>
              </div>
            @endif
          </div>

          <div class="col-md-8 ps-md-4">
            <div class="display-6 fw-bold text-primary font-monospace mb-3">Rx</div>

            @if(!empty($prescription->medicines) && is_array($prescription->medicines))
              <div class="d-flex flex-column gap-3 mb-4">
                @foreach($prescription->medicines as $idx => $med)
                  <div class="p-2 px-3 rounded-2 border-start border-3 border-primary bg-light">
                    <div class="d-flex align-items-center justify-content-between">
                      <strong class="text-dark">{{ $idx + 1 }}. {{ $med['name'] ?? '' }}</strong>
                      <span class="badge bg-primary-subtle text-primary fw-bold">{{ $med['dose'] ?? '' }}</span>
                    </div>
                    <div class="small text-muted mt-1">
                      {{ $med['timing'] ?? '' }} • <span class="text-dark fw-semibold">{{ $med['duration'] ?? '' }}</span>
                      @if(!empty($med['instructions'])) - {{ $med['instructions'] }} @endif
                    </div>
                  </div>
                @endforeach
              </div>
            @endif

            @if($prescription->special_advice)
              <div class="p-3 rounded-3 bg-light border mb-4">
                <div class="fw-bold small text-dark mb-1"><i class="bi bi-info-circle-fill text-success me-1"></i> Advice / পরামর্শ:</div>
                <div class="small text-muted" style="line-height: 1.6;">{{ $prescription->special_advice }}</div>
              </div>
            @endif

            @if($prescription->next_visit_date)
              <div class="small text-muted">
                <strong>Next Review:</strong> {{ date('d M, Y', strtotime($prescription->next_visit_date)) }}
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>

    {{-- Side Meta Actions --}}
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white py-3 border-bottom">
          <h3 class="fs-6 fw-bold mb-0 text-dark brand-font">Quick Actions</h3>
        </div>
        <div class="card-body p-4">
          <a href="{{ route('admin.prescriptions.print', $prescription->id) }}" target="_blank" class="btn btn-success w-100 fw-bold py-2 mb-3">
            <i class="bi bi-printer me-1"></i> Print / PDF Prescription
          </a>

          <a href="tel:{{ $prescription->patient_phone }}" class="btn btn-outline-primary w-100 mb-3">
            <i class="bi bi-telephone-fill me-1"></i> Call Patient ({{ $prescription->patient_phone }})
          </a>

          @if($prescription->serial)
            <div class="p-3 rounded-3 bg-light border small text-muted mb-3">
              <i class="bi bi-link-45deg me-1"></i> Appointment Serial: 
              <a href="{{ route('admin.serials.show', $prescription->serial->id) }}" class="fw-bold">{{ $prescription->serial->serial_number }}</a>
            </div>
          @endif

          <form action="{{ route('admin.prescriptions.destroy', $prescription->id) }}" method="POST" onsubmit="return confirm('Permanently delete this prescription record?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger w-100 btn-sm">
              <i class="bi bi-trash me-1"></i> Delete Prescription
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

