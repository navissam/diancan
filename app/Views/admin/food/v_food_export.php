<?= $this->extend('templates/index') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>查询菜肴信息 Menelusuri Informasi Masakan</h1>
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
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-2 col-md-4 col-sm-6">
                                    <div class="form-group row">
                                        <label class="col-auto my-auto" for="type">类别 Tipe :</label>
                                        <select id="type" name="type" class="form-control col">
                                            <option value="all">全部 Semua</option>
                                            <option value="ordinary">平日 Harian</option>
                                            <option value="special">特别 Spesial</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6">
                                    <button id="query" class="btn btn-primary">查询 Telusuri</button>
                                    <button id="export" class="btn btn-success">导出 Export</button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>编号 Kode</th>
                                        <th>名称 </th>
                                        <th>Nama</th>
                                        <th>单价 Harga</th>
                                        <th>类别 Tipe</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <div id="dvjson"></div>
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
<script src="<?= base_url(); ?>/build/js/excelexportjs.js"></script>
<!-- page script -->
<script>
    $(document).ready(function() {
        let qry_sta = false;

        table = $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false
        });

        function createTable(obj) {
            table.destroy();
            table = $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
                data: obj,
                columns: [{
                        data: 'foodID'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'nameIND'
                    },
                    {
                        data: 'price'
                    },
                    {
                        data: 'type'
                    }
                ]
            });
            qry_sta = true;
        }

        $("#query").click(function() {
            let type = $('#type').val();
            let url = '<?= base_url('/admin/food/query') ?>';
            if (type != 'all')
                url += '/' + type
            $.get(url, function(data, status) {
                let obj = JSON.parse(data);
                createTable(obj);
            });
        });

        $("#export").click(function() {
            if (qry_sta) {
                $("#example1").excelexportjs({
                    containerid: "example1",
                    datatype: 'table'
                });
            }
        });


    });
</script>
<?= $this->endSection() ?>