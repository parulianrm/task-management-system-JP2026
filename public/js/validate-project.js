document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('project-form');
    if (form) {
        var nameInput = document.getElementById('project-name');
        var startInput = document.getElementById('project-start');
        var targetInput = document.getElementById('project-target');
        var descInput = document.getElementById('project-desc');

        var nameError = document.getElementById('project-name-error');
        var startError = document.getElementById('project-start-error');
        var targetError = document.getElementById('project-target-error');

        function clearErrors() {
            nameError.textContent = '';
            startError.textContent = '';
            targetError.textContent = '';
        }

        function validateClientSide() {
            var isValid = true;

            if (nameInput.value.trim() === '') {
                nameError.textContent = 'Nama project wajib diisi.';
                isValid = false;
            }

            if (startInput.value === '') {
                startError.textContent = 'Tanggal mulai wajib diisi.';
                isValid = false;
            }

            if (targetInput.value === '') {
                targetError.textContent = 'Tanggal target wajib diisi.';
                isValid = false;
            } else if (startInput.value !== '' && targetInput.value < startInput.value) {
                targetError.textContent = 'Tanggal target tidak boleh lebih awal dari tanggal mulai.';
                isValid = false;
            }

            return isValid;
        }

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            clearErrors();

            if (!validateClientSide()) return;

            var payload = {
                name: nameInput.value.trim(),
                description: descInput.value.trim(),
                start_date: startInput.value,
                target_date: targetInput.value
            };

            var projectId = form.dataset.projectId;
            if (projectId) {
                payload.id = projectId;
            } else {
                payload.status = document.getElementById('project-status').value;
            }

            apiPost('/api/projects.php', payload).then(function (result) {
                if (!result.success) {
                    if (result.errors && result.errors.name) nameError.textContent = result.errors.name;
                    if (result.errors && result.errors.target_date) targetError.textContent = result.errors.target_date;
                    return;
                }

                document.getElementById('project-form-modal').close();
                window.location.reload();
            }).catch(function () {
                nameError.textContent = 'Gagal menyimpan project, coba lagi nanti.';
            });
        });
    }

    var archiveBtn = document.getElementById('btn-archive-project');
    if (archiveBtn) {
        archiveBtn.addEventListener('click', function () {
            if (!confirm('Arsipkan project ini? Project yang diarsipkan tidak bisa diubah statusnya lagi.')) return;

            var projectId = document.getElementById('project-form').dataset.projectId;
            apiPost('/api/projects.php', { id: projectId, action: 'archive' }).then(function (result) {
                if (result.success) {
                    window.location.reload();
                }
            });
        });
    }
});
