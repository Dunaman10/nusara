@extends('admin.layouts.master')
@section('title', 'Edit Menu')

@section('content')

  <div class="card">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Edit Data Role</h3>
          <p class="text-subtitle text-muted">Silahkan isi data role yang ingin diubah</p>
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
      <form class="for" action="{{ route('roles.update', $role->id) }}" enctype="multipart/form-data" method="post">
        @csrf
        @method('PUT')
        <div class="form-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="role_name">Nama Role</label>
                <input type="text" class="form-control" id="role_name" placeholder="masukkan name" name="role_name" required value="{{ $role->role_name }}">
              </div>

              <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea type="text" class="form-control" id="description" placeholder="masukkan deskripsi" name="description" required>{{ $role->description }}</textarea>
              </div>

                <div class="form-group d-flex justify-content-end">
                <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                <a href="{{ route('roles.index') }}" type="submit" class="btn btn-danger me-1 mb-1">Batal</a>
              </div>

          </div>
        </div>
      </form>
    </div>
  </div>

@endsection
