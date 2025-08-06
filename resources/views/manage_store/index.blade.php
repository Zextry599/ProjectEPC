@extends('templates/main')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/manage_mitra/mitra/style.css') }}">
@endsection

@section('content')
    <div class="row page-title-header">
        <div class="col-12">
            <div class="page-header d-flex justify-content-between align-items-center">
                <h4 class="page-title">Daftar Toko</h4>
                <div class="d-flex justify-content-start">
                    <div class="dropdown dropdown-search">
                        <button class="btn btn-icons btn-inverse-primary btn-filter shadow-sm" type="button"
                            id="dropdownSearchButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                        <div class="dropdown-menu search-dropdown" aria-labelledby="dropdownSearchButton">
                            <div class="row">
                                <div class="col-11">
                                    <input type="text" class="form-control" name="search_store" placeholder="Cari toko">
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('store.create') }}" class="btn btn-icons btn-inverse-primary btn-new ml-2">
                        <i class="mdi mdi-plus"></i>
                    </a>
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
                                        <th>Nama Toko</th>
                                        <th>Alamat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="storeTableBody">
                                    @foreach($stores as $store)
                                        <tr>
                                            <td>{{ $store->name }}</td>
                                            <td>{{ Str::limit($store->alamat, 50) }}</td>
                                            <td>
                                                <button type="button" class="btn btn-edit btn-icons btn-rounded btn-secondary"
                                                    data-toggle="modal" data-target="#editStoreModal"
                                                    data-id="{{ $store->id }}">
                                                    <i class="mdi mdi-pencil"></i>
                                                </button>
                                                <form id="deleteForm{{ $store->id }}"
                                                    action="{{ route('store.destroy', $store->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="btn btn-icons btn-rounded btn-secondary ml-1 btn-delete"
                                                        data-id="{{ $store->id }}">
                                                        <i class="mdi mdi-close"></i>
                                                    </button>
                                                </form>
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

    {{-- Modal Edit --}}
    <div class="modal fade" id="editStoreModal" tabindex="-1" role="dialog" aria-labelledby="editStoreModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="editStoreForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Toko</h5>
                        <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_id">
                        <div class="form-group">
                            <label>Nama Toko</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <input type="text" name="alamat" id="edit_alamat" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="mdi mdi-content-save"></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    {{-- Include SweetAlert kalau belum --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    {{-- Flash message --}}
    @if (Session::has('create_success'))
        <script>
            swal("Berhasil!", "{{ Session::get('create_success') }}", "success");
        </script>
    @endif

    @if (Session::has('update_success'))
        <script>
            swal("Berhasil!", "{{ Session::get('update_success') }}", "success");
        </script>
    @endif

    @if (Session::has('delete_success'))
        <script>
            swal("Berhasil!", "{{ Session::get('delete_success') }}", "success");
        </script>
    @endif

    <script>
        // Open edit modal
        $(document).on('click', '.btn-edit', function () {
            var storeId = $(this).data('id');
            $.get('/store/edit/' + storeId, function (data) {
                $('#edit_id').val(data.id);
                $('#edit_name').val(data.name);
                $('#edit_alamat').val(data.alamat);
                $('#editStoreForm').attr('action', '/store/' + data.id);
                $('#editStoreModal').modal('show');
            });
        });

        // Submit edit form
        $('#editStoreForm').on('submit', function (e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');

            $.ajax({
                url: url,
                method: 'POST',
                data: form.serialize(),
                success: function () {
                    $('#editStoreModal').modal('hide');
                    swal("Berhasil!", "Data toko berhasil diperbarui", "success");
                    setTimeout(function () { location.reload(); }, 1500);
                },
                error: function () {
                    swal("Gagal!", "Terjadi kesalahan saat memperbarui data", "error");
                }
            });
        });

        // Delete confirmation
        $(document).on('click', '.btn-delete', function () {
            var storeId = $(this).data('id');

            swal({
                title: "Yakin ingin menghapus?",
                text: "Data toko yang dihapus tidak bisa dikembalikan.",
                icon: "warning",
                buttons: ["Batal", "Hapus"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $('#deleteForm' + storeId).submit();
                }
            });
        });

        // Search toko
        $(document).on('keyup', 'input[name=search_store]', function () {
            var search_query = $(this).val();

            $.ajax({
                url: "{{ url('/store/search') }}",
                method: "GET",
                data: { query: search_query },
                success: function (data) {
                    $('#storeTableBody').html(data);
                }
            });
        });
    </script>
@endsection
