<?php
$pageTitle = 'Projects - Task Management System';
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
                <h1 class="page-title">Daftar Project</h1>
                <form role="search" class="search-form">
                <div class="search-input-group">
                    <input type="search" id="site-search" name="q" placeholder="Cari nama project" class="search-input" />
                    <button type="button" class="btn-primary" data-modal-open="project-form-modal">+ Project Baru</button>

                </div>
            </form>
            </div>

            <div class="projects-grid">
                <div class="project-card">
                    <div>
                        <div class="project-card-header">
                            <a href="#" class="project-name">E-Commerce Mobile App</a>
                            <span class="badge badge-progress">In Progress</span>
                        </div>
                        <div class="project-meta">
                            Mulai: <strong>05 Okt 2026</strong> Target Selesai: <strong>15 Okt 2026</strong>
                        </div>
                    </div>
                    <div class="project-card-footer">
                        <span class="project-task-count">8 Task Aktif</span>
                        <a href="detail.php" class="link-detail">Lihat Detail &rarr;</a>
                    </div>
                </div>

                <div class="project-card">
                    <div>
                        <div class="project-card-header">
                            <a href="#" class="project-name">HRIS Internal System</a>
                            <span class="badge badge-pending">Pending</span>
                        </div>
                        <div class="project-meta">
                            Target Selesai: <strong>01 Des 2026</strong>
                        </div>
                    </div>
                    <div class="project-card-footer">
                        <span class="project-task-count">4 Task Aktif</span>
                        <a href="#" class="link-detail">Lihat Detail &rarr;</a>
                    </div>
                </div>

                <div class="project-card">
                    <div>
                        <div class="project-card-header">
                            <a href="#" class="project-name">Payment Gateway Integration</a>
                            <span class="badge badge-progress">In Progress</span>
                        </div>
                        <div class="project-meta">
                            Target Selesai: <strong>20 Sep 2026</strong>
                        </div>
                    </div>
                    <div class="project-card-footer">
                        <span class="project-task-count">6 Task Aktif</span>
                        <a href="#" class="link-detail">Lihat Detail &rarr;</a>
                    </div>
                </div>

                <div class="project-card">
                    <div>
                        <div class="project-card-header">
                            <a href="#" class="project-name">Company Landing Page</a>
                            <span class="badge badge-completed">Completed</span>
                        </div>
                        <div class="project-meta">
                            Target Selesai: <strong>30 Jun 2026</strong>
                        </div>
                    </div>
                    <div class="project-card-footer">
                        <span class="project-task-count">Selesai</span>
                        <a href="#" class="link-detail">Lihat Detail &rarr;</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<dialog id="project-form-modal" class="modal-box modal-box-wide">
    <div class="modal-header">
        <span class="modal-title">Tambah Project Baru</span>
        <button type="button" class="modal-close" data-modal-close>&times;</button>
    </div>
    <form method="dialog">
        <div class="form-group">
            <label for="project-name">Nama</label>
            <input type="text" id="project-name" name="name" placeholder="Nama project" required />
        </div>
        <div class="form-group form-group-textarea">
            <label for="project-desc">Deskripsi</label>
            <textarea id="project-desc" name="description" rows="3" placeholder="Deskripsi singkat project"></textarea>
        </div>
        <div class="form-group">
            <label for="project-status">Status</label>
            <select id="project-status" name="status">
                <option value="Planning" selected>Planning</option>
                <option value="Active">Active</option>
                <option value="Completed">Completed</option>
                <option value="Archived">Archived</option>
            </select>
        </div>
        <div class="form-group">
            <label for="project-start">Tanggal Mulai</label>
            <input type="date" id="project-start" name="start_date" required />
        </div>
        <div class="form-group">
            <label for="project-target">Tanggal Target</label>
            <input type="date" id="project-target" name="target_date" required />
        </div>
        <button type="submit" class="btn-primary">Simpan Project</button>
    </form>
</dialog>


<?php require __DIR__ . '/../partials/footer.php'; ?>
