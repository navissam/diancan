<?= $this->extend('templates/index') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>订单明细 Rincian Pesanan</h1>
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
                            <div class="row justify-content-start">
                                <div class="col-lg-2 col-md-6 mx-2">
                                    <div class="form-group row">
                                        <label class="col my-auto" for="begin">开始时间 Waktu Mulai :</label>
                                        <input class="form-control col-12" type="date" name="begin" id="begin" value="<?= date('Y-m-d'); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6 mx-2">
                                    <div class="form-group row">
                                        <label class="col my-auto" for="end">结束时间 Waktu Berakhir :</label>
                                        <input class="form-control col-12" type="date" name="end" id="end" value="<?= date('Y-m-d'); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6  mx-2">
                                    <div class="form-group row">
                                        <label class="col my-auto" for="type">菜类 Tipe Masakan :</label>
                                        <select id="type" name="type" class="form-control col-12">
                                            <option value="all">全部 Semua</option>
                                            <option value="ordinary">平日 Harian</option>
                                            <option value="special">特别 Spesial</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-start">
                                <div class="col-lg-2 col-md-6 mx-2">
                                    <div class="form-group row">
                                        <label class="col my-auto" for="deliverySta">外送 Pengantaran :</label>
                                        <select id="deliverySta" name="deliverySta" class="form-control col-12">
                                            <option value="all">全部 Semua</option>
                                            <option value="1">外送 Antar</option>
                                            <option value="0">不外送 Tidak Antar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6 mx-2">
                                    <div class="form-group row">
                                        <label class="col my-auto" for="paymentSta">付款状态 Pembayaran :</label>
                                        <select id="paymentSta" name="paymentSta" class="form-control col-12">
                                            <option value="all">全部 Semua</option>
                                            <option value="1">已付款 Sudah</option>
                                            <option value="0">未付款 Belum</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6 mx-2">
                                    <div class="form-group row">
                                        <label class="col my-auto" for="region">地区 Regional :</label>
                                        <select id="region" name="region" class="form-control col-12">
                                            <option value="all">全区 Semua</option>
                                            <option value="BQ">北区 Utara</option>
                                            <option value="NQ">南区 Selatan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6 mx-2 my-auto">
                                    <button id="query" class="btn btn-primary">查询 Telusuri</button>
                                    <!-- <button id="export" class="btn btn-success">导出 Export</button> -->
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped" style="max-width: none;">
                                <thead>
                                    <tr>
                                        <th>编号<br>Kode</th>
                                        <th>序号<br>Serial</th>
                                        <th>菜品<br>Masakan</th>
                                        <th>外送<br>Antar</th>
                                        <th>房间号<br>Kamar</th>
                                        <th>电话号<br>No.Telp</th>
                                    </tr>
                                </thead>
                                <tfoot></tfoot>
                            </table>
                        </div>
                        <div class="d-none">
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>编号<br>Kode</th>
                                        <th>序号<br>Serial</th>
                                        <th>菜品<br>Masakan</th>
                                        <th>外送<br>Antar</th>
                                        <th>房间号<br>Kamar</th>
                                        <th>电话号<br>No.Telp</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                </tfoot>
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
        table1 = $("#example1").DataTable();
        // table2 = $("#example2").DataTable({
        //     "responsive": true,
        //     "autoWidth": false
        // });

        function createTable1(obj, cols) {
            table1.destroy();
            $("#example1 thead").html('<tr></tr>');
            $("#example1 tfoot").html('<tr><th colspan="2" style="text-align:right">总计 Total : </th></tr>');
            for (i = 0; i < cols.length; i++) {
                $("#example1 thead tr").append("<th>" + cols[i].title + "</th>");
                if (i < cols.length - 5)
                    $("#example1 tfoot tr").append("<th></th>");
            }
            $("#example1 tfoot tr").append('<th colspan="3"></th>');
            $("#example1 tbody").html("");
            table1 = $("#example1").DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copyHtml5',
                        footer: true,
                        text: '复制 Copy',
                        className: 'btn btn-info'
                    },
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        text: '导出 Excel',
                        className: 'btn btn-success'
                    }
                ],
                "scrollX": true,
                "responsive": false,
                "autoWidth": true,
                data: obj,
                columns: cols,
                "footerCallback": function(row, data, start, end, display) {
                    var api = this.api();
                    for (i = 2; i < cols.length - 3; i++) {
                        api.columns(i).every(function() {
                            var sum = this
                                .data()
                                .reduce(function(a, b) {
                                    var x = parseFloat(a) || 0;
                                    var y = parseFloat(b) || 0;
                                    return x + y;
                                }, 0);
                            sum = new Intl.NumberFormat().format(sum);
                            $(this.footer()).html(sum);
                        });
                    }
                }

            });
            // qry_sta = true;
        }

        // function createTable2(obj, cols) {
        //     table2.destroy();
        //     $("#example2 thead").html('<tr></tr>');
        //     $("#example2 tfoot").html('<tr><th colspan="2" style="text-align:right">总计 Total : </th></tr>');
        //     for (i = 0; i < cols.length; i++) {
        //         $("#example2 thead tr").append("<th>" + cols[i].title + "</th>");
        //         if (i < cols.length - 5)
        //             $("#example2 tfoot tr").append("<th></th>");
        //     }
        //     $("#example2 tfoot tr").append('<th colspan="3"></th>');
        //     $("#example2 tbody").html("");
        //     table2 = $("#example2").DataTable({
        //         buttons: [
        //             'copy', 'csv', 'excel', 'pdf', 'print'
        //         ],
        //         "responsive": true,
        //         "autoWidth": false,
        //         data: obj,
        //         columns: cols,
        //         "footerCallback": function(row, data, start, end, display) {
        //             var api = this.api();
        //             for (i = 2; i < cols.length - 3; i++) {
        //                 api.columns(i).every(function() {
        //                     var sum = this
        //                         .data()
        //                         .reduce(function(a, b) {
        //                             var x = parseFloat(a) || 0;
        //                             var y = parseFloat(b) || 0;
        //                             return x + y;
        //                         }, 0);
        //                     sum = new Intl.NumberFormat().format(sum);
        //                     $(this.footer()).html(sum);
        //                 });
        //             }
        //         }
        //     });
        // }

        $("#query").click(function() {
            let begin = $('#begin').val();
            let end = $('#end').val();
            let type = $('#type').val();
            let deliverySta = $('#deliverySta').val();
            let paymentSta = $('#paymentSta').val();
            let region = $('#region').val();
            let url = '<?= base_url('/admin/orders/pivot/') ?>/' + begin + '/' + end + '/' + type + '/' + deliverySta + '/' + paymentSta + '/' + region;
            $.get(url, function(data, status) {
                let obj = JSON.parse(data);
                let url = '<?= base_url('/admin/orders/pivot_col/') ?>/' + begin + '/' + end + '/' + type + '/' + deliverySta + '/' + paymentSta + '/' + region;
                $.get(url, function(data, status) {
                    let cols = JSON.parse(data);
                    // console.log(cols);
                    createTable1(obj, cols);
                });
            });
        });

        // $("#export").click(function() {
        //     if (qry_sta) {
        //         let begin = $('#begin').val();
        //         let end = $('#end').val();
        //         let type = $('#type').val();
        //         let deliverySta = $('#deliverySta').val();
        //         let paymentSta = $('#paymentSta').val();
        //         let region = $('#region').val();
        //         let url = '<?= base_url('/admin/orders/pivot/') ?>/' + begin + '/' + end + '/' + type + '/' + deliverySta + '/' + paymentSta + '/' + region;
        //         $.get(url, function(data, status) {
        //             let obj = JSON.parse(data);
        //             let url = '<?= base_url('/admin/orders/pivot_col/') ?>/' + begin + '/' + end + '/' + type + '/' + deliverySta + '/' + paymentSta + '/' + region;
        //             $.get(url, function(data, status) {
        //                 let cols = JSON.parse(data);
        //                 // console.log(obj);
        //                 createTable2(obj, cols);
        //                 // $("#example2").excelexportjs({
        //                 //     containerid: "example2",
        //                 //     datatype: 'table'
        //                 // });
        //             });
        //         });

        //     }
        // });


    });
</script>
<?= $this->endSection() ?>