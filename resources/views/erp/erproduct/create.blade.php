@extends('templates/main')

@section('css')
<link rel="stylesheet" href="{{ asset('css/erproduk/new_product/style.css') }}">
@endsection

@section('content')
<div class="row page-title-header">
    <div class="col-12">
        <div class="page-header d-flex justify-content-start align-items-center">
            <div class="quick-link-wrapper d-md-flex flex-md-wrap">
                <ul class="quick-links">
                    <li><a href="{{ route('erproduct.index') }}">Daftar Produk ERP</a></li>
                    <li><a href="{{ route('erproduct.create') }}">Tambah Produk</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 col-md-12 col-sm-12 mb-4">
        <div class="card card-noborder b-radius">
            <div class="card-body">
                <form action="{{ route('erproduct.store') }}" method="POST" name="create_form">
                    @csrf
                    <div class="form-group row">
                        <label class="col-12 font-weight-bold col-form-label">Kode Barang <span class="text-danger">*</span></label>
                        <div class="col-12">
                            <input type="text" name="kode_barang" class="form-control number-input" placeholder="Masukkan Kode Barang" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="font-weight-bold col-form-label">Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" name="nama_barang" class="form-control" placeholder="Masukkan Nama Barang" required>
                        </div>
                        <div class="col-md-6">
                            <label class="font-weight-bold col-form-label">Jenis Barang <span class="text-danger">*</span></label>
                            <select name="jenis_barang" class="form-control" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="Produksi">Produksi</option>
                                <option value="Konsumsi">Konsumsi</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="font-weight-bold col-form-label">Berat Barang <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="berat" class="form-control number-input" placeholder="Masukkan Berat Barang" required>
                                <div class="input-group-append">
                                    <select class="form-control" name="satuan" required>
                                        <option value="kg">Kilogram</option>
                                        <option value="g">Gram</option>
                                        <option value="mg">Miligram</option>
                                        <option value="oz">Ons</option>
                                        <option value="l">Liter</option>
                                        <option value="ml">Mililiter</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="font-weight-bold col-form-label">Merek</label>
                            <input type="text" name="merek" class="form-control" placeholder="Masukkan Merek Barang">
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="font-weight-bold col-form-label">Stok <span class="text-danger">*</span></label>
                            <input type="number" name="stok" class="form-control number-input" value="0" required>
                        </div>
                        <div class="col-md-6">
                            <label class="font-weight-bold col-form-label">Harga Barang <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="number" name="harga" class="form-control number-input" placeholder="Masukkan Harga Barang" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-simpan btn-sm">
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