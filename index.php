<?php
require_once __DIR__ . '/includes/config.php';

$form_success = false;
$form_error = '';
$active_tab = 'tab-home'; // Default tab is Home

// Determine active tab from URL query param if present
if (isset($_GET['tab'])) {
    $tab_param = strtolower(trim($_GET['tab']));
    if (in_array($tab_param, ['home', 'about', 'faith', 'giving', 'watch', 'contact'])) {
        $active_tab = 'tab-' . $tab_param;
    }
}

// Handle Contact / Prayer / Visitor Form Submission
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $active_tab = 'tab-contact'; // Keep user on contact tab

    // 1. Verify CSRF Token
    $submitted_token = $_POST['csrf_token'] ?? '';
    if (!verify_csrf_token($submitted_token)) {
        $form_error = "Session security verification failed. Please refresh the page and try again.";
    }

    // 2. Anti-bot honeypot check
    elseif (!empty($_POST['afm_security_check'])) {
        // Discard bot submission
        $form_error = "Automated submission detected.";
    }

    // 3. Submission rate limiting
    elseif (!check_submission_rate_limit()) {
        $form_error = "Too many messages sent recently. Please wait a few minutes before submitting again.";
    }

    // 4. Submission speed velocity check (minimum 2 seconds)
    elseif (!verify_submission_speed()) {
        $form_error = "Submission was unusually fast. Please review your message before submitting.";
    }

    else {
        // Sanitize and normalize inputs
        $full_name = sanitize_text_input($_POST['full_name'] ?? '');
        $email = sanitize_text_input($_POST['email'] ?? '');
        $phone = sanitize_text_input($_POST['phone'] ?? '');
        $inquiry_type = sanitize_text_input($_POST['inquiry_type'] ?? 'General Message');
        $message = sanitize_text_input($_POST['message'] ?? '');

        // 5. Inspect for high-risk injection payloads in headers and identity fields
        if (detect_malicious_payload($full_name) || detect_malicious_payload($email) || detect_malicious_payload($phone)) {
            $form_error = "Potentially harmful input detected. Please enter standard text.";
        } elseif (empty($full_name) || empty($email) || empty($message)) {
            $form_error = "Please fill in all required fields (Name, Email, and Message).";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $form_error = "Please enter a valid email address.";
        } elseif (mb_strlen($message) > 5000) {
            $form_error = "Message exceeds the maximum length of 5000 characters.";
        } else {
            $form_success = true;
            record_submission_event();
            // Clear inputs on success so form fields don't retain submitted values
            $_POST['full_name'] = '';
            $_POST['email'] = '';
            $_POST['phone'] = '';
            $_POST['message'] = '';
        }
    }
}

$page_title = $church_name . " | " . $church_motto;
require_once __DIR__ . '/includes/header.php';
?>

