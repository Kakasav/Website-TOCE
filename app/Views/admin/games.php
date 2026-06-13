<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col"><h2 class="page-title">Kelola Game</h2></div>
      <div class="col-auto">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
          <i class="ti ti-plus me-1"></i> Tambah Game
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
            <tr><th>ID</th><th>Gambar</th><th>Nama Game</th><th>Publisher</th><th>Status</th><th>Dibuat</th><th>Aksi</th></tr>
          </thead>
          <tbody>
            <?php foreach ($games as $g): ?>
            <tr>
              <td class="text-muted"><?= $g['id'] ?></td>
              <td>
                <?php if (!empty($g['gambar'])): ?>
                  <img src="<?= base_url('uploads/games/' . $g['gambar']) ?>"
                       width="40" height="40" style="object-fit:contain; border-radius:8px;">
                <?php else: ?>
                  <span class="text-muted">—</span>
                <?php endif; ?>
              </td>
              <td class="fw-bold"><?= esc($g['nama_game']) ?></td>
              <td><?= esc($g['publisher']) ?></td>
              <td>
                <span class="badge bg-<?= $g['status'] === 'aktif' ? 'success' : 'secondary' ?>-lt
                                      text-<?= $g['status'] === 'aktif' ? 'success' : 'secondary' ?>">
                  <?= ucfirst($g['status']) ?>
                </span>
              </td>
              <td class="text-muted small"><?= date('d M Y', strtotime($g['created_at'])) ?></td>
              <td>
                <button class="btn btn-sm btn-outline-primary me-1"
                  onclick='openEdit(<?= json_encode($g) ?>)'>
                  <i class="ti ti-edit"></i> Edit
                </button>
                <a href="<?= base_url('/admin/games/delete/' . $g['id']) ?>"
                   class="btn btn-sm btn-outline-danger"
                   data-confirm="Hapus game '<?= esc($g['nama_game']) ?>'?">
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
        <h5 class="modal-title">Tambah Game</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="<?= base_url('/admin/games/store') ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nama Game</label>
            <input type="text" name="nama_game" class="form-control" required placeholder="Mobile Legends">
          </div>
          <div class="mb-3">
            <label class="form-label">Publisher</label>
            <input type="text" name="publisher" class="form-control" required placeholder="Moonton">
          </div>
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
              <option value="aktif">Aktif</option>
              <option value="nonaktif">Nonaktif</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label required">Gambar Game</label>
            <input type="file" name="gambar" class="form-control"
                   accept="image/jpeg,image/png,image/jpg" required>
            <small class="text-muted">Format: JPG, PNG, JPEG. Maks. 3MB</small>
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
        <h5 class="modal-title">Edit Game</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="editForm" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nama Game</label>
            <input type="text" name="nama_game" id="editNama" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Publisher</label>
            <input type="text" name="publisher" id="editPublisher" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" id="editStatus" class="form-select">
              <option value="aktif">Aktif</option>
              <option value="nonaktif">Nonaktif</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Ganti Gambar <span class="text-muted small">(opsional)</span></label>
            <input type="file" name="gambar" class="form-control"
                   accept="image/jpeg,image/png,image/jpg">
            <small class="text-muted">Format: JPG, PNG, JPEG. Maks. 3MB</small>
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
  document.getElementById('editNama').value      = d.nama_game;
  document.getElementById('editPublisher').value = d.publisher;
  document.getElementById('editStatus').value    = d.status;
  document.getElementById('editForm').action     = '<?= base_url('/admin/games/update/') ?>' + d.id;
  new bootstrap.Modal(document.getElementById('modalEdit')).show();
}
</script>

<?= $this->endSection() ?>