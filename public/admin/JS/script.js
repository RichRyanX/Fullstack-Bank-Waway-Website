window.debounce = function (fn, wait) {
  var timer = null;
  return function () {
    var context = this;
    var args = arguments;
    clearTimeout(timer);
    timer = setTimeout(function () {
      fn.apply(context, args);
    }, wait);
  };
};

const toggleBtn = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');

if (toggleBtn && passwordInput) {
  toggleBtn.addEventListener('click', () => {
    const isPassword = passwordInput.type === 'password';
    passwordInput.type = isPassword ? 'text' : 'password';
    toggleBtn.setAttribute('aria-label', isPassword ? 'Sembunyikan password' : 'Tampilkan password');
  });
}

// ----- Custom Alert Modal (for login page) -----
function showAlert(message) {
  // Prevent duplicate modals
  var existing = document.querySelector('.logout-modal-overlay');
  if (existing) return;

  var overlay = document.createElement('div');
  overlay.className = 'logout-modal-overlay';
  overlay.setAttribute('role', 'alertdialog');
  overlay.setAttribute('aria-modal', 'true');
  overlay.setAttribute('aria-labelledby', 'alertModalTitle');

  var modal = document.createElement('div');
  modal.className = 'logout-modal';

  var header = document.createElement('div');
  header.className = 'logout-modal-header';

  var icon = document.createElement('div');
  icon.className = 'icon';
  icon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 9v4m0 4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg>';

  var title = document.createElement('h3');
  title.id = 'alertModalTitle';
  title.textContent = 'Perhatian';

  header.appendChild(icon);
  header.appendChild(title);

  var body = document.createElement('div');
  body.className = 'logout-modal-body';
  var msg = document.createElement('p');
  msg.textContent = message;
  body.appendChild(msg);

  var footer = document.createElement('div');
  footer.className = 'logout-modal-footer';

  var okBtn = document.createElement('button');
  okBtn.className = 'btn btn-danger';
  okBtn.textContent = 'OK';
  okBtn.type = 'button';
  okBtn.addEventListener('click', function () {
    document.body.removeChild(overlay);
  });

  footer.appendChild(okBtn);

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

  // Focus management: focus the OK button
  okBtn.focus();
}

const loginForm = document.getElementById('loginForm');
const twofaCard = document.getElementById('twofaCard');
const twofaForm = document.getElementById('twofaForm');

function showTwofaStep() {
  if (!twofaCard) return;
  if (loginForm) loginForm.closest('.login-card').hidden = true;
  twofaCard.hidden = false;
  const codeInput = document.getElementById('twofaCode');
  if (codeInput) codeInput.focus();
}

function showLoginStep() {
  if (!twofaCard) return;
  twofaCard.hidden = true;
  if (loginForm) loginForm.closest('.login-card').hidden = false;
}

function showLockoutModal(seconds, onComplete) {
  // Prevent duplicate modals
  var existing = document.querySelector('.logout-modal-overlay');
  if (existing) return;

  var overlay = document.createElement('div');
  overlay.className = 'logout-modal-overlay';
  overlay.setAttribute('role', 'alertdialog');
  overlay.setAttribute('aria-modal', 'true');
  overlay.setAttribute('aria-labelledby', 'lockoutModalTitle');

  var modal = document.createElement('div');
  modal.className = 'logout-modal';

  var header = document.createElement('div');
  header.className = 'logout-modal-header';

  var icon = document.createElement('div');
  icon.className = 'icon';
  icon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 9v4m0 4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg>';

  var title = document.createElement('h3');
  title.id = 'lockoutModalTitle';
  title.textContent = 'Akun Dikunci Sementara';

  header.appendChild(icon);
  header.appendChild(title);

  var body = document.createElement('div');
  body.className = 'logout-modal-body';
  var msg = document.createElement('p');
  msg.id = 'lockoutModalMessage';
  msg.textContent = 'Coba lagi dalam ' + seconds + ' detik.';
  body.appendChild(msg);

  var footer = document.createElement('div');
  footer.className = 'logout-modal-footer';

  // No buttons – auto-dismiss when timer ends

  modal.appendChild(header);
  modal.appendChild(body);
  modal.appendChild(footer);

  overlay.appendChild(modal);
  document.body.appendChild(overlay);

  // Update timer every second
  var timerInterval = setInterval(function() {
    seconds--;
    if (seconds <= 0) {
      clearInterval(timerInterval);
      if (document.body.contains(overlay)) {
        document.body.removeChild(overlay);
      }
      if (typeof onComplete === 'function') {
        onComplete();
      }
    } else {
      var msgEl = document.getElementById('lockoutModalMessage');
      if (msgEl) {
        msgEl.textContent = 'Coba lagi dalam ' + seconds + ' detik.';
      }
    }
  }, 1000);

  // Close on backdrop click (optional, but we'll allow it to dismiss early)
  overlay.addEventListener('click', function(e) {
    if (e.target === overlay) {
      clearInterval(timerInterval);
      if (document.body.contains(overlay)) {
        document.body.removeChild(overlay);
      }
      if (typeof onComplete === 'function') {
        onComplete();
      }
    }
  });

  // Close with Escape key
  function handleKeydown(e) {
    if (e.key === 'Escape') {
      clearInterval(timerInterval);
      if (document.body.contains(overlay)) {
        document.body.removeChild(overlay);
        document.removeEventListener('keydown', handleKeydown);
      }
      if (typeof onComplete === 'function') {
        onComplete();
      }
    }
  }
  document.addEventListener('keydown', handleKeydown);

  // Focus management: focus the modal body (or nothing)
  modal.focus();
}

