<?= $this->extend('customer/template') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">编辑资料 Edit Data Pribadi</h1>
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
                        <form action="<?= base_url('/account/update') ?>" method="POST">
                            <?= csrf_field(); ?>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="row form-group">
                                            <label for="roomNum" class="col-sm-4 col-form-label">房间号 No. Kamar</label>
                                            <div class="col-sm-8 input-group">
                                                <input id="roomNum" type="text" class="form-control <?= ($validation->hasError('roomNum')) ? 'is-invalid' : ''; ?>" name="roomNum" placeholder="房间号" value="<?= old('roomNum') ? old('roomNum') : $row['roomNum']; ?>" required>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('roomNum'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <label for="region" class="col-sm-4 col-form-label">地区 Regional</label>
                                            <div class="col-sm-8 input-group">
                                                <select id="region" name="region" class="form-control <?= ($validation->hasError('region')) ? 'is-invalid' : ''; ?>">
                                                    <option value="BQ" <?= (old('region') ? old('region') : $row['region']) == 'BQ' ? 'selected' : ''; ?>>北区 Utara</option>
                                                    <option value="NQ" <?= (old('region') ? old('region') : $row['region']) == 'NQ' ? 'selected' : ''; ?>>南区 Selatan</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('region'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <label for="roomNum" class="col-sm-4 col-form-label">电话号 No. Telp</label>
                                            <div class="col-sm-8 input-group">
                                                <input type="text" class="form-control <?= ($validation->hasError('phoneNum')) ? 'is-invalid' : ''; ?>" name="phoneNum" placeholder="电话号" value="<?= old('phoneNum') ? old('phoneNum') : $row['phoneNum']; ?>" required>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('phoneNum'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <div class="float-right">
                                    <a href="<?= base_url('/') ?>" class="btn btn-secondary ">取消 Batal</a>
                                    <button type="submit" class="btn btn-success">
                                        更改 Ubah
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