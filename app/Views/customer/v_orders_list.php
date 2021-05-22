<?= $this->extend('customer/template') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col mb-2">
                    <h1 class="m-0 text-dark">我今日订单
                        <a href="<?= base_url('/orders/history') ?>" class="btn btn-success btn-sm float-right">订单历史</a>
                    </h1>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
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
                <?php if (count($orders) == 0) : ?>
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            没有订单！
                        </div>
                    </div>
                <?php endif; ?>
                <?php foreach ($orders as $order) : ?>
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <div class="card  <?= ($order['paymentSta'] == 0) ? 'card-secondary' : 'card-primary' ?> collapsed-card">
                            <div class="card-header" data-card-widget="collapse">
                                <h3 class="card-title">
                                    订单号 Kode :
                                </h3>
                                <div class="card-tools">
                                    <span class="font-weight-bold text-lg"><?= $order['ordID']; ?></span>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" style="display: none;">
                                <p class="h1 text-center">
                                    <?= $order['serialNum']; ?>
                                </p>
                                <a href="<?= base_url('/menu/orderresult') . '/' . base64_encode($order['ordID']); ?>" class="btn btn-primary float-right mb-3">订单明细 Rincian</a>
                                <table class="table">
                                    <tr>
                                        <th>是否外送 Pengantaran</th>
                                        <td><?= ($order['deliverySta'] == 0) ? '不外送 Tidak Antar' : '外送 Antar'; ?></td>
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
                                        <?php $total = 0; ?>
                                        <?php foreach ($details as $detail) : ?>
                                            <?php if ($detail['ordID'] == $order['ordID']) : ?>
                                                <?php $total += $detail['qty'] * $detail['price']; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?php if ($order['deliverySta'] == 1) : ?>
                                            <?php $total += $order['deliveryCost']; ?>
                                        <?php endif; ?>
                                    </tr>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer float-right">
                                <div class="row">
                                    <div class="col">
                                        <div class="float-right">
                                            总价 =
                                            <strong class="text-lg text-primary">
                                                <?= number_format($total); ?>
                                            </strong>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <?php
                                        $et = strtotime($endTime);
                                        $now = time();
                                        ?>
                                        <?php if ($order['paymentSta'] == 0 && $now < $et) : ?>
                                            <div class="float-right">
                                                <form action="<?= base_url('/orders/cancel'); ?>" method="POST" class="d-inline">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="ordID" value="<?= $order['ordID']; ?>">
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('确定要撤销这个订单？ Yakin ingin membatalkan pemesanan?');">
                                                        撤销订单 Batal
                                                    </button>
                                                </form>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

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