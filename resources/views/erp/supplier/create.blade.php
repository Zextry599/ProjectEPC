@extends('templates/main')

@section('css')
<link rel="stylesheet" href="{{ asset('css/manage_account/new_account/style.css') }}">
@endsection

@section('content')
<div class="row page-title-header">
  <div class="col-12">
    <div class="page-header d-flex justify-content-start align-items-center">
      <div class="quick-link-wrapper d-md-flex flex-md-wrap">
        <ul class="quick-links">
          <li><a href="{{ url('/erp/supplier') }}">Daftar Supplier</a></li>
          <li><a href="{{ url('/erp/supplier/create') }}">Supplier Baru</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card card-noborder b-radius">
      <div class="card-body">
        <form action="{{ route('supplier.store') }}" method="POST" name="supplier_form">
          @csrf

          <div class="form-group row">
            <label class="col-12 font-weight-bold col-form-label">Nama <span class="text-danger">*</span></label>
            <div class="col-12">
              <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama Supplier" required>
            </div>
            <div class="col-12 error-notice" id="nama_error"></div>
          </div>

          <div class="form-group row">
            <label class="col-12 font-weight-bold col-form-label">Alamat</label>
            <div class="col-12">
              <input type="text" class="form-control" name="alamat" placeholder="Masukkan Alamat Supplier">
            </div>
            <div class="col-12 error-notice" id="alamat_error"></div>
          </div>

          <div class="form-group row">
            <label class="col-12 font-weight-bold col-form-label">Telepon</label>
            <div class="col-12">
              <input type="text" class="form-control" name="telepon" placeholder="Masukkan Nomor Telepon">
            </div>
            <div class="col-12 error-notice" id="telepon_error"></div>
          </div>

          <div class="form-group row">
            <label class="col-12 font-weight-bold col-form-label">Email</label>
            <div class="col-12">
              <input type="email" class="form-control" name="email" placeholder="Masukkan Email Supplier">
            </div>
            <div class="col-12 error-notice" id="email_error"></div>
          </div>

          <div class="row mt-5">
            <div class="col-12 d-flex justify-content-end">
              <button class="btn simpan-btn btn-sm" type="submit"><i class="mdi mdi-content-save"></i> Simpan</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
  @if ($message = Session::get('error'))
    swal("", "{{ $message }}", "error");
  @endif
</script>
@endsection
