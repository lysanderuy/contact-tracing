<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title><?= htmlspecialchars($page_title ?? 'CpE Contact Tracing') ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
  <?php foreach ($css_files ?? ['home.css'] as $css): ?>
  <link rel="stylesheet" href="css/<?= htmlspecialchars($css) ?>"/>
  <?php endforeach; ?>
</head>
<body>
  <?php if (empty($skip_header)): ?>
  <header>
    <div class="brand">
      <img class="brand-badge" src="assets/dcpe_logo.png" alt="CpE Logo"/>
      <div>
        <div class="brand-name">Department of Computer Engineering</div>
        <div class="brand-sub">University of San Carlos · Cebu City</div>
      </div>
    </div>
    <div class="topbar-right">
      <span class="t-date" id="t-date"></span>
      <div class="t-sep"></div>
      <span class="t-time" id="t-time"></span>
      <?php if (isset($topbar_btn)): ?>
        <?php if ($topbar_btn === 'logout'): ?>
          <a class="logout-btn" href="?page=logout">Logout</a>
        <?php else: ?>
          <a class="back-link" href="<?= htmlspecialchars($topbar_btn[1] ?? '?page=admin_dashboard') ?>">
            <?= htmlspecialchars($topbar_btn[2] ?? '← Back') ?>
          </a>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </header>
  <?php endif; ?>
  <?php if (empty($skip_main)): ?><main><?php endif; ?>
