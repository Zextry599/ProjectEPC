@extends('templates/main')

@section('content')
<div class="container mt-4">
    <h4>Tambah Purchase Order</h4>

    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Terjadi Kesalahan:</strong>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('purchase.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="supplier_id" class="form-label">Supplier</label>
            <select name="supplier_id" class="form-control" required>
                <option value="">-- Pilih Supplier --</option>
                @foreach($suppliers as $s)
                <option value="{{ $s->id }}">{{ $s->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan (Opsional)</label>
            <textarea name="catatan" rows="3" class="form-control"></textarea>
        </div>

        <hr>

        <h5 class="mb-2">Produk</h5>
        <div id="produk-list">
            <div class="row mb-2">
                <div class="col-md-5">
                    <select name="product_id[]" class="form-control" required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach($products as $p)
                        <option value="{{ $p->id }}">{{ $p->nama_barang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="jumlah[]" placeholder="Jumlah" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="harga_satuan[]" placeholder="Harga Satuan" class="form-control" required>
                </div>
                <div class="col-md-1 d-flex align-items-center">
                    <button type="button" onclick="hapusProduk(this)" class="btn btn-danger btn-sm">-</button>
                </div>
            </div>
        </div>

        <button type="button" onclick="tambahProduk()" class="btn btn-success mb-3">+ Tambah Produk</button>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="Pending">Pending</option>
                <option value="Diproses">Diproses</option>
                <option value="Selesai">Selesai</option>
                <option value="Dibatalkan">Dibatalkan</option>
            </select>
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>

<script>
    function tambahProduk() {
        const list = document.getElementById('produk-list');
        const item = list.children[0].cloneNode(true);
        item.querySelectorAll('input, select').forEach(el => el.value = '');
        list.appendChild(item);
    }

    function hapusProduk(button) {
        const list = document.getElementById('produk-list');
        if (list.children.length > 1) {
            button.closest('.row').remove();
        } else {
            alert('Minimal harus ada satu produk');
        }
    }
</script>
@endsection
