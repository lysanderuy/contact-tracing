function handleRegister() {
  const first = document.getElementById('reg-first').value.trim();
  const last = document.getElementById('reg-last').value.trim();
  const contact = normalizeContact(document.getElementById('reg-contact').value.trim());

  if (!first || !last) {
    appModal.alert('First name and last name are required', 'Missing Fields', 'error');
    return;
  }
  if (!contact || contact.length < 10) {
    appModal.alert('Please enter a valid contact number', 'Invalid Contact', 'error');
    return;
  }

  const payload = {
    first_name: first,
    last_name: last,
    barangay: document.getElementById('reg-brgy').value.trim() || null,
    city: document.getElementById('reg-city').value.trim() || null,
    province: document.getElementById('reg-prov').value.trim() || null,
    contact_number: contact
  };

  const idEl = document.getElementById('reg-id');
  if (idEl) payload.id_number = idEl.value.trim();

  fetch('?api=visitors/register', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(payload)
  })
  .then(res => res.json())
  .then(data => {
    if (data.error) { appModal.alert(data.error, 'Error', 'error'); return; }
    window.location.href = '?page=confirmation&visitor_id=' + data.visitor_id + '&action=signed_in';
  })
  .catch(err => { console.error(err); appModal.alert('System error. Please try again.', 'Error', 'error'); });
}

const firstEmpty = Array.from(document.querySelectorAll('input:not([readonly])')).find(i => !i.value);
if (firstEmpty) firstEmpty.focus();
