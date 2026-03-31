<!doctype html>
<html lang="en" data-bs-theme="dark">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Nusara</title>
    <!-- Favicon / Brand Icon -->
    <link rel="icon" type="image/png" href="{{ asset('build/assets/logo_nusara.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('build/assets/logo_nusara.png') }}">
    <link rel="stylesheet" crossorigin="" href="{{ asset('assets/admin/compiled/css/app.css') }}" />
    <link rel="stylesheet" crossorigin="" href="{{ asset('assets/admin/compiled/css/app-dark.css') }}" />
    <link rel="stylesheet" crossorigin="" href="{{ asset('assets/admin/compiled/css/auth.css') }}" />
    <style>
      /* Nusara Brand Override */
      #auth #auth-left {
          background-color: #111827;
      }
      #auth #auth-right {
          background: linear-gradient(135deg, rgba(33,37,41,0.95), rgba(25,135,84,0.9)),
                      url('https://images.unsplash.com/photo-1543353071-873f17a7a088?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center center / cover no-repeat !important;
          background-color: #111827 !important;
      }
      /* Hapus warna biru Mazer dari wrapper utama */
      #auth {
          background-color: #111827 !important;
      }
      body, html {
          background-color: #111827 !important;
      }
      /* Pastikan tidak ada elemen biru tersisa */
      .col-lg-7, #auth .row {
          background-color: transparent !important;
      }
      .auth-logo {
          margin-bottom: 1.5rem !important; /* Konsisten, tidak terlalu jauh */
      }
      .brand-name {
          font-size: 1.4rem;
          font-weight: 800;
          color: #4ade80; /* Aksen hijau segar */
          letter-spacing: 0.5px;
      }
      .auth-title {
          font-size: 2rem !important;
          margin-bottom: 0.5rem !important;
      }
      .auth-subtitle {
          color: #9ca3af !important;
      }
      .btn-primary {
          background-color: #198754 !important;
          border-color: #198754 !important;
      }
      .btn-primary:hover {
          background-color: #157347 !important;
          border-color: #157347 !important;
      }
      #auth-left .form-control {
          background-color: #1f2937 !important;
          border-color: #374151 !important;
          color: #f9fafb !important;
      }
      #auth-left .form-control:focus {
          border-color: #198754 !important;
          box-shadow: 0 0 0 0.2rem rgba(25,135,84,0.25) !important;
      }
    </style>
  </head>

  <body>
    <script src="{{ asset('assets/admin/static/js/initTheme.js') }}"></script>
    <div id="auth">
      <div class="row h-100">
        <div class="col-lg-5 col-12">
          <div id="auth-left">
            <div class="auth-logo d-flex align-items-center gap-2">
              <img src="{{ asset('build/assets/logo_nusara.png') }}" alt="Nusara" style="height: 38px; width: 38px; object-fit: contain; border-radius: 8px;">
              <span class="brand-name">Nusara</span>
            </div>
            <h1 class="auth-title">Log in.</h1>
            <p class="auth-subtitle mb-4">
              Masuk ke dashboard Nusara untuk mengelola restoran Anda.
            </p>

            <form method="POST" action="{{ route('login') }}">
              @csrf
              <div class="form-group position-relative has-icon-left mb-4">
                <input
                  type="email"
                  class="form-control form-control-xl"
                  placeholder="Email"
                  name="email"
                  value="{{ old('email') }}"
                  required
                  autofocus
                />
                <div class="form-control-icon">
                  <i class="bi bi-person"></i>
                </div>
              </div>
              <div class="form-group position-relative has-icon-left mb-4">
                <input
                  type="password"
                  class="form-control form-control-xl"
                  placeholder="Password"
                  name="password"
                  required
                  autocomplete="current-password"
                />
                <div class="form-control-icon">
                  <i class="bi bi-shield-lock"></i>
                </div>
              </div>
              <button class="btn btn-primary btn-block btn-lg shadow-lg mt-3">
                Log in
              </button>
            </form>
          </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
          <div id="auth-right"></div>
        </div>
      </div>
    </div>
  </body>
</html>
