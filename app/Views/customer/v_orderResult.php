<?= $this->extend('customer/template') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <button class="btn btn-secondary" onclick="window.history.back()">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        </button>
                        订单明细 Detail Pemesanan
                    </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-lg-6">
                    <?php if ($header['paymentSta'] == 0) : ?>
                        <div class="alert alert-warning">
                            <h5><i class="icon fas fa-exclamation-triangle"></i>请及时完成支付，谢谢！Segera melakukan pembayaran!</h5>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12 col-lg-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <p class="h1 text-center">
                                <?= $header['serialNum']; ?>
                            </p>
                            <button class="btn btn-primary float-right" onClick="window.location.reload();">
                                <i class="fas fa-sync    "></i>
                                刷新 Refresh</button>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>订单编号 Kode</th>
                                        <td><?= $ordID; ?></td>
                                    </tr>
                                    <tr>
                                        <th>消费者姓名 Nama</th>
                                        <td><?= $header['name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>工号 NIK</th>
                                        <td><?= $header['empID']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>房间号 No. Kamar</th>
                                        <td><?= $header['roomNum']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>电话号 No. Telp</th>
                                        <td><?= $header['phoneNum']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>订单日期 Waktu</th>
                                        <td><?= $header['created_at']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>是否外送 Pengantaran</th>
                                        <td><?= $header['deliverySta'] == 0 ? '<span class="text-info">不外送 Tidak Antar</span>' : '<span class="text-primary">外送 Antar</span>'; ?></td>
                                    </tr>
                                    <tr>
                                        <th>付款状态 Pembayaran</th>
                                        <td><?= $header['paymentSta'] == 0 ? '<span class="text-danger">未付款 Belum</span>' : '<span class="text-success">已付款 Sudah</span>'; ?></td>
                                    </tr>
                                    <tr>
                                        <th>地区 Regional</th>
                                        <td><?= $header['region'] == 'BQ' ? '北区 Utara' : '南区 Selatan'; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <thead class="bg-secondary">
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="table">
                                    <?php $total = 0; ?>
                                    <?php foreach ($details as $row) : ?>
                                        <tr>
                                            <td><?= $row['foodName']; ?></td>
                                            <td><?= $row['qty'] . ' x ' . number_format($row['price']); ?></td>
                                            <td align="right" class="text-success"><?= number_format($row['price'] * $row['qty']); ?></td>
                                        </tr>
                                        <?php $total += $row['price'] * $row['qty']; ?>
                                    <?php endforeach; ?>
                                    <?php if ($header['deliverySta'] == 1) : ?>
                                        <tr>
                                            <td colspan="2">
                                                外送费 Biaya Antar
                                            </td>
                                            <td align="right" class="text-success">
                                                <?= number_format($header['deliveryCost']); ?>
                                            </td>
                                        </tr>
                                        <?php $total += $header['deliveryCost']; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer text-right">
                            <strong>
                                总价 Total = Rp <?= number_format($total); ?>
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>


<?= $this->endSection() ?>