function showMaintenanceModal(message) {
  var existing = document.querySelector('.logout-modal-overlay');
  if (existing) return;

  var overlay = document.createElement('div');
  overlay.className = 'logout-modal-overlay';
  overlay.setAttribute('role', 'alertdialog');
  overlay.setAttribute('aria-modal', 'true');
  overlay.setAttribute('aria-labelledby', 'maintenanceModalTitle');

  var modal = document.createElement('div');
  modal.className = 'logout-modal';

  var header = document.createElement('div');
  header.className = 'logout-modal-header';

  var icon = document.createElement('div');
  icon.className = 'icon';
  icon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><circle cx="12" cy="10" r="2.5"/></svg>';

  var title = document.createElement('h3');
  title.id = 'maintenanceModalTitle';
  title.textContent = 'Mode Pemeliharaan';

  header.appendChild(icon);
  header.appendChild(title);

  var body = document.createElement('div');
  body.className = 'logout-modal-body';
  var msg = document.createElement('p');
  msg.textContent = message || 'Server sedang dalam pemeliharaan. Silakan coba lagi nanti.';
  body.appendChild(msg);

  var footer = document.createElement('div');
  footer.className = 'logout-modal-footer';

  var okBtn = document.createElement('button');
  okBtn.className = 'btn btn-danger';
  okBtn.textContent = 'OK';
  okBtn.type = 'button';
  okBtn.addEventListener('click', function () {
    document.body.removeChild(overlay);
  });

  footer.appendChild(okBtn);

  modal.appendChild(header);
  modal.appendChild(body);
  modal.appendChild(footer);

  overlay.appendChild(modal);
  document.body.appendChild(overlay);

  overlay.addEventListener('click', function (e) {
    if (e.target === overlay) {
      document.body.removeChild(overlay);
    }
  });

  function handleKeydown(e) {
    if (e.key === 'Escape') {
      if (document.body.contains(overlay)) {
        document.body.removeChild(overlay);
        document.removeEventListener('keydown', handleKeydown);
      }
    }
  }
  document.addEventListener('keydown', handleKeydown);

  okBtn.focus();
}

if (loginForm) {
  loginForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const username = document.getElementById('username').value.trim();
    const password = passwordInput.value;

    if (!username || !password) {
      showAlert('Mohon isi username dan password.');
      return;
    }

    const submitBtn = loginForm.querySelector('.btn-submit');
    const originalText = 'Masuk';
    let keepDisabled = false;

    submitBtn.disabled = true;
    submitBtn.classList.add('is-loading');
    submitBtn.innerHTML = '<span class="spinner"></span> Memproses...';

    try {
      const res = await fetch('/admin-api/auth/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'include',
        body: JSON.stringify({ username, password })
      });

      const data = await res.json();

      if (res.status === 503 && data.status === 'maintenance') {
        showMaintenanceModal(data.message || 'Server sedang dalam pemeliharaan. Silakan coba lagi nanti.');
        return;
      }

      if (res.status === 423 && data.locked_until) {
        keepDisabled = true;
        const lockedUntil = new Date(data.locked_until);
        const now = new Date();
        let seconds = Math.max(0, Math.floor((lockedUntil - now) / 1000));

        showLockoutModal(seconds, function() {
          submitBtn.disabled = false;
          submitBtn.classList.remove('is-loading');
          submitBtn.innerHTML = originalText;
        });

        return;
      }

      if (!res.ok) throw new Error(data.error || data.message || 'Login gagal.');

      if (data.requires_2fa) {
        showTwofaStep();
        return;
      }

      if (data.session_timeout) {
        try { sessionStorage.setItem('admin_session_timeout', data.session_timeout); } catch (e) {}
      }

      if (data.role) {
        try { sessionStorage.setItem('admin_role', data.role); } catch (e) {}
      }

      window.location.href = '/admin/HTML/dashboard.html';

    } catch (err) {
      showAlert(err.message);
    } finally {
      if (!keepDisabled) {
        submitBtn.disabled = false;
        submitBtn.classList.remove('is-loading');
        submitBtn.innerHTML = originalText;
      }
    }
  });
}

