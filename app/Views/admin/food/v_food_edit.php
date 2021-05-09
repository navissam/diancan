<?= $this->extend('templates/index') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>编辑菜肴 Edit Masakan</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <!-- Default box -->
                    <div class="card  card-primary card-outline">
                        <form action="<?= base_url('/admin/food/update'); ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="foodID">编号 Kode</label>
                                    <input type="text" maxlength="4" class="form-control <?= ($validation->hasError('foodID')) ? 'is-invalid' : ''; ?>" value="<?= old('foodID') ? old('foodID') : $row['foodID']; ?>" name="foodID" id="foodID" placeholder="最长度四个字 Paling panjang 4 huruf/angka" readonly>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('foodID'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">中文名称 Nama Mandarin</label>
                                    <input type="text" maxlength="255" class="form-control <?= ($validation->hasError('name')) ? 'is-invalid' : ''; ?>" value="<?= old('name') ? old('name') : $row['name']; ?>" name="name" id="name" placeholder="输入中文名称 Nama Mandarin">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('name'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nameIND">印尼名称 Nama Indonesia</label>
                                    <input type="text" maxlength="255" class="form-control <?= ($validation->hasError('nameIND')) ? 'is-invalid' : ''; ?>" value="<?= old('nameIND') ? old('nameIND') : $row['nameIND']; ?>" name="nameIND" id="nameIND" placeholder="输入印尼名称 Nama Indonesia">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nameIND'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="price">单价 Harga</label>
                                    <input type="number" min="0" max="2147483647" class="form-control <?= ($validation->hasError('price')) ? 'is-invalid' : ''; ?>" value="<?= old('price') ? old('price') : $row['price']; ?>" name="price" id="price" placeholder="输入单价 Harga satuan">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('price'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="photoURL">照片 Foto</label>
                                    <div class="input-group <?= ($validation->hasError('photoURL')) ? 'is-invalid' : ''; ?>">
                                        <div class="custom-file ">
                                            <input type="hidden" name="oldPhoto" value="<?= $row['photoURL']; ?>">
                                            <input type="file" class="custom-file-input <?= ($validation->hasError('photoURL')) ? 'is-invalid' : ''; ?>" name="photoURL" id="photoURL" placeholder="输入照片">
                                            <label for="photoURL" class="custom-file-label">浏览照片 Telusuri foto</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="">上传 Unggah</span>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('photoURL'); ?>
                                    </div>
                                    <div class="m-3">
                                        <img width="180" src="<?= base_url('/img/' . $row['photoURL']) ?>" class="img-tumbnail img-preview">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="float-sm-right">
                                    <a class="btn btn-secondary" href="<?= base_url('/admin/food/ordinary'); ?>">
                                        取消 Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        保存 Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- /.card-footer-->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
    </section>
    <!-- /.content -->
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        function readURL(input) {
            var filesize = Math.ceil(input.files[0].size / 1024); // KB
            if (input.files && input.files[0] && filesize <= 512) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.img-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                alert('上传文件大小超过 File unggahan melebihi 512KB');
                input.value = '';
                $('.img-preview').attr('src', '<?= base_url('/img/food_default.png') ?>');
            }
        }

        $('#photoURL').change(function(e) {
            readURL(this);
        });
    });
</script>
<?= $this->endSection() ?>