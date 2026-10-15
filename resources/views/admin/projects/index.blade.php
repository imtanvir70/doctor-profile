@extends('layouts.admin')

@section('title', 'International Projects & Global Research')
@section('page_heading', 'International Projects & Global Collaborations')

@section('content')
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <p class="text-muted small mb-0">Manage doctor's international clinical trials, global research partnerships, and multi-country health initiatives.</p>
    </div>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-sm btn-success d-flex align-items-center gap-2 shadow-sm px-3 py-2">
      <i class="bi bi-plus-circle-fill"></i>
      <span>Add New Project</span>
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
            <th>Project Title & Collaboration</th>
            <th>Role & Duration</th>
            <th>Category & Badge</th>
            <th>Status</th>
            <th class="text-end" style="width: 140px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($projects as $proj)
            <tr>
              <td class="fw-bold text-muted text-center">#{{ $proj->display_order }}</td>
              <td>
                <div class="d-flex align-items-start gap-2">
                  <div class="stat-icon-box bg-primary-subtle text-primary mt-1" style="width: 38px; height: 38px; font-size: 1rem; flex-shrink: 0;">
                    <i class="bi {{ $proj->icon ?? 'bi-globe-americas' }}"></i>
                  </div>
                  <div>
                    <div class="fw-bold text-dark fs-6">{{ $proj->title_en }}</div>
                    <div class="text-muted small">{{ $proj->title_bn }}</div>
                    <div class="mt-1 small">
                      <span class="text-primary fw-semibold"><i class="bi bi-building me-1"></i>{{ $proj->organization }}</span>
                      @if($proj->country_or_location)
                        <span class="text-muted ms-2"><i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $proj->country_or_location }}</span>
                      @endif
                    </div>
                  </div>
                </div>
              </td>
              <td>
                <div class="fw-semibold text-dark small">{{ $proj->role_en }}</div>
                <div class="text-muted" style="font-size: 0.75rem;">{{ $proj->role_bn }}</div>
                @if($proj->duration)
                  <span class="badge bg-light text-dark border mt-1"><i class="bi bi-calendar-event me-1 text-primary"></i>{{ $proj->duration }}</span>
                @endif
              </td>
              <td>
                <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle mb-1 d-inline-block">{{ $proj->category }}</span>
                @if($proj->badge_text)
                  <div><span class="badge bg-success-subtle text-success-emphasis border border-success-subtle">{{ $proj->badge_text }}</span></div>
                @endif
              </td>
              <td>
                @if($proj->is_active)
                  <span class="badge bg-success-subtle text-success border border-success-subtle"><i class="bi bi-check-circle me-1"></i>Active</span>
                @else
                  <span class="badge bg-secondary-subtle text-muted border"><i class="bi bi-eye-slash me-1"></i>Hidden</span>
                @endif
                @if($proj->is_featured)
                  <div class="mt-1"><span class="badge bg-warning-subtle text-warning-emphasis"><i class="bi bi-star-fill me-1"></i>Featured</span></div>
                @endif
              </td>
              <td class="text-end">
                <div class="d-flex align-items-center justify-content-end gap-1">
                  <a href="{{ route('admin.projects.edit', $proj->id) }}" class="btn btn-sm btn-outline-primary py-1 px-2" title="Edit Project">
                    <i class="bi bi-pencil-square"></i>
                  </a>
                  <form action="{{ route('admin.projects.destroy', $proj->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this international project?');" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" title="Delete Project">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center py-5 text-muted">
                <i class="bi bi-globe-americas fs-1 d-block mb-2 text-secondary"></i>
                <div>No international projects added yet.</div>
                <a href="{{ route('admin.projects.create') }}" class="btn btn-sm btn-primary mt-2">Add First Project</a>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection

