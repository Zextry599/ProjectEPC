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

    .detail-icon {
        color: #17a2b8;
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
            <h4 class="page-title">Daftar Produksi Barang</h4>
            <a href="{{ route('production.create') }}" class="btn btn-icons btn-inverse-primary btn-new">
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
                                    <th>Kode Produksi</th>
                                    <th>Tanggal</th>
                                    <th>Produk Jadi</th>
                                    <th>Jumlah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($productions as $prod)
                                <tr>
                                    <td>{{ $prod->kode_produksi }}</td>
                                    <td>{{ \Carbon\Carbon::parse($prod->tanggal_produksi)->format('d/m/Y') }}</td>
                                    <td>{{ $prod->masterProduct->nama_barang ?? '-' }}</td>
                                    <td>{{ $prod->jumlah_produksi }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('production.show', $prod->id) }}" class="btn-icon detail-icon" title="Detail">
                                                <i class="material-icons">visibility</i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada produksi.</td>
                                </tr>
                                @endforelse
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
</script>
@endsection
