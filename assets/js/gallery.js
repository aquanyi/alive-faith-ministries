/**
 * Alive Faith Ministries (AFM) - Sanctuary & Leadership Gallery Engine
 * Features:
 * - Fluid Ken Burns cinematic slideshow with play/pause and swipe support
 * - Category filter system with smooth CSS transitions
 * - High-Resolution Fullscreen Lightbox Modal with keyboard & touch navigation
 */

(function () {
  'use strict';

  // Gallery dataset
  const galleryItems = [
    {
      id: 1,
      src: 'assets/images/real/pastor-couple.jpg?v=2',
      title: 'Senior Pastoral Leadership',
      role: 'Founders & Apostolic Oversight',
      category: 'presbytery',
      categoryLabel: 'Senior Pastors',
      scripture: 'Ephesians 2:10',
      desc: 'Our Senior Pastor and First Lady ministering at the golden pulpit, imparting spiritual fatherhood, apostolic vision, and sacrificial love across the ministry.',
      orientation: 'portrait'
    },
    {
      id: 2,
      src: 'assets/images/real/pastor-preaching.jpg?v=2',
      title: 'The Priestly Altar of Truth',
      role: 'Pulpit Word & Prophetic Ministry',
      category: 'pulpit',
      categoryLabel: 'Pulpit Ministry',
      scripture: '2 Timothy 4:2',
      desc: 'Proclaiming the uncompromised Word of God with revelatory depth, preparing the saints for their fullness in Christ Jesus through preaching of grace.',
      orientation: 'landscape'
    },
    {
      id: 3,
      src: 'assets/images/real/pastoral-council.jpg?v=2',
      title: 'Pastoral Oversight Council',
      role: 'Presbytery & Doctrinal Unity',
      category: 'presbytery',
      categoryLabel: 'Pastoral Council',
      scripture: 'Acts 20:28',
      desc: 'Pastoral leaders standing in prayerful unity before the flock, guarding sound doctrine, providing spiritual counsel, and steering church expansion.',
      orientation: 'landscape'
    },
    {
      id: 4,
      src: 'assets/images/real/women-ministry.jpg?v=2',
      title: 'Women of Faith Sisterhood',
      role: 'Sisterhood & Family Discipleship',
      category: 'sisterhood',
      categoryLabel: 'Women of Faith',
      scripture: 'Proverbs 31:25-30',
      desc: 'Women of Faith leadership gathering in heartfelt fellowship, prevailing intercession, maternal encouragement, and compassionate community outreach.',
      orientation: 'portrait'
    },
    {
      id: 5,
      src: 'assets/images/real/covenant-partnership.jpg?v=2',
      title: 'Covenant Handshake & Stewardship',
      role: 'Sacrifice, Partnership & Church Planting',
      category: 'stewardship',
      categoryLabel: 'Stewardship',
      scripture: 'Philippians 1:5',
      desc: 'Covenant ministers joined in hands at the official AFM golden emblem, signifying mutual commitment to kingdom stewardship and regional crusades.',
      orientation: 'portrait'
    },
    {
      id: 6,
      src: 'assets/images/real/pastor-associate.jpg?v=2',
      title: 'Associate Pastor of the Word',
      role: 'Pastoral Counseling & Discipleship',
      category: 'presbytery',
      categoryLabel: 'Associate Pastor',
      scripture: '1 Peter 5:2',
      desc: 'Faithful ministerial service dedicated to discipleship classes, personal prayer counseling, and nurturing new converts in spiritual maturity.',
      orientation: 'portrait'
    },
    {
      id: 7,
      src: 'assets/images/real/ministry-elders.jpg?v=2',
      title: 'Sanctuary Presbytery Elders',
      role: 'Congregational Care & Altar Ministry',
      category: 'presbytery',
      categoryLabel: 'Sanctuary Elders',
      scripture: 'Titus 1:5',
      desc: 'Sanctuary presbytery elders providing congregational shepherding, laying on of hands, pastoral visitation, and elder intercession for families.',
      orientation: 'landscape'
    },
    {
      id: 8,
      src: 'assets/images/real/family-couples.jpg?v=2',
      title: 'Marriage & Family Life Ministry',
      role: 'Covenant Marriages & Home Foundations',
      category: 'family',
      categoryLabel: 'Family Life',
      scripture: 'Joshua 24:15',
      desc: 'Ordained ministers cultivating Christ-centered marriages, covenant fidelity, pre-marital mentoring, and godly parenting across generations.',
      orientation: 'portrait'
    },
    {
      id: 9,
      src: 'assets/images/real/first-lady.jpg?v=2',
      title: 'First Lady & Intercessory Oversight',
      role: 'Maternal Spiritual Care & Prayer Altar',
      category: 'sisterhood',
      categoryLabel: 'Maternal Oversight',
      scripture: 'Titus 2:3-5',
      desc: 'Leading the altar of maternal intercession and pastoral counseling, cultivating virtue, spiritual depth, and unity among the daughters of faith.',
      orientation: 'portrait'
    },
    {
      id: 10,
      src: 'assets/images/real/youth-media.jpg?v=2',
      title: 'Youth & Digital Media Outreach',
      role: 'Next Gen & Global Broadcast Media',
      category: 'youth',
      categoryLabel: 'Youth & Media',
      scripture: '1 Timothy 4:12',
      desc: 'Mobilizing youth with apostolic conviction through creative digital media, livestream broadcasts, high-fidelity sound, and visual arts.',
      orientation: 'portrait'
    }
  ];

  let currentLightboxIndex = 0;
  let activeFilteredItems = [...galleryItems];
  let slideshowTimer = null;
  let currentSlideIndex = 0;

  function initGallery() {
    initSlideshow();
    initFilters();
    initLightbox();
  }

  /* ==========================================================================
     1. Cinematic Slideshow Engine (Top Showcase)
     ========================================================================== */
  function initSlideshow() {
    const slideshow = document.getElementById('gallery-slideshow');
    if (!slideshow) return;

    const slides = slideshow.querySelectorAll('.gallery-showcase-slide');
    const dots = slideshow.querySelectorAll('.gallery-showcase-dot');
    const prevBtn = document.getElementById('gallery-showcase-prev');
    const nextBtn = document.getElementById('gallery-showcase-next');
    const progressBar = document.getElementById('gallery-showcase-progress');

    if (!slides.length) return;

    function goToSlide(index) {
      slides[currentSlideIndex].classList.remove('active');
      if (dots[currentSlideIndex]) dots[currentSlideIndex].classList.remove('active');

      currentSlideIndex = (index + slides.length) % slides.length;

      slides[currentSlideIndex].classList.add('active');
      if (dots[currentSlideIndex]) dots[currentSlideIndex].classList.add('active');

      resetProgress();
    }

    function resetProgress() {
      if (!progressBar) return;
      progressBar.style.transition = 'none';
      progressBar.style.width = '0%';
      // Force reflow
      void progressBar.offsetWidth;
      progressBar.style.transition = 'width 5500ms linear';
      progressBar.style.width = '100%';
    }

    function startAutoPlay() {
      stopAutoPlay();
      resetProgress();
      slideshowTimer = setInterval(() => {
        goToSlide(currentSlideIndex + 1);
      }, 5500);
    }

    function stopAutoPlay() {
      if (slideshowTimer) {
        clearInterval(slideshowTimer);
        slideshowTimer = null;
      }
      if (progressBar) {
        const computedWidth = window.getComputedStyle(progressBar).width;
        progressBar.style.transition = 'none';
        progressBar.style.width = computedWidth;
      }
    }

    if (prevBtn) {
      prevBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        goToSlide(currentSlideIndex - 1);
        startAutoPlay();
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        goToSlide(currentSlideIndex + 1);
        startAutoPlay();
      });
    }

    dots.forEach((dot, idx) => {
      dot.addEventListener('click', (e) => {
        e.stopPropagation();
        goToSlide(idx);
        startAutoPlay();
      });
    });

    // Pause on hover
    slideshow.addEventListener('mouseenter', stopAutoPlay);
    slideshow.addEventListener('mouseleave', startAutoPlay);

    // Touch swipe support for slideshow
    let touchStartX = 0;
    let touchEndX = 0;

    slideshow.addEventListener('touchstart', (e) => {
      touchStartX = e.changedTouches[0].screenX;
      stopAutoPlay();
    }, { passive: true });

    slideshow.addEventListener('touchend', (e) => {
      touchEndX = e.changedTouches[0].screenX;
      handleSwipe();
      startAutoPlay();
    }, { passive: true });

    function handleSwipe() {
      const diff = touchEndX - touchStartX;
      if (Math.abs(diff) > 40) {
        if (diff < 0) {
          goToSlide(currentSlideIndex + 1);
        } else {
          goToSlide(currentSlideIndex - 1);
        }
      }
    }

    startAutoPlay();
  }

  /* ==========================================================================
     2. Category Filter System
     ========================================================================== */
  function initFilters() {
    const filterBtns = document.querySelectorAll('.gallery-filter-pill');
    const cards = document.querySelectorAll('.gallery-bento-card');
    const countBadge = document.getElementById('gallery-items-count');

    if (!filterBtns.length) return;

    filterBtns.forEach(btn => {
      btn.addEventListener('click', function () {
        const category = this.getAttribute('data-filter') || 'all';

        filterBtns.forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        let visibleCount = 0;
        activeFilteredItems = [];

        cards.forEach(card => {
          const cardCat = card.getAttribute('data-category');
          const itemId = parseInt(card.getAttribute('data-id'), 10);
          const isMatch = (category === 'all' || cardCat === category || (category === 'sisterhood' && (cardCat === 'sisterhood' || cardCat === 'family')));

          if (isMatch) {
            card.classList.remove('gallery-card-hidden');
            visibleCount++;
            const item = galleryItems.find(i => i.id === itemId);
            if (item) activeFilteredItems.push(item);
          } else {
            card.classList.add('gallery-card-hidden');
          }
        });

        if (countBadge) {
          countBadge.textContent = `${visibleCount} Photo${visibleCount === 1 ? '' : 's'}`;
        }
      });
    });
  }

  /* ==========================================================================
     3. High-Resolution Fullscreen Lightbox Modal
     ========================================================================== */
  function initLightbox() {
    const modal = document.getElementById('gallery-lightbox-modal');
    if (!modal) return;

    const modalImg = document.getElementById('lightbox-image');
    const titleEl = document.getElementById('lightbox-title');
    const roleEl = document.getElementById('lightbox-role');
    const scriptureEl = document.getElementById('lightbox-scripture');
    const descEl = document.getElementById('lightbox-desc');
    const catBadge = document.getElementById('lightbox-category-badge');
    const counterEl = document.getElementById('lightbox-counter');

    const closeBtn = document.getElementById('lightbox-close-btn');
    const prevBtn = document.getElementById('lightbox-prev-btn');
    const nextBtn = document.getElementById('lightbox-next-btn');

    function openLightbox(index) {
      if (index < 0 || index >= galleryItems.length) return;
      currentLightboxIndex = index;
      updateLightboxContent();

      modal.classList.add('active');
      modal.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';

      // Focus close button for accessibility
      if (closeBtn) closeBtn.focus();
    }

    function closeLightbox() {
      modal.classList.remove('active');
      modal.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
    }

    function nextPhoto() {
      currentLightboxIndex = (currentLightboxIndex + 1) % galleryItems.length;
      updateLightboxContent('next');
    }

    function prevPhoto() {
      currentLightboxIndex = (currentLightboxIndex - 1 + galleryItems.length) % galleryItems.length;
      updateLightboxContent('prev');
    }

    function updateLightboxContent(direction = 'none') {
      const item = galleryItems[currentLightboxIndex];
      if (!item) return;

      // Animate image transition smoothly
      modalImg.classList.add('image-fade-out');

      setTimeout(() => {
        modalImg.src = item.src;
        modalImg.alt = `${item.title} - Alive Faith Ministries`;

        if (titleEl) titleEl.textContent = item.title;
        if (roleEl) roleEl.textContent = item.role;
        if (scriptureEl) scriptureEl.textContent = item.scripture;
        if (descEl) descEl.textContent = item.desc;
        if (catBadge) catBadge.textContent = item.categoryLabel;
        if (counterEl) {
          const currentNum = String(currentLightboxIndex + 1).padStart(2, '0');
          const totalNum = String(galleryItems.length).padStart(2, '0');
          counterEl.textContent = `${currentNum} / ${totalNum}`;
        }

        modalImg.onload = function () {
          modalImg.classList.remove('image-fade-out');
        };
        // Fallback if cached immediately
        if (modalImg.complete) {
          modalImg.classList.remove('image-fade-out');
        }
      }, 140);
    }

    // Attach click listener to gallery cards
    document.addEventListener('click', function (e) {
      const trigger = e.target.closest('[data-lightbox-index]');
      if (trigger) {
        e.preventDefault();
        const index = parseInt(trigger.getAttribute('data-lightbox-index'), 10);
        openLightbox(index);
      }
    });

    if (closeBtn) closeBtn.addEventListener('click', closeLightbox);
    if (nextBtn) nextBtn.addEventListener('click', nextPhoto);
    if (prevBtn) prevBtn.addEventListener('click', prevPhoto);

    // Click outside image closes lightbox
    modal.addEventListener('click', (e) => {
      if (e.target === modal || e.target.classList.contains('lightbox-backdrop-target')) {
        closeLightbox();
      }
    });

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
      if (!modal.classList.contains('active')) return;

      if (e.key === 'Escape') {
        closeLightbox();
      } else if (e.key === 'ArrowRight') {
        nextPhoto();
      } else if (e.key === 'ArrowLeft') {
        prevPhoto();
      }
    });

    // Mobile touch swipe inside lightbox
    let touchStartX = 0;
    let touchEndX = 0;

    modal.addEventListener('touchstart', (e) => {
      touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    modal.addEventListener('touchend', (e) => {
      touchEndX = e.changedTouches[0].screenX;
      const diff = touchEndX - touchStartX;
      if (Math.abs(diff) > 50) {
        if (diff < 0) {
          nextPhoto();
        } else {
          prevPhoto();
        }
      }
    }, { passive: true });
  }

  // Auto-initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initGallery);
  } else {
    initGallery();
  }
})();
