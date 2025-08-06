@extends('templates/main')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/manage_mitra/mitra/style.css') }}">
@endsection

@section('content')
    <div class="row page-title-header">
        <div class="col-12">
            <div class="page-header d-flex justify-content-between align-items-center">
                <h4 class="page-title">Daftar Stok Gudang</h4>
                <a href="{{ route('gudang.create') }}" class="btn btn-icons btn-inverse-primary btn-new ml-2">
                    <i class="mdi mdi-plus"></i>
                </a>
            </div>
        </div>
    </div>

    @include('gudang.modal_edit') {{-- modal edit pisahkan ke partial --}}

    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card card-noborder b-radius">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-custom">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Barang</th>
                                        <th>Merk</th>
                                        <th>Stok (Box)</th>
                                        <th>Harga</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stocks as $s)
                                        <tr>
                                            <td>{{ $s->kode_barang }}</td>
                                            <td>{{ $s->nama_barang }}</td>
                                            <td>{{ $s->merk }}</td>
                                            <td>{{ $s->stok_box }}</td>
                                            <td>Rp {{ number_format($s->harga, 0, ',', '.') }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $s->keterangan == 'tersedia' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ ucfirst($s->keterangan) }}
                                                </span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-edit btn-icons btn-rounded btn-secondary"
                                                    data-toggle="modal" data-target="#editModal" data-id="{{ $s->id }}">
                                                    <i class="mdi mdi-pencil"></i>
                                                </button>
                                                <button type="button"
                                                    class="btn btn-delete btn-icons btn-rounded btn-secondary ml-1"
                                                    data-id="{{ $s->id }}">
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
    <script>
        // Handle Edit
        $(document).on('click', '.btn-edit', function () {
            var id = $(this).data('id');
            $.get('/gudang/' + id + '/edit', function (data) {
                $('#edit_id').val(data.id);
                $('#edit_kode_barang').val(data.kode_barang);
                $('#edit_nama_barang').val(data.nama_barang);
                $('#edit_berat_barang').val(data.berat_barang);
                $('#edit_merk').val(data.merk);
                $('#edit_stok_box').val(data.stok_box);
                $('#edit_harga').val(data.harga);
                $('#editGudangForm').attr('action', '/gudang/' + data.id);
                $('#editModal').modal('show');
            });
        });

        // Handle Delete
        $(document).on('click', '.btn-delete', function () {
            var id = $(this).data('id');
            swal({
                title: "Yakin ingin menghapus?",
                text: "Data yang dihapus tidak dapat dikembalikan",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((confirm) => {
                if (confirm) {
                    $.post('/gudang/' + id, {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    }, function () {
                        swal("Berhasil!", "Barang berhasil dihapus.", "success");
                        setTimeout(() => location.reload(), 1500);
                    }).fail(() => {
                        swal("Gagal!", "Terjadi kesalahan saat menghapus", "error");
                    });
                }
            });
        });
    </script>
@endsection