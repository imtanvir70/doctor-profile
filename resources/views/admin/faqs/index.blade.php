@extends('layouts.admin')

@section('title', 'Patient FAQs Management')
@section('page_heading', 'Patient Frequently Asked Questions (FAQ)')

@section('content')
  <div class="row g-4">
    {{-- Left: FAQs Accordion / List --}}
    <div class="col-lg-7">
      <div class="admin-table-card">
        <div class="p-3 px-4 border-bottom d-flex align-items-center justify-content-between bg-light">
          <h2 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-question-circle-fill text-primary me-2"></i>Active FAQ Items</h2>
          <span class="badge bg-secondary-subtle text-dark">{{ count($faqs) }} Items</span>
        </div>

        <div class="p-3">
          <div class="accordion" id="adminFaqAccordion">
            @forelse($faqs as $idx => $fq)
              <div class="accordion-item mb-2 border rounded-3 overflow-hidden">
                <h3 class="accordion-header" id="heading{{ $idx }}">
                  <button class="accordion-button collapsed py-2 px-3 small fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#adminCollapse{{ $idx }}">
                    <span class="me-2 text-primary">#{{ $fq->display_order }}.</span> {{ $fq->question_en }}
                  </button>
                </h3>
                <div id="adminCollapse{{ $idx }}" class="accordion-collapse collapse" data-bs-parent="#adminFaqAccordion">
                  <div class="accordion-body p-3 small text-muted bg-light">
                    <div class="fw-semibold text-dark mb-1">বাংলা প্রশ্ন: {{ $fq->question_bn }}</div>
                    <div class="mb-2"><strong>Answer (EN):</strong> {{ $fq->answer_en }}</div>
                    <div class="mb-3"><strong>উত্তর (BN):</strong> {{ $fq->answer_bn }}</div>
                    <div class="d-flex justify-content-end gap-2">
                      <button type="button" class="btn btn-sm btn-outline-primary py-1 px-2" data-bs-toggle="modal" data-bs-target="#editFaqModal{{ $fq->id }}">
                        <i class="bi bi-pencil-square me-1"></i> Edit
                      </button>
                      <form action="{{ route('admin.faqs.destroy', $fq->id) }}" method="POST" onsubmit="return confirm('Delete this FAQ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2">
                          <i class="bi bi-trash me-1"></i> Delete
                        </button>
                      </form>
                    </div>

                    {{-- Edit FAQ Modal --}}
                    <div class="modal fade text-start" id="editFaqModal{{ $fq->id }}" tabindex="-1" aria-labelledby="editFaqLabel{{ $fq->id }}" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content rounded-4 border-0 shadow">
                          <form action="{{ route('admin.faqs.update', $fq->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header bg-light py-3 px-4 border-bottom">
                              <h5 class="modal-title fs-6 fw-bold text-dark" id="editFaqLabel{{ $fq->id }}">
                                <i class="bi bi-pencil-square text-primary me-2"></i>Edit FAQ Item
                              </h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                              <div class="mb-3">
                                <label class="form-label small fw-semibold">Question (English) <span class="text-danger">*</span></label>
                                <input type="text" name="question_en" class="form-control form-control-sm" value="{{ $fq->question_en }}" required>
                              </div>

                              <div class="mb-3">
                                <label class="form-label small fw-semibold">Question (বাংলা) <span class="text-danger">*</span></label>
                                <input type="text" name="question_bn" class="form-control form-control-sm" value="{{ $fq->question_bn }}" required>
                              </div>

                              <div class="mb-3">
                                <label class="form-label small fw-semibold">Answer (English) <span class="text-danger">*</span></label>
                                <textarea name="answer_en" class="form-control form-control-sm" rows="3" required>{{ $fq->answer_en }}</textarea>
                              </div>

                              <div class="mb-3">
                                <label class="form-label small fw-semibold">Answer (বাংলা) <span class="text-danger">*</span></label>
                                <textarea name="answer_bn" class="form-control form-control-sm" rows="3" required>{{ $fq->answer_bn }}</textarea>
                              </div>

                              <div class="row g-2 align-items-center">
                                <div class="col-6">
                                  <label class="form-label small fw-semibold">Display Order</label>
                                  <input type="number" name="display_order" class="form-control form-control-sm" value="{{ $fq->display_order }}" min="1">
                                </div>
                                <div class="col-6 pt-3">
                                  <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="faq_active_{{ $fq->id }}" name="is_active" value="1" {{ $fq->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label small fw-semibold" for="faq_active_{{ $fq->id }}">Active / Visible</label>
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
                </div>
              </div>
            @empty
              <div class="text-center py-4 text-muted small">No FAQs added yet.</div>
            @endforelse
          </div>
        </div>
      </div>
    </div>

    {{-- Right: Add FAQ Form --}}
    <div class="col-lg-5">
      <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 border-bottom">
          <h2 class="fs-6 fw-bold mb-0 text-dark brand-font"><i class="bi bi-plus-circle text-success me-2"></i>Add New FAQ</h2>
        </div>
        <div class="card-body p-4">
          <form action="{{ route('admin.faqs.store') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label class="form-label small fw-semibold">Question (English) <span class="text-danger">*</span></label>
              <input type="text" name="question_en" class="form-control form-control-sm" placeholder="e.g. How do I reserve a serial?" required>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">Question (বাংলা) <span class="text-danger">*</span></label>
              <input type="text" name="question_bn" class="form-control form-control-sm" placeholder="e.g. আমি কীভাবে সিরিয়াল বুক করব?" required>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">Answer (English) <span class="text-danger">*</span></label>
              <textarea name="answer_en" class="form-control form-control-sm" rows="3" placeholder="Provide full answer..." required></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">Answer (বাংলা) <span class="text-danger">*</span></label>
              <textarea name="answer_bn" class="form-control form-control-sm" rows="3" placeholder="পূর্ণাঙ্গ উত্তর লিখুন..." required></textarea>
            </div>

            <div class="row g-2 mb-3 align-items-center">
              <div class="col-6">
                <label class="form-label small fw-semibold">Display Order</label>
                <input type="number" name="display_order" class="form-control form-control-sm" value="{{ count($faqs) + 1 }}" min="1">
              </div>
              <div class="col-6 pt-3">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                  <label class="form-check-label small fw-semibold" for="is_active">Active</label>
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-success w-100 fw-bold">
              <i class="bi bi-plus-circle-fill me-1"></i> Save FAQ
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