if (twofaForm) {
  twofaForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const code = document.getElementById('twofaCode').value.trim();

    if (!/^\d{6}$/.test(code)) {
      showAlert('Masukkan kode verifikasi 6 digit.');
      return;
    }

    const submitBtn = twofaForm.querySelector('.btn-submit');
    submitBtn.disabled = true;
    submitBtn.classList.add('is-loading');
    submitBtn.innerHTML = '<span class="spinner"></span> Memverifikasi...';

    try {
      const res = await fetch('/admin-api/auth/verify-2fa', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        credentials: 'include',
        body: JSON.stringify({ code })
      });

      const data = await res.json();
      if (!res.ok) throw new Error(data.error || data.message || 'Verifikasi gagal.');

      if (data.role) {
        try { sessionStorage.setItem('admin_role', data.role); } catch (e) {}
      }

      window.location.href = 'dashboard.html';

    } catch (err) {
      showAlert(err.message);
      submitBtn.disabled = false;
      submitBtn.classList.remove('is-loading');
      submitBtn.innerHTML = 'Verifikasi';
    }
  });
}

const twofaBack = document.getElementById('twofaBack');
if (twofaBack) {
  twofaBack.addEventListener('click', (e) => {
    e.preventDefault();
    showLoginStep();
  });
}

function initGlobalSearch() {
  const globalSearchInput = document.getElementById('global-search-input');

  if (!globalSearchInput) {
    return;
  }

  const q = new URLSearchParams(window.location.search).get('q');
  if (q) {
    globalSearchInput.value = q;
  }

  let resultsEl = document.getElementById('global-search-results');

  if (!resultsEl) {
    resultsEl = document.createElement('div');
    resultsEl.id = 'global-search-results';
    resultsEl.className = 'global-search-dropdown';
    globalSearchInput.parentElement.appendChild(resultsEl);
  }

  let activeIndex = -1;
  let currentItems = [];
  const debounceSearch = window.debounce(function (value) {
    fetchSuggestions(value);
  }, 300);

  function highlight(text, query) {
    const lower = text.toLowerCase();
    const idx = lower.indexOf(query.toLowerCase());
    if (idx === -1 || query === '') {
      return escapeHtml(text);
    }
    return (
      escapeHtml(text.slice(0, idx)) +
      '<mark>' + escapeHtml(text.slice(idx, idx + query.length)) + '</mark>' +
      escapeHtml(text.slice(idx + query.length))
    );
  }

  function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
  }

  function renderSuggestions(suggestions, query) {
    resultsEl.innerHTML = '';
    currentItems = suggestions;
    activeIndex = -1;

    if (!suggestions.length) {
      const empty = document.createElement('div');
      empty.className = 'dropdown-empty';
      empty.textContent = 'Tidak ada hasil untuk "' + query + '"';
      resultsEl.appendChild(empty);
      resultsEl.style.display = 'block';
      return;
    }

    suggestions.forEach((suggestion, index) => {
      const item = document.createElement('a');
      item.className = 'dropdown-item';
      item.href = suggestion.href;
      item.dataset.index = index;

      const typeBadge = document.createElement('span');
      typeBadge.className = 'dropdown-type';
      typeBadge.textContent = suggestion.type;

      const label = document.createElement('span');
      label.className = 'dropdown-label';
      label.innerHTML = highlight(suggestion.label, query);

      const meta = document.createElement('span');
      meta.className = 'dropdown-meta';
      meta.textContent = suggestion.meta;

      item.appendChild(typeBadge);
      item.appendChild(label);
      item.appendChild(meta);

      item.addEventListener('mousedown', (e) => {
        e.preventDefault();
        window.location.href = suggestion.href;
      });

      resultsEl.appendChild(item);
    });

    resultsEl.style.display = 'block';
  }

  async function fetchSuggestions(value) {
    try {
      const res = await fetch('/admin-api/search/suggest?q=' + encodeURIComponent(value), {
        headers: { 'Accept': 'application/json' },
        credentials: 'include'
      });
      if (!res.ok) throw new Error('Gagal memuat saran.');
      const data = await res.json();
      if (globalSearchInput.value.trim() === value) {
        renderSuggestions(data.suggestions || [], value);
      }
    } catch (err) {
      resultsEl.style.display = 'none';
    }
  }

  globalSearchInput.addEventListener('input', () => {
    const value = globalSearchInput.value.trim();

    if (value.length === 0) {
      resultsEl.style.display = 'none';
      resultsEl.innerHTML = '';
      currentItems = [];
      return;
    }

    debounceSearch(value);
  });

  globalSearchInput.addEventListener('keydown', (e) => {
    const items = resultsEl.querySelectorAll('.dropdown-item');
    if (items.length === 0) {
      if (e.key === 'Enter' && globalSearchInput.value.trim().length > 0) {
        window.location.href = 'search.html?q=' + encodeURIComponent(globalSearchInput.value.trim());
      }
      return;
    }

    if (e.key === 'ArrowDown') {
      e.preventDefault();
      activeIndex = (activeIndex + 1) % items.length;
      setActive(items);
    } else if (e.key === 'ArrowUp') {
      e.preventDefault();
      activeIndex = (activeIndex - 1 + items.length) % items.length;
      setActive(items);
    } else if (e.key === 'Enter') {
      e.preventDefault();
      if (activeIndex >= 0 && currentItems[activeIndex]) {
        window.location.href = currentItems[activeIndex].href;
      } else {
        window.location.href = 'search.html?q=' + encodeURIComponent(globalSearchInput.value.trim());
      }
    } else if (e.key === 'Escape') {
      resultsEl.style.display = 'none';
    }
  });

  function setActive(items) {
    items.forEach((item, index) => {
      item.classList.toggle('active', index === activeIndex);
    });
  }

  document.addEventListener('click', (e) => {
    if (!globalSearchInput.contains(e.target) && !resultsEl.contains(e.target)) {
      resultsEl.style.display = 'none';
    }
  });
}

