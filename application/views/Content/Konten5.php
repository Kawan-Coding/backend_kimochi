<script>
    console.log('start');
</script>
<style>
    ::-webkit-scrollbar {
        width: 0px;
    }

    ::-webkit-scrollbar-track {
        background: transparent;
    }

    ::-webkit-scrollbar-thumb {
        background: white;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
<section id="produk">
    <h4>Responsible</h4>
    <hr>
    <div class="col-12 text-right">
        <button class="btn btn-info " data-toggle="modal" data-target="#add" style="position: fixed; bottom: 36px;   right: 20px; padding: 18.5px;
    z-index: 10;" onclick="create()">
            <i class="fa fa-plus"></i>
        </button>
    </div>
    <div class="col-12 card shadow mt-5 mb-5">
        <h4 class="my-3">Data Responsible</h4>
        <table id="table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Cabang</th>
                    <th>Pegawai</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tbodyid">

            </tbody>
        </table>
    </div>

</section> <!-- Modal -->
<!-- Modal -->
<div class="modal fade col-sm-8 offset-md-2" id="edit" style="overflow: auto;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>

            <div class="modal-body row">

                <div class="col-sm-12">
                    <form method="POST" id="form" class="form-horizontal need-validate" novalidate>
                        <div class="box-body">
                            <div class="row clearfix">
                                <!-- EDITED -->
                                <div class="col-md-6">
                                    <label for="cabang_id" class="control-label">Cabang</label>
                                    <div class="form-group">
                                        <select type="text" name="cabang_id" value="" class="form-control" id="cabang_id"></select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="pegawai_id" class="control-label">Pegawai</label>
                                    <div class="form-group">
                                        <select type="text" name="pegawai_id" value="" class="form-control" id="pegawai_id"></select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="role" class="control-label">Role</label>
                                    <div class="form-group">
                                        <select type="text" name="role" value="" class="form-control" id="role">
                                            <option value="kepala cabang">kepala cabang</option>
                                            <option value="kasir">kasir</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" id="status_group">
                                    <label for="status" class="control-label">Status</label>
                                    <div class="form-group">
                                        <select type="text" name="status" value="" class="form-control" id="status">
                                            <option value="not activated">not activated</option>
                                            <option value="activated">activated</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- </div> -->
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
</div>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script> -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/12.0.0/classic/ckeditor.js"></script>
<script>
    let m_view = 'view';
    let bash_api = "<?php echo base_url('sapi/responsible/') ?>";
    console.log(bash_api);
    var number, is_update, latlong = '';
    let label = " Responsible ";
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
        "ajax": {
            url: bash_api + 'get_all',
            dataSrc: 'data'
        },
        "columns": [{
                "render": function() {
                    return get_index();
                }
            }, {
                "render": function(data, type, JsonResultRow, meta) {
                    return get_nama_cabang_byID(JsonResultRow.cabang_id);
                }
            }, {
                "render": function(data, type, JsonResultRow, meta) {
                    return get_nama_pegawai_byID(JsonResultRow.pegawai_id);
                }
            }, {
                "data": "role"
            }, {
                "data": "status"
            }, {
                "render": function(data, type, JsonResultRow, meta) {
                    return '<button class="btn btn-info edit_jenis"  style="width: 40px; margin-right : 5px;" onclick ="read(' + "'" + JsonResultRow.id + "'" + ')"><i class="fa fa-eye"></i></button>' +
                        '<button class="btn btn-info edit_jenis" style="width: 40px;margin-right : 5px;" onclick ="update(' + "'" + JsonResultRow.id + "'" + ')"><i class="fa fa-pencil-square-o"></i></a>' +
                        '<button class="btn btn-danger delete_jenis" style="width: 40px;" onclick ="del(' + "'" + JsonResultRow.id + "'" + ')"><i class="fa fa-trash-o"></i></a>';
                }
            }

        ]
    });


    $('#edit').on('show.bs.modal', function() {
        console.log('modal show');

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
        $('#image_preview,#cabang_id,#pegawai_id').empty();
        $("#foto").prop("required", false);
        $("#form").removeClass("was-validated").addClass("needs-validation");

    })

    function conf_state(state) {
        if (state == "read") {
            $('#conf').hide();
            $('.modal-title').text(state + label);
            $("#form :input,select").prop("readonly", true); //change
            $("#form input").css("color", "black");
            $("#createupdate").show();

        } else if (state == "update" || state == "create") {
            $('#conf').show();
            $('.modal-title').text(state + label);
            $("#form :input,select").prop("readonly", false)
            $("#form input").css("color", "#464a4c");
            $("#createupdate").hide();
        }
    }

    function read(ID, state = "read") {
        $("#status_group").show();
        console.log("edit" + edit);
        $.ajax({
            url: bash_api + 'read',
            type: 'POST',
            data: "id=" + ID,
            success: function(r) {
                // console.log(r);
                if (r.error == false) {
                    render_dropdown('#cabang_id', arr_cabang_all.data);
                    render_dropdown2('#pegawai_id', arr_pegawai_all.data);
                    conf_state(state);
                    // console.log(arr_pegawai_all.data['id'].includes(r.data.pegawai_id));
                    // if (get_nama_pegawai_byID(r.data.pegawai_id) != '<p class="text-danger">DELETED</p>') {
                        $("select[id='pegawai_id'] option[value=" + r.data.pegawai_id + "]").attr("selected", "selected");
                    // } else {
                    //     $("select[id='pegawai_id']").append("<option value=" + r.data.pegawai_id + " selected >" + get_nama_pegawai_byID(r.data.pegawai_id) + "</option>");
                    // }
                    // if (get_nama_pegawai_byID(r.data.cabang_id) != '<p class="text-danger">DELETED</p>') {
                        $("select[id='cabang_id'] option[value=" + r.data.cabang_id + "]").attr("selected", "selected");
                    // } else {
                    //     $("select[id='cabang_id']").append("<option value=" + r.data.cabang_id + " selected >" + get_nama_cabang_byID(r.data.cabang_id) + "</option>");
                    // }


                    $("select[id='pegawai_id'] option[value=" + r.data.pegawai_id + "]").attr("selected", "selected");
                    $("select[id='role'] option[value='" + r.data.role + "']").attr("selected", "selected");
                    $("select[id='status'] option[value='" + r.data.status + "']").attr("selected", "selected");


                    $('#nama').val(r.data.nama);
                    // $('#latlong').val(r.data.latlong);
                    $('#alamat').val(r.data.alamat);
                    $('#create_at').val(r.data.create_at);
                    $('#update_at').val(r.data.update_at);
                    $('#edit').modal('show');
                } else {
                    swal('Gagal !', r.msg, 'error');
                }
            }
        })
    }

    function update(ID) {
       
        read(ID, "update");
        // $('.modal-title').text("update jenis pariwisata");
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
        $("#status_group").hide();
        $("#foto,#password").prop("required", true);
        $("#image_preview").append('<div class="show-image"><img src="" class="rounded image_view p-1" alt="..." style="width:100%;" id="img_preview_src">');
        render_dropdown('#cabang_id', arr_cabang_all.data);
        render_dropdown2('#pegawai_id', arr_pegawai_all.data);

        conf_state("create");
        $("#form input").val('');
        $('#edit').modal('show');
        // $('.modal-title').text("tambah jenis pariwisata");
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
    $("#foto").change(function() {
        console.log('cahne');
        readURL(this);
    });
    //change
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#img_preview_src').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }


    // var arr_cabang_all; sebelumnya gini error
</script>

<script>
    //change
    var arr_cabang_all = "";

    function get_jenis_all() {
        $.ajax({
            url: "<?php echo base_url('sapi/cabang/') ?>" + "get_all",
            async: false,
            type: 'GET',
            success: function(r) {
                if (r.error == false) {
                    arr_cabang_all = r;
                } else {
                    swal('Gagal !', r.data, 'error');
                }
            }
        })
        console.log(arr_cabang_all);
        return arr_cabang_all;
    }

    function get_nama_cabang_byID(id) {
        if (arr_cabang_all == "") {
            arr_cabang_all = get_jenis_all();
        }
        console.log(arr_cabang_all.data);
        console.log(id);
        var result = arr_cabang_all.data.filter(function(element) {
            return element.id == id;
        })
        if (result == "") {
            return '<p class="text-danger">DELETED</p>';
        } else {
            return result[0].nama;
        }
    }
</script>

<script>
    var arr_pegawai_all = "";

    function get_kategori_all() {
        $.ajax({
            url: "<?php echo base_url('sapi/pegawai/') ?>" + "get_all",
            async: false,
            type: 'GET',
            success: function(r) {
                if (r.error == false) {
                    arr_pegawai_all = r;
                } else {
                    swal('Gagal !', r.data, 'error');
                }
            }
        })
        return arr_pegawai_all;
    }

    function get_nama_pegawai_byID(id) {
        if (arr_pegawai_all == "") {
            arr_pegawai_all = get_kategori_all();
        }
        console.log(arr_pegawai_all.data)
        var result = arr_pegawai_all.data.filter(function(element) {
            return element.id == id;
        })
        // console.log(result[0].nama)  POIN kesalahana
        if (result == "") {
            return '<p class="text-danger">DELETED</p>';
        } else {
            return result[0].nama_lengkap;
        }
    }
</script>

<script>
    function render_dropdown(id, data) {
        console.log(data);
        $.each(data, function(key, value) {
            $(id).append("<option value=" + value.id + ">" + value.nama + "</option>");
        });
    }

    function render_dropdown2(id, data) {
        console.log(data);
        $.each(data, function(key, value) {
            $(id).append("<option value=" + value.id + ">" + value.nama_lengkap + "</option>");
        });
    }
</script>