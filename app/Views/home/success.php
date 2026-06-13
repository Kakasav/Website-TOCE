<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-body">
  <div class="container-xl py-5">
    <div class="row justify-content-center">
      <div class="col-md-7 col-lg-6">

        <!-- Notifikasi prominent -->
        <div class="alert alert-warning d-flex align-items-center gap-3 mb-4 p-3">
          <i class="ti ti-clock fs-2 text-warning flex-shrink-0"></i>
          <div>
            <strong>Order Menunggu Verifikasi</strong><br>
            <small>Admin akan memproses ordermu dalam 1x24 jam setelah bukti pembayaran diterima.</small>
          </div>
        </div>

        <div class="card shadow-sm">
          <div class="card-body py-4 text-center">
            <div class="mb-3">
              <div class="d-inline-flex align-items-center justify-content-center bg-success-lt rounded-circle"
                   style="width:72px;height:72px;">
                <i class="ti ti-circle-check text-success" style="font-size:2.2rem;"></i>
              </div>
            </div>
            <h2 class="mb-0">Order Diterima!</h2>
            <p class="text-muted mt-1 mb-0">
              No. Invoice: <strong class="text-primary"><?= esc($order['invoice']) ?></strong>
            </p>
          </div>

          <div class="table-responsive">
            <table class="table table-sm table-borderless px-3 mb-0">
              <tbody>
                <tr>
                  <td class="text-muted ps-4">Game</td>
                  <td class="text-end pe-4"><?= esc($order['nama_game']) ?></td>
                </tr>
                <tr>
                  <td class="text-muted ps-4">Paket</td>
                  <td class="text-end pe-4"><?= esc($order['nama_paket']) ?></td>
                </tr>
                <tr>
                  <td class="text-muted ps-4"><?= esc($order['label_player_id'] ?? 'ID Player') ?></td>
                  <td class="text-end pe-4"><code><?= esc($order['id_game_player']) ?></code></td>
                </tr>
                <?php if (! empty($order['server_id'])): ?>
                <tr>
                  <td class="text-muted ps-4"><?= esc($order['label_server_id'] ?? 'Server ID') ?></td>
                  <td class="text-end pe-4"><code><?= esc($order['server_id']) ?></code></td>
                </tr>
                <?php endif; ?>
                <tr>
                  <td class="text-muted ps-4">Pembayaran</td>
                  <td class="text-end pe-4"><?= esc($order['metode_bayar']) ?></td>
                </tr>
                <?php if (! empty($order['bukti_bayar'])): ?>
                <tr>
                  <td class="text-muted ps-4">Bukti Bayar</td>
                  <td class="text-end pe-4">
                    <a href="<?= base_url('uploads/bukti/' . $order['bukti_bayar']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                      <i class="ti ti-photo me-1"></i> Lihat
                    </a>
                  </td>
                </tr>
                <?php endif; ?>
                <tr class="border-top">
                  <td class="fw-bold ps-4">Total</td>
                  <td class="text-end fw-bold text-primary fs-5 pe-4">
                    Rp <?= number_format($order['total_harga'], 0, ',', '.') ?>
                  </td>
                </tr>
                <tr>
                  <td class="text-muted ps-4">Status</td>
                  <td class="text-end pe-4">
                    <?php
                      $cls = ['sukses' => 'success', 'pending' => 'warning', 'gagal' => 'danger'];
                      $c   = $cls[$order['status']] ?? 'secondary';
                    ?>
                    <span class="badge bg-<?= $c ?>-lt text-<?= $c ?>">
                      <?= ucfirst($order['status']) ?>
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="card-footer d-flex gap-2">
            <?= anchor(url_to('HomeController::orders'), 'Lihat Semua Pesanan', ['class' => 'btn btn-outline-secondary w-50']) ?>
            <?= anchor('/', 'Top Up Lagi', ['class' => 'btn btn-toce w-50']) ?>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>