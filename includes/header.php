<?php
if (!isset($page_title)) {
    $page_title = "Live Faith Ministries | Alive Faith Ministries (AFM) - Official Portal";
}
if (!isset($active_tab)) {
    $active_tab = 'tab-home';
}
$meta_description_default = "Welcome to Live Faith Ministries (Alive Faith Ministries - AFM) at livefaithministries.org. Experience Faith, Grace and Intimacy with God. Join our Friday & Sunday worship services in Nairobi, Kenya or stream live online. Watch revelatory sermons, give voluntary offerings via M-Pesa, and submit prayer requests.";
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
  <meta name="description" content="<?php echo htmlspecialchars($meta_description_default); ?>">
  <meta name="keywords" content="Live Faith, LiveFaith, Live Faith Ministries, LiveFaithMinistries, livefaithministries.org, Alive Faith Ministries, AFM, Live Faith Church, Church Nairobi Kenya, Experience Faith Grace and Intimacy with God, Friday Service, Sunday Celebration Service, Christian Fellowship, Prayer and Teachings, M-Pesa Giving, Sermons Online, Church near me Nairobi">
  <meta name="author" content="Live Faith Ministries">
  <meta name="csrf-token" content="<?php echo htmlspecialchars(get_csrf_token()); ?>">
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
  <link rel="canonical" href="<?php echo htmlspecialchars($canonical_url ?? 'https://www.livefaithministries.org/'); ?>">
  
  <!-- Search Engine Verification (Google & Bing) -->
  <meta name="google-site-verification" content="googlee439da0fb1beeddb">
  <meta name="google-site-verification" content="e439da0fb1beeddb">
  <meta name="msvalidate.01" content="918D94204B716ABA93451065E721A619">
  
  <!-- Open Graph / Facebook / WhatsApp Meta Tags -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?php echo htmlspecialchars($canonical_url ?? 'https://www.livefaithministries.org/'); ?>">
  <meta property="og:site_name" content="Live Faith Ministries (Alive Faith Ministries)">
  <meta property="og:title" content="<?php echo htmlspecialchars($page_title); ?>">
  <meta property="og:description" content="<?php echo htmlspecialchars($meta_description_default); ?>">
  <meta property="og:image" content="https://www.livefaithministries.org/assets/images/worship-hero.jpg">
  <meta property="og:image:secure_url" content="https://www.livefaithministries.org/assets/images/worship-hero.jpg">
  <meta property="og:image:type" content="image/jpeg">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:image:alt" content="Live Faith Ministries - Church Worship and Word Gathering Nairobi">
  <meta property="og:locale" content="en_US">
  <meta property="og:locale:alternate" content="en_GB">

  <!-- Local SEO & Geographic Meta Tags (Nairobi, Kenya) -->
  <meta name="geo.region" content="KE-30">
  <meta name="geo.placename" content="Nairobi, Kenya">
  <meta name="geo.position" content="-1.319247;36.892543">
  <meta name="ICBM" content="-1.319247, 36.892543">

  <!-- Twitter / X Meta Tags -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:url" content="<?php echo htmlspecialchars($canonical_url ?? 'https://www.livefaithministries.org/'); ?>">
  <meta name="twitter:title" content="<?php echo htmlspecialchars($page_title); ?>">
  <meta name="twitter:description" content="<?php echo htmlspecialchars($meta_description_default); ?>">
  <meta name="twitter:image" content="https://www.livefaithministries.org/assets/images/worship-hero.jpg">

  <!-- Mobile Theme & PWA Manifest -->
  <meta name="theme-color" content="#071f11">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="apple-mobile-web-app-title" content="Live Faith">
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
  
  <!-- Main Stylesheet (Versioned for Instant Mobile Cache Busting) -->
  <link rel="stylesheet" href="assets/css/style.css?v=3.0">

  <!-- Enterprise Linked Schema.org Graph (Google Knowledge Graph & Sitelinks) -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@graph": [
      {
        "@type": ["Church", "PlaceOfWorship"],
        "@id": "https://www.livefaithministries.org/#church",
        "name": "Live Faith Ministries",
        "alternateName": [
          "Alive Faith Ministries",
          "AFM",
          "LiveFaith",
          "Live Faith",
          "LiveFaith Ministries",
          "LiveFaithMinistries",
          "Alive Faith Church",
          "Live Faith Church Nairobi",
          "Alive Faith Ministries Kenya"
        ],
        "url": "https://www.livefaithministries.org/",
        "logo": {
          "@type": "ImageObject",
          "@id": "https://www.livefaithministries.org/#logo",
          "url": "https://www.livefaithministries.org/assets/images/logo.png",
          "caption": "Live Faith Ministries Official Logo"
        },
        "image": {
          "@type": "ImageObject",
          "@id": "https://www.livefaithministries.org/#primaryimage",
          "url": "https://www.livefaithministries.org/assets/images/worship-hero.jpg",
          "width": 1200,
          "height": 630,
          "caption": "Live Faith Ministries Church Worship and Word Gathering Nairobi"
        },
        "description": "Live Faith Ministries (Alive Faith Ministries - AFM) is a non-denominational ministry in Nairobi, Kenya with a priestly mandate to raise believers who know and trust God for the realization of their fullness in Christ Jesus.",
        "slogan": "FAITH | SALVATION | GRACE",
        "telephone": "+254712785016",
        "email": "info@livefaithministries.org",
        "priceRange": "Free",
        "isAccessibleForFree": true,
        "publicAccess": true,
        "address": {
          "@type": "PostalAddress",
          "addressLocality": "Nairobi",
          "addressRegion": "Nairobi County",
          "addressCountry": "KE"
        },
        "geo": {
          "@type": "GeoCoordinates",
          "latitude": -1.319247,
          "longitude": 36.892543
        },
        "openingHoursSpecification": [
          {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": "Friday",
            "opens": "18:00",
            "closes": "20:30",
            "description": "Mid-Week Discipleship & Prayer Service"
          },
          {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": "Sunday",
            "opens": "15:30",
            "closes": "18:00",
            "description": "Sunday Celebration & Worship Gathering"
          }
        ],
        "sameAs": [
          "https://www.facebook.com/profile.php?id=61595832568680",
          "https://wa.me/254712785016"
        ]
      },
      {
        "@type": "WebSite",
        "@id": "https://www.livefaithministries.org/#website",
        "url": "https://www.livefaithministries.org/",
        "name": "Live Faith Ministries",
        "alternateName": [
          "LiveFaith",
          "LiveFaithMinistries",
          "Alive Faith Ministries",
          "AFM",
          "Live Faith"
        ],
        "description": "Official portal of Live Faith Ministries (Alive Faith Ministries) Nairobi Kenya - Watch Live Sermons, M-Pesa Giving, Statement of Faith, and Community Gatherings.",
        "publisher": {
          "@id": "https://www.livefaithministries.org/#church"
        },
        "inLanguage": "en-US",
        "potentialAction": {
          "@type": "SearchAction",
          "target": "https://www.livefaithministries.org/?s={search_term_string}",
          "query-input": "required name=search_term_string"
        }
      },
      {
        "@type": "ItemList",
        "@id": "https://www.livefaithministries.org/#sitelinks",
        "name": "Live Faith Ministries Key Sections",
        "itemListElement": [
          {
            "@type": "SiteNavigationElement",
            "position": 1,
            "name": "About Live Faith Ministries",
            "description": "Our mission, vision, spiritual foundation, and pastoral leadership",
            "url": "https://www.livefaithministries.org/#about"
          },
          {
            "@type": "SiteNavigationElement",
            "position": 2,
            "name": "Watch Live Services",
            "description": "Stream live worship, revelatory sermons, and listen to the sermon soundwave player",
            "url": "https://www.livefaithministries.org/#watch"
          },
          {
            "@type": "SiteNavigationElement",
            "position": 3,
            "name": "Online Giving & Tithe",
            "description": "Support the Gospel with free-will giving and covenant partnership via M-Pesa",
            "url": "https://www.livefaithministries.org/#giving"
          },
          {
            "@type": "SiteNavigationElement",
            "position": 4,
            "name": "Statement of Faith",
            "description": "The biblical doctrines and core beliefs of Alive Faith Ministries",
            "url": "https://www.livefaithministries.org/#faith"
          },
          {
            "@type": "SiteNavigationElement",
            "position": 5,
            "name": "Contact & Prayer Requests",
            "description": "Submit a prayer request, reach pastoral counseling, or get directions to the sanctuary",
            "url": "https://www.livefaithministries.org/#contact"
          }
        ]
      },
      {
        "@type": "BreadcrumbList",
        "@id": "https://www.livefaithministries.org/#breadcrumbs",
        "itemListElement": [
          {
            "@type": "ListItem",
            "position": 1,
            "name": "Home",
            "item": "https://www.livefaithministries.org/"
          },
          {
            "@type": "ListItem",
            "position": 2,
            "name": "About Us",
            "item": "https://www.livefaithministries.org/#about"
          },
          {
            "@type": "ListItem",
            "position": 3,
            "name": "Our Faith & Beliefs",
            "item": "https://www.livefaithministries.org/#faith"
          },
          {
            "@type": "ListItem",
            "position": 4,
            "name": "Online Giving",
            "item": "https://www.livefaithministries.org/#giving"
          },
          {
            "@type": "ListItem",
            "position": 5,
            "name": "Watch Live Services",
            "item": "https://www.livefaithministries.org/#watch"
          },
          {
            "@type": "ListItem",
            "position": 6,
            "name": "Contact & Prayer",
            "item": "https://www.livefaithministries.org/#contact"
          }
        ]
      },
      {
        "@type": "Event",
        "@id": "https://www.livefaithministries.org/#friday-service",
        "name": "Friday Mid-Week Word & Prayer Encounter",
        "description": "Experience deep revelatory teaching of the Word, intense intercessory prayer, and transformative fellowship every Friday evening.",
        "eventSchedule": {
          "@type": "Schedule",
          "repeatFrequency": "P1W",
          "byDay": "https://schema.org/Friday",
          "startTime": "18:00:00+03:00",
          "endTime": "20:30:00+03:00"
        },
        "eventAttendanceMode": "https://schema.org/MixedEventAttendanceMode",
        "eventStatus": "https://schema.org/EventScheduled",
        "location": {
          "@id": "https://www.livefaithministries.org/#church"
        },
        "organizer": {
          "@id": "https://www.livefaithministries.org/#church"
        },
        "isAccessibleForFree": true
      },
      {
        "@type": "Event",
        "@id": "https://www.livefaithministries.org/#sunday-service",
        "name": "Sunday Glorious Celebration Service",
        "description": "Weekly Sunday celebration service featuring vibrant high praise, deep worship, prophetic ministry, and life-changing revelation from the Scriptures.",
        "eventSchedule": {
          "@type": "Schedule",
          "repeatFrequency": "P1W",
          "byDay": "https://schema.org/Sunday",
          "startTime": "15:30:00+03:00",
          "endTime": "18:00:00+03:00"
        },
        "eventAttendanceMode": "https://schema.org/MixedEventAttendanceMode",
        "eventStatus": "https://schema.org/EventScheduled",
        "location": {
          "@id": "https://www.livefaithministries.org/#church"
        },
        "organizer": {
          "@id": "https://www.livefaithministries.org/#church"
        },
        "isAccessibleForFree": true
      }
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

  <!-- Accessible Skip to Content Link -->
  <a href="#tab-home" class="skip-link">Skip to main content</a>

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
        <a href="<?php echo htmlspecialchars($church_facebook); ?>" target="_blank" rel="noopener noreferrer" class="topbar-item" style="color: #ffffff; display: inline-flex; align-items: center; gap: 0.4rem;" aria-label="Alive Faith Ministries on Facebook" title="Follow AFM on Facebook">
          <svg class="icon" viewBox="0 0 24 24" fill="#1877F2" style="width: 15px; height: 15px;"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
          Facebook
        </a>
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
          <a href="<?php echo htmlspecialchars($church_facebook); ?>" target="_blank" rel="noopener noreferrer" class="nav-facebook-btn" aria-label="Visit AFM on Facebook" title="Follow us on Facebook">
            <svg class="icon" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
          </a>
          <!-- Dynamic Live Stream Beacon (Activated Exclusively When Gathering is Live) -->
          <a href="#watch" class="nav-live-pill" data-tab-target="tab-watch" id="nav-live-pill" style="display: none;">
            <span class="live-pulse-dot"></span>
            <span>Live Now</span>
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
        <a href="#watch" class="btn btn-primary" id="drawer-watch-live-btn" data-tab-target="tab-watch" style="width: 100%;">
          <span class="live-pulse-dot" id="drawer-live-pulse-dot" style="background-color: #ffffff; display: none;"></span>
          <span id="drawer-watch-label">Watch Services</span>
        </a>
        <a href="#contact" class="btn btn-secondary" data-tab-target="tab-contact" style="width: 100%;">
          Plan a Visit
        </a>
      </div>

      <!-- Quick Contact Info in Drawer -->
      <div class="mobile-drawer-contact">
        <div class="drawer-contact-item">
          <svg class="icon" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
          <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $church_phone); ?>">Call: <?php echo htmlspecialchars($church_phone); ?></a>
        </div>
        <div class="drawer-contact-item">
          <svg class="icon" viewBox="0 0 24 24" fill="#25D366"><path d="M12.031 2C6.496 2 2 6.496 2 12.031c0 1.97.57 3.81 1.558 5.372L2.094 22l4.75-1.442A9.97 9.97 0 0012.03 22c5.535 0 10.031-4.496 10.031-10.031S17.566 2 12.031 2zm0 18.25a8.21 8.21 0 01-4.225-1.168l-.304-.18-3.13.951.956-3.045-.198-.316A8.19 8.19 0 013.78 12.03c0-4.55 3.7-8.25 8.25-8.25 4.55 0 8.25 3.7 8.25 8.25 0 4.55-3.7 8.25-8.25 8.25zm4.516-6.19c-.248-.124-1.464-.722-1.691-.805-.227-.083-.393-.124-.558.124-.165.248-.64 1.054-.785 1.219-.145.165-.29.186-.538.062-.248-.124-1.047-.386-1.995-1.231-.738-.658-1.237-1.472-1.382-1.72-.145-.248-.015-.382.109-.505.111-.111.248-.29.372-.435.124-.145.165-.248.248-.413.083-.165.041-.31-.021-.435-.062-.124-.558-1.344-.765-1.841-.2-.484-.403-.418-.558-.426-.145-.008-.31-.01-.475-.01-.165 0-.434.062-.661.31-.227.248-.868.848-.868 2.068s.889 2.399 1.013 2.564c.124.165 1.748 2.669 4.234 3.743.592.256 1.054.409 1.414.523.595.189 1.136.162 1.564.098.477-.072 1.464-.599 1.671-1.178.207-.579.207-1.075.145-1.178-.062-.103-.227-.165-.475-.29z"/></svg>
          <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $church_phone); ?>?text=Hello%20Alive%20Faith%20Ministries,%20I%20would%20like%20to%20connect%20with%20you." target="_blank" rel="noopener noreferrer">WhatsApp Chat</a>
        </div>
        <div class="drawer-contact-item">
          <svg class="icon" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
          <a href="mailto:<?php echo htmlspecialchars($church_email); ?>"><?php echo htmlspecialchars($church_email); ?></a>
        </div>
        <div class="drawer-contact-item">
          <svg class="icon" viewBox="0 0 24 24" fill="#1877F2"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
          <a href="<?php echo htmlspecialchars($church_facebook); ?>" target="_blank" rel="noopener noreferrer">Facebook Page</a>
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
      <span class="live-pulse-dot" id="bottom-bar-live-dot" style="position: absolute; top: 6px; right: 22%; display: none;"></span>
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
