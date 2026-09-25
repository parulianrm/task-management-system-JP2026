document.addEventListener('DOMContentLoaded', function () {
    function clearErrors(form) {
        form.querySelectorAll('.field-error').forEach(function (span) { span.textContent = ''; });
    }

    function validateClientSide(form) {
        var titleInput = form.querySelector('[name="title"]');
        var dueInput = form.querySelector('[name="due_date"]');
        var titleError = form.querySelector('[data-error-for="title"]');
        var dueError = form.querySelector('[data-error-for="due_date"]');

        var isValid = true;

        if (titleInput.value.trim() === '') {
            titleError.textContent = 'Judul task wajib diisi.';
            isValid = false;
        }
        if (dueInput.value === '') {
            dueError.textContent = 'Due date wajib diisi.';
            isValid = false;
        }

        return isValid;
    }

    document.querySelectorAll('form.task-form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            clearErrors(form);

            if (!validateClientSide(form)) return;

            var payload = {
                title: form.querySelector('[name="title"]').value.trim(),
                description: form.querySelector('[name="description"]').value.trim(),
                assignee_id: form.querySelector('[name="assignee_id"]').value || null,
                priority: form.querySelector('[name="priority"]').value,
                due_date: form.querySelector('[name="due_date"]').value
            };

            var taskId = form.dataset.taskId;
            if (taskId) {
                payload.id = taskId;
                payload.project_id = form.dataset.projectId;
            } else {
                payload.project_id = form.querySelector('[name="project_id"]').value;
            }

            apiPost('/api/tasks.php', payload).then(function (result) {
                if (!result.success) {
                    var titleError = form.querySelector('[data-error-for="title"]');
                    var dueError = form.querySelector('[data-error-for="due_date"]');

                    if (result.errors) {
                        if (result.errors.title) titleError.textContent = result.errors.title;
                        if (result.errors.due_date) dueError.textContent = result.errors.due_date;
                        if (result.errors.project_id) titleError.textContent = result.errors.project_id;
                        if (result.errors.assignee_id) titleError.textContent = result.errors.assignee_id;
                    } else if (result.message) {
                        titleError.textContent = result.message;
                    }
                    return;
                }

                form.closest('dialog').close();
                window.location.reload();
            }).catch(function () {
                alert('Gagal menyimpan task, coba lagi nanti.');
            });
        });
    });
});
