<?php
$pageTitle = 'Users - Task Management System';
$activePage = 'users';
require __DIR__ . '/../partials/header.php';
?>

<div class="app-layout">
    <?php require __DIR__ . '/../partials/sidebar.php'; ?>

    <div class="app-main">
        <?php require __DIR__ . '/../partials/topbar.php'; ?>

        <main class="dashboard-container">
            <div class="page-header">
                <h1 class="page-title">Manajemen User</h1>
                <button type="button" class="btn-primary" data-modal-open="user-form-modal">+ User Baru</button>
            </div>

            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($users)): ?>
                            <tr><td colspan="5" class="empty-row">Belum ada user.</td></tr>
                        <?php else: ?>
                            <?php foreach ($users as $user): ?>
                                <tr data-user-id="<?= $user['id'] ?>">
                                    <td><?= htmlspecialchars($user['name']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><span class="badge <?= $user['role'] === 'Admin' ? 'badge-role-admin' : 'badge-role-member' ?>"><?= $user['role'] ?></span></td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" <?= $user['is_active'] ? 'checked' : '' ?>
                                                data-user-toggle="<?= $user['id'] ?>"
                                                <?= (int) $user['id'] === (int) $_SESSION['user_id'] ? 'disabled' : '' ?> />
                                            <span class="switch-slider"></span>
                                        </label>
                                        <span class="status-text"><?= $user['is_active'] ? 'Aktif' : 'Nonaktif' ?></span>
                                    </td>
                                    <td>
                                        <button type="button" class="link-detail" data-user-edit="<?= $user['id'] ?>">Edit</button>
                                        <button type="button" class="link-detail" data-user-reset="<?= $user['id'] ?>">Reset Password</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<dialog id="user-form-modal" class="modal-box" data-reset-on-close>
    <div class="modal-header">
        <span class="modal-title">Tambah User Baru</span>
        <button type="button" class="modal-close" data-modal-close>&times;</button>
    </div>
    <form id="user-form" novalidate autocomplete="off">
        <div class="form-group">
            <label for="user-name">Nama</label>
            <div class="field-wrap">
                <input type="text" id="user-name" name="name" required autocomplete="off" />
                <span class="field-error" data-error-for="name"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="user-email">Email</label>
            <div class="field-wrap">
                <input type="email" id="user-email" name="email" required />
                <span class="field-error" data-error-for="email"></span>
            </div>
        </div>
                <div class="form-group">
            <label for="user-password">Password</label>
            <div class="field-wrap">
                <div class="password-field">
                    <input type="password" id="user-password" name="password" autocomplete="new-password"/>
                    <button type="button" class="password-toggle" data-password-toggle="user-password" aria-label="Lihat password"></button>
                </div>
                <span class="field-error" data-error-for="password"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="user-role">Role</label>
            <select id="user-role" name="role">
                <option value="Member" selected>Member</option>
                <option value="Admin">Admin</option>
            </select>
            <span class="field-error" data-error-for="role"></span>
        </div>
        <button type="submit" class="btn-primary">Simpan User</button>
    </form>
</dialog>

<dialog id="user-edit-modal" class="modal-box" data-reset-on-close>
    <div class="modal-header">
        <span class="modal-title">Edit User</span>
        <button type="button" class="modal-close" data-modal-close>&times;</button>
    </div>
    <form id="user-edit-form" data-user-id="" novalidate>
        <div class="form-group">
            <label for="edit-user-name">Nama</label>
            <div class="field-wrap">
                <input type="text" id="edit-user-name" name="name" required autocomplete="off" />
                <span class="field-error" data-error-for="name"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="edit-user-email">Email</label>
            <div class="field-wrap">
                <input type="email" id="edit-user-email" name="email" required autocomplete="off"/>
                <span class="field-error" data-error-for="email"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="edit-user-role">Role</label>
            <select id="edit-user-role" name="role">
                <option value="Member">Member</option>
                <option value="Admin">Admin</option>
            </select>
            <span class="field-error" data-error-for="role"></span>
        </div>
        <button type="submit" class="btn-primary">Simpan Perubahan</button>
    </form>
</dialog>
<dialog id="user-reset-password-modal" class="modal-box" data-reset-on-close>
    <div class="modal-header">
        <span class="modal-title">Reset Password</span>
        <button type="button" class="modal-close" data-modal-close>&times;</button>
    </div>
    <form id="user-reset-password-form" data-user-id="" novalidate>
        <div class="form-group">
            <label for="reset-password-input">Password Baru</label>
            <div class="field-wrap">
                <div class="password-field">
                    <input type="password" id="reset-password-input" name="password" required />
                    <button type="button" class="password-toggle" data-password-toggle="reset-password-input" aria-label="Lihat password"></button>
                </div>
                <span class="field-error" data-error-for="password"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="reset-password-confirm">Konfirmasi Password</label>
            <div class="field-wrap">
                <div class="password-field">
                    <input type="password" id="reset-password-confirm" name="password_confirmation" required />
                    <button type="button" class="password-toggle" data-password-toggle="reset-password-confirm" aria-label="Lihat password"></button>
                </div>
                <span class="field-error" data-error-for="password_confirmation"></span>
            </div>
        </div>
        <button type="submit" class="btn-primary">Simpan Password Baru</button>
    </form>
</dialog>

<script>
    var USERS_DATA = <?= json_encode($users) ?>;
</script>
<script src="/js/users-status.js" defer></script>
<script src="/js/validate-user.js" defer></script>
<?php require __DIR__ . '/../partials/footer.php'; ?>
