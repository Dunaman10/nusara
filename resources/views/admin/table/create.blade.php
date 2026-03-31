@extends('admin.layouts.master')
@section('title', 'Tambah Meja')

@section('content')
  <div class="card">
    <div class="page-title p-4 pb-0">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Tambah Data Meja</h3>
          <p class="text-subtitle text-muted">Buat meja baru dan generate QR Code otomatis</p>
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
      
      <form action="{{ route('tables.store') }}" method="post">
        @csrf
        <div class="form-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="restaurant_id">Restoran</label>
                <select class="form-select" id="restaurant_id" name="restaurant_id" required>
                  <option value="" selected disabled>-- Pilih Restoran --</option>
                  @foreach($restaurants as $r)
                    <option value="{{ $r->id }}" {{ old('restaurant_id') == $r->id ? 'selected' : '' }}>
                      {{ $r->name }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label for="name">Nama/Nomor Meja</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Meja 1, VIP A" required>
              </div>
            </div>
            
            <div class="col-md-12 my-3">
              <div class="form-check form-switch ps-0">
                <label class="form-check-label" for="is_active">Status Aktif</label>
                <input class="form-check-input ms-2" type="checkbox" id="is_active" name="is_active" value="1" checked>
              </div>
            </div>

            <div class="form-group d-flex justify-content-end mt-3">
              <button type="submit" class="btn btn-primary me-1 mb-1">Simpan & Generate QR</button>
              <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
              <a href="{{ route('tables.index') }}" class="btn btn-danger me-1 mb-1">Batal</a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection
