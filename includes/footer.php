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
          <div style="margin-top: 1rem;">
            <a href="<?php echo htmlspecialchars($church_facebook); ?>" target="_blank" rel="noopener noreferrer" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.45rem 1rem; font-size: 0.85rem; font-weight: 700; border-radius: var(--radius-full); background: #1877F2; color: #ffffff; text-decoration: none; box-shadow: 0 4px 14px rgba(24, 119, 242, 0.35);">
              <svg class="icon" viewBox="0 0 24 24" fill="currentColor" style="width: 15px; height: 15px;"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
              Follow on Facebook
            </a>
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
          <p class="footer-contact-line">
            <span class="label">Facebook:</span>
            <a href="<?php echo htmlspecialchars($church_facebook); ?>" target="_blank" rel="noopener noreferrer">Alive Faith Ministries</a>
          </p>
          <div class="footer-badge">
            Non-denominational Ministry
          </div>
        </div>
      </div>

      <!-- Footer Bottom (Clean, Well-Balanced 3-Column Baseline) -->
      <div class="footer-bottom">
        <p class="footer-copyright">&copy; <?php echo date('Y'); ?> Live Faith Ministries (Alive Faith Ministries &bull; AFM). All rights reserved.</p>
        <div class="footer-legal-row">
          <a href="privacy.html" class="footer-legal-link">Privacy Policy</a>
          <span class="footer-legal-dot">&bull;</span>
          <a href="terms.html" class="footer-legal-link">Terms of Service</a>
        </div>
        <p class="motto-pill"><?php echo htmlspecialchars($church_motto); ?></p>
      </div>
    </div>
  </footer>

  <!-- Floating Contact Dock (WhatsApp & Direct Phone Call) -->
  <aside class="floating-contact-dock" aria-label="Quick Contact Actions" style="display:flex;">
    <!-- Call Pastoral Desk -->
    <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $church_phone); ?>" class="floating-action-btn btn-call" aria-label="Call Alive Faith Ministries Pastoral Desk (<?php echo htmlspecialchars($church_phone); ?>)" title="Call Us: <?php echo htmlspecialchars($church_phone); ?>" style="display:flex;">
      <span class="floating-btn-tooltip">Call Pastoral Desk</span>
      <svg class="floating-btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
      </svg>
    </a>

    <!-- WhatsApp Ministry Chat -->
    <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $church_phone); ?>?text=Hello%20Alive%20Faith%20Ministries,%20I%20would%20like%20to%20connect%20with%20you." target="_blank" rel="noopener noreferrer" class="floating-action-btn btn-whatsapp" aria-label="Chat with Alive Faith Ministries on WhatsApp" title="Chat on WhatsApp" style="display:flex;">
      <span class="floating-btn-pulse"></span>
      <span class="floating-btn-tooltip">Chat on WhatsApp</span>
      <svg class="floating-btn-icon" viewBox="0 0 24 24" fill="currentColor">
        <path d="M12.031 2C6.496 2 2 6.496 2 12.031c0 1.97.57 3.81 1.558 5.372L2.094 22l4.75-1.442A9.97 9.97 0 0012.03 22c5.535 0 10.031-4.496 10.031-10.031S17.566 2 12.031 2zm0 18.25a8.21 8.21 0 01-4.225-1.168l-.304-.18-3.13.951.956-3.045-.198-.316A8.19 8.19 0 013.78 12.03c0-4.55 3.7-8.25 8.25-8.25 4.55 0 8.25 3.7 8.25 8.25 0 4.55-3.7 8.25-8.25 8.25zm4.516-6.19c-.248-.124-1.464-.722-1.691-.805-.227-.083-.393-.124-.558.124-.165.248-.64 1.054-.785 1.219-.145.165-.29.186-.538.062-.248-.124-1.047-.386-1.995-1.231-.738-.658-1.237-1.472-1.382-1.72-.145-.248-.015-.382.109-.505.111-.111.248-.29.372-.435.124-.145.165-.248.248-.413.083-.165.041-.31-.021-.435-.062-.124-.558-1.344-.765-1.841-.2-.484-.403-.418-.558-.426-.145-.008-.31-.01-.475-.01-.165 0-.434.062-.661.31-.227.248-.868.848-.868 2.068s.889 2.399 1.013 2.564c.124.165 1.748 2.669 4.234 3.743.592.256 1.054.409 1.414.523.595.189 1.136.162 1.564.098.477-.072 1.464-.599 1.671-1.178.207-.579.207-1.075.145-1.178-.062-.103-.227-.165-.475-.29z"/>
      </svg>
    </a>
  </aside>

  <!-- Main JavaScript File (Versioned for Instant Mobile Cache Busting) -->
  <script src="assets/js/main.js?v=3.0"></script>
</body>
</html>
