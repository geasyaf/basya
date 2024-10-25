<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url() ?>Dashboard" class="brand-link" style="display: flex; align-items: center; height: 70px;">
        <img src="<?= base_url() ?>/assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle style="opacity: .8; margin-right: 10px;">
        <span class="brand-text font-weight-light">Basya Investama</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/upload/foto_user/<?= $session->foto ?>" class="img-circle" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= $session->nama ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="<?= base_url() ?>" class="nav-link <?= ($menu['cek_page'] == 'dashboard') ? 'active' : ''; ?>">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <?php foreach ($data_menu['main_menu'] as $main_menu) {
                    if ($main_menu['type_menu'] == 'main') { ?>
                        <li class="nav-item has-treeview <?= ($menu['cek_main'] == $main_menu['nav_act']) ? 'menu-open' : ''; ?>">
                            <a href="#" class="nav-link <?= ($menu['cek_main'] == $main_menu['nav_act']) ? 'active' : ''; ?>">
                                <i class="nav-icon <?= $main_menu['icon']; ?>"></i>
                                <p>
                                    <?= $main_menu['page_name']; ?>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php foreach ($data_menu['page_menu'] as $page_menu) {
                                    if ($main_menu['id'] == $page_menu['parent_id']) { ?>
                                        <li class="nav-item">
                                            <a href="<?= base_url() ?><?= $page_menu['url']; ?>" class="nav-link <?= ($menu['cek_page'] == $page_menu['nav_act']) ? 'active' : ''; ?>">
                                                <i class="<?= $page_menu['icon']; ?> nav-icon"></i>
                                                <p><?= $page_menu['page_name']; ?></p>
                                            </a>
                                        </li>
                                <?php }
                                } ?>
                            </ul>
                        </li>
                    <?php } elseif ($main_menu['type_menu'] == 'page') { ?>
                        <li class="nav-item">
                            <a href="<?= base_url() ?><?= $main_menu['url']; ?>" class="nav-link <?= ($menu['cek_page'] == $main_menu['nav_act']) ? 'active' : ''; ?>">
                                <i class="<?= $main_menu['icon']; ?> nav-icon"></i>
                                <p><?= $main_menu['page_name']; ?></p>
                            </a>
                        </li>
                <?php }
                } ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>