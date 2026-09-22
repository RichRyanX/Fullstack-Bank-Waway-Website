function loadAdminProfile() {
  fetch('/admin-api/auth/me', {
    method: 'GET',
    headers: { 'Accept': 'application/json' },
    credentials: 'include'
  })
    .then(function (res) {
      if (!res.ok) {
        window.location.href = 'index.html';
        return null;
      }
      return res.json();
    })
    .then(function (data) {
      if (!data) return;

      var nameEl = document.getElementById('userName');
      var avatarEl = document.getElementById('userAvatar');
      var roleEl = document.querySelector('.user-role');

      if (nameEl && data.name) {
        nameEl.textContent = data.name;
      }

      if (avatarEl && data.name) {
        var initials = data.name
          .split(' ')
          .filter(Boolean)
          .map(function (word) { return word[0]; })
          .join('')
          .substring(0, 2)
          .toUpperCase();
        avatarEl.textContent = initials;
      }

      if (roleEl && data.role) {
        var readableRole = data.role.replace(/_/g, ' ').toUpperCase();
        roleEl.textContent = readableRole;
      }
    })
    .catch(function () {
      window.location.href = 'index.html';
    });
}

function loadDashboardData() {
  fetch('/admin-api/dashboard', {
    method: 'GET',
    headers: { 'Accept': 'application/json' },
    credentials: 'include'
  })
    .then(function (res) {
      if (!res.ok) {
        throw new Error('Dashboard request failed');
      }
      return res.json();
    })
    .then(function (data) {
      var totalBeritaEl = document.getElementById('totalBerita');
      var totalLaporanEl = document.getElementById('totalLaporan');
      var laporanBadgeEl = document.getElementById('laporanBadge');

      if (totalBeritaEl) {
        totalBeritaEl.textContent = data.total_berita;
      }
      if (totalLaporanEl) {
        totalLaporanEl.textContent = data.total_reports != null ? data.total_reports : 0;
      }
      if (laporanBadgeEl) {
        var published = data.published_reports_count != null ? data.published_reports_count : 0;
        laporanBadgeEl.textContent = published + ' Terpublikasi';
      }

      renderAuditLogs(data.recent_logs);
      renderActivityChart(data.activity_chart);
      renderBruteForceAlerts(data.brute_force_alerts);
      renderLogHealth(data.log_health);
      renderContentStats(data.content_stats);
      renderStorageMetrics(data.storage_metrics);
    })
    .catch(function () {});
}

function renderAuditLogs(logs) {
  var tbody = document.getElementById('auditLogBody');
  if (!tbody) return;

  tbody.innerHTML = '';

  if (!logs || logs.length === 0) {
    var emptyRow = document.createElement('tr');
    var emptyCell = document.createElement('td');
    emptyCell.setAttribute('colspan', '4');
    emptyCell.textContent = 'Tidak ada aktivitas log.';
    emptyRow.appendChild(emptyCell);
    tbody.appendChild(emptyRow);
    return;
  }

  logs.forEach(function (log) {
    var row = document.createElement('tr');

    var userCell = document.createElement('td');
    userCell.className = 'content-name';
    userCell.textContent = log.admin ? log.admin.name : 'Unknown';

    var actionCell = document.createElement('td');
    var actionBadge = document.createElement('span');
    actionBadge.className = 'action-badge ' + actionBadgeClass(log.action);
    actionBadge.textContent = log.action;
    actionCell.appendChild(actionBadge);

    var moduleCell = document.createElement('td');
    moduleCell.className = 'content-cat';
    moduleCell.textContent = log.module;

    var timeCell = document.createElement('td');
    timeCell.className = 'content-date';
    timeCell.textContent = formatWIB(log.created_at);

    row.appendChild(userCell);
    row.appendChild(actionCell);
    row.appendChild(moduleCell);
    row.appendChild(timeCell);

    tbody.appendChild(row);
  });
}

