<?php
$pageTitle = 'Users - Task Management System';
$activePage = 'users';
$basePath = '../';
require __DIR__ . '/../partials/header.php';
?>

<div class="app-layout">
    <?php require __DIR__ . '/../partials/sidebar.php'; ?>

    <div class="app-main">
        <?php require __DIR__ . '/../partials/topbar.php'; ?>

        <main class="dashboard-container">
            <div class="page-header">
                <h1 class="page-title">Manajemen User</h1>
                <a href="#" class="btn-primary">+ User Baru</a>
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
                        <tr>
                            <td>Dimas Aditya</td>
                            <td>dimas.aditya@neuronworks.co.id</td>
                            <td><span class="badge badge-role-admin">Admin</span></td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" checked data-status-toggle />
                                    <span class="switch-slider"></span>
                                </label>
                                <span class="status-text">Aktif</span>
                            </td>

                            <td><button type="button" class="link-detail" data-modal-open="edit-user-1">Edit</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Parulian R M</td>
                            <td>parulian.manik@neuronworks.co.id</td>
                            <td><span class="badge badge-role-member">Member</span></td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" checked data-status-toggle />
                                    <span class="switch-slider"></span>
                                </label>
                                <span class="status-text">Aktif</span>
                            </td>
                            <td><button type="button" class="link-detail" data-modal-open="edit-user-2">Edit</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Rian Hidayat</td>
                            <td>rian.hidayat@neuronworks.co.id</td>
                            <td><span class="badge badge-role-member">Member</span></td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" data-status-toggle />
                                    <span class="switch-slider"></span>
                                </label>
                                <span class="status-text">Nonaktif</span>
                            </td>

                            <td><button type="button" class="link-detail" data-modal-open="edit-user-3">Edit</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <dialog id="edit-user-1" class="modal-box">
                <div class="modal-header">
                    <span class="modal-title">Edit User</span>
                    <button type="button" class="modal-close" data-modal-close>&times;</button>
                </div>
                <form method="dialog">
                    <div class="form-group">
                        <label for="name-1">Nama</label>
                        <input type="text" id="name-1" value="Dimas Aditya" />
                    </div>
                    <div class="form-group">
                        <label for="email-1">Email</label>
                        <input type="email" id="email-1" value="dimas.aditya@neuronworks.co.id" />
                    </div>
                    <div class="form-group">
                        <label for="role-1">Role</label>
                        <select id="role-1">
                            <option value="Admin" selected>Admin</option>
                            <option value="Member">Member</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status-1">Status</label>
                        <select id="status-1">
                            <option value="1" selected>Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                </form>
            </dialog>

            <dialog id="edit-user-2" class="modal-box">
                <div class="modal-header">
                    <span class="modal-title">Edit User</span>
                    <button type="button" class="modal-close" data-modal-close>&times;</button>
                </div>
                <form method="dialog">
                    <div class="form-group">
                        <label for="name-2">Nama</label>
                        <input type="text" id="name-2" value="Parulian R M" />
                    </div>
                    <div class="form-group">
                        <label for="email-2">Email</label>
                        <input type="email" id="email-2" value="parulian.manik@neuronworks.co.id" />
                    </div>
                    <div class="form-group">
                        <label for="role-2">Role</label>
                        <select id="role-2">
                            <option value="Admin">Admin</option>
                            <option value="Member" selected>Member</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status-2">Status</label>
                        <select id="status-2">
                            <option value="1" selected>Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                </form>
            </dialog>

            <dialog id="edit-user-3" class="modal-box">
                <div class="modal-header">
                    <span class="modal-title">Edit User</span>
                    <button type="button" class="modal-close" data-modal-close>&times;</button>
                </div>
                <form method="dialog">
                    <div class="form-group">
                        <label for="name-3">Nama</label>
                        <input type="text" id="name-3" value="Rian Hidayat" />
                    </div>
                    <div class="form-group">
                        <label for="email-3">Email</label>
                        <input type="email" id="email-3" value="rian.hidayat@neuronworks.co.id" />
                    </div>
                    <div class="form-group">
                        <label for="role-3">Role</label>
                        <select id="role-3">
                            <option value="Admin">Admin</option>
                            <option value="Member" selected>Member</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status-3">Status</label>
                        <select id="status-3">
                            <option value="1">Aktif</option>
                            <option value="0" selected>Nonaktif</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                </form>
            </dialog>
        </main>
    </div>
</div>

<script src="/public/js/users-status.js" defer></script>
<?php require __DIR__ . '/../partials/footer.php'; ?>