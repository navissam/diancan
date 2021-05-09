<?= $this->extend('templates/index') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>日度销售 Penjualan Harian</h1>
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
                        <input type="hidden" name="report" value="summary">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="date">日期 Hari</label>
                                <input type="date" max="<?= date('Y-m-d') ?>" name="day" class="form-control" id="day" value="<?= date('Y-m-d') ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="region">地区 Regional</label>
                                <select name="region" class="form-control" id="region">
                                    <option value="all">全区 Semua</option>
                                    <option value="BQ">北区 Utara</option>
                                    <option value="NQ">南区 Selatan</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button id="print" class="btn btn-outline-primary float-right">
                                <i class="fa fa-print" aria-hidden="true"></i>
                                查询 Cetak</button>
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
<script>
    $(document).ready(function() {
        $('#print').click(function() {
            let day = $('input[name="day"]').val();
            let region = $('select[name="region"]').val();

            window.location.href = "<?= base_url(); ?>/admin/report/income/day/" + day + "/" + region;
        });
    });
</script>
<?= $this->endSection() ?>