<!-- Tab 1: Home -->
<div id="tab-home" class="tab-pane <?php echo ($active_tab === 'tab-home') ? 'active' : ''; ?>">
  
  <!-- Hero Section with Preaching/Worship Atmosphere & Floating Service Times -->
  <section class="hero">
    
    <!-- Hero Photographic Background Carousel (Sharp, Real, Active Ken Burns Drift) -->
    <div class="hero-bg-slider" aria-hidden="true" id="hero-bg-slider">
      <div class="hero-slide active" style="background-image: url('assets/images/worship-hero.jpg');"></div>
      <div class="hero-slide" style="background-image: url('assets/images/worship-stage.jpg');"></div>
      <div class="hero-slide" style="background-image: url('assets/images/community-bg.jpg');"></div>
      <div class="hero-slide" style="background-image: url('assets/images/bible-bg.jpg');"></div>
      <div class="hero-slide" style="background-image: url('assets/images/giving-bg.jpg');"></div>
      <div class="hero-vignette-overlay"></div>
    </div>

    <div class="container hero-inner">
      
      <div class="phaneroo-hero-grid">
        <!-- Left: Open Invitation & Call to Action -->
        <div>
          <div class="hero-badge" id="hero-badge-wrap">
            <span class="live-pulse-dot" id="hero-badge-dot" style="margin-right: 0.35rem; display: none;"></span>
            <span id="hero-badge-text"><?php echo htmlspecialchars($church_motto); ?></span>
          </div>

          <h1 class="phaneroo-hero-title">
            An open invitation to <br>
            <span class="gold-gradient-text">the fullness in Christ.</span>
          </h1>

          <p class="lead">
            Welcome to <?php echo htmlspecialchars($church_name); ?>. A non-denominational Ministry with a priestly mandate to raise believers who know and trust God for the realization of their fullness in Christ Jesus. Experience Faith, Grace and Intimacy with God.
          </p>

          <div class="worship-wave-bar">
            <div class="wave-animation">
              <div class="wave-bar"></div>
              <div class="wave-bar"></div>
              <div class="wave-bar"></div>
              <div class="wave-bar"></div>
              <div class="wave-bar"></div>
            </div>
            <span class="worship-wave-text">Atmosphere of Living Faith &bull; Friday 6:00 PM &bull; Sunday 3:30 PM (E.A.T.)</span>
          </div>

          <div class="hero-buttons">
            <a href="#watch" class="btn btn-primary" id="hero-watch-btn" data-tab-target="tab-watch">
              <span class="live-pulse-dot" id="hero-live-dot" style="background-color: #ffffff; display: none;"></span>
              <span id="hero-watch-label">Watch Services</span>
            </a>
            <a href="#contact" class="btn btn-outline-light" data-tab-target="tab-contact">Plan a Visit</a>
            <a href="#about" class="btn btn-secondary" data-tab-target="tab-about">About AFM</a>
          </div>
        </div>

        <!-- Right: Dedicated Floating Service Times Box (Phaneroo Style) -->
        <div>
          <div class="hero-service-times-box">
            <div class="service-box-header">SERVICE TIMES</div>

            <div class="service-box-day">
              <h4>FRIDAYS</h4>
              <span class="service-box-venue">ALIVE FAITH GROUNDS</span>
              <span class="service-box-title">HOUR OF PRAYER &amp; ILLUMINATION</span>
              <div class="service-box-hour">6:00 PM <span class="service-box-tz">E.A.T.</span></div>
            </div>

            <div class="service-box-divider"></div>

            <div class="service-box-day">
              <h4>SUNDAYS</h4>
              <span class="service-box-venue">ALIVE FAITH GROUNDS</span>
              <span class="service-box-title">SUNDAY CELEBRATION SERVICE</span>
              <div class="service-box-hour">3:30 PM <span class="service-box-tz">E.A.T.</span></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Real-Time Live Gathering Countdown Ticker & Live Broadcast Console -->
      <div class="countdown-banner" id="countdown-banner">
        <div class="countdown-title-wrap">
          <span class="live-pulse-dot" id="cd-pulse-dot" style="display: none;"></span>
          <div>
            <div class="countdown-title" id="cd-status-text">Next Gathering: Sunday Celebration (3:30 PM E.A.T.)</div>
            <div class="countdown-sub" id="cd-sub-text">Real-Time Gathering Clock</div>
          </div>
        </div>

        <!-- Normal Counting Down Grid (Visible when Waiting for Service) -->
        <div class="countdown-grid" id="countdown-grid">
          <div class="countdown-unit">
            <div class="countdown-val" id="cd-days">00</div>
            <div class="countdown-lbl">Days</div>
          </div>
          <span class="countdown-colon">:</span>
          <div class="countdown-unit">
            <div class="countdown-val" id="cd-hours">00</div>
            <div class="countdown-lbl">Hours</div>
          </div>
          <span class="countdown-colon">:</span>
          <div class="countdown-unit">
            <div class="countdown-val" id="cd-mins">00</div>
            <div class="countdown-lbl">Mins</div>
          </div>
          <span class="countdown-colon">:</span>
          <div class="countdown-unit">
            <div class="countdown-val" id="cd-secs">00</div>
            <div class="countdown-lbl">Secs</div>
          </div>
        </div>

        <!-- Active Live Stream Action Console (Revealed Dynamically Once Service Time Arrives) -->
        <div class="countdown-live-cta" id="countdown-live-cta" style="display: none;">
          <a href="#watch" class="btn btn-live-cta" data-tab-target="tab-watch">
            <span class="live-pulse-dot" style="background: #ffffff;"></span>
            <span>View Service Live</span>
            <svg class="icon icon-sm" viewBox="0 0 24 24"><path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
          </a>
          <a href="<?php echo htmlspecialchars($church_facebook); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-facebook-live-pill" aria-label="Watch on Facebook Live">
            <svg class="icon icon-sm" viewBox="0 0 24 24" fill="#1877F2"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            <span>Facebook Stream</span>
          </a>
        </div>
      </div>

      <!-- Quick Highlights Bar -->
      <div class="hero-meta-bar">
        <div class="hero-meta-card">
          <div class="hero-meta-icon">
            <svg class="icon" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
          </div>
          <div class="hero-meta-text">
            <h5>Weekly Gatherings</h5>
            <p>Friday 6:00 PM &bull; Sunday 3:30 PM (E.A.T.)</p>
          </div>
        </div>

        <div class="hero-meta-card">
          <div class="hero-meta-icon">
            <svg class="icon" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
          </div>
          <div class="hero-meta-text">
            <h5>Direct Inquiries</h5>
            <p><?php echo htmlspecialchars($church_phone); ?></p>
          </div>
        </div>

        <div class="hero-meta-card">
          <div class="hero-meta-icon">
            <svg class="icon" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
          </div>
          <div class="hero-meta-text">
            <h5>Ministry Email</h5>
            <p><?php echo htmlspecialchars($church_email); ?></p>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- "Who we are" Editorial Section (Phaneroo Style) -->
  <section class="phaneroo-who-we-are">
    <div class="container">
      <div class="who-we-are-grid">
        <h2 class="who-we-are-heading">Who we are</h2>
        <div>
          <p class="who-we-are-text">
            <strong>Alive Faith Ministries (AFM)</strong> is a dynamic, non-denominational Ministry with a priestly mandate to raise believers who know and trust God for the realization of their fullness in Christ Jesus. Experience Faith, Grace and Intimacy with God.
          </p>
          <div style="margin-top: 1.4rem;">
            <a href="#about" class="btn btn-secondary" data-tab-target="tab-about">
              Our Vision, Mission &amp; Values &rarr;
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Devotional / Word Showcase Section (Phaneroo Devotion Style) -->
  <section class="phaneroo-devotion-wrap">
    <div class="container">
      <div class="devotion-showcase-grid">
        <!-- Col 1: Intro -->
        <div class="devotion-intro-col">
          <span class="section-tag" style="color: var(--amber-light);">Spiritual Food</span>
          <h2 class="devotion-intro-title">The AFM Word of Faith</h2>
          <p class="devotion-intro-text">
            The Word of God illuminates our life and reveals Christ in us. We labor to inspire unshakeable faith among believers through revelatory teaching of the Scriptures.
          </p>
          <a href="#faith" class="btn btn-soft" data-tab-target="tab-faith" style="width: fit-content;">
            Statement of Faith (10 Articles) &rarr;
          </a>
        </div>

        <!-- Col 2: Devotion Card 1 -->
        <div class="devotion-card-pill">
          <div>
            <div class="devotion-card-tag">Ephesians 2:10 &bull; Our Firm Belief</div>
            <p class="devotion-card-verse">
              "For we are his workmanship, created in Christ Jesus unto good works, which God hath before ordained that we should walk in them."
            </p>
          </div>
          <div>
            <span class="devotion-badge-bottom">Workmanship in Christ Jesus</span>
          </div>
        </div>

        <!-- Col 3: Devotion Card 2 -->
        <div class="devotion-card-pill">
          <div>
            <div class="devotion-card-tag">Psalm 119:105 &bull; Illumination</div>
            <p class="devotion-card-verse">
              "Thy word is a lamp unto my feet, and a light unto my path. The word of God illuminates our life and reveals Christ in us."
            </p>
          </div>
          <div>
            <span class="devotion-badge-bottom">Illumination &amp; Guidance</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Crusade, Community & Giving Banner (Phaneroo App & Gallery Style) -->
  <section class="phaneroo-community-banner">
    <div class="container">
      <div class="community-grid">
        <!-- Left: Gathering Gallery Photo Card -->
        <div class="community-photo-card">
          <img src="assets/images/community-bg.jpg" alt="Alive Faith Ministries Sanctuary Community">
          <span class="community-photo-badge">AFM Community Gatherings</span>
        </div>

        <!-- Center: Partnership & M-Pesa -->
        <div>
          <span class="section-tag">Kingdom Partnership</span>
          <h3 style="font-size: clamp(1.6rem, 2.5vw, 2.2rem); margin-bottom: 0.8rem; color: var(--green-darkest);">
            Partner with Alive Faith Ministries
          </h3>
          <p style="color: var(--text-muted); line-height: 1.7; margin-bottom: 1.5rem; font-size: 0.96rem;">
            A prosperous and generous giving for charity, for sacrifice and for worship. Enabling every believer to grow from birth to servanthood, capable and mighty to showcase the excellence of God.
          </p>
          <div style="display: flex; gap: 0.8rem; flex-wrap: wrap;">
            <a href="#giving" class="btn btn-primary" data-tab-target="tab-giving">
              M-Pesa Giving &amp; Partnership &rarr;
            </a>
            <a href="#contact" class="btn btn-secondary" data-tab-target="tab-contact">
              Contact Desk
            </a>
          </div>
        </div>

        <!-- Right: Mobile App / Giving Mockup Card -->
        <div class="phone-mockup-frame">
          <div class="phone-mockup-screen">
            <div style="font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--amber-light); font-weight: 800; margin-bottom: 0.4rem;">
              Mobile Giving
            </div>
            <h4 style="font-size: 1.05rem; color: #ffffff; margin-bottom: 0.8rem;">M-Pesa Support</h4>
            <div style="background: rgba(255,255,255,0.12); padding: 0.6rem; border-radius: 8px; font-weight: 800; font-size: 1.1rem; color: #ffffff; margin-bottom: 0.6rem;">
              +254 728 838 977
            </div>
            <p style="font-size: 0.76rem; color: rgba(255,255,255,0.8); margin: 0;">
              Ref: Tithe / Offering / Partner
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Global Broadcast Banner (Phaneroo Around the World Style) -->
  <section class="phaneroo-broadcast-banner">
    <div class="container">
      <h3 class="broadcast-heading">WATCH ALIVE FAITH MINISTRIES AROUND THE WORLD</h3>
      <div class="broadcast-networks-grid">
        <a href="#watch" class="broadcast-chip" data-tab-target="tab-watch">
          <span class="live-pulse-dot"></span>
          YouTube Live Stream
        </a>
        <a href="<?php echo htmlspecialchars($church_facebook); ?>" target="_blank" rel="noopener noreferrer" class="broadcast-chip" aria-label="Watch Facebook Live Broadcast">
          <svg class="icon icon-sm" viewBox="0 0 24 24" fill="#1877F2" style="width: 15px; height: 15px; margin-right: 4px;"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
          Facebook Live Broadcast
        </a>
        <a href="#watch" class="broadcast-chip" data-tab-target="tab-watch">
          Website Live Stream Portal
        </a>
        <a href="#watch" class="broadcast-chip" data-tab-target="tab-watch">
          Audio Message Archive
        </a>
      </div>
      <p style="margin-top: 1.4rem; font-size: 0.88rem; color: rgba(255, 255, 255, 0.75);">
        Streaming Every Friday at 6:00 PM and Sunday at 3:30 PM (East Africa Time)
      </p>
    </div>
  </section>

  <!-- Television / Broadcast Monitor Section (Phaneroo Manifest TV Style) -->
  <section class="phaneroo-tv-section">
    <div class="container">
      
      <!-- Realistic TV Mockup Frame -->
      <div class="tv-mockup-frame">
        <div class="tv-mockup-bezel">
          <div class="tv-mockup-screen">
            <img src="assets/images/worship-stage.jpg" alt="Alive Faith Ministries Service Stage Broadcast">
            <a href="#watch" class="tv-play-overlay" data-tab-target="tab-watch" aria-label="Watch Live Service Stream">
              <svg class="icon" viewBox="0 0 24 24"><path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path></svg>
            </a>
          </div>
        </div>
        <div class="tv-stand"></div>
        <div class="tv-base"></div>
      </div>

      <!-- TV Stage Details -->
      <h2 style="font-size: clamp(2rem, 4vw, 3rem); color: var(--green-darkest); margin-bottom: 0.5rem;">
        Watch Alive Faith Broadcast
      </h2>
      <p style="color: var(--amber-primary); font-weight: 700; font-size: 1.15rem; margin-bottom: 1.5rem;">
        Spreading the Revelation of Jesus Christ to the Nations
      </p>
      <div style="display: flex; gap: 0.8rem; justify-content: center; flex-wrap: wrap;">
        <a href="#watch" class="btn btn-primary" data-tab-target="tab-watch">
          <span class="live-pulse-dot" style="background-color: #ffffff;"></span>
          Watch Live Stream Now
        </a>
        <a href="#contact" class="btn btn-secondary" data-tab-target="tab-contact">
          Get Broadcast Alerts
        </a>
      </div>
    </div>
  </section>

  <!-- Three Iconic Bottom Action Photo Cards (Exact Phaneroo Style) -->
  <section class="section section-white">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">Engage With Us</span>
        <h2>Connect with Alive Faith Ministries</h2>
        <p class="lead">Step into fellowship, experience spiritual transformation, and walk in covenant partnership.</p>
      </div>

      <div class="phaneroo-action-cards-grid">
        <!-- Card 1: Prayer -->
        <a href="#contact" class="action-photo-card" data-tab-target="tab-contact">
          <img src="assets/images/worship-hero.jpg" alt="Congregation Worship and Prayer">
          <div class="action-card-content">
            <h3>Let's stand with you in prayer</h3>
            <span class="action-card-link">Submit your prayer request &rarr;</span>
          </div>
        </a>

        <!-- Card 2: Salvation & Faith -->
        <a href="#faith" class="action-photo-card" data-tab-target="tab-faith">
          <img src="assets/images/bible-bg.jpg" alt="Holy Scriptures and Salvation">
          <div class="action-card-content">
            <h3>Have you given your life to Christ?</h3>
            <span class="action-card-link">Learn all about your new life &rarr;</span>
          </div>
        </a>

        <!-- Card 3: Testimony & Giving -->
        <a href="#giving" class="action-photo-card" data-tab-target="tab-giving">
          <img src="assets/images/giving-bg.jpg" alt="Sanctuary Altar and Covenant Giving">
          <div class="action-card-content">
            <h3>Do you have a testimony or wish to partner?</h3>
            <span class="action-card-link">Partner with us &amp; share your story &rarr;</span>
          </div>
        </a>
      </div>
    </div>
  </section>

  <!-- Service Gatherings Section -->
  <section class="section section-alt">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">Gatherings</span>
        <h2>Weekly Times of Fellowship</h2>
        <p class="lead">Join us in person to experience heartfelt worship, fervent prayer, and revelation of the Word of God.</p>
      </div>

      <div class="home-service-cards">
        <!-- Friday Service -->
        <div class="home-service-card">
          <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.2rem;">
              <span class="btn-soft" style="padding: 0.35rem 0.95rem; border-radius: var(--radius-full); font-size: 0.82rem; font-weight: 800;">Every Friday</span>
              <span style="font-weight: 800; color: var(--green-primary); font-size: 1.15rem;">6:00 PM (E.A.T.)</span>
            </div>
            <h3 style="font-size: 1.6rem; margin-bottom: 0.8rem;">Friday Service</h3>
            <p style="color: var(--text-muted); line-height: 1.7; margin-bottom: 2rem;">
              A dedicated evening given to consistent, fervent, and nourished prayer, deeper illumination of the Scriptures, and ministering to the Lord.
            </p>
          </div>
          <div style="display: flex; gap: 0.8rem; flex-wrap: wrap;">
            <a href="#contact" class="btn btn-secondary" data-tab-target="tab-contact">Plan a Visit</a>
            <a href="#watch" class="btn btn-soft" data-tab-target="tab-watch">Watch Live</a>
          </div>
        </div>

        <!-- Sunday Service -->
        <div class="home-service-card">
          <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.2rem;">
              <span class="btn-soft" style="padding: 0.35rem 0.95rem; border-radius: var(--radius-full); font-size: 0.82rem; font-weight: 800; background: var(--green-tint); color: var(--green-primary);">Every Sunday</span>
              <span style="font-weight: 800; color: var(--amber-primary); font-size: 1.15rem;">3:30 PM (E.A.T.)</span>
            </div>
            <h3 style="font-size: 1.6rem; margin-bottom: 0.8rem;">Sunday Celebration Service</h3>
            <p style="color: var(--text-muted); line-height: 1.7; margin-bottom: 2rem;">
              Our weekly corporate celebration where believers gather to worship in spirit and truth, receive spiritual teaching, and experience the fullness of Christ Jesus.
            </p>
          </div>
          <div style="display: flex; gap: 0.8rem; flex-wrap: wrap;">
            <a href="#contact" class="btn btn-primary" data-tab-target="tab-contact">Join Us Sunday</a>
            <a href="#watch" class="btn btn-soft" data-tab-target="tab-watch">Stream Online</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Gathering Experience & Order of Service Rhythm -->
  <section class="section section-white">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">Gathering Experience</span>
        <h2>The Rhythm of Our Services</h2>
        <p class="lead">What you will encounter when you gather with Alive Faith Ministries:</p>
      </div>

      <div class="quick-access-grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
        <div class="pillar-card">
          <div class="pillar-icon">
            <svg class="icon" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
          </div>
          <span class="btn-soft" style="padding: 0.2rem 0.7rem; font-size: 0.78rem; font-weight: 800; border-radius: var(--radius-full); margin-bottom: 0.8rem; width: fit-content;">01 &bull; Prayer</span>
          <h3 style="font-size: 1.3rem; margin-bottom: 0.5rem;">Fervent Intercession</h3>
          <p style="font-size: 0.92rem; color: var(--text-muted); line-height: 1.65;">
            We yield our hearts in sustained, Spirit-led intercession that builds spiritual endurance, breaks yokes, and prepares the soil of our hearts (Luke 18:1, Acts 6:4).
          </p>
        </div>

        <div class="pillar-card">
          <div class="pillar-icon amber">
            <svg class="icon" viewBox="0 0 24 24"><path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
          </div>
          <span class="btn-soft" style="padding: 0.2rem 0.7rem; font-size: 0.78rem; font-weight: 800; border-radius: var(--radius-full); margin-bottom: 0.8rem; width: fit-content;">02 &bull; Worship</span>
          <h3 style="font-size: 1.3rem; margin-bottom: 0.5rem;">Atmospheric Worship</h3>
          <p style="font-size: 0.92rem; color: var(--text-muted); line-height: 1.65;">
            Sincere, unhurried, and intimate praise that exalts Christ and welcomes the tangible presence and glory of the Holy Spirit (John 4:23-24).
          </p>
        </div>

        <div class="pillar-card">
          <div class="pillar-icon">
            <svg class="icon" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
          </div>
          <span class="btn-soft" style="padding: 0.2rem 0.7rem; font-size: 0.78rem; font-weight: 800; border-radius: var(--radius-full); margin-bottom: 0.8rem; width: fit-content;">03 &bull; The Word</span>
          <h3 style="font-size: 1.3rem; margin-bottom: 0.5rem;">The Living Word</h3>
          <p style="font-size: 0.92rem; color: var(--text-muted); line-height: 1.65;">
            Spiritual teaching of the Scriptures that illuminates truth, unveils Christ in us, and awakens unshakeable faith to fulfill your God-given purpose (Ephesians 2:10).
          </p>
        </div>

        <div class="pillar-card">
          <div class="pillar-icon amber">
            <svg class="icon" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
          </div>
          <span class="btn-soft" style="padding: 0.2rem 0.7rem; font-size: 0.78rem; font-weight: 800; border-radius: var(--radius-full); margin-bottom: 0.8rem; width: fit-content;">04 &bull; Ministry</span>
          <h3 style="font-size: 1.3rem; margin-bottom: 0.5rem;">Divine Enablement</h3>
          <p style="font-size: 0.92rem; color: var(--text-muted); line-height: 1.65;">
            Salvation of souls, healing for the body, prophetic impartation, and empowerment to walk in the fullness and excellence of God in every area of life.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Interactive Scripture Spotlight & Verse Switcher -->
  <section class="section section-alt">
    <div class="container">
      <div class="devotional-spotlight">
        <div>
          <span class="section-tag" style="margin-bottom: 0.4rem;">Word of Faith Illumination</span>
          <div style="font-size: 0.85rem; font-weight: 800; color: var(--amber-primary); margin-bottom: 0.5rem;" id="spotlight-verse-theme">
            Divine Workmanship & Calling
          </div>
          <h2 style="font-size: clamp(1.6rem, 2.8vw, 2.2rem); margin-bottom: 1rem; font-style: italic; font-weight: 500;" id="spotlight-verse-text">
            "For we are his workmanship, created in Christ Jesus unto good works, which God hath before ordained that we should walk in them."
          </h2>
          <div style="font-size: 1.15rem; font-weight: 800; color: var(--green-darkest); margin-bottom: 1.5rem;" id="spotlight-verse-ref">
            Ephesians 2:10
          </div>
          
          <div class="scripture-actions">
            <button class="scripture-copy-btn" id="copy-scripture-btn" type="button">
              <svg class="icon" viewBox="0 0 24 24"><path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
              Copy Verse
            </button>
            <a id="share-scripture-whatsapp" href="https://wa.me/?text=%22For%20we%20are%20his%20workmanship,%20created%20in%20Christ%20Jesus%20unto%20good%20works%22%20-%20Ephesians%202:10%20https://www.livefaithministries.org" target="_blank" rel="noopener noreferrer" class="btn btn-secondary" style="display: inline-flex; align-items: center; gap: 0.45rem;">
              <svg class="icon" viewBox="0 0 24 24" fill="currentColor" style="width: 15px; height: 15px;"><path d="M12.031 2C6.496 2 2 6.496 2 12.031c0 1.97.57 3.81 1.558 5.372L2.094 22l4.75-1.442A9.97 9.97 0 0012.03 22c5.535 0 10.031-4.496 10.031-10.031S17.566 2 12.031 2z"/></svg>
              Share Verse
            </a>
            <button class="scripture-next-btn" id="next-scripture-btn" type="button">
              <svg class="icon" viewBox="0 0 24 24"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
              Next Scripture
            </button>
            <button type="button" class="btn-meditate-focus" id="toggle-meditate-mode">
              <svg class="icon" viewBox="0 0 24 24"><path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
              <span>Meditate</span>
            </button>
          </div>
        </div>

        <div style="background-color: #ffffff; padding: 2.2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm);">
          <div class="pillar-icon amber" style="margin-bottom: 0.8rem;">
            <svg class="icon" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
          </div>
          <h4 style="font-size: 1.25rem; margin-bottom: 0.4rem;">Psalm 119:105</h4>
          <p style="font-style: italic; font-size: 0.95rem; color: var(--text-muted); margin-bottom: 1.2rem; line-height: 1.6;">
            "Thy word is a lamp unto my feet, and a light unto my path."
          </p>
          <p style="font-size: 0.85rem; color: var(--text-subtle); margin: 0;">
            1 Timothy 4:13 &bull; Give attendance to reading, to exhortation, to doctrine.
          </p>
        </div>
      </div>
    </div>
  </section>

