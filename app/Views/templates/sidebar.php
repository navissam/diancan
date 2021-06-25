<aside class="main-sidebar elevation-4 sidebar-dark-primary">
    <!-- Brand Logo -->
    <a href="<?= base_url('/admin'); ?>" class="brand-link">
        <img src="<?= base_url(); ?>/img/logo.png" alt="点餐系统" class="brand-image img-circle elevation-3 bg-white" style="width: 32;">
        <span class="brand-text font-weight-light">点餐系统</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url(); ?>/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="<?= base_url('/admin'); ?>" class="d-block">
                    <?= session()->get('name'); ?>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent text-sm" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <?php if (in_array(session()->get('roleID'), ['super', 'admin'])) : ?>
                    <li class="nav-item has-treeview <?= isset($active['food']) ? 'menu-open' : ''; ?>">
                        <a href="#" class="nav-link <?= isset($active['food']) ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-utensils"></i>
                            <p>
                                菜肴管理 Masakan
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('/admin/food/ordinary'); ?>" class="nav-link <?= isset($active['food']['ordinary']) ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>平日菜肴 Masakan Harian</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('/admin/food/special') ?>" class="nav-link <?= isset($active['food']['special']) ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>特别菜肴 Masakan Spesial</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('/admin/food/restore') ?>" class="nav-link <?= isset($active['food']['restore']) ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>还原菜肴 Memulihkan Masakan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('/admin/food/export') ?>" class="nav-link <?= isset($active['food']['export']) ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>导出菜肴 Export Masakan</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (in_array(session()->get('roleID'), ['super', 'admin', 'cashier'])) : ?>
                    <li class="nav-item">
                        <a href="<?= base_url('/admin/payment') ?>" class="nav-link <?= isset($active['payment']) ? 'active' : ''; ?>">
                            <i class="fas fa-cash-register nav-icon"></i>
                            <p>付款 Pembayaran</p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (in_array(session()->get('roleID'), ['super', 'admin', 'chef'])) : ?>
                    <li class="nav-item">
                        <a href="<?= base_url('/admin/orders/detail') ?>" class="nav-link <?= isset($active['orderdetail']) ? 'active' : ''; ?>">
                            <i class="fas fa-file-invoice nav-icon"></i>
                            <p>订单明细 Rincian Pesanan
                            </p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (in_array(session()->get('roleID'), ['super', 'admin'])) : ?>
                    <li class="nav-item has-treeview <?= isset($active['orders']) ? 'menu-open' : ''; ?>">
                        <a href="#" class="nav-link <?= isset($active['orders']) ? 'active' : ''; ?>">
                            <i class="fas fa-file-invoice nav-icon"></i>
                            <p>订单历史 Riwayat Pesanan
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('/admin/orders') ?>" class="nav-link <?= isset($active['orders']['orders']) ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>订单号分组 Kode</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('/admin/orders/cus') ?>" class="nav-link <?= isset($active['orders']['customer']) ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>消费者分组 Pelanggan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('/admin/orders/food') ?>" class="nav-link <?= isset($active['orders']['food']) ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>菜品分组 Masakan</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array(session()->get('roleID'), ['super', 'admin'])) : ?>
                    <li class="nav-item has-treeview <?= isset($active['report']) ? 'menu-open' : ''; ?>">
                        <a href="#" class="nav-link <?= isset($active['report']) ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>
                                报表 Laporan
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('/admin/report/income') ?>" class="nav-link <?= isset($active['report']['income']) ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>销售统计 Penjualan</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview <?= isset($active['var']) ? 'menu-open' : ''; ?>">
                        <a href="#" class="nav-link <?= isset($active['var']) ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                设置 Pengaturan
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('/admin/variable/changetimelimit'); ?>" class="nav-link <?= isset($active['var']['time']) ? 'active' : ''; ?>">
                                    <i class="far fa-clock nav-icon"></i>
                                    <p>点餐时间 Waktu Pemesanan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('/admin/variable/changedeliverycost'); ?>" class="nav-link <?= isset($active['var']['dCost']) ? 'active' : ''; ?>">
                                    <i class="fas fa-hand-holding-usd nav-icon"></i>
                                    <p>外送费 Biaya Pengantaran</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('/admin/variable/announcement'); ?>" class="nav-link <?= isset($active['var']['announcement']) ? 'active' : ''; ?>">
                                    <i class="fas fa-bullhorn nav-icon"></i>
                                    <p>公告 Pengumuman</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (in_array(session()->get('roleID'), ['super', 'admin'])) : ?>
                    <li class="nav-item">
                        <a href="<?= base_url('/admin/customer'); ?>" class="nav-link <?= isset($active['customer']) ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-user-friends"></i>
                            <p>
                                消费者管理 Customer
                            </p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (in_array(session()->get('roleID'), ['super'])) : ?>
                    <li class="nav-item has-treeview">
                        <a href="<?= base_url('/admin/user') ?>" class="nav-link <?= isset($active['user']) ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p>
                                账号管理 Akun Admin
                            </p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (in_array(session()->get('roleID'), ['super', 'admin'])) : ?>
                    <li class="nav-item has-treeview <?= isset($active['syslog']) ? 'menu-open' : ''; ?>">
                        <a href="#" class="nav-link <?= isset($active['syslog']) ? 'active' : ''; ?>">
                            <i class="fas fa-clipboard nav-icon"></i>
                            <p>系统日志 Catatan Sistem
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('/admin/admlog') ?>" class="nav-link <?= isset($active['syslog']['admlog']) ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>管理员日志 Sistem Admin</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('/admin/cuslog') ?>" class="nav-link <?= isset($active['syslog']['cuslog']) ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>消费者日志 Sistem Pelanggan</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <li class="nav-header"></li>
                <li class="nav-item">
                    <a href="<?= base_url('/admin/account/changepass') ?>" class="nav-link <?= isset($active['pass']) ? 'active' : ''; ?>">
                        <i class="fas fa-key nav-icon"></i>
                        <p>更改密码 Ganti Password</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('/logout') ?>" class="nav-link">
                        <i class="fas fa-sign-out-alt nav-icon"></i>
                        <p>登出 Keluar</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>