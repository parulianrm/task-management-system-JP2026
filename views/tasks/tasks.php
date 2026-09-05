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
                <a href="#" class="btn-primary">+ Task Baru</a>
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
                            <td><a href="#" class="link-detail">Detail</a></td>
                        </tr>
                        <tr>
                            <td>Design ERD Diagram</td>
                            <td>HRIS Internal System</td>
                            <td>Parulian R M</td>
                            <td><span class="badge badge-priority-medium">Medium</span></td>
                            <td>05 Sep 2026</td>
                            <td><span class="badge badge-status-progress">In Progress</span></td>
                            <td><a href="#" class="link-detail">Detail</a></td>
                        </tr>
                        <tr>
                            <td>Midtrans Integration</td>
                            <td>Payment Gateway Integration</td>
                            <td>Dimas Aditya</td>
                            <td><span class="badge badge-priority-low">Low</span></td>
                            <td>10 Sep 2026</td>
                            <td><span class="badge badge-status-done">Done</span></td>
                            <td><a href="#" class="link-detail">Detail</a></td>
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

<?php require __DIR__ . '/../partials/footer.php'; ?>
