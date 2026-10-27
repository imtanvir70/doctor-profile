@extends('layouts.admin')

@section('title', $article->exists ? 'Edit Blog Post: ' . ($article->title_en ?: $article->title_bn) : 'Write New Blog Post')
@section('page_heading', $article->exists ? 'Edit Blog Post' : 'Write New Blog Post')

@section('content')
  @php
    $hasDiffLangs = ($article->exists && ($article->title_en !== $article->title_bn || $article->content_en !== $article->content_bn) && !empty($article->title_en) && !empty($article->title_bn));
    $singleTitle = old('title', $article->title_bn ?: $article->title_en);
    $singleExcerpt = old('excerpt', $article->excerpt_bn ?: $article->excerpt_en);
    $singleContent = old('content', $article->content_bn ?: $article->content_en);
  @endphp

  <div class="row justify-content-center">
    <div class="col-lg-10 col-xl-9">
      <form id="blogPostForm" action="{{ $article->exists ? route('admin.articles.update', $article->id) : route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($article->exists)
          @method('PUT')
        @endif

        <input type="hidden" name="id" id="articleIdInput" value="{{ $article->id ?? '' }}">
        <input type="hidden" name="submit_action" id="submitActionInput" value="publish">

        <div class="card border-0 shadow-sm rounded-4 mb-4">
          {{-- Header Bar with Autosave Status & Back Link --}}
          <div class="card-header bg-white py-3 px-4 border-bottom d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-2">
              <a href="{{ route('admin.articles.index') }}" class="btn btn-sm btn-outline-secondary rounded-circle" style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;" title="Back to Blog Posts">
                <i class="bi bi-arrow-left"></i>
              </a>
              <div>
                <h2 class="fs-6 fw-bold mb-0 text-dark brand-font d-flex align-items-center gap-2">
                  <i class="bi bi-pencil-square text-primary"></i>
                  <span>{{ $article->exists ? 'Edit Blog Post' : 'Write New Blog Post' }}</span>
                </h2>
                <div class="text-muted" style="font-size: 0.76rem;">
                  @if($article->exists)
                    Status: <span class="badge {{ $article->is_published ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning-emphasis' }}">{{ $article->is_published ? 'Published' : 'Draft' }}</span>
                  @else
                    Status: <span class="badge bg-secondary-subtle text-secondary">New Draft</span>
                  @endif
                </div>
              </div>
            </div>

            {{-- 30s Autosave Status Indicator --}}
            <div class="d-flex align-items-center gap-2">
              <div id="autosaveStatusBadge" class="d-inline-flex align-items-center gap-2 small px-3 py-1 rounded-pill bg-light border text-muted" style="font-size: 0.8rem;">
                <i class="bi bi-clock-history text-secondary"></i>
                <span id="autosaveStatusText">Auto-save active (30s)</span>
              </div>
            </div>
          </div>

          <div class="card-body p-4">
            @if ($errors->any())
              <div class="alert alert-danger rounded-3 mb-4">
                <div class="fw-bold small mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Please check the form errors:</div>
                <ul class="mb-0 small ps-3">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            {{-- Multi-language Switch Toggle --}}
            <div class="p-3 mb-4 rounded-3 bg-light border d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2">
              <div>
                <div class="fw-bold text-dark small d-flex align-items-center gap-2">
                  <i class="bi bi-translate text-primary"></i>
                  <span>Multi-Language Option (ঐচ্ছিক দ্বি-ভাষিক সুবিধা)</span>
                </div>
                <div class="text-muted" style="font-size: 0.78rem;">
                  ডিফল্টভাবে একটি ভাষায় পোস্ট লিখলেই চলবে। বাংলা ও ইংরেজি আলাদা করতে চাইলে টগল অন করুন।
                </div>
              </div>
              <div class="form-check form-switch m-0">
                <input class="form-check-input" type="checkbox" id="multiLangSwitch" name="has_multilang" value="1" {{ old('has_multilang', $hasDiffLangs) ? 'checked' : '' }} style="cursor: pointer; width: 2.8em; height: 1.4em;">
                <label class="form-check-label small fw-semibold ms-1" for="multiLangSwitch" style="cursor: pointer;">
                  {{ old('has_multilang', $hasDiffLangs) ? 'Enabled' : 'Disabled' }}
                </label>
              </div>
            </div>

            {{-- SECTION 1: Single Language Form (Default) --}}
            <div id="singleLangSection" class="{{ old('has_multilang', $hasDiffLangs) ? 'd-none' : '' }}">
              <div class="mb-3">
                <label class="form-label small fw-semibold text-dark">
                  Blog Post Title <span class="text-danger">*</span>
                </label>
                <input type="text" name="title" id="singleTitleInput" class="form-control form-control-lg fw-bold" placeholder="যেমন: ডায়াবেটিস নিয়ন্ত্রণে দৈনন্দিন জীবনযাপনের ৫টি নিয়ম..." value="{{ $singleTitle }}">
              </div>

              <div class="mb-3">
                <label class="form-label small fw-semibold text-dark">
                  Short Summary / Excerpt (সংক্ষিপ্ত বিবরণী)
                </label>
                <textarea name="excerpt" id="singleExcerptInput" class="form-control" rows="2" placeholder="পোস্টের সারসংক্ষেপ (খালি রাখলে কন্টেন্ট থেকে প্রথম ১৬০ অক্ষর স্বয়ংক্রিয়ভাবে নেওয়া হবে)...">{{ $singleExcerpt }}</textarea>
                <div class="form-text small text-muted" style="font-size: 0.75rem;">খালি রাখলে ব্লগ কন্টেন্ট থেকে প্রথম কয়েক লাইন সারাংশ হিসেবে ব্যবহৃত হবে।</div>
              </div>

              <div class="mb-4">
                <label class="form-label small fw-semibold text-dark d-flex align-items-center justify-content-between">
                  <span>Full Blog Content (Summernote Editor) <span class="text-danger">*</span></span>
                  <span class="badge bg-light text-secondary border small"><i class="bi bi-file-richtext me-1"></i>Summernote Active</span>
                </label>
                <textarea name="content" id="singleContentEditor" class="form-control summernote-area">{{ $singleContent }}</textarea>
              </div>
            </div>

            {{-- SECTION 2: Multi-Language Tabs (Optional) --}}
            <div id="multiLangSection" class="{{ old('has_multilang', $hasDiffLangs) ? '' : 'd-none' }}">
              <ul class="nav nav-pills mb-3 gap-2" id="langTabs" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active px-4 py-2 fw-semibold" id="tab-bn-btn" data-bs-toggle="pill" data-bs-target="#tab-bn-pane" type="button" role="tab">
                    <i class="bi bi-flag-fill me-1 text-danger"></i> বাংলা সংস্করণ (Bengali)
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link px-4 py-2 fw-semibold" id="tab-en-btn" data-bs-toggle="pill" data-bs-target="#tab-en-pane" type="button" role="tab">
                    <i class="bi bi-globe me-1 text-primary"></i> English Version
                  </button>
                </li>
              </ul>

              <div class="tab-content border rounded-3 p-3 bg-white mb-4">
                {{-- Bengali Tab Pane --}}
                <div class="tab-pane fade show active" id="tab-bn-pane" role="tabpanel">
                  <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">ব্লগের শিরোনাম (বাংলা) <span class="text-danger">*</span></label>
                    <input type="text" name="title_bn" id="titleBnInput" class="form-control fw-bold" placeholder="বাংলায় ব্লগের শিরোনাম লিখুন..." value="{{ old('title_bn', $article->title_bn) }}">
                  </div>
                  <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">সংক্ষিপ্ত সারসংক্ষেপ (বাংলা)</label>
                    <textarea name="excerpt_bn" id="excerptBnInput" class="form-control" rows="2" placeholder="বাংলায় সংক্ষিপ্ত সারাংশ...">{{ old('excerpt_bn', $article->excerpt_bn) }}</textarea>
                  </div>
                  <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">বিস্তারিত ব্লগ কন্টেন্ট (বাংলা - Summernote) <span class="text-danger">*</span></label>
                    <textarea name="content_bn" id="contentBnEditor" class="form-control summernote-area">{{ old('content_bn', $article->content_bn) }}</textarea>
                  </div>
                </div>

                {{-- English Tab Pane --}}
                <div class="tab-pane fade" id="tab-en-pane" role="tabpanel">
                  <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">Blog Title (English) <span class="text-danger">*</span></label>
                    <input type="text" name="title_en" id="titleEnInput" class="form-control fw-bold" placeholder="Enter blog title in English..." value="{{ old('title_en', $article->title_en) }}">
                  </div>
                  <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">Short Excerpt (English)</label>
                    <textarea name="excerpt_en" id="excerptEnInput" class="form-control" rows="2" placeholder="Short excerpt in English...">{{ old('excerpt_en', $article->excerpt_en) }}</textarea>
                  </div>
                  <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">Full Blog Content (English - Summernote) <span class="text-danger">*</span></label>
                    <textarea name="content_en" id="contentEnEditor" class="form-control summernote-area">{{ old('content_en', $article->content_en) }}</textarea>
                  </div>
                </div>
              </div>
            </div>

            {{-- Metadata & Publishing Options --}}
            <div class="row g-3 pt-3 border-top">
              <div class="col-md-6">
                <label class="form-label small fw-semibold text-dark">Category / Topic <span class="text-danger">*</span></label>
                <select name="category" id="blogCategoryInput" class="form-select" required>
                  <option value="Preventive Health" {{ old('category', $article->category) == 'Preventive Health' ? 'selected' : '' }}>Preventive Health / Lifestyle</option>
                  <option value="Endocrine & Thyroid" {{ old('category', $article->category) == 'Endocrine & Thyroid' ? 'selected' : '' }}>Endocrine & Thyroid</option>
                  <option value="Cardiovascular" {{ old('category', $article->category) == 'Cardiovascular' ? 'selected' : '' }}>Cardiovascular & Heart</option>
                  <option value="Infectious Diseases" {{ old('category', $article->category) == 'Infectious Diseases' ? 'selected' : '' }}>Infectious Diseases & Fever</option>
                  <option value="Gastro & Liver" {{ old('category', $article->category) == 'Gastro & Liver' ? 'selected' : '' }}>Gastro & Liver Care</option>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold text-dark">Estimated Read Time</label>
                <input type="text" name="read_time" id="blogReadTimeInput" class="form-control" placeholder="e.g. 5 min read" value="{{ old('read_time', $article->read_time ?? '5 min read') }}">
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold text-dark">Featured Thumbnail Image</label>
                @if(!empty($article->featured_image))
                  <div class="mb-2">
                    <img src="{{ $article->featured_image }}" alt="Thumbnail" style="height: 70px; border-radius: 8px; border: 1px solid #e2e8f0; object-fit: cover;">
                  </div>
                @endif
                <input type="file" name="featured_image_file" class="form-control" accept="image/*">
                <div class="form-text small text-muted" style="font-size: 0.75rem;">JPG, PNG, WebP up to 4MB.</div>
              </div>

              <div class="col-md-6 pt-md-4">
                <div class="form-check form-switch mb-2">
                  <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $article->is_featured) ? 'checked' : '' }}>
                  <label class="form-check-label fw-semibold small" for="is_featured">Set as Lead Featured Column (বড় হাইলাইট কলাম)</label>
                </div>
                <div class="text-muted small" style="font-size: 0.78rem;">
                  <i class="bi bi-info-circle me-1"></i> ব্লগে অটো-সেভ প্রতি ৩০ সেকেন্ড পর পর স্বয়ংক্রিয়ভাবে ড্রাফট হিসেবে সংরক্ষণ করবে।
                </div>
              </div>
            </div>
          </div>

          {{-- Action Footer --}}
          <div class="card-footer bg-light py-3 px-3 px-md-4 d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center justify-content-between gap-2">
            <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-2">
              <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary">
                Cancel
              </a>
              <button type="button" id="manualSaveDraftBtn" class="btn btn-outline-primary d-inline-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-file-earmark-check"></i>
                <span>Save Draft (ড্রাফট রাখুন)</span>
              </button>
            </div>

            <div class="d-flex align-items-center gap-2">
              <button type="button" id="publishPostBtn" class="btn btn-success px-4 fw-bold shadow-sm d-inline-flex align-items-center justify-content-center gap-2 w-100 w-sm-auto">
                <i class="bi bi-send-check-fill"></i>
                <span>Publish Now (লাইভ প্রকাশ করুন)</span>
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('styles')
  {{-- Summernote Bootstrap 5 CSS --}}
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet">
  <style>
    /* Summernote Modern Custom Styling */
    .note-editor.note-frame {
      border-radius: 8px !important;
      border: 1px solid #cbd5e1 !important;
      box-shadow: 0 1px 2px rgba(0,0,0,0.03);
      background: #ffffff;
    }
    .note-editor.note-frame.focus,
    .note-editor.note-frame:focus-within {
      border-color: #0d9488 !important;
      box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15) !important;
    }
    .note-toolbar {
      background: #f8fafc !important;
      border-bottom: 1px solid #e2e8f0 !important;
      padding: 8px 12px !important;
      border-top-left-radius: 7px !important;
      border-top-right-radius: 7px !important;
    }
    .note-editable {
      font-size: 1rem !important;
      line-height: 1.75 !important;
      color: #1e293b !important;
      min-height: 380px !important;
      padding: 1.25rem !important;
      background: #ffffff !important;
    }
    .note-btn {
      background: #ffffff !important;
      border: 1px solid #cbd5e1 !important;
      color: #334155 !important;
      font-size: 0.85rem !important;
    }
    .note-btn:hover {
      background: #f1f5f9 !important;
      color: #0f172a !important;
    }
    .nav-pills .nav-link.active {
      background-color: var(--admin-accent, #0d9488) !important;
      color: #ffffff !important;
    }
    .nav-pills .nav-link {
      color: #475569;
      background-color: #f1f5f9;
      border-radius: 8px;
    }
  </style>
@endpush

@push('scripts')
  {{-- jQuery & Summernote Bootstrap 5 JS --}}
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>
  <script>
    $(document).ready(function() {
      // 1. Initialize Summernote on all blog editor areas
      var summernoteOptions = {
        placeholder: 'ব্লগের পূর্ণাঙ্গ কন্টেন্ট লিখুন...',
        tabsize: 2,
        height: 380,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'italic', 'underline', 'clear']],
          ['fontname', ['fontname']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video', 'hr']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ],
        callbacks: {
          onChange: function() {
            // Automatically updates underlying textarea value
          }
        }
      };

      $('#singleContentEditor').summernote(summernoteOptions);
      $('#contentBnEditor').summernote(summernoteOptions);
      $('#contentEnEditor').summernote(summernoteOptions);

      // 2. Multi-language toggle handler
      $('#multiLangSwitch').on('change', function() {
        var isChecked = $(this).is(':checked');
        var label = $(this).siblings('label');
        if (label.length) {
          label.text(isChecked ? 'Enabled' : 'Disabled');
        }

        if (isChecked) {
          $('#singleLangSection').addClass('d-none');
          $('#multiLangSection').removeClass('d-none');

          var sTitle = $('#singleTitleInput').val();
          if (!$('#titleBnInput').val() && sTitle) {
            $('#titleBnInput').val(sTitle);
          }

          var sExcerpt = $('#singleExcerptInput').val();
          if (!$('#excerptBnInput').val() && sExcerpt) {
            $('#excerptBnInput').val(sExcerpt);
          }

          var sCode = $('#singleContentEditor').summernote('code');
          if (isEditorEmpty('#contentBnEditor') && !isEditorEmpty('#singleContentEditor')) {
            $('#contentBnEditor').summernote('code', sCode);
          }
        } else {
          $('#multiLangSection').addClass('d-none');
          $('#singleLangSection').removeClass('d-none');

          var bnTitle = $('#titleBnInput').val();
          if (!$('#singleTitleInput').val() && bnTitle) {
            $('#singleTitleInput').val(bnTitle);
          }

          var bnCode = $('#contentBnEditor').summernote('code');
          if (isEditorEmpty('#singleContentEditor') && !isEditorEmpty('#contentBnEditor')) {
            $('#singleContentEditor').summernote('code', bnCode);
          }
        }
      });

      // Helper to check if a summernote editor is blank
      function isEditorEmpty(selector) {
        var code = $(selector).summernote('code');
        var text = $('<div>').html(code).text().trim();
        var hasMedia = code.indexOf('<img') !== -1 || code.indexOf('<iframe') !== -1;
        return !text && !hasMedia;
      }

      function getActiveContent() {
        var isMulti = $('#multiLangSwitch').is(':checked');
        if (isMulti) {
          var bnT = ($('#titleBnInput').val() || '').trim();
          var enT = ($('#titleEnInput').val() || '').trim();
          var bnC = $('#contentBnEditor').summernote('code');
          var enC = $('#contentEnEditor').summernote('code');
          var emptyBn = isEditorEmpty('#contentBnEditor');
          var emptyEn = isEditorEmpty('#contentEnEditor');
          return {
            title: bnT || enT,
            content: (!emptyBn ? bnC : (!emptyEn ? enC : '')),
            isMulti: true,
            isEmpty: !bnT && !enT && emptyBn && emptyEn
          };
        } else {
          var title = ($('#singleTitleInput').val() || '').trim();
          var content = $('#singleContentEditor').summernote('code');
          var empty = isEditorEmpty('#singleContentEditor');
          return {
            title: title,
            content: !empty ? content : '',
            isMulti: false,
            isEmpty: !title && empty
          };
        }
      }

      // 3. 30-Second Auto-save Logic
      var lastSavedHash = '';
      var isAutosaving = false;

      function triggerAutosave() {
        if (isAutosaving) return;

        var active = getActiveContent();

        // If blank, skip autosave
        if (active.isEmpty) {
          $('#autosaveStatusText').text('Auto-save paused (empty)');
          return;
        }

        var currentHash = active.title + '|' + active.content;
        if (currentHash === lastSavedHash) {
          return; // No changes
        }

        isAutosaving = true;
        $('#autosaveStatusText').html('<span class="spinner-border spinner-border-sm text-primary me-1" role="status"></span> Saving draft...');

        var formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        var articleId = $('#articleIdInput').val();
        if (articleId) {
          formData.append('id', articleId);
        }

        if (active.isMulti) {
          formData.append('title_bn', $('#titleBnInput').val());
          formData.append('title_en', $('#titleEnInput').val());
          formData.append('excerpt_bn', $('#excerptBnInput').val());
          formData.append('excerpt_en', $('#excerptEnInput').val());
          formData.append('content_bn', $('#contentBnEditor').summernote('code'));
          formData.append('content_en', $('#contentEnEditor').summernote('code'));
        } else {
          formData.append('title', $('#singleTitleInput').val());
          formData.append('excerpt', $('#singleExcerptInput').val());
          formData.append('content', $('#singleContentEditor').summernote('code'));
        }

        formData.append('category', $('#blogCategoryInput').val() || 'Preventive Health');
        formData.append('read_time', $('#blogReadTimeInput').val() || '5 min read');

        $.ajax({
          url: '{{ route("admin.articles.autosave") }}',
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'json',
          success: function(data) {
            isAutosaving = false;
            if (data.success) {
              lastSavedHash = currentHash;
              if (data.id && !$('#articleIdInput').val()) {
                $('#articleIdInput').val(data.id);
                if (window.history && window.history.replaceState) {
                  var editUrl = '{{ url("/admin/articles") }}/' + data.id + '/edit';
                  window.history.replaceState({}, '', editUrl);
                }
              }
              $('#autosaveStatusText').html('<i class="bi bi-check-circle-fill text-success me-1"></i> Draft saved at ' + (data.saved_at || 'just now'));
            } else {
              $('#autosaveStatusText').text(data.message || 'Auto-save skipped');
            }
          },
          error: function(xhr) {
            isAutosaving = false;
            console.warn('Autosave notice:', xhr);
            $('#autosaveStatusText').text('Auto-save retry in 30s');
          }
        });
      }

      // Start 30s interval
      setInterval(triggerAutosave, 30000);

      // 4. Manual Save Draft Button
      $('#manualSaveDraftBtn').on('click', function() {
        $('#submitActionInput').val('draft');
        $('#blogPostForm').submit();
      });

      // 5. Publish Now Button
      $('#publishPostBtn').on('click', function() {
        var active = getActiveContent();
        if (!active.title) {
          alert('Please enter a blog post title before publishing.');
          return;
        }
        $('#submitActionInput').val('publish');
        $('#blogPostForm').submit();
      });
    });
  </script>
@endpush
