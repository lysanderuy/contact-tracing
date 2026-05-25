const params     = new URLSearchParams(window.location.search);
const visitorId  = parseInt(params.get('visitor_id'));
const action     = params.get('action'); // 'signed_in' or 'signed_out'
const ts         = params.get('ts');

const isSignedIn = action === 'signed_in';

// Update heading
document.getElementById('confirm-heading').querySelector('h1').innerHTML =
  isSignedIn ? 'Signed <span>In</span>' : 'Signed <span>Out</span>';

// Update icon style
const iconEl = document.getElementById('confirm-icon');
iconEl.style.background  = isSignedIn ? 'var(--blue-50)' : '#f0f9f0';
const svgEl = document.getElementById('confirm-svg-icon');
svgEl.style.color = isSignedIn ? 'var(--blue-500)' : '#22c55e';
svgEl.innerHTML = isSignedIn
  ? '<path d="M5 12h14M12 5l7 7-7 7"/>'
  : '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/>';

// Show timestamp if available
if (ts) {
  const date = new Date(ts.replace(' ', 'T'));
  document.getElementById('confirm-time').textContent =
    date.toLocaleDateString('en-PH', { month: 'long', day: 'numeric', year: 'numeric' }) + ' ' +
    date.toLocaleTimeString('en-PH', { hour: 'numeric', minute: '2-digit', hour12: true });
}

// Fetch visitor name
if (visitorId) {
  fetch('?api=visitors/get&id=' + visitorId)
    .then(res => res.json())
    .then(data => {
      if (!data.error) {
        document.getElementById('confirm-name').textContent =
          [data.first_name, data.last_name].filter(Boolean).join(' ');
      }
    })
    .catch(() => {});
}

// Countdown redirect
let count = 5;
const countdownEl = document.getElementById('countdown');
const timer = setInterval(() => {
  count--;
  countdownEl.textContent = count;
  if (count <= 0) {
    clearInterval(timer);
    window.location.href = '?page=home';
  }
}, 1000);
