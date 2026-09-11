document.addEventListener('DOMContentLoaded', function () {
    var PROJECT_RANGES = {
        '1': { start: '2026-10-05', target: '2026-10-15' },
        '2': { start: '2026-09-01', target: '2026-12-01' },
        '3': { start: '2026-08-01', target: '2026-09-20' }
    };

    document.querySelectorAll('form.task-form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            var titleInput = form.querySelector('[name="title"]');
            var projectSelect = form.querySelector('[name="project_id"]');
            var dueInput = form.querySelector('[name="due_date"]');

            var titleError = form.querySelector('[data-error-for="title"]');
            var dueError = form.querySelector('[data-error-for="due_date"]');

            titleError.textContent = '';
            dueError.textContent = '';

            var isValid = true;

            if (titleInput.value.trim() === '') {
                titleError.textContent = 'Judul task wajib diisi.';
                isValid = false;
            }

            if (dueInput.value === '') {
                dueError.textContent = 'Due date wajib diisi.';
                isValid = false;
            } else {
                var range = PROJECT_RANGES[projectSelect.value];
                if (range && (dueInput.value < range.start || dueInput.value > range.target)) {
                    dueError.textContent = 'Due date harus antara ' + range.start + ' s.d. ' + range.target + '.';
                    isValid = false;
                }
            }

            if (!isValid) {
                event.preventDefault();
            } else {
                console.log('Form task valid — siap dikirim ke server (belum ada backend).');
            }
        });
    });
});