if (document.readyState !== 'loading') {
  initGlobalSearch();
} else {
  document.addEventListener('DOMContentLoaded', initGlobalSearch);
}

function initSidebarToggle() {
  const sidebar = document.querySelector('.sidebar');
  const toggleBtn = document.querySelector('.menu-toggle');
  const backdrop = document.querySelector('.sidebar-backdrop');

  if (!sidebar || !toggleBtn) {
    return;
  }

  function openSidebar() {
    sidebar.classList.add('open');
    if (backdrop) {
      backdrop.classList.add('show');
    }
    document.body.style.overflow = 'hidden';
  }

  function closeSidebar() {
    sidebar.classList.remove('open');
    if (backdrop) {
      backdrop.classList.remove('show');
    }
    document.body.style.overflow = '';
  }

  toggleBtn.addEventListener('click', function (e) {
    e.stopPropagation();
    if (sidebar.classList.contains('open')) {
      closeSidebar();
    } else {
      openSidebar();
    }
  });

  if (backdrop) {
    backdrop.addEventListener('click', closeSidebar);
  }

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && sidebar.classList.contains('open')) {
      closeSidebar();
    }
  });

  window.addEventListener('resize', function () {
    if (window.innerWidth > 1024 && sidebar.classList.contains('open')) {
      closeSidebar();
    }
  });
}

if (document.readyState !== 'loading') {
  initSidebarToggle();
} else {
  document.addEventListener('DOMContentLoaded', initSidebarToggle);
}

window.adminApiRequest = async function(url, options = {}) {
  const metaTag = document.querySelector('meta[name="csrf-token"]');
  const csrfToken = metaTag ? metaTag.getAttribute('content') : '';

  const method = (options.method || 'GET').toUpperCase();
  const headers = Object.assign({
    'Accept': 'application/json',
    'X-Requested-With': 'XMLHttpRequest'
  }, options.headers || {});

  if (['POST', 'PUT', 'PATCH', 'DELETE'].includes(method)) {
    if (csrfToken) {
      headers['X-CSRF-TOKEN'] = csrfToken;
    }
  }

  const fetchOptions = Object.assign({}, options, {
    method: method,
    headers: headers,
    credentials: options.credentials || 'include'
  });

  const response = await fetch(url, fetchOptions);

  if (response.status === 419) {
    showAlert('Sesi Anda telah kedaluwarsa atau token CSRF tidak valid. Halaman akan dimuat ulang.');
    setTimeout(() => {
      window.location.reload();
    }, 2000);
    throw new Error('CSRF token mismatch (419)');
  }

  return response;
};
