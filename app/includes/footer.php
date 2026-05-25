  </main>
  <?php if (empty($skip_footer)): ?>
  <footer>
    <span class="f-copy">CpE Contact Tracing · University of San Carlos</span>
    <a class="f-admin" href="?page=admin_login">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="11" width="18" height="11" rx="2"/>
        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
      </svg>
      Admin access
    </a>
  </footer>
  <?php endif; ?>
  <script src="js/utils.js"></script>
  <?php if (!empty($page_js)): ?>
    <?php foreach ((array)$page_js as $js): ?>
  <script src="<?= htmlspecialchars($js) ?>"></script>
    <?php endforeach; ?>
  <?php endif; ?>
</body>
</html>
