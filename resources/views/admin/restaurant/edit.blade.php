@extends('admin.layouts.master')
@section('title', 'Ubah Restoran')

@section('content')

  <div class="card">
    <div class="page-title p-4 pb-0">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Ubah Data Restoran</h3>
          <p class="text-subtitle text-muted">Perbarui informasi restoran</p>
        </div>
      </div>
    </div>

    <div class="card-body">
      @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <ul class="mb-0">
            @foreach($errors->all() as $error)
              <li><i class="bi bi-exclamation-triangle-fill"></i> {{ $error }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      
      <form action="{{ route('restaurants.update', $restaurant->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="name">Nama Restoran</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $restaurant->name) }}" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="slug">Slug (URL unik)</label>
                <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $restaurant->slug) }}" required>
                <small class="text-muted">Gunakan huruf kecil dan strip (contoh: cabang-jakarta)</small>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label for="phone">No HP / Telp</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $restaurant->phone) }}">
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $restaurant->email) }}">
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label for="address">Alamat</label>
                <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $restaurant->address) }}</textarea>
              </div>
            </div>
            
            <div class="col-md-12 mb-4">
              <div class="form-check form-switch ps-0">
                <label class="form-check-label" for="is_active">Status Aktif</label>
                <input class="form-check-input ms-2" type="checkbox" id="is_active" name="is_active" value="1" {{ $restaurant->is_active ? 'checked' : '' }}>
              </div>
            </div>

            <div class="form-group d-flex justify-content-end">
              <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
              <a href="{{ route('restaurants.index') }}" class="btn btn-danger me-1 mb-1">Batal</a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

@endsection
