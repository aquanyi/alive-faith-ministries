/**
 * Alive Faith Ministries (AFM) - Devotion Reader Engine
 * Handles dynamic devotional loading, Supabase integration, speech synthesizer, search, and WhatsApp sharing.
 */

(function () {
  'use strict';

  let supabaseClient = null;
  let devotionsData = [];
  let currentActiveDevotion = null;
  let isSpeaking = false;
  let speechUtterance = null;

  // Initialize Supabase if library and credentials are present
  function initSupabaseClient() {
    if (window.supabase && window.AFM_SUPABASE_CONFIG && window.AFM_SUPABASE_CONFIG.isConfigured()) {
      try {
        supabaseClient = window.supabase.createClient(
          window.AFM_SUPABASE_CONFIG.url,
          window.AFM_SUPABASE_CONFIG.anonKey
        );
      } catch (err) {
        console.warn('Supabase initialization warning:', err);
      }
    }
  }

  // Load Devotions (From Supabase or fallback to seed/local data)
  async function loadDevotions() {
    initSupabaseClient();

    // Check if custom local devotions exist in localStorage
    const localSaved = localStorage.getItem('afm_local_devotions');
    let localList = [];
    if (localSaved) {
      try {
        localList = JSON.parse(localSaved);
      } catch (e) {
        localList = [];
      }
    }

    // Default to seed devotions
    const baseDevotions = window.AFM_SEED_DEVOTIONS || [];
    devotionsData = [...localList, ...baseDevotions];

    // If Supabase is active, fetch from remote database
    if (supabaseClient) {
      try {
        const { data, error } = await supabaseClient
          .from('devotions')
          .select('*')
          .order('published_at', { ascending: false });

        if (!error && data && data.length > 0) {
          devotionsData = data;
        }
      } catch (e) {
        console.info('Using local/cached devotions:', e);
      }
    }

    // Deduplicate by ID
    const uniqueMap = new Map();
    devotionsData.forEach(d => {
      if (!uniqueMap.has(d.id)) uniqueMap.set(d.id, d);
    });
    devotionsData = Array.from(uniqueMap.values());

    // Select featured or most recent devotion as active
    currentActiveDevotion = devotionsData.find(d => d.is_featured) || devotionsData[0];

    renderActiveDevotion();
    renderArchiveGrid();
  }

  // Render the currently selected devotional into the reader
  function renderActiveDevotion() {
    const readerContainer = document.getElementById('devotion-reader-content');
    if (!readerContainer || !currentActiveDevotion) return;

    const d = currentActiveDevotion;
    const formattedDate = new Date(d.published_at || Date.now()).toLocaleDateString('en-US', {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    });

    // WhatsApp share message encoding
    const shareText = `*${d.title}*\n_${d.scripture_ref}_\n\n"${d.scripture_text}"\n\nRead today's full devotion from Alive Faith Ministries:\nhttps://www.livefaithministries.org/#devotion`;
    const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(shareText)}`;

    readerContainer.innerHTML = `
      <article class="devotion-article">
        <!-- Devotional Meta Header -->
        <header class="devotion-article-header">
          <div class="devotion-meta-pills">
            <span class="devotion-pill-date">
              <svg class="icon icon-sm" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
              ${formattedDate}
            </span>
            <span class="devotion-pill-author">
              <svg class="icon icon-sm" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
              ${d.author || 'Pastoral Ministry'}
            </span>
            ${d.category ? `<span class="devotion-pill-category">${d.category}</span>` : ''}
          </div>

          <h2 class="devotion-headline">${d.title}</h2>

          <!-- Anchor Scripture Badge Box -->
          <div class="devotion-scripture-anchor">
            <div class="scripture-badge-icon">
              <svg class="icon" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <div class="scripture-badge-content">
              <span class="scripture-badge-ref">${d.scripture_ref}</span>
              <p class="scripture-badge-verse">"${d.scripture_text}"</p>
            </div>
          </div>
        </header>

        <!-- Featured Visual Banner (If available) -->
        ${d.cover_image ? `
          <div class="devotion-featured-image-wrap">
            <img src="${d.cover_image}" alt="${d.title}" class="devotion-featured-image" loading="lazy">
          </div>
        ` : ''}

        <!-- Interactive Voice Audio Bar -->
        <div class="devotion-audio-bar">
          <div class="devotion-audio-label">
            <svg class="icon" viewBox="0 0 24 24"><path d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
            <span>Listen to Today's Devotion</span>
          </div>
          <button type="button" class="btn btn-secondary devotion-listen-btn" id="devotion-listen-btn">
            <svg class="icon icon-sm" id="devotion-listen-icon" viewBox="0 0 24 24"><path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path></svg>
            <span id="devotion-listen-text">Listen</span>
          </button>
        </div>

        <!-- Devotional Body Content (Formatted HTML from Word Editor) -->
        <div class="devotion-rich-body" id="devotion-rich-body">
          ${d.content_html}
        </div>

        <!-- Daily Prayer & Prophetic Declaration Cards -->
        <div class="devotion-cards-grid">
          ${d.prayer ? `
            <div class="devotion-card prayer-card">
              <div class="devotion-card-header">
                <div class="devotion-card-icon amber">
                  <svg class="icon" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </div>
                <h4>Prayer of Agreement</h4>
              </div>
              <p class="devotion-card-text">${d.prayer}</p>
            </div>
          ` : ''}

          ${d.confession ? `
            <div class="devotion-card confession-card">
              <div class="devotion-card-header">
                <div class="devotion-card-icon emerald">
                  <svg class="icon" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h4>Prophetic Declaration</h4>
              </div>
              <p class="devotion-card-text">${d.confession}</p>
            </div>
          ` : ''}
        </div>

        <!-- Action & Share Bar -->
        <footer class="devotion-share-footer">
          <div class="devotion-share-label">Share the Revelation</div>
          <div class="devotion-share-actions">
            <a href="${whatsappUrl}" target="_blank" rel="noopener noreferrer" class="btn btn-whatsapp-share">
              <svg class="icon icon-sm" viewBox="0 0 24 24" fill="currentColor"><path d="M12.031 2C6.496 2 2 6.496 2 12.031c0 1.97.57 3.81 1.558 5.372L2.094 22l4.75-1.442A9.97 9.97 0 0012.03 22c5.535 0 10.031-4.496 10.031-10.031S17.566 2 12.031 2zm0 18.25a8.21 8.21 0 01-4.225-1.168l-.304-.18-3.13.951.956-3.045-.198-.316A8.19 8.19 0 013.78 12.03c0-4.55 3.7-8.25 8.25-8.25 4.55 0 8.25 3.7 8.25 8.25 0 4.55-3.7 8.25-8.25 8.25zm4.516-6.19c-.248-.124-1.464-.722-1.691-.805-.227-.083-.393-.124-.558.124-.165.248-.64 1.054-.785 1.219-.145.165-.29.186-.538.062-.248-.124-1.047-.386-1.995-1.231-.738-.658-1.237-1.472-1.382-1.72-.145-.248-.015-.382.109-.505.111-.111.248-.29.372-.435.124-.145.165-.248.248-.413.083-.165.041-.31-.021-.435-.062-.124-.558-1.344-.765-1.841-.2-.484-.403-.418-.558-.426-.145-.008-.31-.01-.475-.01-.165 0-.434.062-.661.31-.227.248-.868.848-.868 2.068s.889 2.399 1.013 2.564c.124.165 1.748 2.669 4.234 3.743.592.256 1.054.409 1.414.523.595.189 1.136.162 1.564.098.477-.072 1.464-.599 1.671-1.178.207-.579.207-1.075.145-1.178-.062-.103-.227-.165-.475-.29z"/></svg>
              Share on WhatsApp
            </a>
            <button type="button" class="btn btn-secondary" id="devotion-copy-btn">
              <svg class="icon icon-sm" viewBox="0 0 24 24"><path d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
              Copy Text
            </button>
          </div>
        </footer>
      </article>
    `;

    // Wire up Voice Listen Button
    const listenBtn = document.getElementById('devotion-listen-btn');
    if (listenBtn) {
      listenBtn.addEventListener('click', toggleDevotionSpeech);
    }

    // Wire up Copy Button
    const copyBtn = document.getElementById('devotion-copy-btn');
    if (copyBtn) {
      copyBtn.addEventListener('click', () => {
        const plainText = `${d.title}\n${d.scripture_ref} - "${d.scripture_text}"\n\n${d.prayer ? `Prayer: ${d.prayer}\n\n` : ''}${d.confession ? `Confession: ${d.confession}\n\n` : ''}Alive Faith Ministries: https://www.livefaithministries.org/#devotion`;
        if (navigator.clipboard) {
          navigator.clipboard.writeText(plainText).then(() => {
            if (window.showToast) {
              window.showToast('Copied Devotion to clipboard!', true);
            }
            copyBtn.innerText = 'Copied!';
            setTimeout(() => { copyBtn.innerText = 'Copy Text'; }, 2000);
          });
        }
      });
    }
  }

  // Voice Text-to-Speech Reader using Web Speech API
  function toggleDevotionSpeech() {
    if (!('speechSynthesis' in window) || !currentActiveDevotion) return;

    const synth = window.speechSynthesis;
    const listenBtn = document.getElementById('devotion-listen-btn');
    const listenText = document.getElementById('devotion-listen-text');
    const listenIcon = document.getElementById('devotion-listen-icon');

    if (isSpeaking) {
      synth.cancel();
      isSpeaking = false;
      if (listenText) listenText.innerText = 'Listen';
      if (listenIcon) listenIcon.innerHTML = '<path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>';
      return;
    }

    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = currentActiveDevotion.content_html;
    const textToSpeak = `${currentActiveDevotion.title}. ${currentActiveDevotion.scripture_ref}. ${currentActiveDevotion.scripture_text}. ${tempDiv.textContent || tempDiv.innerText}.`;

    speechUtterance = new SpeechSynthesisUtterance(textToSpeak);
    speechUtterance.rate = 0.95;
    speechUtterance.pitch = 1.0;

    speechUtterance.onend = function () {
      isSpeaking = false;
      if (listenText) listenText.innerText = 'Listen';
      if (listenIcon) listenIcon.innerHTML = '<path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>';
    };

    speechUtterance.onerror = function () {
      isSpeaking = false;
      if (listenText) listenText.innerText = 'Listen';
    };

    synth.cancel();
    synth.speak(speechUtterance);
    isSpeaking = true;
    if (listenText) listenText.innerText = 'Stop';
    if (listenIcon) listenIcon.innerHTML = '<path d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
  }

  // Render Devotional Archive Grid
  function renderArchiveGrid(filterKeyword = '') {
    const archiveGrid = document.getElementById('devotion-archive-grid');
    if (!archiveGrid) return;

    let filtered = devotionsData;
    if (filterKeyword && filterKeyword.trim() !== '') {
      const q = filterKeyword.toLowerCase().trim();
      filtered = devotionsData.filter(d =>
        (d.title && d.title.toLowerCase().includes(q)) ||
        (d.scripture_ref && d.scripture_ref.toLowerCase().includes(q)) ||
        (d.category && d.category.toLowerCase().includes(q)) ||
        (d.content_html && d.content_html.toLowerCase().includes(q))
      );
    }

    if (filtered.length === 0) {
      archiveGrid.innerHTML = `
        <div class="devotion-empty-state">
          <p>No devotions found matching "${filterKeyword}".</p>
        </div>
      `;
      return;
    }

    archiveGrid.innerHTML = filtered.map(d => {
      const formattedDate = new Date(d.published_at || Date.now()).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
      });
      const isCurrent = currentActiveDevotion && currentActiveDevotion.id === d.id;

      return `
        <div class="devotion-archive-card spotlight-card ${isCurrent ? 'active-reading' : ''}" data-devotion-id="${d.id}">
          <div class="archive-card-image" style="background-image: url('${d.cover_image || 'assets/images/bible-bg.jpg'}');">
            <span class="archive-card-date">${formattedDate}</span>
          </div>
          <div class="archive-card-body">
            <span class="archive-card-scripture">${d.scripture_ref}</span>
            <h4 class="archive-card-title">${d.title}</h4>
            <p class="archive-card-snippet">"${d.scripture_text ? d.scripture_text.slice(0, 95) + '...' : ''}"</p>
            <button type="button" class="btn btn-secondary archive-read-btn" data-id="${d.id}">
              ${isCurrent ? 'Currently Reading' : 'Read Devotion &rarr;'}
            </button>
          </div>
        </div>
      `;
    }).join('');

    // Attach click listeners to cards
    archiveGrid.querySelectorAll('.archive-read-btn, .devotion-archive-card').forEach(elem => {
      elem.addEventListener('click', function (e) {
        const id = this.getAttribute('data-devotion-id') || this.getAttribute('data-id');
        if (id) {
          const selected = devotionsData.find(d => d.id === id);
          if (selected) {
            currentActiveDevotion = selected;
            renderActiveDevotion();
            renderArchiveGrid(filterKeyword);
            // Smooth scroll to top of reader
            const readerEl = document.getElementById('devotion-reader-content');
            if (readerEl) {
              readerEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
          }
        }
      });
    });
  }

  // Search input handler
  function initSearchAndFilter() {
    const searchInput = document.getElementById('devotion-search-input');
    if (searchInput) {
      searchInput.addEventListener('input', function () {
        renderArchiveGrid(this.value);
      });
    }

    const filterChips = document.querySelectorAll('.devotion-filter-chip');
    filterChips.forEach(chip => {
      chip.addEventListener('click', function () {
        filterChips.forEach(c => c.classList.remove('active'));
        this.classList.add('active');
        const filterVal = this.getAttribute('data-filter') || '';
        renderArchiveGrid(filterVal === 'all' ? '' : filterVal);
      });
    });
  }

  // Expose global refresher
  window.AFM_DEVOTIONS = {
    load: loadDevotions,
    getActive: () => currentActiveDevotion,
    getAll: () => devotionsData
  };

  // Auto-init on DOMContentLoaded
  document.addEventListener('DOMContentLoaded', () => {
    loadDevotions();
    initSearchAndFilter();
  });
})();
