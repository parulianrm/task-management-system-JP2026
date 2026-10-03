function showToast(message, type) {
    var container = document.getElementById('toast-container');
    if (!container) return;

    var toast = document.createElement('div');
    toast.className = 'toast toast-' + (type || 'success');
    toast.textContent = message;
    container.appendChild(toast);

    setTimeout(function () {
        toast.classList.add('toast-hide');
        setTimeout(function () {
            toast.remove();
        }, 300);
    }, 3000);
}

function confirmAction(message, callback) {
    var dialog = document.getElementById('confirm-modal');
    var messageEl = document.getElementById('confirm-modal-message');
    var yesBtn = document.getElementById('confirm-modal-yes');
    if (!dialog || !messageEl || !yesBtn) return;

    var freshYesBtn = yesBtn.cloneNode(true);
    yesBtn.parentNode.replaceChild(freshYesBtn, yesBtn);

    messageEl.textContent = message;
    dialog.showModal();

    freshYesBtn.addEventListener('click', function () {
        dialog.close();
        callback();
    }, { once: true });
}

document.addEventListener('DOMContentLoaded', function () {
    var pending = sessionStorage.getItem('toastMessage');
    if (pending) {
        sessionStorage.removeItem('toastMessage');
        showToast(pending, sessionStorage.getItem('toastType') || 'success');
        sessionStorage.removeItem('toastType');
    }
});

function initPasswordToggles() {
    var EYE_OPEN = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>';
    var EYE_OFF = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>';

    document.querySelectorAll('[data-password-toggle]').forEach(function (btn) {
        var input = document.getElementById(btn.dataset.passwordToggle);
        if (!input) return;

        btn.innerHTML = EYE_OPEN;

        btn.addEventListener('click', function () {
            var isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            btn.innerHTML = isHidden ? EYE_OFF : EYE_OPEN;
        });
    });
}

document.addEventListener('DOMContentLoaded', initPasswordToggles);
