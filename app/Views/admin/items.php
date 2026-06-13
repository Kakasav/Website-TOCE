<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col"><h2 class="page-title">Paket Top Up</h2></div>
      <div class="col-auto">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
          <i class="ti ti-plus me-1"></i> Tambah Paket
        </button>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">
    <!-- Filter -->
    <div class="mb-3">
      <form method="GET" action="<?= base_url('/admin/items') ?>" class="d-flex gap-2">
        <select name="game_id" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
          <option value="">Semua Game</option>
          <?php foreach ($games as $g): ?>
          <option value="<?= $g['id'] ?>" <?= $filterGame === $g['id'] ? 'selected' : '' ?>>
            <?= esc($g['nama_game']) ?>
          </option>
          <?php endforeach; ?>
        </select>
      </form>
    </div>

    <div class="card">
      <div class="table-responsive">
        <table class="table table-vcenter table-hover card-table">
          <thead>
            <tr><th>ID</th><th>Game</th><th>Nama Paket</th><th>Jumlah</th><th>Harga</th><th>Aksi</th></tr>
          </thead>
          <tbody>
            <?php foreach ($items as $item): ?>
            <tr>
              <td class="text-muted"><?= $item['id'] ?></td>
              <td><?= esc($item['nama_game']) ?></td>
              <td class="fw-bold"><?= esc($item['nama_paket']) ?></td>
              <td><?= $item['jumlah'] > 0 ? number_format($item['jumlah']) : '<span class="text-muted">—</span>' ?></td>
              <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
              <td>
                <button class="btn btn-sm btn-outline-primary me-1"
                  onclick='openEdit(<?= json_encode($item) ?>)'>
                  <i class="ti ti-edit"></i> Edit
                </button>
                <a href="<?= base_url('/admin/items/delete/' . $item['id']) ?>"
                   class="btn btn-sm btn-outline-danger"
                   data-confirm="Hapus paket ini?">
                  <i class="ti ti-trash"></i> Hapus
                </a>
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
        <h5 class="modal-title">Tambah Paket</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="<?= base_url('/admin/items/store') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Game</label>
            <select name="game_id" class="form-select" required>
              <?php foreach ($games as $g): ?>
              <option value="<?= $g['id'] ?>" <?= $filterGame === $g['id'] ? 'selected' : '' ?>>
                <?= esc($g['nama_game']) ?>
              </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Nama Paket</label>
            <input type="text" name="nama_paket" class="form-control" required placeholder="86 Diamond">
          </div>
          <div class="mb-3">
            <label class="form-label">Jumlah <span class="text-muted">(0 jika tidak berlaku)</span></label>
            <input type="number" name="jumlah" class="form-control" value="0" min="0">
          </div>
          <div class="mb-3">
            <label class="form-label">Harga (Rp)</label>
            <input type="number" name="harga" class="form-control" required min="0" step="500" placeholder="19000">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary ms-auto">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit -->
<div class="modal modal-blur fade" id="modalEdit" tabindex="-1">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Paket</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="editForm" method="POST">
        <?= csrf_field() ?>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Game</label>
            <select name="game_id" id="editGameId" class="form-select">
              <?php foreach ($games as $g): ?>
              <option value="<?= $g['id'] ?>"><?= esc($g['nama_game']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Nama Paket</label>
            <input type="text" name="nama_paket" id="editNama" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Jumlah</label>
            <input type="number" name="jumlah" id="editJumlah" class="form-control" min="0">
          </div>
          <div class="mb-3">
            <label class="form-label">Harga (Rp)</label>
            <input type="number" name="harga" id="editHarga" class="form-control" min="0" step="500">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary ms-auto">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function openEdit(d) {
  document.getElementById('editGameId').value = d.game_id;
  document.getElementById('editNama').value   = d.nama_paket;
  document.getElementById('editJumlah').value = d.jumlah;
  document.getElementById('editHarga').value  = d.harga;
  document.getElementById('editForm').action  = '<?= base_url('/admin/items/update/') ?>' + d.id;
  new bootstrap.Modal(document.getElementById('modalEdit')).show();
}
</script>

<?= $this->endSection() ?>