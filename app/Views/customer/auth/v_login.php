<?= $this->extend('customer/auth/template') ?>

<?= $this->section('content') ?>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- <div class="register-logo">
            <img src="<?= base_url(); ?>/img/logo.png" alt="点餐系统" class="brand-image img-circle elevation-3" style="width: 60px;">
            <b class="text-light">点餐系统</b>
        </div> -->
        <!-- /.login-logo -->
        <?php if (!empty(session()->getFlashdata('error'))) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif ?>
        <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif ?>
        <div class="card">
            <div class="card-body login-card-body">
                <div class="register-logo mb-4">
                    <img src="<?= base_url(); ?>/img/logo.png" alt="点餐系统" class="brand-image img-circle elevation-3" style="width: 50px;">
                    <b class="">点餐系统</b>
                </div>
                <!-- <div class="row justify-content-center">
                    <div class="col">
                        <div class="">
                            <img src="<?= base_url(); ?>/img/logo.png" alt="点餐系统" class="brand-image img-circle elevation-3 m-1" style="width: 50px;">
                            <span class="h3 my-auto">点餐系统</span>
                        </div>
                    </div>
                </div> -->
                <!-- <p class="login-box-msg">必须先登入才能使用</p> -->
                <form action="<?= base_url('/auth/login'); ?>" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="empID" class="form-control" placeholder="账号 / 工号" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="pass" class="form-control" placeholder="密码" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember">
                                <label for="remember">
                                    记住密码
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">登入</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <!-- <p class="mb-1">
                    <a href="<?= base_url('/register') ?>">注册新账号</a>
                </p> -->
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