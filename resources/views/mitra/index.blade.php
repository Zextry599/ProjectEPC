@extends('templates/main')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/manage_mitra/mitra/style.css') }}">
@endsection
@section('content')
  <div class="row page-title-header">
    <div class="col-12">
    <div class="page-header d-flex justify-content-between align-items-center">
      <h4 class="page-title">Daftar Mitra</h4>
      <div class="d-flex justify-content-start">
      <div class="dropdown">
        <button class="btn btn-icons btn-inverse-primary btn-filter shadow-sm" type="button"
        id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="mdi mdi-filter-variant"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton1">
        <h6 class="dropdown-header">Urut Berdasarkan :</h6>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item filter-btn" data-filter="nama">Nama</a>
        <a href="#" class="dropdown-item filter-btn" data-filter="telepon">Telepon</a>
        <a href="#" class="dropdown-item filter-btn" data-filter="status">Status</a>
        </div>
      </div>
      <div class="dropdown dropdown-search">
        <button class="btn btn-icons btn-inverse-primary btn-filter shadow-sm ml-2" type="button"
        id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="mdi mdi-magnify"></i>
        </button>
        <div class="dropdown-menu search-dropdown" aria-labelledby="dropdownMenuIconButton1">
        <div class="row">
          <div class="col-11">
          <input type="text" class="form-control" name="search" placeholder="Cari mitra">
          </div>
        </div>
        </div>
      </div>
      <a href="{{ route('mitra.create') }}" class="btn btn-icons btn-inverse-primary btn-new ml-2">
        <i class="mdi mdi-plus"></i>
      </a>
      </div>
    </div>
    </div>
  </div>

  <div class="row modal-group">
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
      <form id="editMitraForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Mitra</h5>
        <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <input type="hidden" name="id" id="edit_id">
        <div class="form-group row">
          <label class="col-3 col-form-label font-weight-bold">Nama</label>
          <div class="col-9">
          <input type="text" class="form-control" name="nama" id="edit_nama">
          <div class="error-notice" id="nama_error"></div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-3 col-form-label font-weight-bold">Telepon</label>
          <div class="col-9">
          <input type="text" class="form-control" name="telepon" id="edit_telepon">
          <div class="error-notice" id="telepon_error"></div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-3 col-form-label font-weight-bold">Alamat</label>
          <div class="col-9">
          <textarea class="form-control" name="alamat" id="edit_alamat" rows="3"></textarea>
          <div class="error-notice" id="alamat_error"></div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-3 col-form-label font-weight-bold">Status</label>
          <div class="col-9">
          <select class="form-control" name="status" id="edit_status">
            <option value="aktif">Aktif</option>
            <option value="non-aktif">Nonaktif</option>
          </select>
          </div>
        </div>
        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-update"><i class="mdi mdi-content-save"></i> Simpan</button>
        </div>
      </form>
      </div>
    </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 grid-margin">
    <div class="card card-noborder b-radius">
      <div class="card-body">
      <div class="row">
        <div class="col-12 table-responsive">
        <table class="table table-custom">
          <thead>
          <tr>
            <th>Nama</th>
            <th>Telepon</th>
            <th>Alamat</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
          </thead>
          <tbody>
          @foreach($mitra as $item)
          <tr>
          <td>{{ $item->nama }}</td>
          <td>{{ $item->telepon }}</td>
          <td>{{ Str::limit($item->alamat, 50) }}</td>
          <td>
          @if($item->status == 'aktif')
        <span class="badge badge-success font-weight-bold py-2 px-3" style="font-size: 0.8rem;">Aktif</span>
        @else
        <span class="badge badge-danger font-weight-bold py-2 px-3"
          style="font-size: 0.8rem;">Nonaktif</span>
        @endif
          </td>
          <td>
          <button type="button" class="btn btn-edit btn-icons btn-rounded btn-secondary" data-toggle="modal"
            data-target="#editModal" data-edit="{{ $item->id }}">
            <i class="mdi mdi-pencil"></i>
          </button>
          <button type="button" data-delete="{{ $item->id }}"
            class="btn btn-icons btn-rounded btn-secondary ml-1 btn-delete">
            <i class="mdi mdi-close"></i>
          </button>
          </td>
          </tr>
      @endforeach
          </tbody>
        </table>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="{{ asset('js/mitra/script.js') }}"></script>
  <script type="text/javascript">
    @if ($message = Session::get('success'))
    swal(
    "Berhasil!",
    "{{ $message }}",
    "success"
    );
    @endif

    @if ($message = Session::get('error'))
    swal(
    "Gagal!",
    "{{ $message }}",
    "error"
    );
    @endif

    $(document).on('click', '.filter-btn', function (e) {
    e.preventDefault();
    var data_filter = $(this).attr('data-filter');
    $.ajax({
      method: "GET",
      url: "{{ url('/mitra/filter') }}/" + data_filter,
      success: function (data) {
      $('tbody').html(data);
      }
    });
    });

    $(document).on('click', '.btn-edit', function () {
    var data_edit = $(this).attr('data-edit');
    $.ajax({
      method: "GET",
      url: "{{ url('/mitra') }}/" + data_edit + "/edit", // ✅ URL yang benar
      success: function (response) {
      $('input[name=id]').val(response.id);
      $('input[name=nama]').val(response.nama);
      $('input[name=telepon]').val(response.telepon);
      $('textarea[name=alamat]').val(response.alamat);
      $('select[name=status] option[value="' + response.status + '"]').prop('selected', true);
      }
    });
    });

    $(document).on('click', '.btn-edit', function () {
    var mitraId = $(this).data('edit');

    // Set the form action with the correct route and mitra ID
    $('#editMitraForm').attr('action', '/mitra/' + mitraId);

    // Get mitra data via AJAX
    $.get('/mitra/' + mitraId + '/edit', function (data) {
      $('#edit_id').val(data.id);
      $('#edit_nama').val(data.nama);
      $('#edit_telepon').val(data.telepon);
      $('#edit_alamat').val(data.alamat);
      $('#edit_status').val(data.status);

      // Show modal
      $('#editModal').modal('show');
    }).fail(function () {
      swal("Error", "Gagal memuat data mitra", "error");
    });
    });

    // Handle form submission
    $('#editMitraForm').on('submit', function (e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');

    $.ajax({
      url: url,
      method: 'POST',
      data: form.serialize(),
      success: function (response) {
      $('#editModal').modal('hide');
      swal("Berhasil!", "Data mitra berhasil diperbarui", "success");
      setTimeout(function () {
        location.reload();
      }, 1500);
      },
      error: function (xhr) {
      if (xhr.status === 422) {
        // Clear previous errors
        $('.error-notice').html('');

        // Show validation errors
        var errors = xhr.responseJSON.errors;
        $.each(errors, function (key, value) {
        $('#' + key + '_error').html(value[0]);
        });
      } else {
        swal("Gagal!", "Terjadi kesalahan saat memperbarui data", "error");
      }
      }
    });
    });

    // Delete functionality
    $(document).on('click', '.btn-delete', function () {
    var mitraId = $(this).data('delete');

    swal({
      title: "Apa Anda yakin?",
      text: "Data yang dihapus tidak dapat dikembalikan",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
      .then((willDelete) => {
      if (willDelete) {
        $.ajax({
        url: '/mitra/' + mitraId,
        method: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          _method: 'DELETE'
        },
        success: function (response) {
          swal("Berhasil!", "Data mitra telah dihapus", "success");
          setTimeout(function () {
          location.reload();
          }, 1500);
        },
        error: function () {
          swal("Gagal!", "Terjadi kesalahan saat menghapus data", "error");
        }
        });
      }
      });
    });

    // Search functionality - Perbaikan
    $(document).on('keyup', 'input[name=search]', function () {
    var search_query = $(this).val();

    $.ajax({
      url: "{{ url('/mitra/search') }}",
      method: "GET",
      data: { query: search_query },
      success: function (data) {
      // Pastikan hanya mengganti isi tbody
      $('tbody').html(data);

      // Re-inisialisasi tooltip/plugin jika diperlukan
      $('[data-toggle="tooltip"]').tooltip();
      },
    });
    });
  </script>
@endsection