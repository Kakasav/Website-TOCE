<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <title><?= $title ?? 'Admin — TOCE' ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.19.0/tabler-icons.min.css" />
</head>

<body class="antialiased">
  <div class="wrapper">

    <!-- Top Navbar -->
    <header class="navbar navbar-expand-md navbar-light d-print-none">
      <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a href="<?= base_url('/admin') ?>" class="navbar-brand d-flex align-items-center gap-2 fw-bold">
          <i class="ti ti-bolt text-primary fs-2"></i> TOCE Admin
        </a>
        <div class="navbar-nav flex-row order-md-last">
          <div class="nav-item dropdown">
            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown">
              <?php
              $adminPhoto = session()->get('profile_picture');
              $adminUsername = session()->get('username');
              $adminInitial = strtoupper(substr($adminUsername, 0, 1));
              ?>
              <?php if (!empty($adminPhoto) && file_exists(FCPATH . 'uploads/users/' . $adminPhoto)): ?>
                <img src="<?= base_url('uploads/users/' . $adminPhoto) ?>"
                  class="avatar avatar-sm rounded-circle"
                  style="width:32px;height:32px;object-fit:cover;"
                  alt="<?= esc($adminUsername) ?>">
              <?php else: ?>
                <span class="avatar avatar-sm rounded-circle"
                  style="background:linear-gradient(135deg,#6366f1,#8b5cf6);color:white;font-weight:bold;">
                  <?= $adminInitial ?>
                </span>
              <?php endif; ?>
              <div class="d-none d-xl-block ps-2">
                <div class="fw-bold"><?= esc(session()->get('username')) ?></div>
                <div class="small text-muted">Administrator</div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
              <a href="<?= base_url('/') ?>" class="dropdown-item">
                <i class="ti ti-external-link me-2"></i> Lihat Toko
              </a>
              <div class="dropdown-divider"></div>
              <a href="<?= base_url('/logout') ?>" class="dropdown-item text-danger">
                <i class="ti ti-logout me-2"></i> Keluar
              </a>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Sidebar -->
    <?php $current = service('router')->methodName();
    $uri = uri_string(); ?>
    <aside class="navbar-vertical navbar-expand-lg navbar-light">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="sidebar-menu">
          <ul class="navbar-nav pt-lg-3">
            <li class="nav-item">
              <a class="nav-link <?= str_starts_with($uri, 'admin') && ! str_contains($uri, '/') ? 'active' : (str_ends_with($uri, 'admin') ? 'active' : '') ?>"
                href="<?= base_url('/admin') ?>">
                <span class="nav-link-icon"><i class="ti ti-layout-dashboard"></i></span>
                <span class="nav-link-title">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= str_contains($uri, 'admin/games') ? 'active' : '' ?>"
                href="<?= base_url('/admin/games') ?>">
                <span class="nav-link-icon"><i class="ti ti-device-gamepad-2"></i></span>
                <span class="nav-link-title">Game</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= str_contains($uri, 'admin/items') ? 'active' : '' ?>"
                href="<?= base_url('/admin/items') ?>">
                <span class="nav-link-icon"><i class="ti ti-diamond"></i></span>
                <span class="nav-link-title">Paket Top Up</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= str_contains($uri, 'admin/orders') ? 'active' : '' ?>"
                href="<?= base_url('/admin/orders') ?>">
                <span class="nav-link-icon"><i class="ti ti-clipboard-list"></i></span>
                <span class="nav-link-title">Pesanan</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= str_contains($uri, 'admin/users') ? 'active' : '' ?>"
                href="<?= base_url('/admin/users') ?>">
                <span class="nav-link-icon"><i class="ti ti-users"></i></span>
                <span class="nav-link-title">Pengguna</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= str_contains($uri, 'admin/payments') ? 'active' : '' ?>"
                href="<?= base_url('/admin/payments') ?>">
                <span class="nav-link-icon"><i class="ti ti-credit-card"></i></span>
                <span class="nav-link-title">Metode Pembayaran</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </aside>

    <!-- Page wrapper -->
    <div class="page-wrapper">

      <!-- Flash Messages -->
      <?php if (session()->getFlashdata('success')): ?>
        <div class="container-xl pt-3">
          <div class="alert alert-success alert-dismissible" role="alert">
            <i class="ti ti-check me-2"></i><?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        </div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('error')): ?>
        <div class="container-xl pt-3">
          <div class="alert alert-danger alert-dismissible" role="alert">
            <i class="ti ti-alert-circle me-2"></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        </div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('errors')): ?>
        <div class="container-xl pt-3">
          <div class="alert alert-danger alert-dismissible" role="alert">
            <ul class="mb-0">
              <?php foreach (session()->getFlashdata('errors') as $e): ?>
                <li><?= esc($e) ?></li>
              <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        </div>
      <?php endif; ?>

      <?= $this->renderSection('content') ?>

    </div><!-- .page-wrapper -->
  </div><!-- .wrapper -->
  <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
  <script src="<?= base_url('/assets/script.js') ?>"></script>
</body>

</html>