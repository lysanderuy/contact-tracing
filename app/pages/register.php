<?php
$page_title = 'Visitor Registration — CpE Contact Tracing';
$css_files  = ['home.css'];
$page_js    = 'js/register.js';
include __DIR__ . '/../includes/header.php';

$is_guest = isset($_GET['contact']);
$id_number = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
$contact_number = isset($_GET['contact']) ? htmlspecialchars($_GET['contact']) : '';
?>

<div class="welcome">
  <h1>Visitor <span>Registration</span></h1>
  <p>Fill in your details. You will be automatically signed in.</p>
</div>

<div class="card register-card">
  <?php if (!$is_guest): ?>
  <div class="field">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <rect x="2" y="5" width="20" height="14" rx="2"/>
      <path d="M16 10a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
      <path d="M6 9h3M6 12h3M6 15h3"/>
    </svg>
    <input type="text" id="reg-id" value="<?= $id_number ?>" placeholder="USC ID Number" readonly />
  </div>
  <?php endif; ?>

  <div class="field">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
      <circle cx="12" cy="7" r="4"/>
    </svg>
    <input type="text" id="reg-first" placeholder="First Name" autocomplete="given-name" />
  </div>

  <div class="field">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
      <circle cx="12" cy="7" r="4"/>
    </svg>
    <input type="text" id="reg-middle" placeholder="Middle Name (optional)" autocomplete="additional-name" />
  </div>

  <div class="field">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
      <circle cx="12" cy="7" r="4"/>
    </svg>
    <input type="text" id="reg-last" placeholder="Last Name" autocomplete="family-name" />
  </div>

  <div class="field">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
      <polyline points="9 22 9 12 15 12 15 22"/>
    </svg>
    <input type="text" id="reg-brgy" placeholder="Barangay" />
  </div>

  <div class="field">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
      <polyline points="9 22 9 12 15 12 15 22"/>
    </svg>
    <input type="text" id="reg-city" placeholder="City/Town" />
  </div>

  <div class="field">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
      <polyline points="9 22 9 12 15 12 15 22"/>
    </svg>
    <input type="text" id="reg-prov" placeholder="Province" />
  </div>

  <div class="field">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
    </svg>
    <input type="text" id="reg-contact" value="<?= $contact_number ?>" placeholder="Contact Number" maxlength="11" <?= $is_guest ? 'readonly' : '' ?> />
  </div>

  <div class="field">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <rect x="4" y="4" width="16" height="16" rx="2"/>
      <path d="M12 4v16M4 12h16"/>
    </svg>
    <input type="email" id="reg-email" placeholder="Email (optional)" autocomplete="email" />
  </div>

  <button class="btn-main" onclick="handleRegister()">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
      <polyline points="22 4 12 14.01 9 11.01"/>
    </svg>
    Register & Sign In
  </button>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
