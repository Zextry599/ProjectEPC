@extends('templates/main')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/manage_member/style.css') }}">
@endsection

@section('content')
    <div class="row page-title-header">
        <div class="col-12">
            <div class="page-header d-flex justify-content-between align-items-center">
                <h4 class="page-title">Daftar Member</h4>
                <div class="d-flex">
                    <a href="{{ route('member.create') }}" class="btn btn-icons btn-inverse-primary ml-2"
                        title="Tambah Member">
                        <i class="mdi mdi-plus"></i>
                    </a>

                    <div class="dropdown dropdown-search">
                        <button class="btn btn-icons btn-inverse-primary ml-2" type="button" id="searchDropdownBtn"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                        <div class="dropdown-menu p-3" aria-labelledby="searchDropdownBtn" style="min-width: 250px;">
                            <input type="text" class="form-control" name="search" id="searchInput"
                                placeholder="Cari member...">
                        </div>
                    </div>

                    <button class="btn btn-icons btn-inverse-warning ml-2" title="Pengaturan Kartu Member"
                        data-toggle="modal" data-target="#settingModal">
                        <i class="mdi mdi-cog"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Pengaturan Kartu Member --}}
    <div class="modal fade" id="settingModal" tabindex="-1" role="dialog" aria-labelledby="settingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="POST" action="{{ route('member.setting.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Pengaturan Kartu Member</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Logo (PNG)</label>
                                <input type="file" name="logo" class="form-control-file"
                                    onchange="previewImage(this, 'preview-logo')">
                                @if(file_exists(public_path('img/logo.png')))
                                    <img src="{{ asset('img/logo.png') }}" class="mt-2" width="100" id="current-logo">
                                @endif
                            </div>

                            <div class="form-group mt-3">
                                <label>Background Kartu (PNG/JPG)</label>
                                <input type="file" name="background" class="form-control-file"
                                    onchange="previewImage(this, 'preview-bg')">
                                @if(file_exists(public_path('img/bg-kartu.png')))
                                    <img src="{{ asset('img/bg-kartu.png') }}" class="mt-2" width="100" id="current-bg">
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label>Preview Kartu</label>
                            <div id="preview-bg" style="width: 370px; height: 210px; border: 1px solid #ccc; position: relative;
                                       background: url('{{ asset('img/bg-kartu.png') }}') no-repeat center center;
                                       background-size: cover; border-radius: 8px;">
                                <img src="{{ asset('img/logo.png') }}" alt="logo" id="preview-logo"
                                    style="position:absolute; top:10px; left:10px; width:40px;">
                                <div
                                    style="display: flex; justify-content: center; align-items: center; font-weight: 900; /* Lebih tebal dari bold biasa */
                                            font-size: 20px;   /* Tambahkan ukuran jika perlu */ height: 50px;      /* Sesuaikan tinggi jika dibutuhkan */">
                                    KARTU MEMBER
                                </div>
                                <div class="preview-text"
                                    style="position:absolute; bottom:10px; left:10px; font-size:12px;">
                                    Nama: <strong>Contoh Nama</strong><br>
                                    No.ID: ....
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Daftar Member --}}
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card card-noborder b-radius">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-custom">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>No HP</th>
                                        <th>Alamat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($members as $member)
                                        <tr>
                                            <td>{{ $member->nama }}</td>
                                            <td>{{ $member->email ?? '-' }}</td>
                                            <td>{{ $member->no_hp }}</td>
                                            <td>{{ Str::limit($member->alamat, 50) }}</td>
                                            <td>
                                                <a href="{{ route('member.edit', $member->id) }}"
                                                    class="btn btn-icons btn-rounded btn-secondary" title="Edit">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                <form action="{{ route('member.destroy', $member->id) }}" method="POST"
                                                    style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-icons btn-rounded btn-secondary ml-1"
                                                        onclick="return confirm('Yakin ingin menghapus member ini?')"
                                                        title="Hapus">
                                                        <i class="mdi mdi-close"></i>
                                                    </button>
                                                </form>
                                                <a href="{{ route('member.cetak', $member->id) }}" target="_blank"
                                                    class="btn btn-icons btn-rounded btn-primary ml-1" title="Cetak Kartu">
                                                    <i class="mdi mdi-printer"></i>
                                                </a>
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
        @if ($message = Session::get('success'))
            swal("Berhasil!", "{{ $message }}", "success");
        @endif

        @if ($message = Session::get('error'))
            swal("Gagal!", "{{ $message }}", "error");
        @endif

        function previewImage(input, targetId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    if (targetId === 'preview-logo') {
                        document.getElementById('preview-logo').src = e.target.result;
                        const oldLogo = document.getElementById('current-logo');
                        if (oldLogo) oldLogo.style.display = 'none';
                    } else if (targetId === 'preview-bg') {
                        document.getElementById('preview-bg').style.backgroundImage = `url('${e.target.result}')`;
                        const oldBg = document.getElementById('current-bg');
                        if (oldBg) oldBg.style.display = 'none';
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(document).on('keyup', 'input[name=search]', function () {
            var search_query = $(this).val();

            $.ajax({
                url: "{{ url('/member/search') }}",
                method: "GET",
                data: { query: search_query },
                success: function (data) {
                    $('tbody').html(data);
                },
                error: function () {
                    console.error("Gagal melakukan pencarian.");
                }
            });
        });

    </script>
@endsection