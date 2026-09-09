document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('project-form');
    if (!form) return;

    var nameInput = document.getElementById('project-name');
    var startInput = document.getElementById('project-start');
    var targetInput = document.getElementById('project-target');

    var nameError = document.getElementById('project-name-error');
    var startError = document.getElementById('project-start-error');
    var targetError = document.getElementById('project-target-error');

    form.addEventListener('submit', function (event) {
        nameError.textContent = '';
        startError.textContent = '';
        targetError.textContent = '';

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

        if (!isValid) {
            event.preventDefault();
        } else {
            console.log('Form project valid — siap dikirim ke server (belum ada backend).');
        }
    });
});
