<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Serial;
use App\Models\Prescription;
use App\Models\Article;
use App\Models\Chamber;
use App\Models\Review;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
        $totalSerialsToday = Serial::whereDate('preferred_date', $today)->count();
        $pendingSerials = Serial::where('status', 'pending')->count();
        $totalPrescriptions = Prescription::count();
        $totalArticles = Article::count();
        $chambersCount = Chamber::where('is_active', true)->count();
        $pendingReviews = Review::where('is_approved', false)->count();

        $recentSerials = Serial::with('chamber')->latest()->take(7)->get();
        $recentPrescriptions = Prescription::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalSerialsToday',
            'pendingSerials',
            'totalPrescriptions',
            'totalArticles',
            'chambersCount',
            'pendingReviews',
            'recentSerials',
            'recentPrescriptions'
        ));
    }
}

