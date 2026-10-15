@extends('layouts.admin')

@section('title', 'Serial & Appointment Queue')
@section('page_heading', 'Serial Queue & Patient Appointments')

@section('content')
  {{-- Filter & Search Header --}}
  <div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3 p-md-4">
      <form action="{{ route('admin.serials.index') }}" method="GET" class="row g-2 align-items-end">
        <div class="col-md-3">
          <label class="form-label small fw-semibold text-muted">Search Patient / Serial / Phone</label>
          <div class="input-group input-group-sm">
            <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-search"></i></span>
            <input type="text" class="form-control border-start-0" name="search" value="{{ request('search') }}" placeholder="Name, phone or SL-...">
          </div>
        </div>

        <div class="col-md-3">
          <label class="form-label small fw-semibold text-muted">Filter by Chamber</label>
          <select class="form-select form-select-sm" name="chamber_id">
            <option value="">All Chambers</option>
            @foreach($chambers as $ch)
              <option value="{{ $ch->id }}" {{ request('chamber_id') == $ch->id ? 'selected' : '' }}>{{ $ch->name_en }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-2">
          <label class="form-label small fw-semibold text-muted">Status</label>
          <select class="form-select form-select-sm" name="status">
            <option value="">All Statuses</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
          </select>
        </div>

        <div class="col-md-2">
          <label class="form-label small fw-semibold text-muted">Date</label>
          <input type="date" class="form-control form-control-sm" name="date" value="{{ request('date') }}">
        </div>

        <div class="col-md-2 d-flex gap-2">
          <button type="submit" class="btn btn-sm btn-primary w-100 fw-semibold">
            <i class="bi bi-filter"></i> Filter
          </button>
          <a href="{{ route('admin.serials.index') }}" class="btn btn-sm btn-light border" title="Reset Filters">
            <i class="bi bi-arrow-clockwise"></i>
          </a>
        </div>
      </form>
    </div>
  </div>

  {{-- Serials Table --}}
  <div class="admin-table-card">
    <div class="p-3 px-4 border-bottom d-flex align-items-center justify-content-between bg-light">
      <div class="fw-bold fs-6 text-dark brand-font">Patient Queue ({{ $serials->total() }} total entries)</div>
      <a href="{{ route('admin.serials.printDaily', ['date' => request('date', date('Y-m-d')), 'chamber_id' => request('chamber_id')]) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-printer me-1"></i> Print Printable Queue Sheet
      </a>
    </div>

    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light small text-muted text-uppercase">
          <tr>
            <th>Serial No / Date</th>
            <th>Patient Information</th>
            <th>Chamber</th>
            <th>Type / Age</th>
            <th>Reports</th>
            <th>Status</th>
            <th class="text-end">Manage</th>
          </tr>
        </thead>
        <tbody class="small">
          @forelse($serials as $ser)
            <tr>
              <td>
                <span class="fw-bold text-dark fs-6 d-block">{{ $ser->serial_number }}</span>
                <span class="text-muted" style="font-size: 0.76rem;"><i class="bi bi-calendar3 me-1"></i>{{ date('d M, Y', strtotime($ser->preferred_date)) }}</span>
              </td>
              <td>
                <div class="fw-bold text-dark">{{ $ser->patient_name }}</div>
                <div class="text-muted" style="font-size: 0.8rem;">
                  <a href="tel:{{ $ser->patient_phone }}" class="text-decoration-none text-muted"><i class="bi bi-telephone-fill me-1 text-primary"></i>{{ $ser->patient_phone }}</a>
                </div>
              </td>
              <td>
                <span class="badge bg-light text-secondary border">{{ $ser->chamber->name_en ?? $ser->chamber_name }}</span>
              </td>
              <td>
                <span class="badge bg-secondary-subtle text-dark text-capitalize">{{ $ser->visit_type }}</span>
                <div class="text-muted" style="font-size: 0.75rem;">{{ $ser->patient_age ? $ser->patient_age . ' yrs' : '' }} {{ ucfirst($ser->patient_gender) }}</div>
              </td>
              <td>
                @if(!empty($ser->medical_reports) && is_array($ser->medical_reports) && count($ser->medical_reports) > 0)
                  <span class="badge bg-info-subtle text-info fw-semibold"><i class="bi bi-paperclip me-1"></i>{{ count($ser->medical_reports) }} File(s)</span>
                @else
                  <span class="text-muted" style="font-size: 0.75rem;">None</span>
                @endif
              </td>
              <td>
                <form action="{{ route('admin.serials.updateStatus', $ser->id) }}" method="POST" class="d-inline">
                  @csrf
                  <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" style="font-size: 0.78rem; width: 110px; font-weight: 600; {{ $ser->status === 'confirmed' ? 'color: #059669; background-color: #ecfdf5;' : ($ser->status === 'completed' ? 'color: #0284c7; background-color: #f0f9ff;' : ($ser->status === 'cancelled' ? 'color: #dc2626; background-color: #fef2f2;' : 'color: #d97706; background-color: #fffbeb;')) }}">
                    <option value="pending" {{ $ser->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ $ser->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ $ser->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $ser->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                  </select>
                </form>
              </td>
              <td class="text-end">
                <div class="d-inline-flex gap-1">
                  <a href="{{ route('admin.serials.show', $ser->id) }}" class="btn btn-sm btn-outline-primary py-1 px-2" title="View Patient Intake Details">
                    <i class="bi bi-eye"></i>
                  </a>
                  <a href="{{ route('admin.prescriptions.create', ['serial_id' => $ser->id]) }}" class="btn btn-sm btn-outline-success py-1 px-2" title="Write Digital Prescription">
                    <i class="bi bi-prescription2"></i>
                  </a>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center py-5 text-muted">No appointments found matching your filters.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($serials->hasPages())
      <div class="p-3 px-4 border-top">
        {{ $serials->links('pagination::bootstrap-5') }}
      </div>
    @endif
  </div>
@endsection

