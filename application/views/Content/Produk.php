<section id="produk">
    <h4>Produk</h4>
    <hr>
    <div class="col-12 text-right">
        <button class="btn pull-right" data-toggle="modal" data-target="#add">
            <i class="fas fa-plus-circle fa-lg"></i> New Product
        </button>
    </div>
    <div class="col-12 card shadow mt-5 mb-5">
        <h4 class="my-3">Data Produk</h4>
        <table id="table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="5%">No.</th>
                    <th width="30%">Nama Produk</th>
                    <th width="30%">Deskripsi</th>
                    <th width="20%">Spesifikasi</th>
                    <th width="15%">Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No.</th>
                    <th>Nama Produk</th>
                    <th>Deskripsi</th>
                    <th>Spesifikasi</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </div>
</section> <!-- Modal -->
<div class="modal fade" id="add" tabindex="-10" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <?php echo form_open_multipart('produk/add'); ?>
            <div class="modal-body row">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <input type="file" id="foto" name="foto">
                    </div>
                    <img src="#" alt="foto produk" id="add-foto" class="img-fluid">
                </div>
                <div class="col-sm-8">
                    <div class="form-group"> <label for="nama">Nama Produk</label> <input type="text" class="form-control" id="nama" name="nama" placeholder="Lorem Ipsum Dolor"> </div>
                    <div class="form-group"> <label for="deskripsi">Deskripsi Produk</label> <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5"></textarea> </div>
                    <div class="form-group"> <label for="spesifikasi">Spesifikasi Produk</label> <textarea class="form-control" id="spesifikasi" name="spesifikasi" rows="10"></textarea> </div>
                </div>
            </div>
            <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button> <button type="submit" class="btn btn-primary">Tambah Produk</button> </div> <?php echo form_close() ?>
        </div>
    </div>
</div>
<div class="modal fade" id="view">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Lihat Data</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body row">
                <div class="col-sm-4"> <img src="" alt="foto produk" id="view-foto" class="img-fluid"> </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="nama"><u>Nama Produk</u></label>
                        <p id="view-nama"></p>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi"><u> Deskripsi Produk</u></label>
                        <div id="view-deskripsi"></div>
                    </div>
                    <div class="form-group">
                        <label for="spesifikasi"><u> Produk</u> </label>
                        <div id="view-spesifikasi"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button> <!-- <button type="submit" class="btn btn-primary">Tutup</button> -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <?php echo form_open_multipart('produk/save'); ?>
            <div class="modal-body row">
                <div class="col-sm-4">
                    <div class="input-group mb-3"> <input type="file" id="prev-foto" name="foto-edit">
                    </div>
                    <img src="" alt="foto produk" id="edit-foto" class="img-fluid">
                </div>
                <div class="col-sm-8">
                    <div class="form-group"> <label for="nama">Nama Produk</label> <input type="text" class="form-control" id="edit-nama" name="nama" placeholder="Lorem Ipsum Dolor"> <input type="number" id="edit-id" hidden name="id"> </div>
                    <div class="form-group"> <label for="deskripsi">Deskripsi Produk</label> <textarea class="form-control" id="edit-deskripsi" name="deskripsi" rows="5"></textarea> </div>
                    <div class="form-group"> <label for="spesifikasi">Spesifikasi Produk</label> <textarea class="form-control" id="edit-spesifikasi" name="spesifikasi" rows="10"></textarea> </div>
                </div>
            </div>
            <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button> <button type="submit" class="btn btn-primary">Simpan Perubahan</button> </div> <?php echo form_close() ?>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/12.0.0/classic/ckeditor.js"></script>
<script>
    let deskripsi, spesifikasi, edit_deskripsi, edit_spesifikasi;
    ClassicEditor.create(document.querySelector('#deskripsi')).then(newEditor => {
        deskripsi = newEditor;
    }).catch(error => {
        console.error(error);
    });
    ClassicEditor.create(document.querySelector('#spesifikasi')).then(newEditor => {
        spesifikasi = newEditor;
    }).catch(error => {
        console.error(error);
    });
    ClassicEditor.create(document.querySelector('#edit-deskripsi')).then(newEditor => {
        edit_deskripsi = newEditor;
    }).catch(error => {
        console.error(error);
    });
    ClassicEditor.create(document.querySelector('#edit-spesifikasi')).then(newEditor => {
        edit_spesifikasi = newEditor;
    }).catch(error => {
        console.error(error);
    });
    $(document).ready(function() {
        $('#table').DataTable({
            "ajax": "<?php echo base_url('produk/all') ?>",
            "columns": [{
                "data": "ID"
            }, {
                "data": "NAMA"
            }, {
                "data": "DESKRIPSI"
            }, {
                "data": "SPESIFIKASI"
            }, {
                "data": "ACTION"
            }]
        });
    });

    function view(ID) {
        $.ajax({
            url: '<?= base_url('produk/view') ?>',
            type: 'POST',
            data: "ID=" + ID,
            success: function(r) {
                r = $.parseJSON(r);
                if (r.error == false) {
                    $('#view-nama').html(r.data.NAMA);
                    $('#view-foto').attr('src', r.data.GAMBAR);
                    $('#view-deskripsi').html(r.data.DESKRIPSI);
                    $('#view-spesifikasi').html(r.data.SPESIFIKASI);
                    $('#view').modal('show');
                } else {
                    swal('Gagal !', 'Gagal Mengambil Data Produk', 'error');
                }
            }
        })
    }

    function edit(ID) {
        $.ajax({
            url: '<?= base_url('produk/view') ?>',
            type: 'POST',
            data: "ID=" + ID,
            success: function(r) {
                r = $.parseJSON(r);
                if (r.error == false) {
                    $('#edit-id').val(r.data.ID);
                    $('#edit-nama').val(r.data.NAMA);
                    $('#edit-foto').attr('src', r.data.GAMBAR);
                    $('#edit-deskripsi').val(r.data.DESKRIPSI);
                    edit_deskripsi.setData(r.data.DESKRIPSI);
                    $('#edit-spesifikasi').val(r.data.SPESIFIKASI);
                    edit_spesifikasi.setData(r.data.SPESIFIKASI);
                    $('#edit').modal('show');
                } else {
                    swal('Gagal !', 'Gagal Mengambil Data Produk', 'error');
                }
            }
        })
    }

    function del(ID) {
        swal("Apakah kamu yakin menghapus data ?", {
            icon: "info",
            buttons: {
                cancel: "Batal",
                Yakin: true
            },
        }).then((value) => {
            if (value == 'Yakin') {
                $.ajax({
                    url: '<?= base_url(); ?>produk/delete',
                    type: 'POST',
                    dataType: 'json',
                    data: "ID=" + ID,
                    success: function(r) {
                        if (r.status === true) {
                            swal('Berhasil !', 'Berhasil Menghapus Data Produk', 'success');
                            $('#table').dataTable().api().ajax.reload();
                        } else {
                            swal('Gagal !', 'Gagal Menghapus Data Produk', 'error');
                        }
                    }
                });
            }
        });
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#edit-foto').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function readURL2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#add-foto').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#foto").change(function() {
        readURL2(this);
    });
    $("#prev-foto").change(function() {
        readURL(this);
    });
</script>