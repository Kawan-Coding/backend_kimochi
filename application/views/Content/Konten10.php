<SCript>console.log("FIRST")</SCript>
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
<section id="produk">
    <h4>allowed payment</h4>
    <hr>
    <div class="col-12 text-right">
        <button class="btn btn-info " data-toggle="modal" data-target="#add" style="position: fixed; bottom: 36px;   right: 20px; padding: 18.5px;
    z-index: 10;" onclick="create()">
            <i class="fa fa-plus"></i>
        </button>
    </div>
    <div class="col-12 card shadow mt-5 mb-5">
        <h4 class="my-3">Data allowed payment</h4>
        <table id="table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Cabang</th>
                    <th>Metode Pembayaran</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tbodyid">

            </tbody>
        </table>
    </div>
</section> <!-- Modal -->
<!-- Modal -->
<div class="modal fade col-sm-6 offset-md-3" id="edit" style="overflow: auto;">
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
                                <div class="col-md-12">
                                    <label for="cabang_id" class="control-label">Cabang</label>
                                    <div class="form-group">
                                        <select type="text" name="cabang_id" value="" class="form-control" id="cabang_id" required />
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="nama" class="control-label">Metode Pembayaran</label>
                                    <div id="metode_pembayaran_container" class="row">
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

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/12.0.0/classic/ckeditor.js"></script>
<script>
    let m_view = 'view';
    let bash_api = "<?php echo base_url('sapi/allowed_payment/') ?>";
    var rendered_data_id_cabang = [];
    var number, is_update;
    let label = " allowed payment ";
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
                    rendered_data_id_cabang.push(JsonResultRow[0].cabang_id);
                    return get_nama_cabang_byID(JsonResultRow[0].cabang_id);
                }
            }, {
                "render": function(data, type, JsonResultRow, meta) {
                    return render_content_table(JsonResultRow);
                }
            }, {
                "render": function(data, type, JsonResultRow, meta) {
                    return '<button class="btn btn-info edit_jenis"  style="width: 40px; margin-right : 5px;" onclick ="read(' + "'" + JsonResultRow[0].cabang_id + "'" + ')"><i class="fa fa-eye"></i></button>' +
                        '<button class="btn btn-info edit_jenis" style="width: 40px;margin-right : 5px;" onclick ="update(' + "'" + JsonResultRow[0].cabang_id + "'" + ')"><i class="fa fa-pencil-square-o"></i></a>' +
                        '<button class="btn btn-danger delete_jenis" style="width: 40px;" onclick ="del(' + "'" + JsonResultRow[0].cabang_id + "'" + ')"><i class="fa fa-trash-o"></i></a>';
                }
            }

        ]
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
        $('#image_preview,#cabang_id,#metode_pembayaran_container').empty();
        $("#foto").prop("required", false);
        $("#form").removeClass("was-validated").addClass("needs-validation");

    })

    function conf_state(state) {
        if (state == "read") {
            $('.modal-title').text(state + label);
            $("#form :input,select").prop("readonly", true); //change
            $('#conf').hide(); //change
            $("#form input").css("color", "black");
            $("#createupdate").show();
            

        } else if (state == "update" || state == "create") {
            $('.modal-title').text(state + label);
            $("#form :input,select").prop("readonly", false)
            $("#form input").css("color", "#464a4c");
            $('#conf').show();
            $("#createupdate").hide();
            
        }
    }

    function read(ID, state = "read") {
        $.ajax({
            url: bash_api + 'read',
            type: 'POST',
            data: "cabang_id=" + ID,
            success: function(r) {
                if (r.error == false) {
                    render_dropdown('#cabang_id', arr_cabang_all.data);
                    render_checkbox('#metode_pembayaran_container', arr_metode_pembayaran_all.data);
                    render_placehorder_checkbox(r.data[0]);
                    conf_state(state);
                    $("select[id='cabang_id'] option[value=" + r.data[0][0].cabang_id + "]").attr("selected", "selected");
                    // console.log("TCL: read -> r.data.cabang_id", r.data[0][0].cabang_id);

                    $("#form select").prop("disabled", 'disabled');
                    $('#edit').modal('show');
                } else {
                    swal('Gagal !', r.msg, 'error');
                }
            }
        })
    }

    function update(ID) {

        read(ID, "update");
        $("#form select").prop("disabled", 'disabled');
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
                    // mydata.append('del_cabang_id', ID);
                    mydata.append('cabang_id',ID);
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
        $("#form input").val('');
        $('#edit').modal('show');
        $("#form select").prop("disabled", false);
        // $('.modal-title').text("tambah jenis pariwisata");
        $('.form-group').removeClass('has-error'); // clear error class
        render_dropdown('#cabang_id', arr_cabang_all.data, 'insert');
        render_checkbox('#metode_pembayaran_container', arr_metode_pembayaran_all.data);
        $(function() {
            $('#submit').click(function(event) {
                event.preventDefault();
                if ($('#form')[0].checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                    swal("Insert Gagal!", "form tidak valid", "error");
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
                                swal("Insert Berhasil!", '', "success");
                                table.ajax.reload();
                                $('#edit').modal('toggle');
                            } else {
                                swal("Insert Gagal!", r.msg, "error");
                            }
                        },
                        complete: function() {
                            
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
                    data: "cabang_id=" + ID,
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
    function render_content_table(array) {
        str = '';
        array.forEach(element => {
            str += '<span class="label label-success" style="margin:3px">' + get_nama_metode_pembayaran_byID(element.metode_pembayaran_id) + '</span>';
        });
        return str;
    }
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
        return arr_cabang_all;
    }

    function get_nama_cabang_byID(id) {
        if (arr_cabang_all == "") {
            arr_cabang_all = get_jenis_all();
        }
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
    var arr_metode_pembayaran_all = "";

    function get_kategori_all() {
        $.ajax({
            url: "<?php echo base_url('sapi/metode_pembayaran/') ?>" + "get_all",
            async: false,
            type: 'GET',
            success: function(r) {
                if (r.error == false) {
                    arr_metode_pembayaran_all = r;
                } else {
                    swal('Gagal !', r.data, 'error');
                }
            }
        })
        return arr_metode_pembayaran_all;
    }

    function get_nama_metode_pembayaran_byID(id) {
        if (arr_metode_pembayaran_all == "") {
            arr_metode_pembayaran_all = get_kategori_all();
        }
        var result = arr_metode_pembayaran_all.data.filter(function(element) {
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
    function render_dropdown(id, data,state='') {
        $.each(data, function(key, value) {
            if (state === 'insert') {
                if (!rendered_data_id_cabang.includes(value.id)) {
                    $(id).append("<option value=" + value.id + ">" + value.nama + "</option>");
                }
            }
            else {
                $(id).append("<option value=" + value.id + ">" + value.nama + "</option>");
            }
        });
    }

    function render_checkbox(id, data) {

        $.each(data, function(key, value) {
            // console.log("TCL: functionrender_checkbox -> value", value)
            let a = '<div class="form-check col-md-6">';
            let b = '<input class="form-check-input" name="metode_pembayaran_id[]" type="checkbox" value="' + value.id;
            let c = '" id="defaultCheck' + value.id + '">'
            let d = '<label class="form-check-label" for="defaultCheck' + value.id + '">'
            let e = '</label></div>'



            $(id).append(a + b + c + d + value.nama + e);
        });
    }

    function render_placehorder_checkbox(data) {
        data.forEach(element => {
            // console.log("TCL: functionrender_placehorder_checkbox -> element", element);
            $('#defaultCheck' + element.metode_pembayaran_id).prop('checked', true);
            $('textarea').attr('placeholder', $(this).is(':checked') ? 'name' : 'age');
        });
    }
</script>