<?php
$pageTitle = 'Detail Project - Task Management System';
$activePage = 'projects';
require __DIR__ . '/../partials/header.php';

$badgeClass = match ($project['status']) {
    'Planning' => 'badge-pending',
    'Active' => 'badge-progress',
    'Completed' => 'badge-completed',
    'Archived' => 'badge-archived',
    default => 'badge-pending',
};

$priorityBadge = [
    'Low' => 'badge-priority-low',
    'Medium' => 'badge-priority-medium',
    'High' => 'badge-priority-high',
];

$statusBadge = [
    'To Do' => 'badge-status-todo',
    'In Progress' => 'badge-status-progress',
    'Done' => 'badge-status-done',
];
?>

<div class="app-layout">
    <?php require __DIR__ . '/../partials/sidebar.php'; ?>

    <div class="app-main">
        <?php require __DIR__ . '/../partials/topbar.php'; ?>

        <main class="dashboard-container">
            <div class="page-header">
                <div>
                    <a href="/projects" class="link-detail">&larr; Kembali ke Daftar Proyek</a>
                    <h1 class="page-title"><?= htmlspecialchars($project['name']) ?></h1>
                </div>
                <?php if ($_SESSION['role'] === 'Admin'): ?>
                    <div style="display:flex; gap:0.5rem;">
                        <?php if ($project['status'] !== 'Archived'): ?>
                            <button type="button" class="btn-secondary" id="btn-archive-project">Arsipkan</button>
                        <?php endif; ?>
                        <button type="button" class="btn-primary" data-modal-open="project-form-modal">Edit Project</button>
                    </div>
                <?php endif; ?>
            </div>

            <div class="project-detail-info">
                <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($project['status']) ?></span>
                <p class="project-detail-desc"><?= nl2br(htmlspecialchars($project['description'] ?? '-')) ?></p>
                <div class="project-detail-meta">
                    <div><span class="meta-label">Tanggal Mulai</span><span class="meta-value"><?= date('d M Y', strtotime($project['start_date'])) ?></span></div>
                    <div><span class="meta-label">Target Selesai</span><span class="meta-value"><?= date('d M Y', strtotime($project['target_date'])) ?></span></div>
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($tasks)): ?>
                            <tr><td colspan="5" class="empty-row">Belum ada task di project ini.</td></tr>
                        <?php else: ?>
                            <?php foreach ($tasks as $task): ?>
                                <tr>
                                    <td><?= htmlspecialchars($task['title']) ?></td>
                                    <td><?= htmlspecialchars($task['assignee_name'] ?? '-') ?></td>
                                    <td><span class="badge <?= $priorityBadge[$task['priority']] ?>"><?= $task['priority'] ?></span></td>
                                    <td><?= date('d M Y', strtotime($task['due_date'])) ?></td>
                                    <td><span class="badge <?= $statusBadge[$task['status']] ?>"><?= $task['status'] ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($_SESSION['role'] === 'Admin'): ?>
            <dialog id="project-form-modal" class="modal-box modal-box-wide" data-reset-on-close>
                <div class="modal-header">
                    <span class="modal-title">Edit Project</span>
                    <button type="button" class="modal-close" data-modal-close>&times;</button>
                </div>
                <form id="project-form" data-project-id="<?= $project['id'] ?>" novalidate>
                    <div class="form-group">
                        <label for="project-name">Nama</label>
                        <div class="field-wrap">
                            <input type="text" id="project-name" name="name" value="<?= htmlspecialchars($project['name']) ?>" required />
                            <span class="field-error" id="project-name-error"></span>
                        </div>
                    </div>
                    <div class="form-group form-group-textarea">
                        <label for="project-desc">Deskripsi</label>
                        <textarea id="project-desc" name="description" rows="3"><?= htmlspecialchars($project['description'] ?? '') ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="project-start">Tanggal Mulai</label>
                        <div class="field-wrap">
                            <input type="date" id="project-start" name="start_date" value="<?= $project['start_date'] ?>" required />
                            <span class="field-error" id="project-start-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="project-target">Tanggal Target</label>
                        <div class="field-wrap">
                            <input type="date" id="project-target" name="target_date" value="<?= $project['target_date'] ?>" required />
                            <span class="field-error" id="project-target-error"></span>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                </form>
            </dialog>
            <?php endif; ?>
        </main>
    </div>
</div>

<script src="/js/validate-project.js" defer></script>
<?php require __DIR__ . '/../partials/footer.php'; ?>
