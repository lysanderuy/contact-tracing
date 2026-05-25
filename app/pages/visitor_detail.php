<?php
require_once __DIR__ . '/../includes/auth_guard.php';

$visitor_id = (int)($_GET['id'] ?? 0);
if (!$visitor_id) {
    header('Location: ?page=admin_dashboard');
    exit;
}

$page_title = 'Visitor Detail — CpE Contact Tracing';
$css_files  = ['admin.css', 'visitor_detail.css'];
$topbar_btn = 'logout';
$page_js    = ['js/visitor_detail.js'];
$skip_main  = true;
$skip_footer = true;
include __DIR__ . '/../includes/header.php';
?>

<main>
  <div class="page-header">
    <h1 class="page-title">Visitor Details</h1>
    <a href="?page=admin_dashboard" class="close-btn" title="Close">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="18" y1="6" x2="6" y2="18"/>
        <line x1="6" y1="6" x2="18" y2="18"/>
      </svg>
    </a>
  </div>

  <div id="detail-loading" class="detail-loading">Loading visitor details...</div>

  <div id="detail-content" class="hidden">
    <div class="card">
      <div class="profile-header">
        <div class="avatar" id="visitor-avatar"></div>
        <div class="profile-info">
          <div class="name-row">
            <h2 id="visitor-name"></h2>
            <span id="visitor-status-badge" class="status-badge"></span>
          </div>
          <div class="meta" id="visitor-id-type"></div>
        </div>
        <div id="sign-out-container" class="profile-actions"></div>
      </div>

      <div class="info-grid" id="visitor-info-grid"></div>
    </div>

    <div class="card">
      <div class="card-title">Visit History</div>
      <table class="history-table">
        <thead>
          <tr>
            <th>Date</th>
            <th>Sign In</th>
            <th>Sign Out</th>
            <th>Duration</th>
          </tr>
        </thead>
        <tbody id="history-tbody"></tbody>
      </table>
    </div>
  </div>
</main>

<script>window._ct = { visitorId: <?= (int)$visitor_id ?> };</script>
<?php include __DIR__ . '/../includes/footer.php'; ?>
