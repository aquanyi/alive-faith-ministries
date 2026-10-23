<?php
if (!isset($page_title)) {
    $page_title = $church_name . " | " . $church_motto;
}
if (!isset($active_tab)) {
    $active_tab = 'tab-home';
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr" prefix="og: https://ogp.me/ns#">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Universal Non-pinch Zoomable & Fitted to All Devices -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, shrink-to-fit=no, viewport-fit=cover">
  <meta name="HandheldFriendly" content="true">
  <meta name="MobileOptimized" content="width">
  <meta name="format-detection" content="telephone=no">
  <title><?php echo htmlspecialchars($page_title); ?></title>
  <meta name="description" content="<?php echo htmlspecialchars($about_summary); ?>">
  <meta name="keywords" content="Alive Faith Ministries, AFM, Church Nairobi Kenya, Experience Faith Grace and Intimacy with God, Friday Service, Sunday Celebration Service, Christian Fellowship, Prayer and Teachings, M-Pesa Giving, Sermons Online, Live Faith Ministries">
  <meta name="author" content="Alive Faith Ministries">
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
  <link rel="canonical" href="https://www.livefaithministries.org/">
  
  <!-- Google Search Console Verification -->
  <meta name="google-site-verification" content="googlee439da0fb1beeddb">
  <meta name="google-site-verification" content="e439da0fb1beeddb">
  
  <!-- Open Graph / Facebook / WhatsApp Meta Tags -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://www.livefaithministries.org/">
  <meta property="og:site_name" content="Alive Faith Ministries">
  <meta property="og:title" content="<?php echo htmlspecialchars($page_title); ?>">
  <meta property="og:description" content="<?php echo htmlspecialchars($about_summary); ?>">
  <meta property="og:image" content="https://www.livefaithministries.org/assets/images/worship-hero.jpg">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:image:alt" content="Alive Faith Ministries - Church Worship and Word Gathering">
  <meta property="og:locale" content="en_US">

  <!-- Twitter / X Meta Tags -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:url" content="https://www.livefaithministries.org/">
  <meta name="twitter:title" content="<?php echo htmlspecialchars($page_title); ?>">
  <meta name="twitter:description" content="<?php echo htmlspecialchars($about_summary); ?>">
  <meta name="twitter:image" content="https://www.livefaithministries.org/assets/images/worship-hero.jpg">

  <!-- Mobile Theme & PWA Manifest -->
  <meta name="theme-color" content="#071f11">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="apple-mobile-web-app-title" content="Alive Faith">
  <link rel="manifest" href="site.webmanifest">
  
  <!-- Favicon and Brand Touch Icons -->
  <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
  <link rel="icon" type="image/png" sizes="48x48" href="assets/images/favicon-48x48.png">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
  <link rel="shortcut icon" href="favicon.ico">
  
  <!-- Premium Fonts: Playfair Display & Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="assets/css/style.css">

  <!-- Schema.org Structured Data (Rich Google Snippets) -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Church",
    "name": "Alive Faith Ministries",
    "alternateName": ["AFM", "Live Faith Ministries"],
    "url": "https://www.livefaithministries.org/",
    "logo": "https://www.livefaithministries.org/assets/images/logo.png",
    "image": "https://www.livefaithministries.org/assets/images/worship-hero.jpg",
    "description": "Alive Faith Ministries is a non-denominational ministry with a priestly mandate to raise believers who know and trust God for the realization of their fullness in Christ Jesus.",
    "telephone": "+254712785016",
    "email": "info@livefaithministries.org",
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "Nairobi",
      "addressCountry": "KE"
    },
    "openingHoursSpecification": [
      {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": "Friday",
        "opens": "18:00",
        "closes": "20:30"
      },
      {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": "Sunday",
        "opens": "15:30",
        "closes": "18:00"
      }
    ],
    "sameAs": [
      "https://www.livefaithministries.org"
    ]
  }
  </script>
