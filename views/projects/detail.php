<?php
$pageTitle = 'Detail Project - Task Management System';
$activePage = 'projects';
$basePath = '../';
require __DIR__ . '/../partials/header.php';
?>

<div class="app-layout">
    <?php require __DIR__ . '/../partials/sidebar.php'; ?>

    <div class="app-main">
        <?php require __DIR__ . '/../partials/topbar.php'; ?>

        <main class="dashboard-container">
            <div class="page-header">
                <div>
                    <a href="/projects" class="link-detail">&larr; Kembali ke Daftar Proyek</a>
                    <h1 class="page-title">E-Commerce Mobile App</h1>
                </div>
               <button type="button" class="btn-primary" data-modal-open="project-form-modal">Edit Project</button>
            </div>

            <div class="project-detail-info">
                <span class="badge badge-progress">In Progress</span>
                <p class="project-detail-desc">Aplikasi mobile untuk berbelanja online, mencakup katalog produk, keranjang, dan proses checkout.</p>
                <div class="project-detail-meta">
                    <div><span class="meta-label">Tanggal Mulai</span><span class="meta-value">05 Okt 2026</span></div>
                    <div><span class="meta-label">Target Selesai</span><span class="meta-value">15 Okt 2026</span></div>
                </div>
            </div>

            <h2 class="section-heading">Task pada Project Ini</h2>

            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Assignee</th>
                            <th>Priority</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Fix Auth API</td>
                            <td>Parulian R M</td>
                            <td><span class="badge badge-priority-high">High</span></td>
                            <td class="is-overdue">04 Sep 2026</td>
                            <td><span class="badge badge-status-todo">To Do</span></td>
                            <td><a href="#" class="link-detail">Detail</a></td>
                        </tr>
                        <tr>
                            <td>Integrasi Payment Gateway</td>
                            <td>Dimas Aditya</td>
                            <td><span class="badge badge-priority-high">High</span></td>
                            <td>12 Sep 2026</td>
                            <td><span class="badge badge-status-progress">In Progress</span></td>
                            <td><a href="#" class="link-detail">Detail</a></td>
                        </tr>
                        <tr>
                            <td>Desain Halaman Checkout</td>
                            <td>Parulian R M</td>
                            <td><span class="badge badge-priority-medium">Medium</span></td>
                            <td>14 Sep 2026</td>
                            <td><span class="badge badge-status-done">Done</span></td>
                            <td><a href="#" class="link-detail">Detail</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <dialog id="project-form-modal" class="modal-box modal-box-wide" data-reset-on-close>
    <div class="modal-header">
        <span class="modal-title">Edit Project</span>
        <button type="button" class="modal-close" data-modal-close>&times;</button>
    </div>
    <form method="dialog" id="project-form" novalidate>
        <div class="form-group">
            <label for="project-name">Nama</label>
            <div class="field-wrap">
                <input type="text" id="project-name" name="name" value="E-Commerce Mobile App" required />
                <span class="field-error" id="project-name-error"></span>
            </div>
        </div>
        <div class="form-group form-group-textarea">
            <label for="project-desc">Deskripsi</label>
            <textarea id="project-desc" name="description" rows="3">Aplikasi mobile untuk berbelanja online, mencakup katalog produk, keranjang, dan proses checkout.</textarea>
        </div>
        <div class="form-group">
            <label for="project-status">Status</label>
            <select id="project-status" name="status">
                <option value="Planning">Planning</option>
                <option value="Active" selected>Active</option>
                <option value="Completed">Completed</option>
                <option value="Archived">Archived</option>
            </select>
        </div>
        <div class="form-group">
            <label for="project-start">Tanggal Mulai</label>
            <div class="field-wrap">
                <input type="date" id="project-start" name="start_date" value="2026-10-05" required />
                <span class="field-error" id="project-start-error"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="project-target">Tanggal Target</label>
            <div class="field-wrap">
                <input type="date" id="project-target" name="target_date" value="2026-10-15" required />
                <span class="field-error" id="project-target-error"></span>
            </div>
        </div>
        <button type="submit" class="btn-primary">Simpan Perubahan</button>
    </form>
</dialog>


        </main>
    </div>
</div>

<script src="/js/validate-project.js" defer></script>
<?php require __DIR__ . '/../partials/footer.php'; ?>
