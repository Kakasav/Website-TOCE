<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Kelola Pengguna</h2>
      </div>
      <div class="col-auto">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddAdmin">
          <i class="ti ti-shield-plus me-1"></i> Tambah Admin
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
            <tr>
              <th>ID</th>
              <th>Username</th>
              <th>Email</th>
              <th>Role</th>
              <th>Order</th>
              <th>Bergabung</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $u): ?>
              <tr>
                <td class="text-muted"><?= $u['id'] ?></td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <?php if (!empty($u['photo']) && file_exists(FCPATH . 'uploads/users/' . $u['photo'])): ?>
                      <img src="<?= base_url('uploads/users/' . $u['photo']) ?>"
                        class="avatar avatar-sm rounded-circle"
                        style="width:32px;height:32px;object-fit:cover;">
                    <?php else: ?>
                      <span class="avatar avatar-sm bg-<?= $u['role'] === 'admin' ? 'warning' : 'primary' ?>-lt rounded-circle"
                        style="display:flex;align-items:center;justify-content:center;">
                        <i class="ti ti-<?= $u['role'] === 'admin' ? 'shield' : 'user' ?>"></i>
                      </span>
                    <?php endif; ?>
                    <span class="fw-bold"><?= esc($u['username']) ?></span>
                  </div>
                </td>
                <td class="text-muted"><?= esc($u['email']) ?></td>
                <td>
                  <span class="badge bg-<?= $u['role'] === 'admin' ? 'warning' : 'primary' ?>-lt text-<?= $u['role'] === 'admin' ? 'warning' : 'primary' ?>">
                    <?= ucfirst($u['role']) ?>
                  </span>
                </td>
                <td><?= $u['total_orders'] ?> pesanan</td>
                <td class="text-muted small"><?= date('d M Y', strtotime($u['created_at'])) ?></td>
                <td>
                  <?php if ($u['id'] !== (int)session()->get('user_id') && $u['role'] !== 'admin'): ?>
                    <?= anchor(
                      base_url('/admin/users/delete/' . $u['id']),
                      '<i class="ti ti-trash me-1"></i> Hapus',
                      ['class' => 'btn btn-sm btn-outline-danger', 'data-confirm' => "Hapus user '{$u['username']}'?"]
                    ) ?>
                  <?php else: ?>
                    <span class="text-muted small">—</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah Admin -->
<div class="modal modal-blur fade" id="modalAddAdmin" tabindex="-1">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="ti ti-shield-plus me-2 text-warning"></i>Tambah Akun Admin</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="<?= base_url('/admin/users/store') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label required">Username</label>
            <input type="text" name="username" class="form-control" required placeholder="adminbaru" minlength="3">
          </div>
          <div class="mb-3">
            <label class="form-label required">Email</label>
            <input type="email" name="email" class="form-control" required placeholder="admin@toce.com">
          </div>
          <div class="mb-3">
            <label class="form-label required">Password</label>
            <input type="password" name="password" class="form-control" required placeholder="Min. 6 karakter" minlength="6">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-warning ms-auto">
            <i class="ti ti-shield-plus me-1"></i> Buat Admin
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>