</head>
<body>

  <!-- Serene Moving Ambient Background (Slow Ken Burns Drift & Seamless Crossfade) -->
  <div class="serene-ambient-bg" aria-hidden="true" id="serene-ambient-bg">
    <div class="ambient-slide active" style="background-image: url('assets/images/worship-hero.jpg');"></div>
    <div class="ambient-slide" style="background-image: url('assets/images/bible-bg.jpg');"></div>
    <div class="ambient-slide" style="background-image: url('assets/images/community-bg.jpg');"></div>
    <div class="ambient-slide" style="background-image: url('assets/images/worship-stage.jpg');"></div>
    <div class="ambient-slide" style="background-image: url('assets/images/giving-bg.jpg');"></div>
    <div class="ambient-overlay"></div>
  </div>

  <!-- Top Announcement Bar (Desktop & Wide Displays) -->
  <div class="topbar">
    <div class="container topbar-content">
      <div class="topbar-info">
        <span class="topbar-tag">
          <?php echo htmlspecialchars($church_motto); ?>
        </span>
        <span class="topbar-item hide-mobile">
          <svg class="icon" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
          Friday 6:00 PM &bull; Sunday 3:30 PM (E.A.T.)
        </span>
      </div>
      <div class="topbar-info right-aligned">
        <span class="topbar-item">
          <svg class="icon" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
          <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $church_phone); ?>"><?php echo htmlspecialchars($church_phone); ?></a>
        </span>
        <span class="topbar-item hide-mobile">
          <svg class="icon" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
          <a href="mailto:<?php echo htmlspecialchars($church_email); ?>"><?php echo htmlspecialchars($church_email); ?></a>
        </span>
      </div>
    </div>
  </div>

  <!-- Primary Floating Island Header -->
  <header class="navbar">
    <div class="container navbar-container">
      <a href="#home" class="brand-logo" data-tab="tab-home" aria-label="<?php echo htmlspecialchars($church_name); ?>">
        <img src="assets/images/logo.png" alt="<?php echo htmlspecialchars($church_name); ?>">
      </a>

      <!-- Right-Aligned Navigation Container -->
      <div class="nav-wrapper">
        <!-- Desktop Single-Word Tabs (Aligned Right, Zero Strokes) -->
        <ul class="desktop-nav-links">
          <li>
            <a href="#home" class="nav-tab <?php echo ($active_tab === 'tab-home') ? 'active' : ''; ?>" data-tab="tab-home">
              Home
            </a>
          </li>
          <li>
            <a href="#about" class="nav-tab <?php echo ($active_tab === 'tab-about') ? 'active' : ''; ?>" data-tab="tab-about">
              About
            </a>
          </li>
          <li>
            <a href="#faith" class="nav-tab <?php echo ($active_tab === 'tab-faith') ? 'active' : ''; ?>" data-tab="tab-faith">
              Faith
            </a>
          </li>
          <li>
            <a href="#giving" class="nav-tab <?php echo ($active_tab === 'tab-giving') ? 'active' : ''; ?>" data-tab="tab-giving">
              Giving
            </a>
          </li>
          <li>
            <a href="#watch" class="nav-tab <?php echo ($active_tab === 'tab-watch') ? 'active' : ''; ?>" data-tab="tab-watch">
              Watch
            </a>
          </li>
          <li>
            <a href="#contact" class="nav-tab <?php echo ($active_tab === 'tab-contact') ? 'active' : ''; ?>" data-tab="tab-contact">
              Contact
            </a>
          </li>
        </ul>

        <!-- Right Action Items -->
        <div class="nav-actions">
          <a href="#watch" class="nav-live-pill" data-tab-target="tab-watch">
            <span class="live-pulse-dot"></span>
            <span>Live</span>
          </a>
          <a href="#contact" class="btn btn-primary nav-cta-btn hide-on-mobile" data-tab-target="tab-contact">
            Join
          </a>
        </div>

        <!-- Mobile Right Hamburger Toggle (Accessible, Kinetic & Clean) -->
        <button class="mobile-toggle" id="mobile-toggle-btn" aria-label="Open Navigation Menu" aria-expanded="false">
          <span class="hamburger-bar bar-1"></span>
          <span class="hamburger-bar bar-2"></span>
          <span class="hamburger-bar bar-3"></span>
        </button>
      </div>
    </div>
  </header>

  <!-- Mobile Drawer Backdrop Overlay (Cleanly separated outside navbar) -->
  <div class="drawer-backdrop" id="drawer-backdrop"></div>

  <!-- Dedicated Luxury Mobile Slide Drawer (Right-Side, Zero Stacking Conflicts) -->
  <aside class="mobile-drawer" id="mobile-drawer" aria-label="Mobile Navigation Menu">
    <div class="mobile-drawer-inner">
      
      <!-- Drawer Header with Logo & Touch-Friendly Close Button -->
      <div class="mobile-drawer-header">
        <div class="drawer-brand">
          <img src="assets/images/logo.png" alt="<?php echo htmlspecialchars($church_name); ?>">
          <div class="drawer-brand-text">
            <strong><?php echo htmlspecialchars($church_short); ?></strong>
            <span class="drawer-priestly-badge">Priestly Mandate</span>
          </div>
        </div>
        <button class="mobile-drawer-close" id="mobile-drawer-close" aria-label="Close navigation menu">
          <svg class="icon" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
      </div>

      <!-- Single-Word Mobile Menu Items with Icons & Subtitles -->
      <ul class="mobile-drawer-nav">
        <li>
          <a href="#home" class="mobile-nav-item <?php echo ($active_tab === 'tab-home') ? 'active' : ''; ?>" data-tab="tab-home">
            <div class="mobile-item-icon">
              <svg class="icon" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            </div>
            <div class="mobile-item-text">
              <span class="mobile-item-title">Home</span>
              <span class="mobile-item-sub">Experience Faith, Grace &amp; Intimacy</span>
            </div>
            <span class="mobile-item-arrow">&rarr;</span>
          </a>
        </li>
        <li>
          <a href="#about" class="mobile-nav-item <?php echo ($active_tab === 'tab-about') ? 'active' : ''; ?>" data-tab="tab-about">
            <div class="mobile-item-icon">
              <svg class="icon" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="mobile-item-text">
              <span class="mobile-item-title">About</span>
              <span class="mobile-item-sub">Our Mandate, Vision &amp; 5 Values</span>
            </div>
            <span class="mobile-item-arrow">&rarr;</span>
          </a>
        </li>
        <li>
          <a href="#faith" class="mobile-nav-item <?php echo ($active_tab === 'tab-faith') ? 'active' : ''; ?>" data-tab="tab-faith">
            <div class="mobile-item-icon">
              <svg class="icon" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <div class="mobile-item-text">
              <span class="mobile-item-title">Faith</span>
              <span class="mobile-item-sub">10 Foundational Articles of Truth</span>
            </div>
            <span class="mobile-item-arrow">&rarr;</span>
          </a>
        </li>
        <li>
          <a href="#giving" class="mobile-nav-item <?php echo ($active_tab === 'tab-giving') ? 'active' : ''; ?>" data-tab="tab-giving">
            <div class="mobile-item-icon amber">
              <svg class="icon" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div class="mobile-item-text">
              <span class="mobile-item-title">Giving</span>
              <span class="mobile-item-sub">M-Pesa Stewardship &amp; Partnership</span>
            </div>
            <span class="mobile-item-arrow">&rarr;</span>
          </a>
        </li>
        <li>
          <a href="#watch" class="mobile-nav-item <?php echo ($active_tab === 'tab-watch') ? 'active' : ''; ?>" data-tab="tab-watch">
            <div class="mobile-item-icon amber">
              <svg class="icon" viewBox="0 0 24 24"><path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="mobile-item-text">
              <span class="mobile-item-title">Watch</span>
              <span class="mobile-item-sub">Live Broadcast &amp; Archive Stream</span>
            </div>
            <span class="mobile-item-arrow">&rarr;</span>
          </a>
        </li>
        <li>
          <a href="#contact" class="mobile-nav-item <?php echo ($active_tab === 'tab-contact') ? 'active' : ''; ?>" data-tab="tab-contact">
            <div class="mobile-item-icon">
              <svg class="icon" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            <div class="mobile-item-text">
              <span class="mobile-item-title">Contact</span>
              <span class="mobile-item-sub">Prayer Requests &amp; Plan a Visit</span>
            </div>
            <span class="mobile-item-arrow">&rarr;</span>
          </a>
        </li>
      </ul>

      <!-- Drawer Action Buttons -->
      <div class="mobile-drawer-actions">
        <a href="#watch" class="btn btn-primary" data-tab-target="tab-watch" style="width: 100%;">
          <span class="live-pulse-dot" style="background-color: #ffffff;"></span>
          Watch Live Stream
        </a>
        <a href="#contact" class="btn btn-secondary" data-tab-target="tab-contact" style="width: 100%;">
          Plan a Visit
        </a>
      </div>

      <!-- Quick Contact Info in Drawer -->
      <div class="mobile-drawer-contact">
        <div class="drawer-contact-item">
          <svg class="icon" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
          <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $church_phone); ?>"><?php echo htmlspecialchars($church_phone); ?></a>
        </div>
        <div class="drawer-contact-item">
          <svg class="icon" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
          <a href="mailto:<?php echo htmlspecialchars($church_email); ?>"><?php echo htmlspecialchars($church_email); ?></a>
        </div>
        <div class="drawer-times-badge">
          Friday 6:00 PM &bull; Sunday 3:30 PM (E.A.T.)
        </div>
      </div>

    </div>
  </aside>

  <!-- Mobile Floating Quick-Action Bar (Sticky Under Thumbs) -->
  <nav class="mobile-bottom-bar" aria-label="Mobile Quick Access">
    <a href="#home" class="bottom-bar-item <?php echo ($active_tab === 'tab-home') ? 'active' : ''; ?>" data-tab="tab-home">
      <svg class="icon" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
      <span>Home</span>
    </a>
    <a href="#watch" class="bottom-bar-item <?php echo ($active_tab === 'tab-watch') ? 'active' : ''; ?>" data-tab="tab-watch">
      <span class="live-pulse-dot" style="position: absolute; top: 6px; right: 22%;"></span>
      <svg class="icon" viewBox="0 0 24 24"><path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
      <span>Watch</span>
    </a>
    <a href="#giving" class="bottom-bar-item <?php echo ($active_tab === 'tab-giving') ? 'active' : ''; ?>" data-tab="tab-giving">
      <svg class="icon" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
      <span>Give</span>
    </a>
    <a href="#contact" class="bottom-bar-item <?php echo ($active_tab === 'tab-contact') ? 'active' : ''; ?>" data-tab="tab-contact">
      <svg class="icon" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
      <span>Prayer</span>
    </a>
    <button type="button" class="bottom-bar-item" id="bottom-bar-menu-btn" aria-label="Open Full Menu">
      <svg class="icon" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"></path></svg>
      <span>Menu</span>
    </button>
  </nav>
