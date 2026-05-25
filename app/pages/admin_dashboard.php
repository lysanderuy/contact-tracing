<?php
require_once __DIR__ . '/../includes/auth_guard.php';

$page_title = 'Dashboard — CpE Contact Tracing';
$css_files  = ['admin.css', 'admin_dashboard.css'];
$topbar_btn = 'logout';
$page_js    = ['js/admin_dashboard.js'];
$skip_main  = true;
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
      <div class="search-box">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"/>
          <path d="m21 21-4.35-4.35"/>
        </svg>
        <input type="text" id="search-input" name="search" placeholder="Search by name, ID, contact, location..."/>
      </div>
      <select name="filter" id="filter-select" class="filter-select">
        <option value="all">All Time</option>
        <option value="signed_in">Currently Signed In</option>
        <option value="today">Today</option>
        <option value="date_range">Date Range</option>
      </select>
      <span id="date-range-inputs" class="hidden">
        <input type="date" name="date_from" id="date-from" class="date-input"/>
        <input type="date" name="date_to" id="date-to" class="date-input"/>
      </span>
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
            <th>Sign Out</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="visitor-tbody">
          <tr><td colspan="7" class="loading-center">Loading...</td></tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="footer-note">CpE Contact Tracing System · Admin Dashboard</div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
