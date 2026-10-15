<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin Portal') | {{ $profile->name_en ?? 'Doctor Portal' }}</title>
  
  {{-- Dynamic Admin Portal Favicon --}}
  <link rel="icon" type="image/svg+xml" href="{{ $profile->favicon_url }}">
  <link rel="alternate icon" href="{{ $profile->favicon_url }}">
  <link rel="apple-touch-icon" href="{{ $profile->favicon_url }}">

  {{-- Fonts & Bootstrap 5 --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;600;700;800&family=Noto+Sans+Bengali:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  
  <style>
    :root {
      --admin-navy: {{ $profile->primary_color ?? '#0F3B66' }};
      --admin-navy-dark: {{ $profile->primary_hover ?? '#0a2540' }};
      --admin-accent: {{ $profile->accent_color ?? '#059669' }};
      --admin-bg: #F8FAFC;
      --admin-sidebar-w: 260px;
    }
    body {
      font-family: 'Inter', sans-serif;
      background-color: var(--admin-bg);
      color: #1e293b;
      min-height: 100vh;
    }
    h1, h2, h3, h4, h5, h6, .brand-font {
      font-family: 'Outfit', sans-serif;
    }
    .admin-sidebar {
      width: var(--admin-sidebar-w);
      background: linear-gradient(180deg, var(--admin-navy) 0%, var(--admin-navy-dark) 100%);
      color: #e2e8f0;
      min-height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 1040;
      transition: all 0.3s ease;
      display: flex;
      flex-direction: column;
    }
    .sidebar-brand {
      padding: 1.25rem 1.5rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      display: flex;
      align-items: center;
      gap: 0.75rem;
      text-decoration: none;
      color: #ffffff;
    }
    .sidebar-menu {
      padding: 1rem 0.75rem;
      flex-grow: 1;
      overflow-y: auto;
    }
    .sidebar-link {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.65rem 1rem;
      color: #cbd5e1;
      text-decoration: none;
      border-radius: 8px;
      font-weight: 500;
      font-size: 0.9rem;
      margin-bottom: 0.25rem;
      transition: all 0.2s ease;
    }
    .sidebar-link:hover {
      background: rgba(255, 255, 255, 0.08);
      color: #ffffff;
    }
    .sidebar-link.active {
      background: var(--admin-accent);
      color: #ffffff;
      font-weight: 600;
      box-shadow: 0 4px 12px rgba(5, 150, 105, 0.35);
    }
    .sidebar-section-title {
      font-size: 0.72rem;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: #94a3b8;
      padding: 0.75rem 1rem 0.35rem;
      font-weight: 700;
    }
    .admin-main-wrapper {
      margin-left: var(--admin-sidebar-w);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      transition: all 0.3s ease;
    }
    .admin-topbar {
      background: #ffffff;
      border-bottom: 1px solid #e2e8f0;
      padding: 0.85rem 1.75rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 1020;
    }
    .admin-content {
      padding: 1.75rem;
      flex-grow: 1;
    }
    .stat-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 14px;
      padding: 1.25rem 1.5rem;
      box-shadow: 0 1px 3px rgba(0,0,0,0.04);
      transition: all 0.2s ease;
    }
    .stat-card:hover {
      box-shadow: 0 8px 20px -4px rgba(15, 59, 102, 0.1);
      transform: translateY(-2px);
    }
    .stat-icon-box {
      width: 48px;
      height: 48px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.4rem;
    }
    .stat-number {
      font-family: 'Outfit', sans-serif;
      font-weight: 800;
      font-size: 1.75rem;
      line-height: 1.1;
      color: #0f172a;
    }
    .admin-table-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 14px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.04);
      overflow: hidden;
    }
    @media (max-width: 991.98px) {
      .admin-sidebar {
        margin-left: calc(-1 * var(--admin-sidebar-w));
      }
      .admin-sidebar.show {
        margin-left: 0;
      }
      .admin-main-wrapper {
        margin-left: 0;
      }
    }
  </style>
  @yield('styles')
