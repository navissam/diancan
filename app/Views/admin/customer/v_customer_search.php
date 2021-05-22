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
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header mt-1">
                            <h5>寻找消费者 Pencarian Data Pelanggan
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('/admin/customer/result') ?>" method="POST">
                                <?= csrf_field(); ?>
                                <label for="key" class="">输入关键词 Masukkan kata kunci</label>
                                <div class="input-group">

                                    <input id="key" name="key" type="text" class="form-control" placeholder="‘姓名’ 或 ‘工号’ Nama atau NIK" required>
                                    <span class="input-group-append">
                                        <button type="submit" class="btn btn-primary btn-flat"><i class="fas fa-search"></i> 查询 Cek</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <div class="card card-outline card-secondary">
                        <div class="card-header mt-1">
                            <h5>导入消费者数据 Tambah Data Pelanggan
                                <a href="<?= base_url('admin/customer/download'); ?>" class='btn btn-secondary btn-sm float-right'><i class="fas fa-file-download"></i> 范本 Template</a>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <?= csrf_field(); ?>
                                    <?php if (!empty(session()->getFlashdata('success2'))) : ?>
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <?= session()->getFlashdata('success2') ?>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <?php endif ?>

                                    <?php if (!empty(session()->getFlashdata('error2'))) : ?>
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <?= session()->getFlashdata('error2') ?>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>


                            <?= form_open_multipart(base_url('admin/customer/upload')); ?>

                            <div class="input-group">
                                <!-- <input type="file" name="fileImport" class="form-control"> -->

                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="fileImport" name="fileImport" onchange="loadFile()">
                                    <label class="custom-file-label" for="fileImport">选择文件 Pilih File</label>
                                </div>
                                <div class="input-group-append">
                                    <!-- <button class='btn btn-success btn-flat' type="submit" name="fileImport">
                                                投入 Import
                                            </button> -->
                                    <button class="btn btn-outline-secondary btn-flat" type="submit" name="fileImport"><i class="fas fa-file-import"></i> 导入 Import</button>
                                    <!-- <a href="<?= base_url('admin/customer/download'); ?>" class='btn btn-primary btn-flat'> 范本 Template</a> -->
                                </div>
                            </div>
                            <!-- </form> -->
                            <?= form_close(); ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <div class="card card-outline card-indigo">
                        <div class="card-header mt-1">
                            <h5>手动添加消费者 Tambah Data Pelanggan Manual</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
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
                            <form action="<?= base_url('/admin/customer/save') ?>" method="POST">
                                <?= csrf_field(); ?>
                                <div class="form-group">
                                    <label for="name">姓名 Name</label>
                                    <input type="text" class="form-control <?= ($validation->hasError('name')) ? 'is-invalid' : ''; ?>" value="<?= old('name'); ?>" id="name" name="name" autofocus autocomplete="off">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('name'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="empID">工号 NIK</label>
                                    <input type="text" class="form-control <?= ($validation->hasError('empID')) ? 'is-invalid' : ''; ?>" value="<?= old('empID'); ?>" id="empID" name="empID" autocomplete="off">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('empID'); ?>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary batalData">取消 Batal</button>
                                    <button type="submit" class="btn btn-primary">保存 Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
    function loadFile() {
        const file = document.querySelector('#fileImport');
        const importLabel = document.querySelector('.custom-file-label');

        importLabel.textContent = file.files[0].name;

        const fileImport = new FileReader();
        fileImport.readAsDataURL(file.files[0]);
    }
    $(document).ready(function() {

        $('.collapse').collapse()
    });
</script>

<?= $this->endSection() ?>