</div>

<!-- Tab 2: About -->
<div id="tab-about" class="tab-pane <?php echo ($active_tab === 'tab-about') ? 'active' : ''; ?>">
  
  <section class="page-banner page-banner-about">
    <div class="banner-bg-drift" style="background-image: url('assets/images/community-bg.jpg');"></div>
    <div class="banner-vignette"></div>
    <div class="container banner-inner">
      <span class="section-tag" style="color: var(--amber-light);">Priestly Mandate</span>
      <h1>About Alive Faith Ministries</h1>
      <p class="lead">
        A non-denominational Ministry with a heavenly mandate to raise believers who know, trust, and manifest the fullness of God in Christ Jesus.
      </p>
    </div>
  </section>

  <!-- Priestly Mandate Story & Vision Statement -->
  <section class="section section-white">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">Our Divine Calling</span>
        <h2>Raised for Fullness in Christ</h2>
        <p class="lead">
          Experiencing uncompromised faith, transformative grace, and intimate fellowship with the Father.
        </p>
      </div>

      <div class="mandate-story-grid">
        <div>
          <p class="story-lead-text">
            <span class="story-dropcap">A</span>live Faith Ministries was birthed out of a relentless heavenly burden to see sons and daughters of God awakened to their true priestly stature. In a world full of religious conformity and spiritual weariness, our calling is to unveil the unsearchable riches of Christ Jesus, equipping every believer to walk in experiential knowledge, divine authority, and unshakable trust in God.
          </p>
          <p style="color: var(--text-muted); font-size: 1.02rem; line-height: 1.8; margin-bottom: 1.6rem;">
            We believe that salvation is not merely a ticket to heaven, but an immediate introduction into the supernatural life of God on earth. Through revelatory preaching of the Word, fervent intercession, and sincere worship, we cultivate an altar where believers transition from seeking God for things to seeking God for who He is.
          </p>
          <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="#faith" class="btn btn-secondary" data-tab-target="tab-faith">Statement of Faith</a>
            <a href="#contact" class="btn btn-primary" data-tab-target="tab-contact">Plan Your Visit</a>
          </div>
        </div>

        <div>
          <div class="story-quote-card">
            <svg class="icon icon-lg" viewBox="0 0 24 24" style="stroke: var(--amber-light); margin-bottom: 1rem;"><path d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
            <div class="story-quote-text">
              "For we are His workmanship, created in Christ Jesus unto good works, which God hath before ordained that we should walk in them."
            </div>
            <div class="story-quote-cite">
              Ephesians 2:10 &bull; Our Foundation Scripture
            </div>
          </div>
        </div>
      </div>

      <!-- Twin Pillars: Mission & Vision -->
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2.2rem; margin-top: 2rem;">
        <div class="pillar-card spotlight-card">
          <div class="pillar-icon">
            <svg class="icon icon-lg" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
          </div>
          <span class="section-tag">Our Mission</span>
          <h3 style="margin-bottom: 0.8rem; font-size: 1.45rem;">Laboring to Inspire Faith</h3>
          <p style="line-height: 1.8; font-size: 0.98rem; color: var(--text-muted); margin: 0;">
            <?php echo htmlspecialchars($ministry_mission); ?>
          </p>
        </div>

        <div class="pillar-card spotlight-card">
          <div class="pillar-icon amber">
            <svg class="icon icon-lg" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
          </div>
          <span class="section-tag">Our Vision</span>
          <h3 style="margin-bottom: 0.8rem; font-size: 1.45rem;">Raising Capable Believers</h3>
          <p style="line-height: 1.8; font-size: 0.98rem; color: var(--text-muted); margin: 0;">
            <?php echo htmlspecialchars($ministry_vision); ?>
          </p>
        </div>
      </div>

    </div>
  </section>

  <!-- Core Ministry Values -->
  <section class="section section-alt">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">Culture of Honor</span>
        <h2>5 Foundational Values</h2>
        <p class="lead">The sacred principles that govern our fellowship, preaching, prayer, and discipleship walk.</p>
      </div>

      <div class="quick-access-grid" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));">
        <?php foreach ($ministry_values as $val): ?>
          <div class="pillar-card spotlight-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
              <div class="pillar-icon" style="margin-bottom: 0;">
                <?php if ($val['number'] == '1'): ?>
                  <svg class="icon" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                <?php elseif ($val['number'] == '2'): ?>
                  <svg class="icon" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                <?php elseif ($val['number'] == '3'): ?>
                  <svg class="icon" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <?php elseif ($val['number'] == '4'): ?>
                  <svg class="icon" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <?php else: ?>
                  <svg class="icon" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <?php endif; ?>
              </div>
              <span class="btn-soft" style="padding: 0.25rem 0.75rem; font-size: 0.78rem; font-weight: 800; border-radius: var(--radius-full);">Value 0<?php echo htmlspecialchars($val['number']); ?></span>
            </div>

            <h3 style="font-size: 1.25rem; margin-bottom: 0.3rem;"><?php echo htmlspecialchars($val['title']); ?></h3>
            <div style="font-size: 0.85rem; font-weight: 800; color: var(--amber-primary); margin-bottom: 0.7rem;">
              <?php echo htmlspecialchars($val['scripture']); ?>
            </div>
            <p style="font-size: 0.92rem; color: var(--text-muted); line-height: 1.65; margin: 0;">
              <?php echo htmlspecialchars($val['description']); ?>
            </p>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Discipleship Pathway -->
      <div style="margin-top: 4.5rem;">
        <div class="section-header">
          <span class="section-tag">Spiritual Maturity</span>
          <h2>The Believer's Pathway</h2>
          <p class="lead">How we nurture every person from new birth to spiritual maturity and kingdom leadership.</p>
        </div>

        <div class="roadmap-grid">
          <div class="roadmap-card spotlight-card">
            <div class="roadmap-card-header">
              <span class="roadmap-num">01</span>
              <span class="roadmap-badge">Salvation</span>
            </div>
            <h3 class="roadmap-title">New Birth in Christ</h3>
            <div class="roadmap-scripture">Romans 10:9, 10</div>
            <p class="roadmap-desc">Receiving eternal life through faith in Jesus Christ, washing of regeneration, and new creation identity.</p>
          </div>

          <div class="roadmap-card spotlight-card">
            <div class="roadmap-card-header">
              <span class="roadmap-num">02</span>
              <span class="roadmap-badge">Illumination</span>
            </div>
            <h3 class="roadmap-title">Rooted in the Word</h3>
            <div class="roadmap-scripture">Colossians 2:6, 7</div>
            <p class="roadmap-desc">Grounding in foundational apostolic doctrine, understanding righteous standing, and intimacy through prayer.</p>
          </div>

          <div class="roadmap-card spotlight-card">
            <div class="roadmap-card-header">
              <span class="roadmap-num">03</span>
              <span class="roadmap-badge">Empowerment</span>
            </div>
            <h3 class="roadmap-title">Holy Spirit Ministry</h3>
            <div class="roadmap-scripture">Acts 1:8</div>
            <p class="roadmap-desc">Discovering spiritual gifts, walking in prophetic sensitivity, and demonstrating supernatural power in daily life.</p>
          </div>

          <div class="roadmap-card spotlight-card">
            <div class="roadmap-card-header">
              <span class="roadmap-num">04</span>
              <span class="roadmap-badge">Commission</span>
            </div>
            <h3 class="roadmap-title">Priestly Leadership</h3>
            <div class="roadmap-scripture">1 Peter 2:9</div>
            <p class="roadmap-desc">Advancing the Kingdom in society, mentoring newer believers, and manifesting Christ's love and excellence.</p>
          </div>
        </div>
      </div>

      <!-- Pastoral Heart & Commitment Letter -->
      <div class="pastoral-heart-card">
        <span class="section-tag">Pastoral Heart</span>
        <h3 style="font-size: 1.6rem; color: var(--green-darkest); margin-bottom: 0.8rem;">A Welcome from Leadership</h3>
        <p style="color: var(--text-muted); font-size: 1.05rem; line-height: 1.8; margin-bottom: 1.6rem;">
          At Alive Faith Ministries, we do not view you as a face in the crowd. You are God's workmanship, ordained for purpose and destined for greatness in Christ. Our pastoral commitment is to shepherd you with uncompromised truth, genuine love, and continuous intercession before the throne of grace.
        </p>

        <div class="pastoral-commitments-grid">
          <div class="commitment-item">
            <div class="commitment-item-icon">
              <svg class="icon" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <div class="commitment-item-text">
              <h4>Pure Biblical Truth</h4>
              <p>Teaching the unfiltered gospel of grace with clarity, revelation, and scriptural integrity.</p>
            </div>
          </div>

          <div class="commitment-item">
            <div class="commitment-item-icon">
              <svg class="icon" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
            </div>
            <div class="commitment-item-text">
              <h4>Unconditional Love</h4>
              <p>Creating a loving, welcoming family where everyone is embraced, healed, and valued.</p>
            </div>
          </div>

          <div class="commitment-item">
            <div class="commitment-item-icon">
              <svg class="icon" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="commitment-item-text">
              <h4>Fervent Intercession</h4>
              <p>Standing continually in prayer for your family, spiritual breakthrough, health, and destiny.</p>
            </div>
          </div>
        </div>

        <div style="margin-top: 2.2rem; display: flex; gap: 1rem; flex-wrap: wrap;">
          <a href="#contact" class="btn btn-primary" data-tab-target="tab-contact">Connect With Pastoral Team</a>
          <a href="#watch" class="btn btn-secondary" data-tab-target="tab-watch">Watch Recent Sermons</a>
        </div>
      </div>

    </div>
  </section>

