@extends('layouts.admin')

@section('title', $specialty->exists ? 'Edit Specialty' : 'Add New Specialty')
@section('page_heading', $specialty->exists ? 'Edit Clinical Specialty' : 'Add New Clinical Specialty')

@section('content')
  <div class="mb-4">
    <a href="{{ route('admin.specialties.index') }}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1">
      <i class="bi bi-arrow-left"></i> Back to Specialties List
    </a>
  </div>

  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white py-3 border-bottom">
      <h2 class="fs-6 fw-bold mb-0 text-dark brand-font">
        <i class="bi {{ $specialty->exists ? 'bi-pencil-square' : 'bi-plus-circle' }} text-primary me-2"></i>
        {{ $specialty->exists ? 'Update Clinical Specialty Information' : 'New Clinical Specialty Form' }}
      </h2>
    </div>
    <div class="card-body p-4">
      <form action="{{ $specialty->exists ? route('admin.specialties.update', $specialty->id) : route('admin.specialties.store') }}" method="POST">
        @csrf
        @if($specialty->exists)
          @method('PUT')
        @endif

        <div class="row g-4">
          {{-- Title & Domain --}}
          <div class="col-md-6">
            <label for="title_en" class="form-label small fw-semibold">Specialty Title (English) <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="title_en" name="title_en" value="{{ old('title_en', $specialty->title_en) }}" required placeholder="e.g. Type-2 Diabetes & Metabolic Care">
          </div>

          <div class="col-md-6">
            <label for="title_bn" class="form-label small fw-semibold">Specialty Title (বাংলা) <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="title_bn" name="title_bn" value="{{ old('title_bn', $specialty->title_bn) }}" required placeholder="যেমন: ডায়াবেটিস ও মেটাবলিক সিন্ড্রোম">
          </div>

          <div class="col-md-6">
            <label for="badge_en" class="form-label small fw-semibold">Category / Badge (English)</label>
            <input type="text" class="form-control" id="badge_en" name="badge_en" value="{{ old('badge_en', $specialty->badge_en ?? 'Clinical Discipline') }}" placeholder="e.g. Endocrinology & Metabolism">
          </div>

          <div class="col-md-6">
            <label for="badge_bn" class="form-label small fw-semibold">Category / Badge (বাংলা)</label>
            <input type="text" class="form-control" id="badge_bn" name="badge_bn" value="{{ old('badge_bn', $specialty->badge_bn ?? 'বিশেষায়িত ক্ষেত্র') }}" placeholder="যেমন: এন্ডোক্রাইন ও মেটাবলিজম">
          </div>

          {{-- Descriptions --}}
          <div class="col-md-6">
            <label for="description_en" class="form-label small fw-semibold">Specialty Description (English) <span class="text-danger">*</span></label>
            <textarea class="form-control" id="description_en" name="description_en" rows="4" required placeholder="Evidence-based management protocols for glycemic stabilization...">{{ old('description_en', $specialty->description_en) }}</textarea>
          </div>

          <div class="col-md-6">
            <label for="description_bn" class="form-label small fw-semibold">Specialty Description (বাংলা) <span class="text-danger">*</span></label>
            <textarea class="form-control" id="description_bn" name="description_bn" rows="4" required placeholder="আন্তর্জাতিক গাইডলাইন অনুসারে দীর্ঘমেয়াদী সুগার নিয়ন্ত্রণ ও অঙ্গ সুরক্ষা...">{{ old('description_bn', $specialty->description_bn) }}</textarea>
          </div>

          {{-- Doctor's Approach --}}
          <div class="col-md-6">
            <label for="approach_en" class="form-label small fw-semibold">Doctor's Clinical Approach (English)</label>
            <textarea class="form-control" id="approach_en" name="approach_en" rows="3" placeholder="e.g. Prioritizes organ-protective therapy alongside diet...">{{ old('approach_en', $specialty->approach_en) }}</textarea>
          </div>

          <div class="col-md-6">
            <label for="approach_bn" class="form-label small fw-semibold">Doctor's Clinical Approach (বাংলা)</label>
            <textarea class="form-control" id="approach_bn" name="approach_bn" rows="3" placeholder="যেমন: খাদ্যাভ্যাস, ওষুধ ও নিয়মিত ফলোআপের সমন্বিত চিকিৎসা...">{{ old('approach_bn', $specialty->approach_bn) }}</textarea>
          </div>

          {{-- Icon, Tags & Order --}}
          <div class="col-md-4">
            <label for="icon_class" class="form-label small fw-semibold">Bootstrap Icon Class</label>
            <input type="text" class="form-control" id="icon_class" name="icon_class" value="{{ old('icon_class', $specialty->icon_class ?? 'bi-heart-pulse-fill') }}" placeholder="bi-heart-pulse-fill">
            <div class="small text-muted mt-1">e.g. bi-heart-pulse-fill, bi-activity, bi-capsule, bi-lungs-fill</div>
          </div>

          <div class="col-md-4">
            <label for="tags_en_text" class="form-label small fw-semibold">Tags (English, comma-separated)</label>
            <input type="text" class="form-control" id="tags_en_text" name="tags_en_text" value="{{ old('tags_en_text', is_array($specialty->tags_en) ? implode(', ', $specialty->tags_en) : '') }}" placeholder="HbA1c, Insulin, Diet">
          </div>

          <div class="col-md-4">
            <label for="display_order" class="form-label small fw-semibold">Display Order</label>
            <input type="number" class="form-control" id="display_order" name="display_order" value="{{ old('display_order', $specialty->display_order ?? 0) }}">
          </div>

          <div class="col-12">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $specialty->is_active ?? true) ? 'checked' : '' }}>
              <label class="form-check-label fw-semibold" for="is_active">Publish this specialty on public website</label>
            </div>
          </div>
        </div>

        <div class="mt-4 pt-3 border-top d-flex gap-2 justify-content-end">
          <a href="{{ route('admin.specialties.index') }}" class="btn btn-light px-4">Cancel</a>
          <button type="submit" class="btn btn-success px-4">
            <i class="bi bi-check2-circle me-1"></i> {{ $specialty->exists ? 'Update Specialty' : 'Save Specialty' }}
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection

