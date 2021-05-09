<?= $this->extend('templates/index2') ?>

<?= $this->section('content') ?>
<div class="content-wrapper mt-0">
    <section class="invoice report">
        <!-- title row -->
        <div class="row mb-4">
            <div class="col-12 ">
                <h2 class="page-header">
                    <img src="<?= base_url(); ?>/img/logo.png" alt="点餐系统" class="brand-image elevation-3 img-circle mb-2" width="50">
                    <span class="h1 font-weight-bold">点餐系统</span>
                    <button class="btn btn-primary d-print-none float-right" onclick="window.print()">
                        <i class="fas fa-print"></i>
                        打印
                        Print
                    </button>
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <div class="row invoice-info mb-2 ">
            <div class="col-12 ">
                <h3>
                    菜品销售量统计表 Laporan Penjualan
                    <?php $arr = explode('-', $day);
                    echo '（' . $arr[0] . '年' . $arr[1] . '月' . $arr[2] . '日）'  ?>
                    <?php if ($region != 'all') : ?>
                        <?= $region == 'BQ' ? '北区 Utara' : '南区 Selatan'; ?>
                    <?php endif; ?>
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                        <th>#</th>
                        <th>菜肴编号</th>
                        <th>菜肴名称</th>
                        <th>单价</th>
                        <th>售量</th>
                        <th>金额</th>
                    </thead>
                    <tbody>
                        <?php
                        $num = 0;
                        $total = 0;
                        $product = 0;
                        $qty = 0;
                        $dCostSum = 0;
                        ?>
                        <?php foreach ($rows as $row) : ?>
                            <tr>
                                <td><?= ++$num; ?></td>
                                <td><?= $row['foodID']; ?></td>
                                <td><?= $row['foodName']; ?></td>
                                <td><?= number_format($row['price']); ?></td>
                                <td><?= $row['sum_qty']; ?></td>
                                <td><?= number_format($row['product']); ?></td>
                                <?php $total += $row['sum_qty'];
                                $product += $row['product'];
                                $qty += $row['sum_qty'];
                                ?>
                            </tr>
                        <?php endforeach; ?>
                        <?php foreach ($d_rows as $row) : ?>
                            <tr>
                                <td><?= ++$num; ?></td>
                                <td colspan="2">送餐费 Biaya Pengantaran</td>
                                <td><?= number_format($row['dCost']); ?></td>
                                <td><?= $row['dCostNum']; ?></td>
                                <td><?= number_format($row['dCostSum']); ?></td>
                                <?php $dCostSum += $row['dCostSum'];
                                ?>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <div class="row">
            <div class="col-sm-6 col-lg-4 table-responsive">
                <table class="table table-striped ">
                    <tbody>
                        <tr class="">
                            <th>送餐费总金额</th>
                            <td><span class="text-primary font-weight-bold float-right"><?= 'Rp ' . number_format($dCostSum); ?></span></td>
                        </tr>
                        <tr class="">
                            <th>菜品总销量</th>
                            <td><span class="text-primary font-weight-bold float-right"><?= $qty . '份'; ?></span></td>
                        </tr>
                        <tr class="">
                            <th>菜品销售总金额</th>
                            <td><span class="text-primary font-weight-bold float-right"><?= 'Rp ' . number_format($product); ?></span></td>
                        </tr>
                        <tr class="">
                            <th>营业额</th>
                            <td><span class="text-primary font-weight-bold float-right"><?= 'Rp ' . number_format($product + $dCostSum); ?></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
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