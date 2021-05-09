<?= $this->extend('templates/index') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>欢迎，<?= session()->get('name'); ?></h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <div class="row">
                    <?php if (in_array(session()->get('roleID'), ['super', 'admin', 'cashier'])) : ?>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <a href="<?= base_url('/admin/payment') ?>">
                                <div class="info-box">
                                    <span class="info-box-icon bg-success"><i class="fa fa-chart-pie"></i></span>

                                    <div class="info-box-content">
                                        <span class="h4 text-success">付款 Pembayaran</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if (in_array(session()->get('roleID'), ['super', 'admin', 'chef'])) : ?>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <a href="<?= base_url('/admin/orders/detail') ?>">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info"><i class="fa fa-file-invoice"></i></span>

                                    <div class="info-box-content">
                                        <span class="h4 text-info">订单明细 Rincian Pesanan</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if (in_array(session()->get('roleID'), ['super', 'admin'])) : ?>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <a href="<?= base_url('/admin/variable/changetimelimit'); ?>">
                                <div class="info-box">
                                    <span class="info-box-icon bg-maroon"><i class="far fa-clock"></i></span>

                                    <div class="info-box-content">
                                        <span class="h6 text-maroon">点餐时间设置 Pengaturan Waktu Pesanan</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <a href="<?= base_url('/admin/variable/changedeliverycost'); ?>">
                                <div class="info-box">
                                    <span class="info-box-icon bg-purple"><i class="fas fa-hand-holding-usd"></i></span>

                                    <div class="info-box-content">
                                        <span class="h6 text-purple">外送费设置 Pengaturan Biaya Pengantaran</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <a href="<?= base_url('/admin/variable/announcement'); ?>">
                                <div class="info-box">
                                    <span class="info-box-icon bg-primary"><i class="fas fa-bullhorn"></i></span>

                                    <div class="info-box-content">
                                        <span class="h6 text-primary">公告设置 Pengaturan Pengumuman</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if (in_array(session()->get('roleID'), ['super', 'admin'])) : ?>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <a href="<?= base_url('/admin/customer'); ?>">
                                <div class="info-box">
                                    <span class="info-box-icon bg-olive"><i class="fas fa-user-friends"></i></span>

                                    <div class="info-box-content">
                                        <span class="h4 text-olive">消费者管理 Customer</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if (in_array(session()->get('roleID'), ['super'])) : ?>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <a href="<?= base_url('/admin/user'); ?>">
                                <div class="info-box">
                                    <span class="info-box-icon bg-navy"><i class="fas fa-user-friends"></i></span>

                                    <div class="info-box-content">
                                        <span class="h4 text-navy">账号管理 Akun Admin</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-4 col-12">
                <div class="row">
                    <?php if (in_array(session()->get('roleID'), ['super', 'admin', 'chef'])) : ?>
                        <div class="col-12">
                            <div class="card card-primary" style="transition: all 0.15s ease 0s; height: inherit; width: inherit;">
                                <div class="card-header">
                                    <h3 class="card-title">今日订单 Pesanan Hari Ini</h3>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <canvas id="orders" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>


    </section>
    <!-- /.content -->
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    <?php if (in_array(session()->get('roleID'), ['super', 'admin', 'chef'])) : ?>
        <?php
        $bq = 0;
        $nq = 0;
        if (count($chart_orders) == 1) {
            if ($chart_orders[0]['region'] == 'BQ') {
                $bq = $chart_orders[0]['count'];
            } else {
                $nq = $chart_orders[0]['count'];
            }
        } elseif (count($chart_orders) == 2) {
            $bq = $chart_orders[0]['count'];
            $nq = $chart_orders[1]['count'];
        }
        ?>
        var orders = $('#orders').get(0).getContext('2d')
        var ordersData = {
            labels: [
                '北区 Utara',
                '南区 Selatan',
            ],
            datasets: [{
                data: [<?= $bq; ?>, <?= $nq; ?>],
                backgroundColor: ['#00c0ef', '#3c8dbc']
            }]
        }
        var ordersOpt = {
            maintainAspectRatio: false,
            responsive: true,
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        var donutChart = new Chart(orders, {
            type: 'doughnut',
            data: ordersData,
            options: ordersOpt
        })
    <?php endif; ?>
</script>
<?= $this->endSection() ?>