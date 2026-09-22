// ===== Repositori Laporan Institusional (Laporan & Kepatuhan) page logic =====

document.addEventListener('DOMContentLoaded', function () {

  // ---- Unified filter state ----
  var filters = {
    category: 'Tahunan',
    status: 'all',
    year: '',
    search: '',
    sort_order: 'newest',
    page: 1
  };

  // ---- Category switching ----
  var categoryItems = document.querySelectorAll('.category-item');
  var categoryTitle = document.getElementById('categoryTitle');
  var activeCategory = 'Tahunan';

  function setActiveCategory(item) {
    categoryItems.forEach(function (i) { i.classList.remove('active'); });
    item.classList.add('active');
    activeCategory = item.getAttribute('data-category') || item.querySelector('span').textContent.trim();
    filters.category = activeCategory;
    var label = item.querySelector('span').textContent.trim();
    if (categoryTitle) categoryTitle.textContent = 'Laporan ' + label;
  }

  categoryItems.forEach(function (item) {
    item.addEventListener('click', function (e) {
      e.preventDefault();
      setActiveCategory(item);
      filters.page = 1;
      loadReports();
    });
  });

  // ---- Upload modal ----
  var modalOverlay = document.getElementById('uploadModal');
  var openBtn = document.querySelector('.page-header .btn-primary');
  var closeBtn = document.getElementById('closeModalBtn');
  var cancelBtn = document.getElementById('cancelModalBtn');
  var uploadForm = document.getElementById('uploadForm');
  var categorySelect = document.getElementById('categorySelect');
  var tahunBukuInput = document.getElementById('tahunBuku');
  var documentTitleInput = document.getElementById('documentTitle');
  var fileInput = document.getElementById('fileInput');
  var fileDropzone = document.getElementById('fileDropzone');
  var dropzoneTitle = document.getElementById('dropzoneTitle');
  var dropzoneHint = document.getElementById('dropzoneHint');
  var fileSelected = document.getElementById('fileSelected');
  var fileSelectedName = document.getElementById('fileSelectedName');
  var fileSelectedSize = document.getElementById('fileSelectedSize');
  var fileRemoveBtn = document.getElementById('fileRemoveBtn');
  var formError = document.getElementById('formError');
  var submitBtn = document.getElementById('submitUploadBtn');
  var draftBtn = document.getElementById('draftUploadBtn');
  var statusSelect = document.getElementById('statusSelect');
  var modalTitle = document.getElementById('modalTitle');
  var modalSubtitle = document.getElementById('modalSubtitle');
  var editingId = null;
  var activeReportId = null;
  var docTableBody = document.querySelector('.doc-table tbody');
  var tableCount = document.querySelector('.table-count');
  var metricTotalCard = document.getElementById('metricTotal');
  var metricPublishedCard = document.getElementById('metricPublished');
  var metricDraftCard = document.getElementById('metricDraft');
  var metricArchivedCard = document.getElementById('metricArchived');
  var metricTotalValue = document.getElementById('metricTotalValue');
  var metricPublishedValue = document.getElementById('metricPublishedValue');
  var metricDraftValue = document.getElementById('metricDraftValue');
  var metricArchivedValue = document.getElementById('metricArchivedValue');
  var activeCategoryItem = document.querySelector('.category-item.active');
  var activeCountPill = activeCategoryItem ? activeCategoryItem.querySelector('.count-pill') : null;
  var activeCategoryPill = function () {
    var item = document.querySelector('.category-item.active');
    return item ? item.querySelector('.count-pill') : null;
  };

  function formatFileSize(bytes) {
    if (bytes === 0) return '0 B';
    var k = 1024;
    var sizes = ['B', 'KB', 'MB', 'GB'];
    var i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
  }

  function formatUploadDate(date) {
    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    return months[date.getMonth()] + ' ' + date.getDate() + ', ' + date.getFullYear();
  }

  function showError(message) {
    if (formError) {
      formError.textContent = message;
      formError.hidden = false;
    }
  }

  function clearError() {
    if (formError) {
      formError.textContent = '';
      formError.hidden = true;
    }
  }

  function resetDropzone() {
    if (fileInput) fileInput.value = '';
    if (fileDropzone) fileDropzone.classList.remove('has-file');
    if (dropzoneTitle) dropzoneTitle.textContent = 'Klik untuk memilih file';
    if (dropzoneHint) dropzoneHint.textContent = 'PDF, DOC, DOCX, XLS, XLSX · Maks 20MB';
    if (fileSelected) fileSelected.hidden = true;
    if (fileSelectedName) fileSelectedName.textContent = '';
    if (fileSelectedSize) fileSelectedSize.textContent = '';
    clearError();
  }

  function updateDropzone(file) {
    if (!file) {
      resetDropzone();
      return;
    }
    if (fileDropzone) fileDropzone.classList.add('has-file');
    if (dropzoneTitle) dropzoneTitle.textContent = file.name;
    if (dropzoneHint) dropzoneHint.textContent = 'File siap diunggah';
    if (fileSelectedName) fileSelectedName.textContent = file.name;
    if (fileSelectedSize) fileSelectedSize.textContent = formatFileSize(file.size);
    if (fileSelected) fileSelected.hidden = false;
    clearError();
  }

  if (fileDropzone) {
    fileDropzone.addEventListener('click', function () {
      if (fileInput) fileInput.click();
    });
  }

  if (fileInput) {
    fileInput.addEventListener('change', function (e) {
      var file = e.target.files[0];
      updateDropzone(file);
    });
  }

  if (fileRemoveBtn) {
    fileRemoveBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      resetDropzone();
    });
  }

  // Helper to get CSRF token from cookie
  function getCsrfToken() {
    var name = 'XSRF-TOKEN';
    var value = '; ' + document.cookie;
    var parts = value.split('; ' + name + '=');
    if (parts.length === 2) return parts.pop().split(';').shift();
    return null;
  }

  // Open modal: pre-select category based on active category item
  function openModal() {
    editingId = null;
    if (modalTitle) modalTitle.textContent = 'Upload Dokumen Baru';
    if (modalSubtitle) modalSubtitle.textContent = 'Unggah versi terbaru dokumen kepatuhan untuk diverifikasi.';
    if (submitBtn) submitBtn.textContent = 'Upload & Terbitkan';
    var activeItem = document.querySelector('.category-item.active');
    if (activeItem) {
      var label = activeItem.querySelector('span').textContent.trim();
      var options = categorySelect.options;
      for (var i = 0; i < options.length; i++) {
        if (options[i].value === label) {
          categorySelect.selectedIndex = i;
          break;
        }
      }
    }
    resetDropzone();
    tahunBukuInput.value = '';
    if (documentTitleInput) documentTitleInput.value = '';
    if (statusSelect) statusSelect.value = 'DRAFT';
    modalOverlay.classList.add('open');
  }

  function handleUploadTrigger() {
    var params = new URLSearchParams(window.location.search);
    if (params.get('action') === 'upload' || params.get('trigger') === 'upload') {
      openModal();
      if (fileInput) fileInput.focus();
      window.history.replaceState({}, document.title, window.location.pathname);
    }
  }

  handleUploadTrigger();

  function openEditModal(report) {
    editingId = report.id;
    if (modalTitle) modalTitle.textContent = 'Edit Metadata Dokumen';
    if (modalSubtitle) modalSubtitle.textContent = 'Perbarui metadata dan file dokumen kepatuhan.';
    if (submitBtn) submitBtn.textContent = 'Simpan Perubahan';
    if (documentTitleInput) documentTitleInput.value = report.title || report.original_filename || '';
    if (tahunBukuInput) tahunBukuInput.value = report.fiscal_year || '';
    if (categorySelect) {
      var options = categorySelect.options;
      for (var i = 0; i < options.length; i++) {
        if (options[i].value === (report.category || 'Tahunan')) {
          categorySelect.selectedIndex = i;
          break;
        }
      }
    }
    if (statusSelect) statusSelect.value = report.status || 'DRAFT';
    resetDropzone();
    modalOverlay.classList.add('open');
  }

  window.openEditModal = openEditModal;

  function closeModal() {
    modalOverlay.classList.remove('open');
  }

  if (openBtn) {
    openBtn.addEventListener('click', openModal);
  }
  if (closeBtn) {
    closeBtn.addEventListener('click', closeModal);
  }
  if (cancelBtn) {
    cancelBtn.addEventListener('click', closeModal);
  }
  // Close on overlay click
  modalOverlay.addEventListener('click', function (e) {
    if (e.target === modalOverlay) closeModal();
  });

  // ---- Form submission ----
  function submitUpload(status) {
    clearError();

    var category = categorySelect.value;
    var tahunBuku = tahunBukuInput.value.trim();
    var file = fileInput.files[0];
    var isEdit = editingId !== null;
    if (isEdit && statusSelect) status = statusSelect.value;

    if (status === 'PUBLISHED') {
      if (!category) {
        showError('Kategori wajib dipilih.');
        return;
      }
      if (!tahunBuku) {
        showError('Tahun Buku wajib diisi.');
        return;
      }
      if (!file && !isEdit) {
        showError('File Dokumen wajib dipilih.');
        return;
      }
    } else {
      if (!file && !category && !isEdit) {
        showError('Pilih file dokumen atau kategori untuk menyimpan draft.');
        return;
      }
    }

    if (submitBtn) submitBtn.disabled = true;
    if (draftBtn) draftBtn.disabled = true;
    if (submitBtn) submitBtn.textContent = 'Menyimpan...';

    var formData = new FormData();
    formData.append('category', category);
    formData.append('fiscal_year', tahunBuku);
    formData.append('title', documentTitleInput ? documentTitleInput.value.trim() : '');
    if (file) formData.append('file', file);
    formData.append('status', status);

    var csrfToken = getCsrfToken();
    var url = isEdit ? '/admin-api/compliance-reports/' + editingId : '/admin-api/compliance-reports';
    var method = isEdit ? 'POST' : 'POST';
    if (isEdit) formData.append('_method', 'PATCH');

    window.adminApiRequest(url, {
      method: method,
      headers: {
        'Accept': 'application/json'
      },
      body: formData
    })
    .then(function (response) {
      if (!response.ok) {
        return response.json().then(function (err) {
          throw new Error(err.message || 'Penyimpanan gagal');
        });
      }
      return response.json();
    })
    .then(function (data) {
      if (isEdit) {
        for (var i = 0; i < allReports.length; i++) {
          if (allReports[i].id === data.id) {
            allReports[i] = data;
            break;
          }
        }
      } else {
        allReports.unshift(data);
      }
      updateCategoryCounts();
      loadReports();
      if (isEdit) {
        refreshActiveDocument(data.id);
        loadDocumentHistory(data.id);
      }
      resetDropzone();
      tahunBukuInput.value = '';
      if (documentTitleInput) documentTitleInput.value = '';
      editingId = null;
      closeModal();
    })
    .catch(function (error) {
      showError('Terjadi kesalahan: ' + error.message);
    })
    .finally(function () {
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.textContent = editingId ? 'Simpan Perubahan' : 'Upload & Terbitkan';
      }
      if (draftBtn) draftBtn.disabled = false;
    });
  }

  uploadForm.addEventListener('submit', function (e) {
    e.preventDefault();
    submitUpload('PUBLISHED');
  });

  if (draftBtn) {
    draftBtn.addEventListener('click', function () {
      submitUpload('DRAFT');
    });
  }

  function buildRow(data) {
    var fileName = data.title || data.original_filename || 'Dokumen';
    var fileSize = data.file_size || '0 B';
    var year = data.fiscal_year || '';
    var uploadDate = formatUploadDate(new Date(data.created_at));
    var status = data.status === 'PUBLISHED' ? 'status-published' : (data.status === 'ARCHIVED' ? 'status-archived' : 'status-draft');
    var statusText = data.status || 'DRAFT';
    var uploadedBy = data.uploaded_by || 'Admin Utama';

    var tr = document.createElement('tr');
    tr.setAttribute('data-id', data.id);
    tr.innerHTML =
      '<td>' +
        '<div class="doc-cell">' +
          '<div class="file-icon file-icon-red">' +
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><path d="M14 2v6h6"></path></svg>' +
          '</div>' +
          '<div>' +
            '<a href="#" class="doc-title">' + fileName + '</a>' +
            '<span class="doc-meta">v1.0.0 · ' + fileSize + '</span>' +
          '</div>' +
        '</div>' +
      '</td>' +
      '<td class="doc-year">' + year + '</td>' +
      '<td class="doc-upload">' +
        '<span class="upload-date">' + uploadDate + '</span>' +
        '<span class="upload-by">by ' + uploadedBy + '</span>' +
      '</td>' +
      '<td><span class="status-dot ' + status + '">● ' + statusText + '</span></td>' +
      '<td>' +
        '<div class="row-actions">' +
          '<button class="icon-action" data-action="preview" aria-label="Pratinjau"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></button>' +
          '<button class="icon-action" data-action="download" aria-label="Download"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg></button>' +
          '<button class="icon-action" data-action="history" aria-label="Riwayat"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 3-6.7L3 8"></path><path d="M3 3v5h5"></path><path d="M12 7v5l4 2"></path></svg></button>' +
          '<div class="action-menu-wrap">' +
            '<button class="icon-action" data-action="menu" aria-label="Opsi lainnya"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg></button>' +
            '<div class="action-menu">' +
              '<button type="button" class="action-menu-item" data-menu-action="edit"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"></path></svg>Edit Metadata</button>' +
              '<button type="button" class="action-menu-item" data-menu-action="status" data-id="' + data.id + '" data-status="' + (data.status || 'DRAFT') + '"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"></path></svg>Ubah Status</button>' +
              '<div class="action-menu-divider"></div>' +
              '<button type="button" class="action-menu-item action-menu-item-danger" data-menu-action="archive"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>Arsipkan</button>' +
              '<button type="button" class="action-menu-item action-menu-item-danger" data-menu-action="delete"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>Hapus</button>' +
            '</div>' +
          '</div>' +
        '</div>' +
      '</td>';
    tr.addEventListener('click', function (e) {
      if (e.target.closest('.row-actions') || e.target.closest('.col-check')) return;
      selectDocument(data);
    });
    attachRowActions(tr, data);
    return tr;
  }

  function getFileUrl(doc) {
    if (doc.file_path) {
      return '/storage/' + doc.file_path;
    }
    return '';
  }

  function formatTimelineDate(value) {
    if (!value) return '';
    var d = new Date(value);
    if (isNaN(d.getTime())) return value;
    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    var pad = function (n) { return n < 10 ? '0' + n : n; };
    return pad(d.getDate()) + ' ' + months[d.getMonth()] + ' ' + d.getFullYear() + ' · ' + pad(d.getHours()) + ':' + pad(d.getMinutes());
  }

  function formatRelativeTime(value) {
    if (!value) return '';
    var d = new Date(value);
    if (isNaN(d.getTime())) return value;
    var diff = Math.floor((Date.now() - d.getTime()) / 1000);
    if (diff < 60) return 'Baru saja';
    if (diff < 3600) return Math.floor(diff / 60) + ' menit lalu';
    if (diff < 86400) return Math.floor(diff / 3600) + ' jam lalu';
    if (diff < 604800) return Math.floor(diff / 86400) + ' hari lalu';
    return formatTimelineDate(value);
  }

  function getActionBadgeClass(action) {
    var a = String(action || '').toUpperCase();
    if (a.indexOf('CREATE') !== -1) return 'action-badge-create';
    if (a.indexOf('UPDATE') !== -1) return 'action-badge-update';
    if (a.indexOf('DELETE') !== -1) return 'action-badge-delete';
    if (a.indexOf('LOGOUT') !== -1) return 'action-badge-logout';
    if (a.indexOf('LOGIN') !== -1) return 'action-badge-login';
    return 'action-badge-default';
  }

  function getActionLabel(action) {
    var a = String(action || '').toUpperCase();
    var map = {
      'LOGIN': 'Pengguna berhasil login ke sistem',
      'LOGOUT': 'Pengguna melakukan logout',
      'LOGIN_2FA_SENT': 'Kode 2FA terkirim ke email',
      'LOGIN_FAILED': 'Percobaan login gagal',
      'CREATE': 'Membuat data baru',
      'UPDATE': 'Memperbarui data',
      'DELETE': 'Menghapus data'
    };
    return map[a] || null;
  }

  function buildTimelineItem(log, dateText, isActive) {
    var action = log.action || '';
    var badgeClass = getActionBadgeClass(action);
    var badgeText = action || 'AKTIVITAS';
    var mappedLabel = getActionLabel(action);
    var actionTitle = mappedLabel || log.detail || log.action || 'Aktivitas';
    var author = log.admin && log.admin.name ? log.admin.name : 'Admin Utama';
    return '<li class="timeline-item' + (isActive ? ' active' : '') + '">' +
      '<span class="timeline-dot"></span>' +
      '<div class="timeline-content">' +
        '<div class="timeline-row">' +
          '<span class="action-badge ' + badgeClass + '">' + badgeText + '</span>' +
          '<p class="timeline-title">' + actionTitle + '</p>' +
          '<span class="timeline-date">' + dateText + '</span>' +
        '</div>' +
        '<span class="timeline-author">by ' + author + '</span>' +
      '</div>' +
      '</li>';
  }

  function buildDocumentCode(report) {
    if (report.document_code) return report.document_code;
    var year = report.fiscal_year ? String(report.fiscal_year).replace(/\D/g, '') : '0000';
    var padded = String(report.id || 0).padStart(3, '0');
    return 'AR-' + year + '-BWL-' + padded;
  }

  function getSecurityBadgeClass(level) {
    var value = String(level || '').toLowerCase();
    if (value.indexOf('public') !== -1) return 'tag-public';
    if (value.indexOf('restricted') !== -1) return 'tag-restricted';
    return 'tag-confidential';
  }

  function renderDocumentDetails(report) {
    var idEl = document.getElementById('metaDocumentId');
    var modifiedEl = document.getElementById('metaLastModified');
    var retentionEl = document.getElementById('metaRetention');
    var securityEl = document.getElementById('metaSecurityLevel');
    if (idEl) idEl.textContent = buildDocumentCode(report) || '-';
    if (modifiedEl) {
      var modified = report.updated_at || report.created_at;
      modifiedEl.textContent = modified ? formatTimelineDate(modified) : '-';
    }
    if (retentionEl) {
      var retention = report.retention_period || (report.retention_date ? String(report.retention_date).slice(0, 4) : null);
      retentionEl.textContent = retention ? '10 Years (' + retention + ')' : '-';
    }
    if (securityEl) {
      var level = report.security_level || '-';
      securityEl.textContent = level;
      securityEl.className = 'tag-confidential ' + getSecurityBadgeClass(level);
    }
  }

  function clearDocumentDetails() {
    activeReportId = null;
    var idEl = document.getElementById('metaDocumentId');
    var modifiedEl = document.getElementById('metaLastModified');
    var retentionEl = document.getElementById('metaRetention');
    var securityEl = document.getElementById('metaSecurityLevel');
    if (idEl) idEl.textContent = '-';
    if (modifiedEl) modifiedEl.textContent = '-';
    if (retentionEl) retentionEl.textContent = '-';
    if (securityEl) {
      securityEl.textContent = '-';
      securityEl.className = 'tag-confidential';
    }
    var timelineList = document.getElementById('activityTimelineList');
    if (timelineList) {
      timelineList.innerHTML = '<li class="timeline-empty">Tidak ada aktivitas untuk ditampilkan</li>';
    }
  }

  function renderActivityTimeline(docId) {
    var timelineList = document.getElementById('activityTimelineList');
    if (!timelineList) return;
    timelineList.innerHTML = '<li class="timeline-empty">Memuat riwayat aktivitas...</li>';
    var cacheBuster = new Date().getTime();
    fetch('/admin-api/audit-logs/' + docId + '/history?_=' + cacheBuster, {
      headers: { 'Accept': 'application/json' }
    })
    .then(function (response) {
      if (!response.ok) throw new Error('Gagal memuat riwayat');
      return response.json();
    })
    .then(function (payload) {
      var items = payload && Array.isArray(payload.logs) ? payload.logs : (Array.isArray(payload) ? payload : []);
      if (items.length === 0) {
        timelineList.innerHTML = '<li class="timeline-empty">Belum ada riwayat aktivitas untuk dokumen ini.</li>';
        return;
      }
      var html = '';
      for (var i = 0; i < items.length; i++) {
        var log = items[i];
        var dateText = formatRelativeTime(log.created_at);
        html += buildTimelineItem(log, dateText, i === 0);
      }
      timelineList.innerHTML = html;
    })
    .catch(function () {
      timelineList.innerHTML = '<li class="timeline-empty">Gagal memuat riwayat aktivitas dokumen.</li>';
    });
  }

  function selectDocument(report) {
    if (!report) return;
    activeReportId = report.id;
    var rows = docTableBody.querySelectorAll('tr[data-id]');
    rows.forEach(function (row) {
      row.classList.toggle('active', String(row.getAttribute('data-id')) === String(report.id));
    });
    renderDocumentDetails(report);
    renderActivityTimeline(report.id);
  }

  function refreshActiveDocument(docId) {
    if (!docId) return;
    var cacheBuster = new Date().getTime();
    fetch('/admin-api/compliance-reports/' + docId + '?_=' + cacheBuster, {
      headers: { 'Accept': 'application/json' }
    })
    .then(function (response) {
      if (!response.ok) throw new Error('Gagal memuat dokumen');
      return response.json();
    })
    .then(function (data) {
      for (var i = 0; i < allReports.length; i++) {
        if (String(allReports[i].id) === String(data.id)) {
          allReports[i] = data;
          break;
        }
      }
      if (String(activeReportId) === String(data.id)) {
        selectDocument(data);
      }
    })
    .catch(function () {});
  }

  function attachRowActions(tr, data) {
    var previewBtn = tr.querySelector('[data-action="preview"]');
    var downloadBtn = tr.querySelector('[data-action="download"]');
    var historyBtn = tr.querySelector('[data-action="history"]');
    var menuBtn = tr.querySelector('[data-action="menu"]');
    var editItem = tr.querySelector('[data-menu-action="edit"]');
    var statusItem = tr.querySelector('[data-menu-action="status"]');
    var archiveItem = tr.querySelector('[data-menu-action="archive"]');

    if (previewBtn) {
      previewBtn.addEventListener('click', function () {
        openPreviewModal(data);
      });
    }
    if (downloadBtn) {
      downloadBtn.addEventListener('click', function () {
        downloadDocument(data);
      });
    }
    if (historyBtn) {
      historyBtn.addEventListener('click', function () {
        loadDocumentHistory(data.id);
      });
    }
    if (menuBtn) {
      menuBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        toggleActionMenu(data.id);
      });
    }
    if (editItem) {
      editItem.addEventListener('click', function () {
        openEditModal(data);
        closeAllMenus();
      });
    }
    if (statusItem) {
      statusItem.addEventListener('click', function () {
        changeDocumentStatus(data);
      });
    }
    if (archiveItem) {
      archiveItem.addEventListener('click', function () {
        archiveDocument(data);
      });
    }
    var deleteItem = tr.querySelector('[data-menu-action="delete"]');
    if (deleteItem) {
      deleteItem.addEventListener('click', function () {
        deleteDocument(data);
      });
    }
  }

  function closeAllMenus() {
    document.querySelectorAll('.action-menu.open').forEach(function (menu) {
      menu.classList.remove('open');
    });
    document.querySelectorAll('.action-menu-wrap.open').forEach(function (wrap) {
      wrap.classList.remove('open');
    });
  }

  function toggleActionMenu(docId) {
    var row = docTableBody.querySelector('tr[data-id="' + docId + '"]');
    if (!row) return;
    var menu = row.querySelector('.action-menu');
    if (!menu) return;
    var wrap = row.querySelector('.action-menu-wrap');
    var isOpen = menu.classList.contains('open');
    closeAllMenus();
    if (!isOpen) {
      menu.classList.add('open');
      if (wrap) wrap.classList.add('open');
    }
  }

  function downloadDocument(data) {
    var url = data.file_url || getFileUrl(data);
    if (!url) return;
    var link = document.createElement('a');
    link.href = url;
    link.download = '';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  }

  window.downloadFile = function (fileUrl) {
    if (!fileUrl) return;
    var link = document.createElement('a');
    link.href = fileUrl;
    link.download = '';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  };

  function loadDocumentHistory(docId) {
    var historyModal = document.getElementById('historyModal');
    var historyTitle = document.getElementById('historyTitle');
    var historyList = document.getElementById('historyList');
    if (!historyModal || !historyList) return;
    var report = null;
    for (var i = 0; i < allReports.length; i++) {
      if (allReports[i].id === docId) {
        report = allReports[i];
        break;
      }
    }
    var docName = report ? (report.title || report.original_filename || 'Dokumen') : ('Dokumen #' + docId);
    if (historyTitle) historyTitle.textContent = 'Riwayat ' + docName;
    historyList.innerHTML = '';
    historyModal.classList.add('open');
    var cacheBuster = new Date().getTime();
    fetch('/admin-api/audit-logs/' + docId + '/history?_=' + cacheBuster, {
      headers: { 'Accept': 'application/json' }
    })
    .then(function (response) {
      if (!response.ok) throw new Error('Gagal memuat riwayat');
      return response.json();
    })
    .then(function (payload) {
      var items = payload && Array.isArray(payload.logs) ? payload.logs : (Array.isArray(payload) ? payload : (payload.data || []));
      if (items.length === 0) {
        historyList.innerHTML = '<li class="timeline-empty">Belum ada riwayat aktivitas untuk dokumen ini.</li>';
        return;
      }
      var html = '';
      for (var i = 0; i < items.length; i++) {
        var log = items[i];
        var dateText = formatTimelineDate(log.created_at);
        html += buildTimelineItem(log, dateText, i === 0);
      }
      historyList.innerHTML = html;
    })
    .catch(function () {
      historyList.innerHTML = '<li class="timeline-empty">Gagal memuat riwayat aktivitas dokumen.</li>';
    });
  }

  window.loadHistory = function (docId) {
    loadDocumentHistory(docId);
  };

  var statusModal = document.getElementById('statusModal');
  var statusModalTitle = document.getElementById('statusModalTitle');
  var statusModalSubtitle = document.getElementById('statusModalSubtitle');
  var statusSelectModal = document.getElementById('statusSelectModal');
  var statusFormError = document.getElementById('statusFormError');
  var closeStatusBtn = document.getElementById('closeStatusBtn');
  var cancelStatusBtn = document.getElementById('cancelStatusBtn');
  var saveStatusBtn = document.getElementById('saveStatusBtn');
  var statusTargetId = null;

  function openStatusModal(data) {
    statusTargetId = data.id;
    var docName = data.title || data.original_filename || ('Dokumen #' + data.id);
    if (statusModalTitle) statusModalTitle.textContent = 'Ubah Status Dokumen';
    if (statusModalSubtitle) statusModalSubtitle.textContent = 'Ubah status untuk "' + docName + '".';
    if (statusSelectModal) statusSelectModal.value = data.status || 'DRAFT';
    if (statusFormError) {
      statusFormError.textContent = '';
      statusFormError.hidden = true;
    }
    if (statusModal) statusModal.classList.add('open');
  }

  function closeStatusModal() {
    if (statusModal) statusModal.classList.remove('open');
    statusTargetId = null;
  }

  function changeDocumentStatus(data) {
    openStatusModal(data);
    closeAllMenus();
  }

  if (closeStatusBtn) closeStatusBtn.addEventListener('click', closeStatusModal);
  if (cancelStatusBtn) cancelStatusBtn.addEventListener('click', closeStatusModal);
  if (statusModal) {
    statusModal.addEventListener('click', function (e) {
      if (e.target === statusModal) closeStatusModal();
    });
  }

  if (saveStatusBtn) {
    saveStatusBtn.addEventListener('click', function () {
      if (statusTargetId === null) return;
      var newStatus = statusSelectModal ? statusSelectModal.value : 'DRAFT';
      var csrfToken = getCsrfToken();
      saveStatusBtn.disabled = true;
      saveStatusBtn.textContent = 'Menyimpan...';
      window.adminApiRequest('/admin-api/compliance-reports/' + statusTargetId + '/status', {
        method: 'PATCH',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ status: newStatus })
      })
      .then(function (response) {
        if (!response.ok) {
          return response.json().then(function (err) {
            throw new Error(err.message || 'Gagal mengubah status');
          });
        }
        return response.json();
      })
      .then(function (data) {
        for (var i = 0; i < allReports.length; i++) {
          if (allReports[i].id === data.id) {
            allReports[i] = data;
            break;
          }
        }
        updateCategoryCounts();
        loadReports();
        refreshActiveDocument(data.id);
        loadDocumentHistory(data.id);
        closeStatusModal();
      })
      .catch(function (error) {
        if (statusFormError) {
          statusFormError.textContent = 'Terjadi kesalahan: ' + error.message;
          statusFormError.hidden = false;
        }
      })
      .finally(function () {
        saveStatusBtn.disabled = false;
        saveStatusBtn.textContent = 'Simpan Status';
      });
    });
  }

  function archiveDocument(data) {
    closeAllMenus();
    var csrfToken = getCsrfToken();
    fetch('/admin-api/compliance-reports/' + data.id + '/status', {
      method: 'PATCH',
      headers: {
        'X-XSRF-TOKEN': csrfToken || '',
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ status: 'ARCHIVED' })
    })
    .then(function (response) {
      if (!response.ok) {
        return response.json().then(function (err) {
          throw new Error(err.message || 'Gagal mengarsipkan dokumen');
        });
      }
      return response.json();
    })
    .then(function (updated) {
      for (var i = 0; i < allReports.length; i++) {
        if (allReports[i].id === updated.id) {
          allReports[i] = updated;
          break;
        }
      }
      updateCategoryCounts();
      loadReports();
      refreshActiveDocument(updated.id);
      loadDocumentHistory(updated.id);
    })
    .catch(function () {});
  }

  function deleteDocument(data) {
    closeAllMenus();
    openDeleteModal(data);
  }

  var deleteModal = document.getElementById('deleteModal');
  var deleteForm = document.getElementById('deleteForm');
  var deleteDocumentIdInput = document.getElementById('deleteDocumentId');
  var deleteModalTitle = document.getElementById('deleteModalTitle');
  var deleteModalDescription = document.getElementById('deleteModalDescription');
  var closeDeleteBtn = document.getElementById('closeDeleteBtn');
  var cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
  var deletingId = null;

  function openDeleteModal(data) {
    deletingId = data.id;
    var docName = data.title || data.original_filename || ('Dokumen #' + data.id);
    if (deleteDocumentIdInput) deleteDocumentIdInput.value = data.id;
    if (deleteModalTitle) deleteModalTitle.textContent = 'Hapus Dokumen?';
    if (deleteModalDescription) deleteModalDescription.textContent = 'Anda akan menghapus "' + docName + '" secara permanen. Tindakan ini tidak dapat dibatalkan.';
    if (deleteForm) deleteForm.action = '/admin-api/compliance-reports/' + data.id;
    if (deleteModal) deleteModal.classList.add('open');
  }

  function closeDeleteModal() {
    if (deleteModal) deleteModal.classList.remove('open');
    deletingId = null;
  }

  if (closeDeleteBtn) closeDeleteBtn.addEventListener('click', closeDeleteModal);
  if (cancelDeleteBtn) cancelDeleteBtn.addEventListener('click', closeDeleteModal);
  if (deleteModal) {
    deleteModal.addEventListener('click', function (e) {
      if (e.target === deleteModal) closeDeleteModal();
    });
  }

  if (deleteForm) {
    deleteForm.addEventListener('submit', function (e) {
      e.preventDefault();
      var id = deletingId || (deleteDocumentIdInput ? deleteDocumentIdInput.value : null);
      if (!id) return;
      var csrfToken = getCsrfToken();
      window.adminApiRequest(deleteForm.action || ('/admin-api/compliance-reports/' + id), {
        method: 'DELETE',
        headers: {
          'Accept': 'application/json'
        }
      })
      .then(function (response) {
        if (!response.ok) {
          return response.json().then(function (err) {
            throw new Error(err.message || 'Gagal menghapus dokumen');
          });
        }
        return response.json();
      })
      .then(function () {
        for (var i = 0; i < allReports.length; i++) {
          if (String(allReports[i].id) === String(id)) {
            allReports.splice(i, 1);
            break;
          }
        }
        updateCategoryCounts();
        loadReports();
        if (String(activeReportId) === String(id)) {
          clearDocumentDetails();
        }
        closeDeleteModal();
      })
      .catch(function () {
        closeDeleteModal();
      });
    });
  }

  document.addEventListener('click', function (e) {
    if (!e.target.closest('.action-menu-wrap')) {
      closeAllMenus();
    }
  });

  function renderNewRow(data) {
    if (!docTableBody) return;
    docTableBody.insertBefore(buildRow(data), docTableBody.firstChild);
    if (tableCount) {
      var match = tableCount.textContent.match(/(\d+)/);
      if (match) {
        var total = parseInt(match[1], 10) + 1;
        tableCount.textContent = tableCount.textContent.replace(match[1], total);
      }
    }
  }

  var allReports = [];
  var categoryCounts = {};
  var totalDocuments = 0;
  var pagination = null;

  function updateCategoryCounts() {
    categoryItems.forEach(function (item) {
      var key = item.getAttribute('data-category') || item.querySelector('span').textContent.trim();
      var pill = item.querySelector('.count-pill');
      if (pill) {
        pill.textContent = String(categoryCounts[key] || 0);
      }
    });
  }

  function renderEmptyState() {
    docTableBody.innerHTML = '';
    var tr = document.createElement('tr');
    tr.innerHTML = '<td colspan="5" class="empty-state">Belum ada dokumen untuk kategori ini</td>';
    docTableBody.appendChild(tr);
  }

  function renderTable() {
    docTableBody.innerHTML = '';
    if (allReports.length === 0) {
      activeReportId = null;
      renderEmptyState();
      clearDocumentDetails();
    } else {
      allReports.forEach(function (report) {
        docTableBody.appendChild(buildRow(report));
      });
      var activeReport = null;
      for (var i = 0; i < allReports.length; i++) {
        if (String(allReports[i].id) === String(activeReportId)) {
          activeReport = allReports[i];
          break;
        }
      }
      if (!activeReport) {
        activeReport = allReports[0];
        activeReportId = activeReport.id;
      }
      selectDocument(activeReport);
    }
    if (tableCount) {
      tableCount.textContent = totalDocuments + ' dokumen';
    }
  }

  function updateSummaryMetrics(summary) {
    summary = summary || {};
    if (metricTotalValue) {
      metricTotalValue.textContent = summary.total != null ? summary.total : 0;
    }
    if (metricPublishedValue) {
      metricPublishedValue.textContent = summary.published != null ? summary.published : 0;
    }
    if (metricDraftValue) {
      metricDraftValue.textContent = summary.draft != null ? summary.draft : 0;
    }
    if (metricArchivedValue) {
      metricArchivedValue.textContent = summary.archived_count != null ? summary.archived_count : 0;
    }
  }

  function populateYearFilter() {
    var yearFilter = document.getElementById('yearFilter');
    if (!yearFilter) return;
    if (filters.year) {
      yearFilter.value = filters.year;
    }
  }

  function loadReports() {
    if (!docTableBody) return;
    var params = new URLSearchParams();
    if (filters.category) params.set('category', filters.category);
    if (filters.status && filters.status !== 'all') params.set('status', filters.status);
    if (filters.year) params.set('year', filters.year);
    if (filters.search) params.set('q', filters.search);
    if (filters.sort_order) params.set('sort_order', filters.sort_order);
    if (filters.page && filters.page > 1) params.set('page', filters.page);
    fetch('/admin-api/compliance-reports?' + params.toString(), {
      headers: { 'Accept': 'application/json' }
    })
    .then(function (response) {
      if (!response.ok) throw new Error('Gagal memuat data');
      return response.json();
    })
    .then(function (payload) {
      allReports = payload.data || [];
      categoryCounts = payload.category_counts || {};
      totalDocuments = payload.total_documents != null ? payload.total_documents : (payload.counts && payload.counts.all != null ? payload.counts.all : allReports.length);
      pagination = payload.pagination || null;
      populateYearFilter(payload.years);
      updateStatusCounts(payload.counts);
      updateCategoryCounts();
      updateSummaryMetrics(payload.summary);
      renderTable();
      renderPagination();
    })
    .catch(function () {});
  }

  loadReports();

  // ---- Pagination ----
  var paginationContainer = document.getElementById('pagination');

  function goToPage(page) {
    if (!pagination) return;
    if (page < 1 || page > pagination.last_page) return;
    if (page === pagination.current_page) return;
    filters.page = page;
    activeReportId = null;
    loadReports();
  }

  function renderPagination() {
    if (!paginationContainer) return;
    paginationContainer.innerHTML = '';
    if (!pagination || pagination.last_page <= 1) return;

    var current = pagination.current_page;
    var last = pagination.last_page;

    var prevBtn = document.createElement('button');
    prevBtn.className = 'page-btn page-btn-text';
    prevBtn.textContent = 'Prev';
    if (current <= 1) prevBtn.classList.add('disabled');
    prevBtn.addEventListener('click', function () {
      goToPage(current - 1);
    });
    paginationContainer.appendChild(prevBtn);

    var start = Math.max(1, current - 2);
    var end = Math.min(last, start + 4);
    start = Math.max(1, end - 4);

    for (var i = start; i <= end; i++) {
      (function (pageNum) {
        var btn = document.createElement('button');
        btn.className = 'page-btn';
        btn.textContent = pageNum;
        if (pageNum === current) btn.classList.add('active');
        btn.addEventListener('click', function () {
          goToPage(pageNum);
        });
        paginationContainer.appendChild(btn);
      })(i);
    }

    var nextBtn = document.createElement('button');
    nextBtn.className = 'page-btn page-btn-text';
    nextBtn.textContent = 'Next';
    if (current >= last) nextBtn.classList.add('disabled');
    nextBtn.addEventListener('click', function () {
      goToPage(current + 1);
    });
    paginationContainer.appendChild(nextBtn);
  }

  // ---- Row actions (placeholder) ----
  document.querySelectorAll('.row-actions .icon-action').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var label = btn.getAttribute('aria-label') || 'Aksi';
      console.log(label + ' diklik untuk dokumen ini.');
    });
  });

  // ---- Edit Meta ----
  var editMetaBtn = document.getElementById('editMetaBtn');
  if (editMetaBtn) {
    editMetaBtn.addEventListener('click', function (e) {
      e.preventDefault();
      var report = null;
      for (var i = 0; i < allReports.length; i++) {
        if (String(allReports[i].id) === String(activeReportId)) {
          report = allReports[i];
          break;
        }
      }
      if (report) {
        openEditModal(report);
      }
    });
  }

  // ---- Status tabs filtering ----
  var statusTabs = document.querySelectorAll('.status-tab');

  function updateStatusCounts(counts) {
    counts = counts || {};
    statusTabs.forEach(function (tab) {
      var key = tab.getAttribute('data-status');
      var badge = tab.querySelector('.count-pill');
      if (badge) {
        var value = counts[key];
        badge.textContent = String(value != null ? value : 0);
      }
    });
  }

  statusTabs.forEach(function (tab) {
    tab.addEventListener('click', function () {
      statusTabs.forEach(function (t) { t.classList.remove('active'); });
      tab.classList.add('active');
      filters.status = tab.getAttribute('data-status');
      filters.page = 1;
      loadReports();
    });
  });

  // ---- Inline table search ----
  var tableSearchInput = document.getElementById('tableSearchInput');
  if (tableSearchInput) {
    tableSearchInput.addEventListener('input', function () {
      filters.search = tableSearchInput.value.trim();
      filters.page = 1;
      loadReports();
    });
  }

  // ---- Year filter ----
  var yearFilter = document.getElementById('yearFilter');
  if (yearFilter) {
    yearFilter.addEventListener('change', function () {
      filters.year = yearFilter.value;
      filters.page = 1;
      loadReports();
    });
  }

  // ---- Advanced filter popover ----
  var filterBtn = document.getElementById('filterBtn');
  var filterPopover = document.getElementById('filterPopover');
  var filterSortOrder = document.getElementById('filterSortOrder');
  var filterResetBtn = document.getElementById('filterResetBtn');
  var filterApplyBtn = document.getElementById('filterApplyBtn');

  function syncFilterControls() {
    if (filterSortOrder) filterSortOrder.value = filters.sort_order || 'newest';
  }

  function toggleFilterPopover(force) {
    if (!filterPopover) return;
    var shouldOpen = typeof force === 'boolean' ? force : !filterPopover.classList.contains('open');
    filterPopover.classList.toggle('open', shouldOpen);
  }

  if (filterBtn) {
    filterBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      toggleFilterPopover();
    });
  }

  if (filterPopover) {
    filterPopover.addEventListener('click', function (e) {
      e.stopPropagation();
    });
  }

  document.addEventListener('click', function () {
    toggleFilterPopover(false);
  });

  if (filterApplyBtn) {
    filterApplyBtn.addEventListener('click', function () {
      filters.sort_order = filterSortOrder ? filterSortOrder.value : 'newest';
      filters.page = 1;
      toggleFilterPopover(false);
      loadReports();
    });
  }

  if (filterResetBtn) {
    filterResetBtn.addEventListener('click', function () {
      filters.sort_order = 'newest';
      filters.page = 1;
      syncFilterControls();
      toggleFilterPopover(false);
      loadReports();
    });
  }

  syncFilterControls();

  // ---- Bulk selection ----
  var selectAll = document.getElementById('select-all');
  var rowChecks = document.querySelectorAll('.row-check');
  var bulkBar = document.getElementById('bulkBar');
  var bulkCount = document.getElementById('bulkCount');

  function updateBulkBar() {
    var checked = document.querySelectorAll('.row-check:checked').length;
    if (bulkCount) bulkCount.textContent = checked + ' dipilih';
    if (bulkBar) bulkBar.classList.toggle('visible', checked > 0);
  }

  if (selectAll) {
    selectAll.addEventListener('change', function () {
      rowChecks.forEach(function (cb) { cb.checked = selectAll.checked; });
      updateBulkBar();
    });
  }

  rowChecks.forEach(function (cb) {
    cb.addEventListener('change', function () {
      if (selectAll) {
        var allChecked = document.querySelectorAll('.row-check:checked').length === rowChecks.length;
        selectAll.checked = allChecked;
      }
      updateBulkBar();
    });
  });

  // ---- Bulk actions ----
  var bulkDownloadBtn = document.getElementById('bulkDownloadBtn');
  var bulkStatusBtn = document.getElementById('bulkStatusBtn');
  var bulkArchiveBtn = document.getElementById('bulkArchiveBtn');

  function getSelectedRows() {
    return Array.prototype.filter.call(rowChecks, function (cb) { return cb.checked; });
  }

  if (bulkDownloadBtn) {
    bulkDownloadBtn.addEventListener('click', function () {
      var n = getSelectedRows().length;
      alert('Mengunduh ' + n + ' dokumen terpilih...');
    });
  }

  if (bulkStatusBtn) {
    bulkStatusBtn.addEventListener('click', function () {
      var n = getSelectedRows().length;
      alert('Mengubah status ' + n + ' dokumen terpilih...');
    });
  }

  if (bulkArchiveBtn) {
    bulkArchiveBtn.addEventListener('click', function () {
      var n = getSelectedRows().length;
      alert('Mengarsipkan ' + n + ' dokumen terpilih...');
    });
  }

  // ---- Preview modal ----
  var previewModal = document.getElementById('previewModal');
  var closePreviewBtn = document.getElementById('closePreviewBtn');
  var closePreviewCancelBtn = document.getElementById('closePreviewCancelBtn');
  var previewTitle = document.getElementById('previewTitle');
  var previewMeta = document.getElementById('previewMeta');
  var previewFrame = document.getElementById('previewFrame');
  var previewDownloadBtn = document.getElementById('previewDownloadBtn');
  var currentPreviewUrl = '';

  function closePreview() {
    if (previewFrame) previewFrame.removeAttribute('src');
    if (previewModal) previewModal.classList.remove('open');
  }

  window.openPreviewModal = function (doc) {
    var url = '';
    if (typeof doc === 'string') {
      url = doc;
    } else if (doc && typeof doc === 'object') {
      url = doc.file_url || getFileUrl(doc);
    }
    currentPreviewUrl = url;
    if (previewTitle) {
      previewTitle.textContent = (doc && typeof doc === 'object' && (doc.title || doc.original_filename)) || 'Pratinjau Dokumen';
    }
    if (previewMeta) {
      var metaText = '';
      if (doc && typeof doc === 'object') {
        var parts = [];
        if (doc.category) parts.push(doc.category);
        if (doc.fiscal_year) parts.push('FY ' + doc.fiscal_year);
        if (doc.status) parts.push(doc.status);
        metaText = parts.join(' · ');
      }
      previewMeta.textContent = metaText || 'Pratinjau dokumen kepatuhan sebelum diunduh.';
    }
    if (previewFrame && url) previewFrame.src = url;
    if (previewModal) previewModal.classList.add('open');
  };

  if (closePreviewBtn) closePreviewBtn.addEventListener('click', closePreview);
  if (closePreviewCancelBtn) closePreviewCancelBtn.addEventListener('click', closePreview);
  if (previewModal) {
    previewModal.addEventListener('click', function (e) {
      if (e.target === previewModal) closePreview();
    });
  }

  if (previewDownloadBtn) {
    previewDownloadBtn.addEventListener('click', function () {
      if (currentPreviewUrl) {
        window.downloadFile(currentPreviewUrl);
      }
    });
  }

  // ---- History modal ----
  var historyModal = document.getElementById('historyModal');
  var closeHistoryBtn = document.getElementById('closeHistoryBtn');
  var closeHistoryCancelBtn = document.getElementById('closeHistoryCancelBtn');

  function closeHistory() {
    if (historyModal) historyModal.classList.remove('open');
  }

  if (closeHistoryBtn) closeHistoryBtn.addEventListener('click', closeHistory);
  if (closeHistoryCancelBtn) closeHistoryCancelBtn.addEventListener('click', closeHistory);
  if (historyModal) {
    historyModal.addEventListener('click', function (e) {
      if (e.target === historyModal) closeHistory();
    });
  }
});