</div>

<!-- Tab 3: Faith -->
<div id="tab-faith" class="tab-pane <?php echo ($active_tab === 'tab-faith') ? 'active' : ''; ?>">
  
  <section class="page-banner page-banner-faith">
    <div class="banner-bg-drift" style="background-image: url('assets/images/bible-bg.jpg');"></div>
    <div class="banner-vignette"></div>
    <div class="container banner-inner">
      <span class="section-tag" style="color: var(--amber-light);">Biblical Doctrine</span>
      <h1>Statement of Faith</h1>
      <p class="lead">
        The unshakeable biblical truths that anchor our doctrine, teaching, prayer life, and walk in Christ Jesus.
      </p>
    </div>
  </section>

  <section class="section section-white">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">Foundational Truths</span>
        <h2>10 Articles of Faith</h2>
        <p class="lead">Search doctrines or filter through our scriptural convictions below.</p>
      </div>

      <!-- Real-Time Interactive Search Bar -->
      <div class="faith-search-wrap">
        <svg class="faith-search-icon" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        <input type="text" id="faith-search-input" class="faith-search-input" placeholder="Search doctrines, e.g. Holy Spirit, Salvation, Christ, Eternal Life...">
      </div>

      <div class="faith-count-badge" id="faith-count-badge">
        Showing all 10 foundational articles of faith
      </div>

      <!-- Interactive Category Filter Bar -->
      <div class="faith-filter-bar">
        <button class="filter-btn active" type="button" data-filter="all">All Articles (10)</button>
        <button class="filter-btn" type="button" data-filter="god">God &amp; Christ</button>
        <button class="filter-btn" type="button" data-filter="salvation">Salvation &amp; Grace</button>
        <button class="filter-btn" type="button" data-filter="spirit">Holy Spirit &amp; Truth</button>
        <button class="filter-btn" type="button" data-filter="hope">Eternal Hope</button>
      </div>

      <!-- 10 Articles Grid with Scriptural Expanders -->
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.8rem; max-width: 1100px; margin: 0 auto;">
        <?php 
        $categories = ['god', 'god', 'salvation', 'salvation', 'hope', 'salvation', 'spirit', 'spirit', 'spirit', 'hope'];
        $scripture_proofs = [
          0 => 'Genesis 1:1, 26 &bull; Deuteronomy 6:4 &bull; 1 John 5:7 &bull; Matthew 28:19: "For there are three that bear record in heaven, the Father, the Word, and the Holy Ghost: and these three are one."',
          1 => 'John 1:1, 14 &bull; 1 Corinthians 15:3, 4 &bull; 1 Timothy 3:16 &bull; Hebrews 4:15: "And the Word was made flesh, and dwelt among us, and we beheld His glory."',
          2 => 'Ephesians 2:8, 9 &bull; Romans 3:24 &bull; Romans 5:8 &bull; Titus 3:5: "For by grace are ye saved through faith; and that not of yourselves: it is the gift of God: not of works."',
          3 => '1 John 1:9 &bull; Acts 3:19 &bull; 2 Corinthians 7:10 &bull; Luke 13:3: "If we confess our sins, He is faithful and just to forgive us our sins, and to cleanse us from all unrighteousness."',
          4 => 'Romans 5:1 &bull; Galatians 2:16 &bull; Romans 8:1 &bull; 2 Corinthians 5:21: "Therefore being justified by faith, we have peace with God through our Lord Jesus Christ."',
          5 => 'Matthew 28:19 &bull; Acts 2:38 &bull; Romans 6:3, 4 &bull; Colossians 2:12: "Buried with Him in baptism, wherein also ye are risen with Him through the faith of the operation of God."',
          6 => 'Acts 1:8 &bull; Acts 2:4 &bull; Matthew 3:11 &bull; Luke 24:49: "And they were all filled with the Holy Ghost, and began to speak with other tongues, as the Spirit gave them utterance."',
          7 => '1 Corinthians 12:4 to 11 &bull; Romans 12:6 to 8 &bull; 1 Corinthians 14:1: "Now concerning spiritual gifts, brethren, I would not have you ignorant... but the manifestation of the Spirit is given to every man to profit withal."',
          8 => '1 Thessalonians 5:23 &bull; Hebrews 12:14 &bull; 1 Peter 1:15, 16 &bull; 2 Corinthians 7:1: "And the very God of peace sanctify you wholly; and I pray God your whole spirit and soul and body be preserved blameless."',
          9 => '1 Thessalonians 4:16, 17 &bull; 1 Corinthians 15:51, 52 &bull; Titus 2:13 &bull; Revelation 22:20: "For the Lord Himself shall descend from heaven with a shout, with the voice of the archangel, and with the trump of God: and the dead in Christ shall rise first."'
        ];

        foreach ($statement_of_faith as $idx => $item): 
          $cat = $categories[$idx] ?? 'all';
          $proof = $scripture_proofs[$idx] ?? '';
        ?>
          <div class="faith-card spotlight-card" data-category="<?php echo htmlspecialchars($cat); ?>">
            <div class="num-badge">
              <?php echo htmlspecialchars($item['num']); ?>
            </div>
            <div style="flex-grow: 1;">
              <h4 style="font-size: 1.22rem; margin-bottom: 0.5rem; color: var(--green-darkest);">
                <?php echo htmlspecialchars($item['title']); ?>
              </h4>
              <p style="font-size: 0.94rem; color: var(--text-muted); line-height: 1.7; margin: 0 0 0.5rem 0;">
                <?php echo htmlspecialchars($item['text']); ?>
              </p>
              
              <button type="button" class="scripture-toggle-btn" data-target="scripture-box-<?php echo $idx; ?>">
                View Scriptures <span style="font-size: 0.8rem;">&darr;</span>
              </button>
              
              <div class="faith-scripture-box" id="scripture-box-<?php echo $idx; ?>">
                <strong>Scriptural Proof:</strong><br>
                <?php echo $proof; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Phaneroo-Style Salvation Pathway & Prayer Guide -->
      <div class="salvation-path-container">
        <div style="text-align: center; max-width: 720px; margin: 0 auto;">
          <span class="section-tag" style="color: var(--amber-light);">The Roman Road</span>
          <h2 style="color: #ffffff; font-size: clamp(1.8rem, 4vw, 2.6rem); margin-bottom: 0.8rem;">The Decision to Receive Christ</h2>
          <p style="color: rgba(255, 255, 255, 0.88); font-size: 1.05rem; line-height: 1.7;">
            Salvation is God's free gift to all mankind. You can receive Jesus Christ right now where you are.
          </p>
        </div>

        <div class="salvation-steps-grid">
          <div class="salvation-step-card">
            <div class="salvation-step-num">Step 01</div>
            <div class="salvation-step-title">The Need</div>
            <div class="salvation-step-ref">Romans 3:23</div>
            <p class="salvation-step-desc">All have sinned and come short of the glory of God, yet His heart yearns to restore us.</p>
          </div>

          <div class="salvation-step-card">
            <div class="salvation-step-num">Step 02</div>
            <div class="salvation-step-title">The Free Gift</div>
            <div class="salvation-step-ref">Romans 6:23</div>
            <p class="salvation-step-desc">The wages of sin is death, but the gift of God is eternal life through Jesus Christ our Lord.</p>
          </div>

          <div class="salvation-step-card">
            <div class="salvation-step-num">Step 03</div>
            <div class="salvation-step-title">The Confession</div>
            <div class="salvation-step-ref">Romans 10:9, 10</div>
            <p class="salvation-step-desc">Confess with your mouth the Lord Jesus and believe in your heart that God raised Him from the dead.</p>
          </div>

          <div class="salvation-step-card">
            <div class="salvation-step-num">Step 04</div>
            <div class="salvation-step-title">The Assurance</div>
            <div class="salvation-step-ref">John 5:24</div>
            <p class="salvation-step-desc">Whoever hears His Word and believes Him that sent Him has everlasting life and shall not come into condemnation.</p>
          </div>
        </div>

        <!-- The Sacred Prayer of Salvation Card -->
        <div class="salvation-prayer-card">
          <div style="font-size: 0.82rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.12em; color: var(--amber-light); margin-bottom: 0.8rem;">
            Prayer of Salvation
          </div>
          <div class="salvation-prayer-text">
            "Lord Jesus, I come to You today. I acknowledge that I need You. I believe that You died on the cross for my sins and rose again for my justification. I confess You today as my Lord and personal Savior. Cleanse me, fill me with Your Holy Spirit, and write my name in the Book of Life. Thank You for saving me. I am born again, in Jesus' Name. Amen."
          </div>
          <button type="button" class="btn btn-primary" id="salvation-confirm-btn" style="padding: 1rem 2rem;">
            I Have Prayed This Prayer
          </button>
        </div>

        <!-- Confirmation Feedback Banner -->
        <div class="decision-confirmed-banner" id="decision-confirmed-banner">
          <h3 style="color: #ffffff; margin-bottom: 0.4rem; font-size: 1.4rem;">Glory to God! Welcome to the Family of Christ!</h3>
          <p style="margin: 0 0 1rem 0; font-size: 0.98rem; color: rgba(255, 255, 255, 0.94);">
            Your sins are forgiven, and you are now a new creation in Christ Jesus. We would love to walk with you and help you grow in your faith.
          </p>
          <a href="#contact" class="btn btn-outline-light" data-tab-target="tab-contact">
            Connect With a Pastor Today
          </a>
        </div>

      </div>

    </div>
  </section>

