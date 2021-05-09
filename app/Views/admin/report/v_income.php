<?= $this->extend('templates/index') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>销售统计 Penjualan</h1>
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
                            <div class="row justify-content-around">
                                <div class="col-lg-2 col-md-6">
                                    <div class="form-group row">
                                        <label class="col my-auto" for="type">开始时间 Waktu Mulai :</label>
                                        <input class="form-control col-12" type="date" name="begin" id="begin" value="<?= date('Y-m-d'); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="form-group row">
                                        <label class="col my-auto" for="type">结束时间 Waktu Berakhir :</label>
                                        <input class="form-control col-12" type="date" name="end" id="end" value="<?= date('Y-m-d'); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="form-group row">
                                        <label class="col my-auto" for="type">菜类 Tipe Masakan :</label>
                                        <select id="type" name="type" class="form-control col-12">
                                            <option value="all">全部 Semua</option>
                                            <option value="ordinary">平日 Harian</option>
                                            <option value="special">特别 Spesial</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="form-group row">
                                        <label class="col my-auto" for="type">地区 Regional :</label>
                                        <select id="region" name="region" class="form-control col-12">
                                            <option value="all">全区 Semua</option>
                                            <option value="BQ">北区 Utara</option>
                                            <option value="NQ">南区 Selatan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <button id="query" class="btn btn-primary">查询 Telusuri</button>
                                    <!-- <button id="export" class="btn btn-success">导出 Export</button> -->
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>编号 Kode</th>
                                        <th>名称 Nama </th>
                                        <th>单价 Harga</th>
                                        <th>售量 Porsi</th>
                                        <th>金额 Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" style="text-align:right">总计 Total : </th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" style="text-align:right">外送总计 Pengantaran : </th>
                                        <th id="dCount"></th>
                                        <th id="dSum"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="d-none">
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>编号 Kode</th>
                                        <th>名称 Nama </th>
                                        <th>单价 Harga</th>
                                        <th>售量 Porsi</th>
                                        <th>金额 Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" style="text-align:right">总计 Total : </th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" style="text-align:right">外送总计 Pengantaran : </th>
                                        <th id="dCount2"></th>
                                        <th id="dSum2"></th>
                                    </tr>
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
<!-- page script -->
<script>
    $(document).ready(function() {
        // let qry_sta = false;

        table1 = $("#example1").DataTable();
        // table2 = $("#example2").DataTable({
        //     "responsive": true,
        //     "autoWidth": false
        // });

        function createTable1(obj) {
            table1.destroy();
            table1 = $("#example1").DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copyHtml5',
                        footer: true,
                        text: '复制 Copy',
                        className: 'btn btn-info',
                        exportOptions: {
                            orthogonal: "exportxls"
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        text: '导出 Excel',
                        className: 'btn btn-success',
                        exportOptions: {
                            orthogonal: "exportxls"
                        }
                    }
                ],
                "order": [
                    [3, "desc"]
                ],
                "responsive": true,
                "autoWidth": false,
                data: obj,
                columns: [{
                        data: 'foodID',
                    },
                    {
                        data: 'foodName'
                    },
                    {
                        data: 'price',
                        'render': function(data, type) {
                            if (type === "display" || type === "filter") {
                                data = new Intl.NumberFormat().format(data);
                                return 'Rp ' + data;
                            }
                            if (type === "exportxls") {
                                return data;
                            }
                            return data;
                        }

                    },
                    {
                        data: 'sum_qty',
                        'render': function(data, type) {
                            if (type === "display" || type === "filter") {
                                data = new Intl.NumberFormat().format(data);
                                return data;
                            }
                            if (type === "exportxls") {
                                return data;
                            }
                            return data;
                        }
                    },
                    {
                        data: 'product',
                        'render': function(data, type) {
                            if (type === "display" || type === "filter") {
                                data = new Intl.NumberFormat().format(data);
                                return 'Rp ' + data;
                            }
                            if (type === "exportxls") {
                                return data;
                            }
                            return data;
                        }
                    }
                ],
                "footerCallback": function(row, data, start, end, display) {
                    var api = this.api();
                    api.columns(4).every(function() {
                        var sum = this
                            .data()
                            .reduce(function(a, b) {
                                var x = parseFloat(a) || 0;
                                var y = parseFloat(b) || 0;
                                return x + y;
                            }, 0);
                        sum = new Intl.NumberFormat().format(sum);
                        $(this.footer()).html("Rp " + sum);
                    });
                    api.columns(3).every(function() {
                        var sum = this
                            .data()
                            .reduce(function(a, b) {
                                var x = parseFloat(a) || 0;
                                var y = parseFloat(b) || 0;
                                return x + y;
                            }, 0);
                        sum = new Intl.NumberFormat().format(sum);
                        $(this.footer()).html(sum + " 份");
                    });
                }

            });
            qry_sta = true;
        }

        // function createTable2(obj) {
        //     table2.destroy();
        //     table2 = $("#example2").DataTable({
        //         "order": [
        //             [3, "desc"]
        //         ],
        //         "responsive": true,
        //         "autoWidth": false,
        //         data: obj,
        //         columns: [{
        //                 data: 'foodID'
        //             },
        //             {
        //                 data: 'foodName'
        //             },
        //             {
        //                 data: 'price'
        //             },
        //             {
        //                 data: 'sum_qty'
        //             },
        //             {
        //                 data: 'product'
        //             }
        //         ],
        //         "footerCallback": function(row, data, start, end, display) {
        //             var api = this.api();
        //             api.columns(4).every(function() {
        //                 var sum = this
        //                     .data()
        //                     .reduce(function(a, b) {
        //                         var x = parseFloat(a) || 0;
        //                         var y = parseFloat(b) || 0;
        //                         return x + y;
        //                     }, 0);
        //                 $(this.footer()).html(sum);
        //             });
        //             api.columns(3).every(function() {
        //                 var sum = this
        //                     .data()
        //                     .reduce(function(a, b) {
        //                         var x = parseFloat(a) || 0;
        //                         var y = parseFloat(b) || 0;
        //                         return x + y;
        //                     }, 0);
        //                 $(this.footer()).html(sum);
        //             });
        //         }
        //     });
        // }

        $("#query").click(function() {
            let begin = $('#begin').val();
            let end = $('#end').val();
            let type = $('#type').val();
            let region = $('#region').val();
            let url = '<?= base_url('/admin/report/income_query/') ?>/' + begin + '/' + end + '/' + type + '/' + region;
            $.get(url, function(data, status) {
                let obj = JSON.parse(data);
                createTable1(obj);
            });
            url = '<?= base_url('/admin/report/delivery_query/') ?>/' + begin + '/' + end + '/' + region;
            $.get(url, function(data, status) {
                let obj = JSON.parse(data);
                $("#dCount").html(obj[0].dCount + " 次");
                let dSum = new Intl.NumberFormat().format(obj[0].dSum);
                $("#dSum").html("Rp " + dSum);
            });
        });

        // $("#export").click(function() {
        //     if (qry_sta) {
        //         let begin = $('#begin').val();
        //         let end = $('#end').val();
        //         let type = $('#type').val();
        //         let region = $('#region').val();
        //         let url = '<?= base_url('/admin/report/income_export/') ?>/' + begin + '/' + end + '/' + type + '/' + region;

        //         $.get(url, function(data, status) {
        //             let obj = JSON.parse(data);
        //             createTable2(obj);
        //             url = '<?= base_url('/admin/report/delivery_query/') ?>/' + begin + '/' + end + '/' + region;
        //             $.get(url, function(data, status) {
        //                 let obj = JSON.parse(data);
        //                 $("#dCount2").html(obj[0].dCount);
        //                 let dSum = obj[0].dSum;
        //                 $("#dSum2").html(dSum);
        //                 $("#example2").excelexportjs({
        //                     containerid: "example2",
        //                     datatype: 'table'
        //                 });
        //             });

        //         });

        //     }
        // });


    });
</script>
<?= $this->endSection() ?>