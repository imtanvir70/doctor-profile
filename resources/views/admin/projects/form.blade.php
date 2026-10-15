@extends('layouts.admin')

@section('title', $project->exists ? 'Edit International Project' : 'Add International Project')
@section('page_heading', $project->exists ? 'Edit International Project' : 'Add New International Project')

@section('content')
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="fs-5 fw-bold mb-1 brand-font text-dark">{{ $project->exists ? 'Edit Global Collaboration' : 'New Global Collaboration' }}</h2>
          <p class="text-muted small mb-0">Fill in the details for international research, clinical trials, or WHO/global advisory projects.</p>
        </div>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
          <i class="bi bi-arrow-left"></i>
          <span>Back to List</span>
        </a>
      </div>

      @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
          <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Please fix the following errors:</div>
          <ul class="mb-0 small ps-3">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-md-5">
          <form action="{{ $project->exists ? route('admin.projects.update', $project->id) : route('admin.projects.store') }}" method="POST">
            @csrf
            @if($project->exists)
              @method('PUT')
            @endif

            <h3 class="fs-6 fw-bold text-primary brand-font mb-3 pb-2 border-bottom">
              <i class="bi bi-globe me-2"></i>1. Project Title & Organization
            </h3>

            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label class="form-label small fw-semibold">Project Title (English) <span class="text-danger">*</span></label>
                <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $project->title_en) }}" placeholder="e.g. WHO South-East Asia Diabetes & Cardiovascular Prevention Study" required>
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-semibold">Project Title (বাংলা) <span class="text-danger">*</span></label>
                <input type="text" name="title_bn" class="form-control" value="{{ old('title_bn', $project->title_bn) }}" placeholder="e.g. দক্ষিণ এশিয়া ডায়াবেটিস ও কার্ডিওভাসকুলার প্রতিরোধ গবেষণা" required>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold">Global Organization / Sponsor <span class="text-danger">*</span></label>
                <input type="text" name="organization" class="form-control" value="{{ old('organization', $project->organization) }}" placeholder="e.g. World Health Organization (WHO) & Oxford Health" required>
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-semibold">Country / Collaborative Hub</label>
                <input type="text" name="country_or_location" class="form-control" value="{{ old('country_or_location', $project->country_or_location) }}" placeholder="e.g. Geneva, Switzerland & South Asia Hub">
              </div>
            </div>

            <h3 class="fs-6 fw-bold text-primary brand-font mb-3 pb-2 border-bottom">
              <i class="bi bi-person-badge me-2"></i>2. Doctor's Role & Timing
            </h3>

            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label class="form-label small fw-semibold">Doctor's Role (English) <span class="text-danger">*</span></label>
                <input type="text" name="role_en" class="form-control" value="{{ old('role_en', $project->role_en ?? 'National Clinical Lead - Bangladesh Cohort') }}" required>
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-semibold">Doctor's Role (বাংলা) <span class="text-danger">*</span></label>
                <input type="text" name="role_bn" class="form-control" value="{{ old('role_bn', $project->role_bn ?? 'জাতীয় ক্লিনিক্যাল প্রধান - বাংলাদেশ পর্ব') }}" required>
              </div>

              <div class="col-md-4">
                <label class="form-label small fw-semibold">Project Duration</label>
                <input type="text" name="duration" class="form-control" value="{{ old('duration', $project->duration) }}" placeholder="e.g. 2022 – 2024 or Ongoing">
              </div>
              <div class="col-md-4">
                <label class="form-label small fw-semibold">Category <span class="text-danger">*</span></label>
                <select name="category" class="form-select" required>
                  <option value="Clinical Research" {{ old('category', $project->category) === 'Clinical Research' ? 'selected' : '' }}>Clinical Research</option>
                  <option value="Multicenter Clinical Trial" {{ old('category', $project->category) === 'Multicenter Clinical Trial' ? 'selected' : '' }}>Multicenter Clinical Trial</option>
                  <option value="Public Health & Pharmacology" {{ old('category', $project->category) === 'Public Health & Pharmacology' ? 'selected' : '' }}>Public Health & Pharmacology</option>
                  <option value="Epidemiology" {{ old('category', $project->category) === 'Epidemiology' ? 'selected' : '' }}>Epidemiology</option>
                  <option value="Global Health Advisory" {{ old('category', $project->category) === 'Global Health Advisory' ? 'selected' : '' }}>Global Health Advisory</option>
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label small fw-semibold">Highlight Badge Text</label>
                <input type="text" name="badge_text" class="form-control" value="{{ old('badge_text', $project->badge_text) }}" placeholder="e.g. WHO Sponsored, Published in Lancet">
              </div>
            </div>

            <h3 class="fs-6 fw-bold text-primary brand-font mb-3 pb-2 border-bottom">
              <i class="bi bi-file-text me-2"></i>3. Description, Impact & Links
            </h3>

            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label class="form-label small fw-semibold">Project Summary & Impact (English)</label>
                <textarea name="description_en" class="form-control" rows="3" placeholder="Brief explanation of findings, clinical protocols developed, or patient outcomes...">{{ old('description_en', $project->description_en) }}</textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-semibold">Project Summary & Impact (বাংলা)</label>
                <textarea name="description_bn" class="form-control" rows="3" placeholder="প্রকল্পের ফলাফল, চিকিৎসা নির্দেশনা বা গবেষণার প্রভাব সম্পর্কে সংক্ষেপ...">{{ old('description_bn', $project->description_bn) }}</textarea>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold">External Reference URL (Optional)</label>
                <input type="url" name="project_url" class="form-control" value="{{ old('project_url', $project->project_url) }}" placeholder="https://www.who.int/project-link">
              </div>
              <div class="col-md-3">
                <label class="form-label small fw-semibold">Icon (Bootstrap Icon)</label>
                <select name="icon" class="form-select">
                  <option value="bi-globe-americas" {{ old('icon', $project->icon) === 'bi-globe-americas' ? 'selected' : '' }}>Globe (bi-globe-americas)</option>
                  <option value="bi-shield-check" {{ old('icon', $project->icon) === 'bi-shield-check' ? 'selected' : '' }}>Shield (bi-shield-check)</option>
                  <option value="bi-activity" {{ old('icon', $project->icon) === 'bi-activity' ? 'selected' : '' }}>Pulse / Activity (bi-activity)</option>
                  <option value="bi-hospital-fill" {{ old('icon', $project->icon) === 'bi-hospital-fill' ? 'selected' : '' }}>Hospital (bi-hospital-fill)</option>
                  <option value="bi-award-fill" {{ old('icon', $project->icon) === 'bi-award-fill' ? 'selected' : '' }}>Award (bi-award-fill)</option>
                  <option value="bi-journal-medical" {{ old('icon', $project->icon) === 'bi-journal-medical' ? 'selected' : '' }}>Medical Journal (bi-journal-medical)</option>
                </select>
              </div>
              <div class="col-md-3">
                <label class="form-label small fw-semibold">Display Order</label>
                <input type="number" name="display_order" class="form-control" value="{{ old('display_order', $project->display_order ?? 0) }}" min="0">
              </div>
            </div>

            <div class="p-3 bg-light rounded-3 mb-4 d-flex flex-wrap gap-4 align-items-center">
              <div class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox" name="is_active" id="isActiveCheck" value="1" {{ old('is_active', $project->exists ? $project->is_active : true) ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold small" for="isActiveCheck">Active (Visible on public site)</label>
              </div>
              <div class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox" name="is_featured" id="isFeaturedCheck" value="1" {{ old('is_featured', $project->exists ? $project->is_featured : true) ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold small" for="isFeaturedCheck">Featured on Homepage</label>
              </div>
            </div>

            <div class="d-flex align-items-center justify-content-end gap-2">
              <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
              <button type="submit" class="btn btn-primary px-4 shadow-sm">
                <i class="bi bi-check-circle-fill me-1"></i> {{ $project->exists ? 'Update Project' : 'Save International Project' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

