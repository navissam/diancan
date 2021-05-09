<?= $this->extend('customer/template') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col mb-2">
                    <h1 class="m-0 text-dark">
                        <button class="btn btn-secondary" onclick="window.history.back()">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        </button>订单历史
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
                <?php if (count($orders) == 0) : ?>
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            没有订单历史！
                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-lg-6">
                    <div class="timeline">
                        <?php foreach ($dates as $date) : ?>
                            <!-- timeline time label -->
                            <div class="time-label">
                                <span class="bg-green">
                                    <?= $date['date']; ?>
                                </span>
                            </div>
                            <!-- /.timeline-label -->
                            <?php foreach ($orders as $order) : ?>
                                <?php if ($date['date'] == date_format(date_create($order['created_at']), 'Y-m-d')) : ?>
                                    <!-- timeline item -->
                                    <div>
                                        <?php if ($order['deliverySta'] == 1) : ?>
                                            <i class="fas fa-truck bg-red"></i>
                                        <?php else : ?>
                                            <i class="fas fa-running bg-yellow"></i>
                                        <?php endif; ?>
                                        <div class="timeline-item">
                                            <span class="time">
                                                <i class="fas fa-clock"></i>
                                                <?= date_format(date_create($order['created_at']), 'H:i:s'); ?>
                                            </span>
                                            <h3 class="timeline-header">
                                                <span class="text-primary font-weight-bold">
                                                    <a href="<?= base_url('/menu/orderresult/' . base64_encode($order['ordID'])); ?>">
                                                        <?= $order['ordID']; ?>
                                                    </a>
                                                </span>
                                            </h3>
                                            <div class="timeline-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <?php $total = 0; ?>
                                                        <table class="table table-striped table-sm">
                                                            <tbody>
                                                                <?php foreach ($details as $detail) : ?>
                                                                    <?php if ($detail['ordID'] == $order['ordID']) : ?>
                                                                        <tr>
                                                                            <td><?= $detail['foodName']; ?></td>
                                                                            <td><?= $detail['qty'] . ' x '; ?></td>
                                                                            <?php $total += $detail['qty'] * $detail['price']; ?>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                        <div>
                            <i class="fas fa-clock bg-gray"></i>
                        </div>
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
<script>
    $(document).ready(function() {

    });
</script>
<?= $this->endSection() ?>