</div>

<!-- Tab 4: Giving -->
<div id="tab-giving" class="tab-pane <?php echo ($active_tab === 'tab-giving') ? 'active' : ''; ?>">
  
  <section class="page-banner page-banner-giving">
    <div class="banner-bg-drift" style="background-image: url('assets/images/giving-bg.jpg');"></div>
    <div class="banner-vignette"></div>
    <div class="container banner-inner">
      <span class="section-tag" style="color: var(--amber-light);">Kingdom Stewardship</span>
      <h1>Giving &amp; Partnership</h1>
      <p class="lead">
        Partnering with God's work to raise believers, support charity, advance church planting, and broadcast the Gospel.
      </p>
    </div>
  </section>

  <section class="section section-white">
    <div class="container">
      
      <!-- Scripture Foundation Box -->
      <div class="firm-belief-box" style="max-width: 900px; margin: 0 auto 3.5rem auto; background: linear-gradient(135deg, rgba(254, 244, 236, 0.96) 0%, rgba(255, 255, 255, 0.98) 100%), url('assets/images/giving-bg.jpg') center/cover no-repeat;">
        <span class="section-tag" style="margin-bottom: 0.4rem;">Scripture Foundation</span>
        <h3 style="font-size: 1.35rem; color: var(--green-darkest); margin-bottom: 0.8rem; line-height: 1.6;">
          "Every man according as he purposeth in his heart, so let him give; not grudgingly, or of necessity: for God loveth a cheerful giver."
        </h3>
        <div style="font-size: 1rem; font-weight: 800; color: var(--amber-primary);">
          2 Corinthians 9:7 &bull; Luke 6:38
        </div>
      </div>

      <!-- 4 Impact Pillars of Ministry Giving -->
      <div class="section-header">
        <span class="section-tag">Kingdom Impact</span>
        <h2>Where Your Giving Goes</h2>
        <p class="lead">Every seed sown into Alive Faith Ministries bears direct, tangible fruit in lives and communities.</p>
      </div>

      <div class="giving-pillars-grid">
        <div class="giving-impact-card spotlight-card">
          <div class="giving-impact-icon">
            <svg class="icon" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
          </div>
          <h3 class="giving-impact-title">Soul Winning &amp; Crusades</h3>
          <p class="giving-impact-desc">Funding open-air gospel crusades, regional evangelistic outreaches, and soul-winning literature across communities.</p>
        </div>

        <div class="giving-impact-card spotlight-card">
          <div class="giving-impact-icon">
            <svg class="icon" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
          </div>
          <h3 class="giving-impact-title">Discipleship &amp; Training</h3>
          <p class="giving-impact-desc">Equipping ministers, producing teaching manuals, and establishing believer leadership foundations to mentor the next generation.</p>
        </div>

        <div class="giving-impact-card spotlight-card">
          <div class="giving-impact-icon">
            <svg class="icon" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
          </div>
          <h3 class="giving-impact-title">Compassion &amp; Welfare</h3>
          <p class="giving-impact-desc">Providing food relief, educational support for vulnerable children, and emergency benevolent assistance to families in need.</p>
        </div>

        <div class="giving-impact-card spotlight-card">
          <div class="giving-impact-icon">
            <svg class="icon" viewBox="0 0 24 24"><path d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
          </div>
          <h3 class="giving-impact-title">Global Broadcast Reach</h3>
          <p class="giving-impact-desc">Transmitting high-definition live streams, podcasts, and digital media to reach unchurched believers worldwide.</p>
        </div>
      </div>

      <!-- Interactive Giving Console -->
      <div class="giving-options-grid" style="max-width: 980px; margin: 3.5rem auto 0 auto;">
        
        <!-- Mobile Money Console -->
        <div class="giving-card spotlight-card">
          <div class="pillar-icon">
            <svg class="icon icon-lg" viewBox="0 0 24 24"><path d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
          </div>
          <h3 style="font-size: 1.45rem; margin-bottom: 0.4rem;">M-Pesa Stewardship Console</h3>
          <p style="font-size: 0.92rem; color: var(--text-muted); margin-bottom: 1.2rem;">
            Select your giving purpose below to generate your personalized reference:
          </p>

          <!-- Purpose Selector -->
          <div class="purpose-grid">
            <span class="purpose-pill active" data-purpose="Tithe">Tithe</span>
            <span class="purpose-pill" data-purpose="Offering">Offering</span>
            <span class="purpose-pill" data-purpose="Partnership">Partnership</span>
            <span class="purpose-pill" data-purpose="Welfare &amp; Charity">Welfare &amp; Charity</span>
            <span class="purpose-pill" data-purpose="Media Outreach">Media Outreach</span>
          </div>

          <div class="copy-phone-box">
            <div>
              <div style="font-size: 0.78rem; text-transform: uppercase; font-weight: 800; color: var(--text-subtle);">M-Pesa Number</div>
              <div style="font-size: 1.3rem; font-weight: 800; color: var(--green-darkest);" id="giving-phone-display"><?php echo htmlspecialchars($giving_info['mobile_money']); ?></div>
            </div>
            <button class="copy-btn" id="copy-phone-btn" type="button" data-phone="<?php echo htmlspecialchars($giving_info['mobile_money']); ?>">
              Copy Number
            </button>
          </div>

          <div style="background-color: var(--bg-surface); padding: 1.1rem 1.3rem; border-radius: var(--radius-md); font-size: 0.92rem; margin-bottom: 1.2rem;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
              <span style="color: var(--text-muted);">Account Name:</span>
              <strong><?php echo htmlspecialchars($giving_info['account_name']); ?></strong>
            </div>
            <div style="display: flex; justify-content: space-between;">
              <span style="color: var(--text-muted);">Reference:</span>
              <strong id="giving-ref-display" style="color: var(--amber-primary);">Tithe: [Your Name]</strong>
            </div>
          </div>

          <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.6; margin: 0 0 1.5rem 0;">
            Kindly include your name and purpose so pastoral leadership can stand with you in thanksgiving and agreement prayer.
          </p>

          <!-- Voluntary Heart Giving & M-Pesa Instructions -->
          <div style="padding-top: 1.5rem; border-top: 1px solid rgba(7, 31, 17, 0.08);">
            <!-- Free-Will Kingdom Giving Display Box -->
            <div class="seed-impact-display" id="seed-impact-display" style="margin-top: 0;">
              <div class="seed-impact-icon">
                <svg class="icon" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
              </div>
              <div class="seed-impact-text">
                <h4 id="seed-impact-title">Free-Will Kingdom Giving</h4>
                <p id="seed-impact-desc">Give freely as the Lord has prospered you, whether small or great. Every seed sown in faith advances the Gospel, cares for the sanctuary, supports benevolence, and touches lives. God honors every cheerful giver (2 Cor. 9:7).</p>
              </div>
            </div>

            <!-- Dynamic M-Pesa Instruction Prompt -->
            <div class="mpesa-quick-action">
              <div>
                <div style="font-size: 0.78rem; text-transform: uppercase; color: #94a3b8; font-weight: 700;">M-Pesa Quick Send Details</div>
                <div class="mpesa-quick-code" id="mpesa-quick-instruction">Send to 0728 838 977</div>
              </div>
              <button type="button" class="btn btn-secondary" id="copy-mpesa-instruction-btn" style="background: rgba(255,255,255,0.18); color: #ffffff; border: none; padding: 0.55rem 1.1rem; font-size: 0.85rem;">
                Copy Giving Details
              </button>
            </div>
          </div>
        </div>

        <!-- Covenant Partnership Desk -->
        <div class="giving-card spotlight-card">
          <div class="pillar-icon amber">
            <svg class="icon icon-lg" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
          </div>
          <h3 style="font-size: 1.45rem; margin-bottom: 0.4rem;">Covenant Partnership</h3>
          <p style="font-size: 0.92rem; color: var(--text-muted); margin-bottom: 1.2rem;">
            Consistent monthly fellowship in kingdom expansion, church planting, and ministerial benevolence.
          </p>

          <p style="font-size: 0.94rem; color: var(--text-muted); line-height: 1.75; margin-bottom: 1.8rem;">
            Partners share in the heavenly reward and grace resting upon Alive Faith Ministries. As a partner, you receive monthly pastoral communion letters, exclusive prayer coverage, and direct ministry updates.
          </p>

          <div style="display: flex; flex-direction: column; gap: 0.85rem;">
            <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $church_phone); ?>" class="btn btn-primary" style="width: 100%;">
              Call Partnership Desk
            </a>
            <a href="https://wa.me/254712785016?text=Hello%20Alive%20Faith%20Ministries,%20I%20would%20like%20to%20become%20a%20Covenant%20Partner." target="_blank" rel="noopener noreferrer" class="btn btn-secondary" style="width: 100%;">
              WhatsApp Partnership Desk
            </a>
          </div>
        </div>

      </div>

      <!-- Step-by-Step M-Pesa Giving Walkthrough -->
      <div style="margin-top: 4.5rem;">
        <div class="section-header">
          <span class="section-tag">Simple Guide</span>
          <h2>How to Give via M-Pesa</h2>
          <p class="lead">5 straightforward steps to transfer your offering directly from your mobile phone.</p>
        </div>

        <div class="mpesa-walkthrough-grid">
          <div class="mpesa-step-card">
            <div class="mpesa-step-num">Step 01</div>
            <h4 class="mpesa-step-title">Open M-Pesa</h4>
            <p class="mpesa-step-desc">Go to the M-Pesa menu or SIM toolkit on your mobile phone.</p>
          </div>

          <div class="mpesa-step-card">
            <div class="mpesa-step-num">Step 02</div>
            <h4 class="mpesa-step-title">Select Send Money</h4>
            <p class="mpesa-step-desc">Choose Send Money from your M-Pesa options.</p>
          </div>

          <div class="mpesa-step-card">
            <div class="mpesa-step-num">Step 03</div>
            <h4 class="mpesa-step-title">Enter Number</h4>
            <p class="mpesa-step-desc">Enter <strong>0728 838 977</strong> (Alive Faith Ministries).</p>
          </div>

          <div class="mpesa-step-card">
            <div class="mpesa-step-num">Step 04</div>
            <h4 class="mpesa-step-title">Enter Amount</h4>
            <p class="mpesa-step-desc">Enter any amount as purposed in your heart, with your name and purpose as reference.</p>
          </div>

          <div class="mpesa-step-card">
            <div class="mpesa-step-num">Step 05</div>
            <h4 class="mpesa-step-title">Confirm with PIN</h4>
            <p class="mpesa-step-desc">Enter your M-Pesa PIN and press send to complete.</p>
          </div>
        </div>
      </div>

    </div>
  </section>

