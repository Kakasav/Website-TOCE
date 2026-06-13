<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
  <title><?= $title ?? 'Masuk — TOCE' ?></title>
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
        <h2 class="h2 text-center mb-4">Masuk ke Akun</h2>

        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger" role="alert">
          <i class="ti ti-alert-circle me-2"></i><?= session()->getFlashdata('error') ?>
        </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success" role="alert">
          <i class="ti ti-check me-2"></i><?= session()->getFlashdata('success') ?>
        </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger" role="alert">
          <ul class="mb-0">
            <?php foreach (session()->getFlashdata('errors') as $e): ?>
            <li><?= esc($e) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>

        <?= form_open(url_to('AuthController::loginProcess'), ['method' => 'post']) ?>
          <div class="mb-3">
            <label class="form-label">Username atau Email</label>
            <input type="text" name="username"
              class="form-control <?= session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['username']) ? 'is-invalid' : '' ?>"
              placeholder="username / email"
              value="<?= old('username') ?>" autofocus required>
            <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['username'])): ?>
            <div class="invalid-feedback"><?= session()->getFlashdata('errors')['username'] ?></div>
            <?php endif; ?>
          </div>
          <div class="mb-2">
            <label class="form-label">Password</label>
            <input type="password" name="password"
              class="form-control <?= session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['password']) ? 'is-invalid' : '' ?>"
              placeholder="••••••••" required>
            <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['password'])): ?>
            <div class="invalid-feedback"><?= session()->getFlashdata('errors')['password'] ?></div>
            <?php endif; ?>
          </div>
          <div class="form-footer">
            <button type="submit" class="btn w-100" style="background:#6366f1;color:#fff;">
              <i class="ti ti-login me-1"></i> Masuk
            </button>
          </div>
        <?= form_close() ?>
      </div>
    </div>

    <div class="text-center text-muted mt-3">
      Belum punya akun? <?= anchor(url_to('AuthController::register'), 'Daftar sekarang') ?>
    </div>

  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
</body>
</html>