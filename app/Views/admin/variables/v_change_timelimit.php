<?= $this->extend('templates/index') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>点餐时间 Waktu Pemesanan</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <?php if (!empty(session()->getFlashdata('success'))) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif ?>

                    <?php if (!empty(session()->getFlashdata('error'))) : ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <form action="<?= base_url('/admin/variable/updatetimelimit') ?>" method="POST">
                                <?= csrf_field(); ?>
                                <div class="form-group row">
                                    <label for="beginTime" class="col-sm-6 col-form-label">开始时间 Waktu Mulai</label>
                                    <div class="col-sm-6">
                                        <input id="beginTime" name="beginTime" type="time" value="<?= $beginTime; ?>" class="form-control form-control-lg" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="endTime" class="col-sm-6 col-form-label"> 结束时间 Waktu Berakhir</label>
                                    <div class="col-sm-6">
                                        <input id="endTime" name="endTime" type="time" value="<?= $endTime; ?>" class="form-control form-control-lg" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary float-right">更新 Perbarui</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>

<?= $this->endSection() ?>