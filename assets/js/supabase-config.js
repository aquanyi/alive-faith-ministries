/**
 * Alive Faith Ministries (AFM) - Supabase Cloud Backend Configuration
 * For Daily Devotions & Pastoral Publishing
 */

(function () {
  // Check localStorage for saved credentials first (configured via Admin Settings), otherwise use defaults
  const storedUrl = localStorage.getItem('afm_supabase_url');
  const storedKey = localStorage.getItem('afm_supabase_key');

  window.AFM_SUPABASE_CONFIG = {
    // Paste your Supabase Project URL and Anon Public Key below (or configure via admin.html settings)
    url: storedUrl || 'https://YOUR_PROJECT_ID.supabase.co',
    anonKey: storedKey || 'YOUR_SUPABASE_ANON_PUBLIC_KEY',
    storageBucket: 'devotion-images',
    tableName: 'devotions',
    isConfigured: function () {
      return (
        this.url &&
        this.anonKey &&
        !this.url.includes('YOUR_PROJECT_ID') &&
        !this.anonKey.includes('YOUR_SUPABASE_ANON')
      );
    }
  };

  // Seed devotions for immediate display even before Supabase credentials are plugged in
  window.AFM_SEED_DEVOTIONS = [
    {
      id: 'seed-devotion-01',
      title: 'Walking in the Fullness of Christ',
      slug: 'walking-in-the-fullness-of-christ',
      scripture_ref: 'Ephesians 2:10 (KJV)',
      scripture_text: 'For we are his workmanship, created in Christ Jesus unto good works, which God hath before ordained that we should walk in them.',
      cover_image: 'assets/images/worship-hero.jpg',
      content_html: `
        <p class="devotion-lead-p">The revelation of your identity in Christ is the gateway to living a life of divine purpose, authority, and unshakeable victory. You are not a spiritual afterthought; you are God's masterpiece, intricately crafted for divine greatness.</p>
        
        <h3>The Mandate of Heavenly Craftsmanship</h3>
        <p>The Greek word used for "workmanship" in Ephesians 2:10 is <em>poiēma</em>, which translates to a work of art, a poem, or a divine creation of sovereign excellence. Before you were born into this earthly realm, God had already ordained specific heavenly assignments with your name inscribed upon them.</p>
        
        <blockquote>
          "As you have therefore received Christ Jesus the Lord, so walk ye in him: Rooted and built up in him, and stablished in the faith, as ye have been taught, abounding therein with thanksgiving." &mdash; Colossians 2:6-7
        </blockquote>
        
        <h3>Three Pillars of Walking in Fullness</h3>
        <ul>
          <li><strong>Rooted in Revelation:</strong> Refuse to live by human opinion or temporal circumstances. Anchor your mind in what God has spoken in His Word.</li>
          <li><strong>Exercising Priestly Stature:</strong> You have been called out of darkness into marvelous light to minister before God with bold intercession.</li>
          <li><strong>Walking in Ordained Works:</strong> Every step you take today is backed by the resources of heaven when you align with divine purpose.</li>
        </ul>
        
        <p>As you step out into your week, remember that you are not walking toward victory; you are walking from victory. Christ has already perfected that which concerns you. Walk boldly in that reality.</p>
      `,
      prayer: 'Heavenly Father, I thank You that I am Your workmanship, created in Christ Jesus for divine excellence. Teach my heart to walk daily in the fullness of who You have called me to be. I refuse discouragement, limitation, and fear. Let Your glory radiate through my thoughts, words, and actions today, in the mighty name of Jesus Christ. Amen.',
      confession: 'I am God’s workmanship! I possess the life and nature of Christ. I am rooted and grounded in love, walking in divine authority, wisdom, and victory every single day. My steps are ordered of the Lord, and my fullness in Christ is manifest for all to see!',
      author: 'Pastoral Ministry',
      published_at: new Date().toISOString().split('T')[0],
      is_featured: true,
      category: 'Spiritual Identity'
    },
    {
      id: 'seed-devotion-02',
      title: 'The Unfailing Power of Consistent Prayer',
      slug: 'unfailing-power-of-consistent-prayer',
      scripture_ref: 'James 5:16 (AMPC)',
      scripture_text: 'The earnest (heartfelt, continued) prayer of a righteous man makes tremendous power available [dynamic in its working].',
      cover_image: 'assets/images/bible-bg.jpg',
      content_html: `
        <p class="devotion-lead-p">Prayer is not merely asking God for things; prayer is an altar of communion where the earthly vessel is charged with the heavenly life. When a believer prays with persistence and faith, heaven moves.</p>
        
        <h3>Communion Over Transaction</h3>
        <p>Religion teaches men to pray only when trouble knocks, but the priestly believer prays because intimacy with God is the very atmosphere of spiritual life. In consistent prayer, your spirit is sensitized to hear the whispers of the Holy Ghost before challenges arise.</p>
        
        <blockquote>
          "Praying always with all prayer and supplication in the Spirit, and watching thereunto with all perseverance and supplication for all saints." &mdash; Ephesians 6:18
        </blockquote>
        
        <p>Make prayer your continuous lifestyle. Whether in your quiet moments, at your workplace, or in corporate worship, keep your spiritual engine humming. Divine power is released every time you lift your voice in alignment with truth.</p>
      `,
      prayer: 'Lord God, awaken within me a fresh hunger for communion with Your Spirit. Let my prayer altar stay ablaze with the fire of Your presence. I yield my tongue and heart to be instruments of intercession and praise. Strengthen my spirit today, in Jesus’ Name.',
      confession: 'I am a person of prayer! As I pray in the Spirit, tremendous power is made available in my life, my family, and my community. I walk in divine clarity and angelic backup at all times!',
      author: 'Rev. Leadership',
      published_at: new Date(Date.now() - 86400000).toISOString().split('T')[0],
      is_featured: false,
      category: 'Prayer & Intercession'
    },
    {
      id: 'seed-devotion-03',
      title: 'Abounding Grace for Every Season',
      slug: 'abounding-grace-for-every-season',
      scripture_ref: '2 Corinthians 9:8 (KJV)',
      scripture_text: 'And God is able to make all grace abound toward you; that ye, always having all sufficiency in all things, may abound to every good work.',
      cover_image: 'assets/images/community-bg.jpg',
      content_html: `
        <p class="devotion-lead-p">Grace is not just unmerited favor; grace is the divine enablement of God that empowers a believer to accomplish that which is naturally impossible.</p>
        
        <h3>Sufficiency in All Things</h3>
        <p>Notice the absolute language of the Apostle Paul: <em>all grace</em>, <em>always</em>, <em>all sufficiency</em>, <em>in all things</em>. There is no lack in the economy of God's Kingdom. Whatever assignment or challenge lies before you, the grace of God is greater.</p>
        
        <blockquote>
          "My grace is sufficient for thee: for my strength is made perfect in weakness." &mdash; 2 Corinthians 12:9
        </blockquote>
        
        <p>Rest in His sufficiency today. Cease from anxiety and human striving. When you surrender your plans into the hands of Jesus, His supernatural grace carries you beyond your natural limitations.</p>
      `,
      prayer: 'Father, I rest upon Your abounding grace today. In areas where my strength has fallen short, I thank You that Your power is made perfect. I declare that I have all sufficiency in all things to fulfill Your will with joy and peace.',
      confession: 'God’s grace is abounding toward me! I lack no good thing. Favor surrounds me like a shield, and doors of divine opportunity are open before me today!',
      author: 'Pastoral Ministry',
      published_at: new Date(Date.now() - 172800000).toISOString().split('T')[0],
      is_featured: false,
      category: 'Grace & Faith'
    }
  ];
})();
