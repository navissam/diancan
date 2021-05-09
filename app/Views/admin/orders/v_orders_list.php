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
            <div class="row">
                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5>已支付菜肴总数量 Jumlah Porsi Pesanan</h5>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>代码 Kode</th>
                                        <th>名称 Nama</th>
                                        <th>数量 Jumlah</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rows as $row) : ?>
                                        <tr>
                                            <td><?= $row['foodID']; ?></td>
                                            <td><?= $row['foodName']; ?>
                                            </td>
                                            <td><?= $row['qtySum']; ?></td>
                                            <td>
                                                <button class="btn btn-primary btn-food" data-foodID="<?= $row['foodID']; ?>" data-name="<?= $row['foodName']; ?>">
                                                    查询
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-6">
                    <div class="card card-success">
                        <div class="card-header">
                            <h5 id="ordHeader"></h5>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>订单编号 Kode Pesanan</th>
                                        <th>姓名 Nama</th>
                                        <th>工号 NIK</th>
                                        <th>外送状态</th>
                                        <th>数量</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
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

    });
</script>

<script>
    $(document).ready(function() {
        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false
        });
        table2 = $("#example2").DataTable({
            "responsive": true,
            "autoWidth": false
        });

        function createTable(obj) {
            table2.destroy();
            table2 = $("#example2").DataTable({
                "responsive": true,
                "autoWidth": false,
                data: obj,
                columns: [{
                        data: 'ordID'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'empID'
                    },
                    {
                        data: 'dSta'
                    },
                    {
                        data: 'qty'
                    }
                ]
            });
        }

        $(".btn-food").click(function() {
            let foodid = $(this).data("foodid");
            let foodname = $(this).data("name");
            $.get("<?= base_url('/admin/orders') ?>/" + foodid, function(data, status) {
                let obj = JSON.parse(data);
                createTable(obj);
                $("#ordHeader").html(foodid + " ( " + foodname + " ) ");
            });
        });
    });
</script>
<?= $this->endSection() ?>