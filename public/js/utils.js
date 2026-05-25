function tick() {
  const now = new Date();
  document.getElementById('t-time').textContent =
    now.toLocaleTimeString('en-PH', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
  document.getElementById('t-date').textContent =
    now.toLocaleDateString('en-PH', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
}

if (document.getElementById('t-time')) {
  tick();
  setInterval(tick, 1000);
}

// Normalize contact number to digits only
function normalizeContact(input) {
  return input.replace(/\D/g, '');
}

// Escape HTML special characters
function esc(str) {
  if (str == null) return '';
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}

// Format date (e.g., "Jan 15, 2026")
function fmtDate(dt) {
  return new Date(dt).toLocaleDateString('en-PH', { month: 'short', day: 'numeric', year: 'numeric' });
}

// Format time (e.g., "9:30 AM")
function fmtTime(dt) {
  return new Date(dt).toLocaleTimeString('en-PH', { hour: 'numeric', minute: '2-digit', hour12: true });
}

// Format full date + time without year (e.g., "Jan 15, 9:30 AM") - for dashboard
function fmtDateTime(dt) {
  const d = new Date(dt);
  return d.toLocaleDateString('en-PH', { month: 'short', day: 'numeric' }) + ', ' +
         d.toLocaleTimeString('en-PH', { hour: 'numeric', minute: '2-digit', hour12: true });
}

// Format full date + time with year (e.g., "Jan 15, 2026 9:30 AM") - for detail pages
function fmtDateTimeWithYear(dt) {
  const d = new Date(dt);
  return d.toLocaleDateString('en-PH', { month: 'short', day: 'numeric', year: 'numeric' }) + ' ' +
         d.toLocaleTimeString('en-PH', { hour: 'numeric', minute: '2-digit', hour12: true });
}
