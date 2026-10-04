<?php
$pageTitle = 'Tasks - Task Management System';
$activePage = 'tasks';
require __DIR__ . '/../partials/header.php';

function buildTaskPageUrl(int $page): string
{
    $params = $_GET;
    $params['page'] = $page;
    return '/tasks?' . http_build_query($params);
}

function daysOverdue(string $dueDate): int
{
    $due = new DateTime($dueDate);
    $today = new DateTime(date('Y-m-d'));
    return (int) $today->diff($due)->days;
}

function daysLate(string $dueDate, string $closedAt): int
{
    $due = new DateTime($dueDate);
    $closed = new DateTime(substr($closedAt, 0, 10));
    return (int) $due->diff($closed)->days;
}

$statusBadge = [
    'To Do' => 'badge-status-todo',
    'In Progress' => 'badge-status-progress',
    'Done' => 'badge-status-done',
];
$priorityBadge = [
    'Low' => 'badge-priority-low',
    'Medium' => 'badge-priority-medium',
    'High' => 'badge-priority-high',
];
?>

<div class="app-layout">
    <?php require __DIR__ . '/../partials/sidebar.php'; ?>

    <div class="app-main">
        <?php require __DIR__ . '/../partials/topbar.php'; ?>

        <main class="dashboard-container">
            <div class="page-header">
                <h1 class="page-title">Daftar Task</h1>
                <?php if ($_SESSION['role'] === 'Admin'): ?>
                    <button type="button" class="btn-primary" data-modal-open="task-form-modal"><img src="/images/add.png"
                            class="btn-icon" alt="" />Task Baru</button>
                <?php endif; ?>
            </div>
            <div class="filter-card">
                <form method="GET" action="/tasks">
                    <div class="filter-row">
                        <div class="filter-field">
                            <label for="filter-q">Cari Judul</label>
                            <input type="search" id="filter-q" name="q" placeholder="Cari judul task..."
                                value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" />
                        </div>
                        <div class="filter-field">
                            <label for="filter-project">Project</label>
                            <select id="filter-project" name="project_id">
                                <option value="">Semua Project</option>
                                <?php foreach ($projects as $p): ?>
                                    <option value="<?= $p['id'] ?>" <?= ($_GET['project_id'] ?? '') == $p['id'] ? 'selected' : '' ?>><?= htmlspecialchars($p['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="filter-field">
                            <label for="filter-status">Status</label>
                            <select id="filter-status" name="status">
                                <option value="">Semua Status</option>
                                <?php foreach (['To Do', 'In Progress', 'Done'] as $s): ?>
                                    <option value="<?= $s ?>" <?= ($_GET['status'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="filter-field">
                            <label for="filter-priority">Priority</label>
                            <select id="filter-priority" name="priority">
                                <option value="">Semua Priority</option>
                                <?php foreach (['Low', 'Medium', 'High'] as $p): ?>
                                    <option value="<?= $p ?>" <?= ($_GET['priority'] ?? '') === $p ? 'selected' : '' ?>>
                                        <?= $p ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="filter-field">
                            <label for="filter-sort">Urutkan Due Date</label>
                            <select id="filter-sort" name="sort">
                                <option value="asc" <?= ($_GET['sort'] ?? 'asc') === 'asc' ? 'selected' : '' ?>>Terdekat
                                    &uarr;</option>
                                <option value="desc" <?= ($_GET['sort'] ?? '') === 'desc' ? 'selected' : '' ?>>Terjauh
                                    &darr;</option>
                            </select>
                        </div>
                    </div>
                    <div class="filter-actions">
                        <a href="/tasks" class="btn-secondary">Reset Filter</a>
                        <button type="submit" class="btn-primary">Terapkan Filter</button>
                    </div>
                </form>
            </div>


            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Project</th>
                            <th>Assignee</th>
                            <th>Priority</th>
                            <th>Due Date</th>
                            <th>Closed Date</th>
                            <th>Status</th>
                            <?php if ($_SESSION['role'] === 'Admin'): ?>
                                <th>Aksi</th><?php endif; ?>
                        </tr>
                    </thead>
                    <tbody id="task-table-body">
                        <?php if (empty($tasks)): ?>
                            <tr>
                                <td colspan="9" class="empty-row">Belum ada task.</td>
                            </tr>
                        <?php else: ?>
                            <?php $rowNumber = ($page - 1) * $perPage + 1; ?>
                            <?php foreach ($tasks as $task): ?>
                                <?php
                                $isOverdue = $task['due_date'] < date('Y-m-d') && $task['status'] !== 'Done';
                                $canEdit = $_SESSION['role'] === 'Admin' || (int) $task['assignee_id'] === (int) $_SESSION['user_id'];
                                ?>
                                <tr data-task-id="<?= $task['id'] ?>">
                                    <td><?= $rowNumber++ ?></td>
                                    <td><?= htmlspecialchars($task['title']) ?></td>
                                    <td><?= htmlspecialchars($task['project_name']) ?></td>
                                    <td><?= htmlspecialchars($task['assignee_name'] ?? '-') ?></td>
                                    <td><span
                                            class="badge <?= $priorityBadge[$task['priority']] ?>"><?= $task['priority'] ?></span>
                                    </td>
                                    <td>
                                        <?= date('d M Y', strtotime($task['due_date'])) ?>
                                        <?php if ($isOverdue): ?>
                                            <span class="badge badge-overdue"><?= daysOverdue($task['due_date']) ?>d overdue</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($task['closed_at']): ?>
                                            <?= date('d M Y', strtotime($task['closed_at'])) ?>
                                            <?php if (substr($task['closed_at'], 0, 10) > $task['due_date']): ?>
                                                <span class="badge badge-overdue"><?= daysLate($task['due_date'], $task['closed_at']) ?>d overdue</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($canEdit): ?>
                                            <label for="task-status-<?= $task['id'] ?>" class="visually-hidden">Status task
                                                <?= htmlspecialchars($task['title']) ?></label>
                                            <select id="task-status-<?= $task['id'] ?>" class="status-select"
                                                data-task-status="<?= $task['id'] ?>">
                                                <?php foreach (['To Do', 'In Progress', 'Done'] as $s): ?>
                                                    <option value="<?= $s ?>" <?= $s === $task['status'] ? 'selected' : '' ?>><?= $s ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        <?php else: ?>
                                            <span class="badge <?= $statusBadge[$task['status']] ?>"><?= $task['status'] ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <?php if ($_SESSION['role'] === 'Admin'): ?>
                                        <td><button type="button" class="btn-secondary btn-table-action"
                                                data-task-edit="<?= $task['id'] ?>"><img src="/images/edit.png" class="btn-icon"
                                                    alt="" />Edit</button></td>

                                    <?php endif; ?>

                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="pagination-bar">
                <form method="GET" action="/tasks" class="per-page-form">
                    <?php foreach (['q', 'project_id', 'status', 'priority', 'sort'] as $key): ?>
                        <input type="hidden" name="<?= $key ?>" value="<?= htmlspecialchars($_GET[$key] ?? '') ?>" />
                    <?php endforeach; ?>
                    <label for="per-page-select">Tampilkan</label>
                    <select name="per_page" id="per-page-select" onchange="this.form.submit()">
                        <?php foreach ([5, 10, 25, 50] as $n): ?>
                            <option value="<?= $n ?>" <?= $perPage === $n ? 'selected' : '' ?>><?= $n ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>

                <nav class="pagination" aria-label="Navigasi halaman">
                    <a href="<?= buildTaskPageUrl(max(1, $page - 1)) ?>"
                        class="pagination-btn<?= $page === 1 ? ' is-disabled' : '' ?>"><img src="/images/left-arrow.png" class="btn-icon" alt="" style="margin:0; width:12px; height:12px;" /></a>
                    <?php
                    $pageStart = max(1, $page - 1);
                    $pageEnd = min($totalPages, $page + 1);
                    ?>
                    <?php if ($pageStart > 1): ?>
                        <a href="<?= buildTaskPageUrl(1) ?>" class="pagination-page">1</a>
                        <?php if ($pageStart > 2): ?><span class="pagination-ellipsis">&hellip;</span><?php endif; ?>
                    <?php endif; ?>
                    <?php for ($i = $pageStart; $i <= $pageEnd; $i++): ?>
                        <a href="<?= buildTaskPageUrl($i) ?>"
                            class="pagination-page<?= $i === $page ? ' is-active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                    <?php if ($pageEnd < $totalPages): ?>
                        <?php if ($pageEnd < $totalPages - 1): ?><span class="pagination-ellipsis">&hellip;</span><?php endif; ?>
                        <a href="<?= buildTaskPageUrl($totalPages) ?>" class="pagination-page"><?= $totalPages ?></a>
                    <?php endif; ?>

                    <a href="<?= buildTaskPageUrl(min($totalPages, $page + 1)) ?>"
                        class="pagination-btn<?= $page === $totalPages ? ' is-disabled' : '' ?>"><img src="/images/right-arrow.png" class="btn-icon" alt="" style="margin:0; width:12px; height:12px;" /></a>
                </nav>
            </div>
        </main>
    </div>
</div>




<?php if ($_SESSION['role'] === 'Admin'): ?>
    <dialog id="task-form-modal" class="modal-box modal-box-wide" data-reset-on-close>
        <div class="modal-header">
            <span class="modal-title"><img src="/images/add.png" class="modal-title-icon" alt="" />Tambah Task Baru</span>
            <button type="button" class="modal-close" data-modal-close><img src="/images/close.png" class="modal-close-icon"
                    alt="" /></button>
        </div>
        <form class="task-form" novalidate>
            <div class="form-group">
                <label for="task-project">Project</label>
                <select id="task-project" name="project_id">
                    <?php foreach ($projects as $p): ?>
                        <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="task-title">Judul</label>
                <div class="field-wrap">
                    <input type="text" id="task-title" name="title" placeholder="Judul task" required />
                    <span class="field-error" data-error-for="title"></span>
                </div>
            </div>
            <div class="form-group form-group-textarea">
                <label for="task-desc">Deskripsi</label>
                <textarea id="task-desc" name="description" rows="3" placeholder="Deskripsi singkat task"></textarea>
            </div>
            <div class="form-group">
                <label for="task-assignee">Assignee</label>
                <select id="task-assignee" name="assignee_id">
                    <option value="">- Belum ditugaskan -</option>
                    <?php foreach ($activeUsers as $u): ?>
                        <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['name']) ?></option>
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

    <dialog id="task-edit-modal" class="modal-box modal-box-wide" data-reset-on-close>
        <div class="modal-header">
            <span class="modal-title"><img src="/images/edit.png" class="modal-title-icon" alt="" />Edit Task</span>

            <button type="button" class="modal-close" data-modal-close><img src="/images/close.png" class="modal-close-icon"
                    alt="" /></button>
        </div>
        <form class="task-form" data-task-id="" novalidate>
            <div class="form-group">
                <label for="edit-task-project">Project</label>
                <select id="edit-task-project" name="project_id" disabled>
                    <?php foreach ($projects as $p): ?>
                        <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="edit-task-title">Judul</label>
                <div class="field-wrap">
                    <input type="text" id="edit-task-title" name="title" required />
                    <span class="field-error" data-error-for="title"></span>
                </div>
            </div>
            <div class="form-group form-group-textarea">
                <label for="edit-task-desc">Deskripsi</label>
                <textarea id="edit-task-desc" name="description" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="edit-task-assignee">Assignee</label>
                <select id="edit-task-assignee" name="assignee_id">
                    <option value="">- Belum ditugaskan -</option>
                    <?php foreach ($activeUsers as $u): ?>
                        <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="edit-task-priority">Priority</label>
                <select id="edit-task-priority" name="priority">
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                </select>
            </div>
            <div class="form-group">
                <label for="edit-task-due">Due Date</label>
                <div class="field-wrap">
                    <input type="date" id="edit-task-due" name="due_date" required />
                    <span class="field-error" data-error-for="due_date"></span>
                </div>
            </div>
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </form>
    </dialog>
<?php endif; ?>

<script>
    var TASKS_DATA = <?= json_encode($tasks) ?>;
</script>
<script src="/js/tasks.js" defer></script>
<script src="/js/validate-task.js" defer></script>
<?php require __DIR__ . '/../partials/footer.php'; ?>