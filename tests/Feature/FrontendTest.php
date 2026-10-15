<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FrontendTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_homepage_loads_successfully()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Dr. Abu Hanif Rakib');
        $response->assertSee('turbo.js');
        $response->assertSee('data-turbo="false"', false);
        $response->assertSee('application/ld+json', false);
    }

    public function test_seo_metadata_integrity()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('<meta name="description"', false);
        $response->assertSee('<meta property="og:title"', false);
        $response->assertSee('<meta property="og:description"', false);
        $response->assertSee('<meta name="twitter:card"', false);
        $response->assertSee('schema.org', false);
    }

    public function test_booking_submission()
    {
        $response = $this->post('/booking', [
            'patient_name' => 'Tanzil Hossain',
            'patient_phone' => '01712345678',
            'chamber' => 'popular-diagnostic-dhanmondi',
            'preferred_date' => date('Y-m-d', strtotime('+1 day')),
            'patient_age' => 30,
            'patient_gender' => 'male',
            'visit_type' => 'new',
            'symptoms_summary' => 'Routine general checkup',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success_serial');
    }

    public function test_about_page_loads_successfully()
    {
        $response = $this->get('/about');
        $response->assertStatus(200);
        $response->assertSee('Dr. Abu Hanif Rakib');
    }

    public function test_chambers_page_loads_successfully()
    {
        $response = $this->get('/chambers');
        $response->assertStatus(200);
        $response->assertSee('Dhanmondi');
    }

    public function test_expertise_page_loads_successfully()
    {
        $response = $this->get('/expertise');
        $response->assertStatus(200);
    }

    public function test_blog_page_loads_successfully()
    {
        $response = $this->get('/blog');
        $response->assertStatus(200);
    }

    public function test_videos_page_loads_successfully()
    {
        $response = $this->get('/videos');
        $response->assertStatus(200);
    }

    public function test_faq_page_loads_successfully()
    {
        $response = $this->get('/faq');
        $response->assertStatus(200);
    }

    public function test_booking_page_loads_successfully()
    {
        $response = $this->get('/booking');
        $response->assertStatus(200);
    }

    public function test_language_switch_route()
    {
        $response = $this->get('/lang/bn');
        $response->assertStatus(302);
    }

    public function test_footer_displays_developer_credit()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Developed by');
        $response->assertSee('Solve IT');
        $response->assertSee('https://solveitbd.com/', false);
    }
}

