@extends('templates/main')

@section('css')
<link rel="stylesheet" href="{{ asset('css/manage_mitra/new_akun/style.css') }}">
@endsection

@section('content')
<div class="row page-title-header">
  <div class="col-12">
    <div class="page-header d-flex justify-content-start align-items-center">
      <div class="quick-link-wrapper d-md-flex flex-md-wrap">
        <ul class="quick-links">
          <li><a href="{{ route('store.index') }}">Daftar Toko</a></li>
          <li><a href="{{ route('store.create') }}">Tambah Toko</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="row">
	<div class="col-12">
		<div class="card card-noborder b-radius">
			<div class="card-body">
				<form action="{{ route('store.store') }}" method="POST">
				  @csrf
				  <div class="form-group row">
				  	<label class="col-12 font-weight-bold col-form-label">Nama Toko <span class="text-danger">*</span></label>
				  	<div class="col-12">
				  		<input type="text" class="form-control" name="name" placeholder="Masukkan Nama Toko" required>
				  	</div>
				  	<div class="col-12 error-notice" id="name_error"></div>
				  </div>
				  <div class="form-group row">
				  	<label class="col-12 font-weight-bold col-form-label">Alamat <span class="text-danger">*</span></label>
				  	<div class="col-12">
				  		<textarea class="form-control" name="alamat" placeholder="Masukkan Alamat" required></textarea>
				  	</div>
				  	<div class="col-12 error-notice" id="alamat_error"></div>
				  </div>
				  <div class="row mt-5">
				  	<div class="col-12 d-flex justify-content-end">
				  		<a href="{{ route('store.index') }}" class="btn btn-sm btn-secondary mr-2">Kembali</a>
				  		<button class="btn simpan-btn btn-sm" type="submit"><i class="mdi mdi-content-save"></i> Simpan</button>
				  	</div>
				  </div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
