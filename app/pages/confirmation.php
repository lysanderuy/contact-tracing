<?php
$page_title = 'Confirmation — CpE Contact Tracing';
$css_files  = ['home.css'];
$page_js    = 'js/confirmation.js';
include __DIR__ . '/../includes/header.php';
?>

<div class="welcome" id="confirm-heading">
  <h1>Done</h1>
</div>

<div class="card confirmation-card">
  <div id="confirm-icon" class="confirm-icon">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="confirm-svg-icon">
      <path d="M5 12h14M12 5l7 7-7 7"/>
    </svg>
  </div>

  <div class="confirm-name" id="confirm-name">...</div>
  <div class="confirm-time" id="confirm-time"></div>

  <div class="confirm-hint">
    Redirecting to home in <span id="countdown">5</span> seconds...
  </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
