<?php
require_once __DIR__ . '/../includes/auth_guard.php';

$page_title = 'Dashboard — CpE Contact Tracing';
$css_files  = ['admin.css', 'admin_dashboard.css'];
$topbar_btn = 'logout';
$page_js    = ['js/admin_dashboard.js'];
$skip_main  = true;
$skip_footer = true;
include __DIR__ . '/../includes/header.php';
?>

<main>
  <h1 class="page-title">Admin Dashboard</h1>

  <div class="section">
    <div class="section-title">
      Currently Inside
      <span class="badge" id="signed-in-count">0</span>
    </div>
    <div class="card">
      <div class="signed-in-grid" id="signed-in-grid">
        <div class="loading-text">Loading...</div>
      </div>
    </div>
  </div>

  <div class="section">
    <div class="section-title">Visitor Records</div>

    <form id="filter-form" class="filters">
      <input type="hidden" name="page" value="admin_dashboard">
      <input type="hidden" name="filter" id="filter-value" value="all">
      <input type="hidden" name="visitor_type" id="visitor-type-value" value="all">
      <div class="search-box">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"/>
          <path d="m21 21-4.35-4.35"/>
        </svg>
        <input type="text" id="search-input" name="search" placeholder="Search by name, ID, contact, location..."/>
      </div>

      <div class="dropdown-wrapper">
        <button type="button" class="dropdown-btn" id="filter-btn">
          <span id="filter-label">All Time</span>
          <svg class="dropdown-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="dropdown-menu" id="filter-menu">
          <div class="dropdown-item" data-value="all">All Time</div>
          <div class="dropdown-item" data-value="signed_in">Currently Signed In</div>
          <div class="dropdown-item" data-value="signed_out">Signed Out</div>
          <div class="dropdown-item" data-value="today">Today</div>
          <div class="dropdown-item" data-value="this_week">This Week</div>
          <div class="dropdown-item" data-value="this_month">This Month</div>
        </div>
      </div>

      <div class="dropdown-wrapper">
        <button type="button" class="dropdown-btn" id="visitor-type-btn">
          <span id="visitor-type-label">All Visitors</span>
          <svg class="dropdown-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="dropdown-menu" id="visitor-type-menu">
          <div class="dropdown-item" data-value="all">All Visitors</div>
          <div class="dropdown-item" data-value="usc">USC</div>
          <div class="dropdown-item" data-value="guest">Guest</div>
        </div>
      </div>

      <button type="submit" class="filter-btn">Search</button>
    </form>

    <div class="card table-wrapper">
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>ID/Contact</th>
            <th>Location</th>
            <th>Sign In</th>
            <th>Mark Signed Out</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="visitor-tbody">
          <tr><td colspan="7" class="loading-center">Loading...</td></tr>
        </tbody>
      </table>
    </div>
    <div id="pagination-container"></div>
  </div>

  <div class="footer-note">USC DCpE Contact Tracing System · Admin Dashboard</div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
