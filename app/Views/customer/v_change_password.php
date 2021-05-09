<?= $this->extend('customer/template') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">更改密码 Ganti Password</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
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
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-primary card-outline">
                        <form action="<?= base_url('/account/updatepass') ?>" method="POST">
                            <?= csrf_field(); ?>
                            <div class="card-body">
                                <div class="row form-group">
                                    <label for="currPass" class="col-sm-4 col-form-label">当前密码 Password Saat Ini</label>
                                    <div class="col-sm-8 input-group">
                                        <input id="currPass" name="currPass" type="password" class="form-control <?= ($validation->hasError('currPass')) ? 'is-invalid' : ''; ?>" placeholder="输入当前密码" required>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('currPass'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="newPass" class="col-sm-4 col-form-label">新密码 Password Baru</label>
                                    <div class="col-sm-8 input-group">
                                        <input id="newPass" name="newPass" type="password" class="form-control <?= ($validation->hasError('newPass')) ? 'is-invalid' : ''; ?>" placeholder="输入新密码" required>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('newPass'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="passConfirm" class="col-sm-4 col-form-label">重复新密码 Ulangi Password Baru</label>
                                    <div class="col-sm-8 input-group">
                                        <input id="passConfirm" name="passConfirm" type="password" class="form-control <?= ($validation->hasError('passConfirm')) ? 'is-invalid' : ''; ?>" placeholder="重复新密码" required>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('passConfirm'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="float-right">
                                    <a href="<?= base_url('/') ?>" class="btn btn-secondary ">取消 Batal</a>
                                    <button type="submit" class="btn btn-success">
                                        更改 Ganti
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<?= $this->endSection() ?>