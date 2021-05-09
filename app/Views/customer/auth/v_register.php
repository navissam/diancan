<?= $this->extend('customer/auth/template') ?>

<?= $this->section('content') ?>

<body class="hold-transition register-page">
    <div class="register-box">
        <!-- <div class="register-logo">
            <img src="<?= base_url(); ?>/img/favicon-32x32.png" alt="点餐系统" class="brand-image img-circle elevation-3" style="opacity: .8">
            <b class="text-light">点餐系统</b>
        </div> -->
        <?php if (!empty(session()->getFlashdata('error'))) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif ?>
        <div class="card">
            <div class="card-body register-card-body">
                <div class="register-logo mb-3">
                    <img src="<?= base_url(); ?>/img/logo.png" alt="点餐系统" class="brand-image img-circle elevation-3 mb-1" style="width: 50px;">
                    <b class="">点餐系统</b>
                </div>
                <!-- <p class="login-box-msg">请根据一卡通输入信息</p> -->

                <form action="<?= base_url('/registering') ?>" method="post">
                    <?= csrf_field(); ?>

                    <div class="form-group row">
                        <label for="name" class="col-4 col-form-label">姓名</label>
                        <div class="col-8">
                            <div class="input-group mb-1">
                                <input id="name" type="text" class="form-control <?= ($validation->hasError('name')) ? 'is-invalid' : ''; ?>" name="name" placeholder="姓名" value="<?= old('name'); ?>" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('name'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="empID" class="col-4 col-form-label">工号</label>
                        <div class="col-8">
                            <div class="input-group mb-1">
                                <input id="empID" type="text" class="form-control <?= ($validation->hasError('empID')) ? 'is-invalid' : ''; ?>" name="empID" placeholder="工号" value="<?= old('empID'); ?>" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-id-card"></span>
                                    </div>
                                </div>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('empID'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="input-group mb-3">
                        <input type="text" class="form-control <?= ($validation->hasError('roomNum')) ? 'is-invalid' : ''; ?>" name="roomNum" placeholder="房间号" value="<?= old('roomNum'); ?>" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-bed"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback">
                            <?= $validation->getError('roomNum'); ?>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control <?= ($validation->hasError('phoneNum')) ? 'is-invalid' : ''; ?>" name="phoneNum" placeholder="电话号" value="<?= old('phoneNum'); ?>" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-phone"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback">
                            <?= $validation->getError('phoneNum'); ?>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <select name="region" class="form-control <?= ($validation->hasError('region')) ? 'is-invalid' : ''; ?>">
                            <option value="BQ" <?= old('region') == 'BQ' ? 'selected' : ''; ?>>北区</option>
                            <option value="NQ" <?= old('region') == 'NQ' ? 'selected' : ''; ?>>南区</option>
                        </select>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-map-signs"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback">
                            <?= $validation->getError('region'); ?>
                        </div>
                    </div> -->
                    <div class="form-group row">
                        <label for="password" class="col-4 col-form-label">密码</label>
                        <div class="col-8">
                            <div class="input-group mb-1">
                                <input id="password" type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" name="password" placeholder="密码" value="<?= old('password'); ?>" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('password'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="passConfirm" class="col-4 col-form-label">重复密码</label>
                        <div class="col-8">
                            <div class="input-group mb-1">
                                <input id="passConfirm" type="password" class="form-control <?= ($validation->hasError('passConfirm')) ? 'is-invalid' : ''; ?>" name="passConfirm" placeholder="重复密码" value="<?= old('passConfirm'); ?>" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('passConfirm'); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">注册</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <a href="<?= base_url('/login') ?>" class="text-center">已经拥有账号</a>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->
    <footer class="footer d-print-none">
        <!-- Default to the left -->
        <strong>版权所有：印尼青山莫罗瓦利园区电气部信息科 &copy; GWP 2021</strong> Copyright Indonesia Tsingshan. All rights reserved.
    </footer>
</body>
<?= $this->endSection() ?>