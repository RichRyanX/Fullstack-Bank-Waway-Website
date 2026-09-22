// ===== Pengaturan Umum (Settings) page logic =====

var SETTINGS_KEY = 'bankwaway_settings';

function loadSettings() {
  try {
    return JSON.parse(localStorage.getItem(SETTINGS_KEY)) || {};
  } catch (e) {
    return {};
  }
}

function saveSettings(data) {
  var current = loadSettings();
  for (var key in data) {
    if (Object.prototype.hasOwnProperty.call(data, key)) {
      current[key] = data[key];
    }
  }
  localStorage.setItem(SETTINGS_KEY, JSON.stringify(current));
}

// Save a settings form to the backend via PUT /admin-api/pengaturan.
// `form` may be null (e.g. for standalone toggles/logo uploads) in which case
// the request is still sent but without button feedback.
function saveFormToServer(form, payload) {
  var saveBtn = form ? form.querySelector('.btn-save') : null;
  var original = saveBtn ? saveBtn.textContent : '';
  if (saveBtn) {
    saveBtn.disabled = true;
    saveBtn.textContent = 'Menyimpan...';
  }

  return window.adminApiRequest('/admin-api/pengaturan', {
    method: 'PUT',
    headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
    body: JSON.stringify(payload)
  })
    .then(function (res) {
      if (!res.ok) throw new Error('Gagal menyimpan (status ' + res.status + ')');
      return res.json();
    })
    .then(function () {
      if (saveBtn) {
        saveBtn.textContent = 'Tersimpan ✓';
        saveBtn.classList.add('saved');
        setTimeout(function () {
          saveBtn.textContent = original;
          saveBtn.classList.remove('saved');
          saveBtn.disabled = false;
        }, 1800);
      }
    })
    .catch(function (err) {
      console.error(err);
      if (saveBtn) {
        saveBtn.textContent = original;
        saveBtn.disabled = false;
      }
      alert('Gagal menyimpan pengaturan.');
      throw err;
    });
}

// Bind a form's submit to collect its fields and persist them to the backend.
// `fields` is an array of { id, key, type } where type is 'text'|'checkbox'|'select'.
function bindFormPersistence(formId, fields) {
  var form = document.getElementById(formId);
  if (!form) return;
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    var payload = {};
    fields.forEach(function (f) {
      var el = document.getElementById(f.id);
      if (!el) return;
      if (f.type === 'checkbox') {
        payload[f.key] = el.checked;
      } else {
        payload[f.key] = el.value;
      }
    });
    saveFormToServer(form, payload);
  });
}

function bindTogglePersistence(id, key) {
  var el = document.getElementById(id);
  if (!el) return;
  var saved = loadSettings()[key];
  if (saved !== undefined) {
    el.checked = !!saved;
  }
  el.addEventListener('change', function () {
    var data = {};
    data[key] = el.checked;
    saveSettings(data);
  });
}

function bindInputPersistence(id, key) {
  var el = document.getElementById(id);
  if (!el) return;
  var saved = loadSettings()[key];
  if (saved !== undefined) {
    el.value = saved;
  }
  el.addEventListener('change', function () {
    var data = {};
    data[key] = el.value;
    saveSettings(data);
  });
}

function showToast(message, type) {
    var toast = document.createElement('div');
    toast.className = 'toast-notification ' + (type || 'info');
    toast.textContent = message;
    toast.style.position = 'fixed';
    toast.style.bottom = '20px';
    toast.style.right = '20px';
    toast.style.padding = '12px 24px';
    toast.style.background = type === 'success' ? '#10b981' : '#3b82f6';
    toast.style.color = '#fff';
    toast.style.borderRadius = '8px';
    toast.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
    toast.style.zIndex = '10000';
    toast.style.fontWeight = '500';
    toast.style.transition = 'opacity 0.3s ease';
    document.body.appendChild(toast);
    setTimeout(function () {
        toast.style.opacity = '0';
        setTimeout(function () { toast.remove(); }, 300);
    }, 3000);
}

