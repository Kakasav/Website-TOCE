<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-header bg-white border-bottom">
  <div class="container-xl py-3">
    <div class="row align-items-center">
      <div class="col-auto">
        <?= anchor(url_to('HomeController::orders'), '<i class="ti ti-arrow-left me-1"></i> Kembali', ['class' => 'btn btn-outline-secondary btn-sm']) ?>
      </div>
      <div class="col">
        <h2 class="page-title mb-0">Detail Order</h2>
        <span class="text-muted small"><?= esc($order['invoice']) ?></span>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl py-4">
    <div class="row g-4 justify-content-center">
      <div class="col-lg-7">

        <!-- Status Banner -->
        <?php
          $statusInfo = [
            'pending' => ['color' => 'warning', 'icon' => 'ti-clock',        'msg' => 'Menunggu verifikasi pembayaran oleh admin.'],
            'sukses'  => ['color' => 'success', 'icon' => 'ti-circle-check', 'msg' => 'Pembayaran terverifikasi. Item sudah dikirim ke akunmu.'],
            'gagal'   => ['color' => 'danger',  'icon' => 'ti-circle-x',     'msg' => 'Order gagal atau pembayaran tidak valid.'],
          ];
          $si = $statusInfo[$order['status']] ?? $statusInfo['pending'];
        ?>
        <div class="alert alert-<?= $si['color'] ?> d-flex align-items-center gap-3 mb-4">
          <i class="ti <?= $si['icon'] ?> fs-2 flex-shrink-0"></i>
          <div>
            <strong><?= ucfirst($order['status']) ?></strong> — <?= $si['msg'] ?>
          </div>
        </div>

        <!-- Detail Card -->
        <div class="card shadow-sm">
          <div class="card-header">
            <h3 class="card-title"><i class="ti ti-receipt me-2 text-primary"></i>Informasi Order</h3>
          </div>
          <div class="table-responsive">
            <table class="table table-sm table-borderless mb-0">
              <tr>
                <td class="text-muted ps-4 py-2" style="width:40%">No. Invoice</td>
                <td class="pe-4 py-2 fw-bold text-primary"><?= esc($order['invoice']) ?></td>
              </tr>
              <tr class="bg-light">
                <td class="text-muted ps-4 py-2">Game</td>
                <td class="pe-4 py-2 fw-bold"><?= esc($order['nama_game']) ?></td>
              </tr>
              <tr>
                <td class="text-muted ps-4 py-2">Paket</td>
                <td class="pe-4 py-2"><?= esc($order['nama_paket']) ?></td>
              </tr>
              <tr class="bg-light">
                <td class="text-muted ps-4 py-2"><?= esc($order['label_player_id'] ?? 'ID Player') ?></td>
                <td class="pe-4 py-2"><code><?= esc($order['id_game_player']) ?></code></td>
              </tr>
              <?php if (! empty($order['server_id'])): ?>
              <tr>
                <td class="text-muted ps-4 py-2"><?= esc($order['label_server_id'] ?? 'Server ID') ?></td>
                <td class="pe-4 py-2"><code><?= esc($order['server_id']) ?></code></td>
              </tr>
              <?php endif; ?>
              <tr class="bg-light">
                <td class="text-muted ps-4 py-2">Metode Bayar</td>
                <td class="pe-4 py-2"><?= esc($order['metode_bayar']) ?></td>
              </tr>
              <?php if (! empty($order['bukti_bayar'])): ?>
              <tr>
                <td class="text-muted ps-4 py-2">Bukti Bayar</td>
                <td class="pe-4 py-2">
                  <a href="<?= base_url('uploads/bukti/' . $order['bukti_bayar']) ?>" target="_blank">
                    <img src="<?= base_url('uploads/bukti/' . $order['bukti_bayar']) ?>"
                      class="rounded border" style="max-height:100px;cursor:pointer;"
                      alt="Bukti Bayar">
                  </a>
                </td>
              </tr>
              <?php endif; ?>
              <tr class="border-top bg-light">
                <td class="ps-4 py-2 fw-bold">Total Pembayaran</td>
                <td class="pe-4 py-2 fw-bold text-primary fs-5">
                  Rp <?= number_format($order['total_harga'], 0, ',', '.') ?>
                </td>
              </tr>
              <tr>
                <td class="text-muted ps-4 py-2">Tanggal Order</td>
                <td class="pe-4 py-2"><?= date('d M Y, H:i', strtotime($order['created_at'])) ?> WIB</td>
              </tr>
            </table>
          </div>
          <div class="card-footer">
            <?= anchor('/', '<i class="ti ti-bolt me-1"></i> Top Up Lagi', ['class' => 'btn btn-toce']) ?>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>