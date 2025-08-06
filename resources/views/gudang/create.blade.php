@extends('templates/main')

@section('css')
<link rel="stylesheet" href="{{ asset('css/manage_gudang/new_gudang/style.css') }}">
<!-- Tambahkan style scanner -->
<style>
  #reader {
    width: 260px;
    height: 200px;
    margin: auto;
    border: 2px solid #ccc;
    border-radius: 8px;
  }

  /* Untuk memperkecil padding dalam modal */
  .modal-content {
    padding: 10px;
  }
</style>

@endsection

@section('content')
<div class="row page-title-header">
  <div class="col-12">
    <div class="page-header d-flex justify-content-start align-items-center">
      <div class="quick-link-wrapper d-md-flex flex-md-wrap">
        <ul class="quick-links">
          <li><a href="{{ url('gudang') }}">Stok Gudang</a></li>
          <li><a href="{{ url('gudang/create') }}">Tambah Barang Gudang</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-8 col-md-12 col-sm-12 mb-4">
    <div class="card card-noborder b-radius">
      <div class="card-body">
        <form action="{{ route('gudang.tambah') }}" method="post">
          @csrf
          <div class="form-group row">
            <label class="col-12 font-weight-bold col-form-label">Kode Barang <span class="text-danger">*</span></label>
            <div class="col-12">
              <div class="input-group">
                <input type="text" class="form-control number-input" name="kode_barang"
                  placeholder="Masukkan Kode Barang" required autofocus autocomplete="off">
                <div class="input-group-append">
                  <button class="btn btn-inverse-primary btn-sm btn-scan shadow-sm ml-2" type="button" data-toggle="modal"
                    data-target="#scanModal">
                    <i class="mdi mdi-crop-free"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-lg-6">
              <label class="font-weight-bold col-form-label">Nama Barang <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="nama_barang" placeholder="Masukkan Nama Barang" required>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-lg-6">
              <label class="font-weight-bold col-form-label">Merek Barang</label>
              <input type="text" class="form-control" name="merk" placeholder="Masukkan Merek Barang">
            </div>
            <div class="col-lg-6">
              <label class="font-weight-bold col-form-label">Harga Barang <span class="text-danger">*</span></label>
              <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">Rp.</span></div>
                <input type="number" class="form-control number-input" name="harga" placeholder="Masukkan Harga Barang"
                  required>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-lg-6">
              <label class="font-weight-bold col-form-label">Stok (Box) <span class="text-danger">*</span></label>
              <input type="number" class="form-control" name="stok_box" placeholder="Jumlah dalam dus / box" required>
            </div>
          </div>

          <div class="form-group row">
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

<!-- Modal Scan -->
<div class="modal fade" id="scanModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm modal-top" role="document"> <!-- modal-top custom class -->
    <div class="modal-content">
      <div class="modal-header py-2">
        <h5 class="modal-title">Scan Kode Barang</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <div id="reader" style="width: 260px; height: 200px; margin: auto;"></div> <!-- Ukuran kamera -->
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
{{-- CDN Scanner --}}
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
  // hanya angka untuk input kode_barang
  $('input[name="kode_barang"]').on('input', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  let scanner;

  $('#scanModal').on('shown.bs.modal', function () {
    scanner = new Html5Qrcode("reader");

    scanner.start(
      { facingMode: "environment" }, // kamera belakang
      {
        fps: 10,
        qrbox: 250
      },
      (decodedText, decodedResult) => {
        $('input[name="kode_barang"]').val(decodedText.replace(/[^0-9]/g, ''));
        $('#scanModal').modal('hide');
        scanner.stop();
      },
      (errorMessage) => {
        // error scanning
      }
    ).catch(err => {
      console.error("Gagal membuka kamera: ", err);
    });
  });

  $('#scanModal').on('hidden.bs.modal', function () {
    if (scanner) {
      scanner.stop().then(() => {
        scanner.clear();
      }).catch((err) => {
        console.error("Gagal menghentikan scanner: ", err);
      });
    }
  });
</script>
@endsection