function actionBadgeClass(action) {
  var normalized = String(action || '').toUpperCase();
  if (normalized.indexOf('LOGIN_FAILED') !== -1) {
    return 'badge-red';
  }
  if (normalized.indexOf('LOGIN') !== -1) {
    return 'badge-green';
  }
  if (normalized.indexOf('DELETE') !== -1) {
    return 'badge-red';
  }
  if (normalized.indexOf('CREATE') !== -1 || normalized.indexOf('WEBHOOK') !== -1) {
    return 'badge-green';
  }
  return 'badge-amber';
}

var activityChartInstance = null;

function renderActivityChart(activityChart) {
  var canvas = document.getElementById('activityTrendChart');
  if (!canvas || typeof Chart === 'undefined') return;

  var labels = [];
  var counts = [];

  if (activityChart && activityChart.labels && activityChart.data) {
    labels = activityChart.labels;
    counts = activityChart.data;
  }

  if (activityChartInstance) {
    activityChartInstance.data.labels = labels;
    activityChartInstance.data.datasets[0].data = counts;
    activityChartInstance.update();
    return;
  }

  activityChartInstance = new Chart(canvas, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [{
        label: 'Aktivitas',
        data: counts,
        borderColor: '#2563a8',
        backgroundColor: 'rgba(37, 99, 168, 0.12)',
        fill: true,
        tension: 0.3
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            precision: 0
          }
        }
      }
    }
  });
}

function renderBruteForceAlerts(alerts) {
  var listEl = document.getElementById('bruteForceList');
  var payloadEl = document.getElementById('threatPayload');
  var badgeEl = document.getElementById('alertBadge');
  if (!listEl) return;

  listEl.innerHTML = '';

  if (!alerts || alerts.length === 0) {
    var empty = document.createElement('div');
    empty.className = 'alert-empty';
    empty.textContent = 'Tidak Ada Ancaman';
    listEl.appendChild(empty);
    if (badgeEl) {
      badgeEl.textContent = '0';
      badgeEl.className = 'alert-badge alert-badge-safe';
    }
    return;
  }

  if (badgeEl) {
    badgeEl.textContent = alerts.length;
    badgeEl.className = 'alert-badge alert-badge-danger';
  }

  var alert = alerts[0];

  var item = document.createElement('div');
  item.className = 'alert-item';

  var top = document.createElement('div');
  top.className = 'alert-item-top';

  var ip = document.createElement('span');
  ip.className = 'alert-ip';
  ip.textContent = alert.ip_address;

  var badge = document.createElement('span');
  badge.className = 'attempt-badge';
  badge.textContent = alert.attempt_count + 'x Gagal';

  top.appendChild(ip);
  top.appendChild(badge);

  var time = document.createElement('span');
  time.className = 'alert-time';
  time.textContent = relativeTime(alert.last_attempt);

  item.appendChild(top);
  item.appendChild(time);

  var action = document.createElement('button');
  action.id = 'btn-review-threat';
  action.className = 'btn-alert-action';
  action.type = 'button';
  action.textContent = 'Tinjau Log & Reset';
  action.setAttribute('data-threat-ip', alert.ip_address);

  item.appendChild(action);
  listEl.appendChild(item);

  if (payloadEl) {
    payloadEl.innerHTML = '';
  }

  action.addEventListener('click', function () {
    acknowledgeThreat(alert.ip_address);
  });
}

function acknowledgeThreat(threatIp) {
  window.adminApiRequest('/admin-api/dashboard/acknowledge-threat', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
    body: JSON.stringify({ ip: threatIp })
  })
    .then(function (res) {
      return res.json();
    })
    .then(function () {
      var listEl = document.getElementById('bruteForceList');
      var badgeEl = document.getElementById('alertBadge');
      if (listEl) {
        listEl.innerHTML = '';
        var empty = document.createElement('div');
        empty.className = 'alert-empty';
        empty.textContent = 'Tidak Ada Ancaman';
        listEl.appendChild(empty);
      }
      if (badgeEl) {
        badgeEl.textContent = '0';
        badgeEl.className = 'alert-badge alert-badge-safe';
      }
      window.location.href = 'audit-log.html';
    })
    .catch(function () {
      window.location.href = 'audit-log.html';
    });
}

