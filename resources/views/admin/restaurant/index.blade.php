@extends('admin.layouts.master')
@section('title', 'Daftar Restoran')

@section('css')
<link rel="stylesheet" href={{ asset('assets/admin/extensions/simple-datatables/style.css') }}>
<link rel="stylesheet" href={{ asset('assets/admin/compiled/css/table-datatable.css') }}>
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Manajemen Restoran</h3>
                <p class="text-subtitle text-muted">Daftar Restoran (Tenant)</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <a href="{{ route('restaurants.create') }}" class="btn btn-primary float-lg-end">
                  <i class="bi bi-plus"></i> Tambah Restoran
                </a>
            </div>
        </div>
    </div>
    <section class="section">
      <div class="card">
        <div class="card-body">
          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <p><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</p>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif
          <table class="table table-striped" id="table1">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Restoran</th>
                <th>Slug</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($restaurants as $restaurant)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $restaurant->name }}</td>
                  <td>{{ $restaurant->slug }}</td>
                  <td>{{ Str::limit($restaurant->address, 30) }}</td>
                  <td>
                    @if($restaurant->is_active)
                      <span class="badge bg-success">Aktif</span>
                    @else
                      <span class="badge bg-danger">Nonaktif</span>
                    @endif
                  </td>
                  <td class="d-flex gap-2">
                    <a href="{{ route('restaurants.edit', $restaurant->id) }}" class="btn btn-warning btn-sm">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <form method="POST" action="{{ route('restaurants.destroy', $restaurant->id) }}">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus restoran ini? Semua tabel yang terhubung mungkin terdampak.')">
                        <i class="bi bi-trash"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </section>
</div>
@endsection

@section('script')
<script src={{ asset('assets/admin/extensions/simple-datatables/umd/simple-datatables.js') }}></script>
<script src={{ asset('assets/admin/static/js/pages/simple-datatables.js') }}></script>
@endsection
