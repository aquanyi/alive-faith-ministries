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

      <!-- Footer Bottom -->
      <div class="footer-bottom">
        <div>
          <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($church_name); ?>. All rights reserved.</p>
          <div class="footer-legal-row">
            <a href="#privacy" class="footer-legal-link" id="trigger-privacy-modal">Privacy Policy</a>
            <span class="footer-legal-dot">&bull;</span>
            <a href="#terms" class="footer-legal-link" id="trigger-terms-modal">Terms of Service</a>
            <span class="footer-legal-dot">&bull;</span>
            <button type="button" class="footer-legal-btn" id="trigger-cookie-settings">Cookie Preferences</button>
          </div>
        </div>
        <p class="motto-pill"><?php echo htmlspecialchars($church_motto); ?></p>
      </div>
    </div>
  </footer>

  <!-- Floating Cookie Consent Banner -->
  <div id="cookie-consent-banner" class="cookie-banner" role="region" aria-label="Cookie Consent Banner">
    <div class="cookie-banner-inner">
      <div class="cookie-banner-header">
        <svg class="cookie-shield-icon" viewBox="0 0 24 24">
          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
        </svg>
        <h4 class="cookie-banner-title">Privacy and Cookie Notice</h4>
      </div>
      <p class="cookie-banner-text">
        Alive Faith Ministries uses essential cookies for secure sessions, cross-site defense, and form verification. With your agreement, we also store basic preferences to provide a smooth spiritual experience. Read our <a href="#privacy" id="banner-privacy-link">Privacy Policy</a> to learn more.
      </p>
      <div class="cookie-banner-actions">
        <button type="button" class="btn-cookie-accept" id="btn-accept-all-cookies">Accept All Cookies</button>
        <button type="button" class="btn-cookie-essential" id="btn-accept-essential-cookies">Essential Only</button>
        <button type="button" class="btn-cookie-customize" id="btn-open-cookie-prefs">Customize Settings</button>
      </div>
    </div>
  </div>

  <!-- Interactive Legal & Policy Modal Reader -->
  <div id="legal-modal-backdrop" class="legal-modal-backdrop" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="legal-modal-card">
      
      <!-- Modal Navigation Header -->
      <div class="legal-modal-header">
        <div class="legal-tab-switch" role="tablist">
          <button type="button" class="legal-tab-btn active" id="tab-btn-privacy" role="tab" aria-selected="true" data-target="view-privacy">Privacy Policy</button>
          <button type="button" class="legal-tab-btn" id="tab-btn-terms" role="tab" aria-selected="false" data-target="view-terms">Terms of Service</button>
          <button type="button" class="legal-tab-btn" id="tab-btn-cookies" role="tab" aria-selected="false" data-target="view-cookies">Cookie Preferences</button>
        </div>
        <button type="button" class="legal-modal-close" id="legal-modal-close-btn" aria-label="Close modal">
          <svg viewBox="0 0 24 24" fill="none"><path d="M18 6L6 18M6 6l12 12"></path></svg>
        </button>
      </div>

      <!-- Modal Scrollable Content Container -->
      <div class="legal-modal-body">
        
        <!-- Privacy Policy View Pane -->
        <div id="view-privacy" class="legal-view active" role="tabpanel">
          <h2>Privacy Policy</h2>
          <p class="legal-lead">Sanctity, Integrity, and Pastoral Confidentiality of Your Personal Information</p>
          <div class="legal-meta">
            <span>Effective Date: October 2026</span>
            <span>&bull;</span>
            <span>Alive Faith Ministries Legal Desk</span>
          </div>

          <div class="legal-section">
            <h3><span class="legal-section-num">1.</span> Introduction and Ministry Commitment</h3>
            <p>
              Alive Faith Ministries (referred to as "AFM", "the Ministry", "we", or "our") is a non-denominational Christian ministry with a priestly mandate to raise believers who know and trust God for the realization of their fullness in Christ Jesus (Ephesians 2:8-10).
            </p>
            <p>
              We hold the privacy and personal trust of our congregation, visitors, and online fellowship in the highest reverence. This Privacy Policy outlines transparently how we collect, handle, safeguard, and respect your personal information across our website (www.livefaithministries.org) and digital ministry platforms, in accordance with the Kenya Data Protection Act 2019 and recognized international privacy standards.
            </p>
          </div>

          <div class="legal-section">
            <h3><span class="legal-section-num">2.</span> Information We Collect</h3>
            <p>We only collect personal information that you voluntarily choose to share with us:</p>
            <ul>
              <li><strong>Contact and Visitor Planning:</strong> Your full name, email address, phone number, and intended visit date when planning a sanctuary visit or sending a message.</li>
              <li><strong>Prayer Requests and Salvation Decisions:</strong> Prayer points, health intercession petitions, family matters, and salvation testimonies submitted to our pastoral team.</li>
              <li><strong>Voluntary Giving Verification:</strong> M-Pesa transaction reference codes, donation purposes (such as Tithe, Sanctuary Building, Covenant Partnership, or Charity), and contribution amounts entered voluntarily. We never request, capture, or store sensitive banking PINs or credit card CVV codes.</li>
              <li><strong>Technical and Security Metadata:</strong> Internet Protocol (IP) addresses collected solely for firewall rate-limiting and anti-bot mitigation, and essential session identifiers ensuring secure communication.</li>
            </ul>
          </div>

          <div class="legal-highlight-box">
            <strong>Sacred Pastoral Confidentiality:</strong>
            Prayer requests, counseling notes, and spiritual questions are treated with the highest sacred pastoral confidence. They are shared solely with authorized ministry prayer intercessors and pastoral staff for spiritual agreement. We will never sell, lease, or distribute your prayer petitions to commercial entities or external third parties.
          </div>

          <div class="legal-section">
            <h3><span class="legal-section-num">3.</span> How We Use Your Information</h3>
            <p>Your details are used strictly for legitimate spiritual and administrative ministry purposes:</p>
            <ul>
              <li>Standing with you in prayer and providing pastoral follow-up.</li>
              <li>Welcoming first-time sanctuary guests and assisting with transport or service directions.</li>
              <li>Acknowledging voluntary contributions and providing covenant partnership updates.</li>
              <li>Maintaining digital platform security, mitigating automated spam, and protecting visitors against cyber threats.</li>
            </ul>
          </div>

          <div class="legal-section">
            <h3><span class="legal-section-num">4.</span> Cookies and Technical Data</h3>
            <p>
              Our website uses lightweight, essential cookies to preserve session continuity, enforce Cross-Site Request Forgery (CSRF) defenses, and record your privacy preferences. You can customize your cookie preferences at any time using the Cookie Preferences tab in this dialog.
            </p>
          </div>

          <div class="legal-section">
            <h3><span class="legal-section-num">5.</span> Your Data Protection Rights</h3>
            <p>Under the Kenya Data Protection Act 2019 and relevant data protection principles, you possess the following rights:</p>
            <ul>
              <li><strong>Right of Access:</strong> You may request confirmation of any personal information we hold concerning you.</li>
              <li><strong>Right to Rectification:</strong> You may request the correction of outdated or inaccurate contact details.</li>
              <li><strong>Right to Erasure:</strong> You may request the deletion of your contact records or submitted message history.</li>
              <li><strong>Right to Withdraw Consent:</strong> You may withdraw your consent for email updates or phone communications at any time.</li>
            </ul>
          </div>

          <div class="legal-section">
            <h3><span class="legal-section-num">6.</span> Security and Safeguards</h3>
            <p>
              We implement defense-in-depth security measures, including HTTPS encryption in transit, strict Content Security Policies, parameterized database protocols, and restricted staff access to preserve the integrity and confidentiality of your information.
            </p>
          </div>

          <div class="legal-contact-card">
            <h4>Pastoral Data Inquiries</h4>
            <p>If you have any questions or wish to exercise your data rights, please contact our secretariat:</p>
            <p><strong>Alive Faith Ministries Secretariat</strong></p>
            <p>Email: <a href="mailto:info@livefaithministries.org">info@livefaithministries.org</a></p>
            <p>Phone: <a href="tel:+254712785016">+254 712 785 016</a></p>
            <p>Website: <a href="https://www.livefaithministries.org">www.livefaithministries.org</a></p>
          </div>
        </div>

        <!-- Terms of Service View Pane -->
        <div id="view-terms" class="legal-view" role="tabpanel">
          <h2>Terms of Service</h2>
          <p class="legal-lead">Guiding Principles for Engaging with Alive Faith Ministries Digital Platforms</p>
          <div class="legal-meta">
            <span>Effective Date: October 2026</span>
            <span>&bull;</span>
            <span>Alive Faith Ministries Governance</span>
          </div>

          <div class="legal-section">
            <h3><span class="legal-section-num">1.</span> Acceptance of Terms</h3>
            <p>
              Welcome to Alive Faith Ministries online. By accessing, browsing, or utilizing www.livefaithministries.org, streaming sermon broadcasts, or submitting messages, you acknowledge that you have read, understood, and agreed to be guided by these Terms of Service. If you do not agree with any part of these terms, please discontinue use of this site.
            </p>
          </div>

          <div class="legal-section">
            <h3><span class="legal-section-num">2.</span> Spiritual Mandate and Community Decorum</h3>
            <p>
              Alive Faith Ministries exists under a divine commission to preach the Gospel of Grace, teach the Word of God in spiritual illumination, and raise mature believers. All interactions across our digital contact channels and prayer desks must reflect mutual honor, reverence, and Christian decency.
            </p>
          </div>

          <div class="legal-section">
            <h3><span class="legal-section-num">3.</span> Intellectual Property and Ministry Teachings</h3>
            <p>
              All audio recordings, video sermons, written devotionals, sermon notes, logos, and visual materials published by Alive Faith Ministries are the intellectual and spiritual property of the Ministry.
            </p>
            <ul>
              <li><strong>Permitted Personal Use:</strong> You are warmly encouraged to share sermon links, quote excerpts with proper attribution, and download study notes for your personal spiritual growth.</li>
              <li><strong>Prohibited Commercial Use:</strong> You may not sell, commercially distribute, re-monetize, alter, or misrepresent teachings of Alive Faith Ministries without prior written authorization from ministry leadership.</li>
            </ul>
          </div>

          <div class="legal-section">
            <h3><span class="legal-section-num">4.</span> Voluntary Tithes, Offerings, and Covenant Giving</h3>
            <p>
              Giving at Alive Faith Ministries is grounded in biblical stewardship, generous worship, and willing hearts (Acts 4:32-33, 2 Corinthians 9:7).
            </p>
            <ul>
              <li>All contributions submitted via M-Pesa (Official Giving Number: +254 728 838 977) or church accounts are strictly voluntary gifts unto the Lord for the advancement of the Gospel, sanctuary care, and outreach.</li>
              <li>Contributors are solely responsible for verifying the accuracy of transaction details before sending funds. If a clerical error occurs, our finance team will make reasonable efforts to investigate and assist upon receiving verifiable M-Pesa confirmation statements.</li>
            </ul>
          </div>

          <div class="legal-section">
            <h3><span class="legal-section-num">5.</span> Digital Sanctuary Protection and Prohibited Conduct</h3>
            <p>To preserve the security and availability of this platform for all believers worldwide, users agree not to:</p>
            <ul>
              <li>Attempt SQL injection, script injection (XSS), or unauthorized network scanning.</li>
              <li>Deploy automated bots, spiders, or scrapers to flood prayer desks or message forms.</li>
              <li>Submit defamatory, profane, fraudulent, or harassing messages.</li>
              <li>Circumvent session controls or tamper with security firewall headers.</li>
            </ul>
          </div>

          <div class="legal-section">
            <h3><span class="legal-section-num">6.</span> Pastoral Ministry Disclaimer</h3>
            <p>
              Spiritual counsel, prayers of agreement, and sermon messages offered by Alive Faith Ministries are expressions of Christian faith and biblical teaching. They are provided for spiritual edification and are not intended as substitutes for professional medical diagnosis, certified financial guidance, or licensed legal representation.
            </p>
          </div>

          <div class="legal-section">
            <h3><span class="legal-section-num">7.</span> Governing Law</h3>
            <p>
              These Terms of Service are governed by and construed in accordance with the laws of the Republic of Kenya.
            </p>
          </div>

          <div class="legal-contact-card">
            <h4>Secretariat Inquiries</h4>
            <p>For questions regarding ministry policies or permissions, contact our leadership team:</p>
            <p>Email: <a href="mailto:info@livefaithministries.org">info@livefaithministries.org</a></p>
            <p>Phone: <a href="tel:+254712785016">+254 712 785 016</a></p>
          </div>
        </div>

        <!-- Cookie Preferences View Pane -->
        <div id="view-cookies" class="legal-view" role="tabpanel">
          <h2>Cookie Preferences</h2>
          <p class="legal-lead">Manage How Cookies Are Used to Support Your Ministry Browsing Experience</p>
          <div class="legal-meta">
            <span>Preference Status: Active</span>
          </div>

          <p style="margin-bottom: 1.5rem;">
            We respect your privacy choices. Below you can inspect and configure the types of cookies and local storage tokens utilized on this website.
          </p>

          <div class="cookie-pref-card">
            <div class="cookie-pref-info">
              <h4>Strictly Necessary Cookies <span class="cookie-badge-required">Always Active</span></h4>
              <p>Essential for session integrity, Cross-Site Request Forgery (CSRF) protection, and firewall defense against automated spam bots. These cannot be disabled as the website cannot function securely without them.</p>
            </div>
            <label class="switch-label">
              <input type="checkbox" checked disabled>
              <span class="switch-slider"></span>
            </label>
          </div>

          <div class="cookie-pref-card">
            <div class="cookie-pref-info">
              <h4>Functional &amp; Experience Preferences</h4>
              <p>Enables the website to remember your preference choices, such as active tab persistence, audio volume settings, and dismissing previously viewed announcement banners.</p>
            </div>
            <label class="switch-label">
              <input type="checkbox" id="pref-functional" checked>
              <span class="switch-slider"></span>
            </label>
          </div>

          <div class="cookie-pref-card">
            <div class="cookie-pref-info">
              <h4>Ministry Reach Analytics</h4>
              <p>Collects completely anonymized, aggregated visit counts that help our pastoral team understand how believers across different time zones discover sermon streams and ministry materials.</p>
            </div>
            <label class="switch-label">
              <input type="checkbox" id="pref-analytics" checked>
              <span class="switch-slider"></span>
            </label>
          </div>

          <div style="margin-top: 1.8rem; display: flex; gap: 0.8rem; flex-wrap: wrap;">
            <button type="button" class="btn btn-primary" id="btn-save-cookie-prefs">Save My Preferences</button>
            <button type="button" class="btn btn-secondary" id="btn-reset-cookie-prefs">Reset All</button>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Main JavaScript File -->
  <script src="assets/js/main.js"></script>
</body>
</html>
