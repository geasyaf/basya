<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Log in to Basya Investama</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="<?= base_url() ?>/assets/dist/img/favicon_white.png">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <style>
        .login-box {
            margin-top: -100px;
        }
        .login-card-body {
            border-radius: 20px;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box br-2">
        <div class="login-logo mt-5 mb-4">
            <!-- <a href="#">Resort <b>Pangrango</b></a> -->
            <img src="<?= base_url() ?>/assets/dist/img/basya-logo.png" alt="logo" width="250">
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Harap login dahulu</p>

                <form action="#" method="post" id="form">
                <?= csrf_field(); ?>
                    <div class="input-group mb-3">
                        <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <button type="submit" id="save" class="btn btn-primary btn-block">Sign In</button>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>/assets/dist/js/adminlte.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script>
        $('#form').on('submit', function(e) {
            e.preventDefault(); // Hentikan pengiriman form standar
            $("#save").text('Processing...');
            $("#save").attr('disabled', true);

            let dataForm = new FormData(this);
            $.ajax({
                url: "<?= base_url() ?>login/action",
                type: "POST",
                data: dataForm,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function(data) {
                    if (data.status == false) {
                        swal("Error", data.message, "error");
                    } else {
                        location.reload();
                    }
                    $("#save").text('Sign In');
                    $("#save").attr('disabled', false);
                },
                error: function() {
                    swal("Error", "An unexpected error occurred", "error");
                    $("#save").text('Sign In');
                    $("#save").attr('disabled', false);
                }
            });
        });
    </script>
</body>

</html>