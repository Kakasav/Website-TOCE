<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-header bg-white border-bottom">
  <div class="container-xl py-3">
    <div class="row align-items-center">
      <div class="col-auto">
        <?= anchor('/', '<i class="ti ti-arrow-left me-1"></i> Kembali', ['class' => 'btn btn-outline-secondary btn-sm']) ?>
      </div>
      <div class="col-auto">
        <?php if (!empty($game['gambar'])): ?>
          <img src="<?= base_url('uploads/games/' . $game['gambar']) ?>"
            alt="<?= esc($game['nama_game']) ?>"
            style="width:52px; height:52px; object-fit:contain; border-radius:12px;">
        <?php else: ?>
          <div style="width:52px; height:52px; background:linear-gradient(135deg,#6366f1,#8b5cf6);
                border-radius:12px; display:flex; align-items:center; justify-content:center;
                color:white; font-weight:bold; font-size:1.1rem;">
            <?= strtoupper(substr($game['nama_game'], 0, 2)) ?>
          </div>
        <?php endif; ?>
      </div>
      <div class="col">
        <h2 class="page-title mb-0"><?= esc($game['nama_game']) ?></h2>
        <span class="text-muted small"><?= esc($game['publisher']) ?></span>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl py-4">

    <?php if (! session()->get('user_id')): ?>
      <div class="alert alert-warning alert-dismissible mb-4" role="alert">
        <i class="ti ti-alert-triangle me-2"></i>
        <?= anchor(url_to('AuthController::login'), 'Masuk', ['class' => 'alert-link']) ?> terlebih dahulu untuk melakukan top-up.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <div class="card shadow-sm">
      <div class="card-header">
        <h3 class="card-title">
          <i class="ti ti-diamond me-2 text-primary"></i>Pilih Paket
        </h3>
        <div class="card-options text-muted small">
          Klik paket untuk langsung checkout
        </div>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <?php foreach ($packages as $pkg): ?>
            <div class="col-6 col-md-4 col-lg-3">

              <?php if (session()->get('user_id')): ?>
                <?= anchor(
                  url_to('HomeController::checkout') . '?item_id=' . $pkg['id'],
                  '
                <div class="card-body text-center py-3">
                  ' . ($pkg['jumlah'] > 0 ? '<div class="fs-2 fw-bold text-primary">' . number_format($pkg['jumlah']) . '</div>' : '') . '
                  <div class="text-muted small mb-2">' . esc($pkg['nama_paket']) . '</div>
                  <div class="fw-bold">Rp ' . number_format($pkg['harga'], 0, ',', '.') . '</div>
                </div>
                ',
                  ['class' => 'card h-100 package-card text-decoration-none text-dark']
                ) ?>
              <?php else: ?>
                <?= anchor(
                  url_to('AuthController::login'),
                  '
                <div class="card-body text-center py-3">
                  ' . ($pkg['jumlah'] > 0 ? '<div class="fs-2 fw-bold text-primary">' . number_format($pkg['jumlah']) . '</div>' : '') . '
                  <div class="text-muted small mb-2">' . esc($pkg['nama_paket']) . '</div>
                  <div class="fw-bold">Rp ' . number_format($pkg['harga'], 0, ',', '.') . '</div>
                </div>
                ',
                  ['class' => 'card h-100 package-card text-decoration-none text-dark']
                ) ?>
              <?php endif; ?>

            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

  </div>
</div>

<style>
  .package-card {
    border: 2px solid #e6ebf5;
    transition: all .2s;
    cursor: pointer;
  }

  .package-card:hover {
    border-color: #6366f1;
    background: #f0f0ff !important;
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(99, 102, 241, .15);
  }
</style>

<?= $this->endSection() ?>