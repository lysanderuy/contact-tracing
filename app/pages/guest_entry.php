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
  <div class="section-label">Contact Information</div>

  <div class="field">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
    </svg>
    <input type="text" id="guest-contact" placeholder="09XX XXX XXXX" autocomplete="off" maxlength="11" />
  </div>

  <button class="btn-main" onclick="handleGuestSubmit()">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M5 12h14M12 5l7 7-7 7"/>
    </svg>
    Continue
  </button>

  <div class="or"><span>or</span></div>

  <button class="btn-guest" onclick="window.location.href='?page=home'">
    <div class="g-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M19 12H5M12 19l-7-7 7-7"/>
      </svg>
    </div>
    <div class="g-body">
      <div class="g-title">Back to Home</div>
      <div class="g-hint">Return to main entry</div>
    </div>
  </button>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
