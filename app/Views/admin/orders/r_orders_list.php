<?= $this->extend('templates/index2') ?>

<?= $this->section('content') ?>
<div class="content-wrapper mt-0 ">
    <section class="invoice report rows-print-as-pages">
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
                    订单 Pesanan
                    <?php $arr = explode('-', $date);
                    echo '（' . $arr[0] . '年' . $arr[1] . '月' . $arr[2] . '日）'  ?>
                    <?= $region == 'BQ' ? '北区 Utara' : '南区 Selatan'; ?>
                </h3>
            </div>
        </div>

        <?php
        $rownum = 0;
        foreach ($orders as $order) :
        ?>
            <div class="row mb-5" <?= (++$rownum % 4 == 0) ? 'style="page-break-after: always;"' : ''; ?>>
                <div class="col-6 table-responsive border">
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <td>
                                    序号 No. Serial
                                </td>
                                <td>
                                    <?= $order['serialNum']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    订单编号 Kode Pesanan
                                </td>
                                <td>
                                    <?= $order['ordID']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    消费者 Pelanggan
                                </td>
                                <td>
                                    <?= $order['name'] . '(' . $order['empID'] . ')'; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    房间号 No Kamar
                                </td>
                                <td>
                                    <?= $order['roomNum'] . '(' . ($order['region'] == 'BQ' ? '北区 Utara' : '南区 Selatan') . ')'; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    电话号 No Telp
                                </td>
                                <td>
                                    <?= $order['phoneNum']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    是否外送 Antar Pesanan
                                </td>
                                <td>
                                    <?= $order['deliverySta'] == 0 ? '<span class="text-info">不送 Tidak Antar</span>' : '<span class="text-primary">外送 Antar</span>'; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    付款状态 Pembayaran
                                </td>
                                <td>
                                    <?= $order['paymentSta'] == 0 ? '<span class="text-danger">未付款 Belum</span> ' : '<span class="text-success">已付款 Sudah'; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
                <div class="col-6 table-responsive border">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>编号</th>
                                <th>菜名</th>
                                <th>份数</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $num = 0; ?>
                            <?php foreach ($details as $detail) : ?>
                                <?php if ($detail['ordID'] == $order['ordID']) : ?>
                                    <tr>
                                        <td><?= ++$num; ?></td>
                                        <td>
                                            <?= $detail['foodID']; ?>
                                        </td>
                                        <td>
                                            <?= $detail['foodName']; ?>
                                        </td>
                                        <td>
                                            <?= $detail['qty']; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
        <?php endforeach; ?>

        <div class="absolute-bottom">时间 Waktu : <?= date('Y/m/d H:i:s'); ?></div>
    </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    // window.onload = function() {
    //     window.print();
    // }
</script>
<?= $this->endSection() ?>