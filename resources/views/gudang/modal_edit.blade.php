{{-- Modal Edit --}}
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document" style="margin-top: 40px;">
        <div class="modal-content">
            <form id="editGudangForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header py-2">
                    <h5 class="modal-title">Edit Barang Gudang</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">

                    <div class="form-group">
                        <label>Kode Barang</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="kode_barang" id="edit_kode_barang">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal"
                                    data-target="#editScanModal">
                                    <i class="mdi mdi-crop-free"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" class="form-control" name="nama_barang" id="edit_nama_barang">
                    </div>

                    <div class="form-group">
                        <label>Merk</label>
                        <input type="text" class="form-control" name="merk" id="edit_merk">
                    </div>

                    <div class="form-group">
                        <label>Stok Box</label>
                        <input type="number" class="form-control" name="stok_box" id="edit_stok_box">
                    </div>

                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" class="form-control" name="harga" id="edit_harga">
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Scan QR --}}
<div class="modal fade" id="editScanModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document" style="margin-top: 60px;">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h6 class="modal-title">Scan Kode</h6>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body text-center">
                <div id="edit_qr_reader"></div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        let editScanner;

        $('#editScanModal').on('shown.bs.modal', function () {
            setTimeout(() => {
                if (!editScanner) {
                    const qrRegion = document.getElementById("edit_qr_reader");
                    if (!qrRegion) return console.error("Element #edit_qr_reader not found");

                    editScanner = new Html5Qrcode("edit_qr_reader");
                    editScanner.start(
                        { facingMode: "environment" },
                        { fps: 10, qrbox: { width: 220, height: 150 } },
                        qrCodeMessage => {
                            let kode = qrCodeMessage.replace(/\D/g, ''); // hanya angka
                            $('#edit_kode_barang').val(kode);
                            $('#editScanModal').modal('hide');
                            editScanner.stop().then(() => editScanner = null);
                        },
                        error => { }
                    ).catch(err => console.error("Error starting QR scanner: ", err));
                }
            }, 500);
        });

        $('#editScanModal').on('hidden.bs.modal', function () {
            if (editScanner) {
                editScanner.stop().then(() => editScanner = null);
            }
        });
    </script>
@endpush

@push('style')
    <style>
        #edit_qr_reader {
            width: 100%;
            max-width: 250px;
            height: 160px;
            margin: auto;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
    </style>
@endpush