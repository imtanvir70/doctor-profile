@extends('layouts.admin')

@section('title', 'Digital Prescriptions')
@section('page_heading', 'Digital Prescriptions & EMR Records')

@section('content')
  <div class="card border-0 shadow-sm rounded-4 mb-3">
    <div class="card-body p-3">
      <div class="row g-2 align-items-center justify-content-between">
        <div class="col-12 col-md-7">
          <form action="{{ route('admin.prescriptions.index') }}" method="GET" class="d-flex gap-2">
            <div class="input-group input-group-sm">
              <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-search"></i></span>
              <input type="text" class="form-control border-start-0" name="search" value="{{ request('search') }}" placeholder="Search RX-No, Name, phone...">
            </div>
            <button type="submit" class="btn btn-primary btn-sm px-3 fw-semibold">Search</button>
            @if(request('search'))
              <a href="{{ route('admin.prescriptions.index') }}" class="btn btn-light btn-sm border"><i class="bi bi-x"></i></a>
            @endif
          </form>
        </div>

        <div class="col-12 col-md-5 text-md-end">
          <a href="{{ route('admin.prescriptions.create') }}" class="btn btn-success btn-sm fw-bold px-3 py-1.5 shadow-sm w-100 w-md-auto d-inline-flex align-items-center justify-content-center gap-1.5">
            <i class="bi bi-plus-circle-fill"></i>
            <span>Write New Prescription</span>
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="admin-table-card">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0 table-to-card">
        <thead class="table-light small text-muted text-uppercase">
          <tr>
            <th>Prescription ID / Date</th>
            <th>Patient Details</th>
            <th>Vitals Summary</th>
            <th>Clinical Diagnosis</th>
            <th>Chamber</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody class="small">
          @forelse($prescriptions as $rx)
            <tr>
              <td data-label="Prescription ID / Date">
                <span class="fw-bold text-dark fs-6 d-block">{{ $rx->prescription_no }}</span>
                <span class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-calendar-event me-1"></i>{{ date('d M, Y', strtotime($rx->consultation_date)) }}</span>
              </td>
              <td data-label="Patient Details">
                <div class="fw-bold text-dark">{{ $rx->patient_name }}</div>
                <div class="text-muted" style="font-size: 0.8rem;">{{ $rx->patient_age }}y • {{ ucfirst($rx->patient_gender) }} • <i class="bi bi-telephone text-primary"></i> {{ $rx->patient_phone }}</div>
              </td>
              <td data-label="Vitals Summary">
                @if($rx->bp_systolic && $rx->bp_diastolic)
                  <span class="badge bg-light text-primary border px-2 py-1 small me-1">BP: {{ $rx->bp_systolic }}/{{ $rx->bp_diastolic }}</span>
                @endif
                @if($rx->blood_sugar)
                  <span class="badge bg-light text-success border px-2 py-1 small">RBS: {{ $rx->blood_sugar }}</span>
                @endif
                @if(!$rx->bp_systolic && !$rx->blood_sugar)
                  <span class="text-muted small">-</span>
                @endif
              </td>
              <td data-label="Clinical Diagnosis" style="max-width: 250px;">
                <div class="fw-semibold text-dark text-truncate">{{ $rx->diagnosis ?? 'General Medicine Review' }}</div>
                <div class="text-muted" style="font-size: 0.75rem;">{{ is_array($rx->medicines) ? count($rx->medicines) . ' medicine(s) prescribed' : '' }}</div>
              </td>
              <td data-label="Chamber">
                <span class="badge bg-light text-secondary border px-2 py-1 small">{{ $rx->chamber->name_en ?? 'Dhanmondi' }}</span>
              </td>
              <td data-label="Actions" class="text-end">
                <div class="d-flex flex-wrap gap-2 align-items-center justify-content-end">
                  <a href="{{ route('admin.prescriptions.show', $rx->id) }}" class="btn btn-sm btn-outline-primary py-1 px-2 d-inline-flex align-items-center gap-1" title="View Prescription">
                    <i class="bi bi-eye"></i><span>View</span>
                  </a>
                  <a href="{{ route('admin.prescriptions.edit', $rx->id) }}" class="btn btn-sm btn-outline-warning text-dark py-1 px-2 d-inline-flex align-items-center gap-1" title="Edit Prescription">
                    <i class="bi bi-pencil-square"></i><span>Edit</span>
                  </a>
                  <a href="{{ route('admin.prescriptions.print', $rx->id) }}" target="_blank" class="btn btn-sm btn-outline-success py-1 px-2 d-inline-flex align-items-center gap-1" title="Print Official Prescription (A4)">
                    <i class="bi bi-printer"></i><span>Print</span>
                  </a>
                  <form action="{{ route('admin.prescriptions.destroy', $rx->id) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Delete this prescription?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2 d-inline-flex align-items-center justify-content-center" title="Delete" style="min-height: 31px;">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center py-5 text-muted">No prescriptions created yet. Click "Write New Prescription" to begin.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($prescriptions->hasPages())
      <div class="p-3 px-4 border-top">
        {{ $prescriptions->links('pagination::bootstrap-5') }}
      </div>
    @endif
  </div>
@endsection
