<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Dashboard</h2>
        <div class="text-muted mt-1">Selamat datang, <strong><?= esc(session()->get('username')) ?></strong>!</div>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">
    <!-- Stats -->
    <div class="row row-deck row-cards mb-4">
      <div class="col-sm-6 col-lg-3">
        <div class="card">
          <div class="card-body">
            <div class="subheader">Total Pesanan</div>
            <div class="h1 mb-3"><?= number_format($total_orders) ?></div>
            <div class="d-flex mb-2">
              <div><?= $pending ?> pending</div>
              <div class="ms-auto text-success"><?= $sukses ?> sukses</div>
            </div>
            <div class="progress mb-2" style="height:4px;">
              <div class="progress-bar bg-success"
                   style="width:<?= $total_orders ? round($sukses / $total_orders * 100) : 0 ?>%"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="card">
          <div class="card-body">
            <div class="subheader">Total Revenue</div>
            <div class="h1 mb-0 mt-3" style="font-size:1.4rem;">
              Rp <?= number_format($total_revenue, 0, ',', '.') ?>
            </div>
            <div class="text-muted mt-1 small">dari order sukses</div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="card">
          <div class="card-body">
            <div class="subheader">Pengguna</div>
            <div class="h1 mb-0 mt-3"><?= number_format($total_users) ?></div>
            <div class="text-muted mt-1 small">user terdaftar</div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="card">
          <div class="card-body">
            <div class="subheader">Game Aktif</div>
            <div class="h1 mb-0 mt-3"><?= $total_games ?></div>
            <div class="text-muted mt-1 small">game tersedia</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Orders -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="ti ti-clock me-2"></i>Pesanan Terbaru</h3>
        <div class="card-options">
          <a href="<?= base_url('/admin/orders') ?>" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-vcenter table-hover card-table">
          <thead>
            <tr><th>#</th><th>User</th><th>Game</th><th>Paket</th><th>Total</th><th>Status</th><th>Waktu</th></tr>
          </thead>
          <tbody>
            <?php foreach ($recent_orders as $o):
              $statusClass = ['sukses' => 'success', 'pending' => 'warning', 'gagal' => 'danger'];
              $cls = $statusClass[$o['status']] ?? 'secondary';
            ?>
            <tr>
              <td class="text-muted"><?= $o['id'] ?></td>
              <td><?= esc($o['username']) ?></td>
              <td class="fw-bold"><?= esc($o['nama_game']) ?></td>
              <td><?= esc($o['nama_paket']) ?></td>
              <td>Rp <?= number_format($o['total_harga'], 0, ',', '.') ?></td>
              <td>
                <span class="badge bg-<?= $cls ?>-lt text-<?= $cls ?>">
                  <?= ucfirst($o['status']) ?>
                </span>
              </td>
              <td class="text-muted small"><?= date('d M, H:i', strtotime($o['created_at'])) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>