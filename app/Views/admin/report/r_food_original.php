<?= $this->extend('templates/index2') ?>

<?= $this->section('content') ?>
<div class="content-wrapper mt-0">
    <section class="invoice report">
        <!-- title row -->
        <div class="row mb-4">
            <div class="col-12 ">
                <h2 class="page-header">
                    <img src="<?= base_url(); ?>/img/logo.png" alt="点餐系统" class="brand-image elevation-3 img-circle mb-2" width="50">
                    <span class="h1 font-weight-bold">点餐系统 - 菜单</span>
                    <button class="btn btn-primary d-print-none float-right" onclick="window.print()">
                        <i class="fas fa-print"></i>
                        打印
                        Print
                    </button>
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <th>#</th>
                        <th>编号 Kode</th>
                        <th colspan="2">菜名 Nama Masakan</th>
                        <th>单价 Harga</th>
                    </thead>
                    <tbody>
                        <?php $num = 0; ?>
                        <?php foreach ($rows as $row) : ?>
                            <tr>
                                <td><?= ++$num; ?></td>
                                <td><?= $row['foodID']; ?></td>
                                <td><?= $row['name']; ?></td>
                                <td><?= $row['nameIND']; ?></td>
                                <td><?= number_format($row['price']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <div class="absolute-bottom">时间 Waktu : <?= date('Y/m/d H:i:s'); ?></div>
    </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    window.onload = function() {
        window.print();
    }
</script>
<?= $this->endSection() ?>