<?php
$page_title = 'Guest Entry — CpE Contact Tracing';
$css_files  = ['home.css'];
$page_js    = 'js/guest_entry.js';
include __DIR__ . '/../includes/header.php';
?>

<div class="welcome">
  <h1>Guest <span>Entry</span></h1>
  <p>Enter your contact number to proceed.</p>
</div>

<div class="card">
  <div class="field">
    <label for="guest-contact">Contact Number</label>
    <div class="field-input">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
      </svg>
      <input type="text" id="guest-contact" placeholder="e.g., 09171234567" autocomplete="off" maxlength="11" />
    </div>
  </div>

  <button class="btn-main" onclick="handleGuestSubmit()">
    Continue
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M5 12h14M12 5l7 7-7 7"/>
    </svg>
  </button>

  <div class="or"><span>or</span></div>

  <button class="btn-guest" onclick="window.location.href='?page=home'">
    <div class="g-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
        <polyline points="9 22 9 12 15 12 15 22"/>
      </svg>
    </div>
    <div class="g-body">
      <div class="g-title">I'm a USC student, faculty, or staff</div>
      <div class="g-hint">Have a USC ID? Sign in with your ID number</div>
    </div>
    <div class="g-arrow">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M9 18l6-6-6-6"/>
      </svg>
    </div>
  </button>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
