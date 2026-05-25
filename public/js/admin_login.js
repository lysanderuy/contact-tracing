document.getElementById('login-form').addEventListener('submit', function (e) {
  e.preventDefault();
  handleLogin();
});

function handleLogin() {
  const username   = document.getElementById('username').value.trim();
  const password   = document.getElementById('password').value;
  const csrf_token = document.getElementById('csrf-token').value;
  const errorEl    = document.getElementById('login-error');

  errorEl.style.display = 'none';

  if (!username || !password) return;

  fetch('?api=auth/login', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ username, password, csrf_token }),
  })
    .then(res => res.json())
    .then(data => {
      if (data.error) {
        errorEl.textContent = data.error;
        errorEl.style.display = '';
        return;
      }
      window.location.href = '?page=admin_dashboard';
    })
    .catch(() => {
      errorEl.textContent = 'System error. Please try again.';
      errorEl.style.display = '';
    });
}
