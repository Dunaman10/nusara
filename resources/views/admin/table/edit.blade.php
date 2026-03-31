@extends('admin.layouts.master')
@section('title', 'Ubah Meja')

@section('content')
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="page-title p-4 pb-0">
          <div class="row">
            <div class="col-12 col-md-12 order-md-1 order-last">
              <h3>Ubah Data Meja</h3>
              <p class="text-subtitle text-muted">Perbarui data meja (Catatan: QR code akan diperbarui otomatis jika nama atau restoran berubah)</p>
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
          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <p><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</p>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif
          
          <form action="{{ route('tables.update', $table->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="restaurant_id">Restoran</label>
                    <select class="form-select" id="restaurant_id" name="restaurant_id" required>
                      <option value="" disabled>-- Pilih Restoran --</option>
                      @foreach($restaurants as $r)
                        <option value="{{ $r->id }}" {{ old('restaurant_id', $table->restaurant_id) == $r->id ? 'selected' : '' }}>
                          {{ $r->name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name">Nama/Nomor Meja</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $table->name) }}" required>
                  </div>
                </div>
                
                <div class="col-md-12 my-3">
                  <div class="form-check form-switch ps-0">
                    <label class="form-check-label" for="is_active">Status Aktif</label>
                    <input class="form-check-input ms-2" type="checkbox" id="is_active" name="is_active" value="1" {{ $table->is_active ? 'checked' : '' }}>
                  </div>
                </div>

                <div class="form-group d-flex justify-content-end mt-3">
                  <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                  <a href="{{ route('tables.index') }}" class="btn btn-danger me-1 mb-1">Batal</a>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card">
        <div class="card-header pb-0">
          <h4 class="card-title">QR Code <span class="badge bg-light-primary text-primary">{{ $table->name }}</span></h4>
        </div>
        <div class="card-content">
          <div class="card-body text-center">
            @if($table->getQrCodeImageUrl())
              <img src="{{ $table->getQrCodeImageUrl() }}" alt="QR Code" class="img-fluid border rounded p-2 mb-3" style="max-width: 200px;">
              <p class="text-muted small word-break">{{ $table->qr_code_url }}</p>
              
              <div class="d-flex flex-column gap-2 mt-4">
                <a href="{{ route('tables.downloadQr', $table->id) }}" class="btn btn-info text-white w-100">
                  <i class="bi bi-download"></i> Download SVG
                </a>
                <a href="{{ route('tables.printQr', $table->id) }}" target="_blank" class="btn btn-secondary w-100">
                  <i class="bi bi-printer"></i> Print QR
                </a>
                
                <form action="{{ route('tables.regenerateQr', $table->id) }}" method="POST" class="mt-2">
                  @csrf
                  <button type="submit" class="btn btn-outline-warning w-100" onclick="return confirm('Generate ulang QR Code? QR lama akan tidak valid jika URL berubah.')">
                    <i class="bi bi-arrow-clockwise"></i> Generate Ulang
                  </button>
                </form>
              </div>
            @else
              <div class="alert alert-light-warning">
                QR Code belum ter-generate.
              </div>
              <form action="{{ route('tables.regenerateQr', $table->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary w-100">
                  <i class="bi bi-qr-code"></i> Generate Sekarang
                </button>
              </form>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
