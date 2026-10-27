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
  @yield('styles')
  @stack('styles')
  
  <style>
    :root {
      --admin-navy: {{ $profile->primary_color ?? '#0F3B66' }};
      --admin-navy-dark: {{ $profile->primary_hover ?? '#0a2540' }};
      --admin-accent: {{ $profile->accent_color ?? '#059669' }};
      --admin-bg: #F8FAFC;
      --admin-sidebar-w: 260px;
    }
    html, body {
      max-width: 100vw;
      overflow-x: hidden;
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
      bottom: 0;
      z-index: 1060;
      transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      display: flex;
      flex-direction: column;
    }
    .sidebar-brand-wrapper {
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      background: rgba(0, 0, 0, 0.08);
    }
    .sidebar-brand {
      padding: 1.15rem 1.25rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      text-decoration: none;
      color: #ffffff;
    }
    .sidebar-brand:hover {
      color: #ffffff;
    }
    .sidebar-menu {
      padding: 0.85rem 0.75rem;
      flex-grow: 1;
      overflow-y: auto;
      -webkit-overflow-scrolling: touch;
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
      transition: margin-left 0.3s ease;
      max-width: 100vw;
      min-width: 0;
    }
    .admin-topbar {
      background: #ffffff;
      border-bottom: 1px solid #e2e8f0;
      padding: 0.75rem 1.25rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: fixed;
      top: 0;
      left: var(--admin-sidebar-w);
      right: 0;
      height: 58px;
      z-index: 1030;
      box-sizing: border-box;
      box-shadow: 0 1px 4px rgba(0,0,0,0.03);
    }
    @media (max-width: 991.98px) {
      .admin-topbar {
        left: 0;
      }
    }
    .topbar-title {
      font-size: 1.05rem;
      line-height: 1.25;
    }
    .admin-content {
      padding-top: calc(58px + 0.5rem) !important;
      padding-bottom: 2rem !important;
      flex-grow: 1;
      max-width: 100%;
      min-width: 0;
      box-sizing: border-box;
    }
    .stat-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 14px;
      padding: 1.15rem 1.25rem;
      box-shadow: 0 1px 3px rgba(0,0,0,0.04);
      transition: all 0.2s ease;
      display: flex;
      flex-direction: column;
    }
    .stat-card:hover {
      box-shadow: 0 8px 20px -4px rgba(15, 59, 102, 0.1);
      transform: translateY(-2px);
    }
    .stat-icon-box {
      width: 42px;
      height: 42px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.25rem;
      flex-shrink: 0;
    }
    .stat-number {
      font-family: 'Outfit', sans-serif;
      font-weight: 800;
      font-size: 1.65rem;
      line-height: 1.1;
      color: #0f172a;
      margin-bottom: 0.25rem;
    }
    .stat-card-title {
      font-size: 0.8rem;
      font-weight: 600;
      color: #475569;
      line-height: 1.25;
      margin-bottom: 0.2rem;
    }
    .admin-table-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 14px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.04);
      overflow: hidden;
      max-width: 100%;
    }

    /* Backdrop for Mobile Sidebar */
    .sidebar-backdrop {
      position: fixed;
      inset: 0;
      background: rgba(15, 23, 42, 0.65);
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
      z-index: 1050;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease, visibility 0.3s ease;
    }
    .sidebar-backdrop.show {
      opacity: 1;
      visibility: visible;
    }

    /* Mobile Bottom Navigation Bar */
    .admin-mobile-dock {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      z-index: 1040;
      height: 60px;
      background: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-top: 1px solid #e2e8f0;
      box-shadow: 0 -2px 12px rgba(0, 0, 0, 0.05);
      padding: 0 0.5rem;
    }
    .dock-inner {
      display: flex;
      align-items: center;
      justify-content: space-around;
      height: 100%;
      max-width: 500px;
      margin: 0 auto;
    }
    .dock-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      color: #64748b;
      text-decoration: none;
      font-size: 0.7rem;
      font-weight: 600;
      padding: 4px 0;
      flex: 1;
      height: 100%;
      background: transparent;
      border: none;
      transition: color 0.15s ease;
      -webkit-tap-highlight-color: transparent;
    }
    .dock-item i {
      font-size: 1.25rem;
      line-height: 1.1;
      margin-bottom: 2px;
    }
    .dock-item:hover, .dock-item:focus {
      color: var(--admin-navy, #0F3B66);
    }
    .dock-item.active {
      color: var(--admin-accent, #059669);
      font-weight: 700;
    }
    .dock-item.active i {
      color: var(--admin-accent, #059669);
    }
    .dock-item-highlight .dock-icon-circle {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: var(--admin-accent, #059669);
      color: #ffffff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      margin-bottom: 2px;
      box-shadow: 0 2px 6px rgba(5, 150, 105, 0.35);
      transition: transform 0.15s ease;
    }
    .dock-item-highlight:active .dock-icon-circle {
      transform: scale(0.92);
    }
    .dock-item-highlight {
      color: var(--admin-accent, #059669);
    }

    /* Mobile Responsive Overrides */
    @media (max-width: 991.98px) {
      .admin-sidebar {
        width: min(300px, 86vw);
        transform: translateX(-100%);
        box-shadow: 0 0 35px rgba(0, 0, 0, 0.45);
      }
      .admin-sidebar.show {
        transform: translateX(0);
      }
      .admin-main-wrapper {
        margin-left: 0;
      }
      body.sidebar-open {
        overflow: hidden;
      }
      .admin-content {
        padding-top: calc(58px + 0.5rem) !important;
        padding-bottom: calc(60px + 1.25rem) !important;
      }
    }

    @media (min-width: 992px) {
      .admin-sidebar {
        transform: none !important;
      }
    }

    @media (max-width: 768px) {
      /* Prevent iOS auto-zoom on input focus */
      .form-control,
      .form-select,
      input[type="text"],
      input[type="number"],
      input[type="date"],
      input[type="email"],
      input[type="password"],
      select,
      textarea {
        font-size: 16px !important;
      }

      .admin-topbar {
        padding: 0.5rem 0.85rem;
        height: 56px;
      }
      .topbar-title {
        font-size: 0.95rem;
      }

      .admin-content {
        padding-top: calc(56px + 0.35rem) !important;
        padding-bottom: calc(60px + 1.25rem) !important;
      }

      /* Clean card and container margins */
      .card,
      .admin-table-card,
      .alert {
        border-radius: 12px;
        margin-bottom: 1rem !important;
      }
      .card-body,
      .card-body.p-4 {
        padding: 1rem !important;
      }
      .card-header,
      .card-header.px-4 {
        padding: 0.75rem 1rem !important;
      }
      .card-footer,
      .card-footer.px-4 {
        padding: 0.75rem 1rem !important;
      }

      /* Normalize grid gaps on mobile */
      .row.g-4 {
        --bs-gutter-y: 1rem;
        --bs-gutter-x: 0.75rem;
      }
      .row.g-3 {
        --bs-gutter-y: 0.75rem;
        --bs-gutter-x: 0.75rem;
      }

      /* Stat cards */
      .stat-card {
        padding: 0.85rem 0.85rem;
        border-radius: 12px;
      }
      .stat-icon-box {
        width: 36px;
        height: 36px;
        font-size: 1.1rem;
        border-radius: 8px;
      }
      .stat-number {
        font-size: 1.35rem;
        margin-bottom: 0.15rem;
      }
      .stat-card-title {
        font-size: 0.76rem;
      }

      .table-responsive {
        -webkit-overflow-scrolling: touch;
        border-radius: 10px;
      }
      .table-responsive::-webkit-scrollbar {
        height: 4px;
      }
      .table-responsive::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 4px;
      }

      .btn {
        touch-action: manipulation;
      }
      .btn-sm {
        min-height: 32px;
      }
    }

    @media (max-width: 575.98px) {
      .admin-topbar {
        padding: 0.45rem 0.65rem;
        height: 54px;
      }
      .topbar-title {
        font-size: 0.88rem;
      }

      .admin-content {
        padding-top: calc(54px + 0.25rem) !important;
        padding-bottom: calc(60px + 1rem) !important;
      }

      .card,
      .admin-table-card,
      .alert {
        margin-bottom: 0.85rem !important;
      }
      .card-body,
      .card-body.p-4 {
        padding: 0.85rem !important;
      }
      .card-header,
      .card-header.px-4 {
        padding: 0.65rem 0.85rem !important;
      }
      .card-footer,
      .card-footer.px-4 {
        padding: 0.65rem 0.85rem !important;
      }

      .stat-card {
        padding: 0.75rem 0.7rem;
        border-radius: 10px;
      }
      .stat-icon-box {
        width: 32px;
        height: 32px;
        font-size: 1rem;
        border-radius: 8px;
      }
      .stat-number {
        font-size: 1.25rem;
      }
      .stat-card-title {
        font-size: 0.74rem;
      }
    }

    /* Universal Mobile Table-to-Card Converter (< 768px down to 350px) */
    @media (max-width: 767.98px) {
      /* Disable table hover effects on mobile */
      .table-hover > tbody > tr:hover > *,
      .table-hover > tbody > tr:focus > * {
        --bs-table-hover-bg: transparent !important;
        --bs-table-bg-state: transparent !important;
        background-color: transparent !important;
        color: inherit !important;
      }
      .table-to-card tbody tr:hover,
      .table-to-card tbody tr:focus,
      .mobile-card-table tbody tr:hover,
      .mobile-card-table tbody tr:focus {
        background-color: #ffffff !important;
        transform: none !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03) !important;
      }
      .table-to-card,
      .mobile-card-table {
        display: block !important;
        width: 100% !important;
        border: none !important;
        background: transparent !important;
      }
      .table-to-card thead,
      .mobile-card-table thead {
        display: none !important;
      }
      .table-to-card tbody,
      .mobile-card-table tbody {
        display: flex !important;
        flex-direction: column !important;
        gap: 0.75rem !important;
        width: 100% !important;
        background: transparent !important;
      }
      .table-to-card tbody tr,
      .mobile-card-table tbody tr {
        display: block !important;
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 14px !important;
        padding: 0.85rem 1rem !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;
        margin-bottom: 0 !important;
        width: 100% !important;
        position: relative !important;
      }
      .table-to-card tbody tr > td,
      .mobile-card-table tbody tr > td {
        display: flex !important;
        flex-direction: column !important;
        width: 100% !important;
        padding: 0.45rem 0 !important;
        border: none !important;
        border-bottom: 1px dashed #f1f5f9 !important;
        text-align: left !important;
        background: transparent !important;
      }
      .table-to-card tbody tr > td:last-child,
      .mobile-card-table tbody tr > td:last-child {
        border-bottom: none !important;
        border-top: 1px solid #f1f5f9 !important;
        padding-bottom: 0 !important;
        margin-top: 0.35rem !important;
        padding-top: 0.5rem !important;
        flex-direction: row !important;
        justify-content: flex-end !important;
        align-items: center !important;
        gap: 0.5rem !important;
        flex-wrap: wrap !important;
      }
      .table-to-card tbody tr > td[data-label]::before,
      .mobile-card-table tbody tr > td[data-label]::before {
        content: attr(data-label);
        display: block;
        font-size: 0.75rem !important;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #64748b;
        margin-bottom: 0.2rem;
      }
      .table-to-card tbody tr.medicine-row .remove-row-btn {
        width: auto;
        padding: 0.35rem 0.85rem !important;
        font-size: 0.82rem;
      }
      .table-responsive:has(.table-to-card) {
        overflow-x: visible !important;
        border: none !important;
        background: transparent !important;
      }
    }
  </style>
  @yield('styles')
</head>
<body>

  {{-- Mobile Backdrop Overlay --}}
  <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

  {{-- Admin Sidebar Navigation --}}
  <aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-brand-wrapper d-flex align-items-center justify-content-between">
      <a href="{{ route('admin.dashboard') }}" class="sidebar-brand flex-grow-1">
        <div style="width: 36px; height: 36px; background: var(--admin-accent); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
          <i class="bi bi-heart-pulse-fill text-white fs-5"></i>
        </div>
        <div class="min-w-0">
          <div class="fw-bold fs-6 brand-font leading-tight text-truncate text-white">{{ $profile->name_en ?? 'Doctor Portal' }}</div>
          <div class="small" style="font-size: 0.72rem; color: #94a3b8;">Admin Management</div>
        </div>
      </a>
      <button type="button" class="btn btn-sm text-white-50 p-2 me-2 d-lg-none" id="sidebarCloseBtn" aria-label="Close sidebar">
        <i class="bi bi-x-lg fs-5"></i>
      </button>
    </div>

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

      <a href="{{ route('admin.articles.index') }}" class="sidebar-link {{ request()->routeIs('admin.articles.*') || request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
        <i class="bi bi-pencil-square"></i>
        <span>Blog Posts</span>
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

    <div class="px-3 pt-2 pb-2 border-top border-secondary border-opacity-25">
      <div class="p-2.5 rounded-3 text-center mb-2" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
        <div class="d-flex align-items-center justify-content-center gap-1.5 mb-1">
          <span style="display: inline-block; width: 7px; height: 7px; border-radius: 50%; background: #10b981; box-shadow: 0 0 6px #10b981;"></span>
          <span class="text-white fw-bold" style="font-size: 0.78rem;">Engineered by Solve IT</span>
        </div>
        <a href="https://solveitbd.com/" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-light w-100 py-1 px-2 d-inline-flex align-items-center justify-content-center gap-1 text-nowrap" style="font-size: 0.72rem; border-color: rgba(255,255,255,0.25);">
          <span>Tech Support & Maintenance</span>
          <i class="bi bi-arrow-up-right" style="font-size: 0.65rem;"></i>
        </a>
      </div>
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
      <div class="d-flex align-items-center gap-2 min-w-0 flex-grow-1 overflow-hidden me-2">
        <button class="btn btn-light d-lg-none p-1 px-2 border flex-shrink-0" type="button" id="sidebarToggle" aria-label="Toggle navigation drawer">
          <i class="bi bi-list fs-5"></i>
        </button>
        <h1 class="topbar-title fs-6 fw-bold mb-0 brand-font text-dark text-truncate">@yield('page_heading', 'Admin Overview')</h1>
      </div>

      <div class="d-flex align-items-center gap-2 flex-shrink-0">
        <a href="{{ route('admin.prescriptions.create') }}" class="btn btn-sm btn-success d-none d-sm-inline-flex align-items-center gap-1.5 shadow-sm px-2.5 py-1">
          <i class="bi bi-plus-circle-fill"></i>
          <span>New Prescription</span>
        </a>
        <div class="vr mx-1 d-none d-sm-block"></div>
        <div class="d-flex align-items-center gap-1.5">
          <div style="width: 32px; height: 32px; background: #e0f2fe; color: #0284c7; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.78rem;" title="{{ auth()->user()->name ?? 'Doctor' }}">
            DR
          </div>
          <span class="small fw-semibold d-none d-md-inline">{{ auth()->user()->name ?? ($profile->name_en ?? 'Doctor') }}</span>
        </div>
      </div>
    </header>

    <main class="admin-content">
      <div class="container-fluid px-3 py-2">
        {{-- Flash Messages --}}
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-3" role="alert">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <div class="fw-bold mb-1 small">Please fix the following issues:</div>
            <ul class="mb-0 small ps-3">
              @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @yield('content')
      </div>
    </main>
  </div>

  {{-- Mobile Bottom Navigation Dock (Thumb-friendly for phones) --}}
  <nav class="admin-mobile-dock d-lg-none" aria-label="Mobile Navigation Dock">
    <div class="dock-inner">
      <a href="{{ route('admin.dashboard') }}" class="dock-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
      </a>

      <a href="{{ route('admin.serials.index') }}" class="dock-item {{ request()->routeIs('admin.serials.*') ? 'active' : '' }}">
        <i class="bi bi-calendar-check"></i>
        <span>Queue</span>
      </a>

      <a href="{{ route('admin.prescriptions.create') }}" class="dock-item dock-item-highlight {{ request()->routeIs('admin.prescriptions.create') ? 'active' : '' }}">
        <div class="dock-icon-circle">
          <i class="bi bi-plus-lg"></i>
        </div>
        <span>New Rx</span>
      </a>

      <a href="{{ route('admin.prescriptions.index') }}" class="dock-item {{ request()->routeIs('admin.prescriptions.*') && !request()->routeIs('admin.prescriptions.create') ? 'active' : '' }}">
        <i class="bi bi-file-earmark-medical"></i>
        <span>Rx List</span>
      </a>

      <button type="button" class="dock-item" id="mobileMenuDockBtn" aria-label="Open Admin Menu">
        <i class="bi bi-grid-fill"></i>
        <span>Menu</span>
      </button>
    </div>
  </nav>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var sidebar = document.getElementById('adminSidebar');
      var backdrop = document.getElementById('sidebarBackdrop');
      var toggleBtn = document.getElementById('sidebarToggle');
      var closeBtn = document.getElementById('sidebarCloseBtn');
      var dockMenuBtn = document.getElementById('mobileMenuDockBtn');

      function openSidebar() {
        if (sidebar) sidebar.classList.add('show');
        if (backdrop) backdrop.classList.add('show');
        document.body.classList.add('sidebar-open');
      }

      function closeSidebar() {
        if (sidebar) sidebar.classList.remove('show');
        if (backdrop) backdrop.classList.remove('show');
        document.body.classList.remove('sidebar-open');
      }

      if (toggleBtn) {
        toggleBtn.addEventListener('click', function(e) {
          e.stopPropagation();
          if (sidebar && sidebar.classList.contains('show')) {
            closeSidebar();
          } else {
            openSidebar();
          }
        });
      }

      if (dockMenuBtn) {
        dockMenuBtn.addEventListener('click', function(e) {
          e.stopPropagation();
          openSidebar();
        });
      }

      if (closeBtn) {
        closeBtn.addEventListener('click', function(e) {
          e.stopPropagation();
          closeSidebar();
        });
      }

      if (backdrop) {
        backdrop.addEventListener('click', function() {
          closeSidebar();
        });
      }

      // Close on Escape key
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar && sidebar.classList.contains('show')) {
          closeSidebar();
        }
      });

      // Close when tapping any sidebar link on mobile
      if (sidebar) {
        sidebar.querySelectorAll('.sidebar-link').forEach(function(link) {
          link.addEventListener('click', function() {
            if (window.innerWidth < 992) {
              closeSidebar();
            }
          });
        });
      }
    });
  </script>
  @yield('scripts')
  @stack('scripts')
</body>
</html>

