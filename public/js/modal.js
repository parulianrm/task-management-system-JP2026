document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-modal-open]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var dialog = document.getElementById(btn.dataset.modalOpen);
            if (dialog) dialog.showModal();
        });
    });

    document.querySelectorAll('dialog').forEach(function (dialog) {
        dialog.querySelectorAll('[data-modal-close]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                dialog.close();
            });
        });

        dialog.addEventListener('click', function (event) {
            if (event.target === dialog) {
                dialog.close();
            }
        });

        dialog.addEventListener('close', function () {
            if (dialog.hasAttribute('data-reset-on-close')) {
                var form = dialog.querySelector('form');
                if (form) form.reset();

                dialog.querySelectorAll('.field-error').forEach(function (errorEl) {
                    errorEl.textContent = '';
                });
            }
        });

    });
});
