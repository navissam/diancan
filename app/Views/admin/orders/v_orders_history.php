<?= $this->extend('templates/index') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>订单历史 Riwayat Pesanan</h1>
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
                                        <label class="col my-auto" for="begin">开始时间 Waktu Mulai :</label>
                                        <input class="form-control col-12" type="date" name="begin" id="begin" value="<?= date('Y-m-d'); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="form-group row">
                                        <label class="col my-auto" for="end">结束时间 Waktu Berakhir :</label>
                                        <input class="form-control col-12" type="date" name="end" id="end" value="<?= date('Y-m-d'); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="form-group row">
                                        <label class="col my-auto" for="deliverySta">外送 Pengantaran :</label>
                                        <select id="deliverySta" name="deliverySta" class="form-control col-12">
                                            <option value="all">全部 Semua</option>
                                            <option value="1">外送 Antar</option>
                                            <option value="0">不外送 Tidak Antar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="form-group row">
                                        <label class="col my-auto" for="paymentSta">付款状态 Pembayaran :</label>
                                        <select id="paymentSta" name="paymentSta" class="form-control col-12">
                                            <option value="all">全部 Semua</option>
                                            <option value="1">已付款 Sudah</option>
                                            <option value="0">未付款 Belum</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-6">
                                    <div class="form-group row">
                                        <label class="col my-auto" for="region">地区 Regional :</label>
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
                                        <th>编号<br>Kode</th>
                                        <th>序号<br>Serial </th>
                                        <th>姓名<br>Nama</th>
                                        <th>工号<br>NIK</th>
                                        <th>房间号<br>No. Kamar</th>
                                        <th>电话号<br>No. Telp</th>
                                        <th>时间<br>Waktu</th>
                                        <th>外送<br>Pengantaran</th>
                                        <th>付款<br>Pembayaran</th>
                                        <th>地区<br>Regional</th>
                                        <th>金额<br>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="10" style="text-align:right">总计 Total : </th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="d-none">
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>编号<br>Kode</th>
                                        <th>序号<br>Serial </th>
                                        <th>姓名<br>Nama</th>
                                        <th>工号<br>NIK</th>
                                        <th>房间号<br>No. Kamar</th>
                                        <th>电话号<br>No. Telp</th>
                                        <th>时间<br>Waktu</th>
                                        <th>外送<br>Pengantaran</th>
                                        <th>付款<br>Pembayaran</th>
                                        <th>地区<br>Regional</th>
                                        <th>金额<br>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="10" style="text-align:right">总计 Total : </th>
                                        <th></th>
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
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="example3" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>编号 Kode</th>
                                    <th>菜名 Nama</th>
                                    <th>单价 Harga</th>
                                    <th>菜类 Tipe</th>
                                    <th>售量 Porsi</th>
                                    <th>金额 Jumlah</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" style="text-align:right">总计 Total : </th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
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
        table3 = $("#example3").DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });

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
                    [1, "asc"]
                ],
                "responsive": true,
                "autoWidth": false,
                data: obj,
                columns: [{
                        data: 'ordID',
                        'render': function(x) {
                            link = '<button type="button" class="btn btn-link btn-detail" data-ordID="' + x + '">' + x + '</button>';
                            return link;
                        }
                    }, {
                        data: 'serialNum',
                    }, {
                        data: 'name',
                    }, {
                        data: 'empID',
                    }, {
                        data: 'roomNum',
                    }, {
                        data: 'phoneNum',
                    }, {
                        data: 'created_at',
                    }, {
                        data: 'deliverySta',
                        'render': function(x) {
                            x = (x == 1) ? '外送 Antar' : '不外送 Tidak Antar';
                            return x;
                        }
                    },
                    {
                        data: 'paymentSta',
                        'render': function(x) {
                            x = (x == 1) ? '已付款 Sudah' : '未付款 Belum';
                            return x;
                        }
                    },
                    {
                        data: 'region',
                        'render': function(x) {
                            x = (x == 'BQ') ? '北区 Utara' : '南区 Selatan';
                            return x;
                        },
                    }, {
                        data: 'amount',
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
                    api.columns(10).every(function() {
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
                }

            });
            // qry_sta = true;
        }

        // function createTable2(obj) {

        //     table2.destroy();
        //     table2 = $("#example2").DataTable({
        //         "order": [
        //             [1, "asc"]
        //         ],
        //         "responsive": true,
        //         "autoWidth": false,
        //         data: obj,
        //         columns: [{
        //                 data: 'ordID'
        //             },
        //             {
        //                 data: 'serialNum'
        //             },
        //             {
        //                 data: 'name'
        //             },
        //             {
        //                 data: 'empID'
        //             },
        //             {
        //                 data: 'roomNum'
        //             },
        //             {
        //                 data: 'phoneNum'
        //             },
        //             {
        //                 data: 'created_at'
        //             },
        //             {
        //                 data: 'deliverySta',
        //                 'render': function(x) {
        //                     x = (x == 1) ? '外送 Antar' : '不外送 Tidak Antar';
        //                     return x;
        //                 }
        //             },
        //             {
        //                 data: 'paymentSta',
        //                 'render': function(x) {
        //                     x = (x == 1) ? '已付款 Sudah' : '未付款 Belum';
        //                     return x;
        //                 }
        //             },
        //             {
        //                 data: 'region',
        //                 'render': function(x) {
        //                     x = (x == 'BQ') ? '北区 Utara' : '南区 Selatan';
        //                     return x;
        //                 }
        //             },
        //             {
        //                 data: 'amount'
        //             }
        //         ],
        //         "footerCallback": function(row, data, start, end, display) {
        //             var api = this.api();
        //             api.columns(10).every(function() {
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

        function createTable3(obj) {
            table3.destroy();
            table3 = $("#example3").DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                data: obj,
                columns: [{
                    data: 'foodID',
                }, {
                    data: 'foodName',
                }, {
                    data: 'price',
                }, {
                    data: 'type',
                    'render': function(type) {
                        type = (type == 'ordinary' ? '平日 Harian' : '特别 Spesial');
                        return type;
                    }
                }, {
                    data: 'qty',
                }, {
                    data: 'product',
                    'render': function(amount) {
                        amount = new Intl.NumberFormat().format(amount);
                        return 'Rp ' + amount;
                    }
                }],
                "footerCallback": function(row, data, start, end, display) {
                    var api = this.api();
                    api.columns(5).every(function() {
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
                }

            });
            qry_sta = true;
        }

        $("#query").click(function() {
            let begin = $('#begin').val();
            let end = $('#end').val();
            let deliverySta = $('#deliverySta').val();
            let paymentSta = $('#paymentSta').val();
            let region = $('#region').val();
            let url = '<?= base_url('/admin/orders/history_by_order_query/') ?>/' + begin + '/' + end + '/' + deliverySta + '/' + paymentSta + '/' + region;
            $.get(url, function(data, status) {
                let obj = JSON.parse(data);
                // console.log(obj);
                createTable1(obj);
            });
        });

        // $("#export").click(function() {
        //     if (qry_sta) {
        //         let begin = $('#begin').val();
        //         let end = $('#end').val();
        //         let deliverySta = $('#deliverySta').val();
        //         let paymentSta = $('#paymentSta').val();
        //         let region = $('#region').val();
        //         let url = '<?= base_url('/admin/orders/history_by_order_query/') ?>/' + begin + '/' + end + '/' + deliverySta + '/' + paymentSta + '/' + region;

        //         $.get(url, function(data, status) {
        //             let obj = JSON.parse(data);
        //             createTable2(obj);
        //             $("#example2").excelexportjs({
        //                 containerid: "example2",
        //                 datatype: 'table'
        //             });
        //         });

        //     }
        // });

        $("body").on("click", ".btn-detail", function(e) {
            let ordID = $(this).data('ordid');
            let url = '<?= base_url('/admin/orders/getDetail/') ?>/' + ordID;
            $.get(url, function(data, status) {
                console.log(url);
                let obj = JSON.parse(data);
                createTable3(obj);
                $('.modal-title').html(ordID);
                $('#myModal').modal({
                    show: true
                });
            });
        });



    });
</script>
<?= $this->endSection() ?>