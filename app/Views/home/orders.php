<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-header bg-white border-bottom">
  <div class="container-xl py-3">
    <div class="row align-items-center">
      <div class="col">
        <h2 class="page-title mb-0"><i class="ti ti-list me-2 text-primary"></i>Pesanan Saya</h2>
      </div>
      <div class="col-auto">
        <?= anchor('/', '<i class="ti ti-plus me-1"></i> Top Up Baru', ['class' => 'btn btn-sm btn-toce']) ?>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl py-4">
    <?php if (empty($orders)): ?>
    <div class="card shadow-sm">
      <div class="card-body text-center py-5">
        <i class="ti ti-shopping-cart-off text-muted" style="font-size:3rem;"></i>
        <h3 class="mt-2">Belum ada pesanan</h3>
        <p class="text-muted">Ayo top up sekarang!</p>
        <?= anchor('/', 'Top Up Sekarang', ['class' => 'btn btn-toce']) ?>
      </div>
    </div>
    <?php else: ?>
    <div class="card shadow-sm">
      <div class="table-responsive">
        <table class="table table-vcenter table-hover card-table">
          <thead>
            <tr>
              <th>Invoice</th>
              <th>Game</th>
              <th>Paket</th>
              <th>Total</th>
              <th>Status</th>
              <th>Tanggal</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orders as $o):
              $cls = ['sukses' => 'success', 'pending' => 'warning', 'gagal' => 'danger'];
              $c   = $cls[$o['status']] ?? 'secondary';
            ?>
            <tr>
              <td><code class="text-primary"><?= esc($o['invoice']) ?></code></td>
              <td class="fw-bold"><?= esc($o['nama_game']) ?></td>
              <td><?= esc($o['nama_paket']) ?></td>
              <td class="fw-bold">Rp <?= number_format($o['total_harga'], 0, ',', '.') ?></td>
              <td>
                <span class="badge bg-<?= $c ?>-lt text-<?= $c ?>">
                  <?= ucfirst($o['status']) ?>
                </span>
              </td>
              <td class="text-muted small"><?= date('d M Y, H:i', strtotime($o['created_at'])) ?></td>
              <td>
                <?= anchor(url_to('HomeController::orderDetail', $o['id']), '<i class="ti ti-eye me-1"></i> Detail', ['class' => 'btn btn-sm btn-outline-primary']) ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <?php if ($pager): ?>
      <div class="card-footer d-flex align-items-center justify-content-center">
        <?= $pager->links('orders', 'tabler_pagination') ?>
      </div>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>
</div>

<?= $this->endSection() ?>