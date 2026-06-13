<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col-auto">
        <?= anchor('/admin/orders', '<i class="ti ti-arrow-left me-1"></i> Kembali', ['class' => 'btn btn-outline-secondary btn-sm']) ?>
      </div>
      <div class="col">
        <h2 class="page-title mb-0">Detail Order</h2>
        <span class="text-muted"><?= esc($order['invoice']) ?></span>
      </div>
      <!-- Quick action di header -->
      <?php if ($order['status'] === 'pending'): ?>
      <div class="col-auto d-flex gap-2">
        <?= form_open(base_url('/admin/orders/status/' . $order['id']), ['method' => 'post']) ?>
          <input type="hidden" name="status" value="sukses">
          <button type="submit" class="btn btn-success"
            onclick="return confirm('Konfirmasi order sebagai Sukses?')">
            <i class="ti ti-check me-1"></i> Konfirmasi Sukses
          </button>
        <?= form_close() ?>
        <?= form_open(base_url('/admin/orders/status/' . $order['id']), ['method' => 'post']) ?>
          <input type="hidden" name="status" value="gagal">
          <button type="submit" class="btn btn-danger"
            onclick="return confirm('Tolak order ini?')">
            <i class="ti ti-x me-1"></i> Tolak
          </button>
        <?= form_close() ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">
    <div class="row g-4">

      <!-- Info Order -->
      <div class="col-lg-7">
        <div class="card shadow-sm">
          <div class="card-header">
            <h3 class="card-title">Informasi Order</h3>
          </div>
          <div class="table-responsive">
            <table class="table table-sm table-borderless mb-0">
              <tr><td class="text-muted ps-4 py-2" style="width:35%">Invoice</td>
                  <td class="pe-4 py-2 fw-bold text-primary"><?= esc($order['invoice']) ?></td></tr>
              <tr class="bg-light"><td class="text-muted ps-4 py-2">User</td>
                  <td class="pe-4 py-2"><?= esc($order['username']) ?></td></tr>
              <tr><td class="text-muted ps-4 py-2">Game</td>
                  <td class="pe-4 py-2 fw-bold"><?= esc($order['nama_game']) ?></td></tr>
              <tr class="bg-light"><td class="text-muted ps-4 py-2">Paket</td>
                  <td class="pe-4 py-2"><?= esc($order['nama_paket']) ?></td></tr>
              <tr><td class="text-muted ps-4 py-2"><?= esc($order['label_player_id'] ?? 'ID Player') ?></td>
                  <td class="pe-4 py-2"><code><?= esc($order['id_game_player']) ?></code></td></tr>
              <?php if (! empty($order['server_id'])): ?>
              <tr class="bg-light"><td class="text-muted ps-4 py-2"><?= esc($order['label_server_id'] ?? 'Server ID') ?></td>
                  <td class="pe-4 py-2"><code><?= esc($order['server_id']) ?></code></td></tr>
              <?php endif; ?>
              <tr><td class="text-muted ps-4 py-2">Pembayaran</td>
                  <td class="pe-4 py-2"><?= esc($order['metode_bayar']) ?></td></tr>
              <tr class="bg-light border-top"><td class="ps-4 py-2 fw-bold">Total</td>
                  <td class="pe-4 py-2 fw-bold text-primary fs-5">Rp <?= number_format($order['total_harga'], 0, ',', '.') ?></td></tr>
              <tr><td class="text-muted ps-4 py-2">Status</td>
                  <td class="pe-4 py-2">
                    <?php $c = ['sukses'=>'success','pending'=>'warning','gagal'=>'danger'][$order['status']] ?? 'secondary'; ?>
                    <span class="badge bg-<?= $c ?>-lt text-<?= $c ?>"><?= ucfirst($order['status']) ?></span>
                  </td></tr>
              <tr class="bg-light"><td class="text-muted ps-4 py-2">Tanggal</td>
                  <td class="pe-4 py-2"><?= date('d M Y, H:i', strtotime($order['created_at'])) ?> WIB</td></tr>
            </table>
          </div>
        </div>
      </div>

      <!-- Bukti Pembayaran -->
      <div class="col-lg-5">
        <div class="card shadow-sm">
          <div class="card-header">
            <h3 class="card-title"><i class="ti ti-photo me-2"></i>Bukti Pembayaran</h3>
          </div>
          <div class="card-body text-center">
            <?php if (! empty($order['bukti_bayar'])): ?>
            <img src="<?= base_url('uploads/bukti/' . $order['bukti_bayar']) ?>"
              class="img-fluid rounded border" style="max-height:320px;"
              alt="Bukti Pembayaran">
            <div class="mt-2">
              <a href="<?= base_url('uploads/bukti/' . $order['bukti_bayar']) ?>" target="_blank"
                 class="btn btn-sm btn-outline-primary">
                <i class="ti ti-external-link me-1"></i> Buka Full
              </a>
            </div>
            <?php else: ?>
            <div class="py-4 text-muted">
              <i class="ti ti-photo-off" style="font-size:3rem;"></i>
              <p class="mt-2">Belum ada bukti pembayaran</p>
            </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Ubah Status Manual -->
        <div class="card shadow-sm mt-3">
          <div class="card-header">
            <h3 class="card-title">Ubah Status</h3>
          </div>
          <div class="card-body">
            <?= form_open(base_url('/admin/orders/status/' . $order['id']), ['method' => 'post', 'class' => 'd-flex gap-2']) ?>
              <select name="status" class="form-select">
                <option value="pending" <?= $order['status']==='pending' ? 'selected' : '' ?>>Pending</option>
                <option value="sukses"  <?= $order['status']==='sukses'  ? 'selected' : '' ?>>Sukses</option>
                <option value="gagal"   <?= $order['status']==='gagal'   ? 'selected' : '' ?>>Gagal</option>
              </select>
              <button type="submit" class="btn btn-primary">Simpan</button>
            <?= form_close() ?>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<?= $this->endSection() ?>