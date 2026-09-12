<?php
$pageTitle = 'Tasks - Task Management System';
$activePage = 'tasks';
$basePath = '../';
require __DIR__ . '/../partials/header.php';
?>

<div class="app-layout">
    <?php require __DIR__ . '/../partials/sidebar.php'; ?>

    <div class="app-main">
        <?php require __DIR__ . '/../partials/topbar.php'; ?>

        <main class="dashboard-container">
            <div class="page-header">
                <h1 class="page-title">Daftar Task</h1>
                <button type="button" class="btn-primary" data-modal-open="task-form-modal">+ Task Baru</button>
            </div>

            <form role="search" class="task-filter-bar">
                <input type="search" name="q" placeholder="Cari judul task..." class="search-input" />
                <select name="project" class="filter-select">
                    <option value="">Semua Project</option>
                    <option value="1">E-Commerce Mobile App</option>
                    <option value="2">HRIS Internal System</option>
                    <option value="3">Payment Gateway Integration</option>
                </select>
                <select name="status" class="filter-select">
                    <option value="">Semua Status</option>
                    <option value="To Do">To Do</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Done">Done</option>
                </select>
                <select name="priority" class="filter-select">
                    <option value="">Semua Priority</option>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                </select>
                <select name="sort" class="filter-select">
                    <option value="due_asc">Due Date &uarr;</option>
                    <option value="due_desc">Due Date &darr;</option>
                </select>
                <button type="submit" class="btn-search"><span>Cari</span></button>
            </form>

            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Project</th>
                            <th>Assignee</th>
                            <th>Priority</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="task-table-body">
                        <!-- diisi otomatis oleh public/js/tasks.js -->
                    </tbody>
                </table>
            </div>

            <nav class="pagination" id="task-pagination" aria-label="Navigasi halaman"></nav>
        </main>
    </div>
</div>

<dialog id="task-form-modal" class="modal-box modal-box-wide" data-reset-on-close>
    <div class="modal-header">
        <span class="modal-title">Tambah Task Baru</span>
        <button type="button" class="modal-close" data-modal-close>&times;</button>
    </div>
    <form method="dialog" class="task-form" novalidate>
        <div class="form-group">
            <label for="task-project">Project</label>
            <select id="task-project" name="project_id">
                <option value="1">E-Commerce Mobile App</option>
                <option value="2">HRIS Internal System</option>
                <option value="3">Payment Gateway Integration</option>
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
                <option value="2">Parulian R M</option>
                <option value="1">Dimas Aditya</option>
            </select>
        </div>
        <div class="form-group">
            <label for="task-status">Status</label>
            <select id="task-status" name="status">
                <option value="To Do" selected>To Do</option>
                <option value="In Progress">In Progress</option>
                <option value="Done">Done</option>
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

<dialog id="task-edit-modal" class="modal-box modal-box-wide">
    <div class="modal-header">
        <span class="modal-title">Edit Task</span>
        <button type="button" class="modal-close" data-modal-close>&times;</button>
    </div>
    <form method="dialog" class="task-form" novalidate>
        <div class="form-group">
            <label for="edit-task-project">Project</label>
            <select id="edit-task-project" name="project_id">
                <option value="1">E-Commerce Mobile App</option>
                <option value="2">HRIS Internal System</option>
                <option value="3">Payment Gateway Integration</option>
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
                <option value="2">Parulian R M</option>
                <option value="1">Dimas Aditya</option>
            </select>
        </div>
        <div class="form-group">
            <label for="edit-task-status">Status</label>
            <select id="edit-task-status" name="status">
                <option value="To Do">To Do</option>
                <option value="In Progress">In Progress</option>
                <option value="Done">Done</option>
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

<script src="/js/tasks.js" defer></script>
<script src="/js/validate-task.js" defer></script>
<?php require __DIR__ . '/../partials/footer.php'; ?>
