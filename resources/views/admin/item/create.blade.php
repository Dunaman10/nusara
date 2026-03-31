@extends('admin.layouts.master')
@section('title', 'Tambah Menu')

@section('content')

  <div class="card">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Tambah Data Menu</h3>
          <p class="text-subtitle text-muted">Silahkan isi data menu yang ingin ditambahkan</p>
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
      <form class="for" action="{{ route('items.store') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="form-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="restaurant_id">Restoran</label>
                <select id="restaurant_id" name="restaurant_id" class="form-select" required>
                  <option value="" disabled selected>Pilih Restoran</option>
                  @foreach ($restaurants as $r)
                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label for="name">Nama Menu</label>
                <input type="text" class="form-control" id="name" placeholder="masukkan name" name="name" required>
              </div>

              <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea type="text" class="form-control" id="description" placeholder="masukkan deskripsi" name="description" required></textarea>
              </div>

              <div class="form-group">
                <label for="price">Harga</label>
                <input type="number" class="form-control" id="price" placeholder="masukkan harga" name="price" required>
              </div>

              <div class="form-group">
                <label for="category">Kategori</label>
                <select id="category" name="category_id" class="form-select" required>
                  <option value="" disabled selected>Pilih Menu</option>
                  @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->cat_name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label for="img">Gambar</label>
                <input type="file" class="form-control" id="img" name="img" required>
              </div>

              <div class="form-group">
                <label for="is_active">Status</label>
                <div class="form-check form-switch">
                  <input type="hidden" name="is_active" value="0">
                  <input type="checkbox" class="form-check-input" id="flexSwitchCheckChecked" name="is_active" value="1" checked>
                  <label for="flexSwitchCheckChecked">Aktif/Tidak Aktif</label>
                </div>
              </div>

              <div class="form-group d-flex justify-content-end">
                <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                <a href="{{ route('items.index') }}" type="submit" class="btn btn-danger me-1 mb-1">Batal</a>
              </div>

          </div>
        </div>
      </form>
    </div>
  </div>

@endsection
