document.addEventListener('DOMContentLoaded', function () {
    var PROJECTS = {
        '1': { name: 'E-Commerce Mobile App' },
        '2': { name: 'HRIS Internal System' },
        '3': { name: 'Payment Gateway Integration' }
    };

    var ASSIGNEES = {
        '1': 'Abrar Halomoan R M',
        '2': 'Parulian R M'
    };

    var TODAY = '2026-09-09';
    var PAGE_SIZE = 10;
    var currentPage = 1;

    var filters = { q: '', project: '', status: '', priority: '', sort: 'due_asc' };

    var TASKS = [
        { id: 1, project_id: '1', title: 'Fix Auth API', description: 'Perbaiki bug pada endpoint autentikasi yang gagal validasi token.', assignee_id: '2', priority: 'High', due_date: '2026-09-04', status: 'To Do' },
        { id: 2, project_id: '2', title: 'Design ERD Diagram', description: 'Rancang ERD untuk modul HRIS, termasuk relasi antar tabel.', assignee_id: '2', priority: 'Medium', due_date: '2026-09-05', status: 'In Progress' },
        { id: 3, project_id: '3', title: 'Midtrans Integration', description: 'Integrasikan payment gateway Midtrans ke proses checkout.', assignee_id: '1', priority: 'Low', due_date: '2026-09-10', status: 'Done' },
        { id: 4, project_id: '1', title: 'Integrasi Payment Gateway', description: 'Hubungkan sistem pembayaran ke proses checkout aplikasi mobile.', assignee_id: '1', priority: 'High', due_date: '2026-09-12', status: 'In Progress' },
        { id: 5, project_id: '1', title: 'Desain Halaman Checkout', description: 'Buat desain UI halaman checkout yang responsif.', assignee_id: '2', priority: 'Medium', due_date: '2026-09-14', status: 'Done' },
        { id: 6, project_id: '2', title: 'Setup Database HRIS', description: 'Siapkan skema database awal untuk modul HRIS.', assignee_id: '1', priority: 'High', due_date: '2026-09-08', status: 'To Do' },
        { id: 7, project_id: '1', title: 'Review Security Checklist', description: 'Audit keamanan dasar sebelum rilis.', assignee_id: '2', priority: 'High', due_date: '2026-09-06', status: 'To Do' },
        { id: 8, project_id: '3', title: 'Fix Pagination Bug', description: 'Perbaiki bug pagination yang salah hitung total halaman.', assignee_id: '1', priority: 'Medium', due_date: '2026-09-16', status: 'To Do' },
        { id: 9, project_id: '2', title: 'Update Dependency', description: 'Update dependency Composer yang sudah usang.', assignee_id: '2', priority: 'Low', due_date: '2026-09-20', status: 'To Do' },
        { id: 10, project_id: '2', title: 'Testing Modul Payroll', description: 'Uji coba perhitungan payroll untuk berbagai skenario.', assignee_id: '1', priority: 'Medium', due_date: '2026-09-18', status: 'In Progress' },
        { id: 11, project_id: '3', title: 'Optimasi Query Report', description: 'Optimalkan query laporan yang lambat.', assignee_id: '2', priority: 'Low', due_date: '2026-09-22', status: 'To Do' },
        { id: 12, project_id: '1', title: 'Buat Dokumentasi API', description: 'Tulis dokumentasi endpoint API yang sudah dibuat.', assignee_id: '1', priority: 'Low', due_date: '2026-09-25', status: 'To Do' },
        { id: 13, project_id: '3', title: 'Perbaikan UI Mobile', description: 'Perbaiki tampilan UI yang rusak di layar kecil.', assignee_id: '2', priority: 'Medium', due_date: '2026-09-13', status: 'In Progress' }
    ];

    var STATUS_BADGE_CLASS = { 'To Do': 'badge-status-todo', 'In Progress': 'badge-status-progress', 'Done': 'badge-status-done' };
    var PRIORITY_BADGE_CLASS = { 'Low': 'badge-priority-low', 'Medium': 'badge-priority-medium', 'High': 'badge-priority-high' };
    var STATUS_OPTIONS = ['To Do', 'In Progress', 'Done'];

    function isOverdue(task) {
        return task.due_date < TODAY && task.status !== 'Done';
    }

    function formatDate(iso) {
        var d = new Date(iso + 'T00:00:00');
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        return d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
    }

    function getFilteredTasks() {
        var result = TASKS.filter(function (task) {
            var matchesQuery = filters.q === '' || task.title.toLowerCase().indexOf(filters.q.toLowerCase()) !== -1;
            var matchesProject = filters.project === '' || task.project_id === filters.project;
            var matchesStatus = filters.status === '' || task.status === filters.status;
            var matchesPriority = filters.priority === '' || task.priority === filters.priority;
            return matchesQuery && matchesProject && matchesStatus && matchesPriority;
        });

        result.sort(function (a, b) {
            if (filters.sort === 'due_desc') {
                return a.due_date < b.due_date ? 1 : -1;
            }
            return a.due_date > b.due_date ? 1 : -1;
        });

        return result;
    }

    function renderTable() {
        var tbody = document.getElementById('task-table-body');
        var filtered = getFilteredTasks();
        var start = (currentPage - 1) * PAGE_SIZE;
        var pageTasks = filtered.slice(start, start + PAGE_SIZE);

        if (pageTasks.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="empty-row">Tidak ada task yang cocok dengan pencarian/filter ini.</td></tr>';
            return;
        }

        tbody.innerHTML = pageTasks.map(function (task) {
            var projectName = PROJECTS[task.project_id] ? PROJECTS[task.project_id].name : '-';
            var assigneeName = ASSIGNEES[task.assignee_id] || '-';
            var dueClass = isOverdue(task) ? ' class="is-overdue"' : '';
            var statusOptions = STATUS_OPTIONS.map(function (s) {
                return '<option value="' + s + '"' + (s === task.status ? ' selected' : '') + '>' + s + '</option>';
            }).join('');

            return '<tr>' +
                '<td>' + task.title + '</td>' +
                '<td>' + projectName + '</td>' +
                '<td>' + assigneeName + '</td>' +
                '<td><span class="badge ' + PRIORITY_BADGE_CLASS[task.priority] + '">' + task.priority + '</span></td>' +
                '<td' + dueClass + '>' + formatDate(task.due_date) + '</td>' +
                '<td><select class="status-select" data-task-status="' + task.id + '">' + statusOptions + '</select></td>' +
                '<td><button type="button" class="link-detail" data-task-edit="' + task.id + '">Detail</button></td>' +
                '</tr>';
        }).join('');
    }

    function renderPagination() {
        var nav = document.getElementById('task-pagination');
        var filtered = getFilteredTasks();
        var totalPages = Math.max(1, Math.ceil(filtered.length / PAGE_SIZE));
        if (currentPage > totalPages) currentPage = totalPages;

        var html = '';
        html += '<button type="button" class="pagination-btn' + (currentPage === 1 ? ' is-disabled' : '') + '" data-page="' + (currentPage - 1) + '"' + (currentPage === 1 ? ' disabled' : '') + '>&laquo; Sebelumnya</button>';
        for (var i = 1; i <= totalPages; i++) {
            html += '<button type="button" class="pagination-page' + (i === currentPage ? ' is-active' : '') + '" data-page="' + i + '">' + i + '</button>';
        }
        html += '<button type="button" class="pagination-btn' + (currentPage === totalPages ? ' is-disabled' : '') + '" data-page="' + (currentPage + 1) + '"' + (currentPage === totalPages ? ' disabled' : '') + '>Berikutnya &raquo;</button>';
        nav.innerHTML = html;
    }

    function render() {
        renderTable();
        renderPagination();
    }

    document.getElementById('task-pagination').addEventListener('click', function (event) {
        var btn = event.target.closest('[data-page]');
        if (!btn || btn.disabled) return;
        currentPage = parseInt(btn.dataset.page, 10);
        render();
    });

    document.getElementById('task-table-body').addEventListener('click', function (event) {
        var btn = event.target.closest('[data-task-edit]');
        if (!btn) return;

        var task = TASKS.filter(function (t) { return t.id === parseInt(btn.dataset.taskEdit, 10); })[0];
        if (!task) return;

        var editModal = document.getElementById('task-edit-modal');
        editModal.querySelectorAll('.field-error').forEach(function (span) { span.textContent = ''; });

        document.getElementById('edit-task-project').value = task.project_id;
        document.getElementById('edit-task-title').value = task.title;
        document.getElementById('edit-task-desc').value = task.description;
        document.getElementById('edit-task-assignee').value = task.assignee_id;
        document.getElementById('edit-task-status').value = task.status;
        document.getElementById('edit-task-priority').value = task.priority;
        document.getElementById('edit-task-due').value = task.due_date;

        editModal.showModal();
    });

    document.getElementById('task-table-body').addEventListener('change', function (event) {
        var select = event.target.closest('[data-task-status]');
        if (!select) return;

        var task = TASKS.filter(function (t) { return t.id === parseInt(select.dataset.taskStatus, 10); })[0];
        if (!task) return;

        task.status = select.value;
        render();
    });

    var filterForm = document.querySelector('.task-filter-bar');
    var searchInput = filterForm.querySelector('[name="q"]');
    var projectSelect = filterForm.querySelector('[name="project"]');
    var statusSelect = filterForm.querySelector('[name="status"]');
    var prioritySelect = filterForm.querySelector('[name="priority"]');
    var sortSelect = filterForm.querySelector('[name="sort"]');

    function applyFilters() {
        filters.q = searchInput.value.trim();
        filters.project = projectSelect.value;
        filters.status = statusSelect.value;
        filters.priority = prioritySelect.value;
        filters.sort = sortSelect.value;
        currentPage = 1;
        render();
    }

    searchInput.addEventListener('input', applyFilters);
    projectSelect.addEventListener('change', applyFilters);
    statusSelect.addEventListener('change', applyFilters);
    prioritySelect.addEventListener('change', applyFilters);
    sortSelect.addEventListener('change', applyFilters);
    filterForm.addEventListener('submit', function (event) {
        event.preventDefault();
        applyFilters();
    });

    render();
});
