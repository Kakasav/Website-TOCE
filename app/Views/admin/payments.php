<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col"><h2 class="page-title">Metode Pembayaran</h2></div>
      <div class="col-auto">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
          <i class="ti ti-plus me-1"></i> Tambah
        </button>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="table-responsive">
        <table class="table table-vcenter table-hover card-table">
          <thead>
            <tr><th>ID</th><th>Nama Metode</th><th>Status</th><th>Aksi</th></tr>
          </thead>
          <tbody>
            <?php foreach ($payments as $pm): ?>
            <tr>
              <td class="text-muted"><?= $pm['id'] ?></td>
              <td>
                  <span class="fw-bold"><?= esc($pm['nama']) ?></span>
                </div>
              </td>
              <td>
                <?= form_open(base_url('/admin/payments/toggle/' . $pm['id']), ['method' => 'post', 'class' => 'd-inline']) ?>
                  <button type="submit"
                    class="badge bg-<?= $pm['is_aktif'] ? 'success' : 'secondary' ?>-lt text-<?= $pm['is_aktif'] ? 'success' : 'secondary' ?> border-0"
                    style="cursor:pointer;">
                    <?= $pm['is_aktif'] ? '✓ Aktif' : '✗ Nonaktif' ?>
                  </button>
                <?= form_close() ?>
              </td>
              <td>
                <?= anchor(
                  base_url('/admin/payments/delete/' . $pm['id']),
                  '<i class="ti ti-trash me-1"></i> Hapus',
                  ['class' => 'btn btn-sm btn-outline-danger', 'data-confirm' => "Hapus metode '{$pm['nama']}'?"]
                ) ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal Add -->
<div class="modal modal-blur fade" id="modalAdd" tabindex="-1">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Metode Pembayaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <?= form_open(base_url('/admin/payments/store'), ['method' => 'post']) ?>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nama Metode</label>
            <input type="text" name="nama" class="form-control" required placeholder="ShopeePay">
          </div>
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="is_aktif" class="form-select">
              <option value="1">Aktif</option>
              <option value="0">Nonaktif</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary ms-auto">Simpan</button>
        </div>
      <?= form_close() ?>
    </div>
  </div>
</div>

<?= $this->endSection() ?>