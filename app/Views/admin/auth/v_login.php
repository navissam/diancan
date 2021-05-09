<?= $this->extend('admin/auth/template') ?>

<?= $this->section('content') ?>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="register-logo">
            <img src="<?= base_url(); ?>/img/favicon-32x32.png" alt="点餐系统" class="brand-image img-circle elevation-3" style="opacity: .8">
            <b>点餐系统</b>
        </div>
        <!-- /.login-logo -->
        <?php if (!empty(session()->getFlashdata('msg'))) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>
                    <?= session()->getFlashdata('msg') ?>
                </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif ?>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">必须先登入才能使用</p>
                <form action="<?= base_url('/admin/auth/login'); ?>" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="userID" class="form-control" placeholder="账号" required>
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
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    记住我
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
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <?= $this->endSection() ?>