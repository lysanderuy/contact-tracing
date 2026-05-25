let currentPage = 1;
let totalPages = 1;

const urlParams = new URLSearchParams(window.location.search);
currentPage = parseInt(urlParams.get('page') || '1');
document.getElementById('search-input').value   = urlParams.get('search') || '';
document.getElementById('filter-select').value  = urlParams.get('filter') || 'all';
document.getElementById('date-from').value       = urlParams.get('date_from') || '';
document.getElementById('date-to').value         = urlParams.get('date_to') || '';
toggleDateRange();

fetchSignedIn();
fetchVisitors();

document.getElementById('filter-form').addEventListener('submit', function (e) {
  e.preventDefault();
  currentPage = 1;
  fetchVisitors(1);
});

document.getElementById('filter-select').addEventListener('change', function () {
  toggleDateRange();
  if (this.value !== 'date_range') {
    currentPage = 1;
    fetchVisitors(1);
  }
});

function renderPagination() {
  const container = document.getElementById('pagination-container');
  if (!container) return;

  if (totalPages <= 1) {
    container.innerHTML = '';
    return;
  }

  let html = '<div class="pagination">';
  html += `<button class="page-btn ${currentPage === 1 ? 'disabled' : ''}" onclick="goToPage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>Prev</button>`;

  for (let i = 1; i <= totalPages; i++) {
    if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
      html += `<button class="page-btn ${i === currentPage ? 'active' : ''}" onclick="goToPage(${i})">${i}</button>`;
    } else if (i === currentPage - 2 || i === currentPage + 2) {
      html += '<span class="page-ellipsis">...</span>';
    }
  }

  html += `<button class="page-btn ${currentPage === totalPages ? 'disabled' : ''}" onclick="goToPage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>Next</button>`;
  html += '</div>';

  container.innerHTML = html;
}

function goToPage(page) {
  if (page < 1 || page > totalPages) return;
  currentPage = page;
  fetchVisitors(page);
}

function toggleDateRange() {
  const show = document.getElementById('filter-select').value === 'date_range';
  document.getElementById('date-range-inputs').style.display = show ? '' : 'none';
}

function fetchSignedIn() {
  fetch('?api=admin/signed_in')
    .then(res => res.json())
    .then(data => renderSignedIn(Array.isArray(data) ? data : []))
    .catch(() => {});
}

function fetchVisitors(page = 1) {
  const search     = document.getElementById('search-input').value.trim();
  const filter     = document.getElementById('filter-select').value;
  const date_from  = document.getElementById('date-from').value;
  const date_to    = document.getElementById('date-to').value;

  const q = new URLSearchParams({ search, filter, date_from, date_to, page }).toString();
  fetch('?api=admin/visitors&' + q)
    .then(res => res.json())
    .then(data => {
      const visitors = Array.isArray(data.data) ? data.data : [];
      currentPage = data.page || 1;
      totalPages = data.total_pages || 1;
      renderVisitors(visitors);
      renderPagination();
    })
    .catch(() => {});
}

function renderSignedIn(visitors) {
  const grid = document.getElementById('signed-in-grid');
  document.getElementById('signed-in-count').textContent = visitors.length;

  if (visitors.length === 0) {
    grid.innerHTML = '<div style="font-size:13px;color:var(--text-muted);">No one is currently signed in.</div>';
    return;
  }

  grid.innerHTML = visitors.map(p => `
    <a class="person-card" href="?page=visitor_detail&id=${parseInt(p.visitor_id)}" style="text-decoration:none;color:inherit;display:block;">
      <div class="person-name">${esc(p.first_name + ' ' + p.last_name)}</div>
      <div class="person-meta">${p.id_number ? 'ID: ' + esc(p.id_number) : 'Guest: ' + esc(p.contact_number)}</div>
      <div class="person-time">Since ${fmtTime(p.sign_in)}</div>
    </a>
  `).join('');
}

function renderVisitors(logs) {
  const tbody = document.getElementById('visitor-tbody');

  if (logs.length === 0) {
    tbody.innerHTML = '<tr><td colspan="7" style="text-align:center;color:var(--text-muted);font-size:13px;">No records found.</td></tr>';
    return;
  }

  tbody.innerHTML = logs.map(log => {
    const location = [log.barangay, log.city].filter(Boolean).join(', ');
    const isOut    = !!log.sign_out;
    return `
      <tr>
        <td><a class="view-link" href="?page=visitor_detail&id=${parseInt(log.visitor_id)}">${esc(log.first_name + ' ' + log.last_name)}</a></td>
        <td>${log.id_number ? esc(log.id_number) : esc(log.contact_number)}</td>
        <td>${esc(location)}</td>
        <td>${fmtDateTime(log.sign_in)}</td>
        <td>${log.sign_out ? fmtDateTime(log.sign_out) : '—'}</td>
        <td><span class="status-badge ${isOut ? 'status-out' : 'status-in'}">${isOut ? 'Out' : 'In'}</span></td>
        <td>
          <a class="view-link" href="?page=visitor_detail&id=${parseInt(log.visitor_id)}">View</a>
          ${!isOut ? `<button class="sign-out-btn" style="padding:4px 8px;font-size:10px;" onclick="signOutPerson(${parseInt(log.visitor_id)})">Sign Out</button>` : ''}
        </td>
      </tr>
    `;
  }).join('');
}

function signOutPerson(visitorId) {
  if (!confirm('Sign out this visitor?')) return;
  fetch('?api=visitors/sign', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ visitor_id: visitorId, action: 'sign_out' }),
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        fetchSignedIn();
        fetchVisitors(currentPage);
      } else {
        alert(data.error || 'Failed to sign out');
      }
    })
    .catch(() => alert('System error'));
}
