<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?= url('/') ?>" class="brand-link">
        <img src="<?= url('assets/img/logo/favicon-svg.svg') ?>" alt="Laundry Kami Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light text-uppercase">Luandry Kami</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?= url('/') ?>" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= url('riwayat_transaksi') ?>" class="nav-link">
                        <i class="nav-icon fas fa-history"></i>
                        <p>Riwayat Transaksi</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= url('karyawan') ?>" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Manage Karyawan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= url('paket') ?>" class="nav-link">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Daftar Paket</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <div class="sidebar-custom">
        <a href="<?= url('logout.php') ?>" class="btn btn-block btn-danger btn-sm">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
</aside>