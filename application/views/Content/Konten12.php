<style>
    input[readonly] {
        background-color: transparent;
        border: 0;
        font-size: 1em;
    }
</style>
<section id="produk">
    <h4>Metode Diskon</h4>
    <hr>
    <div class="col-12 text-right">
        <button class="btn btn-info " data-toggle="modal" data-target="#add" style="position: fixed; bottom: 36px;   right: 20px; padding: 18.5px;
    z-index: 10;" onclick="create()">
            <i class="fa fa-plus"></i>
        </button>
    </div>
    <div class="col-12 card shadow mt-5 mb-5">
        <h4 class="my-3">Data Diskon</h4>
        <table id="table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Diskon</th>
                    <th>nama</th>
                    <th>detail</th>
                    <th>mulai</th>
                    <th>akhir</th>
                    <th>potongan</th>
                    <th>kuota</th>
                    <!-- <th>Create At</th> -->
                    <!-- <th>Update At</th> -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tbodyid">

            </tbody>
        </table>
    </div>
</section> <!-- Modal -->
<!-- Modal -->
<div class="modal fade col-sm-6 offset-md-3" id="edit">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>

            <div class="modal-body row">
                <div class="col-sm-12">
                    <form method="POST" id="form" class="form-horizontal was-validated" novalidate>
                        <div class="box-body">
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <label for="kode_diskon" class="control-label">Kode Diskon</label>
                                    <div class="form-group">
                                        <input type="text" name="kode_diskon" value="" class="form-control" id="kode_diskon" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="nama" class="control-label">Nama</label>
                                    <div class="form-group">
                                        <input type="text" name="nama" value="" class="form-control" id="nama" required />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="detail" class="control-label">detail</label>
                                    <div class="form-group">
                                        <textarea type="text" name="detail" value="" class="form-control" id="detail" rows="3" required />
                                        </textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="mulai" class="control-label">Mulai</label>
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="date" class="form-control" name="mulai" id="mulai" placeholder="input tanggal" required>
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="akhir" class="control-label">Akhir</label>
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="date" class="form-control" name="akhir" id="akhir" placeholder="input tanggal" required>
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-md-12" style="margin-top:2em">
                                    <div class="col-md-6">
                                        <label for="potongan" class="control-label">potongan</label>
                                        <div class="form-group">
                                            <input type="number" name="tmp_potongan" value="" class="form-control" id="tmp_potongan" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="satuan" class="control-label">satuan</label>
                                        <div class="form-group">
                                            <select type="text" name="satuan" id="satuan">
                                                <option value="persen">Persen</option>
                                                <option value="rupiah">Rupiah</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="kuota" class="control-label">kuota</label>
                                        <div class="form-group">
                                            <input type="number" name="kuota" value="" class="form-control" id="kuota" required />
                                        </div>
                                    </div>
                                </div>
                                <div id="createupdate" class="row col-md-12">
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
                        </div>
                        <div class="box-footer" style="float: right;" id="conf">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary" id="submit" style="color:white">Simpan
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
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script> -->

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/12.0.0/classic/ckeditor.js"></script>
<script>
    let m_view = 'view';
    let bash_api = "<?php echo base_url('sapi/diskon/') ?>";
    console.log(bash_api);
    var number, is_update;
    let label = " Diskon ";
    $(document).ready(function() {
        table.ajax.reload();
        number = 0;
        is_update = false;
        // $.fx.speeds._default = 100;
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
            "data": "kode_diskon"
        }, {
            "data": "nama"
        }, {
            "data": "detail"
        }, {
            "data": "mulai"
        }, {
            "data": "akhir"
        }, {
            "data": "potongan"
        }, {
            "data": "kuota"

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
        $("#form input").val('');
        $('#modal_crop').unbind();
        $('#submit').off('click');
        $("#form").removeClass("was-validated").addClass("needs-validation");


    })

    function conf_state(state) {
        if (state == "read") {
            $('.modal-title').text("Read" + label);
            $("#form :input").prop("readonly", true);
            $('#conf').hide();
            $("#form input").css("color", "black");
            $("#createupdate").show();

        } else if (state == "update" || state == "create") {
            $('.modal-title').text("Update" + label);
            $("#form :input").prop("readonly", false)
            $("#form input").css("color", "#464a4c");
            $('#conf').show();
            $("#createupdate").hide();
        }
    }

    function read(ID, state = "read") {
        console.log("edit" + edit);
        $.ajax({
            url: bash_api + 'read',
            type: 'POST',
            data: "id=" + ID,
            success: function(r) {
                // console.log(r);
                if (r.error == false) {
                    conf_state(state);
                    $('#nama').val(r.data.nama);
                    $('#kode_diskon').val(r.data.kode_diskon);
                    $('#detail').val(r.data.detail);
                    $('#mulai').val(r.data.mulai);
                    $('#akhir').val(r.data.akhir);
                    get_val_potongan(r.data.potongan);
                    $('#kuota').val(r.data.kuota);
                    $('#create_at').val(r.data.update_at);
                    $('#update_at').val(r.data.update_at);
                    $('#edit').modal('show');
                } else {
                    swal('Gagal !', r.msg, 'error');
                }
            }
        })
    }

    function get_potongan() {
        var tmp_potongan = $("#tmp_potongan").val();
        var satuan = $("#satuan").val();
        if (satuan == "persen") {
            return (tmp_potongan / 100) * 1.0;
        } else if (satuan == "rupiah") {
            return -1 * tmp_potongan;
        }
    }

    function get_val_potongan(number) {
        if (number < 1 && number > 0) {
            $('#tmp_potongan').val(number * 100);
            $("select[id='satuan'] option[value='persen']").attr("selected", "selected");

        } else {
            $('#tmp_potongan').val(number * -1);
            $("select[id='satuan'] option[value='rupiah']").attr("selected", "selected");
        }
    }

    function update(ID) {
        read(ID, "update");
        $('.modal-title').text("update " + label);
        $('.form-group').removeClass('has-error'); // clear error class
        $(function() {
            $('#submit').click(function(event) {
                event.preventDefault();
                if ($('#form')[0].checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                    swal("Update Gagal!", "form tidak valid", "error");
                } else {
                    var mydata = new FormData(document.getElementById("form"));
                    mydata.append('id', ID);
                    mydata.append('potongan', get_potongan());
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
                                swal("Update Berhasil!", '', "success");
                                table.ajax.reload();
                            } else {
                                swal("Update Gagal!", r.msg, "error");
                            }
                        },
                        complete: function() {
                            $('#edit').modal('toggle');
                        }
                    });
                }
                $('#form').addClass('was-validated');

            });
        });
    }

    function create() {
        conf_state("create");
        $("#form input,textarea").val('');
        $('#edit').modal('show');
        $('.modal-title').text("insert Metode Pembayaran");
        $('.form-group').removeClass('has-error'); // clear error class
        $(function() {
            $('#submit').click(function(event) {
                event.preventDefault();
                if ($('#form')[0].checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                    swal("Insert Gagal!", "form tidak valid", "error");
                } else {
                    var mydata = new FormData(document.getElementById("form"));
                    mydata.append('potongan', get_potongan());
                    $.ajax({
                        url: bash_api + 'create',
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
                                swal("Insert Berhasil!", '', "success");
                                table.ajax.reload();
                            } else {
                                swal("Insert Gagal!", r.msg, "error");
                            }
                        },
                        complete: function() {
                            $('#edit').modal('toggle');
                        }
                    });
                }
                $('#form').addClass('was-validated');

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
                            swal('Hapus Gagal', r.msg, 'error');
                            table.ajax.reload();
                        } else {
                            is_update = true;
                            swal('Hapus berhasil', '', 'success');
                            $('#table').dataTable().api().ajax.reload();
                        }
                    }
                });
            }
        });
    }
</script>

<script>

</script>