</div>

<!-- Tab 5: Watch -->
<div id="tab-watch" class="tab-pane <?php echo ($active_tab === 'tab-watch') ? 'active' : ''; ?>">
  
  <section class="page-banner page-banner-watch">
    <div class="banner-bg-drift" style="background-image: url('assets/images/worship-stage.jpg');"></div>
    <div class="banner-vignette"></div>
    <div class="container banner-inner">
      <span class="section-tag" style="color: var(--amber-light);">Broadcasting the Word</span>
      <h1>Watch Services</h1>
      <p class="lead">
        Experience our live gatherings and archived revelatory teachings from anywhere across the globe.
      </p>
    </div>
  </section>

  <section class="section section-white">
    <div class="container">
      <div style="max-width: 1040px; margin: 0 auto;">
        
        <!-- Cinema Broadcast Stage Frame -->
        <div class="cinema-stage-frame">
          <div class="cinema-stage-topbar">
            <div style="display: flex; align-items: center; gap: 0.6rem;">
              <span class="live-pulse-dot" id="watch-stage-pulse-dot" style="display: none;"></span>
              <span id="watch-stage-status-label" style="color: #ffffff; font-size: 0.88rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em;">
                AFM Global Broadcast Feed
              </span>
            </div>

            <!-- Cinema Channel Switcher -->
            <div class="cinema-stage-channels">
              <button class="channel-chip-btn stream-tab-btn active" type="button" data-stream="live">Live Gathering</button>
              <button class="channel-chip-btn stream-tab-btn" type="button" data-stream="sunday">Sunday Archive</button>
              <button class="channel-chip-btn stream-tab-btn" type="button" data-stream="friday">Friday Prayer</button>
            </div>
          </div>

          <!-- Video Stage Screen with Ambient Glow -->
          <div class="stream-screen-box" style="margin: 0; border-radius: 0;">
            <h3 style="color: #ffffff; font-size: clamp(1.6rem, 3.5vw, 2.4rem); margin-bottom: 0.8rem; text-shadow: 0 2px 10px rgba(0,0,0,0.4);" id="stream-title-display">
              Alive Faith Ministries Live Broadcast
            </h3>
            <p style="color: rgba(255, 255, 255, 0.92); max-width: 650px; margin: 0 auto 2.2rem auto; font-size: 1.05rem; text-shadow: 0 1px 4px rgba(0,0,0,0.3); line-height: 1.7;" id="stream-desc-display">
              Join our live fellowship stream every Friday at 6:00 PM and Sunday at 3:30 PM (East Africa Time). Experience worship, fervent prayer, and revelatory teaching of the Word.
            </p>

            <div class="theater-glow" id="theater-glow-box">
              <div style="color: var(--amber-light); margin-bottom: 0.8rem;">
                <svg class="icon icon-lg" viewBox="0 0 24 24"><path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
              </div>
              <h4 style="color: #ffffff; font-size: 1.35rem; margin-bottom: 0.4rem;" id="theater-glow-title">High-Definition Broadcast Ready</h4>
              <p style="font-size: 0.92rem; color: rgba(255, 255, 255, 0.85); margin: 0;" id="theater-glow-sub">
                Friday: 6:00 PM (E.A.T.) &bull; Sunday: 3:30 PM (E.A.T.)
              </p>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
              <a href="<?php echo htmlspecialchars($church_facebook); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary" style="background: #1877F2; display: inline-flex; align-items: center; gap: 0.55rem; box-shadow: 0 4px 18px rgba(24, 119, 242, 0.4);">
                <svg class="icon" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                Watch on Facebook Live
              </a>
              <a href="https://www.youtube.com" target="_blank" rel="noopener noreferrer" class="btn btn-secondary">
                <svg class="icon" viewBox="0 0 24 24"><path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path></svg>
                Launch YouTube Live
              </a>
              <a href="#contact" class="btn btn-outline-light" data-tab-target="tab-contact">
                Get Service Reminders
              </a>
            </div>
          </div>
        </div>

        <!-- Interactive Sermon Notes Bulletin -->
        <div class="sermon-notes-card">
          <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.4rem;">
            <div>
              <span class="section-tag" style="margin-bottom: 0.3rem;">Digital Bulletin</span>
              <h3 style="font-size: 1.5rem; color: var(--green-darkest); margin: 0;">Recent Teaching Outline</h3>
            </div>
            <button type="button" class="btn btn-secondary" id="copy-notes-btn">
              Copy Sermon Notes
            </button>
          </div>

          <div id="sermon-notes-body" style="background: var(--bg-surface); padding: 1.6rem; border-radius: var(--radius-md); font-size: 0.94rem; line-height: 1.8; color: var(--text-muted);">
            <strong style="color: var(--green-darkest); font-size: 1.15rem; display: block; margin-bottom: 0.4rem;">
              Series: Walking in the Fullness of Christ
            </strong>
            <span style="font-weight: 700; color: var(--amber-primary); display: block; margin-bottom: 0.8rem;">
              Scriptural Anchor: Ephesians 2:10 &bull; Colossians 2:6, 7
            </span>
            <ul style="padding-left: 1.3rem; margin: 0;">
              <li><strong>Point 1: The Divine Workmanship</strong>: We are not an accident of nature; we are God's deliberate masterpiece created in Christ for good works.</li>
              <li><strong>Point 2: Beyond Religion into Reality</strong>: Righteousness is not earned through fleshly struggle; it is imputed through grace and expressed through faith.</li>
              <li><strong>Point 3: The Priestly Altar</strong>: Every believer is ordained to offer spiritual sacrifices of prayer, praise, and kingdom impact in their sphere of influence.</li>
            </ul>
          </div>
        </div>

        <!-- Flagship: Interactive Sermon Soundwave Audio Console & Word Player -->
        <div class="soundwave-player-card spotlight-card" id="sermon-soundwave-player">
          <div class="soundwave-top-meta">
            <div class="soundwave-badge">
              <svg class="icon" viewBox="0 0 24 24" style="width: 16px; height: 16px;"><path d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"></path></svg>
              <span>Spiritual Word Stream &bull; Revelatory Teachings</span>
            </div>
            <div class="speed-pills-wrap">
              <button type="button" class="speed-pill-btn active" data-speed="1">1.0x</button>
              <button type="button" class="speed-pill-btn" data-speed="1.25">1.25x</button>
              <button type="button" class="speed-pill-btn" data-speed="1.5">1.5x</button>
            </div>
          </div>

          <div style="max-width: 680px;">
            <h3 style="font-size: clamp(1.4rem, 2.5vw, 1.85rem); color: #ffffff; margin-bottom: 0.4rem;" id="player-sermon-title">
              Walking in the Fullness of Christ Jesus
            </h3>
            <p style="color: rgba(255, 255, 255, 0.78); font-size: 0.92rem; margin: 0;" id="player-sermon-meta">
              Alive Faith Ministries Pastoral Teaching &bull; Scripture: Ephesians 2:10 &bull; Colossians 2:6, 7
            </p>
          </div>

          <!-- Soundwave Animation Visualizer Bars -->
          <div class="soundwave-visualizer" aria-hidden="true" id="soundwave-visualizer">
            <div class="soundwave-bar"></div>
            <div class="soundwave-bar"></div>
            <div class="soundwave-bar"></div>
            <div class="soundwave-bar"></div>
            <div class="soundwave-bar"></div>
            <div class="soundwave-bar"></div>
            <div class="soundwave-bar"></div>
            <div class="soundwave-bar"></div>
            <div class="soundwave-bar"></div>
            <div class="soundwave-bar"></div>
            <div class="soundwave-bar"></div>
            <div class="soundwave-bar"></div>
            <div class="soundwave-bar"></div>
            <div class="soundwave-bar"></div>
            <div class="soundwave-bar"></div>
            <div class="soundwave-bar"></div>
          </div>

          <!-- Audio Scrubber Timeline -->
          <div class="audio-scrubber-wrap">
            <div class="audio-scrubber-track" id="audio-scrubber-track">
              <div class="audio-scrubber-fill" id="audio-scrubber-fill"></div>
            </div>
            <div class="audio-time-row">
              <span id="audio-time-current">00:00</span>
              <span id="audio-time-total">48:20</span>
            </div>
          </div>

          <!-- Audio Action Controls Row -->
          <div class="soundwave-controls-row">
            <div style="display: flex; align-items: center; gap: 1rem;">
              <button type="button" class="soundwave-main-btn" id="sermon-play-toggle" aria-label="Play or pause sermon audio">
                <svg id="play-icon-svg" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"></path></svg>
                <svg id="pause-icon-svg" viewBox="0 0 24 24" style="display: none;"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"></path></svg>
              </button>
              <div>
                <div style="font-size: 0.95rem; font-weight: 700; color: #ffffff;" id="sermon-play-status">Click to Listen Now</div>
                <div style="font-size: 0.8rem; color: var(--gold-start);">High-fidelity word audio</div>
              </div>
            </div>

            <div style="display: flex; gap: 0.65rem; flex-wrap: wrap;">
              <a href="https://wa.me/?text=Listen%20to%20this%20life-transforming%20sermon%20by%20Alive%20Faith%20Ministries:%20Walking%20in%20the%20Fullness%20of%20Christ%20https://www.livefaithministries.org/%23watch" target="_blank" rel="noopener noreferrer" class="btn btn-secondary" style="background: rgba(255,255,255,0.12); color: #ffffff; border: none; padding: 0.5rem 1.1rem; font-size: 0.84rem; display: inline-flex; align-items: center; gap: 0.4rem;">
                <svg class="icon" viewBox="0 0 24 24" style="width: 15px; height: 15px;"><path d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                Share Audio
              </a>
              <button type="button" class="btn btn-secondary" id="sermon-download-notes-btn" style="background: rgba(255,255,255,0.12); color: #ffffff; border: none; padding: 0.5rem 1.1rem; font-size: 0.84rem; display: inline-flex; align-items: center; gap: 0.4rem;">
                <svg class="icon" viewBox="0 0 24 24" style="width: 15px; height: 15px;"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Study Notes
              </button>
            </div>
          </div>

          <!-- Playlist Teaching Chips -->
          <div class="playlist-chips">
            <button type="button" class="playlist-chip active" data-title="Walking in the Fullness of Christ Jesus" data-ref="Ephesians 2:10 &bull; Colossians 2:6, 7" data-duration="48:20">
              01: Walking in Fullness
            </button>
            <button type="button" class="playlist-chip" data-title="The Priestly Mandate of Persistent Intercession" data-ref="Luke 18:1 &bull; Acts 6:4 &bull; 1 Thess 5:17" data-duration="54:15">
              02: Priestly Intercession
            </button>
            <button type="button" class="playlist-chip" data-title="Covenant Faith &amp; Overcoming Every Stumbling Block" data-ref="1 John 5:4 &bull; Hebrews 11:1, 6" data-duration="42:30">
              03: Unshakeable Faith
            </button>
          </div>
        </div>
        <div class="tz-converter-box">
          <span class="section-tag" style="color: var(--amber-light);">Global Schedule</span>
          <h3 style="color: #ffffff; font-size: 1.5rem; margin-bottom: 0.4rem;">Interactive Timezone Converter</h3>
          <p style="color: rgba(255, 255, 255, 0.82); font-size: 0.94rem; margin: 0;">
            Select your region to convert service times into your local clock:
          </p>

          <div class="tz-pills-wrap">
            <button type="button" class="tz-btn active" data-tz="eat">Nairobi (EAT)</button>
            <button type="button" class="tz-btn" data-tz="bst">London (BST)</button>
            <button type="button" class="tz-btn" data-tz="est">New York (EST)</button>
            <button type="button" class="tz-btn" data-tz="sast">Johannesburg (SAST)</button>
            <button type="button" class="tz-btn" data-tz="wat">Lagos (WAT)</button>
          </div>

          <div class="tz-display-grid">
            <div class="tz-display-card">
              <h5>Selected Region</h5>
              <div class="tz-display-time" id="tz-city-label" style="font-size: 1.15rem;">Nairobi, Kenya (East Africa Time)</div>
              <div class="tz-display-note">Alive Faith Grounds Sanctuary</div>
            </div>

            <div class="tz-display-card">
              <h5>Friday Gathering</h5>
              <div class="tz-display-time" id="tz-friday-time">Friday 6:00 PM (E.A.T.)</div>
              <div class="tz-display-note">Hour of Prayer &amp; Illumination</div>
            </div>

            <div class="tz-display-card">
              <h5>Sunday Gathering</h5>
              <div class="tz-display-time" id="tz-sunday-time">Sunday 3:30 PM (E.A.T.)</div>
              <div class="tz-display-note">Sunday Celebration Service</div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

