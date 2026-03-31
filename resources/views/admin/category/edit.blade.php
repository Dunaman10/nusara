@extends('admin.layouts.master')
@section('title', 'Edit Kategori')

@section('content')

  <div class="card">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Edit Data Kategori</h3>
          <p class="text-subtitle text-muted">Silahkan isi data kategori yang ingin diubah</p>
        </div>
      </div>
    </div>

    <div class="card-body">
      @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert" role="alert">
          <ul class="mb-0">
            @foreach($errors->all() as $error)
              <li><i class="bi bi-exclamation-triangle-fill"></i> {{ $error }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      <form class="for" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data" method="post">
        @csrf
        @method('PUT')
        <div class="form-body">
          <div class="row">
            <div class="col-md-12">
              @if(auth()->user()->role->role_name === 'super_admin')
              <div class="form-group">
                <label for="restaurant_id">Restoran</label>
                <select id="restaurant_id" name="restaurant_id" class="form-select" required>
                  <option value="" disabled>Pilih Restoran</option>
                  @foreach ($restaurants as $r)
                    <option value="{{ $r->id }}" {{ $category->restaurant_id == $r->id ? 'selected' : '' }}>{{ $r->name }}</option>
                  @endforeach
                </select>
              </div>
              @else
              <input type="hidden" name="restaurant_id" value="{{ $category->restaurant_id }}">
              @endif

              <div class="form-group">
                <label for="cat_name">Nama Kategori</label>
                <input type="text" class="form-control" id="cat_name" placeholder="masukkan nama kategori" name="cat_name" required value="{{ $category->cat_name }}">
              </div>

              <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea class="form-control" id="description" placeholder="masukkan deskripsi kategori" name="description" required>{{ $category->description }}</textarea>
              </div>

                <div class="form-group d-flex justify-content-end">
                <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                <a href="{{ route('categories.index') }}" type="submit" class="btn btn-danger me-1 mb-1">Batal</a>
              </div>

          </div>
        </div>
      </form>
    </div>
  </div>

@endsection
