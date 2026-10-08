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
                <?php if ($_SESSION['role'] === 'Admin'): ?>
                    <button type="button" class="btn-primary" data-modal-open="project-form-modal"><img
                            src="/images/add.png" class="btn-icon" alt="" />Project Baru</button>

                <?php endif; ?>
            </div>

            <div class="filter-card">
                <form method="GET" action="/projects">
                    <div class="filter-row">
                        <div class="filter-field">
                            <label for="filter-q">Cari Nama Project</label>
                            <input type="search" id="filter-q" name="q" placeholder="Cari nama project..."
                                value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" />
                        </div>
                        <div class="filter-field">
                            <label for="filter-status">Status</label>
                            <select id="filter-status" name="status">
                                <option value="">Semua Status</option>
                                <?php foreach (['Planning', 'Active', 'Completed', 'Archived'] as $s): ?>
                                    <option value="<?= $s ?>" <?= ($_GET['status'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="filter-actions">
                        <a href="/projects" class="btn-secondary">Reset Filter</a>
                        <button type="submit" class="btn-primary">Terapkan Filter</button>
                    </div>
                </form>
            </div>


            <div class="projects-grid">
                <?php if (empty($projects)): ?>
                    <p class="empty-state">Belum ada project. Klik "+ Project Baru" untuk membuat project pertama.</p>
                <?php else: ?>
                    <?php foreach ($projects as $project): ?>
                        <?php
                        $badgeClass = match ($project['status']) {
                            'Planning' => 'badge-pending',
                            'Active' => 'badge-progress',
                            'Completed' => 'badge-completed',
                            'Archived' => 'badge-archived',
                            default => 'badge-pending',
                        };
                        $taskCount = $repository->countTasks((int) $project['id']);
                        ?>
                        <div class="project-card">
                            <div>
                                <div class="project-card-header">
                                    <a href="/projects/detail?id=<?= $project['id'] ?>"
                                        class="project-name"><?= htmlspecialchars($project['name']) ?></a>
                                    <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($project['status']) ?></span>
                                </div>
                                <div class="project-meta">
                                    Mulai: <strong><?= date('d M Y', strtotime($project['start_date'])) ?></strong>
                                    &mdash; Target: <strong><?= date('d M Y', strtotime($project['target_date'])) ?></strong>
                                </div>
                            </div>
                            <div class="project-card-footer">
                                <span class="project-task-count"><?= $taskCount ?> Task</span>
                                <a href="/projects/detail?id=<?= $project['id'] ?>" class="link-detail">Lihat Detail <img
                                        src="/images/right-arrow.png" class="btn-icon" alt=""
                                        style="width: 12px; height: 12px; margin-right:0; margin-left:4px;" /></a>

                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </main>
    </div>
</div>

<?php if ($_SESSION['role'] === 'Admin'): ?>
    <dialog id="project-form-modal" class="modal-box modal-box-wide" data-reset-on-close>
        <div class="modal-header">
            <span class="modal-title"><img src="/images/add.png" class="modal-title-icon" alt="" />Tambah Project
                Baru</span>
            <button type="button" class="modal-close" data-modal-close><img src="/images/close.png" class="modal-close-icon"
                    alt="" /></button>
        </div>
        <form id="project-form" novalidate>
            <div class="form-group">
                <label for="project-name">Nama</label>
                <div class="field-wrap">
                    <input type="text" id="project-name" name="name" placeholder="Nama project" required />
                    <span class="field-error" id="project-name-error"></span>
                </div>
            </div>
            <div class="form-group form-group-textarea">
                <label for="project-desc">Deskripsi</label>
                <textarea id="project-desc" name="description" rows="3" placeholder="Deskripsi singkat project"></textarea>
            </div>
            <div class="form-group">
                <label for="project-start">Tanggal Mulai</label>
                <div class="field-wrap">
                    <input type="date" id="project-start" name="start_date" required />
                    <span class="field-error" id="project-start-error"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="project-target">Tanggal Target</label>
                <div class="field-wrap">
                    <input type="date" id="project-target" name="target_date" required />
                    <span class="field-error" id="project-target-error"></span>
                </div>
            </div>
            <button type="submit" class="btn-primary">Simpan Project</button>
        </form>

    </dialog>
<?php endif; ?>

<script src="/js/validate-project.js" defer></script>
<?php require __DIR__ . '/../partials/footer.php'; ?>