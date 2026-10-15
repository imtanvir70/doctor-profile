@extends('layouts.admin')

@section('title', 'Patient Reviews & Testimonials')
@section('page_heading', 'Patient Reviews & Recovery Stories')

@section('content')
  <div class="row g-4">
    {{-- Left: Reviews List --}}
    <div class="col-lg-7">
      <div class="admin-table-card">
        <div class="p-3 px-4 border-bottom d-flex align-items-center justify-content-between bg-light">
          <h2 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-chat-quote-fill text-warning me-2"></i>Patient Testimonials</h2>
          <span class="badge bg-secondary-subtle text-dark">{{ count($reviews) }} Reviews</span>
        </div>

        <div class="p-3 d-flex flex-column gap-3">
          @forelse($reviews as $rev)
            <div class="p-3 rounded-3 border bg-white shadow-xs">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="d-flex align-items-center gap-2">
                  <div style="width: 36px; height: 36px; background: #e0f2fe; color: #0369a1; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700;">
                    {{ mb_substr($rev->patient_name, 0, 2) }}
                  </div>
                  <div>
                    <div class="fw-bold text-dark small">{{ $rev->patient_name }}</div>
                    <div class="text-muted" style="font-size: 0.75rem;">{{ $rev->location_tag_en ?? $rev->location_en ?? 'Dhanmondi' }} • {{ $rev->disease_type_en ?? 'General' }}</div>
                  </div>
                </div>

                <div class="text-warning small">
                  @for($i = 0; $i < ($rev->rating ?? 5); $i++)
                    <i class="bi bi-star-fill"></i>
                  @endfor
                </div>
              </div>

              <p class="small text-muted mb-2 fst-italic">"{{ $rev->review_text_en }}"</p>
              <p class="small text-muted mb-3" style="font-size: 0.8rem;">"{{ $rev->review_text_bn }}"</p>

              <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                <form action="{{ route('admin.reviews.toggle', $rev->id) }}" method="POST">
                  @csrf
                  @if($rev->is_approved)
                    <button type="submit" class="btn btn-sm btn-outline-success py-1 px-2 fw-semibold" title="Click to unapprove">
                      <i class="bi bi-check-circle-fill me-1"></i> Approved (Live)
                    </button>
                  @else
                    <button type="submit" class="btn btn-sm btn-outline-warning py-1 px-2 fw-semibold" title="Click to approve">
                      <i class="bi bi-hourglass-split me-1"></i> Pending Approval
                    </button>
                  @endif
                </form>

                <div class="d-flex align-items-center gap-1">
                  <button type="button" class="btn btn-sm btn-outline-primary py-1 px-2" data-bs-toggle="modal" data-bs-target="#editReviewModal{{ $rev->id }}" title="Edit Testimonial">
                    <i class="bi bi-pencil-square me-1"></i> Edit
                  </button>
                  <form action="{{ route('admin.reviews.destroy', $rev->id) }}" method="POST" onsubmit="return confirm('Delete this review?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" title="Delete">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </div>
              </div>

              {{-- Edit Review Modal --}}
              <div class="modal fade text-start" id="editReviewModal{{ $rev->id }}" tabindex="-1" aria-labelledby="editReviewLabel{{ $rev->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                  <div class="modal-content rounded-4 border-0 shadow">
                    <form action="{{ route('admin.reviews.update', $rev->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="modal-header bg-light py-3 px-4 border-bottom">
                        <h5 class="modal-title fs-6 fw-bold text-dark" id="editReviewLabel{{ $rev->id }}">
                          <i class="bi bi-pencil-square text-primary me-2"></i>Edit Patient Testimonial
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body p-4">
                        <div class="mb-3">
                          <label class="form-label small fw-semibold">Patient Name <span class="text-danger">*</span></label>
                          <input type="text" name="patient_name" class="form-control form-control-sm" value="{{ $rev->patient_name }}" required>
                        </div>

                        <div class="row g-2 mb-3">
                          <div class="col-6">
                            <label class="form-label small fw-semibold">Disease & Area (EN) <span class="text-danger">*</span></label>
                            <input type="text" name="location_tag_en" class="form-control form-control-sm" value="{{ $rev->location_tag_en }}" required>
                          </div>
                          <div class="col-6">
                            <label class="form-label small fw-semibold">Disease & Area (বাংলা) <span class="text-danger">*</span></label>
                            <input type="text" name="location_tag_bn" class="form-control form-control-sm" value="{{ $rev->location_tag_bn }}" required>
                          </div>
                        </div>

                        <div class="mb-3">
                          <label class="form-label small fw-semibold">Star Rating (1-5) <span class="text-danger">*</span></label>
                          <select name="rating" class="form-select form-select-sm" required>
                            <option value="5" {{ ($rev->rating ?? 5) == 5 ? 'selected' : '' }}>5 Stars (★★★★★)</option>
                            <option value="4" {{ ($rev->rating ?? 5) == 4 ? 'selected' : '' }}>4 Stars (★★★★)</option>
                            <option value="3" {{ ($rev->rating ?? 5) == 3 ? 'selected' : '' }}>3 Stars (★★★)</option>
                            <option value="2" {{ ($rev->rating ?? 5) == 2 ? 'selected' : '' }}>2 Stars (★★)</option>
                            <option value="1" {{ ($rev->rating ?? 5) == 1 ? 'selected' : '' }}>1 Star (★)</option>
                          </select>
                        </div>

                        <div class="mb-3">
                          <label class="form-label small fw-semibold">Testimonial Review (English) <span class="text-danger">*</span></label>
                          <textarea name="review_text_en" class="form-control form-control-sm" rows="3" required>{{ $rev->review_text_en }}</textarea>
                        </div>

                        <div class="mb-3">
                          <label class="form-label small fw-semibold">Testimonial Review (বাংলা) <span class="text-danger">*</span></label>
                          <textarea name="review_text_bn" class="form-control form-control-sm" rows="3" required>{{ $rev->review_text_bn }}</textarea>
                        </div>

                        <div class="row g-3">
                          <div class="col-6">
                            <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" id="rev_featured_{{ $rev->id }}" name="is_featured" value="1" {{ $rev->is_featured ? 'checked' : '' }}>
                              <label class="form-check-label small fw-semibold" for="rev_featured_{{ $rev->id }}">Featured Story</label>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" id="rev_approved_{{ $rev->id }}" name="is_approved" value="1" {{ $rev->is_approved ? 'checked' : '' }}>
                              <label class="form-check-label small fw-semibold" for="rev_approved_{{ $rev->id }}">Approved & Live on Website</label>
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
            </div>
          @empty
            <div class="text-center py-4 text-muted small">No reviews recorded yet.</div>
          @endforelse
        </div>
      </div>
    </div>

    {{-- Right: Add Review Form --}}
    <div class="col-lg-5">
      <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 border-bottom">
          <h2 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-plus-circle text-success me-2"></i>Add Patient Review</h2>
        </div>
        <div class="card-body p-4">
          <form action="{{ route('admin.reviews.store') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label class="form-label small fw-semibold">Patient Name <span class="text-danger">*</span></label>
              <input type="text" name="patient_name" class="form-control form-control-sm" placeholder="e.g. Anwar Hossain" required>
            </div>

            <div class="row g-2 mb-3">
              <div class="col-6">
                <label class="form-label small fw-semibold">Disease & Area (EN) <span class="text-danger">*</span></label>
                <input type="text" name="location_tag_en" class="form-control form-control-sm" placeholder="Diabetes Care • Dhanmondi" required>
              </div>
              <div class="col-6">
                <label class="form-label small fw-semibold">Disease & Area (বাংলা) <span class="text-danger">*</span></label>
                <input type="text" name="location_tag_bn" class="form-control form-control-sm" placeholder="ডায়াবেটিস রোগী • ধানমন্ডি" required>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">Star Rating (1-5) <span class="text-danger">*</span></label>
              <select name="rating" class="form-select form-select-sm" required>
                <option value="5" selected>5 Stars (★★★★★)</option>
                <option value="4">4 Stars (★★★★)</option>
                <option value="3">3 Stars (★★★)</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">Testimonial Review (English) <span class="text-danger">*</span></label>
              <textarea name="review_text_en" class="form-control form-control-sm" rows="3" placeholder="Patient's feedback in English..." required></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">Testimonial Review (বাংলা) <span class="text-danger">*</span></label>
              <textarea name="review_text_bn" class="form-control form-control-sm" rows="3" placeholder="রোগীর বাস্তব মন্তব্য বাংলায়..." required></textarea>
            </div>

            <div class="mb-4">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="is_approved" name="is_approved" value="1" checked>
                <label class="form-check-label small fw-semibold" for="is_approved">Approve & Publish Immediately</label>
              </div>
            </div>

            <button type="submit" class="btn btn-success w-100 fw-bold">
              <i class="bi bi-star-fill me-1"></i> Save Testimonial
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

