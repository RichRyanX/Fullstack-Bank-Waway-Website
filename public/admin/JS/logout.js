// ===== Shared: Logout confirmation & session timeout =====
// Linked on every CMS page (after dashboard.js)

// Auto-logout after a period of inactivity. The timeout (in minutes) is read
// from the server-provided session value, falling back to 30 minutes.
function initSessionTimeout() {
  var timeoutMinutes = 30;
  try {
    var stored = sessionStorage.getItem('admin_session_timeout');
    if (stored) {
      var parsed = parseInt(stored, 10);
      if (parsed > 0) timeoutMinutes = parsed;
    }
  } catch (e) { /* ignore */ }

  var timeoutMs = timeoutMinutes * 60 * 1000;
  var timer = null;

  function resetTimer() {
    if (timer) clearTimeout(timer);
    timer = setTimeout(forceLogout, timeoutMs);
  }

  function forceLogout() {
    window.adminApiRequest('/admin-api/auth/logout', {
      method: 'POST',
      headers: { 'Accept': 'application/json' }
    }).finally(function () {
      window.location.href = 'index.html';
    });
  }

  // Reset the idle timer on any user activity.
  ['click', 'keydown', 'mousemove', 'scroll', 'touchstart'].forEach(function (evt) {
    document.addEventListener(evt, resetTimer, { passive: true });
  });

  resetTimer();
}

// ----- Custom logout confirmation modal -----
function showLogoutModal(onConfirm) {
  // Prevent duplicate modals
  var existing = document.querySelector('.logout-modal-overlay');
  if (existing) return;

  var overlay = document.createElement('div');
  overlay.className = 'logout-modal-overlay';
  overlay.setAttribute('role', 'dialog');
  overlay.setAttribute('aria-modal', 'true');
  overlay.setAttribute('aria-labelledby', 'logoutModalTitle');

  var modal = document.createElement('div');
  modal.className = 'logout-modal';

  var header = document.createElement('div');
  header.className = 'logout-modal-header';

  var icon = document.createElement('div');
  icon.className = 'icon';
  icon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 9v4m0 4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg>';

  var title = document.createElement('h3');
  title.id = 'logoutModalTitle';
  title.textContent = 'Konfirmasi Keluar';

  header.appendChild(icon);
  header.appendChild(title);

  var body = document.createElement('div');
  body.className = 'logout-modal-body';
  var message = document.createElement('p');
  message.textContent = 'Apakah Anda yakin ingin keluar dari sistem? Semua sesi aktif akan berakhir.';
  body.appendChild(message);

  var footer = document.createElement('div');
  footer.className = 'logout-modal-footer';

  var cancelBtn = document.createElement('button');
  cancelBtn.className = 'btn btn-cancel';
  cancelBtn.textContent = 'Batal';
  cancelBtn.type = 'button';
  cancelBtn.addEventListener('click', function () {
    document.body.removeChild(overlay);
  });

  var confirmBtn = document.createElement('button');
  confirmBtn.className = 'btn btn-danger';
  confirmBtn.textContent = 'Keluar';
  confirmBtn.type = 'button';
  confirmBtn.addEventListener('click', function () {
    document.body.removeChild(overlay);
    if (typeof onConfirm === 'function') onConfirm();
  });

  footer.appendChild(cancelBtn);
  footer.appendChild(confirmBtn);

  modal.appendChild(header);
  modal.appendChild(body);
  modal.appendChild(footer);

  overlay.appendChild(modal);
  document.body.appendChild(overlay);

  // Close on backdrop click
  overlay.addEventListener('click', function (e) {
    if (e.target === overlay) {
      document.body.removeChild(overlay);
    }
  });

  // Close with Escape key
  function handleKeydown(e) {
    if (e.key === 'Escape') {
      if (document.body.contains(overlay)) {
        document.body.removeChild(overlay);
        document.removeEventListener('keydown', handleKeydown);
      }
    }
  }
  document.addEventListener('keydown', handleKeydown);

  // Focus management: trap focus inside modal (simple version)
  // After opening, focus the cancel button by default.
  cancelBtn.focus();
}

document.addEventListener('DOMContentLoaded', function () {
  // Only run the idle timeout on authenticated CMS pages (not the login page).
  if (document.getElementById('loginForm')) return;

  initSessionTimeout();
  var searchInput = document.getElementById('global-search-input');
  if (searchInput) {
    searchInput.addEventListener('keydown', function (e) {
      if (e.key === 'Enter') {
        var query = searchInput.value.trim();
        if (query) {
          window.location.href = 'search.html?q=' + encodeURIComponent(query);
        }
      }
    });
  }

  var logoutBtn = document.getElementById('logoutBtn');
  if (!logoutBtn) return;

  logoutBtn.addEventListener('click', function (e) {
    e.preventDefault();

    showLogoutModal(function () {
      window.adminApiRequest('/admin-api/auth/logout', {
        method: 'POST',
        headers: { 'Accept': 'application/json' }
      })
        .finally(function () {
          window.location.href = 'index.html';
        });
    });
  });
});
