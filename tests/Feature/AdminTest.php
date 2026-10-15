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
}
