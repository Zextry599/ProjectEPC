@extends('templates/main')

@section('content')
<div class="container mt-4">
    <h4>Proses Produksi Barang</h4>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('production.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Produksi</label>
            <input type="date" name="tanggal_produksi" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="master_product_id" class="form-label">Barang Jadi</label>
            <select name="master_product_id" class="form-control" required>
                <option value="">-- Pilih Produk Jadi --</option>
                @foreach ($finishedProducts as $mp)
                    <option value="{{ $mp->id }}">{{ $mp->nama_barang }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="jumlah_produksi" class="form-label">Jumlah Produksi</label>
            <input type="number" name="jumlah_produksi" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan (opsional)</label>
            <textarea name="catatan" class="form-control"></textarea>
        </div>

        <hr>
        <h5 class="mb-2">Bahan Mentah</h5>
        <div id="material-list">
            <div class="row mb-2">
                <div class="col-md-6">
                    <select name="material_id[]" class="form-control" required>
                        <option value="">-- Pilih Bahan Mentah --</option>
                        @foreach ($materials as $mat)
                            <option value="{{ $mat->id }}">{{ $mat->nama_barang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="number" name="jumlah_dipakai[]" placeholder="Jumlah Dipakai" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <button type="button" onclick="hapusMaterial(this)" class="btn btn-danger">-</button>
                </div>
            </div>
        </div>

        <button type="button" onclick="tambahMaterial()" class="btn btn-success mb-3">+ Tambah Bahan</button>

        <div>
            <button type="submit" class="btn btn-primary">Proses Produksi</button>
        </div>
    </form>
</div>

<script>
function tambahMaterial() {
    const list = document.getElementById('material-list');
    const item = list.children[0].cloneNode(true);
    item.querySelectorAll('input, select').forEach(el => el.value = '');
    list.appendChild(item);
}

function hapusMaterial(button) {
    const list = document.getElementById('material-list');
    if (list.children.length > 1) {
        button.closest('.row').remove();
    } else {
        alert('Minimal 1 bahan harus ada.');
    }
}
</script>
@endsection
