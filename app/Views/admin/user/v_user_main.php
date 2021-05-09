<?= $this->extend('templates/index') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>账号管理 Manajemen Pengguna</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <?php if (!empty(session()->getFlashdata('success'))) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>
                                <?= session()->getFlashdata('success') ?>
                            </strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif ?>

                    <?php if (!empty(session()->getFlashdata('error'))) : ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>
                                <?= session()->getFlashdata('error') ?>
                            </strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <a class="btn btn-success" href="<?= base_url('/admin/user/add'); ?>">
                                <i class="fas fa-plus" aria-hidden="true"></i>
                                添加 Tambah
                            </a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>账号编码 Kode</th>
                                        <th>账号名称 Nama</th>
                                        <th>角色 Peran</th>
                                        <th>状态 Status</th>
                                        <th>创建时间 Waktu Pembuatan</th>
                                        <th>更新时间 Waktu Pembaruan</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rows as $row) : ?>
                                        <tr>
                                            <td><?= $row['userID']; ?></td>
                                            <td><?= $row['name']; ?>
                                            </td>
                                            <td><?= $row['roleID']; ?></td>
                                            <td><?= $row['status'] == 0 ? '<span class="text-success">正常</span>' : '<span class="text-danger">已拉黑</span>'; ?></td>
                                            <td><?= $row['created_at']; ?></td>
                                            <td><?= $row['updated_at']; ?></td>
                                            <td>
                                                <a href="<?= base_url('/admin/user/edit/' . base64_encode($row['userID'])); ?>" class="btn btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                    编辑 Edit
                                                </a>
                                                <?php if ($row['status'] == 0) : ?>
                                                    <form action="<?= base_url('/admin/user/block'); ?>" method="POST" class="d-inline">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="userID" value="<?= $row['userID']; ?>">
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('你确定要拉黑？');">
                                                            <i class="fas fa-trash"></i>
                                                            拉黑 Blockir
                                                        </button>
                                                    </form>
                                                    <form action="<?= base_url('/admin/user/resetpass'); ?>" method="POST" class="d-inline">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="userID" value="<?= $row['userID']; ?>">
                                                        <button type="submit" class="btn btn-warning" onclick="return confirm('你确定要重置密码？');">
                                                            <i class="fas fa-sync"></i>
                                                            重置密码 Reset Password
                                                        </button>
                                                    </form>
                                                <?php else : ?>
                                                    <form action="<?= base_url('/admin/user/restore'); ?>" method="POST" class="d-inline">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="userID" value="<?= $row['userID']; ?>">
                                                        <button type="submit" class="btn btn-success" onclick="return confirm('你确定要复原？');">
                                                            <i class="fas fa-sync"></i>
                                                            复原 Pulihkan
                                                        </button>
                                                    </form>
                                                <?php endif; ?>

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
<script type="text/javascript">
    $(document).ready(function() {
        bsCustomFileInput.init();
    });
</script>
<!-- Ekko Lightbox -->

<?= $this->endSection() ?>