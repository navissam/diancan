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

                        以下员工名单曾被注册过，其余的已成功注册<br>
                        Daftar karyawan dibawah ini sudah pernah terdaftar, Selainnya sudah berhasil di daftar


                    </div>
                </div>
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <a href="<?= base_url('/admin/customer') ?>" class="btn btn-secondary">返回 Kembali</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>工号 NIK</th>
                                        <th>姓名 Nama</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($datagagal as $dg) :
                                        // d($dg);
                                    ?>
                                        <tr>
                                            <td><?= $dg['empID']; ?></td>
                                            <td><?= $dg['name']; ?></td>
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
        $("#example").DataTable({
            "responsive": true,
            "autoWidth": false
        });
    });
</script>
<?= $this->endSection() ?>