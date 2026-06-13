<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-header bg-white border-bottom">
  <div class="container-xl py-3">
    <div class="row align-items-center">
      <div class="col-auto">
        <?= anchor(url_to('HomeController::topup', $item['game_id']), '<i class="ti ti-arrow-left me-1"></i> Kembali', ['class' => 'btn btn-outline-secondary btn-sm']) ?>
      </div>
      <div class="col">
        <h2 class="page-title mb-0">Checkout</h2>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl py-4">
    <?php $errors = session()->getFlashdata('errors') ?? []; ?>

    <?= form_open_multipart(url_to('HomeController::checkoutProcess'), ['method' => 'post']) ?>
    <input type="hidden" name="item_id" value="<?= $item['id'] ?>">

    <div class="row g-4">
      <div class="col-lg-8">

        <!-- Data Akun Game -->
        <div class="card shadow-sm mb-4">
          <div class="card-header">
            <h3 class="card-title"><i class="ti ti-user me-2 text-primary"></i>Data Akun Game</h3>
          </div>
          <div class="card-body">

            <!-- User ID / Player ID -->
            <div class="mb-3">
              <label class="form-label">
                <?= esc($item['label_player_id'] ?? 'User ID') ?>
                <span class="text-danger">*</span>
              </label>
              <input type="text" name="id_game_player"
                class="form-control <?= isset($errors['id_game_player']) ? 'is-invalid' : '' ?>"
                placeholder="Masukkan <?= esc($item['label_player_id'] ?? 'User ID') ?>"
                value="<?= old('id_game_player') ?>" required maxlength="100">
              <?php if (isset($errors['id_game_player'])): ?>
                <div class="invalid-feedback"><?= esc($errors['id_game_player']) ?></div>
              <?php endif; ?>
            </div>

        
            <?php if (isset($item['needs_server_id']) && $item['needs_server_id']): ?>
              <div class="mb-3">
                <label class="form-label">
                  <?= esc($item['label_server_id'] ?? 'Server ID') ?>
                  <span class="text-danger">*</span>
                </label>
                <input type="text" name="server_id"
                  class="form-control <?= isset($errors['server_id']) ? 'is-invalid' : '' ?>"
                  value="<?= old('server_id') ?>" required>
                <?php if (isset($errors['server_id'])): ?>
                  <div class="invalid-feedback"><?= esc($errors['server_id']) ?></div>
                <?php endif; ?>
              </div>
            <?php endif; ?>

            <div class="alert alert-info py-2 mb-0">
              <i class="ti ti-shield-check me-1"></i>
              Pastikan ID sudah benar. Kesalahan ID tidak dapat direfund.
            </div>
          </div>
        </div>

        <!-- Metode Pembayaran -->
        <div class="card shadow-sm mb-4">
          <div class="card-header">
            <h3 class="card-title"><i class="ti ti-credit-card me-2 text-primary"></i>Metode Pembayaran</h3>
          </div>
          <div class="card-body">
            <?php if (isset($errors['payment_id'])): ?>
              <div class="alert alert-danger py-2 mb-3">
                <i class="ti ti-alert-circle me-1"></i><?= esc($errors['payment_id']) ?>
              </div>
            <?php endif; ?>
            <div class="row g-2">
              <?php foreach ($payments as $pm): ?>
                <div class="col-6 col-md-4">
                  <label class="payment-label w-100" style="cursor:pointer;">
                    <input type="radio" name="payment_id" value="<?= $pm['id'] ?>" class="d-none"
                      <?= old('payment_id') == $pm['id'] ? 'checked' : '' ?>>
                    <div class="card border text-center py-3 px-2" style="transition:all .2s;">
                      <i class="ti ti-wallet fs-2 text-primary mb-1"></i>
                      <div class="fw-bold small"><?= esc($pm['nama']) ?></div>
                    </div>
                  </label>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        <!-- Upload Bukti Pembayaran -->
        <div class="card shadow-sm">
          <div class="card-header">
            <h3 class="card-title"><i class="ti ti-upload me-2 text-primary"></i>Bukti Pembayaran</h3>
          </div>
          <div class="card-body">
            <div class="mb-2">
              <label class="form-label">Upload Screenshot Transfer / E-Wallet</label>
              <input type="file" name="bukti_bayar" class="form-control"
                accept="image/jpeg,image/png,image/jpg,image/webp" required>
              <small class="text-muted">Format: JPG, PNG, WEBP. Maks 2MB. <span class="text-danger">*Wajib diupload</span></small>
            </div>
            <div class="alert alert-warning py-2 mb-0">
              <i class="ti ti-clock me-1"></i>
              Order akan berstatus <strong>Pending</strong> hingga admin memverifikasi pembayaran (maks 1x24 jam).
            </div>
          </div>
        </div>

      </div>

      <!-- Ringkasan Order -->
      <div class="col-lg-4">
        <div class="card shadow-sm sticky-top" style="top:80px;">
          <div class="card-header">
            <h3 class="card-title"><i class="ti ti-receipt me-2 text-primary"></i>Ringkasan Order</h3>
          </div>
          <div class="card-body">
            <table class="table table-sm table-borderless mb-0">
              <tr>
                <td class="text-muted">Game</td>
                <td class="text-end fw-bold"><?= esc($item['nama_game']) ?></td>
              </tr>
              <tr>
                <td class="text-muted">Paket</td>
                <td class="text-end"><?= esc($item['nama_paket']) ?></td>
              </tr>
              <?php if ($item['jumlah'] > 0): ?>
                <tr>
                  <td class="text-muted">Jumlah</td>
                  <td class="text-end"><?= number_format($item['jumlah']) ?></td>
                </tr>
              <?php endif; ?>
              <tr class="border-top">
                <td class="fw-bold">Total</td>
                <td class="text-end fw-bold text-primary fs-5">
                  Rp <?= number_format($item['harga'], 0, ',', '.') ?>
                </td>
              </tr>
            </table>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-toce w-100">
              <i class="ti ti-bolt me-1"></i> Buat Order
            </button>
            <p class="text-muted text-center mt-2 small mb-0">
              Dengan menekan tombol ini, kamu menyetujui syarat layanan kami.
            </p>
          </div>
        </div>
      </div>
    </div>
    <?= form_close() ?>
  </div>
</div>

<script>
  document.querySelectorAll('.payment-label input[type=radio]').forEach(radio => {
    const card = radio.closest('.payment-label').querySelector('.card');
    radio.addEventListener('change', () => {
      document.querySelectorAll('.payment-label .card').forEach(c => c.classList.remove('border-primary', 'bg-primary-lt'));
      if (radio.checked) card.classList.add('border-primary', 'bg-primary-lt');
    });
    if (radio.checked) card.classList.add('border-primary', 'bg-primary-lt');
  });
</script>

<?= $this->endSection() ?>