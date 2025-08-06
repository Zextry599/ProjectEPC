@extends('templates/main')

@section('content')
    <div class="container mt-4">
        <h4>Edit Purchase Order</h4>
        <form method="POST" action="{{ route('purchase.update', $order->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="supplier_id" class="form-label">Supplier</label>
                <select name="supplier_id" class="form-control" required>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ $order->supplier_id == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ $order->tanggal }}" required>
            </div>

            <div class="mb-3">
                <label for="catatan" class="form-label">Catatan</label>
                <textarea name="catatan" class="form-control">{{ $order->catatan }}</textarea>
            </div>

            <hr>
            <h5>Edit Item</h5>
            <div id="items">
                @foreach ($order->items as $item)
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <select name="product_id[]" class="form-control" required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" {{ $item->erp_product_id == $product->id ? 'selected' : '' }}>
                                        {{ $product->nama_barang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah"
                                value="{{ $item->jumlah }}" required>
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="harga_satuan[]" class="form-control" placeholder="Harga Satuan"
                                value="{{ $item->harga_satuan }}" required>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control">
                    <option value="Pending" {{ old('status', $order->status ?? '') == 'Pending' ? 'selected' : '' }}>Pending
                    </option>
                    <option value="Diproses" {{ old('status', $order->status ?? '') == 'Diproses' ? 'selected' : '' }}>
                        Diproses</option>
                    <option value="Selesai" {{ old('status', $order->status ?? '') == 'Selesai' ? 'selected' : '' }}>Selesai
                    </option>
                    <option value="Dibatalkan" {{ old('status', $order->status ?? '') == 'Dibatalkan' ? 'selected' : '' }}>
                        Dibatalkan</option>
                </select>
            </div>


            <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
            <a href="{{ route('purchase.index') }}" class="btn btn-secondary mt-3">Batal</a>
        </form>
    </div>
@endsection