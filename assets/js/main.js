/**
 * Alive Faith Ministries (AFM) - World-Class JavaScript Engine
 * Live Service Countdown, Toast Engine, Scripture Switcher, Faith Filters, Giving Calculator
 */

document.addEventListener('DOMContentLoaded', function () {
  // Navigation elements
  const toggleBtn = document.getElementById('mobile-toggle-btn') || document.querySelector('.mobile-toggle');
  const bottomMenuBtn = document.getElementById('bottom-bar-menu-btn');
  const closeBtn = document.getElementById('mobile-drawer-close') || document.querySelector('.drawer-close');
  const mobileDrawer = document.getElementById('mobile-drawer') || document.querySelector('.nav-links');
  const backdrop = document.getElementById('drawer-backdrop');
  const tabPanes = document.querySelectorAll('.tab-pane');

  // Single-Word Tab Mapping
  const tabMap = {
    '#home': 'tab-home',
    '#about': 'tab-about',
    '#faith': 'tab-faith',
    '#giving': 'tab-giving',
    '#watch': 'tab-watch',
    '#contact': 'tab-contact',
    // Fallback aliases
    '#statement-of-faith': 'tab-faith',
    '#watch-services': 'tab-watch'
  };

  /* Toast notifications */
  function showToast(message, isAmber = false) {
    let container = document.querySelector('.toast-container');
    if (!container) {
      container = document.createElement('div');
      container.className = 'toast-container';
      document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.className = `toast ${isAmber ? 'toast-amber' : ''}`;
    toast.innerHTML = `
      <svg class="icon" viewBox="0 0 24 24" style="flex-shrink:0;"><path d="M5 13l4 4L19 7"></path></svg>
      <span>${message}</span>
    `;

    container.appendChild(toast);

    setTimeout(() => {
      toast.style.animation = 'toastFadeOut 0.3s ease forwards';
      setTimeout(() => {
        if (toast.parentNode) toast.parentNode.removeChild(toast);
      }, 300);
    }, 3200);
  }

  /* Navigation and mobile drawer */
  function closeDrawer() {
    if (mobileDrawer) mobileDrawer.classList.remove('open');
    if (backdrop) backdrop.classList.remove('active');
    if (toggleBtn) toggleBtn.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  }

  function openDrawer() {
    if (mobileDrawer) mobileDrawer.classList.add('open');
    if (backdrop) backdrop.classList.add('active');
    if (toggleBtn) toggleBtn.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
  }

  if (toggleBtn) {
    toggleBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      mobileDrawer && mobileDrawer.classList.contains('open') ? closeDrawer() : openDrawer();
    });
  }

  if (bottomMenuBtn) {
    bottomMenuBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      openDrawer();
    });
  }

  if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
  if (backdrop) backdrop.addEventListener('click', closeDrawer);

  // Switch Between Independent Tabs (Rock-solid, zero redundant re-renders or flickers)
  function switchTab(targetTabId, updateHash = true) {
    if (!targetTabId) return;

    const currentActivePane = document.querySelector('.tab-pane.active');
    if (currentActivePane && currentActivePane.id === targetTabId) {
      // Already active: smoothly scroll to top without re-triggering animations or flickering
      window.scrollTo({ top: 0, left: 0, behavior: 'smooth' });
      closeDrawer();
      return;
    }

    tabPanes.forEach(pane => {
      if (pane.id !== targetTabId) {
        pane.classList.remove('active');
      }
    });

    const activePane = document.getElementById(targetTabId);
    if (activePane) {
      activePane.classList.add('active');
    }

    // Update active state across desktop tabs, mobile drawer items, and floating bottom bar
    document.querySelectorAll('.nav-tab, .mobile-nav-item, .bottom-bar-item').forEach(link => {
      const match = link.getAttribute('data-tab') === targetTabId || link.getAttribute('data-tab-target') === targetTabId;
      link.classList.toggle('active', match);
    });

    if (updateHash) {
      for (const [hash, id] of Object.entries(tabMap)) {
        if (id === targetTabId) {
          history.pushState(null, '', hash);
          break;
        }
      }
    }

    window.scrollTo({ top: 0, left: 0, behavior: 'instant' });
    closeDrawer();
  }

  // Single Unified Click Delegation (Prevents duplicate handler firing & click bouncing)
  document.addEventListener('click', function (e) {
    const tabLink = e.target.closest('[data-tab], [data-tab-target], a[href^="#"]');
    if (!tabLink) return;

    // If on standalone page (no tab panes exist), navigate back to main index page
    if (tabPanes.length === 0) {
      const href = tabLink.getAttribute('href');
      const target = tabLink.getAttribute('data-tab') || tabLink.getAttribute('data-tab-target');
      if (href && href.startsWith('#')) {
        window.location.href = 'index.html' + href;
      } else if (target) {
        for (const [hash, id] of Object.entries(tabMap)) {
          if (id === target) {
            window.location.href = 'index.html' + hash;
            break;
          }
        }
      }
      return;
    }

    const targetTab = tabLink.getAttribute('data-tab') || tabLink.getAttribute('data-tab-target');
    const href = tabLink.getAttribute('href');

    if (targetTab) {
      e.preventDefault();
      switchTab(targetTab, true);
    } else if (href && tabMap[href]) {
      e.preventDefault();
      switchTab(tabMap[href], true);
    }
  });

  window.addEventListener('popstate', function () {
    const currentHash = window.location.hash || '#home';
    switchTab(tabMap[currentHash] || 'tab-home', false);
  });

  const initialHash = window.location.hash;
  const initialTabId = (initialHash && tabMap[initialHash]) ? tabMap[initialHash] : 'tab-home';
  const initialPane = document.getElementById(initialTabId);

  if (initialTabId !== 'tab-home' && initialPane) {
    // Only switch if user landed directly on a non-home tab (e.g. #about, #watch)
    switchTab(initialTabId, false);
  } else {
    // User is on Home: ensure nav links are synced without re-animating or flickering
    document.querySelectorAll('.nav-tab, .mobile-nav-item, .bottom-bar-item').forEach(link => {
      const isHome = link.getAttribute('data-tab') === 'tab-home' || link.getAttribute('data-tab-target') === 'tab-home';
      link.classList.toggle('active', isHome);
    });
  }

  /* ==========================================================================
     Real-Time Live Service Scheduling & Synchronized Broadcast Engine
     - Friday: 6:00 PM - 9:00 PM (E.A.T.)
     - Sunday: 3:30 PM - 6:30 PM (E.A.T.)
     - Automatically activates "Live" badges, pills, and the Live Broadcast Console
     - Supports testing with ?live=1 (or window.setLiveMode(true))
     ========================================================================== */

  // Check URL parameters or local storage for live simulation/override
  const urlParams = new URLSearchParams(window.location.search);
  let liveOverride = null;
  if (urlParams.get('live') === '1' || urlParams.get('live') === 'true' || urlParams.get('preview') === 'live') {
    liveOverride = true;
  } else if (urlParams.get('live') === '0' || urlParams.get('live') === 'false') {
    liveOverride = false;
  } else if (localStorage.getItem('afm_force_live') === 'true') {
    liveOverride = true;
  } else if (localStorage.getItem('afm_force_live') === 'false') {
    liveOverride = false;
  }

  // Developer / Admin console helper
  window.setLiveMode = function (enable) {
    if (enable === true) {
      localStorage.setItem('afm_force_live', 'true');
      liveOverride = true;
      showToast("🔴 Live Service Mode Activated! All live badges and consoles are now visible.", true);
    } else if (enable === false) {
      localStorage.setItem('afm_force_live', 'false');
      liveOverride = false;
      showToast("Live Service Mode Disabled. Showing countdown schedule.", false);
    } else {
      localStorage.removeItem('afm_force_live');
      liveOverride = null;
      showToast("Live Service reset to real-time clock schedule.", false);
    }
    updateCountdown();
  };

  function getNextServiceDate() {
    // If manually overridden for testing/preview
    if (liveOverride === true) {
      return { isLive: true, serviceName: "Sunday Celebration Service" };
    }

    const now = new Date();
    // Convert to East Africa Time (UTC+3)
    const eatOffset = 3 * 60; // in minutes
    const localOffset = now.getTimezoneOffset(); // in minutes
    const eatTime = new Date(now.getTime() + (eatOffset + localOffset) * 60000);

    const day = eatTime.getDay(); // 0 = Sunday, 1 = Monday, ..., 5 = Friday, 6 = Saturday
    const hour = eatTime.getHours();
    const minute = eatTime.getMinutes();

    // Check if within Live Broadcast Windows:
    // Friday: 18:00 (6:00 PM) to 21:00 (9:00 PM)
    const isFridayLive = (day === 5 && hour >= 18 && hour < 21);
    // Sunday: 15:30 (3:30 PM) to 18:30 (6:30 PM)
    const isSundayLive = (day === 0 && ((hour === 15 && minute >= 30) || (hour >= 16 && hour < 18) || (hour === 18 && minute <= 30)));

    if (liveOverride !== false && isFridayLive) {
      return { isLive: true, serviceName: "Friday Hour of Prayer & Illumination" };
    }
    if (liveOverride !== false && isSundayLive) {
      return { isLive: true, serviceName: "Sunday Celebration Service" };
    }

    // Otherwise calculate next service target date
    let target = new Date(eatTime);
    let serviceName = "";

    if (day >= 1 && day < 5) {
      // Monday to Thursday -> upcoming Friday 18:00
      target.setDate(eatTime.getDate() + (5 - day));
      target.setHours(18, 0, 0, 0);
      serviceName = "Friday Service (6:00 PM E.A.T.)";
    } else if (day === 5 && hour < 18) {
      // Friday before 18:00 -> today Friday 18:00
      target.setHours(18, 0, 0, 0);
      serviceName = "Friday Service (6:00 PM E.A.T.)";
    } else if (day === 5 && hour >= 21) {
      // Friday after 21:00 -> this Sunday 15:30
      target.setDate(eatTime.getDate() + 2);
      target.setHours(15, 30, 0, 0);
      serviceName = "Sunday Celebration (3:30 PM E.A.T.)";
    } else if (day === 6) {
      // Saturday -> tomorrow Sunday 15:30
      target.setDate(eatTime.getDate() + 1);
      target.setHours(15, 30, 0, 0);
      serviceName = "Sunday Celebration (3:30 PM E.A.T.)";
    } else if (day === 0 && (hour < 15 || (hour === 15 && minute < 30))) {
      // Sunday before 15:30 -> today Sunday 15:30
      target.setHours(15, 30, 0, 0);
      serviceName = "Sunday Celebration (3:30 PM E.A.T.)";
    } else {
      // Sunday after 18:30 -> upcoming Friday 18:00
      target.setDate(eatTime.getDate() + 5);
      target.setHours(18, 0, 0, 0);
      serviceName = "Friday Service (6:00 PM E.A.T.)";
    }

    // Convert back from EAT to local time
    const targetLocal = new Date(target.getTime() - (eatOffset + localOffset) * 60000);
    return { isLive: false, targetDate: targetLocal, serviceName: serviceName };
  }

  let previousLiveState = null;

  function updateCountdown() {
    const next = getNextServiceDate();

    // DOM Elements across Header, Home, Drawer, and Watch Screen
    const navLivePill = document.getElementById('nav-live-pill');
    const bottomBarLiveDot = document.getElementById('bottom-bar-live-dot');
    const drawerLiveDot = document.getElementById('drawer-live-pulse-dot');
    const drawerWatchLabel = document.getElementById('drawer-watch-label');

    const heroBadgeDot = document.getElementById('hero-badge-dot');
    const heroBadgeText = document.getElementById('hero-badge-text');
    const heroBadgeWrap = document.getElementById('hero-badge-wrap');
    const heroLiveDot = document.getElementById('hero-live-dot');
    const heroWatchLabel = document.getElementById('hero-watch-label');

    const countdownBanner = document.getElementById('countdown-banner');
    const countdownGrid = document.getElementById('countdown-grid');
    const countdownLiveCta = document.getElementById('countdown-live-cta');
    const cdPulseDot = document.getElementById('cd-pulse-dot');
    const statusEl = document.getElementById('cd-status-text');
    const subEl = document.getElementById('cd-sub-text');

    const daysEl = document.getElementById('cd-days');
    const hoursEl = document.getElementById('cd-hours');
    const minsEl = document.getElementById('cd-mins');
    const secsEl = document.getElementById('cd-secs');

    const watchStagePulseDot = document.getElementById('watch-stage-pulse-dot');
    const watchStageStatusLabel = document.getElementById('watch-stage-status-label');
    const streamTitleDisplay = document.getElementById('stream-title-display');
    const streamDescDisplay = document.getElementById('stream-desc-display');
    const theaterGlowTitle = document.getElementById('theater-glow-title');
    const theaterGlowSub = document.getElementById('theater-glow-sub');

    // Notify user if service just went live during their session
    if (previousLiveState === false && next.isLive === true) {
      showToast(`🔴 Alive Faith Ministries is NOW LIVE: ${next.serviceName}! Tap to watch.`, true);
    }
    previousLiveState = next.isLive;

    if (next.isLive) {
      // 1. Reveal "Live" pill in Desktop Navbar
      if (navLivePill) {
        navLivePill.style.display = 'inline-flex';
        navLivePill.classList.add('is-live');
      }

      // 2. Reveal pulse beacon on Mobile Bottom Bar
      if (bottomBarLiveDot) {
        bottomBarLiveDot.style.display = 'inline-block';
      }

      // 3. Update Mobile Drawer Watch Button
      if (drawerLiveDot) drawerLiveDot.style.display = 'inline-block';
      if (drawerWatchLabel) drawerWatchLabel.innerText = '🔴 Watch Live Stream Now';

      // 4. Update Hero Banner Badge & CTA Button
      if (heroBadgeDot) heroBadgeDot.style.display = 'inline-block';
      if (heroBadgeText) heroBadgeText.innerText = `🔴 BROADCASTING LIVE NOW • ${next.serviceName}`;
      if (heroBadgeWrap) heroBadgeWrap.classList.add('is-live');
      if (heroLiveDot) heroLiveDot.style.display = 'inline-block';
      if (heroWatchLabel) heroWatchLabel.innerText = 'Watch Live Now';

      // 5. Transform Home Countdown Banner into Live Broadcast Console
      if (countdownBanner) countdownBanner.classList.add('is-live-active');
      if (countdownGrid) countdownGrid.style.display = 'none';
      if (countdownLiveCta) countdownLiveCta.style.display = 'flex';
      if (cdPulseDot) cdPulseDot.style.display = 'inline-block';
      if (statusEl) {
        statusEl.innerHTML = `<span class="live-pulse-dot" style="margin-right: 6px; background-color: #ff3333;"></span> LIVE NOW: ${next.serviceName}`;
      }
      if (subEl) {
        subEl.innerText = 'Service is currently broadcasting live from the sanctuary! Click below to join:';
      }

      // 6. Update Watch Tab Cinema Stage Header & Details
      if (watchStagePulseDot) watchStagePulseDot.style.display = 'inline-block';
      if (watchStageStatusLabel) watchStageStatusLabel.innerText = '🔴 ON AIR: LIVE FELLOWSHIP IN PROGRESS';
      if (streamTitleDisplay) streamTitleDisplay.innerText = `🔴 Alive Faith Ministries Live: ${next.serviceName}`;
      if (streamDescDisplay) {
        streamDescDisplay.innerText = 'Join our sanctuary fellowship stream in session right now! Experience worship, fervent prayer, and revelatory teaching of the Word.';
      }
      if (theaterGlowTitle) theaterGlowTitle.innerText = '🔴 High-Definition Live Stream Active';
      if (theaterGlowSub) theaterGlowSub.innerText = 'Streaming live across Facebook Live & Digital Outlets';

    } else {
      // 1. Hide "Live" pill in Desktop Navbar when service has not arrived
      if (navLivePill) {
        navLivePill.style.display = 'none';
        navLivePill.classList.remove('is-live');
      }

      // 2. Hide pulse beacon on Mobile Bottom Bar
      if (bottomBarLiveDot) {
        bottomBarLiveDot.style.display = 'none';
      }

      // 3. Reset Mobile Drawer Watch Button
      if (drawerLiveDot) drawerLiveDot.style.display = 'none';
      if (drawerWatchLabel) drawerWatchLabel.innerText = 'Watch Services';

      // 4. Reset Hero Banner Badge & CTA Button
      if (heroBadgeDot) heroBadgeDot.style.display = 'none';
      if (heroBadgeText) heroBadgeText.innerText = 'Experience Faith, Grace & Intimacy with God';
      if (heroBadgeWrap) heroBadgeWrap.classList.remove('is-live');
      if (heroLiveDot) heroLiveDot.style.display = 'none';
      if (heroWatchLabel) heroWatchLabel.innerText = 'Watch Services';

      // 5. Restore Normal Ticking Countdown Banner
      if (countdownBanner) countdownBanner.classList.remove('is-live-active');
      if (countdownGrid) countdownGrid.style.display = '';
      if (countdownLiveCta) countdownLiveCta.style.display = 'none';
      if (cdPulseDot) cdPulseDot.style.display = 'none';
      if (statusEl) statusEl.innerText = `Next Gathering: ${next.serviceName}`;
      if (subEl) subEl.innerText = 'Real-Time Gathering Clock';

      // 6. Reset Watch Tab Cinema Stage
      if (watchStagePulseDot) watchStagePulseDot.style.display = 'none';
      if (watchStageStatusLabel) watchStageStatusLabel.innerText = 'AFM Global Broadcast Feed';
      if (streamTitleDisplay) streamTitleDisplay.innerText = 'Alive Faith Ministries Live Broadcast';
      if (streamDescDisplay) {
        streamDescDisplay.innerText = 'Join our live fellowship stream every Friday at 6:00 PM and Sunday at 3:30 PM (East Africa Time). Experience worship, fervent prayer, and revelatory teaching of the Word.';
      }
      if (theaterGlowTitle) theaterGlowTitle.innerText = 'High-Definition Broadcast Ready';
      if (theaterGlowSub) theaterGlowSub.innerText = 'Friday: 6:00 PM (E.A.T.) • Sunday: 3:30 PM (E.A.T.)';

      // Calculate Countdown Ticker Values
      if (daysEl && hoursEl && minsEl && secsEl && next.targetDate) {
        const diff = next.targetDate - new Date();
        if (diff > 0) {
          const d = Math.floor(diff / (1000 * 60 * 60 * 24));
          const h = Math.floor((diff / (1000 * 60 * 60)) % 24);
          const m = Math.floor((diff / (1000 * 60)) % 60);
          const s = Math.floor((diff / 1000) % 60);

          daysEl.innerText = d < 10 ? '0' + d : d;
          hoursEl.innerText = h < 10 ? '0' + h : h;
          minsEl.innerText = m < 10 ? '0' + m : m;
          secsEl.innerText = s < 10 ? '0' + s : s;
        } else {
          daysEl.innerText = "00";
          hoursEl.innerText = "00";
          minsEl.innerText = "00";
          secsEl.innerText = "00";
        }
      }
    }
  }

  updateCountdown();
  setInterval(updateCountdown, 1000);

  /* Scripture spotlight switcher */
  const scriptures = [
    {
      verse: "For we are his workmanship, created in Christ Jesus unto good works, which God hath before ordained that we should walk in them.",
      ref: "Ephesians 2:10",
      theme: "Divine Workmanship & Calling"
    },
    {
      verse: "Thy word is a lamp unto my feet, and a light unto my path.",
      ref: "Psalm 119:105",
      theme: "Illumination & Guidance"
    },
    {
      verse: "There is therefore now no condemnation to them which are in Christ Jesus, who walk not after the flesh, but after the Spirit.",
      ref: "Romans 8:1",
      theme: "Freedom & Grace in Christ"
    },
    {
      verse: "As ye have therefore received Christ Jesus the Lord, so walk ye in him: Rooted and built up in him, and stablished in the faith.",
      ref: "Colossians 2:6-7",
      theme: "Unshakeable Faith"
    },
    {
      verse: "And he spake a parable unto them to this end, that men ought always to pray, and not to faint.",
      ref: "Luke 18:1",
      theme: "Fervent & Persistent Prayer"
    },
    {
      verse: "Knowing that a man is not justified by the works of the law, but by the faith of Jesus Christ, even we have believed in Jesus Christ.",
      ref: "Galatians 2:16",
      theme: "Justification by Grace"
    }
  ];

  let currentScriptureIndex = 0;
  const verseTextEl = document.getElementById('spotlight-verse-text');
  const verseRefEl = document.getElementById('spotlight-verse-ref');
  const verseThemeEl = document.getElementById('spotlight-verse-theme');
  const nextVerseBtn = document.getElementById('next-scripture-btn');
  const copyVerseBtn = document.getElementById('copy-scripture-btn');

  function renderScripture(index) {
    if (!verseTextEl) return;
    verseTextEl.style.opacity = '0';
    verseTextEl.style.transform = 'translateY(6px)';

    setTimeout(() => {
      const item = scriptures[index];
      verseTextEl.innerText = `"${item.verse}"`;
      if (verseRefEl) verseRefEl.innerText = item.ref;
      if (verseThemeEl) verseThemeEl.innerText = item.theme;

      verseTextEl.style.opacity = '1';
      verseTextEl.style.transform = 'translateY(0)';
      verseTextEl.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
    }, 200);
  }

  if (nextVerseBtn) {
    nextVerseBtn.addEventListener('click', function () {
      currentScriptureIndex = (currentScriptureIndex + 1) % scriptures.length;
      renderScripture(currentScriptureIndex);
    });
  }

  if (copyVerseBtn) {
    copyVerseBtn.addEventListener('click', function () {
      const current = scriptures[currentScriptureIndex];
      const textToCopy = `"${current.verse}" (${current.ref}) Alive Faith Ministries`;
      if (navigator.clipboard) {
        navigator.clipboard.writeText(textToCopy).then(() => {
          showToast(`Copied ${current.ref} to clipboard!`, true);
        });
      }
    });
  }

  /* Statement of faith category filter */
  const filterBtns = document.querySelectorAll('.filter-btn');
  const faithCards = document.querySelectorAll('.faith-card[data-category]');

  filterBtns.forEach(btn => {
    btn.addEventListener('click', function () {
      filterBtns.forEach(b => b.classList.remove('active'));
      this.classList.add('active');

      const category = this.getAttribute('data-filter');

      faithCards.forEach(card => {
        const cardCat = card.getAttribute('data-category');
        if (category === 'all' || cardCat.includes(category)) {
          card.style.display = 'flex';
          card.style.animation = 'tabSmoothReveal 0.35s ease forwards';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });

  /* Giving purpose selector and phone copy */
  const purposePills = document.querySelectorAll('.purpose-pill');
  const refDisplay = document.getElementById('giving-ref-display');
  const copyPhoneBtn = document.getElementById('copy-phone-btn');

  purposePills.forEach(pill => {
    pill.addEventListener('click', function () {
      purposePills.forEach(p => p.classList.remove('active'));
      this.classList.add('active');

      const purposeName = this.getAttribute('data-purpose');
      if (refDisplay) {
        refDisplay.innerText = `${purposeName}: [Your Name]`;
      }
      showToast(`Selected Giving Purpose: ${purposeName}`);
    });
  });

  if (copyPhoneBtn) {
    copyPhoneBtn.addEventListener('click', function () {
      const phoneNumber = this.getAttribute('data-phone');
      if (navigator.clipboard && phoneNumber) {
        navigator.clipboard.writeText(phoneNumber).then(() => {
          showToast(`M-Pesa number ${phoneNumber} copied!`, true);
          const oldText = copyPhoneBtn.innerText;
          copyPhoneBtn.innerText = 'Copied!';
          setTimeout(() => {
            copyPhoneBtn.innerText = oldText;
          }, 2400);
        });
      }
    });
  }

  /* Watch stream channel switcher */
  const streamBtns = document.querySelectorAll('.stream-tab-btn');
  const streamTitleEl = document.getElementById('stream-title-display');
  const streamDescEl = document.getElementById('stream-desc-display');

  const streamInfo = {
    'live': {
      title: "Alive Faith Ministries Live Broadcast",
      desc: "Join our ongoing service broadcast every Friday at 6:00 PM and Sunday at 3:30 PM (East Africa Time)."
    },
    'sunday': {
      title: "Sunday Celebration Service Archive",
      desc: "Watch the latest Sunday service teaching on the Word of Grace, healing, and faith living."
    },
    'friday': {
      title: "Friday Hour of Intercession",
      desc: "Immerse yourself in corporate worship, prophetic prayers, and prevailing faith in God."
    }
  };

  streamBtns.forEach(btn => {
    btn.addEventListener('click', function () {
      streamBtns.forEach(b => b.classList.remove('active'));
      this.classList.add('active');

      const key = this.getAttribute('data-stream');
      const data = streamInfo[key];
      if (data && streamTitleEl && streamDescEl) {
        streamTitleEl.innerText = data.title;
        streamDescEl.innerText = data.desc;
        showToast(`Loaded: ${data.title}`);
      }
    });
  });

  /* Contact form intent chips */
  const formTags = document.querySelectorAll('.form-tag');
  const inquirySelect = document.getElementById('inquiry_type');
  const messageInput = document.getElementById('message');

  formTags.forEach(tag => {
    tag.addEventListener('click', function () {
      formTags.forEach(t => t.classList.remove('active'));
      this.classList.add('active');

      const val = this.getAttribute('data-val');
      if (inquirySelect) {
        for (let i = 0; i < inquirySelect.options.length; i++) {
          if (inquirySelect.options[i].value.includes(val)) {
            inquirySelect.selectedIndex = i;
            break;
          }
        }
      }

      if (messageInput && messageInput.value.trim() === '') {
        messageInput.value = `Topic: ${val}. `;
        messageInput.focus();
      }
      showToast(`Selected Topic: ${val}`);
    });
  });

  /* Interactive contact form submission with instant feedback */
  const contactForm = document.querySelector('form[action*="contact"]') || document.querySelector('.contact-form-card form');
  if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
      if (window.location.hostname.includes('vercel.app') || window.location.protocol === 'file:' || !window.location.port.includes('80')) {
        e.preventDefault();
        showToast('Thank you! Your prayer request & message have been received.');
        contactForm.reset();
      }
    });
  }

  /* Card mouse spotlight */
  function initSpotlightCards() {
    const cards = document.querySelectorAll('.spotlight-card, .pillar-card, .home-service-card, .giving-card, .quick-access-card, .faith-card, .devotion-card-pill, .action-photo-card, .community-photo-card');
    cards.forEach(card => {
      card.addEventListener('mousemove', function (e) {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        card.style.setProperty('--mouse-x', `${x}px`);
        card.style.setProperty('--mouse-y', `${y}px`);
      });
    });
  }
  initSpotlightCards();

  /* Active hero photographic background carousel with Ken Burns drift (Flicker-free crossfade) */
  const heroSlides = document.querySelectorAll('.hero-slide');
  let currentHeroSlide = 0;

  if (heroSlides.length > 1) {
    setInterval(() => {
      const prevSlide = heroSlides[currentHeroSlide];
      prevSlide.classList.remove('active');
      prevSlide.classList.add('prev');

      currentHeroSlide = (currentHeroSlide + 1) % heroSlides.length;
      const nextSlide = heroSlides[currentHeroSlide];
      nextSlide.classList.remove('prev');
      nextSlide.classList.add('active');

      setTimeout(() => {
        prevSlide.classList.remove('prev');
      }, 2300);
    }, 6500);
  }

  /* Continuous serene ambient background crossfader (Flicker-free crossfade) */
  const ambientSlides = document.querySelectorAll('.ambient-slide');
  let currentAmbientIndex = 0;

  if (ambientSlides.length > 1) {
    setInterval(() => {
      const prevAmbient = ambientSlides[currentAmbientIndex];
      prevAmbient.classList.remove('active');
      prevAmbient.classList.add('prev');

      currentAmbientIndex = (currentAmbientIndex + 1) % ambientSlides.length;
      const nextAmbient = ambientSlides[currentAmbientIndex];
      nextAmbient.classList.remove('prev');
      nextAmbient.classList.add('active');

      setTimeout(() => {
        prevAmbient.classList.remove('prev');
      }, 2700);
    }, 7500);
  }

  /* Statement of Faith real-time search */
  const faithSearchInput = document.getElementById('faith-search-input');
  const faithCountBadge = document.getElementById('faith-count-badge');
  const allFaithCards = document.querySelectorAll('.faith-card');

  if (faithSearchInput) {
    faithSearchInput.addEventListener('input', function () {
      const query = this.value.toLowerCase().trim();
      let matchCount = 0;

      allFaithCards.forEach(card => {
        const text = card.innerText.toLowerCase();
        if (text.includes(query)) {
          card.style.display = 'flex';
          card.style.animation = 'tabSmoothReveal 0.3s ease';
          matchCount++;
        } else {
          card.style.display = 'none';
        }
      });

      if (faithCountBadge) {
        faithCountBadge.innerText = query
          ? `Showing ${matchCount} matching article${matchCount === 1 ? '' : 's'}`
          : `Showing all 10 foundational articles of faith`;
      }
    });
  }

  /* Scripture proofs accordion toggle */
  document.querySelectorAll('.scripture-toggle-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      const targetId = this.getAttribute('data-target');
      const box = document.getElementById(targetId);
      if (box) {
        box.classList.toggle('show');
        const isShown = box.classList.contains('show');
        this.innerHTML = isShown
          ? `Hide Scriptures <span style="font-size:0.8rem;">&uarr;</span>`
          : `View Scriptures <span style="font-size:0.8rem;">&darr;</span>`;
      }
    });
  });

  /* Salvation prayer confirmation banner */
  const salvationConfirmBtn = document.getElementById('salvation-confirm-btn');
  const decisionBanner = document.getElementById('decision-confirmed-banner');

  if (salvationConfirmBtn) {
    salvationConfirmBtn.addEventListener('click', function () {
      if (decisionBanner) {
        decisionBanner.style.display = 'block';
        decisionBanner.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      }
      showToast('Glory to God! Welcome to the family of Christ!', true);
    });
  }

  /* Global Timezone Schedule Converter */
  const tzButtons = document.querySelectorAll('.tz-btn');
  const tzFridayTime = document.getElementById('tz-friday-time');
  const tzSundayTime = document.getElementById('tz-sunday-time');
  const tzCityLabel = document.getElementById('tz-city-label');

  const tzSchedule = {
    'eat': { city: 'Nairobi, Kenya (East Africa Time)', fri: 'Friday 6:00 PM (E.A.T.)', sun: 'Sunday 3:30 PM (E.A.T.)' },
    'bst': { city: 'London, United Kingdom (BST / GMT+1)', fri: 'Friday 4:00 PM (BST)', sun: 'Sunday 1:30 PM (BST)' },
    'est': { city: 'New York, USA (Eastern Time)', fri: 'Friday 11:00 AM (EST)', sun: 'Sunday 8:30 AM (EST)' },
    'sast': { city: 'Johannesburg, South Africa (SAST)', fri: 'Friday 5:00 PM (SAST)', sun: 'Sunday 2:30 PM (SAST)' },
    'wat': { city: 'Lagos, Nigeria (West Africa Time)', fri: 'Friday 4:00 PM (WAT)', sun: 'Sunday 1:30 PM (WAT)' }
  };

  tzButtons.forEach(btn => {
    btn.addEventListener('click', function () {
      tzButtons.forEach(b => b.classList.remove('active'));
      this.classList.add('active');

      const tzKey = this.getAttribute('data-tz');
      const data = tzSchedule[tzKey];
      if (data) {
        if (tzCityLabel) tzCityLabel.innerText = data.city;
        if (tzFridayTime) tzFridayTime.innerText = data.fri;
        if (tzSundayTime) tzSundayTime.innerText = data.sun;
        showToast(`Schedule converted to ${data.city}`);
      }
    });
  });

  /* Copy sermon outline */
  const copyNotesBtn = document.getElementById('copy-notes-btn');
  if (copyNotesBtn) {
    copyNotesBtn.addEventListener('click', function () {
      const notesContent = document.getElementById('sermon-notes-body');
      if (notesContent && navigator.clipboard) {
        navigator.clipboard.writeText(notesContent.innerText).then(() => {
          showToast('Sermon outline copied to clipboard!', true);
        });
      }
    });
  }

  /* FAQ Accordion toggle */
  document.querySelectorAll('.faq-question').forEach(btn => {
    btn.addEventListener('click', function () {
      const item = this.closest('.faq-item');
      if (item) {
        const wasOpen = item.classList.contains('open');
        document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
        if (!wasOpen) {
          item.classList.add('open');
        }
      }
    });
  });

  /* Dedicated Page Fallbacks for legacy hash bookmarks */
  const initialLegalHash = window.location.hash.toLowerCase();
  if (initialLegalHash === '#privacy') {
    window.location.href = 'privacy.html';
  } else if (initialLegalHash === '#terms') {
    window.location.href = 'terms.html';
  }

  /* Non-pinch zoom controls */

  // Block Touchscreen Pinch Zoom (touchscreen laptops and phones)
  document.addEventListener('touchstart', function (e) {
    if (e.touches && e.touches.length > 1) {
      e.preventDefault();
    }
  }, { passive: false });

  document.addEventListener('touchmove', function (e) {
    if (e.touches && e.touches.length > 1) {
      e.preventDefault();
    }
  }, { passive: false });

  // 2. Block Precision Trackpad Pinch Zoom & Ctrl+Wheel (Chrome on Windows/Mac)
  window.addEventListener('wheel', function (e) {
    if (e.ctrlKey) {
      e.preventDefault();
    }
  }, { passive: false });

  document.addEventListener('wheel', function (e) {
    if (e.ctrlKey) {
      e.preventDefault();
    }
  }, { passive: false });

  // 3. Block Keyboard Zoom-in & Zoom-out Shortcuts (Ctrl +, Ctrl -) while allowing Ctrl+0 to reset zoom
  window.addEventListener('keydown', function (e) {
    if (e.ctrlKey && (
      e.key === '+' || e.key === '-' || e.key === '=' ||
      e.keyCode === 187 || e.keyCode === 189 || e.keyCode === 107 || e.keyCode === 109
    )) {
      e.preventDefault();
    }
  }, { passive: false });

  // 4. Block WebKit Gestures (Safari / iOS)
  document.addEventListener('gesturestart', function (e) { e.preventDefault(); }, { passive: false });
  document.addEventListener('gesturechange', function (e) { e.preventDefault(); }, { passive: false });
  document.addEventListener('gestureend', function (e) { e.preventDefault(); }, { passive: false });
});
