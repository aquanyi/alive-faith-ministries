  <!-- Vibrant Accent Ribbon (Phaneroo Style) -->
  <div class="phaneroo-accent-strip"></div>

  <!-- Ministry Footer (Clean, High-End & Stroke-Free) -->
  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <!-- Col 1: Brand & Mandate -->
        <div class="footer-brand">
          <a href="#home" data-tab="tab-home" class="footer-logo-link">
            <img src="assets/images/logo.png" alt="<?php echo htmlspecialchars($church_name); ?>">
          </a>
          <p class="footer-tagline">
            <?php echo htmlspecialchars($church_motto); ?>
          </p>
          <p class="footer-desc">
            A priestly mandate to raise believers who know and trust God for the realization of their fullness in Christ Jesus.
          </p>
          <div class="footer-verse">
            "For we are his workmanship, created in Christ Jesus unto good works..." (Ephesians 2:10)
          </div>
        </div>

        <!-- Col 2: Single-Word Navigation -->
        <div class="footer-col">
          <h4>Navigation</h4>
          <ul class="footer-links">
            <li><a href="#home" data-tab="tab-home">Home</a></li>
            <li><a href="#about" data-tab="tab-about">About</a></li>
            <li><a href="#faith" data-tab="tab-faith">Faith</a></li>
            <li><a href="#giving" data-tab="tab-giving">Giving</a></li>
            <li><a href="#watch" data-tab="tab-watch">Watch</a></li>
            <li><a href="#contact" data-tab="tab-contact">Contact</a></li>
          </ul>
        </div>

        <!-- Col 3: Service Times -->
        <div class="footer-col">
          <h4>Gatherings</h4>
          <ul class="footer-service-times">
            <?php foreach ($service_times as $st): ?>
              <li>
                <div class="footer-service-day"><?php echo htmlspecialchars($st['day']); ?> Service</div>
                <div class="footer-service-hour"><?php echo htmlspecialchars($st['time']); ?> (E.A.T.)</div>
                <div class="footer-service-title"><?php echo htmlspecialchars($st['title']); ?></div>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Col 4: Reach Alive Faith Ministries -->
        <div class="footer-col">
          <h4>Connect</h4>
          <p class="footer-contact-line">
            <span class="label">Phone:</span>
            <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $church_phone); ?>"><?php echo htmlspecialchars($church_phone); ?></a>
          </p>
          <p class="footer-contact-line">
            <span class="label">Email:</span>
            <a href="mailto:<?php echo htmlspecialchars($church_email); ?>"><?php echo htmlspecialchars($church_email); ?></a>
          </p>
          <p class="footer-contact-line">
            <span class="label">Online:</span>
            <a href="https://<?php echo htmlspecialchars($church_website); ?>" target="_blank" rel="noopener noreferrer"><?php echo htmlspecialchars($church_website); ?></a>
          </p>
          <div class="footer-badge">
            Non-denominational Ministry
          </div>
        </div>
      </div>

      <!-- Footer Bottom -->
      <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($church_name); ?>. All rights reserved.</p>
        <p class="motto-pill"><?php echo htmlspecialchars($church_motto); ?></p>
      </div>
    </div>
  </footer>

  <!-- Main JavaScript File -->
  <script src="assets/js/main.js"></script>
</body>
</html>
