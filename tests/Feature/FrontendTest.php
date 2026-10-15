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
        $response->assertSee('Fee: BDT 1,200');

        $bnResponse = $this->withSession(['locale' => 'bn'])->get('/chambers');
        $bnResponse->assertStatus(200);
        $bnResponse->assertSee('ভিজিট ফি: BDT 1,200');
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
        $video = \App\Models\Video::first();
        $response = $this->get('/videos');
        $response->assertStatus(200);

        if ($video) {
            $response->assertSee('data-video-id="' . $video->youtube_id . '"', false);
            $response->assertSee($video->thumbnail_url, false);
        }
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

    public function test_html_minification_produces_compact_unreadable_source_without_errors()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $html = $response->getContent();

        // 1. Tags are compacted with no unnecessary spaces between closing and opening tags
        $this->assertStringNotContainsString(">\n<", $html);
        $this->assertStringNotContainsString(">    <", $html);

        // 2. Standard HTML comments are stripped
        $this->assertStringNotContainsString('<!-- Dynamic SEO Meta Tags -->', $html);
        $this->assertStringNotContainsString('<!-- Site Header -->', $html);

        // 3. Script tags and Schema.org JSON-LD are intact and minified without multi-line indentation
        $this->assertStringContainsString('application/ld+json', $html);
        $this->assertStringContainsString('turbo.js', $html);

        // 4. Verify all inline <script> blocks are minified into compact single lines
        preg_match_all('/<script\b([^>]*)>(.*?)<\/script>/is', $html, $scriptMatches, PREG_SET_ORDER);
        foreach ($scriptMatches as $m) {
            if (!str_contains($m[1], 'src=')) {
                $this->assertEquals(0, substr_count($m[2], "\n"), 'Inline script tag must be minified into a single line');
            }
        }
    }

    public function test_sitemap_and_robots_are_not_corrupted_by_minification()
    {
        $sitemapResponse = $this->get('/sitemap.xml');
        $sitemapResponse->assertStatus(200);
        $this->assertEquals('application/xml', $sitemapResponse->headers->get('Content-Type'));
        $this->assertStringContainsString('<?xml version="1.0" encoding="UTF-8"?>', $sitemapResponse->getContent());

        $robotsResponse = $this->get('/robots.txt');
        $robotsResponse->assertStatus(200);
        $this->assertStringContainsString('text/plain', $robotsResponse->headers->get('Content-Type'));
        $this->assertStringContainsString("User-agent: *\nAllow: /\n", $robotsResponse->getContent());
    }
}

