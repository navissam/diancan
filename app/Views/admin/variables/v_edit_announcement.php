<?= $this->extend('templates/index') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>编辑公告 Edit Pengumuman</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
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
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <div class="card-title">
                                公告状态 Status Pengumuman ->
                                <?php if ($announcement['status']) : ?>
                                    <span class="text-success">已发布 Terpublikasi</span>
                                    <form action="<?= base_url('/admin/variable/cancelannounce') ?>" method="POST" class="d-inline">
                                        <button type="submit" class="btn btn-danger mx-1" onclick="return confirm('确定撤销发布？ Yakin ingin batalkan publikasi?');">撤销发布 Batalkan publikasi</button>
                                    </form>
                                <?php else : ?>
                                    <span class="text-danger">待发布 Menunggu dipublikasi</span>
                                    <form action="<?= base_url('/admin/variable/publishannounce') ?>" method="POST" class="d-inline">
                                        <button type="submit" class="btn btn-success mx-1" onclick="return confirm('确定发布？ Yakin ingin publikasi?');">发布 Publikasikan</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                            <button form="announce" type="submit" class="btn btn-primary float-right mx-1" onclick="return confirm('确定保存？ Yakin ingin menyimpan?');">保存 Simpan</button>
                        </div>
                        <div class="card-body pad">
                            <form id="announce" action="<?= base_url('/admin/variable/updateannounce') ?>" method="POST">
                                <?= csrf_field(); ?>
                                <div class="mb-3">
                                    <textarea name="content" class="textarea" placeholder="Place some text here" style="width: 100%; height: 500px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                                <?= $announcement['content']; ?>
                                </textarea>
                                </div>
                            </form>
                        </div>
                    </div>
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
<script>
    $(function() {
        // Summernote
        $('.textarea').summernote({
            height: 500
        });
        $('div.note-editable').height(500);
    })
</script>
<?= $this->endSection() ?>