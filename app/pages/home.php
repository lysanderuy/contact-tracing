<?php
$page_title = 'Welcome — CpE Contact Tracing';
$css_files  = ['home.css'];
$page_js    = 'js/home.js';
include __DIR__ . '/../includes/header.php';
?>

<div class="welcome">
  <h1>Welcome to the <span>DCpE Office</span></h1>
  <p>Please sign in before entering and sign out when you leave.</p>
</div>

<div class="card">
  <div class="field">
    <label for="usc-input">USC ID Number</label>
    <div class="field-input">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <rect x="2" y="5" width="20" height="14" rx="2"/>
        <path d="M16 10a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
        <path d="M6 9h3M6 12h3M6 15h3"/>
      </svg>
      <input type="text" id="usc-input" placeholder="e.g., 20201234" autocomplete="off" />
    </div>
  </div>

  <button class="btn-main" onclick="handleUSC()">
    Continue
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M5 12h14M12 5l7 7-7 7"/>
    </svg>
  </button>

  <div class="or"><span>or</span></div>

  <button class="btn-guest" onclick="handleGuest()">
    <div class="g-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
        <circle cx="9" cy="7" r="4"/>
        <path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
      </svg>
    </div>
    <div class="g-body">
      <div class="g-title">I'm a guest or visitor</div>
      <div class="g-hint">No USC ID? Proceed with your contact number</div>
    </div>
    <div class="g-arrow">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M9 18l6-6-6-6"/>
      </svg>
    </div>
  </button>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