</div>

<!-- Tab 6: Contact -->
<div id="tab-contact" class="tab-pane <?php echo ($active_tab === 'tab-contact') ? 'active' : ''; ?>">
  
  <section class="page-banner page-banner-contact">
    <div class="banner-bg-drift" style="background-image: url('assets/images/community-bg.jpg');"></div>
    <div class="banner-vignette"></div>
    <div class="container banner-inner">
      <span class="section-tag" style="color: var(--amber-light);">Connect With Us</span>
      <h1>Contact &amp; Prayer</h1>
      <p class="lead">
        We look forward to welcoming you. Reach out with questions, submit prayer requests, or plan your upcoming visit.
      </p>
    </div>
  </section>

  <section class="section section-white">
    <div class="container">

      <!-- 4 Action Contact Cards -->
      <div class="contact-action-cards">
        <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $church_phone); ?>" class="contact-action-box spotlight-card">
          <svg class="icon" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
          <span style="font-size: 0.78rem; text-transform: uppercase; font-weight: 800; color: var(--text-subtle);">Direct Phone</span>
          <strong style="color: var(--green-darkest); font-size: 1.1rem; margin: 0.2rem 0;"><?php echo htmlspecialchars($church_phone); ?></strong>
          <span style="font-size: 0.84rem; color: var(--text-muted);">Call for counseling or inquiries</span>
        </a>

        <a href="https://wa.me/254712785016" target="_blank" rel="noopener noreferrer" class="contact-action-box spotlight-card">
          <svg class="icon" viewBox="0 0 24 24"><path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
          <span style="font-size: 0.78rem; text-transform: uppercase; font-weight: 800; color: var(--text-subtle);">WhatsApp Desk</span>
          <strong style="color: var(--green-darkest); font-size: 1.1rem; margin: 0.2rem 0;">WhatsApp Chat</strong>
          <span style="font-size: 0.84rem; color: var(--text-muted);">Chat with ministry coordinators</span>
        </a>

        <a href="mailto:<?php echo htmlspecialchars($church_email); ?>" class="contact-action-box spotlight-card">
          <svg class="icon" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
          <span style="font-size: 0.78rem; text-transform: uppercase; font-weight: 800; color: var(--text-subtle);">Email Secretary</span>
          <strong style="color: var(--green-darkest); font-size: 1.1rem; margin: 0.2rem 0; word-break: break-all;"><?php echo htmlspecialchars($church_email); ?></strong>
          <span style="font-size: 0.84rem; color: var(--text-muted);">Official ministry correspondence</span>
        </a>

        <div class="contact-action-box spotlight-card">
          <svg class="icon" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
          <span style="font-size: 0.78rem; text-transform: uppercase; font-weight: 800; color: var(--text-subtle);">Service Sanctuary</span>
          <strong style="color: var(--green-darkest); font-size: 1.1rem; margin: 0.2rem 0;">Alive Faith Grounds</strong>
          <span style="font-size: 0.84rem; color: var(--text-muted);">Friday 6:00 PM &bull; Sunday 3:30 PM</span>
        </div>

        <a href="<?php echo htmlspecialchars($church_facebook); ?>" target="_blank" rel="noopener noreferrer" class="contact-action-box spotlight-card">
          <svg class="icon" viewBox="0 0 24 24" fill="#1877F2"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
          <span style="font-size: 0.78rem; text-transform: uppercase; font-weight: 800; color: var(--text-subtle);">Official Community</span>
          <strong style="color: var(--green-darkest); font-size: 1.1rem; margin: 0.2rem 0;">Facebook Page</strong>
          <span style="font-size: 0.84rem; color: var(--text-muted);">Follow AFM broadcasts &amp; updates</span>
        </a>
      </div>

      <!-- Visitor Guide: What to Expect -->
      <div class="section-header" style="margin-top: 1rem;">
        <span class="section-tag">Planning Your Visit</span>
        <h2>What to Expect at Alive Faith</h2>
        <p class="lead">Here is how our ushers, ministers, and congregation prepare for your arrival.</p>
      </div>

      <div class="visitor-welcome-grid">
        <div class="visitor-card spotlight-card">
          <div class="visitor-card-icon">
            <svg class="icon" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
          </div>
          <h3 class="visitor-card-title">Warm Hospitality</h3>
          <p class="visitor-card-desc">Our protocol team welcomes you with love, helps you find comfortable seating, and answers any questions.</p>
        </div>

        <div class="visitor-card spotlight-card">
          <div class="visitor-card-icon">
            <svg class="icon" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
          </div>
          <h3 class="visitor-card-title">Children &amp; Teens Church</h3>
          <p class="visitor-card-desc">Dedicated age-appropriate spiritual instruction, secure care, and engaging lessons for your little ones.</p>
        </div>

        <div class="visitor-card spotlight-card">
          <div class="visitor-card-icon">
            <svg class="icon" viewBox="0 0 24 24"><path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
          </div>
          <h3 class="visitor-card-title">Spirit-Filled Worship</h3>
          <p class="visitor-card-desc">An atmosphere filled with passionate adoration, thanksgiving, and prophetic praise that opens the heavens.</p>
        </div>

        <div class="visitor-card spotlight-card">
          <div class="visitor-card-icon">
            <svg class="icon" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
          </div>
          <h3 class="visitor-card-title">Revelatory Word</h3>
          <p class="visitor-card-desc">Uncompromised preaching of apostolic grace that builds unshakeable faith and manifests practical life answers.</p>
        </div>
      </div>

      <!-- Main Contact & Prayer Form Layout -->
      <div class="contact-layout" style="margin-top: 3.5rem;">
        
        <!-- Contact Information Sidebar -->
        <div class="contact-info-card">
          <span class="section-tag">Sanctuary Details</span>
          <h3 style="font-size: 1.5rem; margin-bottom: 0.4rem;">Alive Faith Ministries</h3>
          <p style="color: var(--text-muted); font-size: 0.92rem; margin-bottom: 2.2rem;">
            <?php echo htmlspecialchars($church_motto); ?>
          </p>

          <div style="display: flex; gap: 1rem; margin-bottom: 1.6rem; align-items: flex-start;">
            <div class="pillar-icon" style="margin-bottom: 0; width: 46px; height: 46px;">
              <svg class="icon" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
            </div>
            <div>
              <h4 style="font-size: 1rem; margin-bottom: 0.2rem;">Telephone Line</h4>
              <p style="margin: 0;"><a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $church_phone); ?>"><strong><?php echo htmlspecialchars($church_phone); ?></strong></a></p>
            </div>
          </div>

          <div style="display: flex; gap: 1rem; margin-bottom: 1.6rem; align-items: flex-start;">
            <div class="pillar-icon amber" style="margin-bottom: 0; width: 46px; height: 46px;">
              <svg class="icon" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            <div>
              <h4 style="font-size: 1rem; margin-bottom: 0.2rem;">Email Dispatch</h4>
              <p style="margin: 0;"><a href="mailto:<?php echo htmlspecialchars($church_email); ?>"><strong><?php echo htmlspecialchars($church_email); ?></strong></a></p>
            </div>
          </div>

          <div style="display: flex; gap: 1rem; margin-bottom: 1.6rem; align-items: flex-start;">
            <div class="pillar-icon" style="margin-bottom: 0; width: 46px; height: 46px;">
              <svg class="icon" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
              <h4 style="font-size: 1rem; margin-bottom: 0.2rem;">Weekly Gatherings</h4>
              <p style="margin: 0; color: var(--text-muted); font-size: 0.92rem;">
                <strong>Friday:</strong> 6:00 PM (E.A.T.)<br>
                <strong>Sunday:</strong> 3:30 PM (E.A.T.)
              </p>
            </div>
          </div>

          <div style="display: flex; gap: 1rem; align-items: flex-start;">
            <div class="pillar-icon amber" style="margin-bottom: 0; width: 46px; height: 46px;">
              <svg class="icon" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <div>
              <h4 style="font-size: 1rem; margin-bottom: 0.2rem;">Location</h4>
              <p style="margin: 0; color: var(--text-muted); font-size: 0.92rem;">
                Alive Faith Grounds, Main Sanctuary. Free on-site parking available.
              </p>
            </div>
          </div>

          <div style="display: flex; gap: 1rem; margin-top: 1.6rem; align-items: flex-start;">
            <div class="pillar-icon" style="margin-bottom: 0; width: 46px; height: 46px; background: rgba(24, 119, 242, 0.12); color: #1877F2;">
              <svg class="icon" viewBox="0 0 24 24" fill="#1877F2"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </div>
            <div>
              <h4 style="font-size: 1rem; margin-bottom: 0.2rem;">Facebook Community</h4>
              <p style="margin: 0;">
                <a href="<?php echo htmlspecialchars($church_facebook); ?>" target="_blank" rel="noopener noreferrer" style="color: #1877F2; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem;">
                  Alive Faith Ministries Page &rarr;
                </a>
              </p>
              <span style="font-size: 0.82rem; color: var(--text-muted);">Follow our daily sermons &amp; live broadcasts</span>
            </div>
          </div>
        </div>

        <!-- Interactive Form with Topic Intent Chips -->
        <div class="form-card">
          <span class="section-tag">Interactive Altar</span>
          <h3 style="font-size: 1.5rem; margin-bottom: 0.4rem;">Send a Note or Prayer Point</h3>
          <p style="color: var(--text-muted); font-size: 0.92rem; margin-bottom: 1.2rem;">
            Click a topic below to auto-prepare your message, or write your note directly:
          </p>

          <!-- Interactive Topic Chips -->
          <div class="form-tag-group" style="margin-bottom: 1.5rem;">
            <span class="form-tag" data-val="Plan a Visit">Plan a Visit</span>
            <span class="form-tag" data-val="Salvation Decision">Salvation Decision</span>
            <span class="form-tag" data-val="Healing &amp; Health">Healing &amp; Health</span>
            <span class="form-tag" data-val="Family &amp; Marriage">Family &amp; Marriage</span>
            <span class="form-tag" data-val="Financial Breakthrough">Financial Breakthrough</span>
            <span class="form-tag" data-val="Giving Inquiry">Giving Inquiry</span>
          </div>

          <?php if ($form_success): ?>
            <div class="alert alert-success">
              <strong>Thank you for contacting Alive Faith Ministries.</strong> Your message has been received by pastoral staff. We will stand with you in agreement prayer and reach out promptly.
            </div>
          <?php endif; ?>

          <?php if (!empty($form_error)): ?>
            <div class="alert alert-info">
              <?php echo htmlspecialchars($form_error); ?>
            </div>
          <?php endif; ?>

          <?php get_form_timestamp(); ?>
          <form action="index.php?tab=contact" method="POST">
            <!-- CSRF Protection Token -->
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(get_csrf_token()); ?>">

            <!-- Anti-Bot Honeypot -->
            <div style="position: absolute; left: -9999px; top: -9999px; width: 0; height: 0; overflow: hidden;" aria-hidden="true">
              <label for="afm_security_check">Leave this field blank</label>
              <input type="text" id="afm_security_check" name="afm_security_check" tabindex="-1" autocomplete="off">
            </div>

            <div class="form-group">
              <label class="form-label" for="full_name">Your Full Name *</label>
              <input type="text" id="full_name" name="full_name" class="form-control" required placeholder="Enter your full name" value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>">
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label" for="email">Email Address *</label>
                <input type="email" id="email" name="email" class="form-control" required placeholder="name@example.com" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
              </div>

              <div class="form-group">
                <label class="form-label" for="phone">Phone Number (Optional)</label>
                <input type="tel" id="phone" name="phone" class="form-control" placeholder="+254 700 000 000" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
              </div>
            </div>

            <div class="form-group">
              <label class="form-label" for="inquiry_type">Purpose of Message</label>
              <select id="inquiry_type" name="inquiry_type" class="form-control">
                <option value="Plan a Visit">I want to visit this Friday or Sunday</option>
                <option value="Prayer Request">Prayer Request / Intercession</option>
                <option value="Salvation Decision">I recently received Jesus Christ</option>
                <option value="Giving Inquiry">Giving / Covenant Partnership Inquiry</option>
                <option value="General Question">General Ministry Question</option>
              </select>
            </div>

            <div class="form-group">
              <label class="form-label" for="message">Your Message or Prayer Points *</label>
              <textarea id="message" name="message" class="form-control" required placeholder="Write your message or prayer points here..."><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">
              Submit Message
            </button>
          </form>
        </div>

      </div>

      <!-- Frequently Asked Questions Accordion -->
      <div style="margin-top: 4.5rem;">
        <div class="section-header">
          <span class="section-tag">Common Inquiries</span>
          <h2>Frequently Asked Questions</h2>
          <p class="lead">Helpful answers for newcomers and first-time attendees visiting our sanctuary.</p>
        </div>

        <div class="faq-accordion">
          <div class="faq-item">
            <button type="button" class="faq-question">
              <span>What should I wear when attending service at Alive Faith?</span>
              <svg class="icon faq-icon-arrow" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div class="faq-answer">
              Come dressed comfortably and decently! Whether you prefer formal attire, smart casual, or traditional dress, you will feel completely at home. Our focus is on worshiping God in spirit and truth.
            </div>
          </div>

          <div class="faq-item">
            <button type="button" class="faq-question">
              <span>What time should I arrive before the service starts?</span>
              <svg class="icon faq-icon-arrow" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div class="faq-answer">
              We recommend arriving 20 to 30 minutes before the scheduled time (around 5:30 PM on Fridays and 3:00 PM on Sundays). This allows ample time for parking, checking in children, and settling into prayer before corporate worship begins.
            </div>
          </div>

          <div class="faq-item">
            <button type="button" class="faq-question">
              <span>How can I receive personal pastoral counseling or dedicated prayer?</span>
              <svg class="icon faq-icon-arrow" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div class="faq-answer">
              Our ministers and pastoral team are available right after each service at the front altar. You may also contact our pastoral line at <?php echo htmlspecialchars($church_phone); ?> or submit a prayer request through this website for one-on-one appointments.
            </div>
          </div>

          <div class="faq-item">
            <button type="button" class="faq-question">
              <span>Can I dedicate my baby or be water baptized at Alive Faith?</span>
              <svg class="icon faq-icon-arrow" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div class="faq-answer">
              Yes, absolutely! We conduct regular water baptism services by full immersion and baby dedications during Sunday celebration services. Speak with the protocol desk or submit an inquiry note above to register for upcoming dates.
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
