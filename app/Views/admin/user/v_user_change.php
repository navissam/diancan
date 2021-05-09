<?= $this->extend('templates/index') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>更改密码 Ubah Password</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <?php if (!empty(session()->getFlashdata('error'))) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>
                                <?= session()->getFlashdata('error') ?>
                            </strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif ?>
                    <?php if (!empty(session()->getFlashdata('success'))) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>
                                <?= session()->getFlashdata('success') ?>
                            </strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card card-primary">
                        <div class="card-header"></div>
                        <form action="<?= base_url('/admin/account/updatepass') ?>" method="POST">
                            <?= csrf_field(); ?>
                            <div class="card-body">
                                <div class="form-group">
                                    <input name="currPass" type="password" class="form-control <?= ($validation->hasError('currPass')) ? 'is-invalid' : ''; ?>" placeholder="输入当前密码 Password saat ini" required>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('currPass'); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input name="newPass" type="password" class="form-control <?= ($validation->hasError('newPass')) ? 'is-invalid' : ''; ?>" placeholder="输入新密码 Password baru" required>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('newPass'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input name="passConfirm" type="password" class="form-control <?= ($validation->hasError('passConfirm')) ? 'is-invalid' : ''; ?>" placeholder="验证新密码 Ulangi password baru" required>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('passConfirm'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success float-right">
                                    更改 Ubah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
    </section>
    <!-- /.content -->
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>

</script>
<?= $this->endSection() ?>