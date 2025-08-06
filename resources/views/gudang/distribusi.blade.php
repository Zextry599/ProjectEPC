@extends('templates.main')
@section('content')
<div class="container">
    <h4>Distribusi Barang</h4>
    <form method="POST" action="{{ route('gudang.distribusi', $barang->id) }}">
        @csrf
        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" class="form-control" value="{{ $barang->nama_barang }}" readonly>
        </div>
        <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Pengirim</label>
            <input type="text" name="pengirim" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Penerima</label>
            <input type="text" name="penerima" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Distribusikan</button>
    </form>
</div>
@endsection
