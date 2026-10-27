@extends('layouts.admin')

@section('title', 'Chambers & Visiting Schedules')
@section('page_heading', 'Chamber Locations & Timings')

@section('content')
  <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4">
    <div>
      <h2 class="fs-5 fw-bold mb-0 text-dark brand-font">Chambers List</h2>
      <p class="text-muted small mb-0">Manage doctor visiting locations, hours, and serial booking hotlines</p>
    </div>
    <a href="{{ route('admin.chambers.create') }}" class="btn btn-success fw-bold px-3 py-2 shadow-sm w-100 w-sm-auto text-center d-inline-flex align-items-center justify-content-center gap-1.5">
      <i class="bi bi-plus-circle-fill"></i>
      <span>Add New Chamber</span>
    </a>
  </div>

  <div class="admin-table-card">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0 table-to-card">
        <thead class="table-light small text-muted text-uppercase">
          <tr>
            <th>Chamber Name (EN / BN)</th>
            <th>Address</th>
            <th>Visiting Days & Hours</th>
            <th>Hotline</th>
            <th>Consultation Fee</th>
            <th>Status</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody class="small">
          @foreach($chambers as $ch)
            <tr>
              <td data-label="Chamber Name">
                <div class="fw-bold text-dark">{{ $ch->name_en }}</div>
                <div class="text-muted" style="font-size: 0.8rem;">{{ $ch->name_bn }}</div>
              </td>
              <td data-label="Address" style="max-width: 250px;">
                <div class="text-truncate text-muted">{{ $ch->address_en }}</div>
              </td>
              <td data-label="Visiting Hours">
                <div class="fw-semibold text-dark">{{ $ch->visiting_days_en }}</div>
                <div class="text-primary" style="font-size: 0.8rem;">{{ $ch->visiting_hours_en }}</div>
              </td>
              <td data-label="Hotline">
                <div class="fw-bold text-dark"><i class="bi bi-telephone-fill me-1 text-primary"></i>{{ $ch->phone1 }}</div>
              </td>
              <td data-label="Consultation Fee">
                <span class="badge bg-light text-primary border fw-bold">{{ $ch->consultation_fee ?? $ch->fee }}</span>
              </td>
              <td data-label="Status">
                @if($ch->is_active)
                  <span class="badge bg-success-subtle text-success">Active</span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary">Inactive</span>
                @endif
              </td>
              <td data-label="Actions" class="text-end">
                <div class="d-inline-flex gap-1">
                  <a href="{{ route('admin.chambers.edit', $ch->id) }}" class="btn btn-sm btn-outline-primary py-1 px-2" title="Edit">
                    <i class="bi bi-pencil-square"></i> Edit
                  </a>
                  <form action="{{ route('admin.chambers.destroy', $ch->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this chamber?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" title="Delete">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection

