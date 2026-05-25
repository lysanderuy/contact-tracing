<?php
require_once __DIR__ . '/../includes/auth_guard.php';

$visitor_id = (int)($_GET['id'] ?? 0);
if (!$visitor_id) {
    header('Location: ?page=admin_dashboard');
    exit;
}

$page_title = 'Visitor Detail — CpE Contact Tracing';
$css_files  = ['admin.css', 'visitor_detail.css'];
$topbar_btn = ['back', '?page=admin_dashboard', '← Back to Dashboard'];
$page_js    = ['js/visitor_detail.js'];
$skip_main  = true;
include __DIR__ . '/../includes/header.php';
?>

<main>
  <h1 class="page-title">Visitor Details</h1>

  <div id="detail-loading" class="detail-loading">Loading...</div>

  <div id="detail-content" class="hidden">
    <div class="card">
      <div class="profile-header">
        <div class="avatar" id="visitor-avatar"></div>
        <div class="profile-info">
          <h2 id="visitor-name"></h2>
          <div class="meta" id="visitor-id-type"></div>
          <span id="visitor-status-badge" class="status-badge"></span>
        </div>
      </div>

      <div class="info-grid" id="visitor-info-grid"></div>

      <div id="sign-out-container"></div>
    </div>

    <div class="card">
      <div class="card-title">Visit History</div>
      <table class="history-table">
        <thead>
          <tr>
            <th>Sign In</th>
            <th>Sign Out</th>
            <th>Duration</th>
            <th>Location</th>
          </tr>
        </thead>
        <tbody id="history-tbody"></tbody>
      </table>
    </div>
  </div>
</main>

<script>window._ct = { visitorId: <?= (int)$visitor_id ?> };</script>
<?php include __DIR__ . '/../includes/footer.php'; ?>
