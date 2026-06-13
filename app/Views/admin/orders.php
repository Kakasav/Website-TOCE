<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col"><h2 class="page-title">Kelola Pesanan</h2></div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">

    <!-- Filter tabs -->
    <div class="card mb-3">
      <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
          <?php
            $tabs = ['' => 'Semua', 'pending' => 'Pending', 'sukses' => 'Sukses', 'gagal' => 'Gagal'];
            foreach ($tabs as $val => $label):
          ?>
          <li class="nav-item">
            <?= anchor(
              base_url('/admin/orders') . ($val ? '?status=' . $val : ''),
              $label,
              ['class' => 'nav-link ' . ($filterStatus === $val ? 'active' : '')]
            ) ?>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <div class="card">
      <div class="table-responsive">
        <table class="table table-vcenter table-hover card-table">
          <thead>
            <tr>
              <th>Invoice</th>
              <th>User</th>
              <th>Game & Paket</th>
              <th>Total</th>
              <th>Bukti</th>
              <th>Status</th>
              <th>Tanggal</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orders as $o):
              $cls = ['sukses' => 'success', 'pending' => 'warning', 'gagal' => 'danger'];
              $c   = $cls[$o['status']] ?? 'secondary';
            ?>
            <tr>
              <td><code class="text-primary small"><?= esc($o['invoice']) ?></code></td>
              <td><?= esc($o['username']) ?></td>
              <td>
                <div class="fw-bold"><?= esc($o['nama_game']) ?></div>
                <div class="text-muted small"><?= esc($o['nama_paket']) ?></div>
              </td>
              <td>Rp <?= number_format($o['total_harga'], 0, ',', '.') ?></td>
              <td>
                <?php if (! empty($o['bukti_bayar'])): ?>
                <a href="<?= base_url('uploads/bukti/' . $o['bukti_bayar']) ?>" target="_blank">
                  <img src="<?= base_url('uploads/bukti/' . $o['bukti_bayar']) ?>"
                    class="rounded border" style="width:48px;height:48px;object-fit:cover;" alt="Bukti">
                </a>
                <?php else: ?>
                <span class="text-muted small">—</span>
                <?php endif; ?>
              </td>
              <td>
                <span class="badge bg-<?= $c ?>-lt text-<?= $c ?>">
                  <?= ucfirst($o['status']) ?>
                </span>
              </td>
              <td class="text-muted small"><?= date('d M, H:i', strtotime($o['created_at'])) ?></td>
              <td>
                <div class="d-flex gap-1 align-items-center">
                  <!-- Quick confirm button untuk pending -->
                  <?php if ($o['status'] === 'pending'): ?>
                  <?= form_open(base_url('/admin/orders/status/' . $o['id']), ['method' => 'post', 'class' => 'd-inline']) ?>
                    <input type="hidden" name="status" value="sukses">
                    <button type="submit" class="btn btn-sm btn-success"
                      onclick="return confirm('Konfirmasi order ini sebagai Sukses?')">
                      <i class="ti ti-check"></i>
                    </button>
                  <?= form_close() ?>
                  <?= form_open(base_url('/admin/orders/status/' . $o['id']), ['method' => 'post', 'class' => 'd-inline']) ?>
                    <input type="hidden" name="status" value="gagal">
                    <button type="submit" class="btn btn-sm btn-danger"
                      onclick="return confirm('Tolak order ini?')">
                      <i class="ti ti-x"></i>
                    </button>
                  <?= form_close() ?>
                  <?php else: ?>
                  <!-- Ubah status manual -->
                  <?= form_open(base_url('/admin/orders/status/' . $o['id']), ['method' => 'post', 'class' => 'd-flex gap-1']) ?>
                    <select name="status" class="form-select form-select-sm" style="width:100px;">
                      <option value="pending" <?= $o['status']==='pending' ? 'selected' : '' ?>>Pending</option>
                      <option value="sukses"  <?= $o['status']==='sukses'  ? 'selected' : '' ?>>Sukses</option>
                      <option value="gagal"   <?= $o['status']==='gagal'   ? 'selected' : '' ?>>Gagal</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-outline-primary">
                      <i class="ti ti-check"></i>
                    </button>
                  <?= form_close() ?>
                  <?php endif; ?>

                  <?= anchor(base_url('/admin/orders/' . $o['id']), '<i class="ti ti-eye"></i>', ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <?php if ($pager): ?>
      <div class="card-footer d-flex justify-content-center">
        <?= $pager->links('admin_orders', 'tabler_pagination') ?>
      </div>
      <?php endif; ?>
    </div>

  </div>
</div>

<?= $this->endSection() ?>