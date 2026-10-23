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

  // Switch Between Independent Tabs
  function switchTab(targetTabId, updateHash = true) {
    if (!targetTabId) return;

    tabPanes.forEach(pane => pane.classList.remove('active'));

    const activePane = document.getElementById(targetTabId);
    if (activePane) {
      activePane.classList.add('active');
      triggerCardAnimations(activePane);
    }

    // Update active state across desktop tabs, mobile drawer items, and floating bottom bar
    document.querySelectorAll('.nav-tab, .mobile-nav-item, .bottom-bar-item').forEach(link => {
      link.classList.remove('active');
      if (link.getAttribute('data-tab') === targetTabId) {
        link.classList.add('active');
      }
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

  function triggerCardAnimations(container) {
    const cards = container.querySelectorAll(
      '.spotlight-card, .pillar-card, .home-service-card, .faith-card, .giving-card, .quick-access-card, ' +
      '.roadmap-card, .visitor-card, .contact-action-box, .giving-impact-card, .tier-card, .mpesa-step-card, ' +
      '.salvation-step-card, .faq-item, .cinema-stage-frame, .sermon-notes-card, .tz-converter-box, .pastoral-heart-card'
    );
    cards.forEach((card, index) => {
      card.style.opacity = '0';
      card.style.transform = 'translateY(22px)';
      card.style.transition = 'none';
      setTimeout(() => {
        card.style.transition = 'opacity 0.42s cubic-bezier(0.16, 1, 0.3, 1), transform 0.42s cubic-bezier(0.16, 1, 0.3, 1)';
        card.style.opacity = '1';
        card.style.transform = 'translateY(0)';
      }, 30 + Math.min(index * 35, 450));
    });
  }

  document.querySelectorAll('[data-tab]').forEach(el => {
    el.addEventListener('click', function (e) {
      e.preventDefault();
      switchTab(this.getAttribute('data-tab'), true);
    });
  });

  document.querySelectorAll('[data-tab-target]').forEach(btn => {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      switchTab(this.getAttribute('data-tab-target'), true);
    });
  });

  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    const hash = anchor.getAttribute('href');
    if (tabMap[hash]) {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        switchTab(tabMap[hash], true);
      });
    }
  });

  window.addEventListener('popstate', function () {
    const currentHash = window.location.hash || '#home';
    switchTab(tabMap[currentHash] || 'tab-home', false);
  });

  const initialHash = window.location.hash;
  const initialTabId = (initialHash && tabMap[initialHash]) ? tabMap[initialHash] : 'tab-home';
  const initialPane = document.getElementById(initialTabId);
  if (initialPane) switchTab(initialTabId, false);

  /* Live service countdown */
  function getNextServiceDate() {
    const now = new Date();
    // Convert to East Africa Time (UTC+3)
    const eatOffset = 3 * 60; // in minutes
    const localOffset = now.getTimezoneOffset(); // in minutes
    const eatTime = new Date(now.getTime() + (eatOffset + localOffset) * 60000);

    const day = eatTime.getDay(); // 0 = Sunday, 5 = Friday
    const hour = eatTime.getHours();
    const minute = eatTime.getMinutes();

    let target = new Date(eatTime);
    let serviceName = "Friday Service";

    // Friday is day 5, service at 18:00
    // Sunday is day 0, service at 15:30
    if (day < 5 || (day === 5 && (hour < 18 || (hour === 18 && minute === 0)))) {
      // Next is this Friday 18:00
      target.setDate(eatTime.getDate() + (5 - day));
      target.setHours(18, 0, 0, 0);
      serviceName = "Friday Service (6:00 PM E.A.T.)";
    } else if (day === 5 && hour >= 18 && hour < 21) {
      return { isLive: true, serviceName: "Friday Service" };
    } else if (day === 6 || (day === 0 && (hour < 15 || (hour === 15 && minute < 30)))) {
      // Next is Sunday 15:30
      const daysUntilSunday = (7 - day) % 7;
      target.setDate(eatTime.getDate() + daysUntilSunday);
      target.setHours(15, 30, 0, 0);
      serviceName = "Sunday Celebration (3:30 PM E.A.T.)";
    } else if (day === 0 && hour >= 15 && hour < 18) {
      return { isLive: true, serviceName: "Sunday Celebration Service" };
    } else {
      // Next is upcoming Friday
      const daysUntilNextFriday = (5 - day + 7) % 7 || 7;
      target.setDate(eatTime.getDate() + daysUntilNextFriday);
      target.setHours(18, 0, 0, 0);
      serviceName = "Friday Service (6:00 PM E.A.T.)";
    }

    // Convert back from EAT to local time
    const targetLocal = new Date(target.getTime() - (eatOffset + localOffset) * 60000);
    return { isLive: false, targetDate: targetLocal, serviceName: serviceName };
  }

  function updateCountdown() {
    const next = getNextServiceDate();
    const daysEl = document.getElementById('cd-days');
    const hoursEl = document.getElementById('cd-hours');
    const minsEl = document.getElementById('cd-mins');
    const secsEl = document.getElementById('cd-secs');
    const statusEl = document.getElementById('cd-status-text');

    if (!daysEl) return;

    if (next.isLive) {
      if (statusEl) statusEl.innerHTML = `<span class="live-pulse-dot" style="margin-right: 6px;"></span> LIVE NOW: ${next.serviceName}`;
      daysEl.innerText = "00";
      hoursEl.innerText = "00";
      minsEl.innerText = "00";
      secsEl.innerText = "00";
      return;
    }

    if (statusEl) statusEl.innerText = `Next Gathering: ${next.serviceName}`;

    const diff = next.targetDate - new Date();
    if (diff <= 0) return;

    const d = Math.floor(diff / (1000 * 60 * 60 * 24));
    const h = Math.floor((diff / (1000 * 60 * 60)) % 24);
    const m = Math.floor((diff / (1000 * 60)) % 60);
    const s = Math.floor((diff / 1000) % 60);

    daysEl.innerText = d < 10 ? '0' + d : d;
    hoursEl.innerText = h < 10 ? '0' + h : h;
    minsEl.innerText = m < 10 ? '0' + m : m;
    secsEl.innerText = s < 10 ? '0' + s : s;
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

  /* Active hero photographic background carousel with Ken Burns drift */
  const heroSlides = document.querySelectorAll('.hero-slide');
  let currentHeroSlide = 0;

  if (heroSlides.length > 1) {
    setInterval(() => {
      heroSlides[currentHeroSlide].classList.remove('active');
      currentHeroSlide = (currentHeroSlide + 1) % heroSlides.length;
      heroSlides[currentHeroSlide].classList.add('active');
    }, 6500);
  }

  /* Continuous serene ambient background crossfader */
  const ambientSlides = document.querySelectorAll('.ambient-slide');
  let currentAmbientIndex = 0;

  if (ambientSlides.length > 1) {
    setInterval(() => {
      ambientSlides[currentAmbientIndex].classList.remove('active');
      currentAmbientIndex = (currentAmbientIndex + 1) % ambientSlides.length;
      ambientSlides[currentAmbientIndex].classList.add('active');
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
