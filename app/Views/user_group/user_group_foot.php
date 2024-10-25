<script>
    var save_method;
    var table;

    $(document).ready(function() {

        //datatables
        table = $('#user-group').DataTable({
            "responsive": true,
            "autoWidth": false,
            "processing": true, //Feature control the processing indicator.
            "paging": true,
            "searching": true,
            "pageLength": 10,

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('user_group/listData') ?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [-1], //last column
                "orderable": false, //set not orderable
                "searchable": false,
                "className": "all",
                "render": function(data, type, full, meta) {
                    return `
                    <button class="btn btn-info btn-sm" onclick="editData(${data})"><i class="fas fa-pen"></i></button>
                    <button class="btn btn-danger btn-sm" onclick="deleteData(${data})"><i class="fas fa-trash"></i></button>
                    `;
                }
            }, ],
            error: function(xhr, error, thrown) {
                console.log(xhr);
            }
        });

        //set input/textarea/select event when change value, remove class error and remove text help block 
        $("input").change(function() {
            $(this).removeClass('is-invalid');
            $(this).addClass('is-valid');
            $(this).next().empty();
        });
        $("textarea").change(function() {
            $(this).removeClass('is-invalid');
            $(this).addClass('is-valid');
            $(this).next().empty();
        });

    });

    function addData() {
        save_method = 'add';
        $('#form')[0].reset();
        $('textarea').removeClass('is-invalid');
        $('input').removeClass('is-invalid');
        $('.invalid-feedback').empty();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Data');
    }

    function editData(id) {
        save_method = 'edit';
        $('#form')[0].reset();
        $('textarea').removeClass('is-invalid');
        $('input').removeClass('is-invalid');
        $('.invalid-feedback').empty();

        //Ajax Load data from ajax
        $.ajax({
            url: "<?= base_url() ?>user_group/getData/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id"]').val(data.id);
                $('[name="level"]').val(data.level);
                $('[name="deskripsi"]').val(data.deskripsi);
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('edit Data'); // Set title to Bootstrap modal title

            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    title: "Error!",
                    text: "gagal mengambil data",
                    icon: "error"
                });
            }
        });
    }

    function save() {
        $('#btnSave').text('processing...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        var url;

        if (save_method == 'add') {
            url = "<?= base_url() ?>user_group/addData";
        } else {
            url = "<?= base_url() ?>user_group/editData";
        }

        let dataForm = new FormData($('#form')[0]);
        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: dataForm,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data) {
                if (data.status) //if success close modal and reload ajax table
                {
                    Swal.fire({
                        title: "Success!",
                        text: "Berhasil menyimpan data",
                        icon: "success"
                    });
                    reload_table();
                    $('#modal_form').modal('hide');
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="' + data.inputerror[i] + '"]').addClass('is-invalid');
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                    }
                }
                $('#btnSave').text('Save'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    title: "Error!",
                    text: "gagal menyimpan data",
                    icon: "error"
                });
                $('#btnSave').text('Save'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            }
        });
    }

    function deleteData(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "Konfirmasi apakah akan menghapus data",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#fa4646",
            cancelButtonColor: "#b0b8b4",
            confirmButtonText: "Delete"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url() ?>user_group/deleteData/" + id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Data berhasil dihapus",
                                icon: "success"
                            });
                            reload_table();
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: data.message,
                                icon: "error"
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            title: "Error!",
                            text: "gagal hapus status 500",
                            icon: "error"
                        });
                    }
                });
            }
        });
    }

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax 
    }
</script>

<div class='modal fade' id='modal_form' role='dialog'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='modal-title'></h4> <small class='modal-subtitle'></small>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <form action="#" id="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id">
                    <div class="form-group row">
                        <label for="level" class="col-sm-2 col-form-label">Level Name <span style="color:#FF0000">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="level" id="level" placeholder="level">
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi <span style="color:#FF0000">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="deskripsi" id="deskripsi" placeholder="Deskripsi">
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class='modal-footer justify-content-between'>
                <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
                <button id='btnSave' type='submit' class='btn btn-info' onclick='save()'>Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>