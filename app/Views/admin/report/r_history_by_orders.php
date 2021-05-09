<?= $this->extend('admin/report/template') ?>

<?= $this->section('content') ?>
<!-- title row -->
<div class="row mb-5">
    <div class="col-12 ">
        <h2 class="page-header">
            <img src="<?= base_url(); ?>/img/favicon-32x32.png" alt="点餐系统" class="brand-image elevation-3 img-circle" style="opacity: .8">
            <span class="brand-text font-weight-light">点餐系统</span>
            <small class="float-right">日期: <?= date('Y/m/d'); ?></small>
        </h2>
    </div>
    <!-- /.col -->
</div>
<!-- info row -->
<div class="row invoice-info mb-2 ">
    <div class="col-12 ">
        <h3>
            订单历史 （<?= $date; ?>）
            <?php if ($region != 'all') : ?>
                <?= $region == 'BQ' ? '北区' : '南区'; ?>
            <?php endif; ?>
        </h3>
    </div>
</div>
<!-- /.row -->

<!-- Table row -->
<div class="row">
    <div class="col-12 table-responsive">
        <table class="table table-striped">
            <thead>
                <th>#</th>
                <th>订单编号</th>
                <th>消费者姓名</th>
                <th>工号</th>
                <th>房间号</th>
                <th>电话号</th>
                <th>时间</th>
                <th>外送状态</th>
                <?php if ($region == 'all') : ?>
                    <th>地区</th>
                <?php endif; ?>
            </thead>
            <tbody>
                <?php $num = 0; ?>
                <?php foreach ($rows as $row) : ?>
                    <tr>
                        <td><?= ++$num; ?></td>
                        <td><?= $row['ordID']; ?></td>
                        <td><?= $row['name']; ?></td>
                        <td><?= $row['empID']; ?></td>
                        <td><?= $row['roomNum']; ?></td>
                        <td><?= $row['phoneNum']; ?></td>
                        <td>
                            <?php
                            $date = new DateTime($row['created_at']);
                            echo $date->format('H:i:s');
                            ?>
                        </td>
                        <td><?= $row['deliverySta'] == 1 ? '外送' : '不外送'; ?></td>
                        <?php if ($region == 'all') : ?>
                            <td><?= $row['region'] == 'BQ' ? '北区' : '南区'; ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- /.col -->
</div>
<div class="row">
    <div class="col-6 table-responsive">
        <table class="table table-striped ">
            <tbody>
                <tr class="">
                    <th>订单数量</th>
                    <td><span class="text-primary font-weight-bold"><?= $num; ?></span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- /.row -->
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>

</script>
<?= $this->endSection() ?>