document.addEventListener('DOMContentLoaded', function () {
    var tbody = document.getElementById('task-table-body');
    if (!tbody) return;

    tbody.addEventListener('click', function (event) {
        var btn = event.target.closest('[data-task-edit]');
        if (!btn) return;

        var task = TASKS_DATA.filter(function (t) { return t.id === Number.parseInt(btn.dataset.taskEdit, 10); })[0];
        if (!task) return;

        var editModal = document.getElementById('task-edit-modal');
        editModal.querySelectorAll('.field-error').forEach(function (span) { span.textContent = ''; });

        var editForm = editModal.querySelector('form');
        editForm.dataset.taskId = task.id;
        editForm.dataset.projectId = task.project_id;

        document.getElementById('edit-task-project').value = task.project_id;
        document.getElementById('edit-task-title').value = task.title;
        document.getElementById('edit-task-desc').value = task.description || '';
        document.getElementById('edit-task-assignee').value = task.assignee_id || '';
        document.getElementById('edit-task-priority').value = task.priority;
        document.getElementById('edit-task-due').value = task.due_date;

        editModal.showModal();
    });

    tbody.addEventListener('change', function (event) {
        var select = event.target.closest('[data-task-status]');
        if (!select) return;

        apiPost('/api/tasks.php', {
            action: 'update_status',
            id: select.dataset.taskStatus,
            status: select.value
        }).then(function (result) {
            if (!result.success) {
                alert(result.message || 'Gagal ubah status.');
            }
            window.location.reload();
        }).catch(function () {
            alert('Gagal mengubah status task, coba lagi nanti.');
        });
    });
});
