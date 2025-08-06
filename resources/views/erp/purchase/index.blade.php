@extends('templates/main')

@section('css')
<link rel="stylesheet" href="{{ asset('css/erproduk/product/style.css') }}">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style>
    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-icon {
        padding: 0;
        border: none;
        background: none;
        cursor: pointer;
    }

    .edit-icon {
        color: #ffc107;
    }

    .delete-icon {
        color: #dc3545;
    }

    .btn-icon:hover {
        opacity: 0.8;
    }
</style>
@endsection

@section('content')
<div class="row page-title-header">
    <div class="col-12">
        <div class="page-header d-flex justify-content-between align-items-center">
            <h4 class="page-title">Daftar Purchase Order</h4>
            <a href="{{ route('purchase.create') }}" class="btn btn-icons btn-inverse-primary btn-new">
                <i class="mdi mdi-plus"></i>
            </a>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success mt-3">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-12 grid-margin">
        <div class="card card-noborder b-radius">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-custom">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Supplier</th>
                                    <th>Tanggal</th>
                                    <th>Catatan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->kode_pembelian }}</td>
                                    <td>{{ $order->supplier->nama ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->tanggal)->format('d/m/Y') }}</td>
                                    <td>{{ $order->catatan ?? '-' }}</td>
                                    <td>
                                        @if ($order->status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                        @elseif ($order->status == 'selesai')
                                        <span class="badge badge-success">Selesai</span>
                                        @else
                                        <span class="badge badge-secondary">{{ ucfirst($order->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('purchase.show', $order->id) }}" class="btn-icon text-info" title="Detail">
                                                <i class="material-icons">visibility</i>
                                            </a>
                                            <a href="{{ route('purchase.edit', $order->id) }}" class="btn-icon edit-icon" title="Edit">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <form action="{{ route('purchase.destroy', $order->id) }}" method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn-icon delete-icon delete-btn" title="Hapus">
                                                    <i class="material-icons">delete</i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @if($orders->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada Purchase Order.</td>
                                </tr>
                                @endif
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
    @if(session('success'))
    swal("Berhasil!", "{{ session('success') }}", "success");
    @endif

    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        swal({
                title: "Yakin ingin menghapus?",
                text: "Data PO ini akan terhapus permanen!",
                icon: "warning",
                buttons: {
                    cancel: "Batal",
                    confirm: "Ya, Hapus"
                },
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
    });
</script>
@endsection