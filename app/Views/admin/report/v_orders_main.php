<?= $this->extend('templates/index') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>订单历史</h1>
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
                            <strong>
                                <?= session()->getFlashdata('success') ?>
                            </strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif ?>

                    <?php if (!empty(session()->getFlashdata('error'))) : ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>
                                <?= session()->getFlashdata('error') ?>
                            </strong>
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
                        <form action="<?= base_url('/admin/report/route') ?>" method="POST">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="report" value="order">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="by">报表类型</label>
                                    <select name="by" class="form-control" id="by">
                                        <option value="orders">订单明细</option>
                                        <option value="food">菜肴明细</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="region">地区</label>
                                    <select name="region" class="form-control" id="region">
                                        <option value="all">全区</option>
                                        <option value="BQ">北区</option>
                                        <option value="NQ">南区</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="date">日期</label>
                                    <input type="date" name="date" class="form-control" id="date">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary float-right">查询</button>
                            </div>
                        </form>
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
<script>
    $('#date').attr('max', '<?= date('Y-m-d') ?>');
    $('#date').attr('value', '<?= date('Y-m-d') ?>');
</script>
<?= $this->endSection() ?>