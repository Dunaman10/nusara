@extends('admin.layouts.master')
@section('title', 'Daftar Kategori')

@section('css')
<link rel="stylesheet" href={{ asset('assets/admin/extensions/simple-datatables/style.css') }}>
<link rel="stylesheet" href={{ asset('assets/admin/compiled/css/table-datatable.css') }}>
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Manajemen Kategori</h3>
                <p class="text-subtitle text-muted">Informasi Kategori yang Terdaftar</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <a href="{{ route('categories.create') }}" class="btn btn-primary float-lg-end">
                  <i class="bi bi-plus"></i> Tambah Kategori
                </a>
            </div>
        </div>
    </div>
    <section class="section">
      <div class="card">
        <div class="card-body">
          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" role="alert">
              <p><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</p>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif
          <table class="table table-striped" id="table1">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($categories as $category)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $category->cat_name }}</td>
                  <td>{{ $category->description }}</td>
                  <td class="d-flex gap-2">
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">
                      <i class="bi bi-pencil"></i> Ubah
                    </a>
                    <form method="POST" action="{{ route('categories.destroy', $category->id) }}">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin hapus?')">
                        <i class="bi bi-trash"></i> Hapus
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
<script src={{ asset('assets/admin/exstensions/simple-datatables/umd/simple-datatables.js') }}></script>
<script src={{ asset('assets/admin/static/js/pages/simple-datatables.js') }}></script>
@endsection
