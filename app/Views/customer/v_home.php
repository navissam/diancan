<?= $this->extend('customer/template') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><?= $customer['name'] ?>， 欢迎光临
                        <? print_r($_COOKIE); ?>
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
                <div class="col-lg-6">
                    <?php if (!empty(session()->getFlashdata('success'))) : ?>
                        <!-- <div class="row">
                            <div class="col-lg-6"> -->
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- </div>
                        </div> -->
                    <?php endif ?>
                    <?php if ($customer['password'] == null || password_verify('123456', $customer['password'])) : ?>
                        <!-- <div class="col-lg-6"> -->
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i> 提醒! Peringatan!</h5>
                            <p class="m-0">您的密码还是默认密码，请及时更新密码</p>
                            <p class="m-0">Password yang anda gunakan adalah password bawaan, segera perbaharui password</p>
                        </div>
                        <!-- </div> -->
                    <?php endif; ?>
                    <div class="alert alert-info">
                        <h6><i class="icon fas fa-info"></i> 点餐时间
                            Waktu Pemesanan <span class="font-weight-bold"> <?= $beginTime . '-' . $endTime; ?></span></h6>
                    </div>
                    <div class="card card-info">
                        <div class="card-header">
                            <h5 class="card-title m-0">公告 Pengumuman</h5>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if ($announcement != null && $announcement['status'] == 1) : ?>
                                <?= $announcement['content']; ?>
                            <?php else : ?>
                                <p class="card-text my-0">暂时无公告</p>
                                <p class="card-text my-0">Sementara tidak ada pengumuman</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-6">
                            <a href="<?= base_url('/menu') ?>" class="small-box-footer">
                                <div class="small-box bg-primary py-4">
                                    <div class="inner">
                                        <span class="h3">看菜谱</span><br>
                                        <span>Lihat Menu</span>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-utensils"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="<?= base_url('/orders') ?>" class="small-box-footer">
                                <div class="small-box bg-success py-4">
                                    <div class="inner">
                                        <span class="h3">我的订单</span><br>
                                        <span>Pesananku</span>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="<?= base_url('/account/edit'); ?>" class="small-box-footer">
                                <div class="small-box bg-indigo py-4">
                                    <div class="inner">
                                        <span class="h6">编辑个人资料</span><br>
                                        <span>Edit Data Pribadi</span>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-edit"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="<?= base_url('/account/changepass') ?>" class="small-box-footer">
                                <div class="small-box bg-lightblue py-4">
                                    <div class="inner">
                                        <span class="h4">更改密码</span><br>
                                        <span>Ubah Password</span>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-key"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<?= $this->endSection() ?>