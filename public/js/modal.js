// Modal component - replaces native alert() and confirm()
(function() {
  let modalEl = null;

  function getModal() {
    if (modalEl) return modalEl;

    modalEl = document.createElement('div');
    modalEl.id = 'app-modal';
    modalEl.className = 'modal-overlay';
    modalEl.innerHTML = `
      <div class="modal">
        <div class="modal-header">
          <h3 class="modal-title"></h3>
          <button class="modal-close" onclick="window.appModal.hide()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="18" y1="6" x2="6" y2="18"/>
              <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
          </button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer"></div>
      </div>
    `;
    document.body.appendChild(modalEl);
    return modalEl;
  }

  function hide() {
    const modal = getModal();
    modal.classList.remove('show');
    document.body.classList.remove('modal-open');
  }

  function show({ title, message, type = 'info', confirmText = 'OK', cancelText = null, onConfirm, onCancel }) {
    const modal = getModal();
    const titleEl = modal.querySelector('.modal-title');
    const bodyEl = modal.querySelector('.modal-body');
    const footerEl = modal.querySelector('.modal-footer');

    titleEl.textContent = title || (type === 'error' ? 'Error' : type === 'success' ? 'Success' : '');
    bodyEl.textContent = message;
    bodyEl.className = 'modal-body modal-' + type;

    footerEl.innerHTML = '';
    if (cancelText) {
      const cancelBtn = document.createElement('button');
      cancelBtn.className = 'modal-btn modal-btn-secondary';
      cancelBtn.textContent = cancelText;
      cancelBtn.onclick = () => { hide(); if (onCancel) onCancel(); };
      footerEl.appendChild(cancelBtn);
    }
    const confirmBtn = document.createElement('button');
    confirmBtn.className = 'modal-btn modal-btn-primary';
    confirmBtn.innerHTML = confirmText;
    confirmBtn.onclick = () => { hide(); if (onConfirm) onConfirm(); };
    footerEl.appendChild(confirmBtn);

    document.body.classList.add('modal-open');
    modal.classList.add('show');
    confirmBtn.focus();
  }

  function alert(message, title, type = 'info') {
    show({ title, message, type });
  }

  function confirm(message, title = 'Confirm', onConfirm, onCancel) {
    show({ title, message, confirmText: 'Confirm', cancelText: 'Cancel', onConfirm, onCancel });
  }

  window.appModal = { show, hide, alert, confirm };

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') hide();
  });
})();
