<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-edit mr-2"></i> Edit User: <?= esc($user['username']) ?>
                </h3>
            </div>

            <?= form_open('admin/user/update/' . $user['id']) ?>
            <div class="card-body">

                <!-- Username -->
                <div class="form-group">
                    <label>Username <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        value="<?= set_value('username', $user['username']) ?>"
                        required
                    >
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label>Email <span class="text-danger">*</span></label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="<?= set_value('email', $user['email']) ?>"
                        required
                    >
                </div>

                <!-- Password (opsional saat edit) -->
                <div class="form-group">
                    <label>Password Baru</label>
                    <input
                        type="text"
                        name="password"
                        class="form-control"
                        placeholder="Kosongkan jika tidak ingin ganti password"
                    >
                    <small class="form-text text-muted">
                        <i class="fas fa-info-circle mr-1"></i>
                        Jika diisi: minimal 8 karakter, harus ada huruf kapital dan angka.
                    </small>
                    <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['password'])): ?>
                        <div class="text-danger small mt-1">
                            <?= session()->getFlashdata('errors')['password'] ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Role -->
                <div class="form-group">
                    <label>Role <span class="text-danger">*</span></label>
                    <select name="role" class="form-control" required>
                        <option value="user"  <?= $user['role'] === 'user'  ? 'selected' : '' ?>>User</option>
                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>

                <!-- Info tanggal daftar pakai date() -->
                <div class="text-muted small">
                    <i class="fas fa-calendar-alt mr-1"></i>
                    Terdaftar sejak: <?= date('d F Y, H:i', strtotime($user['created_at'])) ?>
                </div>

            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Batal
                </a>
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-save mr-1"></i> Update
                </button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>