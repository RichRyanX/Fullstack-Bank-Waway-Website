document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.faq-item').forEach(function (item) {
    var question = item.querySelector('.faq-question');
    var answer = item.querySelector('.faq-answer');

    question.addEventListener('click', function () {
      var isOpen = item.classList.contains('open');

      document.querySelectorAll('.faq-item.open').forEach(function (openItem) {
        if (openItem !== item) {
          openItem.classList.remove('open');
          openItem.querySelector('.faq-answer').style.maxHeight = null;
        }
      });

      if (isOpen) {
        item.classList.remove('open');
        answer.style.maxHeight = null;
      } else {
        item.classList.add('open');
        answer.style.maxHeight = answer.scrollHeight + 'px';
      }
    });
  });

  var searchInput = document.getElementById('helpSearch');

  function runSearch() {
    var term = (searchInput.value || '').toLowerCase().trim();
    document.querySelectorAll('.faq-item').forEach(function (item) {
      var questionText = item.querySelector('.faq-question').textContent.toLowerCase();
      var answerText = item.querySelector('.faq-answer').textContent.toLowerCase();
      var matches = !term || questionText.indexOf(term) !== -1 || answerText.indexOf(term) !== -1;
      item.style.display = matches ? '' : 'none';
    });
  }

  if (searchInput) {
    searchInput.addEventListener('input', runSearch);
  }

  var modal = document.getElementById('modal-tiket-internal');
  var btnBuka = document.getElementById('btnBukaTiket');
  var btnTutup = document.getElementById('btnTutupModal');
  var btnBatal = document.getElementById('btnBatalTiket');
  var form = document.getElementById('form-tiket-internal');

  function openModal() {
    modal.classList.add('open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    var subjek = document.getElementById('tiket-subjek');
    if (subjek) {
      subjek.focus();
    }
  }

  function closeModal() {
    modal.classList.remove('open');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }

  function showNotification(message) {
    var existing = document.querySelector('.tiket-notification');
    if (existing) {
      existing.remove();
    }
    var notif = document.createElement('div');
    notif.className = 'tiket-notification';
    notif.textContent = message;
    document.body.appendChild(notif);
    setTimeout(function () {
      notif.classList.add('show');
    }, 10);
    setTimeout(function () {
      notif.classList.remove('show');
      setTimeout(function () {
        notif.remove();
      }, 300);
    }, 5000);
  }

  if (btnBuka) {
    btnBuka.addEventListener('click', openModal);
  }

  if (btnTutup) {
    btnTutup.addEventListener('click', closeModal);
  }

  if (btnBatal) {
    btnBatal.addEventListener('click', closeModal);
  }

  if (modal) {
    modal.addEventListener('click', function (event) {
      if (event.target === modal) {
        closeModal();
      }
    });
  }

  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape' && modal && modal.classList.contains('open')) {
      closeModal();
    }
  });

  if (form) {
    form.addEventListener('submit', function (event) {
      event.preventDefault();

      var subjek = document.getElementById('tiket-subjek').value.trim();
      var modul = document.getElementById('tiket-modul').value;
      var deskripsi = document.getElementById('tiket-deskripsi').value.trim();

      if (!subjek || !deskripsi) {
        showNotification('Mohon lengkapi Subjek dan Deskripsi kendala.');
        return;
      }

      var kirimBtn = document.getElementById('btnKirimTiket');
      kirimBtn.disabled = true;
      kirimBtn.textContent = 'Mengirim...';

      var payload = new URLSearchParams();
      payload.append('subjek', subjek);
      payload.append('modul', modul);
      payload.append('deskripsi', deskripsi);

      window.adminApiRequest('/admin-api/bantuan/tiket', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          'Accept': 'application/json'
        },
        body: payload.toString()
      })
        .then(function (response) {
          return response.json().then(function (data) {
            return { ok: response.ok, data: data };
          });
        })
        .then(function (result) {
          if (result.ok && result.data.success) {
            showNotification(result.data.message + ' Nomor Tiket: ' + result.data.ticket_id);
            form.reset();
            closeModal();
            if (isSuperAdmin()) {
              loadSuperAdminTickets();
            }
          } else {
            showNotification((result.data && result.data.message) || 'Gagal membuat tiket. Silakan coba lagi.');
          }
        })
        .catch(function () {
          showNotification('Terjadi kesalahan jaringan. Silakan coba lagi.');
        })
        .finally(function () {
          kirimBtn.disabled = false;
          kirimBtn.textContent = 'Kirim Tiket';
        });
    });
  }

  function getCsrfToken() {
    var name = 'XSRF-TOKEN';
    var value = '; ' + document.cookie;
    var parts = value.split('; ' + name + '=');
    if (parts.length === 2) return parts.pop().split(';').shift();
    return null;
  }

  function isSuperAdmin() {
    var headerRoleText = '';
    var headerEl = document.querySelector('.header-profile-role, .user-role, font, span');
    if (headerEl) {
      headerRoleText = (headerEl.textContent || '').toUpperCase();
    }
    var storedRole = '';
    try {
      storedRole = (localStorage.getItem('role') || '').toUpperCase();
    } catch (e) {}
    return headerRoleText.indexOf('SUPER ADMIN') !== -1 || storedRole.indexOf('SUPER') !== -1;
  }

  var ticketSection = document.getElementById('superadmin-ticket-section');
  var ticketBody = document.getElementById('ticket-table-body');
  var statusTabs = document.querySelectorAll('.ticket-status-tab');
  var searchInput = document.getElementById('ticket-search-input');
  var moduleFilter = document.getElementById('ticket-module-filter');
  var endDateInput = document.getElementById('ticket-end-date');
  var resetFiltersBtn = document.getElementById('ticket-reset-filters');
  var allTickets = [];
  var currentPage = 1;
  var pageLimit = 5;

  var filterState = {
    status: 'ALL',
    search: '',
    module: 'ALL',
    endDate: ''
  };

  function getTicketId(ticket, index) {
    return ticket.ticket_id || 'TK-' + new Date().getFullYear() + '-' + String(ticket.id || index + 1).padStart(3, '0');
  }

  function getTicketDate(ticket) {
    var raw = ticket.created_at || '';
    var parsed = new Date(raw);
    if (isNaN(parsed.getTime())) return null;
    return parsed;
  }

  function matchesFilters(ticket, index) {
    if (filterState.status !== 'ALL' && ticket.status !== filterState.status) {
      return false;
    }

    var term = filterState.search.toLowerCase();
    if (term) {
      var id = (getTicketId(ticket, index) || '').toLowerCase();
      var subject = (ticket.subjek || '').toLowerCase();
      var sender = (ticket.sender_name || '').toLowerCase();
      if (id.indexOf(term) === -1 && subject.indexOf(term) === -1 && sender.indexOf(term) === -1) {
        return false;
      }
    }

    if (filterState.module !== 'ALL' && (ticket.modul || '') !== filterState.module) {
      return false;
    }

    var date = getTicketDate(ticket);
    if (date) {
      if (filterState.endDate) {
        var end = new Date(filterState.endDate + 'T23:59:59');
        if (date > end) return false;
      }
    }

    return true;
  }

  function getFilteredTickets() {
    return allTickets.filter(matchesFilters);
  }

  function updateTabBadges() {
    var counts = { ALL: allTickets.length, BARU: 0, DIPROSES: 0, SELESAI: 0 };
    allTickets.forEach(function (ticket) {
      var status = ticket.status || 'BARU';
      if (counts[status] !== undefined) {
        counts[status]++;
      }
    });
    Object.keys(counts).forEach(function (key) {
      var badge = document.getElementById('badge-' + key);
      if (badge) {
        badge.textContent = counts[key];
      }
    });
  }

  var ALLOWED_MODULES = ['Konten Website', 'Laporan & Kepatuhan'];

  function populateModuleFilter() {
    if (!moduleFilter) return;
    var currentValue = moduleFilter.value;
    moduleFilter.innerHTML = '<option value="ALL">Semua Modul</option>';
    ALLOWED_MODULES.forEach(function (modul) {
      var option = document.createElement('option');
      option.value = modul;
      option.textContent = modul;
      moduleFilter.appendChild(option);
    });
    if (currentValue !== 'ALL' && ALLOWED_MODULES.indexOf(currentValue) !== -1) {
      moduleFilter.value = currentValue;
    } else {
      moduleFilter.value = 'ALL';
      filterState.module = 'ALL';
    }
  }

  function renderTickets() {
    if (!ticketBody) return;

    var filtered = getFilteredTickets();

    var totalPages = Math.max(1, Math.ceil(filtered.length / pageLimit));
    if (currentPage > totalPages) {
      currentPage = totalPages;
    }

    if (filtered.length === 0) {
      ticketBody.innerHTML = '<tr><td colspan="7" class="ticket-empty">Belum ada tiket masuk.</td></tr>';
      renderPagination(filtered.length, totalPages);
      return;
    }

    var startIndex = (currentPage - 1) * pageLimit;
    var endIndex = Math.min(startIndex + pageLimit, filtered.length);
    var pageTickets = filtered.slice(startIndex, endIndex);

    ticketBody.innerHTML = '';
    pageTickets.forEach(function (ticket, index) {
      var tr = document.createElement('tr');

      var sender = ticket.sender_name || '-';
      if (ticket.sender_email) {
        sender += ' / ' + ticket.sender_email;
      }

      var formattedId = ticket.ticket_id || 'TK-' + new Date().getFullYear() + '-' + String(ticket.id || index + 1).padStart(3, '0');

      var status = ticket.status || 'BARU';
      var badgeClass = 'badge badge-baru';
      if (status === 'DIPROSES') badgeClass = 'badge badge-diproses';
      if (status === 'SELESAI') badgeClass = 'badge badge-selesai';

      tr.innerHTML =
        '<td class="ticket-id">' + escapeHtml(formattedId) + '</td>' +
        '<td class="ticket-date">' + escapeHtml(ticket.created_at || '-') + '</td>' +
        '<td>' + escapeHtml(sender) + '</td>' +
        '<td>' + escapeHtml(ticket.modul || '-') + '</td>' +
        '<td>' + escapeHtml(ticket.subjek) + '</td>' +
        '<td><span class="' + badgeClass + '">' + escapeHtml(status) + '</span></td>';

      var actionTd = document.createElement('td');
      actionTd.className = 'ticket-actions';
      actionTd.innerHTML =
        '<div class="ticket-action-group">' +
        '<button class="btn-detail-ticket btn-sm" data-id="' + ticket.id + '" style="background-color: #334155; color: #ffffff;" onmouseover="this.style.backgroundColor=\'#475569\'" onmouseout="this.style.backgroundColor=\'#334155\'">Detail</button>' +
        '<button class="btn-process-ticket btn-sm" data-id="' + ticket.id + '" style="background-color: #2563eb; color: #ffffff;" onmouseover="this.style.backgroundColor=\'#1d4ed8\'" onmouseout="this.style.backgroundColor=\'#2563eb\'">Diproses</button>' +
        '<button class="btn-complete-ticket btn-sm" data-id="' + ticket.id + '" style="background-color: #10b981; color: #ffffff;" onmouseover="this.style.backgroundColor=\'#059669\'" onmouseout="this.style.backgroundColor=\'#10b981\'">Selesai</button>' +
        '</div>';

      tr.appendChild(actionTd);
      ticketBody.appendChild(tr);
    });

    ticketBody.querySelectorAll('.btn-process-ticket').forEach(function (btn) {
      btn.addEventListener('click', function () {
        updateTicketStatus(btn.getAttribute('data-id'), 'DIPROSES');
      });
    });

    ticketBody.querySelectorAll('.btn-complete-ticket').forEach(function (btn) {
      btn.addEventListener('click', function () {
        updateTicketStatus(btn.getAttribute('data-id'), 'SELESAI');
      });
    });

    renderPagination(filtered.length, totalPages);
  }

  function renderPagination(totalRecords, totalPages) {
    var infoEl = document.getElementById('ticket-pagination-info');
    var numbersEl = document.getElementById('ticket-page-numbers');
    var prevBtn = document.getElementById('ticket-page-prev');
    var nextBtn = document.getElementById('ticket-page-next');

    if (infoEl) {
      if (totalRecords === 0) {
        infoEl.textContent = 'Menampilkan 0-0 dari 0';
      } else {
        var start = (currentPage - 1) * pageLimit + 1;
        var end = Math.min(currentPage * pageLimit, totalRecords);
        infoEl.textContent = 'Menampilkan ' + start + '-' + end + ' dari ' + totalRecords;
      }
    }

    if (numbersEl) {
      numbersEl.innerHTML = '';
      for (var i = 1; i <= totalPages; i++) {
        var numBtn = document.createElement('button');
        numBtn.type = 'button';
        numBtn.className = 'ticket-page-num' + (i === currentPage ? ' active' : '');
        numBtn.textContent = i;
        numBtn.setAttribute('data-page', i);
        numBtn.addEventListener('click', function () {
          currentPage = parseInt(this.getAttribute('data-page'), 10);
          renderTickets();
        });
        numbersEl.appendChild(numBtn);
      }
    }

    if (prevBtn) {
      prevBtn.disabled = currentPage <= 1;
    }
    if (nextBtn) {
      nextBtn.disabled = currentPage >= totalPages;
    }
  }

  if (ticketBody) {
    ticketBody.addEventListener('click', function (event) {
      var btn = event.target.closest('.btn-detail-ticket');
      if (!btn) return;
      var id = btn.getAttribute('data-id');
      var ticket = allTickets.find(function (t) {
        return String(t.id) === String(id);
      });
      if (ticket) {
        openDetailModal(ticket);
      }
    });
  }

  function loadSuperAdminTickets() {
    if (!ticketBody) return;

    ticketBody.innerHTML = '<tr><td colspan="7" class="ticket-empty">Memuat data tiket...</td></tr>';

    window.adminApiRequest('/admin-api/bantuan/tiket', {
      method: 'GET',
      headers: {
        'Accept': 'application/json'
      }
    })
      .then(function (response) {
        return response.json().then(function (data) {
          return { ok: response.ok, data: data };
        });
      })
      .then(function (result) {
        if (!result.ok || !result.data.success) {
          ticketBody.innerHTML = '<tr><td colspan="7" class="ticket-empty">Gagal memuat data tiket.</td></tr>';
          return;
        }

        allTickets = result.data.tickets || [];
        try {
          localStorage.setItem('bank_waway_tickets', JSON.stringify(allTickets));
        } catch (e) {}
        populateModuleFilter();
        updateTabBadges();
        renderTickets();
      })
      .catch(function () {
        ticketBody.innerHTML = '<tr><td colspan="7" class="ticket-empty">Terjadi kesalahan jaringan.</td></tr>';
      });
  }

  function updateTicketStatus(id, status) {
    var payload = new URLSearchParams();
    payload.append('status', status);

    window.adminApiRequest('/admin-api/bantuan/tiket/' + id + '/status', {
      method: 'PATCH',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'Accept': 'application/json'
      },
      body: payload.toString()
    })
      .then(function (response) {
        return response.json().then(function (data) {
          return { ok: response.ok, data: data };
        });
      })
      .then(function (result) {
        if (result.ok && result.data.success) {
          showNotification(result.data.message);
          loadSuperAdminTickets();
        } else {
          showNotification((result.data && result.data.message) || 'Gagal memperbarui status tiket.');
        }
      })
      .catch(function () {
        showNotification('Terjadi kesalahan jaringan. Silakan coba lagi.');
      });
  }

  var detailModal = document.getElementById('modal-detail-tiket');
  var closeDetailModalBtn = document.getElementById('close-detail-modal');
  var btnCloseDetail = document.getElementById('btn-close-detail');

  function openDetailModal(ticket) {
    if (!detailModal || !ticket) return;

    var formattedId = ticket.ticket_id || 'TK-' + new Date().getFullYear() + '-' + String(ticket.id || '').padStart(3, '0');
    var titleEl = document.getElementById('detail-ticket-title');
    var codeEl = document.getElementById('detail-ticket-code');
    var dateEl = document.getElementById('detail-ticket-date');
    var senderEl = document.getElementById('detail-ticket-sender');
    var moduleEl = document.getElementById('detail-ticket-module');
    var statusEl = document.getElementById('detail-ticket-status');
    var subjectEl = document.getElementById('detail-ticket-subject');
    var messageEl = document.getElementById('detail-ticket-message');
    var actionButtons = document.getElementById('modal-action-buttons');

    if (titleEl) titleEl.textContent = 'Detail Tiket #' + formattedId;
    if (codeEl) codeEl.textContent = formattedId;
    if (dateEl) dateEl.textContent = ticket.created_at || '-';
    if (senderEl) senderEl.textContent = ticket.sender_name || '-';
    if (moduleEl) moduleEl.textContent = ticket.modul || '-';
    if (subjectEl) subjectEl.textContent = ticket.subjek || '-';
    if (messageEl) messageEl.textContent = ticket.deskripsi || ticket.message || '-';

    if (statusEl) {
      var status = ticket.status || 'BARU';
      statusEl.textContent = status;
      statusEl.className = 'ticket-detail-status';
      if (status === 'DIPROSES') statusEl.classList.add('status-diproses');
      if (status === 'SELESAI') statusEl.classList.add('status-selesai');
    }

    if (actionButtons) {
      actionButtons.innerHTML = '';
      var prosesBtn = document.createElement('button');
      prosesBtn.type = 'button';
      prosesBtn.className = 'ticket-detail-btn ticket-detail-btn-proses';
      prosesBtn.textContent = 'Diproses';
      prosesBtn.addEventListener('click', function () {
        updateTicketStatus(ticket.id, 'DIPROSES');
        closeDetailModal();
      });

      var selesaiBtn = document.createElement('button');
      selesaiBtn.type = 'button';
      selesaiBtn.className = 'ticket-detail-btn ticket-detail-btn-selesai';
      selesaiBtn.textContent = 'Selesai';
      selesaiBtn.addEventListener('click', function () {
        updateTicketStatus(ticket.id, 'SELESAI');
        closeDetailModal();
      });

      actionButtons.appendChild(prosesBtn);
      actionButtons.appendChild(selesaiBtn);
    }

    detailModal.classList.add('open');
    detailModal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }

  function closeDetailModal() {
    if (!detailModal) return;
    detailModal.classList.remove('open');
    detailModal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }

  if (closeDetailModalBtn) {
    closeDetailModalBtn.addEventListener('click', closeDetailModal);
  }

  if (btnCloseDetail) {
    btnCloseDetail.addEventListener('click', closeDetailModal);
  }

  if (detailModal) {
    detailModal.addEventListener('click', function (event) {
      if (event.target === detailModal) {
        closeDetailModal();
      }
    });
  }

  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape' && detailModal && detailModal.classList.contains('open')) {
      closeDetailModal();
    }
  });

  function escapeHtml(value) {
    var div = document.createElement('div');
    div.textContent = value == null ? '' : String(value);
    return div.innerHTML;
  }

  function applyFilters() {
    currentPage = 1;
    renderTickets();
  }

  statusTabs.forEach(function (tab) {
    tab.addEventListener('click', function () {
      statusTabs.forEach(function (t) {
        t.classList.remove('active');
      });
      tab.classList.add('active');
      filterState.status = tab.getAttribute('data-status');
      applyFilters();
    });
  });

  if (searchInput) {
    searchInput.addEventListener('input', function () {
      filterState.search = searchInput.value;
      applyFilters();
    });
  }

  if (moduleFilter) {
    moduleFilter.addEventListener('change', function () {
      filterState.module = moduleFilter.value;
      applyFilters();
    });
  }

  if (endDateInput) {
    endDateInput.addEventListener('change', function () {
      filterState.endDate = endDateInput.value;
      applyFilters();
    });
  }

  if (resetFiltersBtn) {
    resetFiltersBtn.addEventListener('click', function () {
      filterState.status = 'ALL';
      filterState.search = '';
      filterState.module = 'ALL';
      filterState.endDate = '';

      if (searchInput) searchInput.value = '';
      if (moduleFilter) moduleFilter.value = 'ALL';
      if (endDateInput) endDateInput.value = '';

      statusTabs.forEach(function (t) {
        t.classList.remove('active');
      });
      var allTab = document.querySelector('.ticket-status-tab[data-status="ALL"]');
      if (allTab) {
        allTab.classList.add('active');
      }

      applyFilters();
    });
  }

  var prevBtn = document.getElementById('ticket-page-prev');
  var nextBtn = document.getElementById('ticket-page-next');

  if (prevBtn) {
    prevBtn.addEventListener('click', function () {
      if (currentPage > 1) {
        currentPage--;
        renderTickets();
      }
    });
  }

  if (nextBtn) {
    nextBtn.addEventListener('click', function () {
      var filtered = getFilteredTickets();
      var totalPages = Math.max(1, Math.ceil(filtered.length / pageLimit));
      if (currentPage < totalPages) {
        currentPage++;
        renderTickets();
      }
    });
  }

  if (ticketSection) {
    ticketSection.style.display = 'block';
  }
  loadSuperAdminTickets();

});