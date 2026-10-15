@extends('layouts.admin')

@section('title', 'Video Guides Management')
@section('page_heading', 'Video Guides & Advice Management')

@section('content')
  <div class="row g-4">
    {{-- Left: Videos List --}}
    <div class="col-lg-7">
      <div class="admin-table-card">
        <div class="p-3 px-4 border-bottom d-flex align-items-center justify-content-between bg-light">
          <h2 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-youtube text-danger me-2"></i>Published Video Guides</h2>
          <span class="badge bg-secondary-subtle text-dark">{{ count($videos) }} Videos</span>
        </div>
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light small text-muted text-uppercase">
              <tr>
                <th>Video</th>
                <th>Title / Category</th>
                <th>Duration</th>
                <th>Order</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody class="small">
              @forelse($videos as $vid)
                <tr>
                  <td>
                    <div class="position-relative" style="width: 70px; height: 46px; border-radius: 6px; overflow: hidden; border: 1px solid #e2e8f0;">
                      <img src="{{ $vid->thumbnail ?? 'https://img.youtube.com/vi/' . $vid->youtube_id . '/hqdefault.jpg' }}" alt="Video" class="w-100 h-100 object-fit-cover">
                      <span class="position-absolute top-50 start-50 translate-middle text-white"><i class="bi bi-play-circle-fill fs-5 text-danger"></i></span>
                    </div>
                  </td>
                  <td style="max-width: 250px;">
                    <div class="fw-bold text-dark text-truncate">{{ $vid->title_en }}</div>
                    <div class="text-muted text-truncate" style="font-size: 0.78rem;">{{ $vid->title_bn }}</div>
                    <span class="badge bg-light text-danger border mt-1" style="font-size: 0.72rem;">{{ $vid->category }}</span>
                  </td>
                  <td>{{ $vid->duration ?? '8:00' }}</td>
                  <td>{{ $vid->display_order }}</td>
                  <td class="text-end text-nowrap">
                    <button type="button" class="btn btn-sm btn-outline-primary py-1 px-2 me-1" data-bs-toggle="modal" data-bs-target="#editVideoModal{{ $vid->id }}" title="Edit Video">
                      <i class="bi bi-pencil-square"></i>
                    </button>
                    <form action="{{ route('admin.videos.destroy', $vid->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this video?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" title="Delete">
                        <i class="bi bi-trash"></i>
                      </button>
                    </form>

                    {{-- Edit Video Modal --}}
                    <div class="modal fade text-start" id="editVideoModal{{ $vid->id }}" tabindex="-1" aria-labelledby="editVideoLabel{{ $vid->id }}" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content rounded-4 border-0 shadow">
                          <form action="{{ route('admin.videos.update', $vid->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header bg-light py-3 px-4 border-bottom">
                              <h5 class="modal-title fs-6 fw-bold text-dark" id="editVideoLabel{{ $vid->id }}">
                                <i class="bi bi-pencil-square text-primary me-2"></i>Edit Video Guide
                              </h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                              <div class="mb-3">
                                <label class="form-label small fw-semibold">Video Title (English) <span class="text-danger">*</span></label>
                                <input type="text" name="title_en" class="form-control form-control-sm" value="{{ $vid->title_en }}" required>
                              </div>

                              <div class="mb-3">
                                <label class="form-label small fw-semibold">Video Title (বাংলা) <span class="text-danger">*</span></label>
                                <input type="text" name="title_bn" class="form-control form-control-sm" value="{{ $vid->title_bn }}" required>
                              </div>

                              <div class="mb-3">
                                <label class="form-label small fw-semibold">YouTube Video ID <span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                  <span class="input-group-text bg-light text-muted">youtube.com/watch?v=</span>
                                  <input type="text" name="youtube_id" class="form-control" value="{{ $vid->youtube_id }}" required>
                                </div>
                                <div class="form-text small" style="font-size: 0.72rem;">11-character YouTube video code (e.g. ScMzIvxBSi4).</div>
                              </div>

                              <div class="row g-2 mb-3">
                                <div class="col-6">
                                  <label class="form-label small fw-semibold">Category <span class="text-danger">*</span></label>
                                  <select name="category" class="form-select form-select-sm" required>
                                    <option value="diabetes" {{ $vid->category === 'diabetes' ? 'selected' : '' }}>Diabetes</option>
                                    <option value="hypertension" {{ $vid->category === 'hypertension' ? 'selected' : '' }}>Hypertension</option>
                                    <option value="antibiotic" {{ $vid->category === 'antibiotic' ? 'selected' : '' }}>Antibiotic Safety</option>
                                    <option value="fever" {{ $vid->category === 'fever' ? 'selected' : '' }}>Fever & Dengue</option>
                                    <option value="respiratory" {{ $vid->category === 'respiratory' ? 'selected' : '' }}>Asthma & Chest</option>
                                    <option value="liver" {{ $vid->category === 'liver' ? 'selected' : '' }}>Liver & Digestion</option>
                                  </select>
                                </div>
                                <div class="col-6">
                                  <label class="form-label small fw-semibold">Duration (e.g. 8:45)</label>
                                  <input type="text" name="duration" class="form-control form-control-sm" value="{{ $vid->duration ?? '8:00' }}">
                                </div>
                              </div>

                              <div class="mb-3">
                                <label class="form-label small fw-semibold">Short Description (English) <span class="text-danger">*</span></label>
                                <textarea name="description_en" class="form-control form-control-sm" rows="2" required>{{ $vid->description_en }}</textarea>
                              </div>

                              <div class="mb-3">
                                <label class="form-label small fw-semibold">Short Description (বাংলা) <span class="text-danger">*</span></label>
                                <textarea name="description_bn" class="form-control form-control-sm" rows="2" required>{{ $vid->description_bn }}</textarea>
                              </div>

                              <div class="row g-2 align-items-center">
                                <div class="col-6">
                                  <label class="form-label small fw-semibold">Display Order</label>
                                  <input type="number" name="display_order" class="form-control form-control-sm" value="{{ $vid->display_order }}" min="1">
                                </div>
                                <div class="col-6 pt-3">
                                  <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active_{{ $vid->id }}" name="is_active" value="1" {{ $vid->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label small fw-semibold" for="is_active_{{ $vid->id }}">Active / Visible</label>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer bg-light py-2 px-4 border-top">
                              <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                              <button type="submit" class="btn btn-sm btn-primary fw-bold">
                                <i class="bi bi-check2-circle me-1"></i> Save Changes
                              </button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center py-4 text-muted">No video guides added yet.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    {{-- Right: Add New Video Form --}}
    <div class="col-lg-5">
      <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 border-bottom">
          <h2 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-plus-circle text-success me-2"></i>Add New Video Guide</h2>
        </div>
        <div class="card-body p-4">
          <form action="{{ route('admin.videos.store') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label class="form-label small fw-semibold">Video Title (English) <span class="text-danger">*</span></label>
              <input type="text" name="title_en" class="form-control form-control-sm" placeholder="e.g. Managing Sudden Fluctuations in Blood Sugar" required>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">Video Title (বাংলা) <span class="text-danger">*</span></label>
              <input type="text" name="title_bn" class="form-control form-control-sm" placeholder="e.g. রক্তে সুগারের হঠাৎ ওঠা-নামা নিয়ন্ত্রণে করণীয়" required>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">YouTube Video ID <span class="text-danger">*</span></label>
              <div class="input-group input-group-sm">
                <span class="input-group-text bg-light text-muted">youtube.com/watch?v=</span>
                <input type="text" name="youtube_id" class="form-control" placeholder="ScMzIvxBSi4" required>
              </div>
              <div class="form-text small" style="font-size: 0.72rem;">Enter the 11-character YouTube video ID.</div>
            </div>

            <div class="row g-2 mb-3">
              <div class="col-6">
                <label class="form-label small fw-semibold">Category <span class="text-danger">*</span></label>
                <select name="category" class="form-select form-select-sm" required>
                  <option value="diabetes">Diabetes</option>
                  <option value="hypertension">Hypertension</option>
                  <option value="antibiotic">Antibiotic Safety</option>
                  <option value="fever">Fever & Dengue</option>
                  <option value="respiratory">Asthma & Chest</option>
                  <option value="liver">Liver & Digestion</option>
                </select>
              </div>
              <div class="col-6">
                <label class="form-label small fw-semibold">Duration (e.g. 8:45)</label>
                <input type="text" name="duration" class="form-control form-control-sm" value="8:45">
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">Short Description (English) <span class="text-danger">*</span></label>
              <textarea name="description_en" class="form-control form-control-sm" rows="2" placeholder="Summary of advice..." required></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">Short Description (বাংলা) <span class="text-danger">*</span></label>
              <textarea name="description_bn" class="form-control form-control-sm" rows="2" placeholder="পরামর্শের সারসংক্ষেপ..." required></textarea>
            </div>

            <div class="row g-2 mb-3 align-items-center">
              <div class="col-6">
                <label class="form-label small fw-semibold">Order</label>
                <input type="number" name="display_order" class="form-control form-control-sm" value="{{ count($videos) + 1 }}" min="1">
              </div>
              <div class="col-6 pt-3">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                  <label class="form-check-label small fw-semibold" for="is_active">Active</label>
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-success w-100 fw-bold">
              <i class="bi bi-cloud-arrow-up-fill me-1"></i> Add Video Guide
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

