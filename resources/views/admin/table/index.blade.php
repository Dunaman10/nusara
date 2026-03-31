@extends('admin.layouts.master')
@section('title', 'Daftar Meja & QR Code')

@section('css')
<link rel="stylesheet" href={{ asset('assets/admin/extensions/simple-datatables/style.css') }}>
<link rel="stylesheet" href={{ asset('assets/admin/compiled/css/table-datatable.css') }}>
<style>
  .qr-preview {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border: 1px solid #ddd;
    border-radius: 4px;
    cursor: pointer;
  }
</style>
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Manajemen Meja & QR Code</h3>
                <p class="text-subtitle text-muted">Daftar meja untuk setiap restoran</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <a href="{{ route('tables.create') }}" class="btn btn-primary float-lg-end">
                  <i class="bi bi-plus"></i> Tambah Meja
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
          @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <p><i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}</p>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          @if(auth()->user()->role->role_name === 'super_admin')
          <form action="{{ route('tables.index') }}" method="GET" class="mb-4">
            <div class="row align-items-end">
              <div class="col-md-4">
                <label for="restaurant_id">Filter Restoran</label>
                <select name="restaurant_id" id="restaurant_id" class="form-select" onchange="this.form.submit()">
                  <option value="">-- Semua Restoran --</option>
                  @foreach($restaurants as $r)
                    <option value="{{ $r->id }}" {{ request('restaurant_id') == $r->id ? 'selected' : '' }}>
                      {{ $r->name }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
          </form>
          @endif

          <table class="table table-striped" id="table1">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Meja</th>
                @if(auth()->user()->role->role_name === 'super_admin')
                <th>Restoran</th>
                @endif
                <th>QR Preview</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($tables as $table)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $table->name }}</td>
                  @if(auth()->user()->role->role_name === 'super_admin')
                  <td>{{ $table->restaurant->name ?? '-' }}</td>
                  @endif
                  <td>
                    @if($table->getQrCodeImageUrl())
                      <a href="{{ $table->getQrCodeImageUrl() }}" target="_blank">
                        <img src="{{ $table->getQrCodeImageUrl() }}" class="qr-preview" alt="QR Code" title="Lihat ukuran penuh">
                      </a>
                    @else
                      <span class="text-muted">No QR</span>
                    @endif
                  </td>
                  <td>
                    @if($table->is_active)
                      <span class="badge bg-success">Aktif</span>
                    @else
                      <span class="badge bg-danger">Nonaktif</span>
                    @endif
                  </td>
                  <td class="d-flex flex-wrap gap-2">
                    <a href="{{ route('tables.edit', $table->id) }}" class="btn btn-warning btn-sm" title="Ubah">
                      <i class="bi bi-pencil"></i>
                    </a>
                    
                    @if($table->getQrCodeImageUrl())
                      <a href="{{ route('tables.downloadQr', $table->id) }}" class="btn btn-info btn-sm text-white" title="Download QR">
                        <i class="bi bi-download"></i>
                      </a>
                      <a href="{{ route('tables.printQr', $table->id) }}" target="_blank" class="btn btn-secondary btn-sm" title="Print QR">
                        <i class="bi bi-printer"></i>
                      </a>
                    @endif

                    <form method="POST" action="{{ route('tables.destroy', $table->id) }}">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus meja ini beserta QR Code-nya?')" title="Hapus">
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
