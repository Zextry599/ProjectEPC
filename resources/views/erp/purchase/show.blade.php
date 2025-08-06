@extends('templates/main')

@section('content')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">
            <i class="material-icons align-middle">description</i>
            Detail Purchase Order
        </h4>
        <a href="{{ route('purchase.index') }}" class="btn btn-sm btn-secondary">
            <i class="material-icons">arrow_back</i> Kembali
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Informasi Umum</h5>
            <p><strong>Kode:</strong> {{ $order->kode_pembelian }}</p>
            <p><strong>Supplier:</strong> {{ $order->supplier->nama }}</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($order->tanggal)->format('d/m/Y') }}</p>
            <p><strong>Catatan:</strong> {{ $order->catatan ?? '-' }}</p>
            <p>
                <strong>Status:</strong>
                <span class="badge bg-info text-dark">{{ $order->status }}</span>
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Daftar Produk</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Produk</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Harga Satuan</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $grandTotal = 0; @endphp
                        @foreach ($order->items as $item)
                            @php
                                $subtotal = $item->jumlah * $item->harga_satuan;
                                $grandTotal += $subtotal;
                            @endphp
                            <tr>
                                <td>{{ $item->product->nama_barang ?? '-' }}</td>
                                <td class="text-center">{{ $item->jumlah }}</td>
                                <td class="text-end">Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                <td class="text-end">Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        <tr class="fw-bold">
                            <td colspan="3" class="text-end">Total</td>
                            <td class="text-end">Rp{{ number_format($grandTotal, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
