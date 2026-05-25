<?php
$page_title = 'Verify Information — CpE Contact Tracing';
$css_files  = ['home.css'];
$page_js    = 'js/verify.js';
include __DIR__ . '/../includes/header.php';
?>

<div class="welcome">
  <h1>Verify <span>Information</span></h1>
  <p>Confirm your details before proceeding.</p>
</div>

<div id="verify-loading" class="card verify-loading">
  <div class="verify-loading-text">Loading...</div>
</div>

<div id="verify-content" class="card verify-content">
  <div class="verify-header">
    <div class="verify-avatar" id="v-avatar"></div>
    <div class="verify-name-section">
      <div class="verify-name" id="v-name"></div>
      <div class="verify-id-type" id="v-id-type"></div>
    </div>
  </div>

  <div class="verify-info-grid" id="v-info-grid"></div>

  <div class="verify-status" id="verify-status-box">
    <div class="verify-status-text">
      <span id="v-status-label">Current Status:</span> <strong id="v-status"></strong>
    </div>
  </div>

  <button class="btn-main" id="confirm-btn" onclick="handleConfirm()">
    <span id="confirm-btn-text">Confirm</span>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M5 12h14M12 5l7 7-7 7"/>
    </svg>
  </button>

  <a class="back-link" href="?page=home">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M19 12H5M12 19l-7-7 7-7"/>
    </svg>
    Back to Home
  </a>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
