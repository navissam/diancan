<?= $this->extend('templates/index') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>消费者管理 Manajemen Pelanggan</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="alert alert-info alert-dismissible fade show" role="alert">

                        在‘姓名’或‘工号’有包含 <strong><?= $key; ?></strong> 的查询结果<br>
                        Hasil pencarian pada nama atau NIK yang mengandung <strong><?= $key; ?></strong>


                    </div>
                </div>
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <a href="<?= base_url('/admin/customer') ?>" class="btn btn-secondary">返回 Kembali</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>姓名 Nama</th>
                                        <th>工号 NIK</th>
                                        <th>房间号 No. Kamar</th>
                                        <th>电话号 No. Telp</th>
                                        <th>地区 Regional</th>
                                        <th>状态 Status</th>
                                        <th>注册时间 Waktu Registrasi</th>
                                        <th>更新时间 Waktu Pembaruan</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($rows as $row) : ?>
                                        <tr>
                                            <td><?= $row['name']; ?></td>
                                            <td><?= $row['empID']; ?>
                                            </td>
                                            <td><?= $row['roomNum']; ?></td>
                                            <td><?= $row['phoneNum']; ?></td>
                                            <td><?= $row['region'] == 'BQ' ? '北区' : '南区'; ?></td>
                                            <td><?= $row['status'] == 0 ? '<span class="text-success">正常</span>' : '<span class="text-danger">已拉黑</span>'; ?></td>
                                            <td><?= $row['created_at']; ?></td>
                                            <td><?= $row['updated_at']; ?></td>
                                            <td>
                                                <?php if ($row['status'] == 0) : ?>
                                                    <form action="<?= base_url('/admin/customer/block'); ?>" method="POST" class="d-inline">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="cusID" value="<?= $row['cusID']; ?>">
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('你确定要拉黑？');">
                                                            <i class="fas fa-trash"></i>
                                                            拉黑 Blockir
                                                        </button>
                                                    </form>
                                                <?php else : ?>
                                                    <form action="<?= base_url('/admin/customer/restore'); ?>" method="POST" class="d-inline">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="cusID" value="<?= $row['cusID']; ?>">
                                                        <button type="submit" class="btn btn-success" onclick="return confirm('你确定要复原？');">
                                                            <i class="fas fa-sync"></i>
                                                            复原 Pulihkan
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                                <form action="<?= base_url('/admin/customer/resetpass'); ?>" method="POST" class="d-inline">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="cusID" value="<?= $row['cusID']; ?>">
                                                    <button type="submit" class="btn btn-warning" onclick="return confirm('你确定要重置密码？');">
                                                        <i class="fas fa-sync"></i>
                                                        重置密码 Reset Password
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<!-- DataTables -->
<script src="<?= base_url(); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- page script -->
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false
        });
    });
</script>
<?= $this->endSection() ?>