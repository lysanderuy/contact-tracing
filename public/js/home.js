function handleUSC() {
  const id = document.getElementById('usc-input').value.trim();
  if (!id) {
    document.getElementById('usc-input').focus();
    return;
  }
  fetch('?api=visitors/check', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id_number: id })
  })
  .then(res => res.json())
  .then(data => {
    if (data.error) { appModal.alert(data.error, 'Error', 'error'); return; }
    if (data.found) {
      window.location.href = '?page=verify&visitor_id=' + data.visitor_id + '&status=' + data.status;
    } else {
      window.location.href = '?page=register&id=' + encodeURIComponent(id);
    }
  })
  .catch(err => { console.error(err); appModal.alert('System error. Please try again.', 'Error', 'error'); });
}

function handleGuest() {
  window.location.href = '?page=guest_entry';
}

document.getElementById('usc-input').addEventListener('keydown', e => {
  if (e.key === 'Enter') handleUSC();
});
