@extends('templates/main')

@section('css')
<link rel="stylesheet" href="{{ asset('css/erproduk/product/style.css') }}">
<!-- Tambahkan Material Icons -->
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
        color: #ffc107; /* Warna kuning untuk edit */
    }
    .delete-icon {
        color: #dc3545; /* Warna merah untuk delete */
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
      <h4 class="page-title">Daftar Produk</h4>
      <a href="{{ route('erproduct.create') }}" class="btn btn-icons btn-inverse-primary btn-new">
        <i class="mdi mdi-plus"></i>
      </a>
    </div>
  </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
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
                  <th>Nama</th>
                  <th>Jenis</th>
                  <th>Merek</th>
                  <th>Berat</th>
                  <th>Stok</th>
                  <th>Harga</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($products as $product)
                  <tr>
                    <td>{{ $product->kode_barang }}</td>
                    <td>{{ $product->nama_barang }}</td>
                    <td>{{ $product->jenis_barang }}</td>
                    <td>{{ $product->merek }}</td>
                    <td>{{ $product->berat_barang }}</td>
                    <td>{{ $product->stok }}</td>
                    <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                    <td>
                      <div class="action-buttons">
                        <a href="{{ route('erproduct.edit', $product->id) }}" class="btn-icon edit-icon" title="Edit">
                          <i class="material-icons">edit</i>
                        </a>
                        <form action="{{ route('erproduct.destroy', $product->id) }}" method="POST" class="delete-form">
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
  @if ($message = Session::get('create_success'))
    swal("Berhasil!", "{{ $message }}", "success");
  @endif

  @if ($message = Session::get('update_success'))
    swal("Berhasil!", "{{ $message }}", "success");
  @endif

  @if ($message = Session::get('delete_success'))
    swal("Berhasil!", "{{ $message }}", "success");
  @endif  

  // Confirmation popup for delete action
  $(document).on('click', '.delete-btn', function(e) {
    e.preventDefault();
    var form = $(this).closest('form');
    swal({
      title: "Apa Anda Yakin?",
      text: "Data produk ini akan terhapus secara permanen",
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