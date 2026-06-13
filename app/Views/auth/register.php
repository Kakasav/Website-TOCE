<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
  <title><?= $title ?? 'Daftar — TOCE' ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.19.0/tabler-icons.min.css"/>
</head>
<body class="d-flex flex-column">
<div class="page page-center">
  <div class="container container-tight py-4">

    <div class="text-center mb-4">
      <?= anchor('/', '<i class="ti ti-bolt text-primary fs-1"></i><span class="fs-2 fw-bold ms-1">TOCE</span>', ['class' => 'navbar-brand d-flex align-items-center justify-content-center gap-2 text-decoration-none']) ?>
    </div>

    <div class="card card-md shadow-sm">
      <div class="card-body">
        <h2 class="h2 text-center mb-4">Buat Akun Baru</h2>

        <?php
          // Ambil errors sekali supaya bisa dicek per-field
          $errors = session()->getFlashdata('errors') ?? [];
        ?>

        <?php if (! empty($errors)): ?>
        <div class="alert alert-danger" role="alert">
          <ul class="mb-0">
            <?php foreach ($errors as $e): ?>
            <li><?= esc($e) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>

        <?= form_open(url_to('AuthController::registerProcess'), ['method' => 'post']) ?>
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username"
              class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>"
              placeholder="username unik" value="<?= old('username') ?>" required>
            <?php if (isset($errors['username'])): ?>
            <div class="invalid-feedback"><?= esc($errors['username']) ?></div>
            <?php endif; ?>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email"
              class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
              placeholder="email@example.com" value="<?= old('email') ?>" required>
            <?php if (isset($errors['email'])): ?>
            <div class="invalid-feedback"><?= esc($errors['email']) ?></div>
            <?php endif; ?>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password"
              class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
              placeholder="min. 6 karakter" required>
            <?php if (isset($errors['password'])): ?>
            <div class="invalid-feedback"><?= esc($errors['password']) ?></div>
            <?php endif; ?>
          </div>
          <div class="mb-3">
            <label class="form-label">Konfirmasi Password</label>
            <input type="password" name="confirm_password"
              class="form-control <?= isset($errors['confirm_password']) ? 'is-invalid' : '' ?>"
              placeholder="ulangi password" required>
            <?php if (isset($errors['confirm_password'])): ?>
            <div class="invalid-feedback"><?= esc($errors['confirm_password']) ?></div>
            <?php endif; ?>
          </div>
          <div class="form-footer">
            <button type="submit" class="btn w-100" style="background:#6366f1;color:#fff;">
              <i class="ti ti-user-plus me-1"></i> Daftar Sekarang
            </button>
          </div>
        <?= form_close() ?>
      </div>
    </div>

    <div class="text-center text-muted mt-3">
      Sudah punya akun? <?= anchor(url_to('AuthController::login'), 'Masuk') ?>
    </div>

  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
</body>
</html>