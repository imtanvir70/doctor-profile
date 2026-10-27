@extends('layouts.admin')

@section('title', 'Serial Details: ' . $serial->serial_number)
@section('page_heading', 'Serial Intake: ' . $serial->serial_number)

@section('content')
  <div class="row g-3">
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-header bg-white p-3 border-bottom d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center justify-content-between gap-2">
          <div class="d-flex flex-wrap align-items-center gap-2">
            <span class="badge bg-primary px-2.5 py-1.5 fs-6">{{ $serial->serial_number }}</span>
            <span class="badge bg-light text-dark border px-2 py-1 small">{{ date('d M, Y', strtotime($serial->preferred_date)) }}</span>
          </div>
          <a href="{{ route('admin.serials.index') }}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center justify-content-center gap-1.5 w-100 w-sm-auto">
            <i class="bi bi-arrow-left"></i><span>Back to Queue</span>
          </a>
        </div>
        <div class="card-body p-3">
          <div class="row g-3 mb-3">
            <div class="col-12 col-sm-6">
              <div class="text-muted small">Patient Full Name</div>
              <div class="fs-5 fw-bold text-dark">{{ $serial->patient_name }}</div>
            </div>

            <div class="col-12 col-sm-6">
              <div class="text-muted small">Mobile Phone Number</div>
              <div class="fs-5 fw-bold text-primary">
                <a href="tel:{{ $serial->patient_phone }}" class="text-decoration-none"><i class="bi bi-telephone-fill me-1"></i>{{ $serial->patient_phone }}</a>
              </div>
            </div>

            <div class="col-6 col-sm-4">
              <div class="text-muted small">Assigned Chamber</div>
              <div class="fw-semibold text-dark">{{ $serial->chamber->name_en ?? $serial->chamber_name }}</div>
            </div>

            <div class="col-6 col-sm-4">
              <div class="text-muted small">Age & Gender</div>
              <div class="fw-semibold text-dark">{{ $serial->patient_age ?? 'N/A' }} yrs • {{ ucfirst($serial->patient_gender) }}</div>
            </div>

            <div class="col-12 col-sm-4">
              <div class="text-muted small">Visit Category</div>
              <div class="fw-semibold text-dark text-capitalize">{{ $serial->visit_type }} Consultation</div>
            </div>
          </div>

          <div class="mb-3">
            <h3 class="fs-6 fw-bold text-dark border-bottom pb-2">Reported Symptoms / Reason for Visit</h3>
            <div class="p-3 rounded-3 bg-light border text-muted small" style="line-height: 1.7;">
              {{ $serial->symptoms_summary ?? 'No symptoms provided in online form.' }}
            </div>
          </div>

          {{-- Attached Medical Reports --}}
          <div>
            <h3 class="fs-6 fw-bold text-dark border-bottom pb-2">Uploaded Medical Reports & Prescriptions</h3>
            @if(!empty($serial->medical_reports) && is_array($serial->medical_reports) && count($serial->medical_reports) > 0)
              <div class="row g-2">
                @foreach($serial->medical_reports as $report)
                  <div class="col-12 col-sm-6">
                    <div class="p-2.5 rounded-3 border bg-light d-flex align-items-center justify-content-between gap-2">
                      <div class="d-flex align-items-center gap-2 text-truncate pe-2">
                        <i class="bi bi-file-earmark-pdf-fill text-danger fs-5 flex-shrink-0"></i>
                        <span class="small fw-semibold text-truncate">{{ $report['original_name'] ?? 'Report Document' }}</span>
                      </div>
                      <a href="{{ asset('storage/' . ($report['path'] ?? '')) }}" target="_blank" class="btn btn-sm btn-primary py-1 px-2 flex-shrink-0">
                        <i class="bi bi-download"></i> View
                      </a>
                    </div>
                  </div>
                @endforeach
              </div>
            @else
              <div class="text-muted small py-2">No previous lab documents were uploaded for this serial.</div>
            @endif
          </div>
        </div>
      </div>
    </div>

    {{-- Side Actions & Status --}}
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-header bg-white p-3 border-bottom">
          <h3 class="fs-6 fw-bold mb-0 text-dark brand-font">Status & Actions</h3>
        </div>
        <div class="card-body p-3">
          <form action="{{ route('admin.serials.updateStatus', $serial->id) }}" method="POST">
            @csrf
            <div class="mb-3">
              <label class="form-label small fw-semibold">Current Queue Status</label>
              <select name="status" class="form-select form-select-sm">
                <option value="pending" {{ $serial->status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ $serial->status === 'confirmed' ? 'selected' : '' }}>Confirmed (SMS Ready)</option>
                <option value="completed" {{ $serial->status === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $serial->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">Staff / Chamber Notes</label>
              <textarea name="admin_notes" class="form-control form-control-sm" rows="3" placeholder="Enter notes or remarks...">{{ $serial->admin_notes }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-sm w-100 mb-3 fw-semibold py-2">
              <i class="bi bi-check2 me-1"></i> Update Status
            </button>
          </form>

          <hr class="my-3">

          <a href="{{ route('admin.prescriptions.create', ['serial_id' => $serial->id]) }}" class="btn btn-success btn-sm w-100 fw-bold py-2 shadow-sm d-flex align-items-center justify-content-center gap-1.5">
            <i class="bi bi-prescription2"></i><span>Create Digital Prescription</span>
          </a>

          @if($serial->prescription)
            <div class="mt-3 p-3 rounded-3 bg-success-subtle text-success small">
              <i class="bi bi-check-circle-fill me-1"></i> Linked Prescription: 
              <a href="{{ route('admin.prescriptions.show', $serial->prescription->id) }}" class="fw-bold text-success text-decoration-underline">{{ $serial->prescription->prescription_no }}</a>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection

