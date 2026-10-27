@extends('layouts.admin')

@section('title', 'SEO Management Suite')
@section('page_heading', 'SEO & OpenGraph Control Center')

@section('content')
  <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #059669 0%, #047857 100%); color: #ffffff;">
    <div class="card-body p-4">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <h2 class="fs-4 fw-bold mb-1 brand-font text-white"><i class="bi bi-search me-2"></i>Full Dynamic SEO Management</h2>
          <p class="small text-slate-200 mb-0" style="color: #d1fae5;">Control Meta Titles, Meta Descriptions (Bilingual Bangla & English), OpenGraph Social Banners, Canonical URLs, Robots directives, and Google Schema.org structured data on a per-page level.</p>
        </div>
        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
          <a href="{{ route('sitemap') }}" target="_blank" class="btn btn-light fw-bold btn-sm">
            <i class="bi bi-diagram-2-fill me-1"></i> View Dynamic sitemap.xml
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
            <th>Page Key / Route</th>
            <th>Meta Title (EN / BN)</th>
            <th>Meta Description Preview</th>
            <th>Robots / Schema</th>
            <th>OG Banner</th>
            <th class="text-end">Action</th>
          </tr>
        </thead>
        <tbody class="small">
          @foreach($settings as $s)
            <tr>
              <td data-label="Page Key">
                <span class="badge bg-primary-subtle text-primary fw-bold text-uppercase">{{ $s->page_key }}</span>
                <div class="text-muted" style="font-size: 0.75rem;">/{{ $s->page_key === 'home' || $s->page_key === 'global' ? '' : $s->page_key }}</div>
              </td>
              <td data-label="Meta Title">
                <div class="fw-semibold text-dark">{{ $s->meta_title_en }}</div>
                <div class="text-muted" style="font-size: 0.8rem;">{{ $s->meta_title_bn }}</div>
              </td>
              <td data-label="Description Preview" style="max-width: 320px;">
                <div class="text-truncate text-muted" title="{{ $s->meta_description_en }}">{{ $s->meta_description_en }}</div>
              </td>
              <td data-label="Robots / Schema">
                <span class="badge bg-light text-dark border">{{ $s->robots }}</span>
                <div class="text-muted" style="font-size: 0.75rem;">Type: {{ $s->schema_type }}</div>
              </td>
              <td data-label="OG Banner">
                @if(!empty($s->og_image))
                  <img src="{{ $s->og_image }}" alt="OG Banner" style="width: 48px; height: 32px; object-fit: cover; border-radius: 6px; border: 1px solid #e2e8f0;">
                @else
                  <span class="text-muted small">None</span>
                @endif
              </td>
              <td data-label="Action" class="text-end">
                <a href="{{ route('admin.seo.edit', $s->id) }}" class="btn btn-sm btn-outline-primary px-3">
                  <i class="bi bi-pencil-square me-1"></i> Edit SEO
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection

