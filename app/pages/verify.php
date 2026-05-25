<?php
$page_title = 'Verify Information — CpE Contact Tracing';
$css_files  = ['home.css'];
$page_js    = 'js/verify.js';
include __DIR__ . '/../includes/header.php';
?>

<div class="welcome">
  <h1>Verify <span>Information</span></h1>
  <p>Please confirm your details before proceeding.</p>
</div>

<div id="verify-loading" class="card verify-loading">
  <div class="verify-loading-text">Loading...</div>
</div>

<div id="verify-content" class="card verify-content">
  <div class="verify-header">
    <div class="verify-name" id="v-name"></div>
    <div class="verify-id-type" id="v-id-type"></div>
  </div>

  <div class="verify-info-grid" id="v-info-grid"></div>

  <div class="verify-status">
    <div class="verify-status-text">
      Current Status: <strong id="v-status"></strong>
    </div>
  </div>

  <button class="btn-main" id="confirm-btn" onclick="handleConfirm()">
    Confirm
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
      <polyline points="22 4 12 14.01 9 11.01"/>
    </svg>
  </button>

  <button class="btn-guest" onclick="window.location.href='?page=home'">
    <div class="g-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M18 6L6 18M6 6l12 12"/>
      </svg>
    </div>
    <div class="g-body">
      <div class="g-title">Cancel</div>
      <div class="g-hint">Return to home</div>
    </div>
  </button>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
