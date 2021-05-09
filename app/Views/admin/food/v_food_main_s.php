<?= $this->extend('templates/index') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>特别菜肴信息管理 Manajemen Masakan Spesial</h1>
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
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <a class="btn btn-success" href="<?= base_url('/admin/food/add_s'); ?>">
                                <i class="fas fa-plus" aria-hidden="true"></i>
                                添加 Tambah
                            </a>
                            <a class="btn btn-warning" href="<?= base_url('/admin/food/restore'); ?>">
                                <i class="fas fa-sync" aria-hidden="true"></i>
                                还原已删菜肴 Pulihkan masakan yang terhapus
                            </a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>编号 Kode</th>
                                        <th colspan="2">名称 Nama</th>
                                        <th>单价 Harga</th>
                                        <th>份数 Porsi</th>
                                        <th>照片 Foto</th>
                                        <th>行动 Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($rows as $row) : ?>
                                        <tr>
                                            <td><?= $row['foodID']; ?></td>
                                            <td><?= $row['name']; ?>
                                            </td>
                                            <td><?= $row['nameIND']; ?>
                                            </td>
                                            <td><?= number_format($row['price']); ?></td>
                                            <td><?= number_format($row['qty']); ?></td>
                                            <td>
                                                <a href="<?= base_url('/img/' . $row['photoURL']) ?>" data-toggle="lightbox" data-title="编号 Kode: <?= $row['foodID']; ?>">
                                                    <div>
                                                        <img width="40" src="<?= base_url('/img/' . $row['photoURL']) ?>" class="img-fluid img-tumbnail img-preview">
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('/admin/food/edit_s/' . base64_encode($row['foodID'])); ?>" class="btn btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                    编辑 Edit
                                                </a>
                                                <form action="<?= base_url('/admin/food/special/' . base64_encode($row['foodID'])); ?>" method="POST" class="d-inline">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('你确定要删除？ Anda yakin ingin menghapus?');">
                                                        <i class="fas fa-trash"></i>
                                                        删除 Hapus
                                                    </button>
                                                </form>
                                                <form action="<?= base_url('/admin/food/switch'); ?>" method="POST" class="d-inline">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="foodID" value="<?= $row['foodID']; ?>">
                                                    <input type="hidden" name="type" value="ordinary">
                                                    <button type="submit" class="btn btn-info" onclick="return confirm('你确定要转成平日？ Anda yakin ingin mengganti menjadi harian? ');">
                                                        <i class="fas fa-sync"></i>
                                                        转成平日 Ganti Menjadi harian
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
<script type="text/javascript">
    $(document).ready(function() {
        bsCustomFileInput.init();
    });
</script>
<!-- Ekko Lightbox -->
<script src="<?= base_url(); ?>/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<script>
    $(function() {
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });
    })
</script>
<?= $this->endSection() ?>