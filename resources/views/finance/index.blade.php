@extends('templates/main')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/manage_finance/style.css') }}">
@endsection

@section('content')
    <div class="row page-title-header">
        <div class="col-12">
            <div class="page-header d-flex justify-content-between align-items-center">
                <h4 class="page-title">Laporan Keuangan</h4>
                {{-- Tambahan jika ingin tombol filter, cetak, dll --}}
            </div>
        </div>
    </div>

    {{-- Ringkasan Keuangan --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="card card-noborder b-radius">
                <div class="card-body">
                    <h6>Total Pemasukan</h6>
                    <p class="mb-0 text-success font-weight-bold">Rp{{ number_format($total_pemasukan, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-noborder b-radius">
                <div class="card-body">
                    <h6>Total Pengeluaran</h6>
                    <p class="mb-0 text-danger font-weight-bold">Rp{{ number_format($total_pengeluaran, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-noborder b-radius">
                <div class="card-body">
                    <h6>Keuntungan</h6>
                    <p class="mb-0 font-weight-bold">Rp{{ number_format($saldo, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Transaksi Keuangan --}}
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card card-noborder b-radius">
                <div class="card-body table-responsive">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Sumber</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($finances as $finance)
                                <tr>
                                    <td>{{ $finance->tanggal }}</td>
                                    <td>{{ ucfirst($finance->jenis) }}</td>
                                    <td>{{ $finance->sumber }}</td>
                                    <td>Rp{{ number_format($finance->jumlah, 0, ',', '.') }}</td>
                                    <td>{{ $finance->keterangan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        @if ($message = Session::get('success'))
            swal("Berhasil!", "{{ $message }}", "success");
        @endif

        @if ($message = Session::get('error'))
            swal("Gagal!", "{{ $message }}", "error");
        @endif
    </script>
@endsection
