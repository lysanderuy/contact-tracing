const contactInput = document.getElementById('guest-contact');

contactInput.addEventListener('input', e => {
  e.target.value = normalizeContact(e.target.value);
});

function handleGuestSubmit() {
  const contact = contactInput.value.trim();
  if (contact.length < 10) {
    appModal.alert('Please enter a valid contact number (at least 10 digits)', 'Invalid Input', 'error');
    return;
  }
  fetch('?api=visitors/check', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ contact_number: contact })
  })
  .then(res => res.json())
  .then(data => {
    if (data.error) { appModal.alert(data.error, 'Error', 'error'); return; }
    if (data.found) {
      window.location.href = '?page=verify&visitor_id=' + data.visitor_id + '&status=' + data.status;
    } else {
      window.location.href = '?page=register&contact=' + encodeURIComponent(contact);
    }
  })
  .catch(err => { console.error(err); appModal.alert('System error. Please try again.', 'Error', 'error'); });
}

contactInput.addEventListener('keydown', e => {
  if (e.key === 'Enter') handleGuestSubmit();
});
