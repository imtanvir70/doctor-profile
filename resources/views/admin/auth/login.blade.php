<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor Portal Login | Dr. Abu Hanif Rakib</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #0F3B66 0%, #071728 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
    }
    .login-card {
      background: #FFFFFF;
      border-radius: 20px;
      padding: 2.5rem;
      width: 100%;
      max-w: 440px;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
    }
    .brand-icon-box {
      width: 54px;
      height: 54px;
      background: #0F3B66;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.6rem;
      color: #FFFFFF;
      margin: 0 auto 1.25rem;
      box-shadow: 0 8px 20px rgba(15, 59, 102, 0.3);
    }
    .form-control {
      padding: 0.75rem 1rem;
      border-radius: 10px;
      border-color: #cbd5e1;
    }
    .form-control:focus {
      border-color: #0F3B66;
      box-shadow: 0 0 0 3px rgba(15, 59, 102, 0.15);
    }
    .btn-login {
      background: linear-gradient(135deg, #059669 0%, #047857 100%);
      color: #FFFFFF;
      padding: 0.8rem;
      border-radius: 10px;
      font-weight: 700;
      border: none;
      transition: all 0.2s ease;
    }
    .btn-login:hover {
      background: linear-gradient(135deg, #047857 0%, #065f46 100%);
      transform: translateY(-1px);
    }
  </style>
</head>
<body>

  <div class="login-card" style="max-width: 440px;">
    <div class="brand-icon-box">
      <i class="bi bi-heart-pulse-fill"></i>
    </div>
    
    <div class="text-center mb-4">
      <h1 class="fs-4 fw-bold mb-1 text-dark" style="font-family: 'Outfit', sans-serif;">Doctor & EMR Portal</h1>
      <p class="small text-muted mb-0">Sign in to manage Serials, Prescriptions & SEO</p>
    </div>

    @if($errors->any())
      <div class="alert alert-danger py-2 px-3 small rounded-3 mb-3">
        {{ $errors->first() }}
      </div>
    @endif

    @if(session('success'))
      <div class="alert alert-success py-2 px-3 small rounded-3 mb-3">
        {{ session('success') }}
      </div>
    @endif

    <form action="{{ route('admin.login.submit') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label for="email" class="form-label small fw-semibold text-secondary">Doctor Email</label>
        <div class="input-group">
          <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-envelope-fill"></i></span>
          <input type="email" class="form-control border-start-0 ps-0" id="email" name="email" value="{{ old('email', 'admin@drabuhanifrakib.com') }}" placeholder="admin@drabuhanifrakib.com" required autofocus>
        </div>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label small fw-semibold text-secondary">Password</label>
        <div class="input-group">
          <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-lock-fill"></i></span>
          <input type="password" class="form-control border-start-0 ps-0" id="password" name="password" placeholder="••••••••" required>
        </div>
      </div>

      <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="remember" name="remember" checked>
          <label class="form-check-label small text-muted" for="remember">Keep me logged in</label>
        </div>
        <span class="small text-muted">Demo: admin123</span>
      </div>

      <button type="submit" class="btn btn-login w-100 mb-3">
        <i class="bi bi-box-arrow-in-right me-1"></i> Sign In to Dashboard
      </button>

      <div class="text-center">
        <a href="{{ route('home') }}" class="small text-muted text-decoration-none">
          <i class="bi bi-arrow-left me-1"></i> Back to Public Website
        </a>
      </div>
    </form>
  </div>

</body>
</html>

