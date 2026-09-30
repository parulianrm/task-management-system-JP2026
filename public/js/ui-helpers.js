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
