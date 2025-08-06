@extends('templates/main')

@section('css')
<link rel="stylesheet" href="{{ asset('css/manage_product/product/style.css') }}">
@endsection

@section('content')
<div class="row page-title-header">
  <div class="col-12">
    <div class="page-header d-flex justify-content-between align-items-center">
      <h4 class="page-title">Daftar Supplier</h4>
      <div class="d-flex justify-content-start">
        <a href="{{ route('supplier.create') }}" class="btn btn-icons btn-inverse-primary btn-new ml-2">
          <i class="mdi mdi-plus"></i>
        </a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12 grid-margin">
    <div class="card card-noborder b-radius">
      <div class="card-body">
        <div class="row">
          <div class="col-12 table-responsive">
            <table class="table table-custom">
              <thead>
                <tr>
                  <th>Nama Supplier</th>
                  <th>Email</th>
                  <th>Telepon</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($suppliers as $supplier)
                <tr>
                  <td>{{ $supplier->nama }}</td>
                  <td>{{ $supplier->email }}</td>
                  <td>{{ $supplier->telepon }}</td>
                  <td>
                    <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-edit btn-icons btn-rounded btn-secondary">
                      <i class="mdi mdi-pencil"></i>
                    </a>
                    <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" onclick="return confirm('Yakin hapus supplier ini?')" class="btn btn-icons btn-rounded btn-secondary ml-1">
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
@endsection
