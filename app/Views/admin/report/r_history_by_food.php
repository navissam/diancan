<?= $this->extend('admin/report/template') ?>

<?= $this->section('content') ?>
<!-- title row -->
<div class="row mb-5">
    <div class="col-12 ">
        <h2 class="page-header">
            <img src="<?= base_url(); ?>/img/favicon-32x32.png" alt="点餐系统" class="brand-image elevation-3 img-circle" style="opacity: .8">
            <span class="brand-text font-weight-light">点餐系统</span>
            <small class="float-right">日期: <?= date('Y/m/d'); ?></small>
        </h2>
    </div>
    <!-- /.col -->
</div>
<!-- info row -->
<div class="row invoice-info mb-2 ">
    <div class="col-12 ">
        <h3>
            订单历史 （<?= $date; ?>）
            <?php if ($region != 'all') : ?>
                <?= $region == 'BQ' ? '北区' : '南区'; ?>
            <?php endif; ?>
        </h3>
    </div>
</div>
<!-- /.row -->

<!-- Table row -->
<div class="row">
    <div class="col-12 table-responsive">
        <table class="table table-striped">
            <thead>
                <th>#</th>
                <th>菜肴编号</th>
                <th>菜肴名称</th>
                <th>价格</th>
                <th>数量</th>
            </thead>
            <tbody>
                <?php
                $num = 0;
                $total = 0;
                ?>
                <?php foreach ($rows as $row) : ?>
                    <tr>
                        <td><?= ++$num; ?></td>
                        <td><?= $row['foodID']; ?></td>
                        <td><?= $row['foodName']; ?></td>
                        <td><?= $row['price']; ?></td>
                        <td><?= $row['sum_qty']; ?></td>
                        <?php $total += $row['sum_qty']; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- /.col -->
</div>
<div class="row">
    <div class="col-6 table-responsive">
        <table class="table table-striped ">
            <tbody>
                <tr>
                    <th>菜肴数量</th>
                    <td><span class="text-primary font-weight-bold"><?= $num; ?></span></td>
                </tr>
                <tr>
                    <th>总份数</th>
                    <td><span class="text-primary font-weight-bold"><?= $total; ?></span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>

</script>
<?= $this->endSection() ?>