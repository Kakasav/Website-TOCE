<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
  <title><?= $title ?? 'TOCE — Top Up Center' ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.19.0/tabler-icons.min.css"/>
  <style>
    body { background-color: #f4f6fb; }
    .game-card { transition: transform .2s, box-shadow .2s; text-decoration: none; color: inherit; }
    .game-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(99,102,241,.18) !important; color: inherit; }
    .game-icon-box { width: 64px; height: 64px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; background: linear-gradient(135deg, #6366f1, #8b5cf6); }
    .package-card { cursor: pointer; border: 2px solid #e6ebf5; transition: all .2s; }
    .package-card:hover { border-color: #6366f1; }
    .package-card.selected { border-color: #6366f1; background: #f0f0ff; }
    .btn-toce { background: #6366f1; color: #fff; border: none; }
    .btn-toce:hover { background: #4f46e5; color: #fff; }
    
    /* Tambahan untuk avatar/profile picture */
    .avatar-img {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      object-fit: cover;
    }
    .avatar-placeholder {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #6366f1, #8b5cf6);
      color: white;
      font-size: 14px;
      font-weight: bold;
    }
  </style>
</head>
<body class="antialiased">

<!-- Navbar -->
<div class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top">
  <div class="container-xl">
    <a href="<?= base_url('/') ?>" class="navbar-brand d-flex align-items-center gap-2 fw-bold">
      <i class="ti ti-bolt text-primary fs-2"></i> TOCE
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar-menu">
      <div class="navbar-nav ms-auto align-items-center gap-2">
        <a href="<?= base_url('/') ?>" class="nav-link">Top Up</a>
        <?php if (session()->get('user_id')): ?>
          <a href="<?= base_url('/orders') ?>" class="nav-link">Pesanan Saya</a>
          <?php if (session()->get('role') === 'admin'): ?>
            <a href="<?= base_url('/admin') ?>" class="btn btn-sm btn-warning">Admin Panel</a>
          <?php endif; ?>
          <div class="nav-item dropdown">
            <a href="#" class="nav-link d-flex align-items-center gap-1 text-reset" data-bs-toggle="dropdown">
              
              <!-- MODIFIKASI: Tampilkan profile picture atau placeholder -->
              <?php 
              $profile_picture = session()->get('profile_picture');
              $username = session()->get('username');
              $initial = $username ? strtoupper(substr($username, 0, 1)) : 'U';
              ?>
              
              <?php if (!empty($profile_picture) && file_exists(FCPATH . 'uploads/users/' . $profile_picture)): ?>
                <!-- Tampilkan foto profil dari database -->
                <img src="<?= base_url('uploads/users/' . $profile_picture) ?>" 
                     class="avatar-img rounded-circle" 
                     alt="<?= esc($username) ?>">
              <?php else: ?>
                <!-- Tampilkan placeholder dengan inisial atau icon -->
                <div class="avatar-placeholder">
                  <?= $initial ?>
                </div>
              <?php endif; ?>
              
              <span class="d-none d-md-inline"><?= esc($username) ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
              <a href="<?= base_url('/profile') ?>" class="dropdown-item">
                <i class="ti ti-user-circle me-2"></i> Profil Saya
              </a>
              <a href="<?= base_url('/orders') ?>" class="dropdown-item">
                <i class="ti ti-list me-2"></i> Pesanan Saya
              </a>
              <div class="dropdown-divider"></div>
              <a href="<?= base_url('/logout') ?>" class="dropdown-item text-danger">
                <i class="ti ti-logout me-2"></i> Keluar
              </a>
            </div>
          </div>
        <?php else: ?>
          <a href="<?= base_url('/login') ?>" class="btn btn-sm btn-toce">Masuk</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

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
<?php $flashErrors = session()->getFlashdata('errors'); ?>
<?php if (!empty($flashErrors)): ?>
<div class="container-xl pt-3">
  <div class="alert alert-danger alert-dismissible" role="alert">
    <ul class="mb-0">
      <?php foreach ($flashErrors as $e): ?>
        <li><?= esc($e) ?></li>
      <?php endforeach; ?>
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
</div>
<?php endif; ?>

<!-- Page Content -->
<?= $this->renderSection('content') ?>

<!-- Footer -->
<footer class="footer footer-transparent d-print-none mt-auto border-top">
  <div class="container-xl">
    <div class="row align-items-center text-center">
      <div class="col-12">
        <span class="text-muted">&copy; <?= date('Y') ?> <strong>TOCE</strong> &mdash; Top Up Center</span>
      </div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
<script src="<?= base_url('/assets/script.js') ?>"></script>
</body>
</html>