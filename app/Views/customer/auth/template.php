<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>点餐系统</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url(''); ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url(''); ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(''); ?>/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- <link href="https://fonts.googleapis.com/css?family=Noto+Serif+SC:300,400,400i,700" rel="stylesheet"> -->
    <link rel="stylesheet" href="<?= base_url('/'); ?>/fonts/font.css">
    <style type="text/css">
        @media only screen and (min-width: 992px) {

            .login-page,
            .register-page {
                background: url("<?= base_url(''); ?>/img/view.jpg") no-repeat center center fixed;
                background-size: cover;
            }
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background: #fff;
            border-top: 1px solid #dee2e6;
            color: #869099;
            box-sizing: border-box;
            padding: .812rem;
            text-align: center;
            font-size: 10px;
        }
    </style>
</head>


<?= $this->renderSection('content') ?>


<!-- jQuery -->
<script src="<?= base_url(''); ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url(''); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url(''); ?>/dist/js/adminlte.min.js"></script>

</body>

</html>