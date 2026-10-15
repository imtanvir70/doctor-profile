@extends('layouts.admin')

@section('title', 'Edit SEO: ' . $setting->page_key)
@section('page_heading', 'Edit SEO Settings: ' . strtoupper($setting->page_key))

@section('content')
  <div class="row justify-content-center">
    <div class="col-lg-9">
      <form action="{{ route('admin.seo.update', $setting->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card border-0 shadow-sm rounded-4 mb-4">
          <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h2 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-search text-primary me-2"></i>SEO Parameters for '{{ $setting->page_key }}'</h2>
            <a href="{{ route('admin.seo.index') }}" class="btn btn-sm btn-outline-secondary">
              <i class="bi bi-arrow-left me-1"></i> Back to SEO List
            </a>
          </div>
          <div class="card-body p-4">
            <div class="row g-3">
              {{-- Titles --}}
              <div class="col-12">
                <label for="meta_title_en" class="form-label small fw-semibold">Meta Title (English) <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="meta_title_en" name="meta_title_en" value="{{ old('meta_title_en', $setting->meta_title_en) }}" required>
                <div class="form-text small">Recommended length: 50-65 characters.</div>
              </div>

              <div class="col-12">
                <label for="meta_title_bn" class="form-label small fw-semibold">Meta Title (বাংলা) <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="meta_title_bn" name="meta_title_bn" value="{{ old('meta_title_bn', $setting->meta_title_bn) }}" required>
              </div>

              {{-- Descriptions --}}
              <div class="col-12">
                <label for="meta_description_en" class="form-label small fw-semibold">Meta Description (English) <span class="text-danger">*</span></label>
                <textarea class="form-control" id="meta_description_en" name="meta_description_en" rows="3" required>{{ old('meta_description_en', $setting->meta_description_en) }}</textarea>
                <div class="form-text small">Recommended length: 140-160 characters.</div>
              </div>

              <div class="col-12">
                <label for="meta_description_bn" class="form-label small fw-semibold">Meta Description (বাংলা) <span class="text-danger">*</span></label>
                <textarea class="form-control" id="meta_description_bn" name="meta_description_bn" rows="3" required>{{ old('meta_description_bn', $setting->meta_description_bn) }}</textarea>
              </div>

              {{-- Keywords --}}
              <div class="col-md-6">
                <label for="keywords_en" class="form-label small fw-semibold">Keywords (English, comma-separated)</label>
                <input type="text" class="form-control" id="keywords_en" name="keywords_en" value="{{ old('keywords_en', $setting->keywords_en) }}">
              </div>

              <div class="col-md-6">
                <label for="keywords_bn" class="form-label small fw-semibold">Keywords (বাংলা, কমা দিয়ে আলাদা করুন)</label>
                <input type="text" class="form-control" id="keywords_bn" name="keywords_bn" value="{{ old('keywords_bn', $setting->keywords_bn) }}">
              </div>

              {{-- Canonical, Robots, Schema --}}
              <div class="col-md-4">
                <label for="canonical_url" class="form-label small fw-semibold">Canonical URL</label>
                <input type="url" class="form-control" id="canonical_url" name="canonical_url" value="{{ old('canonical_url', $setting->canonical_url) }}" placeholder="https://...">
              </div>

              <div class="col-md-4">
                <label for="robots" class="form-label small fw-semibold">Robots Meta Directives <span class="text-danger">*</span></label>
                <select class="form-select" id="robots" name="robots" required>
                  <option value="index, follow" {{ old('robots', $setting->robots) == 'index, follow' ? 'selected' : '' }}>index, follow (Standard)</option>
                  <option value="noindex, follow" {{ old('robots', $setting->robots) == 'noindex, follow' ? 'selected' : '' }}>noindex, follow</option>
                  <option value="index, nofollow" {{ old('robots', $setting->robots) == 'index, nofollow' ? 'selected' : '' }}>index, nofollow</option>
                  <option value="noindex, nofollow" {{ old('robots', $setting->robots) == 'noindex, nofollow' ? 'selected' : '' }}>noindex, nofollow</option>
                </select>
              </div>

              <div class="col-md-4">
                <label for="schema_type" class="form-label small fw-semibold">Google Schema.org Type <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="schema_type" name="schema_type" value="{{ old('schema_type', $setting->schema_type) }}" required>
              </div>

              {{-- OpenGraph Image --}}
              <div class="col-12 pt-2 border-top">
                <label for="og_image_file" class="form-label small fw-semibold">OpenGraph Social Share Banner Image (1200x630)</label>
                @if(!empty($setting->og_image))
                  <div class="mb-2">
                    <img src="{{ $setting->og_image }}" alt="Current Banner" style="max-height: 120px; border-radius: 8px; border: 1px solid #e2e8f0;">
                  </div>
                @endif
                <input type="file" class="form-control" id="og_image_file" name="og_image_file" accept="image/*">
                <div class="form-text small">Recommended 1200x630 pixels JPG or PNG for high quality Facebook, Twitter, and WhatsApp link previews.</div>
              </div>
            </div>
          </div>
          <div class="card-footer bg-light py-3 d-flex align-items-center justify-content-end gap-2">
            <a href="{{ route('admin.seo.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-success px-4 fw-bold">
              <i class="bi bi-check2-circle me-1"></i> Save SEO Settings
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

