@extends('layouts.admin')

@section('title', $article->exists ? 'Edit Article: ' . $article->title_en : 'Create New Health Article')
@section('page_heading', $article->exists ? 'Edit Health Article' : 'Write New Health Article')

@section('content')
  <div class="row justify-content-center">
    <div class="col-lg-9">
      <form action="{{ $article->exists ? route('admin.articles.update', $article->id) : route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($article->exists)
          @method('PUT')
        @endif

        <div class="card border-0 shadow-sm rounded-4 mb-4">
          <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h2 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-journal-text text-primary me-2"></i>Article Information</h2>
            <a href="{{ route('admin.articles.index') }}" class="btn btn-sm btn-outline-secondary">
              <i class="bi bi-arrow-left me-1"></i> Back to Articles
            </a>
          </div>
          <div class="card-body p-4">
            <div class="row g-3">
              <div class="col-12">
                <label class="form-label small fw-semibold">Article Title (English) <span class="text-danger">*</span></label>
                <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $article->title_en) }}" required>
              </div>

              <div class="col-12">
                <label class="form-label small fw-semibold">Article Title (বাংলা) <span class="text-danger">*</span></label>
                <input type="text" name="title_bn" class="form-control" value="{{ old('title_bn', $article->title_bn) }}" required>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold">Category <span class="text-danger">*</span></label>
                <select name="category" class="form-select" required>
                  <option value="Preventive Health" {{ old('category', $article->category) == 'Preventive Health' ? 'selected' : '' }}>Preventive Health / Lifestyle</option>
                  <option value="Infectious Diseases" {{ old('category', $article->category) == 'Infectious Diseases' ? 'selected' : '' }}>Infectious Diseases / Fever</option>
                  <option value="Endocrine & Thyroid" {{ old('category', $article->category) == 'Endocrine & Thyroid' ? 'selected' : '' }}>Endocrine & Thyroid</option>
                  <option value="Cardiovascular" {{ old('category', $article->category) == 'Cardiovascular' ? 'selected' : '' }}>Cardiovascular & BP</option>
                  <option value="Gastro & Liver" {{ old('category', $article->category) == 'Gastro & Liver' ? 'selected' : '' }}>Gastro & Liver</option>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold">Read Time (e.g. 5 min read)</label>
                <input type="text" name="read_time" class="form-control" value="{{ old('read_time', $article->read_time_minutes ? $article->read_time_minutes . ' min read' : '5 min read') }}">
              </div>

              <div class="col-12">
                <label class="form-label small fw-semibold">Short Excerpt (English) <span class="text-danger">*</span></label>
                <textarea name="excerpt_en" class="form-control" rows="2" required>{{ old('excerpt_en', $article->excerpt_en) }}</textarea>
              </div>

              <div class="col-12">
                <label class="form-label small fw-semibold">Short Excerpt (বাংলা) <span class="text-danger">*</span></label>
                <textarea name="excerpt_bn" class="form-control" rows="2" required>{{ old('excerpt_bn', $article->excerpt_bn) }}</textarea>
              </div>

              <div class="col-12">
                <label class="form-label small fw-semibold">Full Article Content (English) <span class="text-danger">*</span></label>
                <textarea name="content_en" class="form-control" rows="6" required>{{ old('content_en', $article->content_en ?? $article->excerpt_en) }}</textarea>
              </div>

              <div class="col-12">
                <label class="form-label small fw-semibold">Full Article Content (বাংলা) <span class="text-danger">*</span></label>
                <textarea name="content_bn" class="form-control" rows="6" required>{{ old('content_bn', $article->content_bn ?? $article->excerpt_bn) }}</textarea>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold">Featured Thumbnail Image</label>
                @if(!empty($article->featured_image))
                  <div class="mb-2">
                    <img src="{{ $article->featured_image }}" alt="Thumbnail" style="height: 80px; border-radius: 8px; border: 1px solid #e2e8f0;">
                  </div>
                @endif
                <input type="file" name="featured_image_file" class="form-control" accept="image/*">
              </div>

              <div class="col-md-6 pt-md-4">
                <div class="form-check form-switch mb-2">
                  <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $article->is_featured) ? 'checked' : '' }}>
                  <label class="form-check-label fw-semibold small" for="is_featured">Set as Lead Featured Column</label>
                </div>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published', $article->is_published ?? true) ? 'checked' : '' }}>
                  <label class="form-check-label fw-semibold small" for="is_published">Publish Online Live</label>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer bg-light py-3 d-flex align-items-center justify-content-end gap-2">
            <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-success px-4 fw-bold">
              <i class="bi bi-check2-circle me-1"></i> Save Article
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

