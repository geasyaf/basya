<script>
    let table;
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    $(document).ready(function() {

        <?php if ($level == '') { ?>
            $('#card_group').hide();
        <?php } ?>

        //datatables
        table = $('#group_permission').DataTable({
            order: [],
            "responsive": true,
            "autoWidth": false,
            "processing": true, //Feature control the processing indicator.
            "paging": true,
            "searching": true,
            "pageLength": 10,

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('group_permission/listData') ?>",
                "type": "POST",
                "data": {
                    level: '<?= $level; ?>'
                }
            },
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

    $('#group_level').on('change', function() {
        $('#card_group').show();
        window.location.replace("<?= base_url() ?>group-permission?level=" + this.value);
    })

    function addPermission(val, method, id, level) {
        $.ajax({
            url: "<?= base_url() ?>group_permission/addPermission",
            type: "POST",
            dataType: "JSON",
            data: {
                method: method,
                id: id,
                level: level,
                checked: val.checked
            },
            success: function(data) {
                if (data.status) {
                    Toast.fire({
                        icon: 'success',
                        title: 'status berhasil dirubah'
                    })
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
                    text: "gagal ubah status 500",
                    icon: "error"
                });
            }
        });
    }

    function save(method) {
        $('#btn-save').text('processing...'); //change button text
        $('#btn-save').attr('disabled', true); //set button disable 
        let url = "<?= base_url() ?>menu/saveData/" + method;;

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
                            window.location.href = "<?= base_url() ?>menu";
                        }
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            window.location.href = "<?= base_url() ?>menu";
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
                    url: "<?= base_url() ?>menu/deleteData/" + id,
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
                                text: "gagal hapus status 505",
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

    function changeStatus(id) {
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
                    url: "<?= base_url() ?>menu/changeStatus/" + id,
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
                            text: "gagal ubah status 500",
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