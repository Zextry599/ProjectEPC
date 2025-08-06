@extends('templates/main')

@section('content')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">
            <i class="material-icons align-middle">factory</i>
            Detail Produksi Barang
        </h4>
        <a href="{{ route('production.index') }}" class="btn btn-sm btn-secondary">
            <i class="material-icons">arrow_back</i> Kembali
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Informasi Produksi</h5>
            <p><strong>Kode Produksi:</strong> {{ $production->kode_produksi }}</p>
            <p><strong>Tanggal Produksi:</strong> {{ \Carbon\Carbon::parse($production->tanggal_produksi)->format('d/m/Y') }}</p>
            <p><strong>Produk Jadi:</strong> {{ $production->masterProduct->nama_barang ?? '-' }}</p>
            <p><strong>Jumlah Produksi:</strong> {{ $production->jumlah_produksi }}</p>
            <p><strong>Catatan:</strong> {{ $production->catatan ?? '-' }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Bahan Mentah yang Digunakan</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Bahan</th>
                            <th class="text-center">Jumlah Dipakai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($production->materials as $mat)
                            <tr>
                                <td>{{ $mat->erpProduct->nama_barang ?? '-' }}</td>
                                <td class="text-center">{{ $mat->jumlah_dipakai }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">Tidak ada bahan mentah tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
