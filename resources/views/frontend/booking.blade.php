@extends('layouts.app')

@section('content')
  <section class="hero-booking-banner">
    <div class="container">
      <div class="text-center banner-hero-wrapper mx-auto">
        <div class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold mb-3 d-inline-flex align-items-center gap-2">
          <i class="bi bi-shield-check fs-6"></i>
          <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'চেম্বার প্রায়োরিটি সিরিয়াল' : 'Priority Chamber Reservation' }}</span>
        </div>
        <h1 class="display-5 fw-extrabold mb-3">
          {{ ($locale ?? app()->getLocale()) === 'bn' ? 'অনলাইন চেম্বার সিরিয়াল বুকিং' : 'Instant Chamber Serial Booking' }}
        </h1>
        <p class="fs-5 text-muted mb-0 mx-auto" style="max-width: 760px;">
          {{ ($locale ?? app()->getLocale()) === 'bn' ? 'সহজ ফর্ম পূরণ করে আপনার সিরিয়াল নিশ্চিত করুন। আমাদের চেম্বার প্রতিনিধি দ্রুততম সময়ে আপনার সাথে যোগাযোগ করবেন।' : 'Fast verification and direct serial confirmation with chamber staff. Fill in your details below to secure your consultation appointment.' }}
        </p>
      </div>
    </div>
  </section>

  <section class="py-5" id="bookingFormSection">
    <div class="container py-lg-4">
      <div class="row g-5 align-items-center justify-content-center">
        <div class="col-lg-5">
          <div class="d-flex flex-column gap-4 mb-4">
            <div class="d-flex align-items-start gap-3">
              <div class="clinical-icon clinical-icon-emerald flex-shrink-0">
                <i class="bi bi-lightning-charge-fill"></i>
              </div>
              <div>
                <h2 class="fs-6 fw-bold text-dark mb-1">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'তাৎক্ষণিক এসএমএস নিশ্চিতকরণ' : 'Instant Mobile Confirmation' }}</h2>
                <p class="text-muted small mb-0">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'ফর্ম সাবমিটের পরপরই আপনার ফোনে সিরিয়াল নম্বর ও আগমন সংক্রান্ত তথ্য পাঠানো হবে।' : 'Receive serial number and estimated arrival time directly on your phone via SMS.' }}</p>
              </div>
            </div>

            <div class="d-flex align-items-start gap-3">
              <div class="clinical-icon clinical-icon-blue flex-shrink-0">
                <i class="bi bi-shield-lock-fill"></i>
              </div>
              <div>
                <h2 class="fs-6 fw-bold text-dark mb-1">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'কোনো অগ্রিম ফি নেই' : 'Zero Upfront Payment Required' }}</h2>
                <p class="text-muted small mb-0">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'পরামর্শ ফি (' . ($profile->consultation_fee ?? 'BDT 1,200') . ') চেম্বারে উপস্থিত হয়ে রিসেপশনে জমা দেবেন।' : 'Consultation fee (' . ($profile->consultation_fee ?? 'BDT 1,200') . ') is paid on-site at the chamber reception counter upon arrival.' }}</p>
              </div>
            </div>

            <div class="d-flex align-items-start gap-3">
              <div class="clinical-icon clinical-icon-emerald flex-shrink-0">
                <i class="bi bi-file-earmark-medical-fill"></i>
              </div>
              <div>
                <h2 class="fs-6 fw-bold text-dark mb-1">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'পূর্ববর্তী রিপোর্ট পর্যালোচনা' : 'Pre-Consultation Clinical Intake' }}</h2>
                <p class="text-muted small mb-0">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'প্রয়োজনে আপনার পূর্বের প্রেসক্রিপশন ও টেস্ট রিপোর্ট আপলোড করে রাখতে পারেন।' : 'Optionally attach previous prescriptions and lab tests so the doctor is prepared before you walk in.' }}</p>
              </div>
            </div>
          </div>

          <div class="p-3 rounded-3" style="background-color: #FEF2F2; border: 1px solid #FEE2E2;">
            <div class="d-flex align-items-center gap-2 text-danger fw-bold small">
              <i class="bi bi-exclamation-octagon-fill"></i>
              <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'জরুরি রোগীর ক্ষেত্রে সতর্কতা' : 'Medical Emergency Warning' }}</span>
            </div>
            <p class="small text-muted mt-1 mb-0">{{ ($locale ?? app()->getLocale()) === 'bn' ? ($profile->emergency_notice_bn ?? 'অতিরিক্ত বুকে ব্যথা, তীব্র শ্বাসকষ্ট বা প্যারালাইসিস সংক্রান্ত উপসর্গের ক্ষেত্রে অবিলম্বে নিকটস্থ জরুরি বিভাগে যোগাযোগ করুন।') : ($profile->emergency_notice_en ?? 'For severe chest pain, acute breathlessness, or signs of acute stroke, please visit the nearest hospital emergency department immediately or dial 999.') }}</p>
          </div>
        </div>

        <div class="col-lg-7">
          <div class="frictionless-booking-card p-4 p-md-5">
            <div class="d-flex align-items-center justify-content-between mb-4">
              <div>
                <h2 class="fs-4 fw-bold mb-0 brand-font text-primary">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সিরিয়াল বুকিং ফর্ম' : 'Quick Appointment Form' }}</h2>
                <div class="text-muted small">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সহজ ২-ধাপ • দ্রুত সিরিয়াল প্রসেসিং' : 'Priority Chamber Queue • Fast 2-Step' }}</div>
              </div>
              <span class="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সিরিয়াল চালু আছে' : 'Open For Serials' }}</span>
            </div>

            @if(session('success_serial'))
              <div class="alert alert-success d-flex align-items-center gap-3 mb-4" role="alert">
                <i class="bi bi-check-circle-fill fs-3 text-success flex-shrink-0"></i>
                <div>
                  <div class="fw-bold fs-6">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সিরিয়াল নিশ্চিত হয়েছে!' : 'Serial Request Confirmed!' }}</div>
                  <div class="small">{{ session('success_serial')['message'] }}</div>
                </div>
              </div>
            @endif

            @if($errors->any())
              <div class="alert alert-danger mb-4">
                <ul class="mb-0 small">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data" aria-label="Priority Doctor Consultation Booking" data-turbo="false">
              @csrf
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="fullName" class="form-label">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'রোগীর পূর্ণ নাম' : 'Patient Name' }} <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="fullName" name="patient_name" value="{{ old('patient_name') }}" placeholder="{{ ($locale ?? app()->getLocale()) === 'bn' ? 'উদাঃ মোঃ কামাল উদ্দিন' : 'Mohammad Hossain' }}" required>
                </div>

                <div class="col-md-6">
                  <label for="phoneNumber" class="form-label">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'মোবাইল নম্বর' : 'Mobile Number' }} <span class="text-danger">*</span></label>
                  <input type="tel" class="form-control" id="phoneNumber" name="patient_phone" value="{{ old('patient_phone') }}" placeholder="017XXXXXXXX" required>
                </div>

                <div class="col-md-6">
                  <label for="selectedChamber" class="form-label">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'কাঙ্ক্ষিত চেম্বার' : 'Select Chamber' }} <span class="text-danger">*</span></label>
                  <select class="form-select" id="selectedChamber" name="chamber" required>
                    @foreach($chambers as $ch)
                      <option value="{{ $ch->slug }}" {{ old('chamber') == $ch->slug ? 'selected' : '' }}>
                        {{ ($locale ?? app()->getLocale()) === 'bn' ? $ch->name_bn : $ch->name_en }} ({{ ($locale ?? app()->getLocale()) === 'bn' ? $ch->visiting_days_bn : $ch->visiting_days_en }} — {{ ($locale ?? app()->getLocale()) === 'bn' ? 'ফি: ' . ($ch->fee ?? $profile->consultation_fee) : 'Fee: ' . ($ch->fee ?? $profile->consultation_fee) }})
                      </option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-6">
                  <label for="consultationDate" class="form-label">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'পরামর্শের তারিখ' : 'Preferred Date' }} <span class="text-danger">*</span></label>
                  <input type="date" class="form-control" id="consultationDate" name="preferred_date" value="{{ old('preferred_date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                </div>

                <div class="col-12 mt-3">
                  <button class="clinical-collapse-btn" type="button" data-bs-toggle="collapse" data-bs-target="#clinicalDetailsCollapse" aria-expanded="false" aria-controls="clinicalDetailsCollapse">
                    <span class="d-flex align-items-center gap-2">
                      <i class="bi bi-file-earmark-medical-fill text-accent"></i>
                      <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'চিকিৎসা সংক্রান্ত অতিরিক্ত তথ্য (ঐচ্ছিক)' : 'Add Clinical Details (Optional)' }}</span>
                    </span>
                    <i class="bi bi-chevron-down collapse-chevron"></i>
                  </button>

                  <div class="collapse" id="clinicalDetailsCollapse">
                    <div class="clinical-collapse-card mt-2">
                      <div class="row g-3">
                        <div class="col-6 col-md-4">
                          <label for="age" class="form-label">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'বয়স' : 'Age' }}</label>
                          <input type="number" class="form-control" id="age" name="patient_age" value="{{ old('patient_age') }}" placeholder="45" min="1" max="120">
                        </div>

                        <div class="col-6 col-md-4">
                          <label for="gender" class="form-label">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'লিঙ্গ' : 'Gender' }}</label>
                          <select class="form-select" id="gender" name="patient_gender">
                            <option value="male" {{ old('patient_gender') == 'male' ? 'selected' : '' }}>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'পুরুষ' : 'Male' }}</option>
                            <option value="female" {{ old('patient_gender') == 'female' ? 'selected' : '' }}>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'মহিলা' : 'Female' }}</option>
                            <option value="other" {{ old('patient_gender') == 'other' ? 'selected' : '' }}>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'অন্যান্য' : 'Other' }}</option>
                          </select>
                        </div>

                        <div class="col-md-4">
                          <label for="visitCategory" class="form-label">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'ভিজিটের ধরণ' : 'Visit Type' }}</label>
                          <select class="form-select" id="visitCategory" name="visit_type">
                            <option value="new" {{ old('visit_type') == 'new' ? 'selected' : '' }}>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'নতুন রোগী' : 'New Consultation' }}</option>
                            <option value="followup" {{ old('visit_type') == 'followup' ? 'selected' : '' }}>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'পুরাতন ফলোআপ' : 'Follow-Up' }}</option>
                            <option value="report" {{ old('visit_type') == 'report' ? 'selected' : '' }}>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'রিপোর্ট দেখানো' : 'Report Evaluation' }}</option>
                          </select>
                        </div>

                        <div class="col-12">
                          <label for="medicalIssue" class="form-label">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'প্রধান সমস্যা বা উপসর্গ' : 'Primary Symptoms / Reason for Visit' }}</label>
                          <textarea class="form-control" id="medicalIssue" name="symptoms_summary" rows="2" placeholder="{{ ($locale ?? app()->getLocale()) === 'bn' ? 'আপনার মূল সমস্যা সংক্ষেপে লিখুন (উদাঃ অনিয়ন্ত্রিত সুগার, উচ্চ রক্তচাপ, ৪ দিনের জ্বর...)' : 'Briefly describe your symptoms (e.g. Uncontrolled diabetes, high BP, fever for 4 days...)' }}">{{ old('symptoms_summary') }}</textarea>
                        </div>

                        <div class="col-12">
                          <label class="form-label d-flex align-items-center justify-content-between">
                            <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'পূর্বের প্রেসক্রিপশন বা টেস্ট রিপোর্ট আপলোড' : 'Attach Previous Prescriptions / Lab Reports' }}</span>
                            <span class="badge bg-light text-secondary border fw-normal">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'ঐচ্ছিক' : 'Optional' }}</span>
                          </label>
                          <div class="medical-upload-area" id="medicalUploadArea">
                            <input type="file" class="medical-upload-input" id="reportFiles" name="medical_reports[]" multiple accept=".pdf,.jpg,.jpeg,.png">
                            <div class="upload-icon-circle">
                              <i class="bi bi-cloud-arrow-up-fill"></i>
                            </div>
                            <div class="fw-bold text-dark small">{{ ($locale ?? app()->getLocale()) === 'bn' ? 'ফাইল সিলেক্ট করতে ক্লিক করুন অথবা টেনে আনুন' : 'Click to browse or drag & drop reports here' }}</div>
                            <div class="text-muted" style="font-size: 0.76rem;">PDF, JPG, PNG (Max 15MB)</div>
                            <div class="upload-file-status" id="uploadStatus" style="display: none;">
                              <i class="bi bi-file-earmark-check-fill"></i>
                              <span id="uploadFileName">No file selected</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="termsCheck" required checked>
                    <label class="form-check-label small text-muted" for="termsCheck">
                      {{ ($locale ?? app()->getLocale()) === 'bn' ? 'আমি সিরিয়াল সংক্রান্ত তথ্য ও রিমাইন্ডার এসএমএস মোবাইলে গ্রহণে সম্মত।' : 'I agree to receive appointment serial confirmation and reminder SMS on my phone.' }}
                    </label>
                  </div>
                </div>

                <div class="col-12 pt-2">
                  <button type="submit" class="btn btn-brand-accent w-100 justify-content-center py-3 fs-6">
                    <i class="bi bi-check2-circle fs-5"></i>
                    <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'সিরিয়াল রিকোয়েস্ট জমা দিন' : 'Confirm Serial Request & Get Confirmation' }}</span>
                  </button>
                  <div class="text-center text-muted small mt-2 d-flex align-items-center justify-content-center gap-2" style="font-size: 0.82rem;">
                    <i class="bi bi-shield-check text-success"></i>
                    <span>{{ ($locale ?? app()->getLocale()) === 'bn' ? 'অগ্রিম কোনো ফি নেই। এসএমএস-এ সিরিয়াল নিশ্চিত করা হবে।' : 'No advance payment needed. Serial confirmed via SMS.' }}</span>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('scripts')
<script>
  (function() {
    function initBookingUpload() {
      var uploadInput = document.getElementById('reportFiles');
      var uploadStatus = document.getElementById('uploadStatus');
      var uploadFileName = document.getElementById('uploadFileName');
      var currentLang = '{{ $locale ?? app()->getLocale() }}';

      if (uploadInput && uploadStatus && uploadFileName && !uploadInput.dataset.turboBound) {
        uploadInput.dataset.turboBound = 'true';
        uploadInput.addEventListener('change', function(e) {
          var files = e.target.files;
          if (files && files.length > 0) {
            uploadStatus.style.display = 'inline-flex';
            if (files.length === 1) {
              uploadFileName.textContent = files[0].name;
            } else {
              uploadFileName.textContent = files.length + (currentLang === 'bn' ? ' টি ফাইল সিলেক্ট করা হয়েছে' : ' files selected');
            }
          } else {
            uploadStatus.style.display = 'none';
          }
        });
      }
    }

    document.addEventListener('DOMContentLoaded', initBookingUpload);
    document.addEventListener('turbo:load', initBookingUpload);
  })();
</script>
@endsection

