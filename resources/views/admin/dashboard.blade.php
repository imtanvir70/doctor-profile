@extends('layouts.admin')

@section('title', 'Doctor Dashboard')
@section('page_heading', 'Doctor Clinical & Portal Dashboard')

@section('content')
  {{-- Key Stat Metrics --}}
  <div class="row g-2 g-md-3 mb-3">
    <div class="col-6 col-xl-3">
      <div class="stat-card h-100 p-3">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <div class="stat-icon-box bg-primary-subtle text-primary">
            <i class="bi bi-calendar2-day-fill"></i>
          </div>
          <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 small d-none d-sm-inline-block">Today</span>
        </div>
        <div class="stat-number">{{ $totalSerialsToday }}</div>
        <div class="stat-card-title">Today's Visits</div>
        <div class="small text-muted" style="font-size: 0.75rem;"><i class="bi bi-clock me-1 text-primary"></i>{{ date('M d, Y') }}</div>
      </div>
    </div>

    <div class="col-6 col-xl-3">
      <div class="stat-card h-100 p-3">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <div class="stat-icon-box bg-warning-subtle text-warning">
            <i class="bi bi-hourglass-split"></i>
          </div>
          <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1 small d-none d-sm-inline-block">Queue</span>
        </div>
        <div class="stat-number text-warning">{{ $pendingSerials }}</div>
        <div class="stat-card-title">Pending Queue</div>
        <div class="small text-muted" style="font-size: 0.75rem;"><i class="bi bi-exclamation-circle me-1 text-warning"></i>Action needed</div>
      </div>
    </div>

    <div class="col-6 col-xl-3">
      <div class="stat-card h-100 p-3">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <div class="stat-icon-box bg-success-subtle text-success">
            <i class="bi bi-file-earmark-medical-fill"></i>
          </div>
          <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 small d-none d-sm-inline-block">EMR</span>
        </div>
        <div class="stat-number text-success">{{ $totalPrescriptions }}</div>
        <div class="stat-card-title">Prescriptions</div>
        <div class="small text-muted" style="font-size: 0.75rem;"><i class="bi bi-check2-circle me-1 text-success"></i>EMR records</div>
      </div>
    </div>

    <div class="col-6 col-xl-3">
      <div class="stat-card h-100 p-3">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <div class="stat-icon-box bg-info-subtle text-info">
            <i class="bi bi-hospital"></i>
          </div>
          <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1 small d-none d-sm-inline-block">Live</span>
        </div>
        <div class="stat-number text-info">{{ $chambersCount }} <span class="fs-6 fw-normal text-muted">/ {{ $totalArticles }}</span></div>
        <div class="stat-card-title">Chambers & Blogs</div>
        <div class="small text-muted" style="font-size: 0.75rem;"><i class="bi bi-check-all me-1"></i>Live on site</div>
      </div>
    </div>
  </div>

  {{-- Quick Action Bar --}}
  <div class="card border-0 shadow-sm rounded-4 mb-3" style="background: linear-gradient(135deg, #0F3B66 0%, #1e4976 100%); color: #ffffff;">
    <div class="card-body p-3">
      <div class="row align-items-center g-3">
        <div class="col-lg-7">
          <h2 class="fs-6 fw-bold mb-1 brand-font text-white">Chamber Patient Queue & Digital Prescription</h2>
          <p class="text-white-50 small mb-0" style="font-size: 0.8rem;">Review patient appointments, check symptoms, and write electronic prescriptions.</p>
        </div>
        <div class="col-lg-5">
          <div class="row g-2">
            <div class="col-12 col-sm-6">
              <a href="{{ route('admin.prescriptions.create') }}" class="btn btn-success btn-sm fw-bold py-2 px-3 w-100 d-flex align-items-center justify-content-center gap-1.5 shadow-sm">
                <i class="bi bi-prescription2"></i>
                <span>New Prescription</span>
              </a>
            </div>
            <div class="col-12 col-sm-6">
              <a href="{{ route('admin.serials.printDaily', ['date' => date('Y-m-d')]) }}" target="_blank" class="btn btn-light btn-sm fw-bold py-2 px-3 w-100 d-flex align-items-center justify-content-center gap-1.5 shadow-sm text-dark">
                <i class="bi bi-printer-fill"></i>
                <span>Print Today's Sheet</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Recent Serials & Queue Table --}}
  <div class="row g-3">
    <div class="col-xl-8">
      <div class="admin-table-card">
        <div class="p-3 border-bottom d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-2 bg-light">
          <h3 class="fs-6 fw-bold mb-0 text-dark brand-font d-flex align-items-center"><i class="bi bi-people-fill text-primary me-2"></i>Recent Patient Serials</h3>
          <a href="{{ route('admin.serials.index') }}" class="small fw-semibold text-primary text-decoration-none d-inline-flex align-items-center">View All Serials <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0 table-to-card">
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
                  <td data-label="Serial / Date">
                    <span class="fw-bold text-dark d-block">{{ $ser->serial_number }}</span>
                    <span class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-calendar3 me-1"></i>{{ date('M d, Y', strtotime($ser->preferred_date)) }}</span>
                  </td>
                  <td data-label="Patient Details">
                    <div class="fw-semibold text-dark">{{ $ser->patient_name }}</div>
                    <a href="tel:{{ $ser->patient_phone }}" class="text-muted text-decoration-none" style="font-size: 0.8rem;"><i class="bi bi-telephone-fill me-1 text-primary"></i>{{ $ser->patient_phone }}</a>
                  </td>
                  <td data-label="Chamber">
                    <span class="badge bg-light text-secondary border px-2 py-1 small">{{ $ser->chamber->name_en ?? $ser->chamber_name }}</span>
                  </td>
                  <td data-label="Status">
                    @if($ser->status === 'confirmed')
                      <span class="badge bg-success-subtle text-success px-2 py-1 small">Confirmed</span>
                    @elseif($ser->status === 'completed')
                      <span class="badge bg-info-subtle text-info px-2 py-1 small">Completed</span>
                    @elseif($ser->status === 'cancelled')
                      <span class="badge bg-danger-subtle text-danger px-2 py-1 small">Cancelled</span>
                    @else
                      <span class="badge bg-warning-subtle text-warning px-2 py-1 small">Pending</span>
                    @endif
                  </td>
                  <td class="text-end" data-label="Actions">
                    <div class="d-flex flex-wrap gap-2 align-items-center justify-content-end">
                      <a href="{{ route('admin.serials.show', $ser->id) }}" class="btn btn-sm btn-outline-primary py-1 px-2 d-inline-flex align-items-center gap-1" title="View Serial Details">
                        <i class="bi bi-eye-fill"></i><span>View</span>
                      </a>
                      <a href="{{ route('admin.prescriptions.create', ['serial_id' => $ser->id]) }}" class="btn btn-sm btn-outline-success py-1 px-2 d-inline-flex align-items-center gap-1" title="Create Prescription">
                        <i class="bi bi-prescription2"></i><span>New Rx</span>
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
        <div class="p-3 border-bottom d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-2 bg-light">
          <h3 class="fs-6 fw-bold mb-0 text-dark brand-font d-flex align-items-center"><i class="bi bi-file-medical text-success me-2"></i>Recent Prescriptions</h3>
          <a href="{{ route('admin.prescriptions.index') }}" class="small fw-semibold text-primary text-decoration-none d-inline-flex align-items-center">View All <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
        <div class="p-3 d-flex flex-column gap-2">
          @forelse($recentPrescriptions as $rx)
            <div class="p-3 rounded-3 border bg-white shadow-xs">
              <div class="d-flex align-items-center justify-content-between mb-1">
                <span class="badge bg-primary-subtle text-primary fw-bold px-2 py-1 small">{{ $rx->prescription_no }}</span>
                <span class="text-muted small" style="font-size: 0.75rem;">{{ date('M d, Y', strtotime($rx->consultation_date)) }}</span>
              </div>
              <div class="fw-bold text-dark small">{{ $rx->patient_name }} ({{ $rx->patient_age }}y, {{ ucfirst($rx->patient_gender) }})</div>
              <div class="text-muted small mb-2 text-truncate" style="font-size: 0.8rem;">Diagnosis: {{ $rx->diagnosis ?? 'General Checkup' }}</div>
              <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.prescriptions.show', $rx->id) }}" class="btn btn-sm btn-light border py-1 px-2 small">View</a>
                <a href="{{ route('admin.prescriptions.print', $rx->id) }}" target="_blank" class="btn btn-sm btn-outline-secondary py-1 px-2 small"><i class="bi bi-printer me-1"></i>Print A4</a>
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
