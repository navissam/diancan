<?= $this->extend('templates/index') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>管理员日志 Catatan Sistem Admin</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="form-group">
                                <div class="row justify-content-start">
                                    <div class="col-lg-2 col-md-6">
                                        <label for="start">开始时间 Waktu Mulai :</label>
                                        <input type="date" class="form-control" id="start" value="<?= date('Y-m-d'); ?>">
                                    </div>
                                    <div class="col-2">
                                        <label for="finish">结束时间 Waktu Berakhir :</label>
                                        <input type="date" class="form-control" id="finish" value="<?= date('Y-m-d'); ?>">
                                    </div>
                                    <div class="col-2">
                                        <label for="controller">模块 Controller :</label>
                                        <select name="controller" id="controller" class="form-control">
                                            <option value="all">全部 Semua</option>
                                            <!-- <option value="auth">授权 Auth</option>
                                            <option value="payment">支付 Payment</option>
                                            <option value="customer">消费者 Customer</option>
                                            <option value="food">菜肴 Food</option>
                                            <option value="variable">变量 Variable</option> -->
                                            <?php foreach ($ctrl as $c) : ?>
                                                <option value="<?= $c['controller'] ?>"><?= $c['controller']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <label for="method">方法 Method :</label>
                                        <select name="method" id="method" class="form-control">
                                            <option value="all">全部 Semua</option>
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <label for="status">状态 Status :</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="all">全部 Semua</option>
                                            <option value="1">成功 Sukses</option>
                                            <option value="0">失败 Gagal</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-6 mt-auto">
                                        <button id="filter" class="btn btn-primary">查询 Telusuri</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="table1" class="table table-bordered table-striped" style="max-width: none;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>模块<br>Controller</th>
                                        <th>方法<br>Method</th>
                                        <th>时间<br>Timestamp</th>
                                        <th>数据<br>Data</th>
                                        <th>用户<br>User</th>
                                        <th>IP地址<br>IP Address</th>
                                        <th>状态<br>Status</th>
                                        <th>反应<br>Response</th>
                                    </tr>
                                </thead>
                                <tfoot></tfoot>
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
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">数据 Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea id="detail" cols=60 rows=10 disabled></textarea>
                </div>
                <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> 取消</button>
                        <button type="button" class="btn btn-primary" id="save-edit"><i class="fas fa-save"></i> 保存</button>
                    </div> -->
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<!-- DataTables -->
<script src="<?= base_url(); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/build/js/excelexportjs.js"></script>


<script src="<?= base_url(); ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-buttons/js/jszip.min.js"></script>


<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> -->
<!-- <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script> -->
<!-- <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script> -->

<!-- page script -->
<script>
    $(document).ready(function() {
        table1 = $("#table1").DataTable();
        // table2 = $("#example2").DataTable({
        //     "responsive": true,
        //     "autoWidth": false
        // });

        function createTable1(obj) {
            table1.destroy();
            table1 = $("#table1").DataTable({
                "order": [
                    [3, "desc"]
                ],
                "responsive": true,
                "autoWidth": false,
                data: obj,
                columns: [{
                        data: 'id',
                    },
                    {
                        data: 'controller'
                    },
                    {
                        data: 'method'
                    },
                    {
                        data: 'timestamp'
                    },
                    {
                        data: 'id',
                        render: function(data, type) {
                            let btn = '<button type="button" class="btn badge badge-primary btn-detail" data-admlogid="' + data + '">detail';
                            btn += '</button> ';
                            return btn
                        }
                    },
                    {
                        data: 'user_name',
                    },
                    {
                        data: 'ip'
                    },
                    {
                        data: 'status',
                        render: function(data, type) {
                            return (data == 1 ? '<span class="text-success">成功</span>' : '<span class="text-danger">失败</span')
                        }
                    },
                    {
                        data: 'response'
                    },
                ],
            });
        }

        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var today = now.getFullYear() + "-" + (month) + "-" + (day);
        $("#start").attr("max", today);
        $("#finish").attr("max", today);

        // reload datasource from ajax
        function reloadTable1() {
            let url = '/admin/admlog/getAll/';
            $.get(url, function(data, status) {
                let obj = JSON.parse(data);
                createTable1(obj);
                admlog = obj;
            });
        }

        $("#controller").on("change", function() {
            ctrl = $('#controller').val();
            // console.log(ctrl);
            let url = '/admin/admlog/getMethod/' + ctrl;
            $.get(url, function(data, status) {
                let obj = JSON.parse(data);
                // console.log(obj);

                $('#method').empty();
                $('#method').append('<option value="all">全部 Semua</option>');
                for (i = 0; i < obj.length; i++) {
                    $('#method').append('<option value="' + obj[i].method + '">' + obj[i].method + '</option>');
                }
                // if (data == 'auth') {
                // $('#method').append('<option value="login">登录 Login</option>');
                // $('#method').append('<option value="logout">登出 Logout</option>');
                // } else if (data == 'payment') {
                //     $('#method').append('<option value="process">过程 Proses</option>');
                // } else if (data == 'customer') {
                //     $('#method').append('<option value="upload">上传 Upload</option>');
                //     $('#method').append('<option value="resetpass">重置密码 Reset Password</option>');
                // } else if (data == 'variable' || data == 'food') {
                //     $('#method').append('<option value="update">更新 Update</option>');
                // }
                // console.log(data);
            });
        });

        $("#filter").on("click", function() {
            start = $('#start').val();
            controller = $('#controller').val();
            method = $('#method').val();
            status = $('#status').val();
            finish = $('#finish').val();
            // var date = new Date(f);
            // var day = ("0" + (date.getDate() + 1)).slice(-2);
            // var month = ("0" + (date.getMonth() + 1)).slice(-2);
            // var finish = date.getFullYear() + "-" + (month) + "-" + (day);

            let url = '/admin/admlog/getByFilter/' + start + "/" + finish + "/" + controller + "/" + method + "/" + status;
            $.get(url, function(data, status) {
                let obj = JSON.parse(data);
                createTable1(obj);
                admlog = obj;
            });
        });

        function pretty() {
            var ugly = document.getElementById('detail').value;
            try {
                var obj = JSON.parse(ugly);
            } catch (e) {

            }

            if (typeof obj === "object" && obj !== null) {
                var pretty = JSON.stringify(obj, undefined, 4);
                document.getElementById('detail').value = pretty;
            }
        };

        $("body").on("click", ".btn-detail", function(e) {
            id = $(this).data('admlogid');
            let a = admlog.find(x => x.id == id);
            let data = a.data;
            // console.log(data);
            $('#detail').val(data);
            pretty();
            $('#detailModal').modal('show');
        });

        reloadTable1();
    });
</script>
<?= $this->endSection() ?>