@extends('layouts.admin')

@section('title', $chamber->exists ? 'Edit Chamber: ' . $chamber->name_en : 'Add New Chamber')
@section('page_heading', $chamber->exists ? 'Edit Chamber' : 'Create New Chamber')

@section('content')
  <div class="row justify-content-center">
    <div class="col-lg-9">
      <form action="{{ $chamber->exists ? route('admin.chambers.update', $chamber->id) : route('admin.chambers.store') }}" method="POST">
        @csrf
        @if($chamber->exists)
          @method('PUT')
        @endif

        <div class="card border-0 shadow-sm rounded-4 mb-4">
          <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h2 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-hospital text-primary me-2"></i>Chamber Details</h2>
            <a href="{{ route('admin.chambers.index') }}" class="btn btn-sm btn-outline-secondary">
              <i class="bi bi-arrow-left me-1"></i> Back to Chambers
            </a>
          </div>
          <div class="card-body p-4">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label small fw-semibold">Chamber Name (English) <span class="text-danger">*</span></label>
                <input type="text" name="name_en" class="form-control" value="{{ old('name_en', $chamber->name_en) }}" required>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold">Chamber Name (বাংলা) <span class="text-danger">*</span></label>
                <input type="text" name="name_bn" class="form-control" value="{{ old('name_bn', $chamber->name_bn) }}" required>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold">Address (English) <span class="text-danger">*</span></label>
                <input type="text" name="address_en" class="form-control" value="{{ old('address_en', $chamber->address_en) }}" required>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold">Address (বাংলা) <span class="text-danger">*</span></label>
                <input type="text" name="address_bn" class="form-control" value="{{ old('address_bn', $chamber->address_bn) }}" required>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold">Visiting Days (English) <span class="text-danger">*</span></label>
                <input type="text" name="visiting_days_en" class="form-control" value="{{ old('visiting_days_en', $chamber->visiting_days_en) }}" placeholder="Saturday – Wednesday" required>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold">Visiting Days (বাংলা) <span class="text-danger">*</span></label>
                <input type="text" name="visiting_days_bn" class="form-control" value="{{ old('visiting_days_bn', $chamber->visiting_days_bn) }}" placeholder="শনিবার – বুধবার" required>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold">Visiting Hours (English) <span class="text-danger">*</span></label>
                <input type="text" name="visiting_hours_en" class="form-control" value="{{ old('visiting_hours_en', $chamber->visiting_hours_en) }}" placeholder="5:00 PM – 9:30 PM" required>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold">Visiting Hours (বাংলা) <span class="text-danger">*</span></label>
                <input type="text" name="visiting_hours_bn" class="form-control" value="{{ old('visiting_hours_bn', $chamber->visiting_hours_bn) }}" placeholder="বিকেল ৫:০০ – রাত ৯:৩০" required>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold">Weekly Off (English)</label>
                <input type="text" name="weekly_off_en" class="form-control" value="{{ old('weekly_off_en', $chamber->weekly_off_en) }}" placeholder="Thursday & Friday">
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold">Weekly Off (বাংলা)</label>
                <input type="text" name="weekly_off_bn" class="form-control" value="{{ old('weekly_off_bn', $chamber->weekly_off_bn) }}" placeholder="বৃহস্পতিবার ও শুক্রবার">
              </div>

              <div class="col-md-4">
                <label class="form-label small fw-semibold">Phone Hotline 1 <span class="text-danger">*</span></label>
                <input type="text" name="phone1" class="form-control" value="{{ old('phone1', $chamber->phone1) }}" required>
              </div>

              <div class="col-md-4">
                <label class="form-label small fw-semibold">Phone Hotline 2</label>
                <input type="text" name="phone2" class="form-control" value="{{ old('phone2', $chamber->phone2) }}">
              </div>

              <div class="col-md-4">
                <label class="form-label small fw-semibold">Consultation Fee <span class="text-danger">*</span></label>
                <input type="text" name="fee" class="form-control" value="{{ old('fee', $chamber->consultation_fee ?? $chamber->fee ?? 'BDT 1,200') }}" required>
              </div>

              <div class="col-12">
                <label class="form-label small fw-semibold">Google Map Embed or Direct URL</label>
                <input type="text" name="map_url" class="form-control" value="{{ old('map_url', $chamber->map_url) }}" placeholder="https://maps.google.com/...">
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold">On-Site Facilities / Note (English)</label>
                <textarea name="facilities_en" class="form-control" rows="2">{{ old('facilities_en', $chamber->notes_en ?? $chamber->facilities_en) }}</textarea>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold">On-Site Facilities / Note (বাংলা)</label>
                <textarea name="facilities_bn" class="form-control" rows="2">{{ old('facilities_bn', $chamber->notes_bn ?? $chamber->facilities_bn) }}</textarea>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold">Display Order</label>
                <input type="number" name="display_order" class="form-control" value="{{ old('display_order', $chamber->display_order ?? 1) }}" min="1">
              </div>

              <div class="col-md-6 d-flex align-items-center pt-4">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $chamber->is_active ?? true) ? 'checked' : '' }}>
                  <label class="form-check-label fw-semibold small" for="is_active">Active & Open for Online Serials</label>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer bg-light py-3 d-flex align-items-center justify-content-end gap-2">
            <a href="{{ route('admin.chambers.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-success px-4 fw-bold">
              <i class="bi bi-check2-circle me-1"></i> Save Chamber
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

