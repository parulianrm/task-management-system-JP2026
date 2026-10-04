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

$totalTasks = count($allTasks);
$doneTasks = count(array_filter($allTasks, fn($t) => $t['status'] === 'Done'));
$progressPercent = $totalTasks > 0 ? (int) round(($doneTasks / $totalTasks) * 100) : 0;

$assigneeNames = [];
foreach ($allTasks as $t) {
    if (!empty($t['assignee_name']) && !in_array($t['assignee_name'], $assigneeNames, true)) {
        $assigneeNames[] = $t['assignee_name'];
    }
}

function buildProjectDetailPageUrl(int $page, int $projectId, int $perPage): string
{
    return '/projects/detail?' . http_build_query(['id' => $projectId, 'page' => $page, 'per_page' => $perPage]);
}

?>

<div class="app-layout">
    <?php require __DIR__ . '/../partials/sidebar.php'; ?>

    <div class="app-main">
        <?php require __DIR__ . '/../partials/topbar.php'; ?>

        <main class="dashboard-container">
            <div class="page-header">
                <div>
                    <nav class="breadcrumb" aria-label="Breadcrumb">
                        <a href="/projects">Projects</a>
                        <span class="breadcrumb-sep">&rsaquo;</span>
                        <span class="breadcrumb-current">Detail Project</span>
                    </nav>
                    <h1 class="page-title"><?= htmlspecialchars($project['name']) ?></h1>
                </div>
                <?php if ($_SESSION['role'] === 'Admin'): ?>
                    <div style="display:flex; gap:0.5rem;">
                        <?php if ($project['status'] === 'Archived'): ?>
                            <button type="button" class="btn-secondary" id="btn-unarchive-project"><img src="/images/undo.png"
                                    class="btn-icon" alt="" />Aktifkan Kembali</button>
                        <?php else: ?>
                            <?php if ($project['status'] !== 'Planning' && $repository->countIncompleteTasks($project['id']) === 0): ?>
                                <button type="button" class="btn-secondary" id="btn-archive-project"><img src="/images/undo.png"
                                        class="btn-icon" alt="" />Arsipkan</button>
                            <?php endif; ?>
                            <button type="button" class="btn-primary" data-modal-open="task-form-modal"><img
                                    src="/images/add.png" class="btn-icon" alt="" />Task Baru</button>
                            <button type="button" class="btn-primary" data-modal-open="project-form-modal"><img
                                    src="/images/edit.png" class="btn-icon" alt="" />Edit Project</button>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>

            <div class="project-detail-info">
                <div class="detail-row">
                    <span class="detail-row-label">Status</span>
                    <span class="detail-row-value"><span
                            class="badge <?= $badgeClass ?>"><?= htmlspecialchars($project['status']) ?></span></span>
                </div>
                <div class="detail-row">
                    <span class="detail-row-label">Start Date</span>
                    <span class="detail-row-value"><?= date('d M Y', strtotime($project['start_date'])) ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-row-label">Due Date</span>
                    <span class="detail-row-value"><?= date('d M Y', strtotime($project['target_date'])) ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-row-label">Assignees</span>
                    <span class="detail-row-value">
                        <div class="assignee-avatars">
                            <?php if (empty($assigneeNames)): ?>
                                -
                            <?php else: ?>
                                <?php foreach ($assigneeNames as $name): ?>
                                    <span class="nav-avatar"
                                        title="<?= htmlspecialchars($name) ?>"><?= htmlspecialchars(strtoupper(substr($name, 0, 1))) ?></span>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-row-label">Progress</span>
                    <span class="detail-row-value">
                        <div class="progress-bar-track">
                            <div class="progress-bar-fill" style="width: <?= $progressPercent ?>%;"></div>
                        </div>
                        <?= $progressPercent ?>% (<?= $doneTasks ?>/<?= $totalTasks ?> task)
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-row-label">Description</span>
                    <span class="detail-row-value"><?= nl2br(htmlspecialchars($project['description'] ?? '-')) ?></span>
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
                            <tr>
                                <td colspan="5" class="empty-row">Belum ada task di project ini.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($tasks as $task): ?>
                                <tr>
                                    <td><?= htmlspecialchars($task['title']) ?></td>
                                    <td><?= htmlspecialchars($task['assignee_name'] ?? '-') ?></td>
                                    <td><span
                                            class="badge <?= $priorityBadge[$task['priority']] ?>"><?= $task['priority'] ?></span>
                                    </td>
                                    <td><?= date('d M Y', strtotime($task['due_date'])) ?></td>
                                    <td><span class="badge <?= $statusBadge[$task['status']] ?>"><?= $task['status'] ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="pagination-bar">
                <form method="GET" action="/projects/detail" class="per-page-form">
                    <input type="hidden" name="id" value="<?= $project['id'] ?>" />
                    <label for="per-page-select">Tampilkan</label>
                    <select name="per_page" id="per-page-select" onchange="this.form.submit()">
                        <?php foreach ([5, 10, 25, 50] as $n): ?>
                            <option value="<?= $n ?>" <?= $perPage === $n ? 'selected' : '' ?>><?= $n ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>

                <nav class="pagination" aria-label="Navigasi halaman">
                    <a href="<?= buildProjectDetailPageUrl(max(1, $page - 1), $project['id'], $perPage) ?>"
                        class="pagination-btn<?= $page === 1 ? ' is-disabled' : '' ?>"><img src="/images/left-arrow.png" class="btn-icon" alt="" style="margin:0; width:12px; height:12px;" /></a>
                    <?php
                    $pageStart = max(1, $page - 1);
                    $pageEnd = min($totalPages, $page + 1);
                    ?>
                    <?php if ($pageStart > 1): ?>
                        <a href="<?= buildProjectDetailPageUrl(1, $project['id'], $perPage) ?>" class="pagination-page">1</a>
                        <?php if ($pageStart > 2): ?><span class="pagination-ellipsis">&hellip;</span><?php endif; ?>
                    <?php endif; ?>
                    <?php for ($i = $pageStart; $i <= $pageEnd; $i++): ?>
                        <a href="<?= buildProjectDetailPageUrl($i, $project['id'], $perPage) ?>"
                            class="pagination-page<?= $i === $page ? ' is-active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                    <?php if ($pageEnd < $totalPages): ?>
                        <?php if ($pageEnd < $totalPages - 1): ?><span class="pagination-ellipsis">&hellip;</span><?php endif; ?>
                        <a href="<?= buildProjectDetailPageUrl($totalPages, $project['id'], $perPage) ?>" class="pagination-page"><?= $totalPages ?></a>
                    <?php endif; ?>

                    <a href="<?= buildProjectDetailPageUrl(min($totalPages, $page + 1), $project['id'], $perPage) ?>"
                        class="pagination-btn<?= $page === $totalPages ? ' is-disabled' : '' ?>"><img src="/images/right-arrow.png" class="btn-icon" alt="" style="margin:0; width:12px; height:12px;" /></a>
                </nav>
            </div>

            <?php if ($_SESSION['role'] === 'Admin'): ?>
                <dialog id="project-form-modal" class="modal-box modal-box-wide" data-reset-on-close>
                    <div class="modal-header">
                        <span class="modal-title"><img src="/images/edit.png" class="modal-title-icon" alt="" />Edit
                            Project</span>
                        <button type="button" class="modal-close" data-modal-close><img src="/images/close.png"
                                class="modal-close-icon" alt="" /></button>
                    </div>
                    <form id="project-form" data-project-id="<?= $project['id'] ?>" novalidate>
                        <div class="form-group">
                            <label for="project-name">Nama</label>
                            <div class="field-wrap">
                                <input type="text" id="project-name" name="name"
                                    value="<?= htmlspecialchars($project['name']) ?>" required />
                                <span class="field-error" id="project-name-error"></span>
                            </div>
                        </div>
                        <div class="form-group form-group-textarea">
                            <label for="project-desc">Deskripsi</label>
                            <textarea id="project-desc" name="description"
                                rows="3"><?= htmlspecialchars($project['description'] ?? '') ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="project-start">Tanggal Mulai</label>
                            <div class="field-wrap">
                                <input type="date" id="project-start" name="start_date"
                                    value="<?= $project['start_date'] ?>" required />
                                <span class="field-error" id="project-start-error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="project-target">Tanggal Target</label>
                            <div class="field-wrap">
                                <input type="date" id="project-target" name="target_date"
                                    value="<?= $project['target_date'] ?>" required />
                                <span class="field-error" id="project-target-error"></span>
                            </div>
                        </div>
                        <button type="submit" class="btn-primary">Simpan Perubahan</button>
                    </form>
                </dialog>
            <?php endif; ?>
            <?php if ($_SESSION['role'] === 'Admin' && $project['status'] !== 'Archived'): ?>
                <dialog id="task-form-modal" class="modal-box modal-box-wide" data-reset-on-close>
                    <div class="modal-header">
                        <span class="modal-title"><img src="/images/add.png" class="modal-title-icon" alt="" />Tambah Task
                            Baru</span>
                        <button type="button" class="modal-close" data-modal-close><img src="/images/close.png"
                                class="modal-close-icon" alt="" /></button>
                    </div>
                    <form class="task-form" novalidate>
                        <input type="hidden" name="project_id" value="<?= $project['id'] ?>" />
                        <div class="form-group">
                            <label for="task-title">Judul</label>
                            <div class="field-wrap">
                                <input type="text" id="task-title" name="title" placeholder="Judul task" required />
                                <span class="field-error" data-error-for="title"></span>
                            </div>
                        </div>
                        <div class="form-group form-group-textarea">
                            <label for="task-desc">Deskripsi</label>
                            <textarea id="task-desc" name="description" rows="3"
                                placeholder="Deskripsi singkat task"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="task-assignee">Assignee</label>
                            <select id="task-assignee" name="assignee_id">
                                <option value="">- Belum ditugaskan -</option>
                                <?php foreach ($activeUsers as $u): ?>
                                    <option value="<?= $u['id'] ?>">
                                        <?= htmlspecialchars($u['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="task-priority">Priority</label>
                            <select id="task-priority" name="priority">
                                <option value="Low">Low</option>
                                <option value="Medium" selected>Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="task-due">Due Date</label>
                            <div class="field-wrap">
                                <input type="date" id="task-due" name="due_date" required />
                                <span class="field-error" data-error-for="due_date"></span>
                            </div>
                        </div>
                        <button type="submit" class="btn-primary">Simpan Task</button>
                    </form>
                </dialog>
            <?php endif; ?>

        </main>
    </div>
</div>

<script src="/js/validate-project.js" defer></script>
<script src="/js/validate-task.js" defer></script>
<?php require __DIR__ . '/../partials/footer.php'; ?>