document.addEventListener('DOMContentLoaded', function () {
  // ---- Existing: footer form ----
  var form = document.getElementById('footerForm');
  var alamatInput = document.getElementById('alamatKantor');
  var previewAddress = document.getElementById('previewAddress');

  // Live-update the footer preview as the office address is edited
  if (alamatInput && previewAddress) {
    alamatInput.addEventListener('input', function () {
      previewAddress.textContent = alamatInput.value || previewAddress.textContent;
    });
  }

  // Load existing settings from the backend and populate the form
  function loadSettingsFromServer() {
    fetch('/admin-api/pengaturan', {
      method: 'GET',
      headers: { 'Accept': 'application/json' },
      credentials: 'include'
    })
      .then(function (res) {
        if (!res.ok) throw new Error('Gagal memuat pengaturan (status ' + res.status + ')');
        return res.json();
      })
      .then(function (data) {
        // Text/select inputs
        var map = {
          phoneCS: data.phone_cs,
          emailPublik: data.email_publik,
          alamatKantor: data.alamat_kantor,
          whatsapp: data.whatsapp_url,
          instagram: data.instagram_url,
          x: data.x_url,
          facebook: data.facebook_url,
          siteName: data.site_name,
          siteTagline: data.site_tagline,
          lockoutDuration: data.lockout_duration,
          sessionTimeout: data.session_timeout,
          notifEmail: data.notif_email
        };
        Object.keys(map).forEach(function (id) {
          var el = document.getElementById(id);
          if (el && map[id] !== null && map[id] !== undefined) {
            el.value = map[id];
          }
        });

        // Checkbox toggles
        var toggles = {
          twoFactorToggle: data.two_factor,
          lockoutToggle: data.lockout,
          notifLogin: data.notif_login,
          notifThreat: data.notif_threat,
          notifWeekly: data.notif_weekly,
          maintenanceToggle: data.maintenance
        };
        Object.keys(toggles).forEach(function (id) {
          var el = document.getElementById(id);
          if (el && toggles[id] !== null && toggles[id] !== undefined) {
            el.checked = !!toggles[id];
          }
        });

        // Restore the site logo preview from the saved data so that the
        // uploaded logo persists across page reloads.
        if (data.site_logo && logoPreview) {
          logoPreview.innerHTML = '<img src="' + data.site_logo + '" alt="Logo">';
        }

        // Rebuild the compliance badges panel from the saved data so that
        // changes persist across page reloads.
        if (Array.isArray(data.badges) && badgesPanel) {
          var savedItems = badgesPanel.querySelectorAll('.badge-item');
          savedItems.forEach(function (item) { item.remove(); });
          data.badges.forEach(function (badge) {
            badgesPanel.insertBefore(createBadgeItem(badge), addBadgeBtn);
          });
          renderPreviewBadges();
        }

        if (previewAddress && data.alamat_kantor) {
          previewAddress.textContent = data.alamat_kantor;
        }

        if (data.last_backup_at && backupStatus) {
          var dot = backupStatus.querySelector('.status-dot');
          var text = backupStatus.querySelector('span:last-child');
          dot.className = 'status-dot ok';
          text.textContent = 'Cadangan terakhir: ' + data.last_backup_at;
        }
      })
      .catch(function (err) {
        console.error(err);
      });
  }

  loadSettingsFromServer();

  // ---- Kontak & Informasi Footer ----
  bindFormPersistence('footerForm', [
    { id: 'phoneCS', key: 'phone_cs', type: 'text' },
    { id: 'emailPublik', key: 'email_publik', type: 'text' },
    { id: 'alamatKantor', key: 'alamat_kantor', type: 'text' },
    { id: 'whatsapp', key: 'whatsapp_url', type: 'text' },
    { id: 'instagram', key: 'instagram_url', type: 'text' },
    { id: 'x', key: 'x_url', type: 'text' },
    { id: 'facebook', key: 'facebook_url', type: 'text' }
  ]);

  // ---- Identity Situs ----
  bindFormPersistence('identityForm', [
    { id: 'siteName', key: 'site_name', type: 'text' },
    { id: 'siteTagline', key: 'site_tagline', type: 'text' }
  ]);

  // ---- Keamanan ----
  bindFormPersistence('securityForm', [
    { id: 'twoFactorToggle', key: 'two_factor', type: 'checkbox' },
    { id: 'lockoutToggle', key: 'lockout', type: 'checkbox' },
    { id: 'lockoutDuration', key: 'lockout_duration', type: 'text' },
    { id: 'sessionTimeout', key: 'session_timeout', type: 'text' }
  ]);

  // ---- Notifikasi ----
  bindFormPersistence('notifForm', [
    { id: 'notifLogin', key: 'notif_login', type: 'checkbox' },
    { id: 'notifThreat', key: 'notif_threat', type: 'checkbox' },
    { id: 'notifWeekly', key: 'notif_weekly', type: 'checkbox' },
    { id: 'notifEmail', key: 'notif_email', type: 'text' }
  ]);

  // ---- Badges panel: save feedback ----
  var saveBadgesBtn = document.getElementById('btnSaveBadges');
  if (saveBadgesBtn) {
    saveBadgesBtn.addEventListener('click', function () {
      var original = saveBadgesBtn.textContent;
      saveBadgesBtn.disabled = true;
      saveBadgesBtn.textContent = 'Menyimpan...';

      // Collect all badge items from the panel
      var items = badgesPanel ? badgesPanel.querySelectorAll('.badge-item') : [];
      var badges = [];
      items.forEach(function (item) {
        var logoImg = item.querySelector('.badge-logo img');
        var meta = item.querySelector('.badge-meta');
        var category = meta ? meta.querySelector('.meta-label') : null;
        var license = meta ? meta.querySelectorAll('.meta-value')[0] : null;
        var validUntil = meta ? meta.querySelectorAll('.meta-value')[1] : null;
        var reference = meta ? meta.querySelector('a') : null;
        badges.push({
          name: item.querySelector('.badge-name') ? item.querySelector('.badge-name').textContent : '',
          description: item.querySelector('.badge-desc') ? item.querySelector('.badge-desc').textContent : '',
          logo: logoImg ? logoImg.src : '',
          active: item.querySelector('.status-pill') ? item.querySelector('.status-pill').classList.contains('status-pill-green') : false,
          category: category ? category.textContent : '',
          license: license ? license.textContent : '',
          validUntil: validUntil ? validUntil.textContent : '',
          reference: reference ? reference.getAttribute('href') : ''
        });
      });

      window.adminApiRequest('/admin-api/pengaturan', {
        method: 'PUT',
        headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
        body: JSON.stringify({ badges: badges })
      })
        .then(function (res) {
          if (!res.ok) throw new Error('Gagal menyimpan (status ' + res.status + ')');
          return res.json();
        })
        .then(function () {
          saveBadgesBtn.textContent = 'Tersimpan ✓';
          saveBadgesBtn.classList.add('saved');
          setTimeout(function () {
            saveBadgesBtn.textContent = original;
            saveBadgesBtn.classList.remove('saved');
            saveBadgesBtn.disabled = false;
          }, 1800);
        })
        .catch(function (err) {
          console.error(err);
          saveBadgesBtn.textContent = original;
          saveBadgesBtn.disabled = false;
          alert('Gagal menyimpan pengaturan.');
        });
    });
  }

  // ---- Identity: logo upload preview & persistence ----
  var siteLogoInput = document.getElementById('siteLogoInput');
  var logoPreview = document.getElementById('logoPreview');
  if (siteLogoInput && logoPreview) {
    siteLogoInput.addEventListener('change', function () {
      var file = siteLogoInput.files && siteLogoInput.files[0];
      if (!file) return;
      var reader = new FileReader();
      reader.onload = function (e) {
        logoPreview.innerHTML = '<img src="' + e.target.result + '" alt="Logo">';
        // Persist the logo to the backend immediately
        saveFormToServer(null, { site_logo: e.target.result });
      };
      reader.readAsDataURL(file);
    });
  }

  // ---- Maintenance toggle (persist to backend on change) ----
  var maintenanceToggle = document.getElementById('maintenanceToggle');
  if (maintenanceToggle) {
    maintenanceToggle.addEventListener('change', function () {
      var status = maintenanceToggle.checked;
      window.adminApiRequest('/admin-api/maintenance/toggle', {
        method: 'POST',
        headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
        body: JSON.stringify({ status: status })
      })
        .then(function (res) {
          if (!res.ok) throw new Error('Gagal mengubah mode pemeliharaan');
          return res.json();
        })
        .then(function (data) {
          if (data.success) {
            showToast('Mode pemeliharaan ' + (data.status ? 'diaktifkan' : 'dinonaktifkan'), 'success');
          }
        })
        .catch(function (err) {
          console.error(err);
          maintenanceToggle.checked = !status;
          alert('Gagal mengubah mode pemeliharaan.');
        });
    });
  }

  // ---- Backup & cache actions ----
  var backupBtn = document.getElementById('btnBackup');
  var backupStatus = document.getElementById('backupStatus');
  if (backupBtn && backupStatus) {
    backupBtn.addEventListener('click', function () {
      var dot = backupStatus.querySelector('.status-dot');
      var text = backupStatus.querySelector('span:last-child');
      dot.className = 'status-dot busy';
      text.textContent = 'Membuat cadangan...';
      backupBtn.disabled = true;
      window.adminApiRequest('/admin-api/maintenance/backup', {
        method: 'POST',
        headers: { 'Accept': 'application/json' }
      })
        .then(function (res) {
          if (!res.ok) throw new Error('Gagal membuat cadangan');
          return res.json();
        })
        .then(function (data) {
          if (data.success) {
            dot.className = 'status-dot ok';
            text.textContent = 'Cadangan terakhir: ' + data.timestamp;
            saveSettings({ lastBackup: data.timestamp });
            if (data.file_url) {
              window.location.href = data.file_url;
            }
            showToast('Cadangan data berhasil dibuat', 'success');
          }
        })
        .catch(function (err) {
          console.error(err);
          dot.className = 'status-dot error';
          text.textContent = 'Gagal membuat cadangan';
          alert('Gagal membuat cadangan data.');
        })
        .finally(function () {
          backupBtn.disabled = false;
        });
    });
  }

  var clearCacheBtn = document.getElementById('btnClearCache');
  if (clearCacheBtn) {
    clearCacheBtn.addEventListener('click', function () {
      var original = clearCacheBtn.textContent;
      clearCacheBtn.disabled = true;
      clearCacheBtn.textContent = 'Membersihkan...';
      window.adminApiRequest('/admin-api/maintenance/clear-cache', {
        method: 'POST',
        headers: { 'Accept': 'application/json' }
      })
        .then(function (res) {
          if (!res.ok) throw new Error('Gagal membersihkan cache');
          return res.json();
        })
        .then(function (data) {
          if (data.success) {
            clearCacheBtn.textContent = 'Cache dibersihkan ✓';
            clearCacheBtn.classList.add('saved');
            showToast(data.message || 'Cache berhasil dibersihkan', 'success');
            setTimeout(function () {
              clearCacheBtn.textContent = original;
              clearCacheBtn.classList.remove('saved');
              clearCacheBtn.disabled = false;
            }, 2000);
          }
        })
        .catch(function (err) {
          console.error(err);
          clearCacheBtn.textContent = original;
          clearCacheBtn.disabled = false;
          alert('Gagal membersihkan cache.');
        });
    });
  }

  // Restore last backup timestamp if present
  if (backupStatus) {
    var lastBackup = loadSettings().lastBackup;
    if (lastBackup) {
      var dot = backupStatus.querySelector('.status-dot');
      var text = backupStatus.querySelector('span:last-child');
      dot.className = 'status-dot ok';
      text.textContent = 'Cadangan terakhir: ' + new Date(lastBackup).toLocaleString('id-ID');
    }
  }

  // ---- Compliance badges ----
  var badgesPanel = document.querySelector('.badges-panel');
  var previewBadges = document.getElementById('previewBadges');

  // Render the footer preview badge boxes to match the current badge items
  function renderPreviewBadges() {
    if (!previewBadges) return;
    previewBadges.innerHTML = '';
    var items = badgesPanel ? badgesPanel.querySelectorAll('.badge-item') : [];
    items.forEach(function (item) {
      var logo = item.querySelector('.badge-logo img');
      var box = document.createElement('div');
      box.className = 'footer-badge-box';
      if (logo && logo.src) {
        var img = document.createElement('img');
        img.src = logo.src;
        img.alt = item.querySelector('.badge-name') ? item.querySelector('.badge-name').textContent : 'Badge';
        box.appendChild(img);
      }
      previewBadges.appendChild(box);
    });
  }

  // Set a logo image into a badge-logo element (replaces any existing img)
  function setBadgeLogo(logoEl, src) {
    if (!logoEl) return;
    logoEl.innerHTML = '';
    var img = document.createElement('img');
    img.src = src;
    img.alt = 'Logo';
    logoEl.appendChild(img);
  }

  // Badge logo upload preview
  document.querySelectorAll('.badge-upload').forEach(function (input) {
    input.addEventListener('change', function () {
      var file = input.files && input.files[0];
      var targetId = input.getAttribute('data-target');
      var target = targetId && document.getElementById(targetId);
      if (!file || !target) return;
      var reader = new FileReader();
      reader.onload = function (e) {
        setBadgeLogo(target, e.target.result);
        renderPreviewBadges();
      };
      reader.readAsDataURL(file);
    });
  });

  // Remove a badge item
  function bindRemoveBadge(btn) {
    btn.addEventListener('click', function () {
      var item = btn.closest('.badge-item');
      if (!item) return;
      if (!confirm('Hapus lencana kepatuhan ini?')) return;
      item.remove();
      renderPreviewBadges();
    });
  }
  document.querySelectorAll('.btn-remove-badge').forEach(bindRemoveBadge);

  // Edit a badge item (opens the modal pre-filled)
  function bindEditBadge(btn) {
    btn.addEventListener('click', function () {
      var item = btn.closest('.badge-item');
      if (!item) return;
      openBadgeModal(item);
    });
  }
  document.querySelectorAll('.btn-edit-badge').forEach(bindEditBadge);

  // ---- Add compliance badge via modal ----
  var badgeModal = document.getElementById('badgeModal');
  var badgeForm = document.getElementById('badgeForm');
  var badgeLogoInput = document.getElementById('badgeLogoInput');
  var badgeLogoPreview = document.getElementById('badgeLogoPreview');
  var badgeModalSave = document.getElementById('badgeModalSave');
  var badgeModalCancel = document.getElementById('badgeModalCancel');
  var badgeModalClose = document.getElementById('badgeModalClose');
  var pendingBadgeLogo = null;
  var editingItem = null;
  var badgeModalTitleText = document.getElementById('badgeModalTitleText');

  function openBadgeModal(item) {
    if (!badgeModal) return;
    editingItem = item || null;
    badgeForm.reset();
    badgeForm.querySelector('#badgeActive').checked = true;
    pendingBadgeLogo = null;
    badgeLogoPreview.innerHTML =
      '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>';

    if (item) {
      // Pre-fill the form with the existing badge data
      var name = item.querySelector('.badge-name').textContent;
      var desc = item.querySelector('.badge-desc').textContent;
      var meta = item.querySelector('.badge-meta');
      var category = meta ? meta.querySelector('.meta-label') : null;
      var license = meta ? meta.querySelector('.meta-value') : null;
      var validUntil = meta ? meta.querySelectorAll('.meta-value')[1] : null;
      var reference = meta ? meta.querySelector('a') : null;
      var active = item.querySelector('.status-pill').classList.contains('status-pill-green');
      var logoImg = item.querySelector('.badge-logo img');

      badgeForm.querySelector('#badgeName').value = name;
      badgeForm.querySelector('#badgeDesc').value = desc;
      if (category) badgeForm.querySelector('#badgeCategory').value = category.textContent;
      if (license) badgeForm.querySelector('#badgeLicense').value = license.textContent;
      if (validUntil) {
        var vText = validUntil.textContent.replace(' (Kadaluarsa)', '');
        badgeForm.querySelector('#badgeValidUntil').value = vText;
      }
      if (reference) badgeForm.querySelector('#badgeReference').value = reference.getAttribute('href');
      badgeForm.querySelector('#badgeActive').checked = active;
      if (logoImg && logoImg.src) {
        pendingBadgeLogo = logoImg.src;
        badgeLogoPreview.innerHTML = '<img src="' + logoImg.src + '" alt="Logo">';
      }
      if (badgeModalTitleText) badgeModalTitleText.textContent = 'Edit Lencana Kepatuhan';
      if (badgeModalSave) badgeModalSave.textContent = 'Simpan Perubahan';
    } else {
      if (badgeModalTitleText) badgeModalTitleText.textContent = 'Tambah Lencana Kepatuhan';
      if (badgeModalSave) badgeModalSave.textContent = 'Tambah Lencana';
    }

    badgeModal.hidden = false;
    document.body.style.overflow = 'hidden';
    var nameInput = badgeForm.querySelector('#badgeName');
    if (nameInput) nameInput.focus();
  }

  function closeBadgeModal() {
    if (!badgeModal) return;
    badgeModal.hidden = true;
    document.body.style.overflow = '';
  }

  function buildBadgeMetaHTML(data) {
    var meta = '';
    if (data.category) {
      meta +=
        '<span class="badge-meta-item">' +
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"></path><path d="M2 17l10 5 10-5"></path><path d="M2 12l10 5 10-5"></path></svg>' +
        '<span class="meta-label">' + data.category + '</span>' +
        '</span>';
    }
    if (data.license) {
      meta +=
        '<span class="badge-meta-item">' +
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><path d="M14 2v6h6"></path></svg>' +
        '<span class="meta-label">Izin:</span> <span class="meta-value">' + data.license + '</span>' +
        '</span>';
    }
    if (data.validUntil) {
      var expired = new Date(data.validUntil + 'T23:59:59') < new Date();
      meta +=
        '<span class="badge-meta-item">' +
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>' +
        '<span class="meta-label">Berlaku s.d:</span> <span class="meta-value' + (expired ? ' expired' : '') + '">' + data.validUntil + (expired ? ' (Kadaluarsa)' : '') + '</span>' +
        '</span>';
    }
    if (data.reference) {
      meta +=
        '<span class="badge-meta-item">' +
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>' +
        '<a href="' + data.reference + '" target="_blank" rel="noopener">Verifikasi</a>' +
        '</span>';
    }
    return meta ? '<div class="badge-meta">' + meta + '</div>' : '';
  }

  function createBadgeItem(data) {
    var item = document.createElement('div');
    item.className = 'badge-item';
    item.innerHTML =
      '<div class="badge-logo"></div>' +
      '<div class="badge-info">' +
      '<div class="badge-info-top">' +
      '<span class="badge-name"></span>' +
      '<span class="status-pill ' + (data.active ? 'status-pill-green' : 'status-pill-gray') + '">' + (data.active ? 'AKTIF' : 'NONAKTIF') + '</span>' +
      '</div>' +
      '<span class="badge-desc"></span>' +
      buildBadgeMetaHTML(data) +
      '<div class="badge-actions">' +
      '<label class="btn-file">' +
      '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>' +
      'Ganti File' +
      '<input type="file" accept="image/png,image/svg+xml" class="badge-upload">' +
      '</label>' +
      '<button type="button" class="btn-edit-badge" title="Edit lencana">' +
      '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>' +
      '</button>' +
      '<button type="button" class="btn-remove-badge" title="Hapus lencana">' +
      '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>' +
      '</button>' +
      '</div>' +
      '</div>';

    item.querySelector('.badge-name').textContent = data.name;
    item.querySelector('.badge-desc').textContent = data.description || '';
    if (data.logo) {
      setBadgeLogo(item.querySelector('.badge-logo'), data.logo);
    }

    var newInput = item.querySelector('.badge-upload');
    var newLogo = item.querySelector('.badge-logo');
    newInput.addEventListener('change', function () {
      var file = newInput.files && newInput.files[0];
      if (!file) return;
      var reader = new FileReader();
      reader.onload = function (e) {
        setBadgeLogo(newLogo, e.target.result);
        renderPreviewBadges();
      };
      reader.readAsDataURL(file);
    });

    bindRemoveBadge(item.querySelector('.btn-remove-badge'));
    bindEditBadge(item.querySelector('.btn-edit-badge'));
    return item;
  }

  var addBadgeBtn = document.getElementById('btnAddBadge');
  if (addBadgeBtn) {
    addBadgeBtn.addEventListener('click', function () {
      openBadgeModal();
    });
  }

  if (badgeLogoInput && badgeLogoPreview) {
    badgeLogoInput.addEventListener('change', function () {
      var file = badgeLogoInput.files && badgeLogoInput.files[0];
      if (!file) return;
      var reader = new FileReader();
      reader.onload = function (e) {
        pendingBadgeLogo = e.target.result;
        badgeLogoPreview.innerHTML = '<img src="' + e.target.result + '" alt="Logo">';
      };
      reader.readAsDataURL(file);
    });
  }

  if (badgeModalSave) {
    badgeModalSave.addEventListener('click', function () {
      var name = badgeForm.querySelector('#badgeName').value.trim();
      if (!name) {
        badgeForm.querySelector('#badgeName').focus();
        return;
      }
      var data = {
        name: name,
        description: badgeForm.querySelector('#badgeDesc').value.trim(),
        category: badgeForm.querySelector('#badgeCategory').value,
        license: badgeForm.querySelector('#badgeLicense').value.trim(),
        validUntil: badgeForm.querySelector('#badgeValidUntil').value,
        reference: badgeForm.querySelector('#badgeReference').value.trim(),
        active: badgeForm.querySelector('#badgeActive').checked,
        logo: pendingBadgeLogo
      };

      var original = badgeModalSave.textContent;
      var feedback = 'Ditambahkan ✓';

      if (editingItem) {
        // Update the existing badge item in place
        editingItem.querySelector('.badge-name').textContent = data.name;
        editingItem.querySelector('.badge-desc').textContent = data.description || '';
        var pill = editingItem.querySelector('.status-pill');
        pill.className = 'status-pill ' + (data.active ? 'status-pill-green' : 'status-pill-gray');
        pill.textContent = data.active ? 'AKTIF' : 'NONAKTIF';
        var oldMeta = editingItem.querySelector('.badge-meta');
        if (oldMeta) oldMeta.remove();
        var metaHTML = buildBadgeMetaHTML(data);
        if (metaHTML) {
          editingItem.querySelector('.badge-desc').insertAdjacentHTML('afterend', metaHTML);
        }
        if (data.logo) {
          setBadgeLogo(editingItem.querySelector('.badge-logo'), data.logo);
        }
        feedback = 'Tersimpan ✓';
      } else {
        var item = createBadgeItem(data);
        addBadgeBtn.parentNode.insertBefore(item, addBadgeBtn);
      }

      renderPreviewBadges();
      closeBadgeModal();

      badgeModalSave.textContent = feedback;
      badgeModalSave.classList.add('saved');
      setTimeout(function () {
        badgeModalSave.textContent = original;
        badgeModalSave.classList.remove('saved');
      }, 1600);
    });
  }

  if (badgeModalCancel) badgeModalCancel.addEventListener('click', closeBadgeModal);
  if (badgeModalClose) badgeModalClose.addEventListener('click', closeBadgeModal);
  if (badgeModal) {
    badgeModal.addEventListener('click', function (e) {
      if (e.target === badgeModal) closeBadgeModal();
    });
  }
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && badgeModal && !badgeModal.hidden) closeBadgeModal();
  });

  // Initial render of the footer preview badges
  renderPreviewBadges();
});