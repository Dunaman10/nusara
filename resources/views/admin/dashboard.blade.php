@extends('admin.layouts.master')
@section('title', 'Dashboard')

@section('css')
@endsection

@section('content')
<div class="page-heading">
  <h3>
    Selamat Datang, {{ Auth::user()->fullname }} - {{ Auth::user()->role->role_name }}
    @if(Auth::user()->role->role_name !== 'super_admin' && Auth::user()->restaurant)
      <span class="fs-5 text-muted">({{ Auth::user()->restaurant->name }})</span>
    @endif
  </h3>
</div>
<div class="page-content">
  <section class="row">
    <div class="col-12 col-lg-12">
      <div class="row">
        <div class="col-6 col-lg-3 col-md-6">
          <div class="card">
            <div class="card-body px-4 py-4-5">
              <div class="row">
                <div
                  class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start"
                >
                  <div class="stats-icon purple mb-2">
                    <i class="iconly-boldWallet"></i>
                  </div>
                </div>
                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                  <h6 class="text-muted font-semibold">
                    Pesanan Hari Ini
                  </h6>
                  <h6 class="font-extrabold mb-0">{{ $todayOrders }}</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 col-lg-3 col-md-6">
          <div class="card">
            <div class="card-body px-4 py-4-5">
              <div class="row">
                <div
                  class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start"
                >
                  <div class="stats-icon blue">
                    <i class="iconly-boldBuy"></i>
                  </div>
                </div>
                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                  <h6 class="text-muted font-semibold">
                    Pendapatan Hari Ini
                  </h6>
                  <h6 class="font-extrabold mb-0">{{ 'Rp ' . number_format($todayRevenue, 0, ',', '.') }}</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 col-lg-3 col-md-6">
          <div class="card">
            <div class="card-body px-4 py-4-5">
              <div class="row">
                <div
                  class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start"
                >
                  <div class="stats-icon purple mb-2">
                    <i class="iconly-boldFolder"></i>
                  </div>
                </div>
                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                  <h6 class="text-muted font-semibold">Total Pesanan</h6>
                  <h6 class="font-extrabold mb-0">{{ $totalOrders }}</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 col-lg-3 col-md-6">
          <div class="card">
            <div class="card-body px-4 py-4-5">
              <div class="row">
                <div
                  class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start"
                >
                  <div class="stats-icon blue mb-2">
                    <i class="iconly-boldProfile"></i>
                  </div>
                </div>
                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                  <h6 class="text-muted font-semibold">
                    Total Pendapatan
                  </h6>
                  <h6 class="font-extrabold mb-0">{{ 'Rp ' . number_format($totalRevenue, 0, ',', '.') }}</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <!-- Kolom Kiri -->
        <div class="col-12 col-xl-8">
          <div class="card">
            <div class="card-header">
              <h4>Grafik Pendapatan (7 Hari Terakhir)</h4>
            </div>
            <div class="card-body">
              <div id="chart-revenue"></div>
            </div>
          </div>
          
          <div class="card">
            <div class="card-header">
              <h4>Total Pesanan Harian (Batang)</h4>
            </div>
            <div class="card-body">
              <div id="chart-orders"></div>
            </div>
          </div>
        </div>

        <!-- Kolom Kanan -->
        <div class="col-12 col-xl-4">
          <div class="card">
            <div class="card-header">
              <h4>Status Keberhasilan Pesanan</h4>
            </div>
            <div class="card-body">
              <div id="chart-pie"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@section('script')
<script>
  // Deteksi dark mode agar warna text menyesuaikan (Mazer)
  var isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
  var themeMode = isDark ? 'dark' : 'light';

  // 1. Grafik Area (Pendapatan)
  var optionsRevenue = {
    theme: { mode: themeMode },
    chart: {
      type: 'area',
      height: 300,
      fontFamily: 'Nunito, sans-serif',
      toolbar: { show: false },
      background: 'transparent'
    },
    dataLabels: { enabled: false },
    stroke: { curve: 'smooth' },
    fill: { opacity: 0.3 },
    series: [{
      name: 'Pendapatan',
      data: @json($chartData)
    }],
    colors: ['#435ebe'],
    xaxis: { categories: @json($chartLabels) },
    yaxis: {
      labels: {
        formatter: function (value) { return "Rp " + value.toLocaleString("id-ID"); }
      }
    },
    tooltip: {
      y: { formatter: function (val) { return "Rp " + val.toLocaleString("id-ID"); } }
    }
  }

  // 2. Grafik Batang (Jumlah Pesanan)
  var optionsOrders = {
    theme: { mode: themeMode },
    chart: {
      type: 'bar',
      height: 300,
      fontFamily: 'Nunito, sans-serif',
      toolbar: { show: false },
      background: 'transparent'
    },
    dataLabels: { enabled: false },
    series: [{
      name: 'Pesanan',
      data: @json($barChartData)
    }],
    colors: ['#57caeb'],
    xaxis: { categories: @json($chartLabels) },
    yaxis: {
      labels: {
        formatter: function (value) { return Math.round(value); }
      }
    }
  }

  // 3. Grafik Lingkaran (Status Pesanan)
  var optionsPie = {
    theme: { mode: themeMode },
    chart: {
      type: 'donut',
      height: 350,
      fontFamily: 'Nunito, sans-serif',
      background: 'transparent'
    },
    series: @json($pieChartData),
    labels: @json($pieChartLabels),
    colors: ['#ffc107', '#198754', '#0dcaf0'],
    legend: { position: 'bottom' },
    dataLabels: { enabled: false },
    plotOptions: {
      pie: { donut: { size: '65%' } }
    }
  }

  new ApexCharts(document.querySelector("#chart-revenue"), optionsRevenue).render();
  new ApexCharts(document.querySelector("#chart-orders"), optionsOrders).render();
  new ApexCharts(document.querySelector("#chart-pie"), optionsPie).render();
</script>
@endsection
