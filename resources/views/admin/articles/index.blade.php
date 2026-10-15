@extends('layouts.admin')

@section('title', 'Health Articles')
@section('page_heading', 'Health Articles & Medical Columns')

@section('content')
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h2 class="fs-5 fw-bold mb-0 text-dark brand-font">Articles & Medical Writings</h2>
      <p class="text-muted small mb-0">Manage doctor's health awareness columns and clinical educational posts</p>
    </div>
    <a href="{{ route('admin.articles.create') }}" class="btn btn-success fw-bold px-3 py-2 shadow-sm">
      <i class="bi bi-plus-circle-fill me-1"></i> Write New Article
    </a>
  </div>

  <div class="admin-table-card">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light small text-muted text-uppercase">
          <tr>
            <th>Image</th>
            <th>Title (EN / BN)</th>
            <th>Category</th>
            <th>Featured</th>
            <th>Status</th>
            <th>Date</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody class="small">
          @foreach($articles as $art)
            <tr>
              <td>
                <img src="{{ $art->featured_image ?? 'https://images.unsplash.com/photo-1505751172876-fa1923c5c528?auto=format&fit=crop&w=800&q=80' }}" alt="Article" style="width: 50px; height: 38px; object-fit: cover; border-radius: 6px; border: 1px solid #e2e8f0;">
              </td>
              <td style="max-width: 320px;">
                <div class="fw-bold text-dark text-truncate">{{ $art->title_en }}</div>
                <div class="text-muted text-truncate" style="font-size: 0.8rem;">{{ $art->title_bn }}</div>
              </td>
              <td>
                <span class="badge bg-light text-primary border">{{ $art->category }}</span>
              </td>
              <td>
                @if($art->is_featured)
                  <span class="badge bg-warning-subtle text-warning fw-bold"><i class="bi bi-star-fill me-1"></i>Featured Lead</span>
                @else
                  <span class="text-muted">Standard</span>
                @endif
              </td>
              <td>
                @if($art->is_published)
                  <span class="badge bg-success-subtle text-success">Published</span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary">Draft</span>
                @endif
              </td>
              <td class="text-muted" style="font-size: 0.78rem;">
                {{ date('d M, Y', strtotime($art->published_at ?? $art->created_at)) }}
              </td>
              <td class="text-end">
                <div class="d-inline-flex gap-1">
                  <a href="{{ route('admin.articles.edit', $art->id) }}" class="btn btn-sm btn-outline-primary py-1 px-2" title="Edit">
                    <i class="bi bi-pencil-square"></i>
                  </a>
                  <form action="{{ route('admin.articles.destroy', $art->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this article?');">
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

