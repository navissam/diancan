<?= $this->extend('customer/auth/template') ?>

<?= $this->section('content') ?>

<body class="hold-transition login-page">
    <div class="login-box">

        <div class="card">
            <div class="card-body login-card-body">
                <div class="register-logo mb-4">
                    <img src="<?= base_url(); ?>/img/logo.png" alt="点餐系统" class="brand-image img-circle elevation-3" style="width: 50px;">
                    <b class="">点餐系统</b>
                </div>
                <img src="<?= base_url(); ?>/img/maintain.jpg" alt="">
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
    <footer class="footer d-print-none">
        <!-- Default to the left -->
        <strong>版权所有：印尼青山莫罗瓦利园区电气部信息科 &copy; GWP 2021</strong> Copyright Indonesia Tsingshan. All rights reserved.
    </footer>
</body>
<?= $this->endSection() ?>