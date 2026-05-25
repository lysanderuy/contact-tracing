const params     = new URLSearchParams(window.location.search);
const visitorId  = parseInt(params.get('visitor_id'));
const statusParam = params.get('status');

if (!visitorId) {
  window.location.href = '?page=home';
}

fetch('?api=visitors/get&id=' + visitorId)
  .then(res => res.json())
  .then(data => {
    if (data.error) { window.location.href = '?page=home'; return; }
    renderVerify(data);
  })
  .catch(() => { window.location.href = '?page=home'; });

function renderVerify(v) {
  const isSignedIn  = (statusParam || v.status) === 'signed_in';
  const action      = isSignedIn ? 'sign_out' : 'sign_in';
  const actionLabel = isSignedIn ? 'Sign Out' : 'Sign In';

  const fullName = [v.first_name, v.middle_name, v.last_name].filter(Boolean).join(' ');
  const initials = v.first_name && v.last_name
    ? (v.first_name[0] + v.last_name[0]).toUpperCase()
    : '??';

  document.getElementById('v-avatar').textContent = initials;
  document.getElementById('v-name').textContent = fullName;
  document.getElementById('v-id-type').textContent =
    v.id_number ? 'USC ID: ' + v.id_number : 'Guest';

  const statusText = isSignedIn ? 'Signed In' : 'Signed Out';
  document.getElementById('v-status').textContent = statusText;
  document.getElementById('confirm-btn-text').textContent = 'Confirm & ' + actionLabel;

  const statusBox = document.getElementById('verify-status-box');
  statusBox.className = 'verify-status ' + (isSignedIn ? 'status-in' : 'status-out');

  const grid = document.getElementById('v-info-grid');
  const infoItems = [
    ['Contact', v.contact_number],
    v.email ? ['Email', v.email] : null,
    (v.barangay || v.city) ? ['Location', [v.barangay, v.city].filter(Boolean).join(', ')] : null,
  ].filter(Boolean);

  grid.innerHTML = infoItems.map(([label, val]) => `
    <div class="verify-info-item">
      <div class="verify-info-label">${label}</div>
      <div class="verify-info-value">${val}</div>
    </div>
  `).join('');

  document.getElementById('verify-loading').style.display = 'none';
  document.getElementById('verify-content').style.display = '';

  window._ct = {
    visitorId,
    action,
    nextPage: '?page=confirmation&visitor_id=' + visitorId + '&action=' + (isSignedIn ? 'signed_out' : 'signed_in'),
  };
}

function handleConfirm() {
  const { visitorId, action, nextPage } = window._ct;
  fetch('?api=visitors/sign', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ visitor_id: visitorId, action }),
  })
    .then(res => res.json())
    .then(data => {
      if (data.error) { appModal.alert(data.error, 'Error', 'error'); return; }
      const ts = data.timestamp ? '&ts=' + encodeURIComponent(data.timestamp) : '';
      window.location.href = nextPage + ts;
    })
    .catch(() => appModal.alert('System error. Please try again.', 'Error', 'error'));
}
