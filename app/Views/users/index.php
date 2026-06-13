<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">
            <i class="fas fa-users mr-2"></i> Daftar User
        </h3>
        <a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Tambah User
        </a>
    </div>

    <!-- Form Search pakai form_helper + url_helper -->
    <div class="card-body border-bottom">
        <?= form_open('admin/users', ['method' => 'get', 'class' => 'd-flex gap-2']) ?>
            <input
                type="text"
                name="search"
                class="form-control form-control-sm mr-2"
                placeholder="Cari username atau email..."
                value="<?= esc($keyword ?? '') ?>"
                style="max-width: 300px"
            >
            <button type="submit" class="btn btn-sm btn-secondary mr-1">
                <i class="fas fa-search"></i>
            </button>
            <?php if (!empty($keyword)): ?>
                <a href="<?= base_url('admin/users') ?>" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-times"></i> Reset
                </a>
            <?php endif; ?>
        <?= form_close() ?>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped">
            <thead class="thead-dark">
                <tr>
                    <th width="5%">#</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <!-- date helper -->
                    <th>Terdaftar</th>
                    <th width="15%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $i => $user): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td>
                                <i class="fas fa-user-circle mr-1 text-muted"></i>
                                <?= esc($user['username']) ?>
                                <?php if ($user['id'] == session()->get('user_id')): ?>
                                    <span class="badge badge-info ml-1">Kamu</span>
                                <?php endif; ?>
                            </td>
                            <td><?= esc($user['email']) ?></td>
                            <td>
                                <span class="badge badge-<?= $user['role'] === 'admin' ? 'danger' : 'primary' ?>">
                                    <?= ucfirst($user['role']) ?>
                                </span>
                            </td>
                            <!-- Pakai date helper CI4 via PHP date() -->
                            <td>
                                <i class="fas fa-calendar-alt mr-1 text-muted"></i>
                                <?= date('d M Y', strtotime($user['created_at'])) ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('admin/users/edit/' . $user['id']) ?>"
                                   class="btn btn-xs btn-warning mr-1" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if ($user['id'] != session()->get('user_id')): ?>
                                    <a href="<?= base_url('admin/users/delete/' . $user['id']) ?>"
                                       class="btn btn-xs btn-danger"
                                       title="Hapus"
                                       onclick="return confirm('Yakin hapus user <?= esc($user['username']) ?>?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-xs btn-secondary" disabled title="Tidak bisa hapus akun sendiri">
                                        <i class="fas fa-lock"></i>
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                            <?= !empty($keyword) ? 'Tidak ada user yang cocok dengan pencarian.' : 'Belum ada data user.' ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="card-footer text-muted">
        Total: <strong><?= count($users) ?></strong> user
    </div>
</div>

<?= $this->endSection() ?>