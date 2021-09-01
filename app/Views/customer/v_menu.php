<?= $this->extend('customer/template') ?>

<?= $this->section('content') ?>
<?php
$bt = strtotime($beginTime);
$et = strtotime($endTime);
$now = time();
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <?php if (!empty(session()->getFlashdata('error'))) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif ?>
            <div class="row">
                <div class="col-lg-8 col-md-6 mb-2">
                    <h1 class="m-0 text-dark">今日菜谱</h1>
                </div><!-- /.col -->
                <?php if ($now < $et && $now > $bt && count($ordinary) != 0) : ?>
                    <div class="col-lg-4 col-md-6 mb-2">
                        <form action="<?= base_url('/menu/ordering') ?>" method="post">
                            <div class="row mb-2">
                                <input type="hidden" name="json" id="json" value="null">
                                <div class="col-7">
                                    <select name="deliverySta" class="form-control" id="deliverySta" data-cost="<?= $deliveryCost; ?>">
                                        <option value="0">不外送 Tidak Antar</option>
                                        <!-- <option value="1">外送 Antar</option> -->
                                    </select>
                                </div>
                                <div class="col-5">
                                    <button type="submit" class="btn btn-success form-control" id="order">订购 Pesan</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <select name="deliveryTo" class="form-control text-success" id="deliveryTo" style="display: none;">
                                        <option value="room">自己房间 Kamar Sendiri</option>
                                        <option value="spec">别的房间 Kamar Lain</option>
                                    </select>
                                </div>
                                <div class="col-12 input-group" id="to" style="display: none;">
                                    <input type="text" class="form-control" name="to" placeholder="输入明确房间号">
                                    <span class="input-group-append">
                                        <select name="region" class="btn btn-secondary btn-info" id="region">
                                            <option value="BQ">北区 Utara</option>
                                            <option value="NQ">南区 Selatan</option>
                                        </select>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container">
            <?php if ($now > $et) : ?>
                <div class="row">
                    <div class="col">
                        <div class="alert alert-warning fade show" role="alert">
                            <strong>
                                时间已过！无法点餐！
                                <br>
                                请明天再点
                            </strong>
                        </div>
                    </div>
                </div>
            <?php elseif ($now < $bt) : ?>
                <div class="row">
                    <div class="col">
                        <div class="alert alert-warning fade show" role="alert">
                            <strong>
                                时间未到！无法点餐！
                                <br>
                                请稍后再点
                            </strong>
                        </div>
                    </div>
                </div>
            <?php elseif (count($ordinary) == 0) : ?>
                <div class="row">
                    <div class="col">
                        <div class="alert alert-warning fade show" role="alert">
                            <strong>
                                今日菜谱未发布！无法点餐！
                                <br>
                                请稍后再点。
                            </strong>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <div class="row">
                    <div class="col">
                        <div class="card card-primary card-outline collapsed-card">
                            <div class="card-header " data-card-widget="collapse">
                                <h3 class="card-title">
                                    已选菜肴
                                </h3>
                                <div class="card-tools">
                                    <span class="text-success">
                                        <h5 id="total" class="d-inline"></h5>
                                    </span>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>名称</th>
                                            <th>单价</th>
                                            <th>份数</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="table">
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>

                <!-- <div class="card" style="position: relative; left: 0px; top: 0px;">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link active" href="#ordinary" data-toggle="tab">正常售卖 Biasa</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#special" data-toggle="tab">限量售卖 Terbatas</a>
                            </li>
                        </ul>
                    </div>
                </div> -->

                <div class="tab-content">
                    <div class="tab-pane active" id="ordinary">
                        <div class="row">
                            <?php foreach ($ordinary as $row) : ?>
                                <div class="col-md-6 col-sm-6 col-lg-4">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-5 my-auto">
                                                <a href="<?= base_url('/img/' . $row['photoURL']) ?>" data-toggle="lightbox" data-title="菜肴编号：<?= $row['foodID']; ?>">
                                                    <img class="card-img-top rounded-left" style="width: 150px; height: 100px; object-fit: contain;" src="<?= base_url('/img/' . $row['photoURL']) ?>">
                                                </a>
                                            </div>
                                            <div class="col-7">
                                                <div class="row my-n1">
                                                    <div class="col mt-2 mr-2">
                                                        <span id="name-<?= $row['foodID']; ?>">
                                                            <?= $row['name']; ?>
                                                        </span>
                                                        <span class="text-success text-sm float-right" id="price-<?= $row['foodID']; ?>" data-price="<?= $row['price']; ?>"><?= number_format($row['price']); ?></span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <span id="nameIND-<?= $row['foodID']; ?>" class="text-sm">
                                                            <?= $row['nameIND']; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col mb-auto">
                                                        <button class="btn btn-success btn-qty font-weight-bold" data-action="plus" data-foodid="<?= $row['foodID']; ?>">
                                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                                        </button>
                                                        <span class="btn btn-primary font-weight-bold btn-qty" data-action="zero" id="qty-<?= $row['foodID']; ?>" data-type="ordinary" data-foodid="<?= $row['foodID']; ?>">0</span>
                                                        <button class="btn btn-danger btn-qty" data-action="minus" data-foodid="<?= $row['foodID']; ?>">
                                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card -->
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="tab-pane" id="special" style="position: relative; height: 300px;">
                        <div class="row">
                            <?php foreach ($special as $row) : ?>
                                <div class="col-md-6 col-sm-6 col-lg-4">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-5 my-auto">
                                                <a href="<?= base_url('/img/' . $row['photoURL']) ?>" data-toggle="lightbox" data-title="菜肴编号：<?= $row['foodID']; ?>">
                                                    <img class="card-img-top rounded-left" src="<?= base_url('/img/' . $row['photoURL']) ?>">
                                                </a>
                                            </div>
                                            <div class="col-7">
                                                <div class="row my-n1">
                                                    <div class="col mt-2 mr-2">
                                                        <span id="name-<?= $row['foodID']; ?>">
                                                            <?= $row['name']; ?>
                                                        </span>
                                                        <span class="text-success text-sm float-right" id="price-<?= $row['foodID']; ?>" data-price="<?= $row['price']; ?>"><?= number_format($row['price']); ?></span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <span id="nameIND-<?= $row['foodID']; ?>" class="text-sm">
                                                            <?= $row['nameIND']; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <?php if ($row['ordered_qty'] < $row['qty']) : ?>
                                                        <div class="col-12 mb-auto">
                                                            <button class="btn btn-success btn-qty font-weight-bold" data-action="plus" data-foodid="<?= $row['foodID']; ?>">
                                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                                            </button>
                                                            <span class="btn btn-primary font-weight-bold btn-qty" data-action="zero" id="qty-<?= $row['foodID']; ?>" data-max-qty="<?= $row['qty'] - $row['ordered_qty']; ?>" data-foodid="<?= $row['foodID']; ?>">0</span>
                                                            <button class="btn btn-danger btn-qty" data-action="minus" data-foodid="<?= $row['foodID']; ?>">
                                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                        <div class="col-12">
                                                            <span class="text-sm text-primary">剩 Sisa : <?= $row['qty'] - $row['ordered_qty']; ?></span>
                                                        </div>
                                                    <?php else : ?>
                                                        <span class="text-danger mr-auto">断货 Habis</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card -->
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            <?php endif; ?>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<a id="back-to-top" href="#" class="btn btn-info back-to-top rounded-circle" role="button"><i class="fas fa-chevron-up"></i></a>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        $(window).scroll(function() {
            if ($(this).scrollTop() > 50) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });
        // scroll body to 0px on click
        $('#back-to-top').click(function() {
            $('body,html').animate({
                scrollTop: 0
            }, 400);
            return false;
        });
        var orders = {};

        function update_orders(orders, foodid, row) {
            if (row["qty"] == 0) {
                delete orders[foodid];
            } else
                orders[foodid] = row;
        }

        function update_total(orders) {
            let deliverySta = $("#deliverySta").val();
            let deliveryCost = $("#deliverySta").data("cost");
            deliveryCost = parseInt(deliveryCost, 10);
            let total = 0;
            for (var key in orders) {
                row = orders[key];
                total += row["product"];
            }
            total += deliverySta * deliveryCost;
            total = new Intl.NumberFormat().format(total);
            $("#total").html("总价 " + total + "盾");
        }

        function update_table(orders) {
            let text = "";
            for (var key in orders) {
                row = orders[key];
                len = row.length;
                text += "<tr>";
                text += "<td>" + row["name"] + "</td>";
                let price = new Intl.NumberFormat().format(row["price"]);
                text += "<td>" + price + "</td>";
                text += "<td>" + row["qty"] + "</td>";
                let product = new Intl.NumberFormat().format(row["product"]);
                text += "<td>" + product + "</td>";
                text += "</tr>";
            }
            let deliverySta = $("#deliverySta").val();
            let deliveryCost = $("#deliverySta").data("cost");
            deliveryCost = parseInt(deliveryCost, 10);
            deliveryCost = new Intl.NumberFormat().format(deliveryCost, 10);
            if (deliverySta == 1) {
                text += "<tr><td colspan=\"3\">外送费</td><td>" + deliveryCost + "</td>"
            }
            $("#table").html(text);
        }

        $(".btn-qty").click(function() {
            let foodid = $(this).data("foodid");
            let name = $("#name-" + foodid).text().trim() + " " + $("#nameIND-" + foodid).text().trim();
            let qty = $("#qty-" + foodid).text();
            let max_qty = $("#qty-" + foodid).data("max-qty");
            let type = $("#qty-" + foodid).data("type");
            let price = $("#price-" + foodid).data("price");
            let action = $(this).data("action");

            price = parseInt(price, 10);
            qty = parseInt(qty, 10);
            if (action == "plus") {
                if (type == "ordinary") qty += 1;
                else if (qty < max_qty) qty += 1;
            } else if (action == "minus") {
                qty -= 1;
                if (qty < 0) qty = 0;
            } else if (action == "zero") {
                qty = 0;
            }
            $("#qty-" + foodid).text(qty);
            let product = qty * price;
            $("#product-" + foodid).text(product + "盾");
            let row = {
                "foodID": foodid,
                "name": name,
                "price": price,
                "qty": qty,
                "product": product
            };
            update_orders(orders, foodid, row);
            update_table(orders);
            update_total(orders);
        });

        function checkDates(b, e) {
            let dt = new Date();
            let d = dt.getDate();
            let m = dt.getMonth() + 1;
            let y = dt.getFullYear();

            b = y + "-" + m + "-" + d + " " + b;
            e = y + "-" + m + "-" + d + " " + e;
            begin = new Date(b);
            end = new Date(e);
            return dt.getTime() < begin.getTime() || dt.getTime() > end.getTime();
        }

        $("#order").click(function() {
            let myJSON = JSON.stringify(orders);
            let beginTime = "<?= $beginTime; ?>";
            let endTime = "<?= $endTime; ?>";
            if (checkDates(beginTime, endTime)) {
                alert("现在不是点餐时间范围！无法点餐！");
                return false;
            } else if (Object.keys(orders).length == 0) {
                alert("无法订购！您还没有点选菜肴！");
                return false;
            } else if ($('#deliveryTo').val() == 'spec' && $('input[name="to"]').val() == '') {
                alert("请输入明确房间号");
                return false;
            } else {
                // console.log(myJSON);
                $("#json").val(myJSON);
                return confirm("你确定要完成订购？");
                // return false
            }
        });

        $("#deliverySta").change(function() {
            update_table(orders);
            update_total(orders);
            if ($("#deliverySta").val() == 0) {
                $('#deliveryTo').hide();
                $('#deliveryTo').val('room');
                $('#to').hide();
            } else {
                $('#deliveryTo').show();
            }
        });

        $('#deliveryTo').change(function() {
            if ($(this).val() == 'room') {
                $('#to').hide();
            } else {
                $('#to').show();
            }
        });
    });
</script>



<!-- Ekko Lightbox -->
<script src="../plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
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