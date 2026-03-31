@extends('admin.layouts.master')
@section('title', 'Edit Karyawan')

@section('content')

  <div class="card">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Edit Data Karyawan</h3>
          <p class="text-subtitle text-muted">Silahkan isi data karyawan yang ingin diubah</p>
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
      <form class="for" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data" method="post">
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
                    <option value="{{ $r->id }}" {{ $user->restaurant_id == $r->id ? 'selected' : '' }}>{{ $r->name }}</option>
                  @endforeach
                </select>
              </div>
              @else
              <input type="hidden" name="restaurant_id" value="{{ $user->restaurant_id }}">
              @endif

              <div class="form-group">
                <label for="fullname">Nama Karyawan</label>
                <input type="text" class="form-control" id="fullname" placeholder="masukkan nama karyawan" name="fullname" required value="{{ $user->fullname }}">
              </div>

              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" placeholder="masukkan username" name="username" required value="{{ $user->username }}">
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="masukkan email" name="email" required value="{{ $user->email }}">
              </div>

              <div class="form-group">
                <label for="phone">Nomor Telepon</label>
                <input type="tel" class="form-control" id="phone" placeholder="masukkan nomor telepon" name="phone" value="{{ $user->phone }}">
              </div>

              <div class="form-group">
                <label for="role_id">Role</label>
                <select class="form-control" id="role_id" name="role_id" required>
                  <option value="" disabled>Pilih role</option>
                  @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->role_name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label for="password">Password (Opsional)</label>
                <input type="password" class="form-control" id="password" placeholder="kosongkan jika tidak ingin mengubah password" name="password">
                <small><a href="#" class="toggle-password" data-target="password">Lihat password</a></small>
              </div>

              <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" class="form-control" id="password_confirmation" placeholder="konfirmasi password baru" name="password_confirmation">
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

@endsection

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
