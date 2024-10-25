<script>
    let table;
    $(document).ready(function() {

        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });
        //datatables
        table = $('#produk_master').DataTable({
            "responsive": true,
            "autoWidth": false,
            "processing": true, //Feature control the processing indicator.
            "paging": true,
            "searching": true,
            "pageLength": 10,

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('Produk_master/listData') ?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [-1], //last column
                "orderable": false, //set not orderable
                "searchable": false,
                "className": "all",
                "render": function(data, type, full, meta) {
                    return `<div class="btn-group">
                                <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="<?= base_url() ?>Produk_master/editData/${data}"><i class="fas fa-pen"></i> Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" onclick="deleteData('${data}')"><i class="fas fa-trash"></i> Delete</a>
                                </div>
                            </div>`;
                }
            }, ],
            error: function(xhr, error, thrown) {
                console.log(xhr);
            }
        });

        //set input/textarea/select event when change value, remove class error and remove text error 
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

    function save(method) {
        $('#btn-save').text('processing...'); //change button text
        $('#btn-save').attr('disabled', true); //set button disable 
        let url = "<?= base_url() ?>produk_master/saveData/" + method;;

        let dataForm = new FormData($('#form')[0]);
        for (var pair of dataForm.entries()) {
            console.log(pair[0]+ ', ' + pair[1]); 
        }
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
                    let timerInterval;
                    Swal.fire({
                        title: "Berhasil!",
                        text: "Data berhasil disimpan",
                        icon: "success",
                        timer: 1800,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                            window.location.href = "<?= base_url() ?>produk_master";
                        }
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            window.location.href = "<?= base_url() ?>produk_master";
                        }
                    });
                    $('#btn-save').text('Save'); //change button text
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('#' + data.inputerror[i]).addClass('is-invalid');
                        $('#' + data.inputerror[i]).next().text(data.error_string[i]);
                    }
                    $('#btn-save').text('Save'); //change button text
                    $('#btn-save').attr('disabled', false); //set button enable 
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    title: "Error!",
                    text: "gagal menyimpan data",
                    icon: "error"
                });
                console.log(jqXHR);
                $('#btn-save').text('Save'); //change button text
                $('#btn-save').attr('disabled', false); //set button enable 
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
                    url: "<?= base_url() ?>Produk_master/deleteData/" + id,
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
                        console.log(errorThrown);
                    }
                });
            }
        });
    }

    function changeStatus(id) {
        var cek = "<?= base_url() ?>" + "produk-master/changeStatus/" + id;
        console.log(cek);
        Swal.fire({
            title: "Are you sure?",
            text: "Konfirmasi apakah akan mengubah status",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#b0b8b4",
            confirmButtonText: "Save" 
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url() ?>produk_master/changeStatus/" + id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status) {
                            Swal.fire({
                                title: "Updated!",
                                text: "Status berhasil dirubah",
                                icon: "success"
                            });
                            reload_table();
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: "gagal ubah status 505",
                                icon: "error"
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            title: "Error!",
                            text: "gagal ubah status 500" + textStatus,
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