let currentPage = 1;
let totalPages = 1;

function esc(str) {
  if (!str) return '';
  return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function fmtTime(iso) {
  if (!iso) return '';
  const d = new Date(iso);
  return d.toLocaleTimeString('en-PH', { hour: 'numeric', minute: '2-digit', hour12: true });
}

function fmtDateTime(iso) {
  if (!iso) return '';
  const d = new Date(iso);
  return d.toLocaleString('en-PH', { month: 'short', day: 'numeric', hour: 'numeric', minute: '2-digit', hour12: true });
}

const urlParams = new URLSearchParams(window.location.search);
currentPage = parseInt(urlParams.get('page') || '1');
document.getElementById('search-input').value = urlParams.get('search') || '';

const filterOptions = {
  all: 'All Time',
  signed_in: 'Currently Signed In',
  signed_out: 'Signed Out',
  today: 'Today',
  this_week: 'This Week',
  this_month: 'This Month'
};

const visitorTypeOptions = {
  all: 'All Visitors',
  usc: 'USC',
  guest: 'Guest'
};

const initialFilter = urlParams.get('filter') || 'all';
const initialVisitorType = urlParams.get('visitor_type') || 'all';

document.getElementById('filter-value').value = initialFilter;
document.getElementById('visitor-type-value').value = initialVisitorType;
document.getElementById('filter-label').textContent = filterOptions[initialFilter];
document.getElementById('visitor-type-label').textContent = visitorTypeOptions[initialVisitorType];

markActiveDropdownItem('filter-menu', initialFilter);
markActiveDropdownItem('visitor-type-menu', initialVisitorType);

fetchSignedIn();
fetchVisitors();

function markActiveDropdownItem(menuId, value) {
  const menu = document.getElementById(menuId);
  menu.querySelectorAll('.dropdown-item').forEach(item => {
    item.classList.toggle('active', item.dataset.value === value);
  });
}

function setupDropdown(btnId, menuId, hiddenInputId, labelId, optionsObj) {
  const btn = document.getElementById(btnId);
  const menu = document.getElementById(menuId);

  btn.addEventListener('click', (e) => {
    e.stopPropagation();
    const isOpen = btn.classList.contains('open');
    document.querySelectorAll('.dropdown-btn').forEach(b => {
      b.classList.remove('open');
      b.nextElementSibling?.classList.remove('open');
    });
    if (!isOpen) {
      btn.classList.add('open');
      menu.classList.add('open');
    }
  });

  menu.querySelectorAll('.dropdown-item').forEach(item => {
    item.addEventListener('click', (e) => {
      e.stopPropagation();
      const value = item.dataset.value;
      document.getElementById(hiddenInputId).value = value;
      document.getElementById(labelId).textContent = optionsObj[value];
      markActiveDropdownItem(menuId, value);
      btn.classList.remove('open');
      menu.classList.remove('open');
      currentPage = 1;
      fetchVisitors(1);
    });
  });
}

setupDropdown('filter-btn', 'filter-menu', 'filter-value', 'filter-label', filterOptions);
setupDropdown('visitor-type-btn', 'visitor-type-menu', 'visitor-type-value', 'visitor-type-label', visitorTypeOptions);

document.addEventListener('click', () => {
  document.querySelectorAll('.dropdown-btn').forEach(b => b.classList.remove('open'));
  document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.remove('open'));
});

document.getElementById('filter-form').addEventListener('submit', function (e) {
  e.preventDefault();
  currentPage = 1;
  fetchVisitors(1);
});

function renderPagination() {
  const container = document.getElementById('pagination-container');
  if (!container) return;

  if (totalPages <= 1) {
    container.innerHTML = '';
    return;
  }

  let html = '<div class="pagination">';
  html += `<a href="#" class="page-arrow ${currentPage === 1 ? 'disabled' : ''}" onclick="goToPage(${currentPage - 1}); return false;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg></a>`;

  for (let i = 1; i <= totalPages; i++) {
    if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
      html += `<button class="page-btn ${i === currentPage ? 'active' : ''}" onclick="goToPage(${i})">${i}</button>`;
    } else if (i === currentPage - 2 || i === currentPage + 2) {
      html += '<span class="page-ellipsis">...</span>';
    }
  }

  html += `<a href="#" class="page-arrow ${currentPage === totalPages ? 'disabled' : ''}" onclick="goToPage(${currentPage + 1}); return false;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg></a>`;
  html += '</div>';

  container.innerHTML = html;
}

function goToPage(page) {
  if (page < 1 || page > totalPages) return;
  currentPage = page;
  fetchVisitors(page);
}


function fetchSignedIn() {
  fetch('?api=admin/signed_in')
    .then(res => res.json())
    .then(data => renderSignedIn(Array.isArray(data) ? data : []))
    .catch(() => {});
}

function fetchVisitors(page = 1) {
  const search       = document.getElementById('search-input').value.trim();
  const filter       = document.getElementById('filter-value').value;
  const visitor_type = document.getElementById('visitor-type-value').value;

  const q = new URLSearchParams({ search, filter, visitor_type, page }).toString();
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
        <td style="position:relative;">
          <a href="#" class="dots-link" onclick="toggleMenu(${log.visitor_id}); return false;">···</a>
          <div id="menu-${log.visitor_id}" class="action-menu" style="display:none;">
            <a href="?page=visitor_detail&id=${parseInt(log.visitor_id)}">View Visitor</a>
            ${!isOut ? `<a href="#" onclick="signOutPerson(${parseInt(log.visitor_id)}); return false;">Mark Signed Out</a>` : ''}
          </div>
        </td>
      </tr>
    `;
  }).join('');
}

function toggleMenu(visitorId) {
  const menu = document.getElementById(`menu-${visitorId}`);
  const allMenus = document.querySelectorAll('.action-menu');
  allMenus.forEach(m => {
    if (m.id !== `menu-${visitorId}`) m.style.display = 'none';
  });
  menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}

document.addEventListener('click', function(e) {
  if (!e.target.closest('.dots-link')) {
    document.querySelectorAll('.action-menu').forEach(m => m.style.display = 'none');
  }
});

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
