<?= $this->extend('templates/index') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>添加账号 Tambah Pengguna</h1>
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
                    <div class="card  card-success">
                        <div class="card-header">
                        </div>
                        <form action="<?= base_url('/admin/user/save'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="userID">账号编码 Kode</label>
                                    <input type="text" class="form-control <?= ($validation->hasError('userID')) ? 'is-invalid' : ''; ?>" value="<?= old('userID'); ?>" name="userID" id="userID" placeholder="输入账号编码" required>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('userID'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">账号名称 Nama</label>
                                    <input type="text" maxlength="255" class="form-control <?= ($validation->hasError('name')) ? 'is-invalid' : ''; ?>" value="<?= old('name'); ?>" name="name" id="name" placeholder="输入账号名称" required>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('name'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="roleID">角色 Peran</label>
                                    <select name="roleID" class="form-control">
                                        <?php foreach ($roles as $role) : ?>
                                            <option value="<?= $role['roleID'] ?>"><?= $role['roleName'] . ' - ' . $role['authDesc']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('roleID'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password">密码 Password</label>
                                    <input type="password" min="0" max="2147483647" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" value="<?= old('password'); ?>" name="password" id="password" placeholder="输入密码" required>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('password'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="passConfirm">重复密码 Ulangi Password</label>
                                    <input type="password" min="0" max="2147483647" class="form-control <?= ($validation->hasError('passConfirm')) ? 'is-invalid' : ''; ?>" value="<?= old('passConfirm'); ?>" name="passConfirm" id="passConfirm" placeholder="重复输入密码" required>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('passConfirm'); ?>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="float-sm-right">
                                    <a class="btn btn-secondary" href="<?= base_url('/admin/user'); ?>">
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

</script>
<?= $this->endSection() ?>