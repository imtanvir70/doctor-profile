<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\DrProfile;
use App\Models\SeoSetting;
use App\Models\Chamber;
use App\Models\Serial;
use App\Models\Prescription;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->adminUser = User::where('email', 'admin@drabuhanifrakib.com')->first();
    }

    public function test_login_page_renders()
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
        $response->assertSee('Doctor & EMR Portal', false);
    }

    public function test_unauthenticated_user_redirected_to_admin_login()
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');

        $responseDashboard = $this->get('/admin/dashboard');
        $responseDashboard->assertRedirect('/admin/login');
    }

    public function test_admin_can_login_successfully()
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@drabuhanifrakib.com',
            'password' => 'admin123',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($this->adminUser);
    }

    public function test_authenticated_doctor_can_access_dashboard()
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Doctor Clinical & Portal Dashboard');
    }

    public function test_doctor_profile_edit_and_update_drprofile_table()
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/profile');
        $response->assertStatus(200);
        $response->assertSee('Doctor Profile (drprofile Table Settings)');

        $updateResponse = $this->actingAs($this->adminUser)->post('/admin/profile', [
            'name_en' => 'Dr. Abu Hanif Rakib',
            'name_bn' => 'ডাঃ মোঃ আবু হানিফ রাকিব',
            'designation_en' => 'Associate Professor & Senior Consultant',
            'designation_bn' => 'সহযোগী অধ্যাপক ও সিনিয়র কনসালট্যান্ট',
            'degrees_en' => 'MBBS, BCS (Health), FCPS (Medicine)',
            'degrees_bn' => 'এমবিবিএস, বিসিএস (স্বাস্থ্য), এফসিপিএস (মেডিসিন)',
            'bmdc_reg' => '84321',
            'experience_years' => '15+',
            'patients_count' => '30,000+',
            'satisfaction_rate' => '99.5%',
            'hero_bio_en' => 'Updated bio in English',
            'hero_bio_bn' => 'আপডেট করা বায়ো',
            'hotline_phone' => '+8801711000001',
            'hotline_whatsapp' => '8801711000001',
            'email' => 'admin@drabuhanifrakib.com',
            'consultation_fee' => 'BDT 1,200',
            'primary_color' => '#0369a1',
            'accent_color' => '#06b6d4',
        ]);

        $updateResponse->assertSessionHas('success');
        $this->assertDatabaseHas('drprofile', [
            'experience_years' => '15+',
            'primary_color' => '#0369a1',
            'accent_color' => '#06b6d4',
        ]);
    }

    public function test_seo_settings_index_and_update()
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/seo');
        $response->assertStatus(200);

        $seo = SeoSetting::first();
        $editResponse = $this->actingAs($this->adminUser)->get("/admin/seo/{$seo->id}/edit");
        $editResponse->assertStatus(200);

        $updateResponse = $this->actingAs($this->adminUser)->post("/admin/seo/{$seo->id}", [
            'meta_title_en' => 'Updated Best Medicine Specialist Dhaka',
            'meta_title_bn' => 'মেডিসিন বিশেষজ্ঞ ঢাকা',
            'meta_description_en' => 'Expert internal medicine care in Dhanmondi and Uttara Dhaka.',
            'meta_description_bn' => 'অভিজ্ঞ মেডিসিন বিশেষজ্ঞ ডাক্তার।',
            'robots' => 'index, follow',
            'schema_type' => 'Physician',
        ]);

        $updateResponse->assertRedirect('/admin/seo');
        $this->assertDatabaseHas('seo_settings', [
            'id' => $seo->id,
            'meta_title_en' => 'Updated Best Medicine Specialist Dhaka',
        ]);
    }

    public function test_serial_queue_and_status_update()
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/serials');
        $response->assertStatus(200);

        $serial = Serial::first();
        $this->assertNotNull($serial);

        $showResponse = $this->actingAs($this->adminUser)->get("/admin/serials/{$serial->id}");
        $showResponse->assertStatus(200);
        $showResponse->assertSee($serial->patient_name);

        $statusResponse = $this->actingAs($this->adminUser)->post("/admin/serials/{$serial->id}/status", [
            'status' => 'confirmed',
            'admin_notes' => 'Patient called and appointment confirmed for 6:30 PM.',
        ]);

        $statusResponse->assertSessionHas('success');
        $this->assertDatabaseHas('serials', [
            'id' => $serial->id,
            'status' => 'confirmed',
        ]);
    }

    public function test_digital_prescription_creation_and_printable_sheet()
    {
        $chamber = Chamber::first();

        $createPageResponse = $this->actingAs($this->adminUser)->get('/admin/prescriptions/create');
        $createPageResponse->assertStatus(200);
        $createPageResponse->assertSee('Doctor Prescription (EMR Pad)');

        $storeResponse = $this->actingAs($this->adminUser)->post('/admin/prescriptions', [
            'prescription_no' => 'RX-2026-TEST',
            'chamber_id' => $chamber->id,
            'patient_name' => 'Abul Kashem',
            'patient_phone' => '01711223344',
            'patient_age' => 52,
            'patient_gender' => 'male',
            'consultation_date' => date('Y-m-d'),
            'bp_systolic' => '130',
            'bp_diastolic' => '85',
            'pulse' => '78',
            'weight' => '74',
            'temperature' => '98.6',
            'blood_sugar' => '7.2 mmol/L',
            'chief_complaints' => 'Polyuria, polydipsia, high morning glucose',
            'diagnosis' => 'Type 2 Diabetes Mellitus with Mild Hypertension',
            'medicines' => [
                [
                    'name' => 'Tab. Metformin 500mg',
                    'dose' => '১+০+১',
                    'timing' => 'খাবারের পরে (After Meal)',
                    'duration' => '১ মাস',
                    'instructions' => 'নিয়মিত সেব্য',
                ],
                [
                    'name' => 'Tab. Bisoprolol 2.5mg',
                    'dose' => '১+০+০',
                    'timing' => 'সকালে খাবারের পর (Morning)',
                    'duration' => 'চলবে',
                    'instructions' => 'প্রেশারের জন্য',
                ],
            ],
            'investigations' => [
                ['name' => 'HbA1c', 'instructions' => 'Fasting'],
                ['name' => 'Serum Creatinine', 'instructions' => 'Routine'],
            ],
            'special_advice' => 'প্রতিদিন ৪৫ মিনিট হাঁটবেন। মিষ্টি ও অতিরিক্ত ভাত পরিহার করবেন।',
            'next_visit_date' => date('Y-m-d', strtotime('+30 days')),
        ]);

        $prescription = Prescription::where('prescription_no', 'RX-2026-TEST')->first();
        $this->assertNotNull($prescription);
        $storeResponse->assertRedirect(route('admin.prescriptions.show', $prescription->id));

        // Test Printable A4 Sheet
        $printResponse = $this->actingAs($this->adminUser)->get("/admin/prescriptions/{$prescription->id}/print");
        $printResponse->assertStatus(200);
        $printResponse->assertSee('Abul Kashem');
        $printResponse->assertSee('Tab. Metformin 500mg');
        $printResponse->assertSee('১+০+১');
    }

    public function test_international_projects_crud_operations()
    {
        // 1. List
        $listResponse = $this->actingAs($this->adminUser)->get('/admin/projects');
        $listResponse->assertStatus(200);
        $listResponse->assertSee('International Projects');

        // 2. Create
        $createResponse = $this->actingAs($this->adminUser)->post('/admin/projects', [
            'title_en' => 'Global Diabetes Registry Project',
            'title_bn' => 'গ্লোবাল ডায়াবেটিস রেজিস্ট্রি গবেষণা',
            'organization' => 'World Health Organization (WHO)',
            'country_or_location' => 'Geneva, Switzerland',
            'role_en' => 'Principal Investigator',
            'role_bn' => 'প্রধান গবেষক',
            'duration' => '2023 - 2025',
            'category' => 'Clinical Research',
            'badge_text' => 'WHO Sponsored',
            'description_en' => 'Multi-center clinical observational trial.',
            'description_bn' => 'বহুকেন্দ্রীক পর্যবেক্ষণমূলক গবেষণা।',
            'project_url' => 'https://www.who.int',
            'icon' => 'bi-globe-americas',
            'display_order' => 1,
            'is_featured' => '1',
            'is_active' => '1',
        ]);
        $createResponse->assertRedirect('/admin/projects');

        $project = \App\Models\InternationalProject::where('title_en', 'Global Diabetes Registry Project')->first();
        $this->assertNotNull($project);
        $this->assertTrue($project->is_active);

        // 3. Update
        $updateResponse = $this->actingAs($this->adminUser)->put("/admin/projects/{$project->id}", [
            'title_en' => 'Global Diabetes Registry Project Updated',
            'title_bn' => 'গ্লোবাল ডায়াবেটিস রেজিস্ট্রি গবেষণা পরিবর্তিত',
            'organization' => 'WHO & Harvard Global Health',
            'country_or_location' => 'Boston & Geneva',
            'role_en' => 'Lead Investigator',
            'role_bn' => 'প্রধান তদন্তকারী',
            'duration' => '2023 - 2026',
            'category' => 'Multicenter Clinical Trial',
            'badge_text' => 'Harvard Collab',
            'description_en' => 'Updated description.',
            'description_bn' => 'পরিবর্তিত বিবরণ।',
            'project_url' => 'https://www.who.int',
            'icon' => 'bi-activity',
            'display_order' => 2,
        ]);
        $updateResponse->assertRedirect('/admin/projects');
        $project->refresh();
        $this->assertEquals('Global Diabetes Registry Project Updated', $project->title_en);

        // 4. Delete
        $deleteResponse = $this->actingAs($this->adminUser)->delete("/admin/projects/{$project->id}");
        $deleteResponse->assertRedirect('/admin/projects');
        $this->assertNull(\App\Models\InternationalProject::find($project->id));
    }

    public function test_drprofile_route_redirects_to_profile_edit()
    {
        $response = $this->actingAs($this->adminUser)->get('/drprofile');
        $response->assertRedirect(route('admin.profile.edit'));
    }

    public function test_specialties_crud_operations()
    {
        // 1. Index & Create view
        $indexResponse = $this->actingAs($this->adminUser)->get('/admin/specialties');
        $indexResponse->assertStatus(200);

        $createResponse = $this->actingAs($this->adminUser)->get('/admin/specialties/create');
        $createResponse->assertStatus(200);

        // 2. Store
        $storeResponse = $this->actingAs($this->adminUser)->post('/admin/specialties', [
            'title_en' => 'Hypertension & Heart Health',
            'title_bn' => 'উচ্চ রক্তচাপ ও হৃদরোগ চিকিৎসা',
            'badge_en' => 'Cardiovascular',
            'badge_bn' => 'কার্ডিওভাসকুলার',
            'description_en' => 'Precision blood pressure monitoring and cardiovascular protection.',
            'description_bn' => 'রক্তচাপ নিয়ন্ত্রণ ও হার্ট অ্যাটাক প্রতিরোধে আধুনিক চিকিৎসা।',
            'approach_en' => 'Lifestyle optimization with safe pharmacotherapy.',
            'approach_bn' => 'জীবনযাত্রা নিয়ন্ত্রণ ও নিরাপদ ওষুধের সমন্বয়।',
            'icon_class' => 'bi-heart-pulse-fill',
            'display_order' => 1,
            'is_active' => '1',
        ]);
        $storeResponse->assertRedirect(route('admin.specialties.index'));

        $specialty = \App\Models\Specialty::where('title_en', 'Hypertension & Heart Health')->first();
        $this->assertNotNull($specialty);
        $this->assertEquals('উচ্চ রক্তচাপ ও হৃদরোগ চিকিৎসা', $specialty->title_bn);

        // 3. Edit & Update
        $editResponse = $this->actingAs($this->adminUser)->get("/admin/specialties/{$specialty->id}/edit");
        $editResponse->assertStatus(200);

        $updateResponse = $this->actingAs($this->adminUser)->put("/admin/specialties/{$specialty->id}", [
            'title_en' => 'Hypertension Care Updated',
            'title_bn' => 'উচ্চ রক্তচাপ চিকিৎসা আপডেট',
            'description_en' => 'Updated description content.',
            'description_bn' => 'আপডেট করা বিবরণী।',
            'display_order' => 5,
            'is_active' => '1',
        ]);
        $updateResponse->assertRedirect(route('admin.specialties.index'));
        $specialty->refresh();
        $this->assertEquals('Hypertension Care Updated', $specialty->title_en);

        // 4. Delete
        $deleteResponse = $this->actingAs($this->adminUser)->delete("/admin/specialties/{$specialty->id}");
        $deleteResponse->assertRedirect(route('admin.specialties.index'));
        $this->assertNull(\App\Models\Specialty::find($specialty->id));
    }

    public function test_video_guide_update_operation()
    {
        $video = \App\Models\Video::first();
        $this->assertNotNull($video);

        // Test full URL with playlist query parameter
        $response = $this->actingAs($this->adminUser)->put("/admin/videos/{$video->id}", [
            'title_en' => 'Updated Video Title EN',
            'title_bn' => 'আপডেট করা ভিডিও শিরোনাম',
            'youtube_id' => 'https://www.youtube.com/watch?v=nFgsBxw-zWQ&list=RDGMEMCMFH2exzjBeE_zAHHJOdxgVMnFgsBxw-zWQ',
            'category' => 'diabetes',
            'duration' => '10:00',
            'description_en' => 'Updated English description.',
            'description_bn' => 'আপডেট করা বাংলা বর্ণনা।',
            'display_order' => 2,
            'is_active' => '1',
        ]);

        $response->assertSessionHas('success');
        $video->refresh();
        $this->assertEquals('Updated Video Title EN', $video->title_en);
        $this->assertEquals('nFgsBxw-zWQ', $video->youtube_id);
        $this->assertEquals('https://img.youtube.com/vi/nFgsBxw-zWQ/hqdefault.jpg', $video->thumbnail);

        // Test short URL (https://youtu.be/nFgsBxw-zWQ)
        $shortResponse = $this->actingAs($this->adminUser)->put("/admin/videos/{$video->id}", [
            'title_en' => 'Updated Video Short URL',
            'title_bn' => 'শর্ট লিংক ভিডিও',
            'youtube_id' => 'https://youtu.be/nFgsBxw-zWQ',
            'category' => 'diabetes',
            'duration' => '8:30',
            'description_en' => 'Short link description.',
            'description_bn' => 'শর্ট লিংক বর্ণনা।',
            'display_order' => 2,
            'is_active' => '1',
        ]);
        $shortResponse->assertSessionHas('success');
        $video->refresh();
        $this->assertEquals('nFgsBxw-zWQ', $video->youtube_id);
    }

    public function test_faq_update_operation()
    {
        $faq = \App\Models\Faq::first();
        $this->assertNotNull($faq);

        $response = $this->actingAs($this->adminUser)->put("/admin/faqs/{$faq->id}", [
            'question_en' => 'Updated FAQ Question EN',
            'question_bn' => 'আপডেট করা এফএকিউ প্রশ্ন',
            'answer_en' => 'Updated answer EN text.',
            'answer_bn' => 'আপডেট করা বাংলা উত্তর।',
            'display_order' => 3,
            'is_active' => '1',
        ]);

        $response->assertSessionHas('success');
        $faq->refresh();
        $this->assertEquals('Updated FAQ Question EN', $faq->question_en);
    }

    public function test_review_update_operation()
    {
        $review = \App\Models\Review::first();
        $this->assertNotNull($review);

        $response = $this->actingAs($this->adminUser)->put("/admin/reviews/{$review->id}", [
            'patient_name' => 'Dr. Farhana Updated',
            'location_tag_en' => 'Endocrinology Care • Gulshan',
            'location_tag_bn' => 'এন্ডোক্রিনোলজি সেবা • গুলশান',
            'rating' => 5,
            'review_text_en' => 'Outstanding medical expertise.',
            'review_text_bn' => 'অসাধারণ চিকিৎসা সেবা।',
            'is_approved' => '1',
            'is_featured' => '1',
        ]);

        $response->assertSessionHas('success');
        $review->refresh();
        $this->assertEquals('Dr. Farhana Updated', $review->patient_name);
        $this->assertEquals('Endocrinology Care • Gulshan', $review->location_tag_en);
    }
}

