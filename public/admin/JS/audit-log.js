document.addEventListener("DOMContentLoaded", function () {
    var tableBody = document.getElementById("logTableBody");
    if (!tableBody) return;

    var filterUser = document.getElementById("filterUser");
    var filterAction = document.getElementById("filterAction");
    var filterModule = document.getElementById("filterModule");
    var filterDate = document.getElementById("filterDate");

    var currentPage = 1;
    var currentLogs = [];

    loadLogs();

    var flatpickrCss = document.createElement("link");
    flatpickrCss.rel = "stylesheet";
    flatpickrCss.href =
        "https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css";
    document.head.appendChild(flatpickrCss);

    var flatpickrJs = document.createElement("script");
    flatpickrJs.src = "https://cdn.jsdelivr.net/npm/flatpickr";
    document.head.appendChild(flatpickrJs);

    flatpickrJs.onload = function () {
        var datePicker = flatpickr("#filterDate", {
            mode: "range",
            dateFormat: "d M Y",
            placeholder: "Pilih rentang tanggal...",
            allowInput: true,
        });

        var calendarIcon = document.querySelector(
            ".filter-panel .input-wrapper .input-icon",
        );
        if (calendarIcon) {
            calendarIcon.addEventListener("click", function () {
                datePicker.open();
            });
        }
    };

    function showToast(message, type) {
        type = type || 'info';
        var container = document.getElementById('toastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toastContainer';
            container.className = 'toast-container';
            document.body.appendChild(container);
        }
        var toast = document.createElement('div');
        toast.className = 'toast';
        var icon = document.createElement('span');
        icon.className = 'toast-icon ' + type;
        icon.textContent = type === 'info' ? 'ℹ️' : '⚠️';
        var msg = document.createElement('span');
        msg.className = 'toast-message';
        msg.textContent = message;
        var closeBtn = document.createElement('button');
        closeBtn.className = 'toast-close';
        closeBtn.innerHTML = '&times;';
        closeBtn.addEventListener('click', function() {
            toast.classList.add('hide');
            setTimeout(function() { toast.remove(); }, 300);
        });
        toast.appendChild(icon);
        toast.appendChild(msg);
        toast.appendChild(closeBtn);
        container.appendChild(toast);
        setTimeout(function() {
            toast.classList.add('hide');
            setTimeout(function() { toast.remove(); }, 300);
        }, 5000);
    }

    function buildQuery(params) {
        var q = Object.keys(params)
            .filter(function (k) {
                return params[k];
            })
            .map(function (k) {
                return (
                    encodeURIComponent(k) + "=" + encodeURIComponent(params[k])
                );
            })
            .join("&");
        return q ? "?" + q : "";
    }

    function loadLogs(filters) {
        filters = filters || getCurrentFilters();
        filters.page = currentPage;
        filters.per_page = 10;

        var query = buildQuery(filters);

        fetch("/admin-api/audit-logs" + query, {
            method: "GET",
            headers: { Accept: "application/json" },
            credentials: "include",
        })
            .then(function (res) {
                if (!res.ok)
                    throw new Error(
                        "Gagal memuat log (status " + res.status + ")",
                    );
                return res.json();
            })
            .then(function (data) {
                var items = Array.isArray(data) ? data : data.data || [];
                currentLogs = items;

                if (items.length === 0 && query !== "") {
                    showToast("Tidak ada log aktivitas yang sesuai dengan filter yang Anda pilih.", "info");
                }

                renderRows(items, data);
                renderPagination(data);
                renderStats(data.stats);
                populateUserFilter(items);
            })
            .catch(function (err) {
                console.error(err);
                tableBody.innerHTML =
                    '<tr><td colspan="6">Gagal memuat log aktivitas.</td></tr>';
            });
    }

    function renderStats(stats) {
        if (!stats) return;

        var total12hElem = document.getElementById("statTotal12h");
        var trendElem = document.getElementById("statTrend12h");
        var failedLoginsElem = document.getElementById("statFailedLogins");
        var failedMetaElem = document.getElementById("statFailedLoginsMeta");
        var contentChangesElem = document.getElementById("statContentChanges");
        var contentMetaElem = document.getElementById("statContentMeta");

        if (total12hElem) {
            total12hElem.textContent = (stats.total_12h || 0).toLocaleString(
                "id-ID",
            );
        }

        if (trendElem) {
            var change = stats.percentage_change || 0;
            var sign = change >= 0 ? "+" : "";
            var arrow = change >= 0 ? "↗ " : "↘ ";

            trendElem.className =
                change >= 0
                    ? "log-stat-meta log-stat-up"
                    : "log-stat-meta log-stat-down";

            if (change < 0) {
                trendElem.style.color = "#dc2626";
            } else {
                trendElem.style.color = "#16a34a";
            }

            trendElem.textContent =
                arrow + sign + change + "% dari 12 jam sebelumnya";
        }

        if (failedLoginsElem) {
            var failedCount = stats.failed_logins_12h || 0;
            failedLoginsElem.textContent = failedCount.toLocaleString("id-ID");

            if (failedMetaElem) {
                if (failedCount === 0) {
                    failedMetaElem.className = "log-stat-meta log-stat-safe";
                    failedMetaElem.style.color = "#16a34a";
                    failedMetaElem.innerHTML =
                        "&#10003; Aman &mdash; Tidak ada ancaman";
                } else if (failedCount < 5) {
                    failedMetaElem.className = "log-stat-meta";
                    failedMetaElem.style.color = "#d97706";
                    failedMetaElem.innerHTML =
                        "&#9888; Perlu Pantauan &mdash; " +
                        failedCount +
                        " percobaan gagal dalam 12 jam";
                } else {
                    failedMetaElem.className = "log-stat-meta";
                    failedMetaElem.style.color = "#dc2626";
                    failedMetaElem.innerHTML =
                        "&#9888; Peringatan &mdash; Potensi Brute Force (12 Jam)";
                }
            }
        }

        if (contentChangesElem) {
            contentChangesElem.textContent = (
                stats.content_changes || 0
            ).toLocaleString("id-ID");
        }

        if (contentMetaElem) {
            var updates = stats.recent_updates || 0;
            var admins = stats.unique_admins || 0;
            contentMetaElem.innerHTML =
                "&#9998; " +
                updates +
                " Update Terakhir oleh " +
                admins +
                " admin berbeda";
        }
    }
    function populateUserFilter(items) {
        if (!filterUser || filterUser.dataset.populated) return;

        var seen = {};
        var users = [];
        items.forEach(function (item) {
            var id = item.admin_id;
            var name = item.admin ? item.admin.name : null;
            if (id && name && !seen[id]) {
                seen[id] = true;
                users.push({ id: id, name: name });
            }
        });

        if (!users.length) return;

        filterUser.innerHTML =
            '<option value="">Semua Admin</option>' +
            users
                .map(function (u) {
                    return (
                        '<option value="' +
                        u.id +
                        '">' +
                        escapeHtml(u.name) +
                        "</option>"
                    );
                })
                .join("");

        filterUser.dataset.populated = "true";
    }

    function renderRows(items, responseData) {
        var tableCount = document.querySelector(".table-count");

        if (!items.length) {
            tableBody.innerHTML =
                '<tr><td colspan="6">Belum ada log aktivitas.</td></tr>';
            if (tableCount) {
                tableCount.textContent = "Menampilkan 0 log";
            }
            return;
        }

        var total =
            responseData && responseData.total !== undefined
                ? responseData.total
                : items.length;
        var from =
            responseData && responseData.from !== undefined
                ? responseData.from
                : 1;
        var to =
            responseData && responseData.to !== undefined
                ? responseData.to
                : items.length;

        if (tableCount) {
            tableCount.textContent =
                "Menampilkan " +
                from +
                " - " +
                to +
                " dari " +
                total.toLocaleString("id-ID") +
                " log";
        }

        tableBody.innerHTML = items
            .map(function (item, index) {
                var dt = formatDateParts(item.created_at);
                var userName = item.admin ? item.admin.name : "Unknown";
                var initials = getInitials(userName);
                var actionBadge = getActionBadge(item.action);

                return (
                    "<tr>" +
                    '<td class="log-timestamp">' +
                    dt.date +
                    "<br><span>" +
                    dt.time +
                    "</span></td>" +
                    '<td class="log-user"><span class="avatar avatar-blue">' +
                    initials +
                    "</span> " +
                    escapeHtml(userName) +
                    "</td>" +
                    '<td class="log-activity"><div class="activity-cell">' +
                    actionBadge +
                    '<span class="activity-text">' +
                    escapeHtml(getActionTitle(item.action)) +
                    "</span></div></td>" +
                    "<td>" +
                    escapeHtml(item.module || "") +
                    "</td>" +
                    '<td class="log-ip">' +
                    escapeHtml(item.ip_address || "-") +
                    "</td>" +
                    '<td><a href="#" class="link-detail" data-index="' +
                    index +
                    '">Detail</a></td>' +
                    "</tr>"
                );
            })
            .join("");
    }

    function renderPagination(data) {
        var paginationContainer = document.querySelector(".pagination");
        if (!paginationContainer) return;

        var totalPages =
            data.last_page || Math.ceil((data.total || 0) / 10) || 1;
        var html = "";

        html +=
            '<button type="button" class="page-btn" data-page="' +
            (currentPage - 1) +
            '" ' +
            (currentPage === 1 ? "disabled" : "") +
            ' aria-label="Sebelumnya">&lsaquo;</button>';

        var startPage = Math.max(1, currentPage - 1);
        var endPage = Math.min(totalPages, currentPage + 1);

        if (startPage > 1) {
            html +=
                '<button type="button" class="page-btn" data-page="1">1</button>';
            if (startPage > 2)
                html += '<span class="page-ellipsis">&hellip;</span>';
        }

        for (var i = startPage; i <= endPage; i++) {
            html +=
                '<button type="button" class="page-btn ' +
                (i === currentPage ? "active" : "") +
                '" data-page="' +
                i +
                '">' +
                i +
                "</button>";
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1)
                html += '<span class="page-ellipsis">&hellip;</span>';
            html +=
                '<button type="button" class="page-btn" data-page="' +
                totalPages +
                '">' +
                totalPages +
                "</button>";
        }

        html +=
            '<button type="button" class="page-btn" data-page="' +
            (currentPage + 1) +
            '" ' +
            (currentPage === totalPages ? "disabled" : "") +
            ' aria-label="Berikutnya">&rsaquo;</button>';

        paginationContainer.innerHTML = html;
    }

    function getActionBadge(action) {
        var normalized = (action || "").toUpperCase();
        var category = getActionCategory(normalized);
        return (
            '<span class="activity-badge badge-' +
            category +
            '">' +
            escapeHtml(normalized) +
            "</span>"
        );
    }

    function getActionCategory(action) {
        var a = (action || "").toUpperCase();
        if (
            a.indexOf("LOGIN") === 0 ||
            a.indexOf("LOGOUT") === 0 ||
            a.indexOf("2FA") !== -1 ||
            a.indexOf("AUTH") !== -1
        ) {
            return "auth";
        }
        if (
            a.indexOf("CREATE") === 0 ||
            a.indexOf("STORE") === 0 ||
            a.indexOf("ADD") === 0 ||
            a.indexOf("WEBHOOK") === 0
        ) {
            return "create";
        }
        if (
            a.indexOf("UPDATE") === 0 ||
            a.indexOf("EDIT") === 0 ||
            a.indexOf("PATCH") === 0 ||
            a.indexOf("PUT") === 0 ||
            a.indexOf("CHANGE") === 0
        ) {
            return "update";
        }
        if (
            a.indexOf("DELETE") === 0 ||
            a.indexOf("REMOVE") === 0 ||
            a.indexOf("DESTROY") === 0 ||
            a.indexOf("BLOCK") === 0 ||
            a.indexOf("FAIL") === 0 ||
            a.indexOf("SECURITY") === 0 ||
            a.indexOf("WARNING") === 0
        ) {
            return "delete";
        }
        return "auth";
    }

    function getActionTitle(action) {
        var normalized = (action || "").toUpperCase();
        var map = {
            UPDATE_TICKET_STATUS: "Update Status Tiket",
            CREATE_TICKET: "Buat Tiket Baru",
            UPDATE: "Memperbarui Data",
            CREATE: "Membuat Data Baru",
            DELETE: "Menghapus Data",
            LOGIN: "Login CMS",
            LOGIN_FAILED: "Login Gagal",
            WEBHOOK_PRODUCT_APPLICATION_CREATED: "Pengajuan Produk Webhook",
        };
        return map[normalized] || normalized;
    }

    function formatDateParts(isoString) {
        if (!isoString) return { date: "-", time: "-" };
        var d = new Date(isoString);
        if (isNaN(d)) return { date: "-", time: "-" };
        var date = d.toLocaleDateString("sv-SE");
        var time = d.toLocaleTimeString("id-ID", {
            hour: "2-digit",
            minute: "2-digit",
            second: "2-digit",
        });
        return { date: date, time: time };
    }

    function getInitials(name) {
        if (!name) return "";
        return name
            .split(" ")
            .map(function (w) {
                return w[0];
            })
            .join("")
            .toUpperCase()
            .slice(0, 2);
    }

    function escapeHtml(str) {
        var div = document.createElement("div");
        div.textContent = str == null ? "" : str;
        return div.innerHTML;
    }

    var refreshBtn = document.getElementById("btnRefresh");
    if (refreshBtn) {
        refreshBtn.addEventListener("click", function () {
            var original = refreshBtn.innerHTML;
            refreshBtn.disabled = true;
            refreshBtn.textContent = "Memuat...";
            currentPage = 1;
            loadLogs(getCurrentFilters());
            setTimeout(function () {
                refreshBtn.innerHTML = original;
                refreshBtn.disabled = false;
            }, 500);
        });
    }

    var exportBtn = document.getElementById("btnExport");
    if (exportBtn) {
        exportBtn.addEventListener("click", function () {
            var filters = getCurrentFilters();
            var query = buildQuery(filters);
            window.location.href = "/admin-api/audit-logs/export" + query;
        });
    }

    var applyBtn =
        document.getElementById("btnApplyFilter") ||
        document.querySelector(".filter-panel button");

    if (applyBtn) {
        applyBtn.addEventListener("click", function (e) {
            e.preventDefault();
            currentPage = 1;
            loadLogs(getCurrentFilters());
        });
    }


    function toYmd(date) {
        var y = date.getFullYear();
        var m = String(date.getMonth() + 1).padStart(2, "0");
        var d = String(date.getDate()).padStart(2, "0");
        return y + "-" + m + "-" + d;
    }

    function getCurrentFilters() {
        var actionVal = filterAction ? filterAction.value : "";
        var moduleVal = filterModule ? filterModule.value : "";
        var userVal = filterUser ? filterUser.value : "";
        var dateVal = filterDate ? filterDate.value : "";

        var isPlaceholder = function (v) {
            return !v || v.indexOf("Semua") === 0;
        };

        var filters = {
            adminId: isPlaceholder(userVal) ? "" : userVal,
            action: isPlaceholder(actionVal) ? "" : actionVal,
            module: isPlaceholder(moduleVal) ? "" : moduleVal,
        };

        if (dateVal) {
            var dates = [];
            if (dateVal.indexOf(" to ") !== -1) {
                dates = dateVal.split(" to ");
            } else if (dateVal.indexOf(" - ") !== -1) {
                dates = dateVal.split(" - ");
            }

            if (dates.length === 2) {
                var fromDate = new Date(dates[0]);
                var toDate = new Date(dates[1]);

                if (!isNaN(fromDate) && !isNaN(toDate)) {
                    filters.from = toYmd(fromDate);
                    filters.to = toYmd(toDate);
                }
            } else {
                var singleDate = new Date(dateVal);
                if (!isNaN(singleDate)) {
                    filters.from = toYmd(singleDate);
                    filters.to = toYmd(singleDate);
                }
            }
        }

        return filters;
    }

    var paginationContainer = document.querySelector(".pagination");
    if (paginationContainer) {
        paginationContainer.addEventListener("click", function (e) {
            var btn = e.target.closest(".page-btn");
            if (
                !btn ||
                btn.hasAttribute("disabled") ||
                btn.classList.contains("active")
            )
                return;

            var targetPage = parseInt(btn.getAttribute("data-page"), 10);
            if (targetPage) {
                currentPage = targetPage;
                loadLogs();
            }
        });
    }

    var auditModal = document.getElementById("auditModal");
    var auditDiff = document.getElementById("auditDiff");
    var auditMeta = document.getElementById("auditMeta");
    var auditSession = document.getElementById("auditSession");
    var auditModalTitle = document.getElementById("auditModalTitle");
    var auditModalSubtitle = document.getElementById("auditModalSubtitle");

    function openAuditModal() {
        if (!auditModal) return;
        auditModal.classList.add("is-open");
        auditModal.setAttribute("aria-hidden", "false");
        document.body.style.overflow = "hidden";
    }

    function closeAuditModal() {
        if (!auditModal) return;
        auditModal.classList.remove("is-open");
        auditModal.setAttribute("aria-hidden", "true");
        document.body.style.overflow = "";
    }

    function renderDiff(log) {
        if (!auditDiff) return;
        var oldValues = log.old_values || {};
        var newValues = log.new_values || {};
        var keys = Object.keys(newValues).length
            ? Object.keys(newValues)
            : Object.keys(oldValues);

        if (!keys.length) {
            auditDiff.innerHTML =
                '<p class="audit-empty">Tidak ada perubahan data.</p>';
            return;
        }

        auditDiff.innerHTML = keys
            .map(function (key) {
                var oldVal = oldValues[key];
                var newVal = newValues[key];
                var oldStr =
                    oldVal === undefined || oldVal === null
                        ? "-"
                        : escapeHtml(String(oldVal));
                var newStr =
                    newVal === undefined || newVal === null
                        ? "-"
                        : escapeHtml(String(newVal));
                return (
                    '<div class="audit-diff-row">' +
                    '<span class="audit-diff-field">' +
                    escapeHtml(key) +
                    "</span>" +
                    '<span class="audit-diff-old">' +
                    oldStr +
                    "</span>" +
                    '<span class="audit-diff-arrow">&rarr;</span>' +
                    '<span class="audit-diff-new">' +
                    newStr +
                    "</span>" +
                    "</div>"
                );
            })
            .join("");
    }

    function isEmpty(value) {
        return (
            value === null ||
            value === undefined ||
            value === "" ||
            value === "-"
        );
    }

    function renderMeta(log) {
        if (!auditMeta) return;
        var rows = [
            ["Aktivitas", log.action],
            ["Modul", log.module],
            ["Metode", log.method],
            ["Rute", log.route],
            ["Status Kode", log.status_code != null ? log.status_code : null],
            ["Alamat IP", log.ip_address],
            ["Detail", log.details || log.detail],
            ["Alasan Gagal", log.failure_reason],
        ];
        auditMeta.innerHTML = rows
            .filter(function (row) {
                return !isEmpty(row[1]);
            })
            .map(function (row) {
                return (
                    "<div><dt>" +
                    escapeHtml(row[0]) +
                    "</dt><dd>" +
                    escapeHtml(row[1]) +
                    "</dd></div>"
                );
            })
            .join("");
    }

    function renderSession(log) {
        if (!auditSession) return;
        var rows = [
            ["Admin", log.admin ? log.admin.name : "Unknown"],
            ["User Agent", log.user_agent],
            ["ID Sesi", log.session_id],
            ["Auth Guard", log.auth_guard],
        ];
        auditSession.innerHTML = rows
            .filter(function (row) {
                return !isEmpty(row[1]);
            })
            .map(function (row) {
                return (
                    "<div><dt>" +
                    escapeHtml(row[0]) +
                    "</dt><dd>" +
                    escapeHtml(row[1]) +
                    "</dd></div>"
                );
            })
            .join("");
    }

    tableBody.addEventListener("click", function (e) {
        var detailBtn = e.target.closest(".link-detail");
        if (!detailBtn) return;
        e.preventDefault();
        var idx = detailBtn.getAttribute("data-index");
        var log = currentLogs[idx];
        if (!log) return;

        if (auditModalTitle) {
            auditModalTitle.textContent =
                "Detail Log #" + (log.id != null ? log.id : "-");
        }
        if (auditModalSubtitle) {
            auditModalSubtitle.textContent =
                (log.action || "") +
                " - " +
                (log.module || "") +
                " - " +
                (log.created_at || "");
        }

        renderDiff(log);
        renderMeta(log);
        renderSession(log);
        openAuditModal();
    });

    if (auditModal) {
        auditModal.addEventListener("click", function (e) {
            if (e.target.closest("[data-audit-close]")) {
                closeAuditModal();
            }
        });
        document.addEventListener("keydown", function (e) {
            if (e.key === "Escape" && auditModal.classList.contains("is-open")) {
                closeAuditModal();
            }
        });
    }
});
