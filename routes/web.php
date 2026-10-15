<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminSeoController;
use App\Http\Controllers\Admin\AdminChamberController;
use App\Http\Controllers\Admin\AdminSerialController;
use App\Http\Controllers\Admin\AdminPrescriptionController;
use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\Admin\AdminVideoController;
use App\Http\Controllers\Admin\AdminFaqController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\AdminInternationalProjectController;
use App\Http\Controllers\Admin\AdminSpecialtyController;
use App\Models\Article;
use App\Models\SeoSetting;

// Direct shortcut route for /drprofile requested by user
Route::get('/drprofile', fn () => redirect()->route('admin.profile.edit'))->name('drprofile');
Route::get('/admin/drprofile', fn () => redirect()->route('admin.profile.edit'));

/*
|--------------------------------------------------------------------------
| Public Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/expertise', [FrontendController::class, 'expertise'])->name('expertise');
Route::get('/chambers', [FrontendController::class, 'chambers'])->name('chambers');
Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');
Route::get('/videos', [FrontendController::class, 'videos'])->name('videos');
Route::get('/faq', [FrontendController::class, 'faq'])->name('faq');
Route::get('/booking', [FrontendController::class, 'booking'])->name('booking');
Route::post('/booking', [FrontendController::class, 'storeSerial'])->name('booking.store');
Route::get('/lang/{locale}', [FrontendController::class, 'switchLocale'])->name('lang.switch');

// Dynamic Sitemap & Robots.txt for SEO
Route::get('/sitemap.xml', function () {
    $articles = Article::where('is_published', true)->latest()->get();
    $baseUrl = url('/');
    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    
    $pages = ['', '/about', '/expertise', '/chambers', '/blog', '/videos', '/faq', '/booking'];
    foreach ($pages as $p) {
        $xml .= '<url><loc>' . $baseUrl . $p . '</loc><changefreq>weekly</changefreq><priority>' . ($p === '' ? '1.0' : '0.8') . '</priority></url>';
    }
    foreach ($articles as $art) {
        $xml .= '<url><loc>' . $baseUrl . '/blog?slug=' . $art->slug . '</loc><lastmod>' . $art->updated_at->toAtomString() . '</lastmod><changefreq>monthly</changefreq><priority>0.7</priority></url>';
    }
    $xml .= '</urlset>';

    return response($xml, 200)->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::get('/robots.txt', function () {
    $txt = "User-agent: *\n";
    $txt .= "Allow: /\n";
    $txt .= "Disallow: /admin\n";
    $txt .= "Disallow: /admin/\n";
    $txt .= "Sitemap: " . url('/sitemap.xml') . "\n";

    return response($txt, 200)->header('Content-Type', 'text/plain');
});

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Admin Protected Panel Routes (Requires Authentication)
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index']);
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // 1. Doctor Profile & Identity (table: drprofile)
        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

        // 2. A to Z SEO Management
        Route::get('/seo', [AdminSeoController::class, 'index'])->name('seo.index');
        Route::get('/seo/{id}/edit', [AdminSeoController::class, 'edit'])->name('seo.edit');
        Route::post('/seo/{id}', [AdminSeoController::class, 'update'])->name('seo.update');

        // 3. Serial / Appointment Queue Management
        Route::get('/serials', [AdminSerialController::class, 'index'])->name('serials.index');
        Route::get('/serials/print-daily', [AdminSerialController::class, 'printDaily'])->name('serials.printDaily');
        Route::get('/serials/{id}', [AdminSerialController::class, 'show'])->name('serials.show');
        Route::post('/serials/{id}/status', [AdminSerialController::class, 'updateStatus'])->name('serials.updateStatus');
        Route::delete('/serials/{id}', [AdminSerialController::class, 'destroy'])->name('serials.destroy');

        // 4. Digital Prescription (EMR) Management
        Route::get('/prescriptions', [AdminPrescriptionController::class, 'index'])->name('prescriptions.index');
        Route::get('/prescriptions/create', [AdminPrescriptionController::class, 'create'])->name('prescriptions.create');
        Route::post('/prescriptions', [AdminPrescriptionController::class, 'store'])->name('prescriptions.store');
        Route::get('/prescriptions/{id}', [AdminPrescriptionController::class, 'show'])->name('prescriptions.show');
        Route::get('/prescriptions/{id}/print', [AdminPrescriptionController::class, 'print'])->name('prescriptions.print');
        Route::delete('/prescriptions/{id}', [AdminPrescriptionController::class, 'destroy'])->name('prescriptions.destroy');

        // 5. Chambers Management
        Route::resource('chambers', AdminChamberController::class);

        // 6. Medical Articles / Blog
        Route::resource('articles', AdminArticleController::class);

        // 7. Video Guides
        Route::get('/videos', [AdminVideoController::class, 'index'])->name('videos.index');
        Route::post('/videos', [AdminVideoController::class, 'store'])->name('videos.store');
        Route::put('/videos/{id}', [AdminVideoController::class, 'update'])->name('videos.update');
        Route::delete('/videos/{id}', [AdminVideoController::class, 'destroy'])->name('videos.destroy');

        // 8. FAQs
        Route::get('/faqs', [AdminFaqController::class, 'index'])->name('faqs.index');
        Route::post('/faqs', [AdminFaqController::class, 'store'])->name('faqs.store');
        Route::put('/faqs/{id}', [AdminFaqController::class, 'update'])->name('faqs.update');
        Route::delete('/faqs/{id}', [AdminFaqController::class, 'destroy'])->name('faqs.destroy');

        // 9. Reviews / Testimonials
        Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
        Route::post('/reviews', [AdminReviewController::class, 'store'])->name('reviews.store');
        Route::put('/reviews/{id}', [AdminReviewController::class, 'update'])->name('reviews.update');
        Route::post('/reviews/{id}/toggle', [AdminReviewController::class, 'toggleApproval'])->name('reviews.toggle');
        Route::delete('/reviews/{id}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

        // 10. International Projects & Global Collaborations
        Route::resource('projects', AdminInternationalProjectController::class);

        // 11. Clinical Specialties & Services Management
        Route::resource('specialties', AdminSpecialtyController::class);
    });
});
