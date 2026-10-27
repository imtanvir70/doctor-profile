@extends('layouts.admin')

@section('title', 'Blog Posts & Articles')
@section('page_heading', 'Blog Posts & Health Articles')

@section('content')
  <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4">
    <div>
      <h2 class="fs-5 fw-bold mb-1 text-dark brand-font d-flex align-items-center gap-2">
        <i class="bi bi-pencil-square text-primary"></i>
        <span>Blog Posts & Clinical Articles</span>
      </h2>
      <p class="text-muted small mb-0">Manage doctor's health blog posts, clinical awareness columns, and medical insights</p>
    </div>
    <div class="d-flex align-items-center gap-2">
      <a href="{{ route('admin.articles.create') }}" class="btn btn-success fw-bold px-3 py-2 shadow-sm d-inline-flex align-items-center gap-2">
        <i class="bi bi-plus-circle-fill"></i>
        <span>Write New Blog Post</span>
      </a>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4 rounded-3 d-flex align-items-center gap-2" role="alert">
      <i class="bi bi-check-circle-fill text-success fs-5"></i>
      <div>{{ session('success') }}</div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="admin-table-card">
    <div class="p-3 px-4 border-bottom bg-light d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
      <div class="d-flex flex-wrap align-items-center gap-2">
        <span class="badge bg-white text-dark border px-3 py-2 rounded-pill fw-semibold">
          Total Posts: {{ $articles->count() }}
        </span>
        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-semibold">
          Published: {{ $articles->where('is_published', true)->count() }}
        </span>
        <span class="badge bg-secondary-subtle text-secondary border px-3 py-2 rounded-pill fw-semibold">
          Drafts: {{ $articles->where('is_published', false)->count() }}
        </span>
      </div>
      <a href="{{ route('blog') }}" target="_blank" class="small text-primary fw-semibold text-decoration-none">
        <i class="bi bi-box-arrow-up-right me-1"></i> View Live Blog
      </a>
    </div>

    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0 table-to-card">
        <thead class="table-light small text-muted text-uppercase">
          <tr>
            <th style="width: 70px;">Thumbnail</th>
            <th>Blog Post Title</th>
            <th>Category</th>
            <th>Featured</th>
            <th>Status</th>
            <th>Last Updated</th>
            <th class="text-end" style="width: 120px;">Actions</th>
          </tr>
        </thead>
        <tbody class="small">
          @forelse($articles as $art)
            <tr>
              <td data-label="Thumbnail">
                <img src="{{ $art->featured_image ?? 'https://images.unsplash.com/photo-1505751172876-fa1923c5c528?auto=format&fit=crop&w=800&q=80' }}" alt="Blog" style="width: 52px; height: 40px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0;">
              </td>
              <td data-label="Blog Post Title" style="max-width: 340px;">
                <div class="fw-bold text-dark text-truncate" title="{{ $art->title_en ?: $art->title_bn }}">
                  {{ $art->title_en ?: ($art->title_bn ?: 'Untitled Draft') }}
                </div>
                @if($art->title_bn && $art->title_en && $art->title_bn !== $art->title_en)
                  <div class="text-muted text-truncate" style="font-size: 0.78rem;">{{ $art->title_bn }}</div>
                @endif
              </td>
              <td data-label="Category">
                <span class="badge bg-light text-primary border">{{ $art->category ?? 'General' }}</span>
              </td>
              <td data-label="Featured">
                @if($art->is_featured)
                  <span class="badge bg-warning-subtle text-warning-emphasis fw-bold"><i class="bi bi-star-fill me-1"></i>Featured Lead</span>
                @else
                  <span class="text-muted" style="font-size: 0.8rem;">Standard</span>
                @endif
              </td>
              <td data-label="Status">
                @if($art->is_published)
                  <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill fw-semibold">
                    <i class="bi bi-check-circle-fill me-1"></i> Published
                  </span>
                @else
                  <span class="badge bg-warning-subtle text-warning-emphasis px-2 py-1 rounded-pill fw-semibold">
                    <i class="bi bi-clock-history me-1"></i> Draft
                  </span>
                @endif
              </td>
              <td data-label="Last Updated" class="text-muted" style="font-size: 0.78rem;">
                {{ $art->updated_at ? $art->updated_at->format('d M, Y h:i A') : date('d M, Y', strtotime($art->created_at)) }}
              </td>
              <td data-label="Actions" class="text-end">
                <div class="d-inline-flex gap-1">
                  <a href="{{ route('admin.articles.edit', $art->id) }}" class="btn btn-sm btn-outline-primary py-1 px-2" title="Edit Blog Post">
                    <i class="bi bi-pencil-square"></i> Edit
                  </a>
                  <form action="{{ route('admin.articles.destroy', $art->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this blog post?');">
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
              <td colspan="7" class="text-center py-5 text-muted">
                <i class="bi bi-journal-x display-6 text-secondary mb-3 d-block"></i>
                <h6 class="fw-bold text-dark">No blog posts found</h6>
                <p class="small text-muted mb-3">Start writing health articles and clinical guides for your patients.</p>
                <a href="{{ route('admin.articles.create') }}" class="btn btn-sm btn-success fw-bold px-3 py-2">
                  <i class="bi bi-pencil-square me-1"></i> Write Your First Blog Post
                </a>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
