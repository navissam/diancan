<?= $this->extend('templates/index') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <section class="invoice invoice-order px-5">
        <!-- title row -->
        <div class="row mb-4">
            <div class="col-12 ">
                <h2 class="page-header">
                    <img src="<?= base_url(); ?>/img/logo.png" alt="点餐系统" class="brand-image elevation-3 img-circle mb-2" width="50">
                    <span class="brand-text h1 font-weight-bold">点餐系统 - 订单</span>
                    <span class="h1 font-weight-bold float-right">编号：<?= $order['ordID']; ?></span>
                    <button class="btn btn-primary d-print-none float-right" onclick="window.print()">
                        <i class="fas fa-print"></i>
                        打印
                        Print
                    </button>
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <div class="row mb-3">
            <div class="col">
                <table class="table table-sm" style="font-size: 32px;">
                    <tr>
                        <td>序号 Serial</td>
                        <td><?= $order['serialNum']; ?></td>
                    </tr>
                    <tr>
                        <td>消费者 Pelanggan</td>
                        <td><?= $order['name']; ?> (<?= $order['empID']; ?>)</td>
                    </tr>
                    <tr>
                        <td>房间号 Nomor Kamar</td>
                        <td><?= $order['roomNum']; ?> (<?= ($order['region'] == 'BQ') ? '北区 Utara' : '南区 Selatan'; ?>)</td>
                    </tr>
                    <tr>
                        <td>电话号 No.Telp</td>
                        <td><?= $order['phoneNum']; ?></td>
                    </tr>
                    <tr>
                        <td>是否外送 Antar Pesanan</td>
                        <td><?= ($order['deliverySta'] == 0) ? '不外送 Tidak Antar' : '外送 Antar'; ?></td>
                    </tr>
                    <tr>
                        <td>付款状态 Pembayaran</td>
                        <td><?= ($order['paymentSta'] == 0) ? '未付款 Belum' : '已付款 Sudah'; ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <?php $total = 0; ?>
                <table class="table table-sm table-detail" style="font-size: 32px;">
                    <thead>
                        <tr>
                            <td class="font-weight-bold">#</td>
                            <td class="font-weight-bold">菜肴</td>
                            <td align="center">
                                <span class="font-weight-bold">份数 x 单价</span>
                            </td>
                            <td></td>
                            <td align="right">
                                <span class="font-weight-bold">金额</span>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $num = 0;
                        foreach ($details as $row) : ?>
                            <tr>
                                <td><?= ++$num; ?></td>
                                <td><?= $row['foodName']; ?></td>
                                <td align="center"><?= $row['qty'] . ' x ' . number_format($row['price']); ?></td>
                                <td align="center">=</td>
                                <td align="right"><?= number_format($row['qty'] * $row['price']); ?></td>
                                <?php $total += $row['qty'] * $row['price']; ?>
                            </tr>
                        <?php endforeach; ?>
                        <?php if ($order['deliverySta'] == 1) : ?>
                            <tr>
                                <td><?= ++$num; ?></td>
                                <td colspan="2">外送费</td>
                                <td align="center">=</td>
                                <td align="right"><?= number_format($order['deliveryCost']); ?></td>
                                <?php $total += $order['deliveryCost']; ?>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td colspan="3" class="text-right font-weight-bold">总金额 Total</td>
                            <td align="center">=</td>
                            <td class="text-right font-weight-bold">
                                <?= number_format($total); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="absolute-bottom h3">时间 Waktu : <?= date('Y/m/d H:i:s'); ?></div>
    </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>

<?= $this->endSection() ?>