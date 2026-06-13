<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-header bg-white border-bottom">
  <div class="container-xl py-4">
    <div class="row align-items-center">
      <div class="col-auto">
        <i class="ti ti-bolt text-primary" style="font-size:2.5rem;"></i>
      </div>
      <div class="col">
        <h1 class="page-title mb-0">Top Up Game Instan</h1>
        <p class="text-muted mb-0">Isi diamond dan mata uang game favoritmu dengan cepat dan aman.</p>
      </div>
      <?php if (! session()->get('user_id')): ?>
        <div class="col-auto">
          <a href="<?= base_url('/login') ?>" class="btn btn-toce">
            <i class="ti ti-login me-1"></i> Masuk untuk Top Up
          </a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl py-4">
    <div class="row mb-3">
      <div class="col">
        <h3 class="mb-0"><i class="ti ti-device-gamepad-2 me-2 text-primary"></i>Pilih Game</h3>
      </div>
    </div>
    <div class="row g-3">
      <?php foreach ($games as $game): ?>
        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
          <a href="<?= base_url('topup/' . $game['id']) ?>" class="card game-card h-100 shadow-sm text-decoration-none">
            <div class="card-body text-center d-flex flex-column align-items-center gap-2 py-4">

              <!-- Gambar logo game -->
              <!-- Ganti bagian game-icon-box ini -->
              <div class="game-icon-box mb-1">
                <?php if (!empty($game['gambar'])): ?>
                  <img src="<?= base_url('uploads/games/' . $game['gambar']) ?>"
                    alt="<?= esc($game['nama_game']) ?>"
                    class="game-logo-img">
                <?php else: ?>
                  <div class="game-icon-fallback">
                    <?= strtoupper(substr($game['nama_game'], 0, 2)) ?>
                  </div>
                <?php endif; ?>
              </div>

              <div class="fw-bold"><?= esc($game['nama_game']) ?></div>
              <div class="text-muted small"><?= esc($game['publisher']) ?></div>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>


<style>
  .game-icon-fallback {
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 1.2rem;
  }

  .game-card {
    transition: all 0.3s ease;
    border: 2px solid #eef2ff;
    border-radius: 16px;
  }

  .game-card:hover {
    transform: translateY(-5px);
    border-color: #6366f1;
    box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.2);
  }

  .game-logo-img {
    width: 64px;
    height: 64px;
    object-fit: contain;
    border-radius: 16px;
  }

  .game-icon-box {
    width: 70px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
  }


  .game-logo-img {
    background-color: white;
    padding: 4px;
  }
</style>

<?= $this->endSection() ?>