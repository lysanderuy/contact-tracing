const visitorId = window._ct.visitorId;

fetch('?api=admin/visitor&id=' + visitorId)
  .then(res => res.json())
  .then(data => {
    if (data.error) { window.location.href = '?page=admin_dashboard'; return; }
    renderDetail(data);
  })
  .catch(() => { window.location.href = '?page=admin_dashboard'; });

function renderDetail({ visitor: v, logs, first_visit, currently_signed_in }) {
  const initials = (v.first_name[0] + v.last_name[0]).toUpperCase();
  document.getElementById('visitor-avatar').textContent = initials;

  document.getElementById('visitor-name').textContent =
    [v.first_name, v.last_name].filter(Boolean).join(' ');
  document.getElementById('visitor-id-type').textContent =
    v.id_number ? 'USC ID: ' + v.id_number : 'Guest';

  const badge = document.getElementById('visitor-status-badge');
  badge.textContent = currently_signed_in ? 'Currently Signed In' : 'Not Inside';
  badge.className = 'status-badge ' + (currently_signed_in ? 'status-in' : 'status-out');

  const infoItems = [
    ['Contact Number', v.contact_number],
    v.email ? ['Email', v.email] : null,
    (v.barangay || v.city || v.province) ? ['Location', [v.barangay, v.city, v.province].filter(Boolean).join(', ')] : null,
    first_visit ? ['First Visit', fmtDate(first_visit)] : null,
  ].filter(Boolean);

  document.getElementById('visitor-info-grid').innerHTML = infoItems.map(([label, val]) => `
    <div class="info-item">
      <div class="info-label">${esc(label)}</div>
      <div class="info-value">${esc(val)}</div>
    </div>
  `).join('');

  if (currently_signed_in) {
    document.getElementById('sign-out-container').innerHTML =
      `<button class="sign-out-btn" onclick="signOutVisitor()">Mark Signed Out</button>`;
  }

  // Visit history
  document.getElementById('history-tbody').innerHTML = logs.map(log => {
    const signInDate = fmtDate(log.sign_in);
    const signInTime = fmtTime(log.sign_in);
    let signOut = '—';
    let duration = '—';
    if (log.sign_out) {
      signOut = fmtTime(log.sign_out);
      const diff = new Date(log.sign_out) - new Date(log.sign_in);
      const h = Math.floor(diff / 3600000);
      const m = Math.floor((diff % 3600000) / 60000);
      duration = h + 'h ' + m + 'm';
    }
    return `
      <tr>
        <td>${signInDate}</td>
        <td>${signInTime}</td>
        <td>${signOut}</td>
        <td>${duration}</td>
      </tr>
    `;
  }).join('');

  document.getElementById('detail-loading').style.display = 'none';
  document.getElementById('detail-content').classList.remove('hidden');
}

function signOutVisitor() {
  appModal.confirm('Sign out this visitor now?', 'Confirm', function() {
    fetch('?api=visitors/sign', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ visitor_id: visitorId, action: 'sign_out' }),
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          location.reload();
        } else {
          appModal.alert(data.error || 'Failed to sign out', 'Error', 'error');
        }
      })
      .catch(() => appModal.alert('System error', 'Error', 'error'));
  });
}
