// app.js — small, focused behaviors shared across every page.
// No frameworks: this is a records app, not a SPA.

document.addEventListener('DOMContentLoaded', function () {
    initAlerts();
    initTableSearch();
    initConfirmLinks();
});

/* ---------------- Auto-dismiss success/info alerts ---------------- */

function initAlerts() {
    var alerts = document.querySelectorAll('.alert-success, .alert-info');
    alerts.forEach(function (el) {
        setTimeout(function () {
            el.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            el.style.opacity = '0';
            el.style.transform = 'translateY(-4px)';
            setTimeout(function () { el.remove(); }, 400);
        }, 4000);
    });
}

/* ---------------- Live table search ---------------- */
// Any input with [data-table-search="tableId"] filters that table's rows
// live, matching against all visible cell text in each row.

function initTableSearch() {
    var boxes = document.querySelectorAll('[data-table-search]');
    boxes.forEach(function (box) {
        var table = document.getElementById(box.getAttribute('data-table-search'));
        if (!table) return;

        var countEl = document.querySelector('[data-table-count="' + table.id + '"]');
        var rows = Array.prototype.slice.call(table.querySelectorAll('tbody tr, tr')).filter(function (r) {
            return r.querySelector('td'); // skip header row
        });

        box.addEventListener('input', function () {
            var q = box.value.trim().toLowerCase();
            var shown = 0;
            rows.forEach(function (row) {
                var text = row.textContent.toLowerCase();
                var match = q === '' || text.indexOf(q) !== -1;
                row.style.display = match ? '' : 'none';
                if (match) shown++;
            });
            if (countEl) {
                countEl.textContent = q === '' ? '' : (shown + (shown === 1 ? ' match' : ' matches'));
            }
        });
    });
}

/* ---------------- Custom confirm modal for delete links ---------------- */
// Any link with [data-confirm="Message"] gets intercepted and routed
// through a styled modal instead of the browser's native confirm().

function initConfirmLinks() {
    var links = document.querySelectorAll('[data-confirm]');
    if (!links.length) return;

    var overlay = document.createElement('div');
    overlay.className = 'confirm-overlay';
    overlay.innerHTML =
        '<div class="confirm-box" role="alertdialog" aria-modal="true">' +
        '  <p class="confirm-message"></p>' +
        '  <div class="confirm-actions">' +
        '    <button type="button" class="btn btn-secondary confirm-cancel">Cancel</button>' +
        '    <a href="#" class="btn confirm-ok" style="background:var(--coral)">Delete</a>' +
        '  </div>' +
        '</div>';
    document.body.appendChild(overlay);

    var messageEl = overlay.querySelector('.confirm-message');
    var okEl = overlay.querySelector('.confirm-ok');
    var cancelEl = overlay.querySelector('.confirm-cancel');
    var pendingHref = null;

    function open(href, message) {
        pendingHref = href;
        messageEl.textContent = message || 'Are you sure?';
        overlay.classList.add('open');
    }
    function close() {
        overlay.classList.remove('open');
        pendingHref = null;
    }

    links.forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            open(link.getAttribute('href'), link.getAttribute('data-confirm'));
        });
    });

    okEl.addEventListener('click', function (e) {
        e.preventDefault();
        if (pendingHref) window.location.href = pendingHref;
    });
    cancelEl.addEventListener('click', close);
    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) close();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') close();
    });
}
