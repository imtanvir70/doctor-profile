@extends('layouts.admin')

@section('title', 'Doctor Dashboard')
@section('page_heading', 'Doctor Clinical & Portal Dashboard')

@section('content')
  {{-- Key Stat Metrics --}}
  <div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
      <div class="stat-card">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <span class="text-muted small fw-semibold">Today's Appointments</span>
          <div class="stat-icon-box bg-primary-subtle text-primary">
            <i class="bi bi-calendar2-day-fill"></i>
          </div>
        </div>
        <div class="stat-number">{{ $totalSerialsToday }}</div>
        <div class="small text-muted mt-1"><i class="bi bi-clock me-1 text-primary"></i> For {{ date('M d, Y') }}</div>
      </div>
    </div>

    <div class="col-sm-6 col-xl-3">
      <div class="stat-card">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <span class="text-muted small fw-semibold">Pending Serial Requests</span>
          <div class="stat-icon-box bg-warning-subtle text-warning">
            <i class="bi bi-hourglass-split"></i>
          </div>
        </div>
        <div class="stat-number text-warning">{{ $pendingSerials }}</div>
        <div class="small text-muted mt-1"><i class="bi bi-exclamation-circle me-1 text-warning"></i> Action needed</div>
      </div>
    </div>

    <div class="col-sm-6 col-xl-3">
      <div class="stat-card">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <span class="text-muted small fw-semibold">Digital Prescriptions</span>
          <div class="stat-icon-box bg-success-subtle text-success">
            <i class="bi bi-file-earmark-medical-fill"></i>
          </div>
        </div>
        <div class="stat-number text-success">{{ $totalPrescriptions }}</div>
        <div class="small text-muted mt-1"><i class="bi bi-check2-circle me-1 text-success"></i> EMR records saved</div>
      </div>
    </div>

    <div class="col-sm-6 col-xl-3">
      <div class="stat-card">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <span class="text-muted small fw-semibold">Chambers & Articles</span>
          <div class="stat-icon-box bg-info-subtle text-info">
            <i class="bi bi-hospital"></i>
          </div>
        </div>
        <div class="stat-number text-info">{{ $chambersCount }} <span class="fs-6 fw-normal text-muted">/ {{ $totalArticles }} Posts</span></div>
        <div class="small text-muted mt-1"><i class="bi bi-check-all me-1"></i> Live on site</div>
      </div>
    </div>
  </div>

  {{-- Quick Action Bar --}}
  <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #0F3B66 0%, #1e4976 100%); color: #ffffff;">
    <div class="card-body p-4">
      <div class="row align-items-center g-3">
        <div class="col-lg-7">
          <h2 class="fs-4 fw-bold mb-1 brand-font text-white">Chamber Patient Queue & Digital Prescription</h2>
          <p class="text-slate-200 small mb-0" style="color: #cbd5e1;">Review incoming appointment serial requests, verify patient symptoms, write electronic prescriptions, or manage SEO parameters.</p>
        </div>
        <div class="col-lg-5 text-lg-end">
          <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
            <a href="{{ route('admin.prescriptions.create') }}" class="btn btn-success fw-bold px-3 py-2">
              <i class="bi bi-prescription2 me-1"></i> New Prescription
            </a>
            <a href="{{ route('admin.serials.printDaily', ['date' => date('Y-m-d')]) }}" target="_blank" class="btn btn-light fw-bold px-3 py-2">
              <i class="bi bi-printer-fill me-1"></i> Print Today's Sheet
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Recent Serials & Queue Table --}}
  <div class="row g-4">
    <div class="col-xl-8">
      <div class="admin-table-card">
        <div class="p-3 px-4 border-bottom d-flex align-items-center justify-content-between bg-light">
          <h3 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-people-fill text-primary me-2"></i>Recent Patient Serial Requests</h3>
          <a href="{{ route('admin.serials.index') }}" class="small fw-semibold text-primary text-decoration-none">View All Serials <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light small text-muted text-uppercase">
              <tr>
                <th>Serial / Date</th>
                <th>Patient Details</th>
                <th>Chamber</th>
                <th>Status</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody class="small">
              @forelse($recentSerials as $ser)
                <tr>
                  <td>
                    <span class="fw-bold text-dark d-block">{{ $ser->serial_number }}</span>
                    <span class="text-muted" style="font-size: 0.78rem;">{{ date('M d, Y', strtotime($ser->preferred_date)) }}</span>
                  </td>
                  <td>
                    <div class="fw-semibold text-dark">{{ $ser->patient_name }}</div>
                    <a href="tel:{{ $ser->patient_phone }}" class="text-muted text-decoration-none" style="font-size: 0.8rem;"><i class="bi bi-telephone-fill me-1 text-primary"></i>{{ $ser->patient_phone }}</a>
                  </td>
                  <td>
                    <span class="badge bg-light text-secondary border">{{ $ser->chamber->name_en ?? $ser->chamber_name }}</span>
                  </td>
                  <td>
                    @if($ser->status === 'confirmed')
                      <span class="badge bg-success-subtle text-success">Confirmed</span>
                    @elseif($ser->status === 'completed')
                      <span class="badge bg-info-subtle text-info">Completed</span>
                    @elseif($ser->status === 'cancelled')
                      <span class="badge bg-danger-subtle text-danger">Cancelled</span>
                    @else
                      <span class="badge bg-warning-subtle text-warning">Pending</span>
                    @endif
                  </td>
                  <td class="text-end">
                    <div class="dropdown d-inline-block">
                      <a href="{{ route('admin.serials.show', $ser->id) }}" class="btn btn-sm btn-outline-primary py-1 px-2" title="View Serial Details">
                        <i class="bi bi-eye-fill"></i>
                      </a>
                      <a href="{{ route('admin.prescriptions.create', ['serial_id' => $ser->id]) }}" class="btn btn-sm btn-outline-success py-1 px-2" title="Create Prescription">
                        <i class="bi bi-file-earmark-plus"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center py-4 text-muted">No serial requests found yet.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    {{-- Recent Digital Prescriptions --}}
    <div class="col-xl-4">
      <div class="admin-table-card">
        <div class="p-3 px-4 border-bottom d-flex align-items-center justify-content-between bg-light">
          <h3 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-file-medical text-success me-2"></i>Recent Prescriptions</h3>
          <a href="{{ route('admin.prescriptions.index') }}" class="small fw-semibold text-primary text-decoration-none">View All <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="p-3 d-flex flex-column gap-3">
          @forelse($recentPrescriptions as $rx)
            <div class="p-3 rounded-3 border bg-white shadow-xs">
              <div class="d-flex align-items-center justify-content-between mb-1">
                <span class="badge bg-primary-subtle text-primary fw-bold">{{ $rx->prescription_no }}</span>
                <span class="text-muted small" style="font-size: 0.75rem;">{{ date('M d, Y', strtotime($rx->consultation_date)) }}</span>
              </div>
              <div class="fw-bold text-dark small">{{ $rx->patient_name }} ({{ $rx->patient_age }}y, {{ ucfirst($rx->patient_gender) }})</div>
              <div class="text-muted small mb-2 text-truncate" style="font-size: 0.8rem;">Diagnosis: {{ $rx->diagnosis ?? 'General Checkup' }}</div>
              <div class="d-flex gap-2">
                <a href="{{ route('admin.prescriptions.show', $rx->id) }}" class="btn btn-sm btn-light border py-0 px-2 small">View</a>
                <a href="{{ route('admin.prescriptions.print', $rx->id) }}" target="_blank" class="btn btn-sm btn-outline-secondary py-0 px-2 small"><i class="bi bi-printer me-1"></i>Print A4</a>
              </div>
            </div>
          @empty
            <div class="text-center py-4 text-muted small">No prescriptions written yet.</div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
@endsection

