<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
        <a href="<?= base_url('/'); ?>" class="navbar-brand">
            <img src="<?= base_url(); ?>/img/logo.png" alt="点餐系统" class="brand-image img-circle elevation-3" style="width: 32;">
            <span class="brand-text font-weight-light">点餐系统</span>
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php if (session()->has('logged_in')) : ?>
            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                <ul class="navbar-nav ">
                    <li class="nav-item">
                        <a href="<?= base_url('/'); ?>" class="nav-link"><i class="fas fa-home"></i> 主页 Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/logout'); ?>" class="nav-link"><i class="fas fa-sign-out-alt"></i> 登出 Keluar</a>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
</nav>