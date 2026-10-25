# Design System Master File - Alive Faith Ministries

Project: Alive Faith Ministries
Design Engine: NextLevelBuilder UI/UX Pro Max Intelligence
Category: Christian Ministry, Faith & Community
Platform: Modern Web Standards (Single-Page Experience)

## Global Design Rules

### Brand Color Tokens

| Token Role | Hex Code | CSS Variable | Semantic Usage |
| :--- | :--- | :--- | :--- |
| Primary Darkest | `#071f11` | `--green-darkest` | Deep sanctuary green, primary dark headers, mobile drawer background |
| Primary Dark | `#0c331c` | `--green-dark` | Rich jade, ambient overlays, card depth |
| Primary Emerald | `#135831` | `--green-primary` | Accent buttons, active tabs, brand recognition |
| Primary Light | `#1f8249` | `--green-light` | Hover states, pill badges, success highlights |
| Surface Tint | `#eaf6ee` | `--green-tint` | Soft emerald container tint, active tag backgrounds |
| Accent Amber | `#ea6407` | `--amber-primary` | Primary action buttons, CTA badges, giving highlights |
| Accent Amber Dark | `#c54e00` | `--amber-dark` | Button active press states |
| Accent Amber Light | `#f78d38` | `--amber-light` | Highlighted scripture verse text, link hovers |
| Radiant Gold Start | `#fbbf24` | `--gold-start` | Gradient start, accessible keyboard focus rings |
| Radiant Gold End | `#ea6407` | `--gold-end` | Gradient end for buttons and icons |
| Body Background | `#f8f6f2` | `--bg-body` | Warm linen light page background |
| Card Surface | `#ffffff` | `--bg-card` | Pure white cards, form containers, elevated panels |
| Muted Surface | `#f2ece3` | `--bg-surface` | Secondary background, scripture callout cards |
| Glass Surface | `rgba(255, 255, 255, 0.88)` | `--bg-glass` | Frosted header navigation, translucent pill docks |
| Text Primary | `#121d16` | `--text-primary` | High-contrast body copy and headings (12.4:1 contrast ratio) |
| Text Muted | `#4e5e54` | `--text-muted` | Descriptive subheadings and metadata (5.8:1 contrast ratio) |

### Typography Hierarchy

- Heading Font: Playfair Display, Georgia, serif
- Body Font: Plus Jakarta Sans, -apple-system, BlinkMacSystemFont, Segoe UI, sans-serif
- Editorial Tone: Reverent spiritual warmth, crisp modern clarity, high readability across all age groups

### Accessibility & UX Intelligence (NextLevelBuilder Standards)

1. Touch Targets: Minimum 44x44px for all mobile interactive controls (buttons, tabs, chips, and dock icons).
2. Contrast Ratios: Minimum 4.5:1 for body copy and 3:1 for large display titles and non-text UI controls.
3. Accessible Focus: Visible `:focus-visible` rings styled with `3px solid var(--gold-start)` and `3px offset`.
4. Skip Link: Accessible `.skip-link` at body start allowing screen readers and keyboard users to bypass navigation.
5. Reduced Motion: Strict `@media (prefers-reduced-motion: reduce)` compliance, halting continuous Ken Burns drift and replacing long animations with instant transitions.
6. Safe Area Clearances: Native insets (`env(safe-area-inset-bottom)`) applied to fixed mobile floating navigation and bottom bars.
7. Icon Discipline: Pure vector SVGs exclusively (no emojis used as system controls or navigation icons).
