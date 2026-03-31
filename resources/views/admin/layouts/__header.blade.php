<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title') | Nusara</title>
    <!-- Favicon / Brand Icon -->
    <link rel="icon" type="image/png" href="{{ asset('build/assets/logo_nusara.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('build/assets/logo_nusara.png') }}">

    <link rel="stylesheet" crossorigin href="{{ asset('assets/admin/compiled/css/app.css') }}" />
    <link
      rel="stylesheet"
      crossorigin
      href="{{ asset('assets/admin/compiled/css/app-dark.css') }}"
    />
    <link
      rel="stylesheet"
      crossorigin
      href="{{ asset('assets/admin/compiled/css/iconly.css') }}"
    />

    @yield('css')

    <!-- Nusara Brand Override: Ganti warna biru Mazer dengan hijau Nusara -->
    <style>
      /* Logo sidebar */
      .sidebar-wrapper .sidebar-header .logo a {
          color: #4ade80 !important;
          font-weight: 800 !important;
          font-size: 1.3rem !important;
          letter-spacing: 0.5px;
          display: flex;
          align-items: center;
          gap: 8px;
          text-decoration: none;
      }
      .sidebar-wrapper .sidebar-header .logo a::before {
          content: '';
          display: inline-block;
          width: 28px;
          height: 28px;
          background: url('/build/assets/logo_nusara.png') center / cover no-repeat;
          border-radius: 6px;
          flex-shrink: 0;
      }

      /* Sidebar item aktif & hover — LIGHT MODE */
      html body .sidebar-wrapper .sidebar-menu ul li.sidebar-item.active > .sidebar-link,
      html body .sidebar-wrapper .sidebar-menu ul li.sidebar-item > .sidebar-link:hover {
          background: rgba(25, 135, 84, 0.15) !important;
          color: #145a32 !important;
      }
      html body .sidebar-wrapper .sidebar-menu ul li.sidebar-item.active > .sidebar-link span,
      html body .sidebar-wrapper .sidebar-menu ul li.sidebar-item > .sidebar-link:hover span {
          color: #145a32 !important;
      }
      html body .sidebar-wrapper .sidebar-menu ul li.sidebar-item.active > .sidebar-link i,
      html body .sidebar-wrapper .sidebar-menu ul li.sidebar-item > .sidebar-link:hover i {
          color: #198754 !important;
      }
      html body .sidebar-wrapper .sidebar-menu ul li.sidebar-item.active > .sidebar-link::before {
          background-color: #198754 !important;
      }

      /* Sidebar item aktif & hover — DARK MODE */
      html[data-bs-theme="dark"] body .sidebar-wrapper .sidebar-menu ul li.sidebar-item.active > .sidebar-link,
      html[data-bs-theme="dark"] body .sidebar-wrapper .sidebar-menu ul li.sidebar-item > .sidebar-link:hover {
          background: rgba(25, 135, 84, 0.2) !important;
          color: #ffffff !important;
      }
      html[data-bs-theme="dark"] body .sidebar-wrapper .sidebar-menu ul li.sidebar-item.active > .sidebar-link span,
      html[data-bs-theme="dark"] body .sidebar-wrapper .sidebar-menu ul li.sidebar-item > .sidebar-link:hover span {
          color: #ffffff !important;
      }
      html[data-bs-theme="dark"] body .sidebar-wrapper .sidebar-menu ul li.sidebar-item.active > .sidebar-link i,
      html[data-bs-theme="dark"] body .sidebar-wrapper .sidebar-menu ul li.sidebar-item > .sidebar-link:hover i {
          color: #4ade80 !important;
      }

      /* =============================================
         GANTI SEMUA BIRU MAZER → HIJAU NUSARA
         ============================================= */

      /* Stat Card Icons (avatar/icon box) */
      .stats-icon.purple, .stats-icon.blue,
      .avatar.bg-primary, .avatar.bg-info,
      [class*="bg-primary"]:not(.btn):not(input):not(.badge),
      [class*="bg-info"]:not(.btn):not(input):not(.badge) {
          background-color: rgba(25, 135, 84, 0.18) !important;
          color: #4ade80 !important;
      }
      .stats-icon.purple i, .stats-icon.blue i,
      .avatar.bg-primary i, .avatar.bg-info i {
          color: #4ade80 !important;
      }

      /* Tombol primary & info */
      .btn-primary, .btn-info {
          background-color: #198754 !important;
          border-color: #198754 !important;
          color: #fff !important;
      }
      .btn-primary:hover, .btn-info:hover {
          background-color: #157347 !important;
          border-color: #146c43 !important;
      }
      .btn-outline-primary {
          color: #198754 !important;
          border-color: #198754 !important;
      }
      .btn-outline-primary:hover {
          background-color: #198754 !important;
          color: #fff !important;
      }

      /* Link biru → hijau */
      a.text-primary, .text-primary {
          color: #198754 !important;
      }

      /* Badge */
      .badge.bg-primary, .badge.bg-info {
          background-color: #198754 !important;
      }
      .badge.bg-light-primary, .badge.bg-light-info {
          background-color: rgba(25, 135, 84, 0.15) !important;
          color: #198754 !important;
      }

      /* Progress bar */
      .progress-bar.bg-primary, .progress-bar.bg-info {
          background-color: #198754 !important;
      }

      /* Form focus ring */
      .form-control:focus, .form-select:focus {
          border-color: #198754 !important;
          box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.2) !important;
      }

      /* Nav tabs / pills aktif */
      .nav-pills .nav-link.active,
      .nav-tabs .nav-link.active {
          background-color: #198754 !important;
          border-color: #198754 !important;
          color: #fff !important;
      }

      /* Pagination aktif */
      .page-item.active .page-link {
          background-color: #198754 !important;
          border-color: #198754 !important;
      }
      .page-link {
          color: #198754 !important;
      }

      /* Checkbox & radio checked */
      .form-check-input:checked {
          background-color: #198754 !important;
          border-color: #198754 !important;
      }

      /* =============================================
         BADGE: Settlement berbeda dari Cooked
         bg-primary → Teal/Cyan agar beda dari hijau
         ============================================= */
      .badge.bg-primary {
          background-color: #0d6efd !important; /* Biru murni khusus badge settlement */
      }

      /* =============================================
         DARK MODE: Ganti background biru Mazer → hijau gelap Nusara
         ============================================= */
      html[data-bs-theme="dark"] body,
      html[data-bs-theme="dark"] #app,
      html[data-bs-theme="dark"] #main {
          background-color: #050f0a !important;
      }
      html[data-bs-theme="dark"] #sidebar .sidebar-wrapper {
          background-color: #030a07 !important;
      }
      html[data-bs-theme="dark"] .card {
          background-color: #081509 !important;
      }
      html[data-bs-theme="dark"] .card-header,
      html[data-bs-theme="dark"] .card-footer {
          background-color: #060f07 !important;
          border-color: rgba(255,255,255,0.05) !important;
      }
      html[data-bs-theme="dark"] header.mb-3,
      html[data-bs-theme="dark"] footer {
          background-color: transparent !important;
      }
      html[data-bs-theme="dark"] .table {
          background-color: transparent !important;
      }
      html[data-bs-theme="dark"] .table td,
      html[data-bs-theme="dark"] .table th {
          border-color: rgba(255,255,255,0.06) !important;
      }
    </style>
  </head>
