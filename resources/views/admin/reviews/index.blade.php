@extends('layouts.admin')

@section('title', 'Patient Reviews & Moderation')
@section('page_heading', 'Patient Reviews & Testimonials')

@section('content')
  <div class="row g-4">
    <div class="col-12">
      <div class="card border-0 shadow-sm rounded-4">
        <div class="p-4 border-bottom bg-white d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
          <div>
            <h2 class="fs-5 fw-bold mb-1 text-dark brand-font d-flex align-items-center gap-2">
              <i class="bi bi-chat-quote-fill text-warning"></i>
              <span>Patient Reviews & Moderation</span>
            </h2>
            <p class="text-muted small mb-0">
              রোগীদের সরাসরি সাবমিট করা রিভিউ ও মতামতের তালিকা। অনুমোদন দিলে রিভিউটি মূল ওয়েবসাইটে প্রদর্শিত হবে।
            </p>
          </div>
          <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill fw-semibold">
              <i class="bi bi-collection-fill me-1"></i> Total: {{ $reviews->count() }}
            </span>
            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-semibold">
              <i class="bi bi-check-circle-fill me-1"></i> Live: {{ $reviews->where('is_approved', true)->count() }}
            </span>
            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-2 rounded-pill fw-semibold">
              <i class="bi bi-hourglass-split me-1"></i> Pending: {{ $reviews->where('is_approved', false)->count() }}
            </span>
          </div>
        </div>

        <div class="p-4">
          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 rounded-3 d-flex align-items-center gap-2" role="alert">
              <i class="bi bi-check-circle-fill fs-5 text-success"></i>
              <div>{{ session('success') }}</div>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <div class="row g-3">
            @forelse($reviews as $rev)
              <div class="col-lg-6 col-xl-4">
                <div class="card h-100 border rounded-3 p-3 d-flex flex-column justify-content-between shadow-xs {{ $rev->is_approved ? 'border-success-subtle bg-white' : 'border-warning-subtle bg-light-subtle' }}">
                  <div>
                    {{-- Header: Avatar, Name, Rating --}}
                    <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                      <div class="d-flex align-items-center gap-2 min-w-0">
                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white flex-shrink-0"
                             style="width: 40px; height: 40px; background: linear-gradient(135deg, #0d9488, #0284c7); font-size: 0.9rem;">
                          {{ $rev->patient_initials ?: mb_substr($rev->patient_name, 0, 2) }}
                        </div>
                        <div class="min-w-0">
                          <div class="fw-bold text-dark text-truncate" title="{{ $rev->patient_name }}">{{ $rev->patient_name }}</div>
                          <div class="text-muted" style="font-size: 0.78rem;">
                            {{ $rev->treated_for ?: ($rev->location_tag_bn ?: $rev->location_tag_en ?: 'রোগী') }}
                          </div>
                        </div>
                      </div>

                      <div class="text-warning text-nowrap" style="font-size: 0.85rem;" title="{{ $rev->rating ?? 5 }} Stars">
                        @for($i = 0; $i < ($rev->rating ?? 5); $i++)
                          <i class="bi bi-star-fill"></i>
                        @endfor
                      </div>
                    </div>

                    {{-- Verification Data Badge: Phone & Last Visit Date --}}
                    <div class="p-2 mb-3 rounded-2 bg-light border small">
                      <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-telephone-fill text-primary me-1"></i>মোবাইল নং:</span>
                        @if($rev->patient_phone)
                          <a href="tel:{{ $rev->patient_phone }}" class="fw-bold text-dark text-decoration-none">
                            {{ $rev->patient_phone }}
                          </a>
                        @else
                          <span class="text-muted fst-italic">অজানা / Not set</span>
                        @endif
                      </div>
                      <div class="d-flex align-items-center justify-content-between">
                        <span class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-calendar-check text-success me-1"></i>সর্বশেষ ভিজিট:</span>
                        @if($rev->last_visit_date)
                          <span class="fw-semibold text-secondary">
                            {{ is_string($rev->last_visit_date) ? date('d M, Y', strtotime($rev->last_visit_date)) : $rev->last_visit_date->format('d M, Y') }}
                          </span>
                        @else
                          <span class="text-muted fst-italic">পূর্বে সংগৃহীত</span>
                        @endif
                      </div>
                    </div>

                    {{-- Review Content --}}
                    <div class="mb-3">
                      <p class="small text-dark mb-1" style="font-size: 0.88rem; line-height: 1.45;">
                        "{{ $rev->review_text_bn ?: $rev->review_text_en }}"
                      </p>
                      @if($rev->review_text_en && $rev->review_text_bn && $rev->review_text_en !== $rev->review_text_bn)
                        <p class="small text-muted mb-0 fst-italic" style="font-size: 0.8rem;">
                          "{{ $rev->review_text_en }}"
                        </p>
                      @endif
                    </div>
                  </div>

                  {{-- Bottom Moderation Bar --}}
                  <div class="pt-2 border-top mt-auto d-flex align-items-center justify-content-between gap-2">
                    <form action="{{ route('admin.reviews.toggle', $rev->id) }}" method="POST" class="m-0">
                      @csrf
                      @if($rev->is_approved)
                        <button type="submit" class="btn btn-sm btn-outline-success py-1 px-2 fw-semibold d-inline-flex align-items-center gap-1" title="ক্লিক করে আন-এপ্রুভ করুন">
                          <i class="bi bi-check-circle-fill"></i>
                          <span>Approved (Live)</span>
                        </button>
                      @else
                        <button type="submit" class="btn btn-sm btn-outline-warning text-dark py-1 px-2 fw-semibold d-inline-flex align-items-center gap-1" title="ক্লিক করে ওয়েবসাইটে লাইভ করুন">
                          <i class="bi bi-hourglass-split text-warning"></i>
                          <span>Approve Review</span>
                        </button>
                      @endif
                    </form>

                    <div class="d-flex align-items-center gap-1">
                      <button type="button" class="btn btn-sm btn-outline-primary py-1 px-2" data-bs-toggle="modal" data-bs-target="#editReviewModal{{ $rev->id }}" title="রিভিউ এডিট করুন">
                        <i class="bi bi-pencil-square"></i>
                      </button>
                      <form action="{{ route('admin.reviews.destroy', $rev->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত এই রিভিউটি ডিলিট করতে চান?');" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" title="ডিলিট">
                          <i class="bi bi-trash"></i>
                        </button>
                      </form>
                    </div>
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
                            <i class="bi bi-pencil-square text-primary me-2"></i>Edit Patient Review / Testimonial
                          </h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                          <div class="row g-3 mb-3">
                            <div class="col-md-6">
                              <label class="form-label small fw-semibold">Patient Name <span class="text-danger">*</span></label>
                              <input type="text" name="patient_name" class="form-control form-control-sm" value="{{ $rev->patient_name }}" required>
                            </div>
                            <div class="col-md-6">
                              <label class="form-label small fw-semibold">Phone Number (11-digit BD)</label>
                              <input type="text" name="patient_phone" class="form-control form-control-sm" value="{{ $rev->patient_phone }}" pattern="01[3-9][0-9]{8}" maxlength="11" placeholder="01712345678">
                            </div>
                          </div>

                          <div class="row g-3 mb-3">
                            <div class="col-md-6">
                              <label class="form-label small fw-semibold">Last Visit Date (সর্বশেষ দেখানোর তারিখ)</label>
                              <input type="date" name="last_visit_date" class="form-control form-control-sm" value="{{ $rev->last_visit_date ? (is_string($rev->last_visit_date) ? date('Y-m-d', strtotime($rev->last_visit_date)) : $rev->last_visit_date->format('Y-m-d')) : '' }}" max="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-6">
                              <label class="form-label small fw-semibold">Treated For / Disease (রোগের ধরন)</label>
                              <input type="text" name="treated_for" class="form-control form-control-sm" value="{{ $rev->treated_for }}" placeholder="e.g. ডায়াবেটিস ও থাইরয়েড">
                            </div>
                          </div>

                          <div class="row g-3 mb-3">
                            <div class="col-md-4">
                              <label class="form-label small fw-semibold">Star Rating (1-5) <span class="text-danger">*</span></label>
                              <select name="rating" class="form-select form-select-sm" required>
                                <option value="5" {{ ($rev->rating ?? 5) == 5 ? 'selected' : '' }}>5 Stars (★★★★★)</option>
                                <option value="4" {{ ($rev->rating ?? 5) == 4 ? 'selected' : '' }}>4 Stars (★★★★)</option>
                                <option value="3" {{ ($rev->rating ?? 5) == 3 ? 'selected' : '' }}>3 Stars (★★★)</option>
                                <option value="2" {{ ($rev->rating ?? 5) == 2 ? 'selected' : '' }}>2 Stars (★★)</option>
                                <option value="1" {{ ($rev->rating ?? 5) == 1 ? 'selected' : '' }}>1 Star (★)</option>
                              </select>
                            </div>
                            <div class="col-md-4">
                              <label class="form-label small fw-semibold">Location / Tag (বাংলা)</label>
                              <input type="text" name="location_tag_bn" class="form-control form-control-sm" value="{{ $rev->location_tag_bn }}">
                            </div>
                            <div class="col-md-4">
                              <label class="form-label small fw-semibold">Location / Tag (English)</label>
                              <input type="text" name="location_tag_en" class="form-control form-control-sm" value="{{ $rev->location_tag_en }}">
                            </div>
                          </div>

                          <div class="mb-3">
                            <label class="form-label small fw-semibold">Review Text (বাংলা) <span class="text-danger">*</span></label>
                            <textarea name="review_text_bn" class="form-control form-control-sm" rows="3" required>{{ $rev->review_text_bn }}</textarea>
                          </div>

                          <div class="mb-3">
                            <label class="form-label small fw-semibold">Review Text (English)</label>
                            <textarea name="review_text_en" class="form-control form-control-sm" rows="3">{{ $rev->review_text_en }}</textarea>
                          </div>

                          <div class="row g-3">
                            <div class="col-6">
                              <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="rev_approved_{{ $rev->id }}" name="is_approved" value="1" {{ $rev->is_approved ? 'checked' : '' }}>
                                <label class="form-check-label small fw-semibold" for="rev_approved_{{ $rev->id }}">Approved & Live on Website</label>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="rev_featured_{{ $rev->id }}" name="is_featured" value="1" {{ $rev->is_featured ? 'checked' : '' }}>
                                <label class="form-check-label small fw-semibold" for="rev_featured_{{ $rev->id }}">Featured Story</label>
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
              <div class="col-12">
                <div class="text-center py-5 text-muted">
                  <i class="bi bi-chat-square-quote display-4 text-secondary mb-3 d-block"></i>
                  <h5 class="fw-bold text-dark">কোনো রিভিউ এখনো জমা হয়নি</h5>
                  <p class="small text-muted">রোগীরা মূল ওয়েবসাইট থেকে রিভিউ সাবমিট করলে এখানে প্রদর্শন ও অনুমোদন করা যাবে।</p>
                </div>
              </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
