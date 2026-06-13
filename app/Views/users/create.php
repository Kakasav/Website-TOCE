<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-plus mr-2"></i> Tambah User Baru
                </h3>
            </div>

            <!-- form_open() dari form_helper, base_url() dari url_helper -->
            <?= form_open('admin/user/store') ?>
            <div class="card-body">

                <!-- Username -->
                <div class="form-group">
                    <label>Username <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        name="username"
                        class="form-control <?= session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['username']) ? 'is-invalid' : '' ?>"
                        value="<?= set_value('username') ?>"
                        placeholder="Masukkan username"
                        required
                    >
                    <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['username'])): ?>
                        <div class="invalid-feedback">
                            <?= session()->getFlashdata('errors')['username'] ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label>Email <span class="text-danger">*</span></label>
                    <input
                        type="email"
                        name="email"
                        class="form-control <?= session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['email']) ? 'is-invalid' : '' ?>"
                        value="<?= set_value('email') ?>"
                        placeholder="Masukkan email"
                        required
                    >
                    <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['email'])): ?>
                        <div class="invalid-feedback">
                            <?= session()->getFlashdata('errors')['email'] ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label>Password <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        name="password"
                        class="form-control <?= session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['password']) ? 'is-invalid' : '' ?>"
                        placeholder="Min 8 karakter, ada huruf kapital & angka"
                        required
                    >
                    <small class="form-text text-muted">
                        <i class="fas fa-info-circle mr-1"></i>
                        Minimal 8 karakter, harus mengandung huruf kapital (A-Z) dan angka (0-9).
                        Contoh: <code>Topup123</code>
                    </small>
                    <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['password'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= session()->getFlashdata('errors')['password'] ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Role -->
                <div class="form-group">
                    <label>Role <span class="text-danger">*</span></label>
                    <select name="role" class="form-control" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="user"  <?= set_value('role') === 'user'  ? 'selected' : '' ?>>User</option>
                        <option value="admin" <?= set_value('role') === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>

            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Simpan
                </button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>