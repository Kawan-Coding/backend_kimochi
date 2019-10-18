<style>
input[readonly]{
  background-color:transparent;
  border: 0;
  font-size: 1em;
}

</style>
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
                    <th width="25%">Nama</th>
                    <th width="25%">Nomor</th>
                    <th width="15%">Create At</th>
                    <th width="15%">Update At</th>
                    <th width="15%">Actions</th>
                </tr>
            </thead>
            <tbody id="tbodyid">

            </tbody>
        </table>
    </div>
</section> <!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="edit">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>

            <div class="modal-body row">
                <div class="col-sm-12">
                    <form method="POST" id="form" class="form-horizontal was-validated">
                        <div class="box-body">
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <label for="nama" class="control-label">Nama</label>
                                    <div class="form-group">
                                        <input type="text" name="nama" value="" class="form-control" id="nama" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="nomor" class="control-label">Nomor</label>
                                    <div class="form-group">
                                        <input type="text" name="nomor" value="" class="form-control" id="nomor" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="create_at" class="control-label">Create At</label>
                                    <div class="form-group">
                                        <input type="text" name="create_at" value="" class="form-control" id="create_at" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="update_at" class="control-label">Update At</label>
                                    <div class="form-group">
                                        <input type="text" name="update_at" value="" class="form-control" id="update_at" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer" style="float: right;" id="conf">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary" id="submit">Simpan
                                Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script> -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/12.0.0/classic/ckeditor.js"></script>
<script>
    let m_view = 'view';
    let bash_api = "<?php echo base_url('sapi/metode_pembayaran/') ?>";
    console.log(bash_api);
    var number, is_update;
    let label = " metode_pembayaran ";
    $(document).ready(function() {
        table.ajax.reload();
        number = 0;
        is_update = false;
    })


    function get_index() {
        if (is_update) {
            number = 1;
            is_update = false;
        } else {
            number++;
        }
        return number;
    }
    var table = $('#table').DataTable({
        "ajax": bash_api + "get_all",
        "columns": [{
            "render": function() {
                return get_index();
            }
        }, {
            "data": "nama"
        }, {
            "data": "nomor"
        }, {
            "data": "create_at"
        }, {
            "data": "update_at"
        }, {
            "render": function(data, type, JsonResultRow, meta) {
                return '<button class="btn btn-info edit_jenis"  style="width: 40px; margin-right : 5px;" onclick ="read(' + "'" + JsonResultRow.id + "'" + ')"><i class="fa fa-eye"></i></button>' +
                    '<button class="btn btn-info edit_jenis" style="width: 40px;margin-right : 5px;" onclick ="update(' + "'" + JsonResultRow.id + "'" + ')"><i class="fa fa-pencil-square-o"></i></a>' +
                    '<button class="btn btn-danger delete_jenis" style="width: 40px;" onclick ="del(' + "'" + JsonResultRow.id + "'" + ')"><i class="fa fa-trash-o"></i></a>';
            }

        }]
    });



    $('#edit').on('hidden.bs.modal', function(e) {
        if (e.handled !== true) {
            e.handled = true;
            jenis_sub = null;
        }
        console.log('modal hidden');
        $('#modal_crop').unbind();
        $('#submit').off('click');

    })

    function read(ID, edit = false) {
        console.log("edit" + edit);
        $.ajax({
            url: bash_api + 'read',
            type: 'POST',
            data: "id=" + ID,
            success: function(r) {
                // console.log(r);
                if (r.error == false) {
                    if(!edit){
                        $('.modal-title').text("Read"+label);
                        $( "#form :input" ).prop("readonly", true);
                        $('#conf').hide();
                        $( "#form :input" ).css("color", "black");
                        
                    }else{
                        $('.modal-title').text("Update"+label);
                        $( "#form :input" ).prop("readonly", false)
                        $( "#form :input" ).css("color", "#464a4c");
                        $('#conf').show();
                    }
                    $('#nama').val(r.data.nama);
                    $('#nomor').val(r.data.nomor);
                    $('#create_at').val(r.data);
                    $('#update_at').val(r.data.update_at);
                    $('#edit').modal('show');
                } else {
                    swal('Gagal !', 'Gdd', 'error');
                }
            }
        })
    }

    function update(ID) {
        read(ID, true);
        $('.modal-title').text("update jenis pariwisata");
        // $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $(function() {
            $('#submit').click(function(e) {
                var mydata = new FormData(document.getElementById("form"));
                mydata.append('id', ID);
                $.ajax({
                    url: bash_api + 'update',
                    type: "POST",
                    dataType: "json",
                    data: mydata,
                    async: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {},
                    success: function(r) {
                        if (r.error == false) {
                            is_update = true;
                            swal("Berhasil!", "Insert data berhasil!", "success");
                            table.ajax.reload();
                        } else {
                            swal("Kesalahan!", r.data, "error");
                        }
                    },
                    complete: function() {
                        $('#edit').modal('toggle');
                    }
                });
            });
        });
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
                    url: bash_api + 'delete',
                    type: 'POST',
                    dataType: 'json',
                    data: "id=" + ID,
                    success: function(r) {
                        if (r.error === true) {
                            swal('Gagal !', 'Hapus Gagal', 'error');
                            table.ajax.reload();
                        } else {
                            is_update = true;
                            swal('Berhasil !', 'Hapus berhasil', 'success');
                            $('#table').dataTable().api().ajax.reload();
                        }
                    }
                });
            }
        });
    }
</script>