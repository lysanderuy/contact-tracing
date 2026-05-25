<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['admin_id'])) {
    header('Location: ?page=admin_dashboard');
    exit;
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$page_title = 'Admin Login — CpE Contact Tracing';
$css_files  = ['admin.css', 'admin_login.css'];
$page_js    = ['js/admin_login.js'];
$skip_footer = true;
include __DIR__ . '/../includes/header.php';
?>

<div class="welcome">
  <h1>Admin <span>Portal</span></h1>
  <p>Sign in to access the admin dashboard.</p>
</div>

<div class="card">
  <div class="error" id="login-error" style="display:none;"></div>

  <form id="login-form">
    <input type="hidden" id="csrf-token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>"/>
    <div class="field">
      <label for="username">Username</label>
      <div class="field-input">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
          <circle cx="12" cy="7" r="4"/>
        </svg>
        <input type="text" id="username" name="username" placeholder="e.g., admin" required autofocus autocomplete="username"/>
      </div>
    </div>
    <div class="field">
      <label for="password">Password</label>
      <div class="field-input">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="11" width="18" height="11" rx="2"/>
          <circle cx="12" cy="16" r="1"/>
        </svg>
        <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="current-password"/>
      </div>
    </div>
    <button type="submit" class="btn-main">Login</button>
  </form>

  <a class="login-link" href="?page=home">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M19 12H5M12 19l-7-7 7-7"/>
    </svg>
    Back to Home
  </a>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
