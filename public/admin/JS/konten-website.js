// ===== Konten Website: load real berita data from the backend =====

document.addEventListener('DOMContentLoaded', function () {
  var tableBody = document.getElementById('beritaTableBody');
  if (!tableBody) return;

  var PAGE_SIZE = 5;
  var allItems = [];
  var currentPage = 1;

  loadBerita();

  function loadBerita() {
    fetch('/admin-api/berita', {
      method: 'GET',
      headers: { 'Accept': 'application/json' },
      credentials: 'include'
    })
      .then(function (res) {
        if (!res.ok) throw new Error('Failed to load berita (status ' + res.status + ')');
        return res.json();
      })
      .then(function (data) {
        allItems = Array.isArray(data) ? data : (data.data || []);
        currentPage = 1;
        renderRows();
        renderDonut();
        renderLeaderboard();
        renderStats();
      })
      .catch(function (err) {
        console.error(err);
        tableBody.innerHTML = '<tr><td colspan="5">Gagal memuat data berita.</td></tr>';
        updateCount(0, 0, 0);
        renderPagination(0);
        renderStats();
      });
  }

  function renderRows() {
    var items = getFilteredItems();
    if (!items.length) {
      tableBody.innerHTML = '<tr><td colspan="5">Belum ada berita.</td></tr>';
      updateCount(0, 0, 0);
      renderPagination(0);
      return;
    }

    var totalPages = Math.ceil(items.length / PAGE_SIZE);
    if (currentPage > totalPages) currentPage = totalPages;
    if (currentPage < 1) currentPage = 1;

    var start = (currentPage - 1) * PAGE_SIZE;
    var pageItems = items.slice(start, start + PAGE_SIZE);

    tableBody.innerHTML = pageItems.map(function (item) {
      var statusClass = 'status-' + (item.status || 'draft');
      var statusLabel = (item.status || 'draft').toUpperCase();
      var categorySlug = (item.category || '').toLowerCase().replace(/\s+/g, '-');
      var dateLabel = formatDate(item.updated_at || item.created_at);

      return (
        '<tr data-id="' + item.id + '">' +
          '<td>' +
            '<div class="berita-cell">' +
              '<div class="thumb thumb-' + categorySlug + '">' + categoryIcon(item.category) + '</div>' +
              '<a href="#" class="berita-title">' + escapeHtml(item.title) + '</a>' +
            '</div>' +
          '</td>' +
          '<td><span class="tag tag-' + categorySlug + '">' + escapeHtml((item.category || '').toUpperCase()) + '</span></td>' +
          '<td><span class="status-dot ' + statusClass + '">&bull; ' + statusLabel + '</span></td>' +
          '<td class="content-date">' + dateLabel + '</td>' +
          '<td>' +
            '<div class="row-actions">' +
              '<button class="icon-action btn-edit" aria-label="Edit" data-id="' + item.id + '">Edit</button>' +
              '<button class="icon-action btn-delete" aria-label="Hapus" data-id="' + item.id + '">Hapus</button>' +
              '<button class="icon-action btn-view" aria-label="Lihat" data-id="' + item.id + '">Lihat</button>' +
            '</div>' +
          '</td>' +
        '</tr>'
      );
    }).join('');

    updateCount(start + 1, start + pageItems.length, items.length);
    renderPagination(items.length);
    wireRowActions();
  }

  function categoryIcon(category) {
    var cat = (category || '').toLowerCase();
    if (cat.indexOf('promo') !== -1) {
      // Tag / percent icon
      return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>';
    }
    if (cat.indexOf('pengumuman') !== -1) {
      // Megaphone icon
      return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11l18-5v12L3 14v-3z"></path><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"></path></svg>';
    }
    // Default: book / edukasi icon
    return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>';
  }

  function updateCount(start, end, total) {
    var countEl = document.querySelector('.table-count');
    if (!countEl) return;
    if (!total) {
      countEl.textContent = 'Menampilkan 0 berita';
      return;
    }
    countEl.textContent = 'Menampilkan ' + start + ' - ' + end + ' dari ' + total + ' berita';
  }

  function renderPagination(total) {
    var pagination = document.getElementById('pagination');
    if (!pagination) return;

    var totalPages = Math.ceil(total / PAGE_SIZE);
    if (totalPages <= 1) {
      pagination.innerHTML = '';
      return;
    }

    var html = '';
    // Previous button
    html += '<button class="page-btn" aria-label="Sebelumnya" data-page="' + (currentPage - 1) + '"' + (currentPage === 1 ? ' disabled' : '') + '>&lsaquo;</button>';

    var pages = getPageWindow(currentPage, totalPages);

    pages.forEach(function (p) {
      if (p === '...') {
        html += '<span class="page-ellipsis">...</span>';
      } else {
        html += '<button class="page-btn' + (p === currentPage ? ' active' : '') + '" data-page="' + p + '">' + p + '</button>';
      }
    });

    // Next button
    html += '<button class="page-btn" aria-label="Berikutnya" data-page="' + (currentPage + 1) + '"' + (currentPage === totalPages ? ' disabled' : '') + '>&rsaquo;</button>';

    pagination.innerHTML = html;

    pagination.querySelectorAll('.page-btn[data-page]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var page = parseInt(btn.getAttribute('data-page'), 10);
        if (isNaN(page) || page < 1 || page > totalPages || page === currentPage) return;
        currentPage = page;
        renderRows();
      });
    });
  }

  function getPageWindow(current, total) {
    var pages = [];
    if (total <= 7) {
      for (var i = 1; i <= total; i++) pages.push(i);
      return pages;
    }
    pages.push(1);
    if (current > 3) pages.push('...');
    for (var j = Math.max(2, current - 1); j <= Math.min(total - 1, current + 1); j++) {
      pages.push(j);
    }
    if (current < total - 2) pages.push('...');
    pages.push(total);
    return pages;
  }

  function wireRowActions() {
    tableBody.querySelectorAll('.btn-delete').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var id = btn.getAttribute('data-id');
        var confirmed = confirm('Hapus berita ini? Tindakan ini tidak bisa dibatalkan.');
        if (!confirmed) return;

        window.adminApiRequest('/admin-api/berita/' + id, {
            method: 'DELETE',
            headers: { 'Accept': 'application/json' }
          })
          .then(function (res) {
            if (!res.ok) throw new Error('Gagal menghapus (status ' + res.status + ')');
            loadBerita();
          })
          .catch(function (err) {
            console.error(err);
            alert('Gagal menghapus berita.');
          });
      });
    });

    tableBody.querySelectorAll('.btn-edit, .btn-view').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var id = btn.getAttribute('data-id');
        fetch('/admin-api/berita/' + id, {
          method: 'GET',
          headers: { 'Accept': 'application/json' },
          credentials: 'include'
        })
          .then(function (res) {
            if (!res.ok) throw new Error('Gagal memuat berita');
            return res.json();
          })
          .then(function (item) {
            openModal('edit', item);
          })
          .catch(function (err) {
            console.error(err);
            alert('Gagal memuat data berita.');
          });
      });
    });
  }

  var searchInput = document.getElementById('searchInput');
  if (searchInput) {
    searchInput.addEventListener('input', function () {
      currentPage = 1;
      renderRows();
    });
  }

  function formatDate(isoString) {
    if (!isoString) return '-';
    var d = new Date(isoString);
    if (isNaN(d)) return '-';
    return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) +
      ', ' + d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
  }

  function escapeHtml(str) {
    var div = document.createElement('div');
    div.textContent = str == null ? '' : str;
    return div.innerHTML;
  }

  // ===== Stat cards (TOTAL / PUBLISHED / DRAFT / TERJADWAL) =====
  function renderStats() {
    var total = allItems.length;
    var published = 0;
    var draft = 0;
    var scheduled = 0;

    allItems.forEach(function (item) {
      var s = (item.status || '').toLowerCase();
      if (s === 'published') published++;
      else if (s === 'scheduled') scheduled++;
      else draft++;
    });

    setStat('statTotal', total);
    setStat('statPublished', published);
    setStat('statDraft', draft);
    setStat('statScheduled', scheduled);
  }

  function setStat(id, value) {
    var el = document.getElementById(id);
    if (el) el.textContent = value;
  }

  // ===== Donut chart (distribusi kategori) =====
  var CATEGORY_COLORS = {
    'edukasi': '#2563eb',
    'promo': '#f59e0b',
    'pengumuman': '#7e3ff2'
  };

  function categoryKey(category) {
    var cat = (category || '').toLowerCase();
    if (cat.indexOf('promo') !== -1) return 'promo';
    if (cat.indexOf('pengumuman') !== -1) return 'pengumuman';
    return 'edukasi';
  }

  function renderDonut() {
    var chart = document.getElementById('categoryDonut');
    var legend = document.getElementById('donutLegend');
    var totalEl = document.getElementById('donutTotal');
    if (!chart || !legend || !totalEl) return;

    var counts = { edukasi: 0, promo: 0, pengumuman: 0 };
    allItems.forEach(function (item) {
      counts[categoryKey(item.category)]++;
    });

    var total = allItems.length;
    totalEl.textContent = total;

    var segments = [
      { key: 'edukasi', label: 'Edukasi' },
      { key: 'promo', label: 'Promo' },
      { key: 'pengumuman', label: 'Pengumuman' }
    ];

    // Build legend
    legend.innerHTML = segments.map(function (seg) {
      var pct = total ? Math.round((counts[seg.key] / total) * 100) : 0;
      return (
        '<li data-key="' + seg.key + '">' +
          '<span class="legend-dot" style="background:' + CATEGORY_COLORS[seg.key] + '"></span>' +
          '<span class="legend-name">' + seg.label + '</span>' +
          '<span class="legend-count">' + counts[seg.key] + ' (' + pct + '%)</span>' +
        '</li>'
      );
    }).join('');

    // Build SVG donut segments so each category is individually hoverable
    var size = 150;
    var stroke = 29;
    var radius = (size - stroke) / 2;
    var circumference = 2 * Math.PI * radius;
    var center = size / 2;
    var svgNS = 'http://www.w3.org/2000/svg';

    var svg = document.createElementNS(svgNS, 'svg');
    svg.setAttribute('viewBox', '0 0 ' + size + ' ' + size);
    svg.setAttribute('class', 'donut-svg');

    var g = document.createElementNS(svgNS, 'g');
    g.setAttribute('transform', 'rotate(-90 ' + center + ' ' + center + ')');
    svg.appendChild(g);

    var cursor = 0;
    segments.forEach(function (seg) {
      var count = counts[seg.key];
      var frac = total ? count / total : 0;
      var circle = document.createElementNS(svgNS, 'circle');
      circle.setAttribute('cx', center);
      circle.setAttribute('cy', center);
      circle.setAttribute('r', radius);
      circle.setAttribute('fill', 'none');
      circle.setAttribute('stroke', CATEGORY_COLORS[seg.key]);
      circle.setAttribute('stroke-width', stroke);
      var dash = frac * circumference;
      circle.setAttribute('stroke-dasharray', dash + ' ' + (circumference - dash));
      circle.setAttribute('stroke-dashoffset', -cursor * circumference);
      circle.setAttribute('data-key', seg.key);
      circle.setAttribute('data-count', count);
      circle.setAttribute('data-label', seg.label);
      circle.setAttribute('data-pct', total ? Math.round(frac * 100) : 0);
      circle.classList.add('donut-seg');
      g.appendChild(circle);
      cursor += frac;
    });

    var oldSvg = chart.querySelector('.donut-svg');
    if (oldSvg) oldSvg.remove();
    chart.insertBefore(svg, chart.firstChild);

    // Hover on a segment shows a shadow-box tooltip with the category name and count
    svg.querySelectorAll('.donut-seg').forEach(function (seg) {
      seg.addEventListener('mouseenter', function (e) {
        showDonutTooltip(e, seg.getAttribute('data-label'), seg.getAttribute('data-count'), seg.getAttribute('data-pct'));
      });
      seg.addEventListener('mousemove', function (e) {
        moveDonutTooltip(e);
      });
      seg.addEventListener('mouseleave', hideDonutTooltip);
    });

    // Hover on a legend row shows the same tooltip
    legend.querySelectorAll('li').forEach(function (li) {
      li.addEventListener('mouseenter', function () {
        var key = li.getAttribute('data-key');
        var seg = svg.querySelector('.donut-seg[data-key="' + key + '"]');
        if (seg) {
          showDonutTooltip(null, seg.getAttribute('data-label'), seg.getAttribute('data-count'), seg.getAttribute('data-pct'));
        }
      });
      li.addEventListener('mouseleave', hideDonutTooltip);
    });
  }

  function showDonutTooltip(e, label, count, pct) {
    var tooltip = document.getElementById('donutTooltip');
    if (!tooltip) return;
    tooltip.innerHTML = '<strong>' + count + '</strong> ' + label + ' (' + pct + '%)';
    tooltip.style.display = 'block';
    if (e) moveDonutTooltip(e);
  }

  function moveDonutTooltip(e) {
    var tooltip = document.getElementById('donutTooltip');
    if (!tooltip || tooltip.style.display === 'none') return;
    var tipRect = tooltip.getBoundingClientRect();
    var left = e.clientX - tipRect.width / 2;
    var top = e.clientY - tipRect.height - 12;
    tooltip.style.left = left + 'px';
    tooltip.style.top = top + 'px';
  }

  function hideDonutTooltip() {
    var tooltip = document.getElementById('donutTooltip');
    if (tooltip) tooltip.style.display = 'none';
  }

  // ===== Leaderboard (top 5 berita) =====
  // Ranked by real view counts tracked via the /berita/{id}/view endpoint.
  function renderLeaderboard() {
    var list = document.getElementById('leaderboard');
    if (!list) return;

    if (!allItems.length) {
      list.innerHTML = '<li class="empty">Belum ada berita.</li>';
      return;
    }

    // Rank by real views (fall back to 0 when not yet tracked)
    var sorted = allItems.slice().sort(function (a, b) {
      var av = Number(a.views) || 0;
      var bv = Number(b.views) || 0;
      return bv - av;
    });

    var top = sorted.slice(0, 5);

    list.innerHTML = top.map(function (item, i) {
      var clicks = Number(item.views) || 0;
      var clicksLabel = formatClicks(clicks);
      var exactLabel = clicks.toLocaleString('id-ID');
      return (
        '<li>' +
          '<span class="rank' + (i === 0 ? ' top' : '') + '">' + (i + 1) + '</span>' +
          '<span class="lb-title">' + escapeHtml(item.title) + '</span>' +
          '<span class="lb-clicks" title="' + exactLabel + ' kunjungan">' + clicksLabel + '</span>' +
        '</li>'
      );
    }).join('');
  }

  function formatClicks(n) {
    if (n >= 1000) return (n / 1000).toFixed(1).replace(/\.0$/, '') + 'k';
    return String(n);
  }

  // ===== Filters =====
  var categoryFilter = document.getElementById('categoryFilter');
  var statusFilter = document.getElementById('statusFilter');
  var filterDate = document.getElementById('filterDate');
  var btnDateFilter = document.getElementById('btnDateFilter');

  // ===== Date range filter (flatpickr) =====
  var flatpickrCss = document.createElement('link');
  flatpickrCss.rel = 'stylesheet';
  flatpickrCss.href = 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css';
  document.head.appendChild(flatpickrCss);

  var flatpickrJs = document.createElement('script');
  flatpickrJs.src = 'https://cdn.jsdelivr.net/npm/flatpickr';
  document.head.appendChild(flatpickrJs);

  var datePicker = null;

  flatpickrJs.onload = function () {
    if (!filterDate || typeof flatpickr === 'undefined') return;
    datePicker = flatpickr('#filterDate', {
      mode: 'range',
      dateFormat: 'd M Y',
      placeholder: 'Pilih rentang tanggal...',
      allowInput: true,
      onChange: function () {
        applyFilters();
      }
    });

    var calendarIcon = document.querySelector('.date-filter-wrap .date-filter-icon');
    if (calendarIcon) {
      calendarIcon.addEventListener('click', function () {
        if (datePicker) datePicker.open();
      });
    }
  };

  function getFilteredItems() {
    var keyword = searchInput ? searchInput.value.trim().toLowerCase() : '';
    var cat = categoryFilter ? categoryFilter.value : '';
    var stat = statusFilter ? statusFilter.value : '';
    var dateRange = getDateRange();

    return allItems.filter(function (item) {
      var matchKeyword = !keyword ||
        (item.title || '').toLowerCase().indexOf(keyword) !== -1;
      var matchCat = !cat ||
        (item.category || '').toLowerCase() === cat.toLowerCase();
      var matchStat = !stat ||
        (item.status || '').toLowerCase() === stat.toLowerCase();
      var matchDate = matchDateRange(item, dateRange);
      return matchKeyword && matchCat && matchStat && matchDate;
    });
  }

  function getDateRange() {
    if (!filterDate || !filterDate.value) return null;
    var val = filterDate.value.trim();
    if (!val) return null;

    var parts = [];
    if (val.indexOf(' to ') !== -1) {
      parts = val.split(' to ');
    } else if (val.indexOf(' - ') !== -1) {
      parts = val.split(' - ');
    } else {
      parts = [val];
    }

    var from = new Date(parts[0]);
    var to = parts.length === 2 ? new Date(parts[1]) : new Date(parts[0]);
    if (isNaN(from) || isNaN(to)) return null;

    // Normalize to start/end of day
    from.setHours(0, 0, 0, 0);
    to.setHours(23, 59, 59, 999);
    return { from: from, to: to };
  }

  function matchDateRange(item, range) {
    if (!range) return true;
    var dateStr = item.updated_at || item.created_at;
    if (!dateStr) return false;
    var d = new Date(dateStr);
    if (isNaN(d)) return false;
    return d >= range.from && d <= range.to;
  }

  function applyFilters() {
    currentPage = 1;
    renderRows();
  }

  if (categoryFilter) categoryFilter.addEventListener('change', applyFilters);
  if (statusFilter) statusFilter.addEventListener('change', applyFilters);
  if (btnDateFilter) {
    btnDateFilter.addEventListener('click', function () {
      if (datePicker) {
        datePicker.open();
      } else if (filterDate) {
        filterDate.focus();
      }
    });
  }

  // ===== Reset all filters to default =====
  var btnResetFilter = document.getElementById('btnResetFilter');
  if (btnResetFilter) {
    btnResetFilter.addEventListener('click', function () {
      if (searchInput) searchInput.value = '';
      if (categoryFilter) categoryFilter.value = '';
      if (statusFilter) statusFilter.value = '';
      if (datePicker) {
        datePicker.clear();
      } else if (filterDate) {
        filterDate.value = '';
      }
      currentPage = 1;
      renderRows();
    });
  }

  // ===== Modal =====
  var modal = document.getElementById('beritaModal');
  var form = document.getElementById('beritaForm');
  var modalTitle = document.getElementById('modalTitle');
  var beritaIdField = document.getElementById('beritaId');
  var btnAdd = document.getElementById('btnAddBerita');
  var btnCancel = document.getElementById('btnCancelModal');
  var btnClose = document.getElementById('btnCloseModal');

  function openModal(mode, item) {
    form.reset();
    beritaIdField.value = '';
    if (mode === 'edit' && item) {
      modalTitle.textContent = 'Edit Berita';
      beritaIdField.value = item.id;
      document.getElementById('beritaTitle').value = item.title || '';
      document.getElementById('beritaCategory').value = item.category || '';
      document.getElementById('beritaStatus').value = item.status || 'draft';
      document.getElementById('beritaContent').value = item.content || '';
    } else {
      modalTitle.textContent = 'Tambah Berita Baru';
    }
    modal.style.display = 'flex';
  }

  function closeModal() {
    modal.style.display = 'none';
  }

  if (btnAdd) btnAdd.addEventListener('click', function () { openModal('add'); });
  if (btnCancel) btnCancel.addEventListener('click', closeModal);
  if (btnClose) btnClose.addEventListener('click', closeModal);

  // Close modal when clicking outside the box
  if (modal) {
    modal.addEventListener('click', function (e) {
      if (e.target === modal) closeModal();
    });
  }

  // Auto-open "Tambah Berita Baru" modal when arriving via ?open=add
  var urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('open') === 'add' && modal) {
    openModal('add');
  }

  if (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();

      var id = beritaIdField.value;
      var payload = {
        title: document.getElementById('beritaTitle').value,
        category: document.getElementById('beritaCategory').value,
        status: document.getElementById('beritaStatus').value,
        content: document.getElementById('beritaContent').value
      };

      var url = id ? '/admin-api/berita/' + id : '/admin-api/berita';
      var method = id ? 'PUT' : 'POST';

      window.adminApiRequest(url, {
        method: method,
        headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      })
        .then(function (res) {
          if (!res.ok) throw new Error('Gagal menyimpan (status ' + res.status + ')');
          return res.json();
        })
        .then(function () {
          closeModal();
          loadBerita();
        })
        .catch(function (err) {
          console.error(err);
          alert('Gagal menyimpan berita.');
        });
    });
  }
});
