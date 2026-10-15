@extends('layouts.admin')

@section('title', 'Clinical Specialties & Services')
@section('page_heading', 'Clinical Specialties & Specialized Domains')

@section('content')
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <p class="text-muted small mb-0">Manage doctor's specialized clinical domains, disease treatments, and patient care protocols displayed across the homepage and expertise sections.</p>
    </div>
    <a href="{{ route('admin.specialties.create') }}" class="btn btn-sm btn-success d-flex align-items-center gap-2 shadow-sm px-3 py-2">
      <i class="bi bi-plus-circle-fill"></i>
      <span>Add New Specialty</span>
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
      <i class="bi bi-check-circle-fill"></i>
      <div>{{ session('success') }}</div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="admin-table-card">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="bg-light">
          <tr>
            <th style="width: 50px;">Order</th>
            <th>Specialty Title</th>
            <th>Domain / Badge</th>
            <th>Clinical Approach Summary</th>
            <th>Status</th>
            <th class="text-end" style="width: 140px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($specialties as $sp)
            <tr>
              <td class="fw-bold text-muted text-center">#{{ $sp->display_order }}</td>
              <td>
                <div class="d-flex align-items-center gap-3">
                  <div class="stat-icon-box bg-primary-subtle text-primary" style="width: 40px; height: 40px; font-size: 1.1rem; flex-shrink: 0;">
                    <i class="bi {{ $sp->icon_class ?? 'bi-heart-pulse-fill' }}"></i>
                  </div>
                  <div>
                    <div class="fw-bold text-dark fs-6">{{ $sp->title_en }}</div>
                    <div class="text-muted small">{{ $sp->title_bn }}</div>
                  </div>
                </div>
              </td>
              <td>
                <span class="badge bg-light text-primary border px-2 py-1">{{ $sp->badge_en ?? 'Clinical Domain' }}</span>
                <div class="text-muted small mt-1">{{ $sp->badge_bn ?? 'বিশেষায়িত ক্ষেত্র' }}</div>
              </td>
              <td>
                <div class="small text-muted" style="max-width: 320px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                  {{ $sp->description_en }}
                </div>
              </td>
              <td>
                @if($sp->is_active)
                  <span class="badge bg-success-subtle text-success px-2 py-1"><i class="bi bi-check-circle-fill me-1"></i>Active</span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary px-2 py-1">Disabled</span>
                @endif
              </td>
              <td class="text-end">
                <div class="d-flex align-items-center justify-content-end gap-2">
                  <a href="{{ route('admin.specialties.edit', $sp->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Specialty">
                    <i class="bi bi-pencil-square"></i>
                  </a>
                  <form action="{{ route('admin.specialties.destroy', $sp->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this specialty?');" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Specialty">
                      <i class="bi bi-trash-fill"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                No specialties created yet. Click "Add New Specialty" to create one.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection

