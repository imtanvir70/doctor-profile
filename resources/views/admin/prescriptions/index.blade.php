@extends('layouts.admin')

@section('title', 'Digital Prescriptions')
@section('page_heading', 'Digital Prescriptions & EMR Records')

@section('content')
  <div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3 p-md-4">
      <div class="row g-3 align-items-center justify-content-between">
        <div class="col-md-6">
          <form action="{{ route('admin.prescriptions.index') }}" method="GET" class="d-flex gap-2">
            <div class="input-group">
              <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-search"></i></span>
              <input type="text" class="form-control border-start-0" name="search" value="{{ request('search') }}" placeholder="Search by RX-No, Patient name, phone, diagnosis...">
            </div>
            <button type="submit" class="btn btn-primary px-3 fw-semibold">Search</button>
            @if(request('search'))
              <a href="{{ route('admin.prescriptions.index') }}" class="btn btn-light border"><i class="bi bi-x"></i></a>
            @endif
          </form>
        </div>

        <div class="col-md-4 text-md-end">
          <a href="{{ route('admin.prescriptions.create') }}" class="btn btn-success fw-bold px-3 py-2 shadow-sm">
            <i class="bi bi-plus-circle-fill me-1"></i> Write New Prescription
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="admin-table-card">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
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
              <td>
                <span class="fw-bold text-dark fs-6 d-block">{{ $rx->prescription_no }}</span>
                <span class="text-muted" style="font-size: 0.76rem;"><i class="bi bi-calendar-event me-1"></i>{{ date('d M, Y', strtotime($rx->consultation_date)) }}</span>
              </td>
              <td>
                <div class="fw-bold text-dark">{{ $rx->patient_name }}</div>
                <div class="text-muted" style="font-size: 0.8rem;">{{ $rx->patient_age }}y • {{ ucfirst($rx->patient_gender) }} • <i class="bi bi-telephone text-primary"></i> {{ $rx->patient_phone }}</div>
              </td>
              <td>
                @if($rx->bp_systolic && $rx->bp_diastolic)
                  <span class="badge bg-light text-primary border me-1">BP: {{ $rx->bp_systolic }}/{{ $rx->bp_diastolic }}</span>
                @endif
                @if($rx->blood_sugar)
                  <span class="badge bg-light text-success border">RBS: {{ $rx->blood_sugar }}</span>
                @endif
              </td>
              <td style="max-width: 250px;">
                <div class="fw-semibold text-dark text-truncate">{{ $rx->diagnosis ?? 'General Medicine Review' }}</div>
                <div class="text-muted" style="font-size: 0.75rem;">{{ is_array($rx->medicines) ? count($rx->medicines) . ' medicine(s) prescribed' : '' }}</div>
              </td>
              <td>
                <span class="badge bg-light text-secondary border">{{ $rx->chamber->name_en ?? 'Dhanmondi' }}</span>
              </td>
              <td class="text-end">
                <div class="d-inline-flex gap-1">
                  <a href="{{ route('admin.prescriptions.show', $rx->id) }}" class="btn btn-sm btn-outline-primary py-1 px-2" title="View Prescription">
                    <i class="bi bi-eye"></i>
                  </a>
                  <a href="{{ route('admin.prescriptions.edit', $rx->id) }}" class="btn btn-sm btn-outline-warning text-dark py-1 px-2" title="Edit Prescription">
                    <i class="bi bi-pencil-square"></i>
                  </a>
                  <a href="{{ route('admin.prescriptions.print', $rx->id) }}" target="_blank" class="btn btn-sm btn-outline-success py-1 px-2" title="Print Official Prescription (A4)">
                    <i class="bi bi-printer"></i>
                  </a>
                  <form action="{{ route('admin.prescriptions.destroy', $rx->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this prescription?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" title="Delete">
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