</head>
<body>

  {{-- Admin Sidebar Navigation --}}
  <aside class="admin-sidebar" id="adminSidebar">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
      <div style="width: 36px; height: 36px; background: var(--admin-accent); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
        <i class="bi bi-heart-pulse-fill text-white fs-5"></i>
      </div>
      <div>
        <div class="fw-bold fs-6 brand-font leading-tight">{{ $profile->name_en ?? 'Doctor Portal' }}</div>
        <div class="small text-slate-400" style="font-size: 0.72rem; color: #94a3b8;">Admin Management</div>
      </div>
    </a>

    <div class="sidebar-menu">
      <div class="sidebar-section-title">Core Operations</div>
      <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
      </a>

      <a href="{{ route('admin.serials.index') }}" class="sidebar-link {{ request()->routeIs('admin.serials.*') ? 'active' : '' }}">
        <i class="bi bi-calendar-check-fill"></i>
        <span>Serials & Queue</span>
      </a>

      <a href="{{ route('admin.prescriptions.index') }}" class="sidebar-link {{ request()->routeIs('admin.prescriptions.*') ? 'active' : '' }}">
        <i class="bi bi-file-earmark-medical-fill"></i>
        <span>Digital Prescription</span>
      </a>

      <div class="sidebar-section-title">Site & Content Control</div>
      <a href="{{ route('admin.profile.edit') }}" class="sidebar-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
        <i class="bi bi-person-badge-fill"></i>
        <span>Doctor Profile (drprofile)</span>
      </a>

      <a href="{{ route('admin.seo.index') }}" class="sidebar-link {{ request()->routeIs('admin.seo.*') ? 'active' : '' }}">
        <i class="bi bi-search"></i>
        <span>SEO Control Suite</span>
      </a>

      <a href="{{ route('admin.chambers.index') }}" class="sidebar-link {{ request()->routeIs('admin.chambers.*') ? 'active' : '' }}">
        <i class="bi bi-geo-alt-fill"></i>
        <span>Chambers & Schedules</span>
      </a>

      <a href="{{ route('admin.specialties.index') }}" class="sidebar-link {{ request()->routeIs('admin.specialties.*') ? 'active' : '' }}">
        <i class="bi bi-heart-pulse-fill"></i>
        <span>Clinical Specialties</span>
      </a>

      <a href="{{ route('admin.articles.index') }}" class="sidebar-link {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
        <i class="bi bi-journal-richtext"></i>
        <span>Health Articles</span>
      </a>

      <a href="{{ route('admin.videos.index') }}" class="sidebar-link {{ request()->routeIs('admin.videos.*') ? 'active' : '' }}">
        <i class="bi bi-youtube"></i>
        <span>Video Guides</span>
      </a>

      <a href="{{ route('admin.faqs.index') }}" class="sidebar-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
        <i class="bi bi-question-circle-fill"></i>
        <span>FAQ Manager</span>
      </a>

      <a href="{{ route('admin.reviews.index') }}" class="sidebar-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
        <i class="bi bi-chat-quote-fill"></i>
        <span>Patient Testimonials</span>
      </a>

      <a href="{{ route('admin.projects.index') }}" class="sidebar-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
        <i class="bi bi-globe-americas"></i>
        <span>International Projects</span>
      </a>

      <div class="sidebar-section-title">External</div>
      <a href="{{ route('home') }}" target="_blank" class="sidebar-link">
        <i class="bi bi-box-arrow-up-right"></i>
        <span>View Live Website</span>
      </a>
    </div>

    <div class="p-3 border-top border-secondary border-opacity-25">
      <form action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-sm btn-outline-danger w-100 d-flex align-items-center justify-content-center gap-2">
          <i class="bi bi-box-arrow-right"></i>
          <span>Logout</span>
        </button>
      </form>
    </div>
  </aside>

  {{-- Admin Main Content Area --}}
  <div class="admin-main-wrapper">
    <header class="admin-topbar">
      <div class="d-flex align-items-center gap-3">
        <button class="btn btn-light d-lg-none p-1 px-2 border" type="button" id="sidebarToggle">
          <i class="bi bi-list fs-4"></i>
        </button>
        <h1 class="fs-5 fw-bold mb-0 brand-font text-dark">@yield('page_heading', 'Admin Overview')</h1>
      </div>

      <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.prescriptions.create') }}" class="btn btn-sm btn-success d-flex align-items-center gap-2 shadow-sm">
          <i class="bi bi-plus-circle-fill"></i>
          <span>New Prescription</span>
        </a>
        <div class="vr mx-1"></div>
        <div class="d-flex align-items-center gap-2">
          <div style="width: 34px; height: 34px; background: #e0f2fe; color: #0284c7; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700;">
            DR
          </div>
          <span class="small fw-semibold d-none d-sm-inline">{{ auth()->user()->name ?? ($profile->name_en ?? 'Doctor') }}</span>
        </div>
      </div>
    </header>

    <main class="admin-content">
      {{-- Flash Messages --}}
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
          <i class="bi bi-check-circle-fill fs-5"></i>
          <div>{{ session('success') }}</div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
          <i class="bi bi-exclamation-triangle-fill fs-5"></i>
          <div>{{ session('error') }}</div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
          <div class="fw-bold mb-1">Please fix the following issues:</div>
          <ul class="mb-0 small">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @yield('content')
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var sidebarToggle = document.getElementById('sidebarToggle');
      var adminSidebar = document.getElementById('adminSidebar');
      if (sidebarToggle && adminSidebar) {
        sidebarToggle.addEventListener('click', function() {
          adminSidebar.classList.toggle('show');
        });
      }
    });
  </script>
  @yield('scripts')
</body>
</html>