function renderLogHealth(logHealth) {
  var totalEl = document.getElementById('totalLogStored');
  var dbEl = document.getElementById('dbHealthStatus');
  var archiveEl = document.getElementById('autoArchive');

  if (totalEl && logHealth) {
    totalEl.textContent = logHealth.total_logs + ' entri';
  }

  if (dbEl && logHealth) {
    var storage = logHealth.estimated_storage_mb;
    if (storage !== null && storage !== undefined && storage > 50) {
      dbEl.textContent = '● Perlu Perhatian';
      dbEl.className = 'status status-amber';
    } else {
      dbEl.textContent = '● Optimal';
      dbEl.className = 'status status-green';
    }
  }

  if (archiveEl && logHealth) {
    var latest = logHealth.latest_log_at;
    if (latest) {
      archiveEl.textContent = '● ' + relativeTime(latest);
      archiveEl.className = 'status status-amber';
    } else {
      archiveEl.textContent = '● Aktif';
      archiveEl.className = 'status status-green';
    }
  }
}

function renderContentStats(contentStats) {
  var beritaTerbitEl = document.getElementById('beritaTerbit');
  var beritaDraftEl = document.getElementById('beritaDraft');
  var laporanPublikasiEl = document.getElementById('laporanPublikasi');

  if (beritaTerbitEl && contentStats) {
    beritaTerbitEl.textContent = contentStats.berita_terbit;
  }
  if (beritaDraftEl && contentStats) {
    beritaDraftEl.textContent = contentStats.berita_draft;
  }
  if (laporanPublikasiEl && contentStats) {
    laporanPublikasiEl.textContent = contentStats.total_reports != null
      ? contentStats.total_reports
      : contentStats.laporan_publikasi;
  }
}

function renderStorageMetrics(storageMetrics) {
  var usedEl = document.getElementById('storageUsed');
  var quotaEl = document.getElementById('storageQuota');
  var fillEl = document.getElementById('storageProgressFill');
  var countEl = document.getElementById('storageDocumentCount');
  var statusEl = document.getElementById('storageStatus');

  if (!storageMetrics) return;

  if (usedEl) {
    usedEl.textContent = storageMetrics.used_storage != null ? storageMetrics.used_storage : '0 B';
  }
  if (quotaEl) {
    quotaEl.textContent = storageMetrics.quota_storage != null ? storageMetrics.quota_storage : '2 GB';
  }
  if (countEl) {
    countEl.textContent = storageMetrics.document_count != null ? storageMetrics.document_count : 0;
  }
  if (statusEl) {
    var status = storageMetrics.status || 'Optimal';
    statusEl.textContent = '● ' + status;
    statusEl.className = status === 'Peringatan' ? 'status status-amber' : 'status status-green';
  }
  if (fillEl) {
    var percentage = storageMetrics.usage_percentage != null ? storageMetrics.usage_percentage : 0;
    var width = Math.min(100, Math.max(0, percentage));
    fillEl.style.width = width + '%';
  }
}

function getTicketStorageKey() {
  return 'bank_waway_tickets';
}

function getDefaultTickets() {
  return [
    { id: 1, ticket_id: 'TK-2026-001', sender_name: 'Admin', sender_email: 'admin@bankwaway.co.id', subjek: 'Contoh tiket baru', modul: 'Konten Website', deskripsi: 'Contoh deskripsi tiket baru.', status: 'BARU', created_at: '26 Aug 2026 09:00' },
    { id: 2, ticket_id: 'TK-2026-002', sender_name: 'Admin', sender_email: 'admin@bankwaway.co.id', subjek: 'Contoh tiket diproses', modul: 'Laporan & Kepatuhan', deskripsi: 'Contoh deskripsi tiket diproses.', status: 'DIPROSES', created_at: '27 Aug 2026 10:30' },
    { id: 3, ticket_id: 'TK-2026-003', sender_name: 'Admin', sender_email: 'admin@bankwaway.co.id', subjek: 'Contoh tiket selesai', modul: 'Konten Website', deskripsi: 'Contoh deskripsi tiket selesai.', status: 'SELESAI', created_at: '28 Aug 2026 14:00' }
  ];
}

