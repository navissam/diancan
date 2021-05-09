<?= $this->extend('templates/index') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $title; ?></h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-6">
                    <a href="<?= base_url('/admin/payment') ?>" class="btn btn-secondary">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        撤回 Kembali</a>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
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

                <?php
                if ($order == null) : ?>
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            没有订单！ Tidak ada pesanan!
                        </div>
                    </div>
                <?php else : ?>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    订单号 No Pesanan :
                                </h3>
                                <div class="card-tools">
                                    <span class="text-primary text-lg"><?= $order['ordID']; ?></span>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <th>序号 No Serial</th>
                                        <td><?= $order['serialNum']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>姓名 Nama</th>
                                        <td><?= $order['name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>工号 NIK</th>
                                        <td><?= $order['empID']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>房间号 Nomor Kamar</th>
                                        <td><?= $order['roomNum']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>电话号 No.Telp</th>
                                        <td><?= $order['phoneNum']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>是否外送 Antar Pesanan</th>
                                        <td>
                                            <?php if ($order['deliverySta'] == 0) : ?>
                                                <span class="text-info">不外送 Tidak Antar</span>
                                            <?php else : ?>
                                                <span class="text-primary">外送 Antar</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>付款状态 Pembayaran</th>
                                        <td>
                                            <?php if ($order['paymentSta'] == 0) : ?>
                                                <span class="text-danger">未付款 Belum</span>
                                            <?php else : ?>
                                                <span class="text-success">已付款 Sudah</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>地区 Regional</th>
                                        <td><?= ($order['region'] == 'BQ') ? '北区 Utara' : '南区 Selatan'; ?></td>
                                    </tr>
                                </table>
                                <div class="card card-info collapsed-card">
                                    <div class="card-header" data-card-widget="collapse">
                                        <h3 class="card-title">
                                            明细 Detail
                                        </h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <!-- /.card-tools -->
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body" style="display: none;">
                                        <?php $total = 0; ?>
                                        <table class="table">
                                            <tbody>
                                                <?php foreach ($detail as $row) : ?>
                                                    <tr>
                                                        <td><?= $row['foodName']; ?></td>
                                                        <td><?= $row['qty'] . ' x ' . number_format($row['price']); ?></td>
                                                        <td align="right"><?= number_format($row['qty'] * $row['price']); ?></td>
                                                        <?php $total += $row['qty'] * $row['price']; ?>
                                                    </tr>
                                                <?php endforeach ?>
                                                <?php if ($order['deliverySta'] == 1) : ?>
                                                    <tr>
                                                        <td colspan="2">外送费</td>
                                                        <td align="right"><?= number_format($order['deliveryCost']); ?></td>
                                                        <?php $total += $order['deliveryCost']; ?>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer float-right">
                                <div class="row">
                                    <div class="col">
                                        <div class="float-right">
                                            总价 Total =
                                            <strong class="text-lg text-primary">
                                                <?= number_format($total); ?>
                                            </strong>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="float-right">
                                            <form action="<?= base_url('/admin/payment/process'); ?>" method="POST">
                                                <?= csrf_field(); ?>
                                                <input type="hidden" name="ordID" value="<?= $order['ordID']; ?>">
                                                <?php if ($order['paymentSta'] == 0) : ?>
                                                    <button type="submit" class="btn btn-success" onclick="return confirm('确定要支付？ Yakin untuk dilakukan pembayaran?');">
                                                        <i class="fa fa-money" aria-hidden="true"></i>
                                                        支付 Bayar</button>
                                                <?php else : ?>
                                                    <a href="<?= base_url('/admin/payment/print/') . '/' . base64_encode($order['ordID']); ?>" class="btn btn-primary">
                                                        <i class="fas fa-print    "></i>
                                                        打印 Print
                                                    </a>
                                                <?php endif; ?>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

</div>
<!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>

<?= $this->endSection() ?>