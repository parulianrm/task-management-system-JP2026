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
                    <a href="projects.php" class="link-detail">&larr; Kembali ke Daftar Proyek</a>
                    <h1 class="page-title">E-Commerce Mobile App</h1>
                </div>
                <a href="form.php" class="btn-primary">Edit Project</a>
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
        </main>
    </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