function readTicketsFromStorage() {
  var raw = null;
  try {
    raw = localStorage.getItem(getTicketStorageKey());
  } catch (e) {
    raw = null;
  }
  if (raw) {
    try {
      var parsed = JSON.parse(raw);
      if (Array.isArray(parsed) && parsed.length > 0) {
        return parsed;
      }
    } catch (e) {}
  }
  return getDefaultTickets();
}

function renderTicketMetrics(tickets) {
  var baruEl = document.getElementById('ticketBaru');
  var diprosesEl = document.getElementById('ticketDiproses');
  var selesaiEl = document.getElementById('ticketSelesai');
  var totalEl = document.getElementById('ticketTotal');

  var list = Array.isArray(tickets) ? tickets : readTicketsFromStorage();

  var baru = 0;
  var diproses = 0;
  var selesai = 0;

  list.forEach(function (ticket) {
    var status = String((ticket && ticket.status) || '').toLowerCase().trim();
    if (status.indexOf('baru') !== -1) {
      baru++;
    }
    if (status.indexOf('proses') !== -1 || status.indexOf('diproses') !== -1 || status.indexOf('dalam proses') !== -1) {
      diproses++;
    }
    if (status.indexOf('selesai') !== -1) {
      selesai++;
    }
  });

  if (baruEl) baruEl.textContent = baru;
  if (diprosesEl) diprosesEl.textContent = diproses;
  if (selesaiEl) selesaiEl.textContent = selesai;
  if (totalEl) totalEl.textContent = list.length;
}

function loadTicketMetrics() {
  renderTicketMetrics(readTicketsFromStorage());
}

function formatWIB(timestamp) {
  if (!timestamp) return '';
  var raw = String(timestamp).trim();
  if (!/\d{4}-\d{2}-\d{2}/.test(raw)) return raw;
  if (!/[zZ]|[+-]\d{2}:?\d{2}$/.test(raw)) {
    raw = raw.replace(' ', 'T') + 'Z';
  }
  var date = new Date(raw);
  if (isNaN(date.getTime())) return timestamp;
  return date.toLocaleString('id-ID', {
    timeZone: 'Asia/Jakarta',
    weekday: 'short',
    day: '2-digit',
    month: 'short',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit'
  });
}

function relativeTime(timestamp) {
  if (!timestamp) return 'Baru saja';
  var raw = String(timestamp).trim();
  if (!/\d{4}-\d{2}-\d{2}/.test(raw)) return raw;
  if (!/[zZ]|[+-]\d{2}:?\d{2}$/.test(raw)) {
    raw = raw.replace(' ', 'T') + 'Z';
  }
  var date = new Date(raw);
  if (isNaN(date.getTime())) return timestamp;
  var seconds = Math.floor((Date.now() - date.getTime()) / 1000);
  if (seconds < 60) return 'Baru saja';
  var minutes = Math.floor(seconds / 60);
  if (minutes < 60) return minutes + ' menit lalu';
  var hours = Math.floor(minutes / 60);
  if (hours < 24) return hours + ' jam lalu';
  var days = Math.floor(hours / 24);
  return days + ' hari lalu';
}

function renderCurrentDate() {
  var dateEl = document.getElementById('current-date-display');
  if (!dateEl) return;
  var now = new Date();
  dateEl.textContent = now.toLocaleDateString('id-ID', {
    weekday: 'long',
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  });
}

function initDashboard() {
  renderCurrentDate();
  loadAdminProfile();
  loadDashboardData();
  loadTicketMetrics();
  var quickActionUploadBtn = document.getElementById('quickActionUploadBtn');
  if (quickActionUploadBtn) {
    quickActionUploadBtn.addEventListener('click', function (e) {
      e.preventDefault();
      window.location.href = 'laporan-kepatuhan.html?action=upload';
    });
  }
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initDashboard);
} else {
  initDashboard();
}