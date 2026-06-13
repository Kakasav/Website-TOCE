<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-header bg-white border-bottom">
  <div class="container-xl py-3">
    <h2 class="page-title mb-0">
      <i class="ti ti-user-circle me-2 text-primary"></i>Profil Saya
    </h2>
  </div>
</div>

<div class="page-body">
  <div class="container-xl py-4">
    <div class="row g-4">

      <!-- Kolom Kiri: Foto Profil -->
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Foto Profil</h3>
          </div>
          <div class="card-body text-center">
            <?php
            $photoUrl = !empty($user['photo'])
              ? base_url('uploads/users/' . $user['photo'])
              : 'https://ui-avatars.com/api/?name=' . urlencode($user['username']) . '&background=6366f1&color=fff&size=120&rounded=true';
            ?>
            <img src="<?= $photoUrl ?>"
              class="rounded-circle mb-3"
              style="width:120px;height:120px;object-fit:cover;border:3px solid #fff;box-shadow:0 0 20px rgba(0,0,0,0.1);"
              id="profile-photo">
            <div class="mb-2">
              <label class="btn btn-primary btn-sm" for="photo-input">
                <i class="ti ti-camera me-1"></i> Ganti Foto
              </label>
              <?php if (!empty($user['photo'])): ?>
                <button class="btn btn-danger btn-sm" id="delete-photo-btn">
                  <i class="ti ti-trash me-1"></i> Hapus
                </button>
              <?php endif; ?>
              <input type="file" id="photo-input" accept="image/jpeg,image/png,image/jpg" style="display:none;">
            </div>
            <small class="text-muted">Max 3MB (JPG/PNG)</small>
          </div>
        </div>
      </div>

      <!-- Kolom Kanan: Informasi Akun -->
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Informasi Akun</h3>
          </div>
          <div class="card-body">

            <?php if (!empty($errors)): ?>
              <div class="alert alert-danger alert-dismissible">
                <ul class="mb-0">
                  <?php foreach ($errors as $e): ?>
                    <li><?= esc($e) ?></li>
                  <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            <?php endif; ?>

            <form action="<?= url_to('HomeController::profileUpdate') ?>" method="post">
              <?= csrf_field() ?>

              <div class="mb-3">
                <label class="form-label required">Username</label>
                <input type="text" name="username" id="inputUsername" class="form-control"
                  value="<?= old('username', esc($user['username'])) ?>"
                  required minlength="3" maxlength="50">
                <div class="invalid-feedback" id="feedback-username"></div>
              </div>

              <div class="mb-3">
                <label class="form-label required">Email</label>
                <input type="email" name="email" id="inputEmail" class="form-control"
                  value="<?= old('email', esc($user['email'])) ?>"
                  required>
                <div class="invalid-feedback" id="feedback-email"></div>
              </div>

              <div class="mb-3">
                <label class="form-label">Role</label>
                <input type="text" class="form-control" value="<?= ucfirst($user['role']) ?>" disabled>
              </div>

              <div class="mb-3">
                <label class="form-label">No. Telepon</label>
                <input type="text" name="phone" id="inputPhone" class="form-control"
                  value="<?= old('phone', esc($user['phone'] ?? '')) ?>"
                  pattern="[0-9]{10,13}">
                <div class="invalid-feedback" id="feedback-phone"></div>
              </div>

              <div class="mb-3">
                <label class="form-label">Bio</label>
                <textarea name="bio" class="form-control" rows="3" placeholder="Ceritakan tentang Anda..."><?= old('bio', esc($user['bio'] ?? '')) ?></textarea>
              </div>

              <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="address" class="form-control" rows="2" placeholder="Alamat lengkap..."><?= old('address', esc($user['address'] ?? '')) ?></textarea>
              </div>

              <hr>

              <h4 class="mb-3 fs-5">Ganti Password <span class="text-muted small fw-normal">(opsional)</span></h4>

              <div class="mb-3">
                <label class="form-label">Password Lama</label>
                <input type="password" name="current_password" class="form-control"
                  placeholder="Kosongkan jika tidak ganti password">
              </div>

              <div class="mb-3">
                <label class="form-label">Password Baru</label>
                <input type="password" name="new_password" class="form-control" placeholder="Min. 6 karakter">
              </div>

              <div class="mb-4">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="confirm_password" class="form-control" placeholder="Ulangi password baru">
              </div>

              <button type="submit" class="btn btn-primary w-100">
                <i class="ti ti-device-floppy me-1"></i> Simpan Perubahan
              </button>

            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

  // ── Foto Upload ──────────────────────────────────────────────
  const photoInput  = document.getElementById('photo-input');
  const profilePhoto = document.getElementById('profile-photo');

  if (photoInput) {
    photoInput.addEventListener('change', function (e) {
      const file = e.target.files[0];
      if (!file) return;
      if (file.size > 3 * 1024 * 1024) { alert('Ukuran foto maksimal 3MB'); return; }

      const formData = new FormData();
      formData.append('photo', file);

      fetch('<?= site_url('home/uploadPhoto') ?>', { method: 'POST', body: formData })
        .then(r => r.json())
        .then(data => {
          if (data.success) { profilePhoto.src = data.photo_url + '?t=' + Date.now(); location.reload(); }
          else alert('Error: ' + data.message);
        })
        .catch(() => alert('Terjadi kesalahan saat upload.'));
    });
  }

  const deleteBtn = document.getElementById('delete-photo-btn');
  if (deleteBtn) {
    deleteBtn.addEventListener('click', function () {
      if (!confirm('Yakin hapus foto profil?')) return;
      fetch('<?= site_url('home/deletePhoto') ?>', { method: 'POST', headers: { 'Content-Type': 'application/json' } })
        .then(r => r.json())
        .then(data => { if (data.success) location.reload(); else alert('Error: ' + data.message); });
    });
  }

  // ── Real-time Validation ──────────────────────────────────────
  function setValid(input, feedbackId) {
    input.classList.remove('is-invalid');
    input.classList.add('is-valid');
    document.getElementById(feedbackId).textContent = '';
  }

  function setInvalid(input, feedbackId, msg) {
    input.classList.remove('is-valid');
    input.classList.add('is-invalid');
    document.getElementById(feedbackId).textContent = msg;
    document.getElementById(feedbackId).style.display = 'block';
  }

  function clearState(input, feedbackId) {
    input.classList.remove('is-valid', 'is-invalid');
    document.getElementById(feedbackId).textContent = '';
  }

  // Username
  const usernameInput = document.getElementById('inputUsername');
  usernameInput.addEventListener('input', function () {
    if (this.value.trim().length === 0) clearState(this, 'feedback-username');
    else if (this.value.trim().length < 3) setInvalid(this, 'feedback-username', 'Username minimal 3 karakter.');
    else setValid(this, 'feedback-username');
  });

  // Email
  const emailInput = document.getElementById('inputEmail');
  emailInput.addEventListener('input', function () {
    if (this.value.trim().length === 0) clearState(this, 'feedback-email');
    else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value)) setInvalid(this, 'feedback-email', 'Format email tidak valid, contoh: nama@domain.com');
    else setValid(this, 'feedback-email');
  });

  // Phone
  const phoneInput = document.getElementById('inputPhone');
  phoneInput.addEventListener('input', function () {
    if (this.value.trim().length === 0) clearState(this, 'feedback-phone');
    else if (!/^[0-9]{10,13}$/.test(this.value)) setInvalid(this, 'feedback-phone', 'Nomor telepon harus angka 10-13 digit.');
    else setValid(this, 'feedback-phone');
  });

  // Block submit kalau masih invalid
  document.querySelector('form').addEventListener('submit', function (e) {
    const emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value);
    const usnOk   = usernameInput.value.trim().length >= 3;
    const phoneVal = phoneInput.value.trim();
    const phoneOk  = phoneVal === '' || /^[0-9]{10,13}$/.test(phoneVal);

    if (!usnOk)   { e.preventDefault(); setInvalid(usernameInput, 'feedback-username', 'Username minimal 3 karakter.'); usernameInput.focus(); return; }
    if (!emailOk) { e.preventDefault(); setInvalid(emailInput, 'feedback-email', 'Format email tidak valid, contoh: nama@domain.com'); emailInput.focus(); return; }
    if (!phoneOk) { e.preventDefault(); setInvalid(phoneInput, 'feedback-phone', 'Nomor telepon harus angka 10-13 digit.'); phoneInput.focus(); return; }
  });

});
</script>

<?= $this->endSection() ?>