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
                    <tbody>
                        <tr>
                            <td>Fix Auth API</td>
                            <td>E-Commerce Mobile App</td>
                            <td>Parulian R M</td>
                            <td><span class="badge badge-priority-high">High</span></td>
                            <td class="is-overdue">04 Sep 2026</td>
                            <td><span class="badge badge-status-todo">To Do</span></td>
                            <td><button type="button" class="link-detail" data-modal-open="task-edit-1">Detail</button></td>
                        </tr>
                        <tr>
                            <td>Design ERD Diagram</td>
                            <td>HRIS Internal System</td>
                            <td>Parulian R M</td>
                            <td><span class="badge badge-priority-medium">Medium</span></td>
                            <td>05 Sep 2026</td>
                            <td><span class="badge badge-status-progress">In Progress</span></td>
                            <td><button type="button" class="link-detail" data-modal-open="task-edit-2">Detail</button></td>
                        </tr>
                        <tr>
                            <td>Midtrans Integration</td>
                            <td>Payment Gateway Integration</td>
                            <td>Dimas Aditya</td>
                            <td><span class="badge badge-priority-low">Low</span></td>
                            <td>10 Sep 2026</td>
                            <td><span class="badge badge-status-done">Done</span></td>
                            <td><button type="button" class="link-detail" data-modal-open="task-edit-3">Detail</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <nav class="pagination" aria-label="Navigasi halaman">
                <a href="#" class="pagination-btn is-disabled" aria-disabled="true">&laquo; Sebelumnya</a>
                <span class="pagination-page is-active">1</span>
                <a href="#" class="pagination-page">2</a>
                <a href="#" class="pagination-page">3</a>
                <a href="#" class="pagination-btn">Berikutnya &raquo;</a>
            </nav>
        </main>
    </div>
</div>

            <dialog id="task-form-modal" class="modal-box modal-box-wide">
                <div class="modal-header">
                    <span class="modal-title">Tambah Task Baru</span>
                    <button type="button" class="modal-close" data-modal-close>&times;</button>
                </div>
                <form method="dialog">
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
                        <input type="text" id="task-title" name="title" placeholder="Judul task" required />
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
                        <input type="date" id="task-due" name="due_date" required />
                    </div>
                    <button type="submit" class="btn-primary">Simpan Task</button>
                </form>
            </dialog>

            <dialog id="task-edit-1" class="modal-box modal-box-wide">
                <div class="modal-header">
                    <span class="modal-title">Edit Task</span>
                    <button type="button" class="modal-close" data-modal-close>&times;</button>
                </div>
                <form method="dialog">
                    <div class="form-group">
                        <label for="t1-project">Project</label>
                        <select id="t1-project" name="project_id">
                            <option value="1" selected>E-Commerce Mobile App</option>
                            <option value="2">HRIS Internal System</option>
                            <option value="3">Payment Gateway Integration</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="t1-title">Judul</label>
                        <input type="text" id="t1-title" name="title" value="Fix Auth API" required />
                    </div>
                    <div class="form-group form-group-textarea">
                        <label for="t1-desc">Deskripsi</label>
                        <textarea id="t1-desc" name="description" rows="3">Perbaiki bug pada endpoint autentikasi yang gagal validasi token.</textarea>
                    </div>
                    <div class="form-group">
                        <label for="t1-assignee">Assignee</label>
                        <select id="t1-assignee" name="assignee_id">
                            <option value="2" selected>Parulian R M</option>
                            <option value="1">Dimas Aditya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="t1-status">Status</label>
                        <select id="t1-status" name="status">
                            <option value="To Do" selected>To Do</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Done">Done</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="t1-priority">Priority</label>
                        <select id="t1-priority" name="priority">
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High" selected>High</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="t1-due">Due Date</label>
                        <input type="date" id="t1-due" name="due_date" value="2026-09-04" required />
                    </div>
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                </form>
            </dialog>

            <dialog id="task-edit-2" class="modal-box modal-box-wide">
                <div class="modal-header">
                    <span class="modal-title">Edit Task</span>
                    <button type="button" class="modal-close" data-modal-close>&times;</button>
                </div>
                <form method="dialog">
                    <div class="form-group">
                        <label for="t2-project">Project</label>
                        <select id="t2-project" name="project_id">
                            <option value="1">E-Commerce Mobile App</option>
                            <option value="2" selected>HRIS Internal System</option>
                            <option value="3">Payment Gateway Integration</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="t2-title">Judul</label>
                        <input type="text" id="t2-title" name="title" value="Design ERD Diagram" required />
                    </div>
                    <div class="form-group form-group-textarea">
                        <label for="t2-desc">Deskripsi</label>
                        <textarea id="t2-desc" name="description" rows="3">Rancang ERD untuk modul HRIS, termasuk relasi antar tabel.</textarea>
                    </div>
                    <div class="form-group">
                        <label for="t2-assignee">Assignee</label>
                        <select id="t2-assignee" name="assignee_id">
                            <option value="2" selected>Parulian R M</option>
                            <option value="1">Dimas Aditya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="t2-status">Status</label>
                        <select id="t2-status" name="status">
                            <option value="To Do">To Do</option>
                            <option value="In Progress" selected>In Progress</option>
                            <option value="Done">Done</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="t2-priority">Priority</label>
                        <select id="t2-priority" name="priority">
                            <option value="Low">Low</option>
                            <option value="Medium" selected>Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="t2-due">Due Date</label>
                        <input type="date" id="t2-due" name="due_date" value="2026-09-05" required />
                    </div>
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                </form>
            </dialog>

            <dialog id="task-edit-3" class="modal-box modal-box-wide">
                <div class="modal-header">
                    <span class="modal-title">Edit Task</span>
                    <button type="button" class="modal-close" data-modal-close>&times;</button>
                </div>
                <form method="dialog">
                    <div class="form-group">
                        <label for="t3-project">Project</label>
                        <select id="t3-project" name="project_id">
                            <option value="1">E-Commerce Mobile App</option>
                            <option value="2">HRIS Internal System</option>
                            <option value="3" selected>Payment Gateway Integration</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="t3-title">Judul</label>
                        <input type="text" id="t3-title" name="title" value="Midtrans Integration" required />
                    </div>
                    <div class="form-group form-group-textarea">
                        <label for="t3-desc">Deskripsi</label>
                        <textarea id="t3-desc" name="description" rows="3">Integrasikan payment gateway Midtrans ke proses checkout.</textarea>
                    </div>
                    <div class="form-group">
                        <label for="t3-assignee">Assignee</label>
                        <select id="t3-assignee" name="assignee_id">
                            <option value="2">Parulian R M</option>
                            <option value="1" selected>Dimas Aditya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="t3-status">Status</label>
                        <select id="t3-status" name="status">
                            <option value="To Do">To Do</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Done" selected>Done</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="t3-priority">Priority</label>
                        <select id="t3-priority" name="priority">
                            <option value="Low" selected>Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="t3-due">Due Date</label>
                        <input type="date" id="t3-due" name="due_date" value="2026-09-10" required />
                    </div>
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                </form>
            </dialog>


<?php require __DIR__ . '/../partials/footer.php'; ?>
