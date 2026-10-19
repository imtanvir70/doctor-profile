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
                <textarea name="excerpt" id="singleExcerptInput" class="form-control" rows="2" placeholder="পোস্টের সারসংক্ষেপ (খালি রাখলে প্রথম ১৬০ অক্ষর স্বয়ংক্রিয়ভাবে নেওয়া হবে)...">{{ $singleExcerpt }}</textarea>
                <div class="form-text small text-muted" style="font-size: 0.75rem;">খালি রাখলে ব্লগ কন্টেন্ট থেকে প্রথম কয়েক লাইন সারাংশ হিসেবে ব্যবহৃত হবে।</div>
              </div>

              <div class="mb-4">
                <label class="form-label small fw-semibold text-dark">
                  Full Blog Content (বিস্তারিত ব্লগ কন্টেন্ট) <span class="text-danger">*</span>
                </label>
                <textarea name="content" id="singleContentEditor" class="form-control" rows="12">{{ $singleContent }}</textarea>
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
                    <label class="form-label small fw-semibold text-dark">বিস্তারিত ব্লগ কন্টেন্ট (বাংলা) <span class="text-danger">*</span></label>
                    <textarea name="content_bn" id="contentBnEditor" class="form-control" rows="10">{{ old('content_bn', $article->content_bn) }}</textarea>
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
                    <label class="form-label small fw-semibold text-dark">Full Blog Content (English) <span class="text-danger">*</span></label>
                    <textarea name="content_en" id="contentEnEditor" class="form-control" rows="10">{{ old('content_en', $article->content_en) }}</textarea>
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

          {{-- Sticky / Prominent Action Footer --}}
          <div class="card-footer bg-light py-3 px-4 d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="d-flex align-items-center gap-2">
              <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary">
                Cancel
              </a>
              <button type="button" id="manualSaveDraftBtn" class="btn btn-outline-primary d-inline-flex align-items-center gap-2">
                <i class="bi bi-file-earmark-check"></i>
                <span>Save Draft (ড্রাফট রাখুন)</span>
              </button>
            </div>

            <div class="d-flex align-items-center gap-2">
              <button type="button" id="publishPostBtn" class="btn btn-success px-4 fw-bold shadow-sm d-inline-flex align-items-center gap-2">
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
  <style>
    /* CKEditor Custom Styling */
    .ck-editor__editable_inline {
      min-height: 380px !important;
      font-size: 1rem;
      line-height: 1.7;
      color: #1e293b;
      padding: 1.25rem !important;
      border-bottom-left-radius: 8px !important;
      border-bottom-right-radius: 8px !important;
    }
    .ck.ck-toolbar {
      border-top-left-radius: 8px !important;
      border-top-right-radius: 8px !important;
      background: #f8fafc !important;
      border-color: #cbd5e1 !important;
    }
    .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
      border-color: #cbd5e1 !important;
    }
    .ck.ck-editor__main>.ck-editor__editable.ck-focused {
      border-color: #0d9488 !important;
      box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15) !important;
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
  {{-- Load CKEditor 5 Classic from Official CDN --}}
  <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
  <script>
    (function() {
      var editorSingleInstance = null;
      var editorBnInstance = null;
      var editorEnInstance = null;

      var ckConfig = {
        toolbar: [
          'heading', '|',
          'bold', 'italic', 'underline', 'strikethrough', '|',
          'bulletedList', 'numberedList', '|',
          'blockQuote', 'insertTable', 'link', '|',
          'undo', 'redo'
        ],
        heading: {
          options: [
            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
            { model: 'heading2', view: 'h2', title: 'Heading 2 (H2)', class: 'ck-heading_heading2' },
            { model: 'heading3', view: 'h3', title: 'Heading 3 (H3)', class: 'ck-heading_heading3' },
            { model: 'heading4', view: 'h4', title: 'Heading 4 (H4)', class: 'ck-heading_heading4' }
          ]
        }
      };

      // 1. Initialize CKEditor for Single Content
      var singleEl = document.querySelector('#singleContentEditor');
      if (singleEl) {
        ClassicEditor.create(singleEl, ckConfig).then(function(editor) {
          editorSingleInstance = editor;
        }).catch(function(err) {
          console.error('CKEditor Single Error:', err);
        });
      }

      // 2. Initialize CKEditor for Bengali & English Content
      var bnEl = document.querySelector('#contentBnEditor');
      if (bnEl) {
        ClassicEditor.create(bnEl, ckConfig).then(function(editor) {
          editorBnInstance = editor;
        }).catch(function(err) {
          console.error('CKEditor BN Error:', err);
        });
      }

      var enEl = document.querySelector('#contentEnEditor');
      if (enEl) {
        ClassicEditor.create(enEl, ckConfig).then(function(editor) {
          editorEnInstance = editor;
        }).catch(function(err) {
          console.error('CKEditor EN Error:', err);
        });
      }

      // 3. Multi-language toggle handler
      var multiLangSwitch = document.getElementById('multiLangSwitch');
      var singleSection = document.getElementById('singleLangSection');
      var multiSection = document.getElementById('multiLangSection');

      if (multiLangSwitch) {
        multiLangSwitch.addEventListener('change', function() {
          var isChecked = this.checked;
          var label = this.nextElementSibling;
          if (label) {
            label.textContent = isChecked ? 'Enabled' : 'Disabled';
          }

          if (isChecked) {
            singleSection.classList.add('d-none');
            multiSection.classList.remove('d-none');

            // Copy single values to BN if BN is empty
            var sTitle = document.getElementById('singleTitleInput').value;
            var bnTitle = document.getElementById('titleBnInput');
            if (bnTitle && !bnTitle.value && sTitle) {
              bnTitle.value = sTitle;
            }

            var sExcerpt = document.getElementById('singleExcerptInput').value;
            var bnExcerpt = document.getElementById('excerptBnInput');
            if (bnExcerpt && !bnExcerpt.value && sExcerpt) {
              bnExcerpt.value = sExcerpt;
            }

            if (editorSingleInstance && editorBnInstance && !editorBnInstance.getData()) {
              editorBnInstance.setData(editorSingleInstance.getData());
            }
          } else {
            multiSection.classList.add('d-none');
            singleSection.classList.remove('d-none');

            // Copy BN values back to Single if Single is empty
            var bnTitleVal = document.getElementById('titleBnInput') ? document.getElementById('titleBnInput').value : '';
            var sTitleEl = document.getElementById('singleTitleInput');
            if (sTitleEl && !sTitleEl.value && bnTitleVal) {
              sTitleEl.value = bnTitleVal;
            }

            if (editorBnInstance && editorSingleInstance && !editorSingleInstance.getData()) {
              editorSingleInstance.setData(editorBnInstance.getData());
            }
          }
        });
      }

      // 4. Sync CKEditor data to underlying textareas
      function syncEditors() {
        if (editorSingleInstance) {
          document.querySelector('#singleContentEditor').value = editorSingleInstance.getData();
        }
        if (editorBnInstance) {
          document.querySelector('#contentBnEditor').value = editorBnInstance.getData();
        }
        if (editorEnInstance) {
          document.querySelector('#contentEnEditor').value = editorEnInstance.getData();
        }
      }

      // 5. Check if editor is blank
      function getActiveContent() {
        syncEditors();
        var isMulti = multiLangSwitch && multiLangSwitch.checked;
        if (isMulti) {
          var bnT = document.getElementById('titleBnInput') ? document.getElementById('titleBnInput').value.trim() : '';
          var enT = document.getElementById('titleEnInput') ? document.getElementById('titleEnInput').value.trim() : '';
          var bnC = editorBnInstance ? editorBnInstance.getData().trim() : '';
          var enC = editorEnInstance ? editorEnInstance.getData().trim() : '';
          return {
            title: bnT || enT,
            content: bnC || enC,
            isMulti: true
          };
        } else {
          var title = document.getElementById('singleTitleInput') ? document.getElementById('singleTitleInput').value.trim() : '';
          var content = editorSingleInstance ? editorSingleInstance.getData().trim() : '';
          return {
            title: title,
            content: content,
            isMulti: false
          };
        }
      }

      // 6. Autosave every 30 seconds
      var lastSavedContentHash = '';
      var isAutosaving = false;

      function triggerAutosave() {
        if (isAutosaving) return;

        var active = getActiveContent();
        var cleanContent = active.content.replace(/<[^>]*>?/gm, '').trim();

        // If completely blank (no title and no text), skip autosave
        if (!active.title && !cleanContent) {
          var badge = document.getElementById('autosaveStatusBadge');
          var text = document.getElementById('autosaveStatusText');
          if (text) text.textContent = 'Auto-save paused (empty)';
          return;
        }

        var currentHash = active.title + '|' + active.content;
        if (currentHash === lastSavedContentHash) {
          // No changes since last save
          return;
        }

        isAutosaving = true;
        var badgeText = document.getElementById('autosaveStatusText');
        if (badgeText) {
          badgeText.innerHTML = '<span class="spinner-border spinner-border-sm text-primary me-1" role="status"></span> Saving draft...';
        }

        var formData = new FormData();
        var csrfToken = document.querySelector('input[name="_token"]').value;
        formData.append('_token', csrfToken);

        var articleId = document.getElementById('articleIdInput').value;
        if (articleId) {
          formData.append('id', articleId);
        }

        if (active.isMulti) {
          formData.append('title_bn', document.getElementById('titleBnInput').value);
          formData.append('title_en', document.getElementById('titleEnInput').value);
          formData.append('excerpt_bn', document.getElementById('excerptBnInput').value);
          formData.append('excerpt_en', document.getElementById('excerptEnInput').value);
          formData.append('content_bn', editorBnInstance ? editorBnInstance.getData() : '');
          formData.append('content_en', editorEnInstance ? editorEnInstance.getData() : '');
        } else {
          formData.append('title', document.getElementById('singleTitleInput').value);
          formData.append('excerpt', document.getElementById('singleExcerptInput').value);
          formData.append('content', editorSingleInstance ? editorSingleInstance.getData() : '');
        }

        var category = document.getElementById('blogCategoryInput') ? document.getElementById('blogCategoryInput').value : 'Preventive Health';
        var readTime = document.getElementById('blogReadTimeInput') ? document.getElementById('blogReadTimeInput').value : '5 min read';
        formData.append('category', category);
        formData.append('read_time', readTime);

        fetch('{{ route("admin.articles.autosave") }}', {
          method: 'POST',
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
          },
          body: formData
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
          isAutosaving = false;
          if (data.success) {
            lastSavedContentHash = currentHash;
            if (data.id && !document.getElementById('articleIdInput').value) {
              document.getElementById('articleIdInput').value = data.id;
              // Smoothly update browser URL without reload
              if (window.history && window.history.replaceState) {
                var editUrl = '{{ url("/admin/articles") }}/' + data.id + '/edit';
                window.history.replaceState({}, '', editUrl);
              }
            }
            if (badgeText) {
              badgeText.innerHTML = '<i class="bi bi-check-circle-fill text-success me-1"></i> Draft saved at ' + (data.saved_at || 'just now');
            }
          } else {
            if (badgeText) {
              badgeText.textContent = data.message || 'Auto-save skipped';
            }
          }
        })
        .catch(function(err) {
          isAutosaving = false;
          console.warn('Autosave notice:', err);
          if (badgeText) {
            badgeText.textContent = 'Auto-save retry in 30s';
          }
        });
      }

      // Start 30s timer
      var autosaveTimer = setInterval(triggerAutosave, 30000);

      // 7. Manual Save Draft Button
      var manualDraftBtn = document.getElementById('manualSaveDraftBtn');
      if (manualDraftBtn) {
        manualDraftBtn.addEventListener('click', function() {
          syncEditors();
          document.getElementById('submitActionInput').value = 'draft';
          document.getElementById('blogPostForm').submit();
        });
      }

      // 8. Publish Button (Explicit Publish Action)
      var publishBtn = document.getElementById('publishPostBtn');
      if (publishBtn) {
        publishBtn.addEventListener('click', function() {
          syncEditors();
          var active = getActiveContent();
          if (!active.title) {
            alert('Please enter a blog post title before publishing.');
            return;
          }
          document.getElementById('submitActionInput').value = 'publish';
          document.getElementById('blogPostForm').submit();
        });
      }

      // On direct form submit, sync editor data
      var form = document.getElementById('blogPostForm');
      if (form) {
        form.addEventListener('submit', function() {
          syncEditors();
        });
      }
    })();
  </script>
@endpush
