@extends('admin.layouts.master')
@section('title', 'Tambah Karyawan')

@section('content')

  <div class="card">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Tambah Data Karyawan</h3>
          <p class="text-subtitle text-muted">Silahkan isi data karyawan yang ingin ditambahkan</p>
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
      <form class="for" action="{{ route('users.store') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="form-body">
          <div class="row">
            <div class="col-md-12">
              @if(auth()->user()->role->role_name === 'super_admin')
              <div class="form-group">
                <label for="restaurant_id">Restoran</label>
                <select id="restaurant_id" name="restaurant_id" class="form-select" required>
                  <option value="" disabled selected>Pilih Restoran</option>
                  @foreach ($restaurants as $r)
                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                  @endforeach
                </select>
              </div>
              @else
              <input type="hidden" name="restaurant_id" value="{{ auth()->user()->restaurant_id }}">
              @endif

              <div class="form-group">
                <label for="name">Nama Karyawan</label>
                <input type="text" class="form-control" id="name" placeholder="masukkan nama karyawan" name="fullname" required>
              </div>

              <div class="form-group">
                <label for="name">Username</label>
                <input type="text" class="form-control" id="name" placeholder="masukkan username karyawan" name="username" required>
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="masukkan email karyawan" name="email" required>
              </div>

              <div class="form-group">
                <label for="phone">No. Telepon</label>
                <input type="tel" class="form-control" id="phone" placeholder="masukkan nomor telepon" name="phone" required>
              </div>

              <div class="form-group">
                <label for="role">Role</label>
                <select class="form-control" id="role" name="role_id" required>
                  <option value="">Pilih Role</option>
                  @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="masukkan password" name="password" required>
                <small><a href="#" class="toggle-password" data-target="password">Lihat password</a></small>
              </div>

              <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" class="form-control" id="password_confirmation" placeholder="konfirmasi password" name="password_confirmation" required>
                <small><a href="#" class="toggle-password" data-target="password_confirmation">Lihat password</a></small>
              </div>

              <div class="form-group d-flex justify-content-end">
                <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                <a href="{{ route('users.index') }}" type="submit" class="btn btn-danger me-1 mb-1">Batal</a>
              </div>

          </div>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.querySelectorAll('.toggle-password').forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        let input = document.getElementById(this.dataset.target);
        let isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        document.querySelector(`[data-target="${this.dataset.target}"]`).textContent = isHidden ? 'Sembunyikan password' : 'Lihat password';
      });
    });
  </script>

@endsection
