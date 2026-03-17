@include('admin.layouts.__header')

  <body>
    <script src="assets/static/js/initTheme.js"></script>
    @include('admin.layouts.__sidebar')

    <div id="app">


      <div id="main">
        <header class="mb-3">
          <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
          </a>
        </header>

      @yield('content')

      @include('admin.layouts.__footer')
      </div>
    </div>

    <script src="assets/admin/static/js/components/dark.js"></script>
    <script src="assets/admin/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <script src="assets/admin/compiled/js/app.js"></script>

    <!-- Need: Apexcharts -->
    <script src="assets/admin/extensions/apexcharts/apexcharts.min.js"></script>
    <script src="assets/admin/static/js/pages/dashboard.js"></script>

    @yield('script')

  </body>
</html>
