<?php
$pageTitle = 'Tambah Project - Task Management System';
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
                    <a href="projects.php" class="link-detail">&larr; Kembali ke Daftar Proyek</a>
                    <h1 class="page-title">Tambah Project Baru</h1>
                </div>
            </div>

            <!-- Catatan: PRJ-01 — kalau project SUDAH punya task, opsi status di bawah nanti (Week 4)
                 harus dikunci cuma boleh pilih "Archived". Belum diterapkan di sini karena masih statis. -->
            <form class="project-form">
                <div class="form-group">
                    <label for="project-name">Nama</label>
                    <input type="text" id="project-name" name="name" placeholder="Nama project" required />
                </div>

                <div class="form-group form-group-textarea">
                    <label for="project-desc">Deskripsi</label>
                    <textarea id="project-desc" name="description" rows="4" placeholder="Deskripsi singkat project"></textarea>
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
        </main>
    </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
