@extends('templates/main')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/manage_member/style.css') }}">
@endsection

@section('content')
  <div class="row page-title-header">
    <div class="col-12">
      <div class="page-header d-flex justify-content-between align-items-center">
        <h4 class="page-title">Tambah Member</h4>
        <a href="{{ route('member.index') }}" class="btn btn-icons btn-inverse-primary btn-back">
          <i class="mdi mdi-arrow-left"></i>
        </a>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 grid-margin">
      <div class="card card-noborder b-radius">
        <div class="card-body">
          <form action="{{ route('member.store') }}" method="POST">
            @csrf
            <div class="form-group row">
              <label class="col-3 col-form-label font-weight-bold">Nama</label>
              <div class="col-9">
                <input type="text" name="nama" class="form-control" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-3 col-form-label font-weight-bold">Email</label>
              <div class="col-9">
                <input type="email" name="email" class="form-control">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-3 col-form-label font-weight-bold">No HP</label>
              <div class="col-9">
                <input type="text" name="no_hp" class="form-control" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-3 col-form-label font-weight-bold">Alamat</label>
              <div class="col-9">
                <textarea name="alamat" rows="3" class="form-control"></textarea>
              </div>
            </div>
            <div class="form-group row mb-0">
              <div class="col-9 offset-3">
                <button type="submit" class="btn btn-primary">
                  <i class="mdi mdi-content-save"></i> Simpan
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection